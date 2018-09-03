<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 03:20 PM
 */

namespace Tests\Utils;


use App\Api\UserApiView;
use App\Site\SiteContainer;
use App\Utils\SiteRouterUtils;
use League\Container\Container;
use League\Route\RouteCollection;
use League\Route\RouteGroup;
use PHPUnit\Framework\TestCase;
use Tests\TestRouterDataGenerator;
use Tests\TestUtils;


/**
 * Class ClassSiteRouterUtilsTest
 * @package Tests\Utils
 */
class ClassSiteRouterUtilsTest extends TestCase
{
    /** @var Container */
    protected static $container = null;

    public static function setUpBeforeClass()
    {
        self::$container = SiteContainer::make();

        TestUtils::initConsts();
    }

    public function testAppendCrudRoutesToRouteGroup()
    {
        $route = new RouteCollection(self::$container, null, new TestRouterDataGenerator);
        $route->group('/api', function (RouteGroup $group) {
            SiteRouterUtils::appendCrudRoutesToRouteGroup($group, '/user' , UserApiView::class);
        });

        $request = TestUtils::makeServerRequestMock('GET', '/api/user');
        $dispatcher = $route->getDispatcher($request);

        $data = $route->getData();

        $this->assertTrue($this->searchRouteInData($data, 'POST', '/api/user'));
        $this->assertTrue($this->searchRouteInData($data, 'GET', '/api/user'));
        $this->assertTrue($this->searchRouteInData($data, 'GET', '/api/user/', true));
        $this->assertTrue($this->searchRouteInData($data, 'PUT', '/api/user/', true));
        $this->assertTrue($this->searchRouteInData($data, 'DELETE', '/api/user/', true));
    }

    /**
     * @param $data
     * @param string $routeMethod
     * @param string $routePath
     * @param bool $hasArgs
     * @return bool
     */
    private function searchRouteInData($data, string $routeMethod, string $routePath, bool $hasArgs = false)
    {
        $inArray = false;

        foreach ($data as $item) {
            if ($item['method'] == $routeMethod && $item['route'] == $routePath) {
                if ($hasArgs && !!$item['args']) {
                    $inArray = true;
                    break;
                } else if (!$hasArgs) {
                    $inArray = true;
                    break;
                }
            }
        }

        return $inArray;
    }
}