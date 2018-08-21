<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 2/08/18
 * Time: 02:44 PM
 */

namespace App\Api;


use App\Entities\BillInfo;
use App\Exceptions\ValidationException;
use App\Models\CountGetBillsInfoGroupedByRequestData;
use App\Models\GetBillsInfoGroupedByRequestData;
use App\Models\GetBillsTotalRequestData;
use App\Models\GetFilteredBillInfoRegistersCountRequestData;
use App\Models\GetFilteredBillInfoReportData;
use App\Models\GetFilteredBillInfoRegistersRequestData;
use App\Models\GetLastRegistersRequestData;
use App\Repositories\BillInfoRepository;
use App\Traits\EntityManagerViewTrait;
use App\Traits\LocalFilesystemViewTrait;
use App\Transformers\BillInfoEmailItemTransformer;
use App\Transformers\BillInfoEntityTransformer;
use App\Transformers\BillInfoEntityWithCfdiUseNameTransformer;
use App\Transformers\BillInfoGroupByCfdiUseItemTransformer;
use App\Transformers\BillInfoGroupByClientItemTransformer;
use App\Transformers\BillInfoGroupByEmailItemTransformer;
use App\Transformers\BillInfoTaxTransformer;
use App\Utils\ResponseUtils;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use XLSXWriter;

/**
 * Class BillInfoApiView
 * @package App\Api
 */
class BillInfoApiView extends BaseApiView
{
    use EntityManagerViewTrait;

    use LocalFilesystemViewTrait;

    /**
     * ReportsApiView constructor.
     * @param FileSystem $localFilesystem
     */
    public function __construct(Filesystem $localFilesystem)
    {
        $this->localFilesystem = $localFilesystem;
    }

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
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getBillsInfoGroupByClientCount(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = CountGetBillsInfoGroupedByRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var BillInfoRepository $repo */
        $repo = $this->getEm()->getRepository(BillInfo::class);

        $result = $repo->getRegistersGroupedByClientAndFilterCount($requestData->getFilter());

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write(\json_encode(['count' => (int)$result]));

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
        $requestData = GetBillsInfoGroupedByRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var BillInfoRepository $repo */
        $repo = $this->getEm()->getRepository(BillInfo::class);

        $registers = $repo->getRegistersGroupedByClientAndFilter(
            $requestData->getLimit(),
            $requestData->getOffset(),
            $requestData->getFilter()
        );

        $manager = new Manager();
        $resource = new Collection($registers, new BillInfoGroupByClientItemTransformer());
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
    public function getBillsInfoGroupByCfdiUse(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetBillsTotalRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var BillInfoRepository $repo */
        $repo = $this->getEm()->getRepository(BillInfo::class);

        $registers = $repo->getRegistersGroupedByCfdiUseAndFilter($requestData->getFilter());

        $manager = new Manager();
        $resource = new Collection($registers, new BillInfoGroupByCfdiUseItemTransformer());
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
    public function getBillsInfoGroupByEmail(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetBillsTotalRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var BillInfoRepository $repo */
        $repo = $this->getEm()->getRepository(BillInfo::class);

        $registers = $repo->getRegistersGroupedByEmailAndFilter($requestData->getFilter());

        $manager = new Manager();
        $resource = new Collection($registers, new BillInfoGroupByEmailItemTransformer());
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
    public function getLastBillInfoEmailRegisters(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetLastRegistersRequestData::makeFromArray($request->getQueryParams());
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
    public function getLastBillInfoRegisters(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetLastRegistersRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var BillInfoRepository $repo */
        $repo = $this->getEm()->getRepository(BillInfo::class);

        $registers = $repo->getLastRegistersGroupedByBill($requestData->getLimit());

        // todo: cambiar transformer
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
     */
    public function getFilteredBillInfoRegisters(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetFilteredBillInfoRegistersRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var BillInfoRepository $repo */
        $repo = $this->getEm()->getRepository(BillInfo::class);

        $registers = $repo->getFilteredRegistersWithCfdiUseName(
            $requestData->getLimit(),
            $requestData->getOffset(),
            $requestData->getStartDatetimeObj(),
            $requestData->getEndDatetimeObj(),
            $requestData->getClientRfc(),
            $requestData->getInitialAmount(),
            $requestData->getFinalAmount(),
            $requestData->getFilterDateType()
        );

        $manager = new Manager();
        $resource = new Collection($registers, new BillInfoEntityWithCfdiUseNameTransformer());
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
        $requestData = GetFilteredBillInfoRegistersCountRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var BillInfoRepository $repo */
        $repo = $this->getEm()->getRepository(BillInfo::class);

        $result = $repo->getFilteredRegistersCount(
            $requestData->getStartDatetimeObj(),
            $requestData->getEndDatetimeObj(),
            $requestData->getClientRfc(),
            $requestData->getInitialAmount(),
            $requestData->getFinalAmount(),
            $requestData->getFilterDateType()
        );

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write(\json_encode(['count' => (int)$result]));

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \App\Exceptions\ValidationException
     */
    public function getBillInfoXls(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetFilteredBillInfoReportData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var BillInfoRepository $repo */
        $repo = $this->getEm()->getRepository(BillInfo::class);

        $headerStyle = ['halign' => 'center', 'fill' => '#43a0bf', 'border' => 'left,right,top,bottom', 'font-size' => 12, 'widths' => [30, 15, 30, 30, 35, 15]];
        $cellStyle = ['halign' => 'center', 'font-style' => 'bold', 'border' => 'left,right,top,bottom', 'font-size' => 14, 'height' => 20];

        $header = [
            'ID' => 'string',
            'EMAIL' => 'integer',
            'EMISOR' => 'string',
            'RFC' => 'string',
            'UUID' => 'string',
            'CODIGO USO CFDI' => 'string',
            'USO CFDI' => 'string',
            'SUBTOTAL' => 'price',
            'DISCOUNT' => 'price',
            'TOTAL' => 'price',
            'MONEDA' => 'string',
            'TIPO' => 'string',
            'TIPO DE PAGO' => 'string',
            'FECHA DE FACTURA' => 'datetime',
            'FECHA DE TIMBRADO' => 'datetime',
            'FECHA DE EMAIL' => 'datetime',
            'FECHA DE PROCESADO' => 'datetime',
            'ESTATUS DE TIMBRADO' => 'integer',
            'TIENE PDF' => 'integer'
        ];

        $sheetName = 'datos';

        $registers = $repo->getFilteredReportRegisters(
            $requestData->getStartDatetimeObj(),
            $requestData->getEndDatetimeObj(),
            $requestData->getClientRfc(),
            $requestData->getInitialAmount(),
            $requestData->getFinalAmount(),
            $requestData->getFilterDateType()
        );

        $writer = new XLSXWriter();
        $writer->writeSheetHeader($sheetName, $header, $headerStyle);

        $manager = new Manager();
        $resource = new Collection($registers, new BillInfoEntityWithCfdiUseNameTransformer());
        $data = $manager->createData($resource)->toJson();
        $data = json_decode($data, true);
        $values = array_values($data['data']);
        
        foreach ($data['data'] as $key) {
            $array = array_values($key);
            $writer->writeSheetRow($sheetName, $array);
        }

        $writer->writeToFile('file');

        # generate response
        $response = ResponseUtils::setXlsxFileResponse('file', 'filename.xlsx');

        # remove the file before exit
        //$this->localFilesystem->delete('filename.xls');

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface|\Zend\Diactoros\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function getBillInfoXml(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $filesDoneDir = $this->config['FILES_DONE_DIR'] ?? '';

        $billInfoId = $args['billInfoId'] ?? 0;

        /** @var BillInfo $register */
        $register = $this->em->find(BillInfo::class, $billInfoId);

        $filePath = $register->getFilesPath();
        $uuid = $register->getUuid();
        $baseDir = "{$filesDoneDir}{$filePath}/{$uuid}.xml";


        $response = ResponseUtils::setXmlFileResponse($baseDir, "{$uuid}.xml");
        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function getBillInfoPdf(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $filesDoneDir = $this->config['FILES_DONE_DIR'] ?? '';

        $billInfoId = $args['billInfoId'] ?? 0;

        $register = $this->em->find(BillInfo::class, $billInfoId);

        $filePath = $register->getFilesPath();
        $uuid = $register->getUuid();
        $baseDir = "{$filesDoneDir}{$filePath}/{$uuid}.pdf";

        $response = ResponseUtils::setPdfFileResponse($baseDir, "{$uuid}.pdf");
        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     * @throws ValidationException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function getBillInfoTaxes(ServerRequestInterface $request, ResponseInterface $response, array $args) {
        $billInfoId = $args['billInfoId'] ?? 0;

        $register = $this->em->find(BillInfo::class, $billInfoId);

        if (!$register)
            throw new ValidationException('The requested register does not exists');

        $taxes = $register->getTaxes()->toArray();

        $manager = new Manager();
        $resource = new Collection($taxes, new BillInfoTaxTransformer());
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
    public function getBillInfoTransferTotal(ServerRequestInterface $request, ResponseInterface $response){
        $requestData = GetBillsTotalRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var BillInfoRepository $repo */
        $repo = $this->getEm()->getRepository(BillInfo::class); 

        $total = $repo->getTransferTaxesTotalByFilter($requestData->getFilter());

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
    public function getBillInfoWithheldTotal(ServerRequestInterface $request, ResponseInterface $response){
        $requestData = GetBillsTotalRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var BillInfoRepository $repo */
        $repo = $this->getEm()->getRepository(BillInfo::class); 

        $total = $repo->getWithheldTaxesTotalByFilter($requestData->getFilter());

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write(\json_encode(['total' => (float)$total]));

        return $response;     
    }
}