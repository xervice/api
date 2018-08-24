<?php
declare(strict_types=1);

namespace Xervice\Api\Business;

use Xervice\Api\Business\Model\Authenticator\ApiAuthenticatorInterface;
use Xervice\Security\Business\SecurityFacade;

/**
 * @method \Xervice\Api\ApiConfig getConfig()
 */
interface ApiBusinessFactoryInterface
{
    /**
     * @return \Xervice\Api\Business\Model\Authenticator\ApiAuthenticatorInterface
     */
    public function createApiAuthenticator(): ApiAuthenticatorInterface;

    /**
     * @return \Xervice\Security\Business\SecurityFacade
     */
    public function getSecurityFacade(): SecurityFacade;
}