<?php
/**
 * Created by PhpStorm.
 * Emitter: alberto
 * Date: 3/09/18
 * Time: 02:35 PM
 */

namespace App\Api;
use App\Entities\Emitter;
use App\Exceptions\ApiCrudCreateRegisterException;
use App\Exceptions\ApiCrudDeleteRegisterException;
use App\Exceptions\ApiCrudUpdateRegisterException;
use App\Exceptions\ApiRegisterNotFoundException;
use App\Exceptions\ValidationException;
use App\Factories\RequestData\CreateEmitterRequestDataFactory;
use App\Factories\RequestData\UpdateEmitterRequestDataFactory;
use App\Models\RequestData\CreateEmitterRequestData;
use App\Models\RequestData\UpdateEmitterRequestData;
use App\Repositories\EmitterRepository;
use App\Traits\EntityManagerViewTrait;
use App\Transformers\EmitterItemTransformer;
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
 * Class EmitterApiView
 * @package App\Api
 */
class EmitterApiView extends AbstractBaseCrudApiView
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
        /** @var CreateEmitterRequestData $requestData */
        $requestData = (new CreateEmitterRequestDataFactory())($request);
        $requestData->validate();

        // save new register
        $register = new Emitter();
        $register->setName($requestData->getName());
        $register->setRfc($requestData->getRfc());
        $register->setEmail($requestData->getEmail());

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
        /** @var EmitterRepository $repo */
        $repo = $this->em->getRepository(Emitter::class);

        $registers = $repo->findAll();

        $manager = new Manager();
        $resource = new Collection($registers, new EmitterItemTransformer());
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

        /** @var EmitterRepository $repo */
        $repo = $this->em->getRepository(Emitter::class);

        /** @var Emitter $register */
        $register = $repo->find($regId);

        if (!$register) {
            throw new ApiRegisterNotFoundException();
        }

        $manager = new Manager();
        $manager->setSerializer(new ArraySerializer());
        $resource = new Item($register, new EmitterItemTransformer());
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
     * @throws ApiCrudUpdateRegisterException
     */
    public function updateRegister(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $regId = $args['regId'] ?? 0;

        if (!$regId || $regId < 0) {
            throw new ValidationException('Invalid register id');
        }

        /** @var EmitterRepository $repo */
        $repo = $this->em->getRepository(Emitter::class);

        /** @var Emitter $register */
        $register = $repo->find((int)$regId);

        if (!$register) {
            throw new ApiRegisterNotFoundException();
        }

        /** @var UpdateEmitterRequestData $requestData */
        $requestData = (new UpdateEmitterRequestDataFactory())($request);
        $requestData->validate();

        // update register
        $register->setName($requestData->getName());
        $register->setRfc($requestData->getRfc());
        $register->setEmail($requestData->getEmail());

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
     * @throws ApiCrudUpdateRegisterException
     * @throws ApiRegisterNotFoundException
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws ValidationException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws ApiCrudDeleteRegisterException
     */
    public function deleteRegister(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $regId = $args['regId'] ?? 0;

        if (!$regId || $regId < 0) {
            throw new ValidationException('Invalid register id');
        }

        /** @var Emitter $register */
        $register = $this->em->find(Emitter::class, (int)$regId);

        if (!$register) {
            throw new ApiRegisterNotFoundException();
        }

        // delete register
        try {
            $this->em->remove($register);
            $this->em->flush($register);
        } catch (OptimisticLockException $e) {
            \error_log($e->getMessage());
            throw new ApiCrudDeleteRegisterException();
        } catch (ORMException $e) {
            \error_log($e->getMessage());
            throw new ApiCrudDeleteRegisterException();
        }

        ResponseUtils::addContentTypeJsonHeader($response);

        $response->getBody()->write(\json_encode([
            'id' => $register->getId(),
            'msg' => 'Register successfully deleted',
        ]));
        return $response;
    }
}