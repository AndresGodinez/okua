<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 18/08/18
 * Time: 01:25 PM
 */

namespace App\Views;


use App\Utils\ResponseUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ProvidersHomeView
 * @package App\Views
 */
class ProvidersHomeView extends BaseView
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response)
    {
        $params = $request->getQueryParams();

        $body = $this->templates->render('app/providers/home', []);

        ResponseUtils::addContentTypeHtmlHeader($response);
        $response->getBody()->write($body);

        return $response;
    }
}