<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 21/05/18
 * Time: 04:35 PM
 */

namespace App\Site\ServicesProviders;


use App\Site\SiteRouter;
use App\Utils\EntityUtils;
use App\Utils\RequestUtils;
use Doctrine\Common\Persistence\Mapping\Driver\StaticPHPDriver;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Dotenv\Dotenv;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Config;
use League\Flysystem\Filesystem;
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
        'entity-manager',
        'emitter',
        'shared-filesystem',
        'local-filesystem',
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

        $container->add('response', Response::class);
        $container->share('request', function () {
            $parsedBody = RequestUtils::getParsedBodyFromServer($_SERVER, $_POST);

            return ServerRequestFactory::fromGlobals(
                $_SERVER, $_GET, $parsedBody, $_COOKIE, $_FILES
            );
        });

        $container->add('router', function () use ($container) {
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

        $container->share('shared-filesystem', function ($config) {
            $sharedDir = $config['OKUA_SHARED_DIR'] ?? '';
            $adapter = new Local($sharedDir);
            $filesystem = new Filesystem($adapter, new Config([
                'disable_asserts' => true,
            ]));
            return $filesystem;
        })
        ->withArgument('config');

        $container->share('local-filesystem', function () {
            $sharedDir = BASE_DIR . '/storage/local' ?? '';
            $adapter = new Local($sharedDir);
            $filesystem = new Filesystem($adapter, new Config([
                'disable_asserts' => true,
            ]));
            return $filesystem;
        });

        $container->add('entity-manager', function ($config) {
            $dbEntitiesPath = $config['DOCTRINE_ENTITIES_PATH'] ?? false;
            $driver = $config['DOCTRINE_DRIVER'] ?? 'pdo_mysql';
            $host = $config['DOCTRINE_HOST'] ?? 'localhost';
            $user = $config['DOCTRINE_USERNAME'] ?? false;
            $password = $config['DOCTRINE_PSWD'] ?? false;
            $charset = $config['DOCTRINE_CHARSET'] ?? 'utf8';

            if (\defined('TESTING') && !!TESTING) {
                if (EntityUtils::$mockedEm != null) {
                    return EntityUtils::$mockedEm;
                }

                $dbname = $config['DOCTRINE_TEST_DB'] ?? false;
            } else {
                $dbname = $config['DOCTRINE_DB'] ?? false;
            }

            if (!$dbEntitiesPath || !$driver || !$host || !$user || !$password || !$dbname) {
                throw new \Exception("Invalid configuration");
            }

            $paths = [$dbEntitiesPath];
            $isDevMode = true;

            // the connection configuration
            $dbParams = array(
                'host'   => $host,
                'driver'   => $driver,
                'user'     => $user,
                'password' => $password,
                'dbname'   => $dbname,
                'charset'   => $charset,
            );

            $driver = new StaticPHPDriver($paths);

            $config = Setup::createConfiguration($isDevMode);
            $config->setMetadataDriverImpl($driver);
            $em = EntityManager::create($dbParams, $config);

            return $em;
        })
            ->withArgument('config');

        $container->share('emitter', SapiEmitter::class);
    }
}
