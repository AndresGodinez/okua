<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 31/07/18
 * Time: 05:25 PM
 */

namespace Tests;

use Zend\Diactoros\ServerRequestFactory;


class TestUtils
{
    const HEADER_CONTENT_TYPE = 'Content-Type';
    const CONTENT_TYPE_APPLICATION_JSON_UTF8 = 'application/json; charset=utf-8';

    /**
     * @param $method
     * @param $uri
     * @param array $query
     * @param array $body
     * @return \Zend\Diactoros\ServerRequest
     */
    public static function makeServerRequestMock($method, $uri, $query = [], $body = [])
    {
        $server = (require __DIR__ . DIRECTORY_SEPARATOR . "server-mock.php");

        $server['REQUEST_METHOD'] = $method;
        $server['REQUEST_URI'] = $uri;

        return ServerRequestFactory::fromGlobals($server, $query, $body);
    }
}