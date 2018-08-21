<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 16/04/18
 * Time: 09:38 AM
 */
namespace App\Utils;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Stream;

/**
 * Class ResponseUtils
 * @package App\Utils
 */
class ResponseUtils
{
    /**
     * @param ResponseInterface $response
     */
    public static function addCorsHeader(ResponseInterface &$response)
    {
        $response = $response->withHeader('Access-Control-Allow-Origin', '*');
    }

    /**
     * @param ResponseInterface $response
     */
    public static function addContentTypeJsonHeader(ResponseInterface &$response)
    {
        $response = $response->withHeader('Content-Type', 'application/json; charset=utf-8');
    }

    /**
     * @param ResponseInterface $response
     */
    public static function addContentTypeHtmlHeader(ResponseInterface &$response)
    {
        $response = $response->withHeader('Content-Type', 'text/html; charset=utf-8');
    }

    /**
     * @param ResponseInterface $response
     */
    public static function addContentTypeSvgXmlHeader(ResponseInterface &$response)
    {
        $response = $response->withHeader('Content-Type', 'image/svg+xml');
    }

    /**
     * @param ResponseInterface $response
     * @param string $msg
     */
    public static function setBadRequestJsonResponse(ResponseInterface &$response, string $msg)
    {
        $response = $response->withStatus(400);
        self::setMessageJsonResponse($response, $msg);
    }

    /**
     * @param ResponseInterface $response
     * @param string $msg
     */
    public static function setMessageJsonResponse(ResponseInterface &$response, string $msg)
    {
        self::addContentTypeJsonHeader($response);
        $response->getBody()->write(\json_encode(["msg" => $msg], JSON_UNESCAPED_UNICODE));
    }

    /**
     * @param string $pdfFile
     * @param string $filename
     * @return Response
     */
    public static function setPdfFileResponse(string $pdfFile, string $filename)
    {
        $stream = new Stream($pdfFile, 'r');
        $fileSize = $stream->getSize();

        $response = new Response($stream, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
            'Content-Length' => $fileSize,
            'Content-Transfer-Encoding' => 'binary',
            'Pragma' => 'public',
        ]);

        return $response;
    }

    /**
     * @param string $pdfFile
     * @param string $filename
     * @return Response
     */
    public static function setXmlFileResponse(string $pdfFile, string $filename)
    {
        $stream = new Stream($pdfFile, 'r');
        $fileSize = $stream->getSize();

        $response = new Response($stream, 200, [
            'Content-Type' => 'application/xml',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length' => $fileSize,
            'Content-Transfer-Encoding' => 'binary',
            'Pragma' => 'public',
        ]);

        return $response;
    }

     /**
     * @param string $content
     * @param string $filename
     * @return Response
     */
    public static function setXlsxFileResponse(string $content, string $filename)
    {
         $stream = new Stream($content, 'r');
         $fileSize = $stream->getSize();

        $response = new Response($stream, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length' => $fileSize,
            'Content-Transfer-Encoding' => 'binary',
            'Pragma' => 'public',
        ]);

        return $response;
    }

    /**
     * @param ResponseInterface $response
     * @param string $body
     */
    public static function setSvgResponse(ResponseInterface &$response, string $body)
    {
        self::addContentTypeSvgXmlHeader($response);
        $response->getBody()->write($body);
    }

    /**
     * @param ResponseInterface $response
     * @return array|mixed
     */
    public static function getJsonContentFromResponse(ResponseInterface $response)
    {
        $content = $response->getBody()->getContents();

        if (!$content) return [];

        return \json_decode($content, true);
    }
}
