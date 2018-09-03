<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 27/04/18
 * Time: 10:40 AM
 */

namespace App\Utils;


/**
 * Class RequestUtils
 * @package App\Utils
 */
class RequestUtils
{
    const HEADER_AUTHORIZATION = 'authorization';

    /**
     * @param array $server
     * @param array $defBody
     * @return array
     */
    public static function getParsedBodyFromServer(array $server, array $defBody)
    {
        // init default parsed body array
        $parsedBody = $defBody ?? [];

        // get request method
        $requestMethod = \strtolower($server['REQUEST_METHOD'] ?? '');

        // get content-type header
        $contentType = \strtolower($server['CONTENT_TYPE'] ?? '');

        // get requestBody string from input stream
        $requestBodyStr = \file_get_contents('php://input');
        $requestBody = [];

        // parse post json input or put input
        if (!!$requestBodyStr && \strpos($contentType, 'application/json') !== false) {
            // json content type
            $requestBody = \json_decode($requestBodyStr);
        } else if (!!$requestBodyStr && ($requestMethod === 'put' || $requestMethod === 'delete')) {
            // parse put input
            \parse_str($requestBodyStr, $requestBody);
        }

        if (!empty($requestBody)) {
            $parsedBody = \array_merge($parsedBody, $requestBody);
        }

        return $parsedBody;
    }
}
