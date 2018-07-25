<?php

namespace Xervice\Api\Business\Authenticator;

use Symfony\Component\HttpFoundation\Request;
use Xervice\Kernel\Business\Service\ClearServiceInterface;

interface ApiAuthenticatorInterface extends ClearServiceInterface
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Xervice\Api\Business\Exception\AuthorizationException
     */
    public function authenticate(Request $request);
}