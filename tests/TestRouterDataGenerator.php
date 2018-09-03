<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 03:38 PM
 */

namespace Tests;


use FastRoute\DataGenerator;

class TestRouterDataGenerator implements DataGenerator
{
    protected $routes = [];

    /**
     * Adds a route to the data generator. The route data uses the
     * same format that is returned by RouterParser::parser().
     *
     * The handler doesn't necessarily need to be a callable, it
     * can be arbitrary data that will be returned when the route
     * matches.
     *
     * @param string $httpMethod
     * @param array $routeData
     * @param mixed $handler
     */
    public function addRoute($httpMethod, $routeData, $handler)
    {
        $args = $routeData[1] ?? false;
        \array_push($this->routes, ['method' => $httpMethod, 'route' => $routeData[0], 'args' => $args]);
    }

    /**
     * Returns dispatcher data in some unspecified format, which
     * depends on the used method of dispatch.
     */
    public function getData()
    {
        return $this->routes ?? [];
    }
}