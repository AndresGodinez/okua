<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 03:17 PM
 */

namespace App\Utils;


use App\Site\Middlewares\SecureApiMiddleware;
use League\Route\RouteGroup;


/**
 * Class SiteRouterUtils
 * @package App\Utils
 */
class SiteRouterUtils
{
    /**
     * @param RouteGroup $group
     * @param string $baseRoute
     * @param string $className
     */
    public static function appendCrudRoutesToRouteGroup(RouteGroup &$group, string $baseRoute, string $className, $secureRoute = false)
    {
        $middleware = new SecureApiMiddleware;

        $route = $group->post($baseRoute, $className . "::createRegister");
        if ($secureRoute) $route->middleware($middleware);

        $route = $group->get($baseRoute, $className . "::readRegisters");
        if ($secureRoute) $route->middleware($middleware);

        $route = $group->get($baseRoute . '/{regId:regId}', $className . "::readRegister");
        if ($secureRoute) $route->middleware($middleware);

        $route = $group->put($baseRoute . '/{regId:regId}', $className . "::updateRegister");
        if ($secureRoute) $route->middleware($middleware);

        $route = $group->delete($baseRoute . '/{regId:regId}', $className . "::deleteRegister");
        if ($secureRoute) $route->middleware($middleware);
    }
}