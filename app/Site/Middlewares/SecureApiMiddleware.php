<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 04:23 PM
 */

namespace App\Site\Middlewares;


use App\Exceptions\ApiSecurityException;
use App\Utils\RequestUtils;
use App\Utils\SecurityUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class SecureApiMiddleware
 * @package App\Site\Middlewares
 */
class SecureApiMiddleware
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return mixed
     * @throws ApiSecurityException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if (!$request->hasHeader(RequestUtils::HEADER_AUTHORIZATION)) {
            throw new ApiSecurityException('Unauthorized request');
        }

        $authorizationHeader = $request->getHeaderLine(RequestUtils::HEADER_AUTHORIZATION);

        if (!$authorizationHeader) {
            throw new ApiSecurityException('Unauthorized request');
        }

        list($jwt) = \sscanf($authorizationHeader, 'Bearer %s');

        if (!$jwt) {
            throw new ApiSecurityException('Unauthorized request');
        }

        // todo: validate jwt with token utils class

        return $next($request, $response);
    }

}