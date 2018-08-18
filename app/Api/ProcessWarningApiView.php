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
}