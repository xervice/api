<?php


namespace XerviceTest\Api\Controller;


use DataProvider\TestDataProvider;
use Symfony\Component\HttpFoundation\Response;
use Xervice\Api\Communication\Controller\AbstractSecureApiController;

class TestSecureController extends AbstractSecureApiController
{
    /**
     * @param \DataProvider\TestDataProvider $dataProvider
     * @param string $name
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myRequestAction(TestDataProvider $dataProvider): Response
    {
        $dataProvider->setValue(
            'test'
        );

        return $this->apiResponse($dataProvider);
    }
}