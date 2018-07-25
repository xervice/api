<?php
namespace XerviceTest\Api;

use DataProvider\ApiRequestDataProvider;
use DataProvider\ApiResponseDataProvider;
use DataProvider\TestDataProvider;
use Symfony\Component\HttpFoundation\Request;
use Xervice\Config\XerviceConfig;
use Xervice\Controller\Business\Provider\KernelBridge;
use Xervice\Core\Locator\Dynamic\DynamicLocator;
use Xervice\Core\Locator\Locator;
use Xervice\DataProvider\DataProviderConfig;
use Xervice\DataProvider\DataProviderFacade;
use XerviceTest\Api\Controller\TestController;
use XerviceTest\Api\Controller\TestSecureController;

/**
 * @method \Xervice\Api\ApiFactory getFactory()
 */
class IntegrationTest extends \Codeception\Test\Unit
{
    use DynamicLocator;

    protected function _before()
    {
        XerviceConfig::getInstance()->getConfig()->set(DataProviderConfig::FILE_PATTERN, '*.dataprovider.xml');
        $this->getDataProviderFacade()->generateDataProvider();
        XerviceConfig::getInstance()->getConfig()->set(DataProviderConfig::FILE_PATTERN, '*.testprovider.xml');
        $this->getDataProviderFacade()->generateDataProvider();
    }

    protected function _after()
    {
//        $this->getDataProviderFacade()->cleanDataProvider();
    }

    /**
     * @group Xervice
     * @group Api
     * @group Integration
     */
    public function testApiController()
    {
        $controller = new TestController();

        $request = new Request(
            [],
            [],
            [],
            [],
            [],
            [],
            $this->getTestJsonBody()
        );

        $params = [
            'addition'
        ];

        $response = $controller->apiAction($request, 'myRequest', ...$params);

        $responseData = new ApiResponseDataProvider();
        $responseData->fromArray(
            json_decode($response->getContent(), true)
        );

        $this->assertEquals(
            'exampleaddition',
            $responseData->getBody()->getValue()
        );
    }

    /**
     * @group Xervice
     * @group Api
     * @group Integration
     *
     * @expectedException \Xervice\Api\Business\Exception\AuthorizationException
     * @expectedExceptionMessage No HTTP_Authorization header found
     */
    public function testSecureApiControllerWithoutHeader()
    {
        $kernBride = $this
            ->getMockBuilder(KernelBridge::class)
            ->setMethods(['getService'])
            ->disableOriginalConstructor()
            ->getMock();

        $kernBride
            ->expects($this->once())
            ->method('getService')
            ->with(
                $this->equalTo('apiAuthenticator')
            )
            ->willReturn(
                $this->getFactory()->createApiAuthenticator()
            );

        $request = new Request(
            [],
            [],
            [],
            [],
            [],
            [],
            $this->getTestJsonBody()
        );

        $controller = new TestSecureController();
        $controller->setKernel($kernBride);
        $controller->apiAction($request, 'myRequest');
    }

    /**
     * @group Xervice
     * @group Api
     * @group Integration
     *
     * @expectedException \Xervice\Api\Business\Exception\AuthorizationException
     * @expectedExceptionMessage Wrong structure for HTTP_Authorization header test
     */
    public function testSecureApiControllerWithWrongHeader()
    {
        $kernBride = $this
            ->getMockBuilder(KernelBridge::class)
            ->setMethods(['getService'])
            ->disableOriginalConstructor()
            ->getMock();

        $kernBride
            ->expects($this->once())
            ->method('getService')
            ->with(
                $this->equalTo('apiAuthenticator')
            )
            ->willReturn(
                $this->getFactory()->createApiAuthenticator()
            );

        $request = new Request(
            [],
            [],
            [],
            [],
            [],
            [
                'HTTP_Authorization' => 'test'
            ],
            $this->getTestJsonBody()
        );

        $controller = new TestSecureController();
        $controller->setKernel($kernBride);
        $controller->apiAction($request, 'myRequest');
    }

    /**
     * @group Xervice
     * @group Api
     * @group Integration
     *
     * @expectedException \Xervice\Api\Business\Exception\AuthorizationException
     * @expectedExceptionMessage Authenticator Token does not exist
     */
    public function testSecureApiControllerWithHeader()
    {
        $kernBride = $this
            ->getMockBuilder(KernelBridge::class)
            ->setMethods(['getService'])
            ->disableOriginalConstructor()
            ->getMock();

        $kernBride
            ->expects($this->once())
            ->method('getService')
            ->with(
                $this->equalTo('apiAuthenticator')
            )
            ->willReturn(
                $this->getFactory()->createApiAuthenticator()
            );

        $request = new Request(
            [],
            [],
            [],
            [],
            [],
            [
                'HTTP_Authorization' => 'Token myToken'
            ],
            $this->getTestJsonBody()
        );


        $controller = new TestSecureController();
        $controller->setKernel($kernBride);
        $controller->apiAction($request, 'myRequest');
    }

    /**
     * @return \Xervice\DataProvider\DataProviderFacade
     */
    private function getDataProviderFacade(): DataProviderFacade
    {
        return Locator::getInstance()->dataProvider()->facade();
    }

    /**
     * @return string
     */
    public function getTestJsonBody(): string
    {
        $test = new TestDataProvider();
        $test->setValue('example');

        $apiRequest = new ApiRequestDataProvider();
        $apiRequest->setBody($test);

        return json_encode($apiRequest->toArray());
    }
}