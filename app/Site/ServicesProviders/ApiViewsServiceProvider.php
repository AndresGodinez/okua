<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 21/05/18
 * Time: 04:40 PM
 */

namespace App\Site\ServicesProviders;


use App\Api\BaseApiView;
use App\Api\BillInfoApiView;
use App\Api\BillInfoClientApiView;
use App\Api\TestApiView;
use App\Api\UserAuthApiView;
use App\Api\ProcessWarningApiView;
use App\Api\ProcessErrorApiView;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

/**
 * Class ApiViewsServiceProvider
 * @package App\Site\ServicesProviders
 */
class ApiViewsServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    /**
     * @var array
     */
    protected $provides = [
        TestApiView::class,
        UserAuthApiView::class,
        BillInfoApiView::class,
        BillInfoClientApiView::class,
        ProcessWarningApiView::class,
        ProcessErrorApiView::class,
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

        $container->add(TestApiView::class);
        $container->add(UserAuthApiView::class);

        $container
            ->add(BillInfoApiView::class)
            ->withMethodCall('setEm', ['entity-manager']);

        $container
            ->add(BillInfoClientApiView::class)
            ->withMethodCall('setEm', ['entity-manager']);

        $container
            ->add(ProcessWarningApiView::class)
            ->withMethodCall('setEm', ['entity-manager']);

        $container
            ->add(ProcessErrorApiView::class)
            ->withMethodCall('setEm', ['entity-manager']);
    }

    /**
     * Method will be invoked on registration of a service provider implementing
     * this interface. Provides ability for eager loading of Service Providers.
     *
     * @return void
     */
    public function boot()
    {
        $this->getContainer()->inflector(BaseApiView::class)
            ->invokeMethod('setConfig', ['config']);
    }
}
