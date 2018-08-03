<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 2/08/18
 * Time: 02:44 PM
 */

namespace App\Api;


use App\Entities\BillInfo;
use App\Models\GetBillsTotalRequestData;
use App\Models\GetFilteredBillInfoRegistersRequestData;
use App\Models\GetLastBillInfoRegistersRequestData;
use App\Repositories\BillInfoRepository;
use App\Traits\EntityManagerViewTrait;
use App\Transformers\BillInfoEmailItemTransformer;
use App\Transformers\BillInfoEntityTransformer;
use App\Utils\ResponseUtils;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class BillInfoApiView
 * @package App\Api
 */
class BillInfoApiView extends BaseApiView
{
    use EntityManagerViewTrait;

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \App\Exceptions\ValidationException
     */
    public function getBillsTotal(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetBillsTotalRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var BillInfoRepository $repo */
        $repo = $this->getEm()->getRepository(BillInfo::class);

        $total = $repo->getIncomeTotalByRangeTimeFilter($requestData->getFilter());

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write(\json_encode(['total' => (float)$total]));

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \App\Exceptions\ValidationException
     */
    public function getBillsInfoGroupByClient(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetBillsTotalRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var BillInfoRepository $repo */
        $repo = $this->getEm()->getRepository(BillInfo::class);

        $registers = $repo->getRegistersGroupedByClientAndFilter($requestData->getFilter());

        \error_log(\print_r($registers, true));

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write(\json_encode(['total' => \count($registers)]));

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \App\Exceptions\ValidationException
     */
    public function getBillsInfoGroupByCfdiUse(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetBillsTotalRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var BillInfoRepository $repo */
        $repo = $this->getEm()->getRepository(BillInfo::class);

        $registers = $repo->getRegistersGroupedByCfdiUseAndFilter($requestData->getFilter());

        \error_log(\print_r($registers, true));

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write(\json_encode(['total' => \count($registers)]));

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \App\Exceptions\ValidationException
     */
    public function getBillsInfoGroupByEmail(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetBillsTotalRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var BillInfoRepository $repo */
        $repo = $this->getEm()->getRepository(BillInfo::class);

        $registers = $repo->getRegistersGroupedByEmailAndFilter($requestData->getFilter());

        \error_log(\print_r($registers, true));

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write(\json_encode(['total' => \count($registers)]));

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \App\Exceptions\ValidationException
     */
    public function getLastBillInfoRegisters(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetLastBillInfoRegistersRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var BillInfoRepository $repo */
        $repo = $this->getEm()->getRepository(BillInfo::class);

        $registers = $repo->getLastRegistersGroupedByEmail($requestData->getLimit());

        $manager = new Manager();
        $resource = new Collection($registers, new BillInfoEmailItemTransformer());
        $data = $manager->createData($resource)->toJson();

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write($data);

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \App\Exceptions\ValidationException
     */
    public function getFilteredBillInfoRegisters(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetFilteredBillInfoRegistersRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var BillInfoRepository $repo */
        $repo = $this->getEm()->getRepository(BillInfo::class);

        $registers = $repo->getFilteredRegisters(
            $requestData->getLimit(),
            $requestData->getOffset(),
            $requestData->getStartDatetimeObj(),
            $requestData->getEndDatetimeObj(),
            $requestData->getClientRfc(),
            $requestData->getInitialAmount(),
            $requestData->getFinalAmount()
        );

        $manager = new Manager();
        $resource = new Collection($registers, new BillInfoEntityTransformer());
        $data = $manager->createData($resource)->toJson();

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write($data);

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \App\Exceptions\ValidationException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getFilteredBillInfoRegistersCount(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetFilteredBillInfoRegistersRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var BillInfoRepository $repo */
        $repo = $this->getEm()->getRepository(BillInfo::class);

        $result = $repo->getFilteredRegistersCount(
            $requestData->getStartDatetimeObj(),
            $requestData->getEndDatetimeObj(),
            $requestData->getClientRfc(),
            $requestData->getInitialAmount(),
            $requestData->getFinalAmount()
        );

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write(\json_encode(['count' => $result]));

        return $response;
    }
}