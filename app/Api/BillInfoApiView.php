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
use App\Repositories\BillInfoRepository;
use App\Traits\EntityManagerViewTrait;
use App\Utils\ResponseUtils;
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
}