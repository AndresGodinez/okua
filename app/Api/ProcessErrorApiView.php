<?php
/**
 * Created by Sublime Text.
 * User: Diego
 * Date: 18/08/18
 * Time: 11:56 AM
 */

namespace App\Api;


use App\Entities\ProcessError;
use App\Exceptions\ValidationException;
use App\Models\GetLastRegistersRequestData;
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
    public function getLastProcessError(ServerRequestInterface $request, ResponseInterface $response)
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
}