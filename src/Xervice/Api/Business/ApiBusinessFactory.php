<?php
declare(strict_types=1);

namespace Xervice\Api\Business;


use Xervice\Api\ApiDependencyProvider;
use Xervice\Api\Business\Model\Authenticator\ApiAuthenticator;
use Xervice\Api\Business\Model\Authenticator\ApiAuthenticatorInterface;
use Xervice\Core\Business\Model\Factory\AbstractBusinessFactory;
use Xervice\Security\Business\SecurityFacade;

/**
 * @method \Xervice\Api\ApiConfig getConfig()
 */
class ApiBusinessFactory extends AbstractBusinessFactory implements ApiBusinessFactoryInterface
{
    /**
     * @return \Xervice\Api\Business\Model\Authenticator\ApiAuthenticatorInterface
     */
    public function createApiAuthenticator(): ApiAuthenticatorInterface
    {
        return new ApiAuthenticator(
            $this->getSecurityFacade()
        );
    }

    /**
     * @return \Xervice\Security\Business\SecurityFacade
     */
    public function getSecurityFacade(): SecurityFacade
    {
        return $this->getDependency(ApiDependencyProvider::SECURITY_FACADE);
    }
}