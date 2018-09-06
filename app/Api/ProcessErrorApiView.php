<?php
/**
 * Created by Sublime Text.
 * User: Diego
 * Date: 18/08/18
 * Time: 11:56 AM
 */

namespace App\Api;


use App\Entities\ProcessError;
use App\Models\GetLastRegistersRequestData;
use App\Models\GetFilteredErrorRegistersRequestData;
use App\Models\GetFilteredErrorRegistersCountRequestData;
use App\Repositories\ProcessErrorRepository;
use App\Traits\EntityManagerViewTrait;
use App\Transformers\ProcessErrorItemTransformer;
use App\Utils\ResponseUtils;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ProcessWarningApiView
 * @package App\Api
 */

class ProcessErrorApiView extends BaseApiView {

	use EntityManagerViewTrait;

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \App\Exceptions\ValidationException
     */
    public function getLastProcessErrors(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetLastRegistersRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var ProcessErrorRepository $repo */
        $repo = $this->getEm()->getRepository(ProcessError::class);

        $registers = $repo->getLastProcessError($requestData->getLimit());

        $manager = new Manager();
        $resource = new Collection($registers, new ProcessErrorItemTransformer());
        $data = $manager->createData($resource)->toJson();

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write($data);

        return $response;
    }

    public function getProcessErrorById(ServerRequestInterface $request, ResponseInterface $response, array $args){
        $processErrorId = $args['processErrorId'] ?? 0;

        $repo = $this->getEm()->getRepository(ProcessError::class);

        $registers = $repo->getProcessErrorById($processErrorId);

        $manager = new Manager();
        $resource = new Collection($registers, new ProcessErrorItemTransformer());
        $data = $manager->createData($resource)->toJson();

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write($data);

        return $response;
    }

    public function getFilteredProcessErrorRegisters(ServerRequestInterface $request, ResponseInterface $response){
        $requestData = GetFilteredErrorRegistersRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        $repo = $this->getEm()->getRepository(ProcessError::class);

        $registers = $repo->getFilteredRegisters(
            $requestData->getLimit(),
            $requestData->getOffset(),
            $requestData->getStartDatetimeObj(),
            $requestData->getEndDatetimeObj(),
            $requestData->getFilterDateType()
        );

        $manager = new Manager();
        $resource = new Collection($registers, new ProcessErrorItemTransformer());
        $data = $manager->createData($resource)->toJson();

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write($data);

        return $response;
    }

    public function getFilteredProcessErrorRegistersCount(ServerRequestInterface $request, ResponseInterface $response){
        $requestData = GetFilteredErrorRegistersCountRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        $repo = $this->getEm()->getRepository(ProcessError::class);

        $result = $repo->getFilteredRegistersCount(
            $requestData->getStartDatetimeObj(),
            $requestData->getEndDatetimeObj(),
            $requestData->getFilterDateType()
        );

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write(\json_encode(['count' => (int)$result]));

        return $response;
    }
}