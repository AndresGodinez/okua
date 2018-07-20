<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 20/07/18
 * Time: 12:40 PM
 */

namespace App\Api;


use App\Utils\ResponseUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class TestApiView
 * @package App\Api
 */
class TestApiView extends BaseApiView
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function test(ServerRequestInterface $request, ResponseInterface $response)
    {
        // use response utils to make a simple json message ({"msg": "..."}) response
        ResponseUtils::addCorsHeader($response);
        ResponseUtils::setMessageJsonResponse($response, "test");
        ResponseUtils::addContentTypeJsonHeader($response);

        // create a complex response from an array (the same as before but unwrapped from functions)
//        $response = $response->withHeader('Access-Control-Allow-Origin', '*');
//
//        $responseData = ["msg" => "test"];
//        $response->getBody()->write(\json_encode($responseData));
//
//        $response = $response->withHeader('Content-Type', 'application/json; charset=utf-8');


        return $response;
    }
}