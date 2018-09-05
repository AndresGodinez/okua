<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 10:13 PM
 */

namespace App\Api;


use App\Entities\AlertEmailResponse;
use App\Exceptions\ApiCrudCreateRegisterException;
use App\Exceptions\ApiCrudUpdateRegisterException;
use App\Exceptions\ApiRegisterNotFoundException;
use App\Exceptions\ValidationException;
use App\Factories\RequestData\CreateAlertEmailResponseRequestDataFactory;
use App\Factories\RequestData\UpdateAlertEmailResponseRequestDataFactory;
use App\Models\RequestData\CreateAlertEmailResponseRequestData;
use App\Repositories\AlertEmailResponseRepository;
use App\Traits\EntityManagerViewTrait;
use App\Transformers\AlertEmailResponseItemTransformer;
use App\Utils\ResponseUtils;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\ArraySerializer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class AlertEmailResponseApiView
 * @package App\Api
 */
class AlertEmailResponseApiView extends AbstractBaseCrudApiView
{
    use EntityManagerViewTrait;

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \App\Exceptions\ValidationException
     * @throws ApiCrudCreateRegisterException
     */
    public function createRegister(ServerRequestInterface $request, ResponseInterface $response)
    {
        /** @var CreateAlertEmailResponseRequestData $requestData */
        $requestData = (new CreateAlertEmailResponseRequestDataFactory)($request);
        $requestData->validate();

        // save new register
        $register = new AlertEmailResponse();
        $register->setCode($requestData->getCode());
        $register->setInternalMsg($requestData->getInternalMsg());
        $register->setEmailMsg($requestData->getEmailMsg());

        try {
            $this->em->persist($register);
            $this->em->flush($register);
        } catch (OptimisticLockException $e) {
            \error_log($e->getMessage());
            throw new ApiCrudCreateRegisterException();
        } catch (ORMException $e) {
            \error_log($e->getMessage());
            throw new ApiCrudCreateRegisterException();
        }

        ResponseUtils::addContentTypeJsonHeader($response);

        $response->getBody()->write(\json_encode([
            'id' => $register->getId(),
            'msg' => 'Register successfully created',
        ]));

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function readRegisters(ServerRequestInterface $request, ResponseInterface $response)
    {
        /** @var AlertEmailResponseRepository $repo */
        $repo = $this->em->getRepository(AlertEmailResponse::class);

        $registers = $repo->findAll();

        $manager = new Manager();
        $resource = new Collection($registers, new AlertEmailResponseItemTransformer());
        $data = $manager->createData($resource)->toJson();

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write($data);

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     * @throws ValidationException
     * @throws ApiRegisterNotFoundException
     */
    public function readRegister(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $regId = $args['regId'] ?? 0;

        if (!$regId || $regId < 0) {
            throw new ValidationException('Invalid register id');
        }

        /** @var AlertEmailResponseRepository $repo */
        $repo = $this->em->getRepository(AlertEmailResponse::class);

        /** @var AlertEmailResponse $register */
        $register = $repo->find($regId);

        if (!$register) {
            throw new ApiRegisterNotFoundException();
        }

        $manager = new Manager();
        $manager->setSerializer(new ArraySerializer());
        $resource = new Item($register, new AlertEmailResponseItemTransformer());
        $data = $manager->createData($resource)->toJson();

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write($data);

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     * @throws ValidationException
     * @throws ApiCrudUpdateRegisterException
     * @throws ApiRegisterNotFoundException
     */
    public function updateRegister(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $regId = $args['regId'] ?? 0;

        if (!$regId || $regId < 0) {
            throw new ValidationException('Invalid register id');
        }

        /** @var AlertEmailResponseRepository $repo */
        $repo = $this->em->getRepository(AlertEmailResponse::class);

        /** @var AlertEmailResponse $register */
        $register = $repo->find((int)$regId);

        if (!$register) {
            throw new ApiRegisterNotFoundException();
        }

        /** @var CreateAlertEmailResponseRequestData $requestData */
        $requestData = (new UpdateAlertEmailResponseRequestDataFactory())($request);
        $requestData->validate();

        // update register
        $register->setCode($requestData->getCode());
        $register->setInternalMsg($requestData->getInternalMsg());
        $register->setEmailMsg($requestData->getEmailMsg());

        try {
            $this->em->merge($register);
            $this->em->flush($register);
        } catch (OptimisticLockException $e) {
            \error_log($e->getMessage());
            throw new ApiCrudUpdateRegisterException();
        } catch (ORMException $e) {
            \error_log($e->getMessage());
            throw new ApiCrudUpdateRegisterException();
        }

        ResponseUtils::addContentTypeJsonHeader($response);

        $response->getBody()->write(\json_encode([
            'id' => $register->getId(),
            'msg' => 'Register successfully updated',
        ]));
        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function deleteRegister(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        ResponseUtils::setForbiddenJsonResponse($response, 'Forbidden');
        return $response;
    }
}