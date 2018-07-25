<?php


namespace Xervice\Api;


use Symfony\Component\HttpFoundation\Request;
use Xervice\Core\Facade\AbstractFacade;

/**
 * @method \Xervice\Api\ApiFactory getFactory()
 * @method \Xervice\Api\ApiConfig getConfig()
 * @method \Xervice\Api\ApiClient getClient()
 */
class ApiFacade extends AbstractFacade
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $dataProvider
     */
    public function apiAuth(Request $dataProvider): void
    {

    }
}