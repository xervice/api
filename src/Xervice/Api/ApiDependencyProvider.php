<?php


namespace Xervice\Api;


use Xervice\Core\Business\Model\Dependency\DependencyContainerInterface;
use Xervice\Core\Business\Model\Dependency\Provider\AbstractDependencyProvider;

class ApiDependencyProvider extends AbstractDependencyProvider
{
    public const SECURITY_FACADE = 'security.facade';

    /**
     * @param \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface $container
     *
     * @return \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface
     */
    public function handleDependencies(DependencyContainerInterface $container): DependencyContainerInterface
    {
        $container = $this->addSecurityFacade($container);

        return $container;
    }

    /**
     * @param \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface $container
     *
     * @return \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface
     */
    protected function addSecurityFacade(DependencyContainerInterface $container
    ): \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface {
        $container[self::SECURITY_FACADE] = function (DependencyContainerInterface $container) {
            return $container->getLocator()->security()->facade();
        };
        return $container;
}
}