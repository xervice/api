<?php
declare(strict_types=1);

namespace Xervice\Api\Business\Plugin;

use Xervice\Core\Plugin\AbstractCommunicationPlugin;
use Xervice\Kernel\Business\Model\Service\ServiceProviderInterface;
use Xervice\Kernel\Business\Plugin\BootInterface;

/**
 * @method \Xervice\Api\Business\ApiBusinessFactory getFactory()
 */
class ApiAuthService extends AbstractCommunicationPlugin implements BootInterface
{
    /**
     * @param \Xervice\Kernel\Business\Model\Service\ServiceProviderInterface $serviceProvider
     *
     */
    public function boot(ServiceProviderInterface $serviceProvider): void
    {
        $serviceProvider->set('apiAuthenticator', $this->getFactory()->createApiAuthenticator());
    }
}