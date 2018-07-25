<?php


namespace Xervice\Api;


use Xervice\Api\Business\Authenticator\ApiAuthenticator;
use Xervice\Api\Business\Authenticator\ApiAuthenticatorInterface;
use Xervice\Core\Factory\AbstractFactory;
use Xervice\Security\SecurityFacade;

/**
 * @method \Xervice\Api\ApiConfig getConfig()
 */
class ApiFactory extends AbstractFactory
{
    /**
     * @return \Xervice\Api\Business\Authenticator\ApiAuthenticatorInterface
     */
    public function createApiAuthenticator(): ApiAuthenticatorInterface
    {
        return new ApiAuthenticator(
            $this->getSecurityFacade()
        );
    }

    /**
     * @return \Xervice\Security\SecurityFacade
     */
    public function getSecurityFacade(): SecurityFacade
    {
        return $this->getDependency(ApiDependencyProvider::SECURITY_FACADE);
    }
}