<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 8/06/18
 * Time: 04:40 PM
 */

namespace App\Utils;


use App\Exceptions\ApiSecurityException;
use App\Exceptions\RemoteApiException;
use App\Exceptions\ValidationException;
use App\Exceptions\ViewInvalidSessionException;
use App\Exceptions\ViewSecurityException;
use App\Exceptions\ViewValidationException;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ExceptionUtils
 * @package App\Utils
 */
class ExceptionUtils
{
    /**
     * @param ResponseInterface $response
     * @param ValidationException $e
     * @return ResponseInterface
     */
    public static function prepareValidationExceptionResponse(ResponseInterface $response, ValidationException $e)
    {
        $response = $response->withStatus(400);
        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write(\json_encode(["message" => $e->getMessage()]));

        return $response;
    }
    /**
     * @param ResponseInterface $response
     * @param ApiSecurityException $e
     * @return ResponseInterface
     */
    public static function prepareApiSecurityExceptionResponse(ResponseInterface $response, ApiSecurityException $e)
    {
        $response = $response->withStatus(401);
        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write(\json_encode(["message" => $e->getMessage()]));

        return $response;
    }

    /**
     * @param ResponseInterface $response
     * @param RemoteApiException $e
     * @return ResponseInterface
     */
    public static function prepareRemoteApiExceptionResponse(ResponseInterface $response, RemoteApiException $e)
    {
        $response = $response->withStatus($e->getCode());
        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write(\json_encode(["message" => $e->getMessage()]));

        return $response;
    }

    /**
     * @param Engine $templates
     * @param ResponseInterface $response
     * @param \Exception $e
     * @return ResponseInterface
     */
    public static function prepareViewError(Engine $templates, ResponseInterface $response, \Exception $e)
    {
        $response = $response->withStatus($e->getCode());
        ResponseUtils::addContentTypeHtmlHeader($response);

        $template = '';

        if ($e instanceof ViewInvalidSessionException)
            $template = 'errors/view-invalid-session-exception';
        else if ($e instanceof ViewValidationException)
            $template = 'errors/view-validation-exception';
        else if ($e instanceof ViewSecurityException)
            $template = 'errors/view-security-exception';

        $body = $templates->render($template, ['msg' => $e->getMessage()]);

        $response->getBody()->write($body);

        return $response;
    }
}