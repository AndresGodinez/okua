<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 13/04/18
 * Time: 12:08 PM
 */

namespace App\Site;

use App\Site\ServicesProviders\ApiViewsServiceProvider;
use App\Site\ServicesProviders\BaseServiceProvider;
use App\Site\ServicesProviders\FrontViewsServiceProvider;
use App\Site\ServicesProviders\ModelsServiceProvider;
use App\Site\ServicesProviders\ModuleProvidersServiceProvider;
use League\Container\Container;

/**
 * Class SiteContainer
 * @package App\Site
 */
class SiteContainer
{
    /**
     * @return Container
     */
    public static function make()
    {
        $container = new Container();

        # base provider (share utils)
        $container->addServiceProvider(new BaseServiceProvider);

        # SECTION: adding site front-end views containers
        $container->addServiceProvider(new FrontViewsServiceProvider);

        # SECTION: adding site API back-end views containers
        $container->addServiceProvider(new ApiViewsServiceProvider);

        # SECTION: models
        $container->addServiceProvider(new ModelsServiceProvider);

        # SECTION: modules
        $container->addServiceProvider(new ModuleProvidersServiceProvider);

        return $container;
    }

}
