<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 31/07/18
 * Time: 11:12 AM
 */

namespace Tests;


use App\Site\SiteContainer;
use League\Container\Container;
use League\Route\RouteCollection;
use PHPUnit\Framework\TestCase;


/**
 * Class UserAuthApiViewTest
 * @package Tests
 */
class UserAuthApiViewTest extends TestCase
{
    /** @var Container */
    protected static $container = null;

    /** @var null|RouteCollection */
    public static $router = null;

    public static function setUpBeforeClass()/* The :void return type declaration that should be here would cause a BC issue */
    {
        self::$container = SiteContainer::make();

        self::$router = self::$container->get('router');

        if (!defined("BASE_DIR")) {
            define("BASE_DIR", \realpath(__DIR__ . "/../"));
        }

        if (!defined("TESTING")) {
            define("TESTING", true);
        }
    }

    public function testUserAuthUpAndRunning()
    {
        $body = [
            "username" => "admin",
            "password" => "1",
        ];

        $request = TestUtils::makeServerRequestMock('POST', '/api/user/authenticate', [], $body);
        $response = self::$router->dispatch($request, self::$container->get('response'));

        $this->assertNotNull($response);

        $responseArray = \json_decode($response->getBody(), true);
        $this->assertArrayHasKey('token', $responseArray);

    }
}