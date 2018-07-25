<?php


namespace XerviceTest\Api\Controller;


use DataProvider\TestDataProvider;
use Symfony\Component\HttpFoundation\Response;
use Xervice\Api\Business\Controller\AbstractApiController;
use Xervice\Api\Business\Controller\AbstractSecureApiController;

class TestSecureController extends AbstractSecureApiController
{
    /**
     * @param \DataProvider\TestDataProvider $dataProvider
     * @param string $name
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Xervice\Api\Exception\ApiException
     */
    public function myRequestAction(TestDataProvider $dataProvider): Response
    {
        $dataProvider->setValue(
            'test'
        );

        return $this->apiResponse($dataProvider);
    }
}