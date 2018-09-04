<?php
/**
 * Created by PhpStorm.
 * FilterReceptor: alberto
 * Date: 3/09/18
 * Time: 02:35 PM
 */

namespace App\Api;
use App\Utils\ResponseUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tests\TestUtils;


/**
 * Class FilterReceptorApiView
 * @package App\Api
 */
class FilterReceptorApiView extends AbstractBaseCrudApiView
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function createRegister(ServerRequestInterface $request, ResponseInterface $response)
    {
        ResponseUtils::addCorsHeader($response);

        $body = TestUtils::mockCreateRegisterResponse();
        $response->getBody()->write($body);

        ResponseUtils::addContentTypeJsonHeader($response);

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function readRegisters(ServerRequestInterface $request, ResponseInterface $response)
    {
        ResponseUtils::addCorsHeader($response);

        $body = TestUtils::mockReadRegistersResponse();
        $response->getBody()->write($body);

        ResponseUtils::addContentTypeJsonHeader($response);

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function readRegister(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        ResponseUtils::addCorsHeader($response);

        $body = TestUtils::mockReadRegisterResponse();
        $response->getBody()->write($body);

        ResponseUtils::addContentTypeJsonHeader($response);

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function updateRegister(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        ResponseUtils::addCorsHeader($response);

        $body = TestUtils::mockUpdateRegisterResponse();
        $response->getBody()->write($body);

        ResponseUtils::addContentTypeJsonHeader($response);

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function deleteRegister(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        ResponseUtils::addCorsHeader($response);

        $body = TestUtils::mockDeleteRegisterResponse();
        $response->getBody()->write($body);

        ResponseUtils::addContentTypeJsonHeader($response);

        return $response;
    }
}