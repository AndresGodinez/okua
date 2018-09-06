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
 * Class ErrorView
 * @package App\Views
 */
class ErrorView extends BaseView
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response)
    {
        $params = $request->getQueryParams();

        $body = $this->templates->render('app/error', []);

        ResponseUtils::addContentTypeHtmlHeader($response);
        $response->getBody()->write($body);

        return $response;
    }
}
