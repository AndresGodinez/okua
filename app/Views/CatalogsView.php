<?php
/**
 * Created by PhpStorm.
 * User: aGodinez
 * Date: 03/09/18
 * Time: 14:23
 */

namespace App\Views;

use App\Utils\ResponseUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class CatalogsView
 * @package App\Views
 */
class CatalogsView extends BaseView
{
    ####################################################################################################################
    ### Users
    ####################################################################################################################
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function usersIndex(ServerRequestInterface $request, ResponseInterface $response)
    {
        $body = $this->templates->render('app/catalogs/users/catalogs-user-index');

        ResponseUtils::addContentTypeHtmlHeader($response);
        $response->getBody()->write($body);

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function userForm(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = $args['id'] ?? 0;

        $body = $this->templates->render('app/catalogs/users/user-form', [
            'id' => $id,
        ]);

        ResponseUtils::addContentTypeHtmlHeader($response);
        $response->getBody()->write($body);

        return $response;
    }

    ####################################################################################################################
    ### emitters
    ####################################################################################################################
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function emittersIndex(ServerRequestInterface $request, ResponseInterface $response)
    {
        $body = $this->templates->render('app/catalogs/emitters/catalogs-emitters-index');

        ResponseUtils::addContentTypeHtmlHeader($response);
        $response->getBody()->write($body);

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function emitterForm(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = $args['id'] ?? 0;

        $body = $this->templates->render('app/catalogs/emitters/emitter-form', [
            'id' => $id,
        ]);

        ResponseUtils::addContentTypeHtmlHeader($response);
        $response->getBody()->write($body);

        return $response;
    }

    ####################################################################################################################
    ### filter-emitters
    ####################################################################################################################
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function filterEmitterIndex(ServerRequestInterface $request, ResponseInterface $response)
    {
        $body = $this->templates->render('app/catalogs/filter-emitters/catalogs-filter-emitters-index');

        ResponseUtils::addContentTypeHtmlHeader($response);
        $response->getBody()->write($body);

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function filterEmitterForm(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id =  $args['id'] ?? 0;

        $body = $this->templates->render('app/catalogs/filter-emitters/filter-emitter-form', [
            'id' => $id,
        ]);

        ResponseUtils::addContentTypeHtmlHeader($response);
        $response->getBody()->write($body);

        return $response;
    }

    ####################################################################################################################
    ### filter-receptors
    ####################################################################################################################
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function filterReceptorsIndex(ServerRequestInterface $request, ResponseInterface $response)
    {
        $body = $this->templates->render('app/catalogs/filter-receptors/catalogs-filter-receptors-index');

        ResponseUtils::addContentTypeHtmlHeader($response);
        $response->getBody()->write($body);

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function filterReceptorForm(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = $args['id'] ?? 0;

        $body = $this->templates->render('app/catalogs/filter-receptors/filter-receptor-form', [
            'id' => $id,
        ]);

        ResponseUtils::addContentTypeHtmlHeader($response);
        $response->getBody()->write($body);

        return $response;
    }


    ####################################################################################################################
    ### alert-email-responses
    ####################################################################################################################
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function alertEmailResponsesIndex(ServerRequestInterface $request, ResponseInterface $response)
    {
        $body = $this->templates->render('app/catalogs/alert-email-responses/catalogs-alert-email-responses-index');

        ResponseUtils::addContentTypeHtmlHeader($response);
        $response->getBody()->write($body);

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function alertEmailResponseForm(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = $args['id'] ?? 0;

        $body = $this->templates->render('app/catalogs/alert-email-responses/alert-email-response-form', [
            'id' => $id,
        ]);

        ResponseUtils::addContentTypeHtmlHeader($response);
        $response->getBody()->write($body);

        return $response;
    }
}