<?php
/**
 * Created by Sublime Text.
 * User: Diego
 * Date: 18/08/18
 * Time: 11:56 AM
 */

namespace App\Api;


use App\Entities\ProcessWarning;
use App\Models\GetLastRegistersRequestData;
use App\Models\GetFilteredWarningRegistersRequestData;
use App\Models\GetFilteredWarningRegistersCountRequestData;
use App\Repositories\ProcessWarningRepository;
use App\Traits\EntityManagerViewTrait;
use App\Transformers\ProcessWarningItemTransformer;
use App\Utils\ResponseUtils;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ProcessWarningApiView
 * @package App\Api
 */

class ProcessWarningApiView extends BaseApiView {

	use EntityManagerViewTrait;

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \App\Exceptions\ValidationException
     */
    public function getLastProcessWarnings(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetLastRegistersRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var ProcessWarningRepository $repo */
        $repo = $this->getEm()->getRepository(ProcessWarning::class);

        $registers = $repo->getLastProcessWarning($requestData->getLimit());

        $manager = new Manager();
        $resource = new Collection($registers, new ProcessWarningItemTransformer());
        $data = $manager->createData($resource)->toJson();

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write($data);

        return $response;
    }

    public function getEveryRegister(ServerRequestInterface $request, ResponseInterface $response){
        $repo = $this->getEm()->getRepository(ProcessWarning::class);

        $registers = $repo->findAll();

        $manager = new Manager();
        $resource = new Collection($registers, new ProcessWarningItemTransformer());
        $data = $manager->createData($resource)->toJson();

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write($data);

        return $response;
    }

    public function getFilteredProcessWarningsRegisters(ServerRequestInterface $request, ResponseInterface $response){
        $requestData = GetFilteredWarningRegistersRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        $repo = $this->getEm()->getRepository(ProcessWarning::class);

        $registers = $repo->getFilteredRegisters(
            $requestData->getLimit(),
            $requestData->getOffset(),
            $requestData->getStartDatetimeObj(),
            $requestData->getEndDatetimeObj(),
            $requestData->getFilterDateType()
        );

        $manager = new Manager();
        $resource = new Collection($registers, new ProcessWarningItemTransformer());
        $data = $manager->createData($resource)->toJson();

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write($data);

        return $response;
    }

    public function getFilteredProcessWarningsRegistersCount(ServerRequestInterface $request, ResponseInterface $response){
        $requestData = GetFilteredWarningRegistersCountRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        $repo = $this->getEm()->getRepository(ProcessWarning::class);

        $result = $repo->getFilteredRegistersCount(
            $requestData->getStartDatetimeObj(),
            $requestData->getEndDatetimeObj(),
            $requestData->getFilterDateType()
        );

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write(\json_encode(['count' => (int)$result]));

        return $response;
    }

    public function getProcessWarningById(ServerRequestInterface $request, ResponseInterface $response, array $args){
        $processWarningId = $args['processWarningId'] ?? 0;
        
        $repo = $this->getEm()->getRepository(ProcessWarning::class);

        $registers = $repo->getProcessWarningById($processWarningId);

        $manager = new Manager();
        $resource = new Collection($registers, new ProcessWarningItemTransformer());
        $data = $manager->createData($resource)->toJson();

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write($data);

        return $response;
    }
}