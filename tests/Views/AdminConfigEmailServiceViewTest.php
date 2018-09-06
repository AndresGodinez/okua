<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 5/09/18
 * Time: 03:39 PM
 */

namespace Views;


use App\Exceptions\ViewInvalidSessionException;
use App\Site\SiteContainer;
use League\Container\Container;
use League\Route\RouteCollection;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;


/**
 * Class AdminConfigEmailServiceViewTest
 * @package Views
 */
class AdminConfigEmailServiceViewTest extends TestCase
{
    /** @var Container */
    protected static $container = null;

    /** @var null|RouteCollection */
    public static $router = null;

    public static function setUpBeforeClass()
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

    public function testIndexRouteUpAndRunning()
    {
        $this->expectException(ViewInvalidSessionException::class);

        $request = TestUtils::makeServerRequestMock('GET', '/admin/config/email-service');
        self::$router->dispatch($request, self::$container->get('response'));
    }

    public function testIndexLoadsSuccessfully()
    {
        $_SESSION = [
            'id' => \md5('12345'),
        ];

        $request = TestUtils::makeServerRequestMock('GET', '/admin/config/email-service');
        $response = self::$router->dispatch($request, self::$container->get('response'));

        TestUtils::runDefaultTestsHtmlViewResponse($this, $response);
    }
}