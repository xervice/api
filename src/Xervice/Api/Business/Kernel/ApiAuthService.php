<?php


namespace Xervice\Api\Business\Kernel;


use Xervice\Core\Locator\AbstractWithLocator;
use Xervice\Kernel\Business\Service\BootInterface;
use Xervice\Kernel\Business\Service\ServiceProviderInterface;

/**
 * @method \Xervice\Api\ApiFacade getFacade()
 * @method \Xervice\Api\ApiFactory getFactory()
 */
class ApiAuthService extends AbstractWithLocator implements BootInterface
{
    /**
     * @param \Xervice\Kernel\Business\Service\ServiceProviderInterface $serviceProvider
     *
     * @throws \Core\Locator\Dynamic\ServiceNotParseable
     */
    public function boot(ServiceProviderInterface $serviceProvider): void
    {
        $serviceProvider->set('apiAuthenticator', $this->getFactory()->createApiAuthenticator());
    }
}