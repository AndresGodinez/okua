<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 21/05/18
 * Time: 04:35 PM
 */

namespace App\Site\ServicesProviders;


use App\Factories\ConnectionFactory;
use App\Site\SiteRouter;
use App\Utils\RequestUtils;
use Dotenv\Dotenv;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Plates\Engine;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

/**
 * Class BaseServiceProvider
 * @package App\Site\ServicesProviders
 */
class BaseServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        'response',
        'request',
        'router',
        'templates',
        'config',
        'connection-factory',
        'emitter',
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

        $container->share('response', Response::class);
        $container->share('request', function () {
            $parsedBody = RequestUtils::getParsedBodyFromServer($_SERVER, $_POST);

            return ServerRequestFactory::fromGlobals(
                $_SERVER, $_GET, $parsedBody, $_COOKIE, $_FILES
            );
        });

        $container->share('router', function () use ($container) {
            $invokable = new SiteRouter;
            if (!($container instanceof Container)) throw new \Exception("Invalid container interface");
            return $invokable($container);
        });

        $container->share('templates', function () {
            return new Engine(BASE_DIR . '/resources/views');
        });

        $container->share('config', function () {
            $dotenv = new Dotenv(BASE_DIR);
            $dotenv->load();
            $config = $_ENV;
            return $config;
        });

        $container->share('connection-factory', function ($config) {
            return new ConnectionFactory($config);
        })->withArgument('config');

        $container->share('emitter', SapiEmitter::class);
    }
}
