<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 31/07/18
 * Time: 11:12 AM
 */

namespace Tests\Api;


use App\Exceptions\ValidationException;
use App\Site\SiteContainer;
use League\Container\Container;
use League\Route\RouteCollection;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;


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

        TestUtils::initConsts();
    }

    protected function setUp()
    {
        self::$router = self::$container->get('router');
    }

    protected function tearDown()
    {
        self::$router = null;
    }

    public function testUserAuthUpAndRunning()
    {
        $this->expectException(ValidationException::class);

        $request = TestUtils::makeServerRequestMock('POST', '/api/user/authenticate');
        $response = self::$router->dispatch($request, self::$container->get('response'));
    }

    public function testAuthUserValidJwtResponse()
    {
        // todo: mock response for citzou api

        $body = [
            "username" => "test",
            "password" => "test",
        ];

        $request = TestUtils::makeServerRequestMock('POST', '/api/user/authenticate', [], $body);
        $response = self::$router->dispatch($request, self::$container->get('response'));

        $this->assertNotNull($response);

        $responseArray = \json_decode($response->getBody(), true);
        $this->assertArrayHasKey('token', $responseArray);


        $re = '/^([a-zA-Z0-9_=]+)\.([a-zA-Z0-9_=]+)\.([a-zA-Z0-9_\-\+\/=]*)$/m';
        $token = $responseArray['token'];

        $this->assertRegExp($re, $token);
    }
}