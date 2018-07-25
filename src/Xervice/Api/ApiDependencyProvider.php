<?php


namespace Xervice\Api;


use Xervice\Core\Dependency\DependencyProviderInterface;
use Xervice\Core\Dependency\Provider\AbstractProvider;

/**
 * @method \Xervice\Core\Locator\Locator getLocator()
 */
class ApiDependencyProvider extends AbstractProvider
{
    public const SECURITY_FACADE = 'security.facade';

    /**
     * @param \Xervice\Core\Dependency\DependencyProviderInterface $dependencyProvider
     */
    public function handleDependencies(DependencyProviderInterface $dependencyProvider): void
    {
        $dependencyProvider[self::SECURITY_FACADE] = function (DependencyProviderInterface $dependencyProvider) {
            return $dependencyProvider->getLocator()->security()->facade();
        };
    }
}