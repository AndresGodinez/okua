<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 10:34 PM
 */

namespace App\Api;
use App\Exceptions\ApiInternalException;
use App\Exceptions\ValidationException;
use App\Factories\RequestData\UpdateEmailServiceConfigRequestDataFactory;
use App\Models\EmailServiceConfig;
use App\Models\RequestData\UpdateEmailServiceConfigRequestData;
use App\Traits\SharedFilesystemViewTrait;
use App\Utils\ResponseUtils;
use App\Utils\SharedConfigUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class SharedConfigApiView
 * @package App\Api
 */
class SharedConfigApiView extends BaseApiView
{
    use SharedFilesystemViewTrait;

    /** @var null|EmailServiceConfig */
    protected $emailServiceConfig = null;

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws ValidationException
     */
    public function readEmailServiceConfig(ServerRequestInterface $request, ResponseInterface $response)
    {
        $data = !!$this->emailServiceConfig ? $this->emailServiceConfig->toArray() : null;

        if (!$data)
            throw new ValidationException('The configuration is not initialized');

        // remove pswd key from data
        unset($data['pswd']);

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write(\json_encode($data));

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws ValidationException
     */
    public function updateEmailServiceConfig(ServerRequestInterface $request, ResponseInterface $response)
    {
        /** @var UpdateEmailServiceConfigRequestData $requestData */
        $requestData = (new UpdateEmailServiceConfigRequestDataFactory)($request);
        $requestData->validate();

        $this->emailServiceConfig->setHostname($requestData->getHostname());
        $this->emailServiceConfig->setInboxName($requestData->getInboxName());
        $this->emailServiceConfig->setUsername($requestData->getUsername());
        $this->emailServiceConfig->setPswd($requestData->getPswd());
        $this->emailServiceConfig->setTagOk($requestData->getTagOk());
        $this->emailServiceConfig->setTagIssue($requestData->getTagIssue());

        $k = $this->config['OKUA_SHARED_CONFIG_KEY'];
        $fs = $this->getSharedFilesystem();
        try {
            SharedConfigUtils::writeEmailServiceConfig($fs, SharedConfigUtils::$EMAIL_SERVICE_FILE_PATH, $this->emailServiceConfig, $k);
        } catch (ApiInternalException $e) {
            \error_log($e->getMessage());
            ResponseUtils::setBadRequestJsonResponse($response, 'Error saving the new configuration');
            return $response;
        } catch (\SecurityException $e) {
            \error_log($e->getMessage());
            ResponseUtils::setBadRequestJsonResponse($response, 'Error saving the new configuration (security)');
            return $response;
        }

        ResponseUtils::addContentTypeJsonHeader($response);
        ResponseUtils::setMessageJsonResponse($response, 'Configuration successfully updated');
        return $response;
    }

    /**
     * @return EmailServiceConfig|null
     */
    public function getEmailServiceConfig()
    {
        return $this->emailServiceConfig;
    }

    /**
     * @param EmailServiceConfig|null $emailServiceConfig
     */
    public function setEmailServiceConfig(EmailServiceConfig $emailServiceConfig)
    {
        $this->emailServiceConfig = $emailServiceConfig;
    }
}