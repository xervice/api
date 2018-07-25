<?php

namespace Xervice\Api\Business\Controller;

use DataProvider\ApiRequestDataProvider;
use DataProvider\ApiResponseDataProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Xervice\Api\Business\Exception\ApiException;
use Xervice\Controller\Business\Controller\AbstractController;
use Xervice\DataProvider\DataProvider\DataProviderInterface;

abstract class AbstractApiController extends AbstractController
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string $method
     * @param mixed ...$params
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Xervice\Api\Business\Exception\ApiException
     */
    public function apiAction(Request $request, string $method, ...$params): Response
    {
        $this->request = $request;

        $execMethod = $this->getValidMethod($method);

        $requestData = $this->getValidDataProvider();

        if ($requestData) {
            $apiRequest = new ApiRequestDataProvider();
            $apiRequest->fromArray($requestData);

            $result = $this->$execMethod($apiRequest->getBody(), ...$params);
        } else {
            $result = $this->$execMethod(...$params);
        }

        return $result;
    }

    /**
     * @param \Xervice\DataProvider\DataProvider\DataProviderInterface $dataProvider
     * @param int $status
     * @param array $header
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \InvalidArgumentException
     */
    public function apiResponse(DataProviderInterface $dataProvider, int $status = 200, array $header = []): Response
    {
        $apiDataProvider = new ApiResponseDataProvider();
        $apiDataProvider->setBody($dataProvider);

        return new Response(
            json_encode($apiDataProvider->toArray()),
            $status,
            $header
        );
    }

    /**
     * @param $string
     * @param bool $capitalizeFirstCharacter
     *
     * @return mixed
     */
    protected function dashesToCamelCase($string, $capitalizeFirstCharacter = false)
    {
        $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));

        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }

    /**
     * @param string $method
     *
     * @return string
     * @throws \Xervice\Api\Business\Exception\ApiException
     */
    protected function getValidMethod(string $method): string
    {
        $method = $this->dashesToCamelCase($method);
        $execMethod = $method . 'Action';

        if (!method_exists($this, $execMethod)) {
            throw new ApiException(
                sprintf(
                    'API method %s was not found',
                    $method
                )
            );
        }
        return $execMethod;
    }

    /**
     * @return null|array
     */
    protected function getValidDataProvider(): ?array
    {
        $jsonBody = $this->request->getContent();

        return json_decode($jsonBody, true);
    }

}