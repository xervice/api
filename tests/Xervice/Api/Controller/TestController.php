<?php


namespace XerviceTest\Api\Controller;


use DataProvider\TestDataProvider;
use Symfony\Component\HttpFoundation\Response;
use Xervice\Api\Business\Controller\AbstractApiController;

class TestController extends AbstractApiController
{
    /**
     * @param \DataProvider\TestDataProvider $dataProvider
     * @param string $name
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Xervice\Api\Exception\ApiException
     */
    public function myRequestAction(TestDataProvider $dataProvider, string $name): Response
    {
        $dataProvider->setValue(
            $dataProvider->getValue() . $name
        );

        return $this->apiResponse($dataProvider);
    }
}