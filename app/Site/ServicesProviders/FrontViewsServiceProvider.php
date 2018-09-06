<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 21/05/18
 * Time: 04:41 PM
 */

namespace App\Site\ServicesProviders;


use App\Views\AdminConfigEmailServiceView;
use App\Views\BaseView;
use App\Views\BillsView;
use App\Views\HomeView;
use App\Views\LoginView;
use App\Views\WarningView;
use App\Views\ErrorView;
use App\Views\MovementsLogView;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

/**
 * Class FrontViewsServiceProvider
 * @package App\Site\ServicesProviders
 */
class FrontViewsServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    /**
     * @var array
     */
    protected $provides = [
        LoginView::class,
        HomeView::class,
        BillsView::class,
        MovementsLogView::class,
        WarningView::class,
        ErrorView::class,

        AdminConfigEmailServiceView::class,
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

        $container->add(LoginView::class);
        $container->add(HomeView::class);
        $container->add(BillsView::class);
        $container->add(MovementsLogView::class);
        $container->add(WarningView::class);
        $container->add(ErrorView::class);

        $container->add(AdminConfigEmailServiceView::class);
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
