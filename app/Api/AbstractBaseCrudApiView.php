<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 02:35 PM
 */

namespace App\Api;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class AbstractBaseCrudApiView
 * @package App\Api
 */
abstract class AbstractBaseCrudApiView extends BaseApiView
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public abstract function createRegister(ServerRequestInterface $request, ResponseInterface $response);

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public abstract function readRegisters(ServerRequestInterface $request, ResponseInterface $response);

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public abstract function readRegister(ServerRequestInterface $request, ResponseInterface $response, array $args);

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public abstract function updateRegister(ServerRequestInterface $request, ResponseInterface $response, array $args);

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public abstract function deleteRegister(ServerRequestInterface $request, ResponseInterface $response, array $args);
}