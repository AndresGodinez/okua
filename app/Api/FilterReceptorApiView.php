<?php
/**
 * Created by PhpStorm.
 * FilterReceptor: alberto
 * Date: 3/09/18
 * Time: 02:35 PM
 */

namespace App\Api;


use App\Entities\FilterReceptor;
use App\Exceptions\ApiCrudCreateRegisterException;
use App\Exceptions\ApiCrudDeleteRegisterException;
use App\Exceptions\ApiCrudUpdateRegisterException;
use App\Exceptions\ApiRegisterNotFoundException;
use App\Exceptions\ValidationException;
use App\Factories\RequestData\CreateFilterReceptorRequestDataFactory;
use App\Factories\RequestData\UpdateFilterReceptorRequestDataFactory;
use App\Models\RequestData\CreateFilterReceptorRequestData;
use App\Models\RequestData\UpdateFilterReceptorRequestData;
use App\Repositories\FilterReceptorRepository;
use App\Traits\EntityManagerViewTrait;
use App\Transformers\FilterReceptorItemTransformer;
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
 * Class FilterReceptorApiView
 * @package App\Api
 */
class FilterReceptorApiView extends AbstractBaseCrudApiView
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
        /** @var CreateFilterReceptorRequestData $requestData */
        $requestData = (new CreateFilterReceptorRequestDataFactory())($request);
        $requestData->validate();

        // save new register
        $register = new FilterReceptor();
        $register->setRfc($requestData->getRfc());
        $register->setValid($requestData->getValid());

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
        /** @var FilterReceptorRepository $repo */
        $repo = $this->em->getRepository(FilterReceptor::class);

        $registers = $repo->findAll();

        $manager = new Manager();
        $resource = new Collection($registers, new FilterReceptorItemTransformer());
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

        /** @var FilterReceptorRepository $repo */
        $repo = $this->em->getRepository(FilterReceptor::class);

        /** @var FilterReceptor $register */
        $register = $repo->find($regId);

        if (!$register) {
            throw new ApiRegisterNotFoundException();
        }

        $manager = new Manager();
        $manager->setSerializer(new ArraySerializer());
        $resource = new Item($register, new FilterReceptorItemTransformer());
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

        /** @var FilterReceptorRepository $repo */
        $repo = $this->em->getRepository(FilterReceptor::class);

        /** @var FilterReceptor $register */
        $register = $repo->find((int)$regId);

        if (!$register) {
            throw new ApiRegisterNotFoundException();
        }

        /** @var UpdateFilterReceptorRequestData $requestData */
        $requestData = (new UpdateFilterReceptorRequestDataFactory())($request);
        $requestData->validate();

        // update register
        $register->setRfc($requestData->getRfc());
        $register->setValid($requestData->getValid());

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

        /** @var FilterReceptor $register */
        $register = $this->em->find(FilterReceptor::class, (int)$regId);

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