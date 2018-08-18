<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 18/08/18
 * Time: 01:28 PM
 */


namespace App\Site\ServicesProviders;


use App\Views\BaseView;
use App\Views\ProvidersHomeView;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

/**
 * Class ModuleProvidersServiceProvider
 * @package App\Site\ServicesProviders
 */
class ModuleProvidersServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    /**
     * @var array
     */
    protected $provides = [
        ProvidersHomeView::class,
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->add(ProvidersHomeView::class);
    }

    /**
     * Method will be invoked on registration of a service provider implementing
     * this interface. Provides ability for eager loading of Service Providers.
     *
     * @return void
     */
    public function boot()
    {
        $this->getContainer()->inflector(BaseView::class)
            ->invokeMethod('setConfig', ['config'])
            ->invokeMethod('setTemplates', ['templates']);
    }
}
