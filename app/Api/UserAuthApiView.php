<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 20/07/18
 * Time: 12:40 PM
 */

namespace App\Api;


use App\Exceptions\RemoteApiException;
use App\Models\LoginRequestData;
use App\Utils\ResponseUtils;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class UserAuthApiView
 * @package App\Api
 */
class UserAuthApiView extends BaseApiView
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws RemoteApiException
     * @throws \App\Exceptions\ValidationException
     */
    public function userAuth(ServerRequestInterface $request, ResponseInterface $response)
    {
        $reqData = LoginRequestData::makeFromRequest($request);
        $reqData->validate();

        $config = $this->getConfig();

        $citzouServiceUri = $config['CITZOU_SERVICE_URI'];
        $citzouDomain = $config['CITZOU_DOMAIN'];

        $client = new \GuzzleHttp\Client();

        try {
            $reqFormParams = [
                "username" => $reqData->getUsername(),
                "password" => $reqData->getPassword(),
                "domain" => $citzouDomain,
            ];
            $res = $client->post($citzouServiceUri . '/authenticate', ['form_params' => $reqFormParams]);
        } catch (ClientException $cex) {
            $content = ResponseUtils::getJsonContentFromResponse($cex->getResponse());
            $error = $content['error'];
            throw new RemoteApiException($error['message'], $error['statusCode']);
        }

        $resBody = $res->getBody()->getContents();
        $resBodyArr = \json_decode($resBody, true);
        $token = $resBodyArr['token'];

        $body = \json_encode(["token" => $token]);
        $response->getBody()->write($body);

        return $response;
    }
}