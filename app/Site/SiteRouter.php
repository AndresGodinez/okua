<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 13/04/18
 * Time: 12:09 PM
 */

namespace App\Site;

use App\Api\LoginApiView;
use App\Api\ReportsApiView;
use App\Api\TestApiView;
use App\Views\HomeView;
use App\Views\LoginView;
use App\Views\ModulesView;
use App\Views\ReportsView;
use League\Container\Container;
use League\Route\RouteCollection;
use League\Route\RouteGroup;
use Zend\Diactoros\Response\RedirectResponse;

class SiteRouter
{
    public function __invoke(Container $container)
    {
        $route = new RouteCollection($container);

        # SECTION: front-end views
        $route->group('/', function (RouteGroup $group) {
            $group->map('GET', '/', function ($request, $response) {
                return new RedirectResponse('/home');
            });
            $group->map('GET', '/home', HomeView::class . '::index');
        })
            ->setScheme('http');


        # SECTION: back-end views (API)
        $route->group('/api', function (RouteGroup $group) {
            $group->map('GET', '/test', TestApiView::class . '::test');
        })
            ->setScheme('http');

        return $route;
    }
}
