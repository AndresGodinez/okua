<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 04:23 PM
 */

namespace App\Site\Middlewares;


use App\Exceptions\ViewSecurityException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class SecureApiQueryParamMiddleware
 * @package App\Site\Middlewares
 */
class SecureApiQueryParamMiddleware
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return mixed
     * @throws ViewSecurityException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $queryParams = $request->getQueryParams();

        if (!$queryParams) {
            throw new ViewSecurityException('Unauthorized request', 401);
        }

        $encJwt = $queryParams['a'] ?? false;

        if (!$encJwt) {
            throw new ViewSecurityException('Unauthorized request', 401);
        }

        // todo: decrypt encJwt and validate it with token utils class

        return $next($request, $response);
    }

}