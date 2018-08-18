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
 * Class HomeView
 * @package App\Views
 */
class HomeView extends BaseView
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response)
    {
        $params = $request->getQueryParams();

        $body = $this->templates->render('app/home', []);

        ResponseUtils::addContentTypeHtmlHeader($response);
        $response->getBody()->write($body);

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function providersIndex(ServerRequestInterface $request, ResponseInterface $response)
    {
        $params = $request->getQueryParams();

        $body = $this->templates->render('app/providers/home', []);

        ResponseUtils::addContentTypeHtmlHeader($response);
        $response->getBody()->write($body);

        return $response;
    }
}
