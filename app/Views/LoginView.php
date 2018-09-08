<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 13/04/18
 * Time: 11:59 AM
 */

namespace App\Views;

use App\Utils\ResponseUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class LoginView
 * @package App\Views
 */
class LoginView extends BaseView
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response)
    {
        $params = $request->getQueryParams();

        $body = $this->templates->render('app/login', []);

        ResponseUtils::addContentTypeHtmlHeader($response);
        $response->getBody()->write($body);

        return $response;
    }

    public function logout(ServerRequestInterface $request, ResponseInterface $response)
    {
        $params = $request->getQueryParams();
        $body = $this->templates->render('app/logout', []);
        ResponseUtils::addContentTypeHtmlHeader($response);
        $response->getBody()->write($body);
        return $response;
    }
}
