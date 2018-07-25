<?php

namespace Xervice\Api\Business\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Xervice\Api\ApiFacade;
use Xervice\Api\Business\Authenticator\ApiAuthenticatorInterface;

abstract class AbstractSecureApiController extends AbstractApiController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string $method
     * @param mixed ...$params
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Xervice\Api\Business\Exception\ApiException
     * @throws \Xervice\Api\Business\Exception\AuthorizationException
     */
    public function apiAction(Request $request, string $method, ...$params): Response
    {
        $this->authorize($request);

        return parent::apiAction($request, $method, ...$params);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Xervice\Api\Business\Exception\AuthorizationException
     */
    protected function authorize(Request $request): void
    {
        $this->getAuthenticator()->authenticate($request);
    }

    /**
     * @return \Xervice\Api\Business\Authenticator\ApiAuthenticatorInterface
     */
    private function getAuthenticator(): ApiAuthenticatorInterface
    {
        return $this->getService('apiAuthenticator');
    }
}