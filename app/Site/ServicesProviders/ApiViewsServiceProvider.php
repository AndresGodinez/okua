<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 21/05/18
 * Time: 04:40 PM
 */

namespace App\Site\ServicesProviders;


use App\Api\AlertEmailResponseApiView;
use App\Api\BaseApiView;
use App\Api\CfdiApiView;
use App\Api\CfdiEmitterApiView;
use App\Api\EmitterApiView;
use App\Api\FilterEmitterApiView;
use App\Api\FilterReceptorApiView;
use App\Api\ProcessErrorApiView;
use App\Api\ProcessWarningApiView;
use App\Api\SharedConfigApiView;
use App\Api\TestApiView;
use App\Api\UserAuthApiView;
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
        CfdiApiView::class,
        CfdiEmitterApiView::class,
        ProcessWarningApiView::class,
        ProcessErrorApiView::class,
        SharedConfigApiView::class,

        AlertEmailResponseApiView::class,
        EmitterApiView::class,
        FilterEmitterApiView::class,
        FilterReceptorApiView::class,
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
            ->add(CfdiApiView::class)
            ->withArgument('local-filesystem')
            ->withMethodCall('setEm', ['entity-manager']);

        $container
            ->add(CfdiEmitterApiView::class)
            ->withMethodCall('setEm', ['entity-manager']);

        $container
            ->add(ProcessWarningApiView::class)
            ->withMethodCall('setEm', ['entity-manager']);

        $container
            ->add(ProcessErrorApiView::class)
            ->withMethodCall('setEm', ['entity-manager']);


        $container->add(SharedConfigApiView::class)
            ->withMethodCall('setEmailServiceConfig', ['email-service-config'])
            ->withMethodCall('setSharedFilesystem', ['shared-filesystem']);

        // catalogs api services

        $container->add(AlertEmailResponseApiView::class)
            ->withMethodCall('setEm', ['entity-manager']);

        $container->add(EmitterApiView::class)
            ->withMethodCall('setEm', ['entity-manager']);

        $container->add(FilterEmitterApiView::class)
            ->withMethodCall('setEm', ['entity-manager']);

        $container->add(FilterReceptorApiView::class)
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
