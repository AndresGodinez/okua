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
 * Class UserAuthApiView
 * @package App\Api
 */
class UserAuthApiView extends BaseApiView
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function userAuth(ServerRequestInterface $request, ResponseInterface $response)
    {
        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write(\json_encode(["token" => "a"]));

        return $response;
    }
}