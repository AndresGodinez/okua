<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 2/08/18
 * Time: 02:44 PM
 */

namespace App\Api;


use App\Entities\Cfdi;
use App\Exceptions\ValidationException;
use App\Models\CountGetCfdiGroupedByRequestData;
use App\Models\GetCfdiGroupedByRequestData;
use App\Models\GetCfdiTotalRequestData;
use App\Models\GetFilteredCfdiRegistersCountRequestData;
use App\Models\GetFilteredCfdiRegistersRequestData;
use App\Models\GetFilteredCfdiReportData;
use App\Models\GetLastRegistersRequestData;
use App\Repositories\CfdiRepository;
use App\Traits\EntityManagerViewTrait;
use App\Traits\LocalFilesystemViewTrait;
use App\Transformers\CfdiEmailItemTransformer;
use App\Transformers\CfdiEntityTransformer;
use App\Transformers\CfdiEntityWithCfdiUseNameTransformer;
use App\Transformers\CfdiGroupByCfdiUseItemTransformer;
use App\Transformers\CfdiGroupByClientItemTransformer;
use App\Transformers\CfdiGroupByEmailItemTransformer;
use App\Transformers\CfdiTaxTransformer;
use App\Utils\ResponseUtils;
use League\Flysystem\Filesystem;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use XLSXWriter;

/**
 * Class CfdiApiView
 * @package App\Api
 */
class CfdiApiView extends BaseApiView
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
    public function getCfdiTotal(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetCfdiTotalRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var CfdiRepository $repo */
        $repo = $this->getEm()->getRepository(Cfdi::class);

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
    public function getCfdiGroupByClientCount(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = CountGetCfdiGroupedByRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var CfdiRepository $repo */
        $repo = $this->getEm()->getRepository(Cfdi::class);

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
    public function getCfdiGroupByClient(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetCfdiGroupedByRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var CfdiRepository $repo */
        $repo = $this->getEm()->getRepository(Cfdi::class);

        $registers = $repo->getRegistersGroupedByClientAndFilter(
            $requestData->getLimit(),
            $requestData->getOffset(),
            $requestData->getFilter()
        );

        $manager = new Manager();
        $resource = new Collection($registers, new CfdiGroupByClientItemTransformer());
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
    public function getCfdiGroupByCfdiUse(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetCfdiTotalRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var CfdiRepository $repo */
        $repo = $this->getEm()->getRepository(Cfdi::class);

        $registers = $repo->getRegistersGroupedByCfdiUseAndFilter($requestData->getFilter());

        $manager = new Manager();
        $resource = new Collection($registers, new CfdiGroupByCfdiUseItemTransformer());
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
    public function getCfdiGroupByEmail(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetCfdiTotalRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var CfdiRepository $repo */
        $repo = $this->getEm()->getRepository(Cfdi::class);

        $registers = $repo->getRegistersGroupedByEmailAndFilter($requestData->getFilter());

        $manager = new Manager();
        $resource = new Collection($registers, new CfdiGroupByEmailItemTransformer());
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
    public function getLastCfdiEmailRegisters(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetLastRegistersRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var CfdiRepository $repo */
        $repo = $this->getEm()->getRepository(Cfdi::class);

        $registers = $repo->getLastRegistersGroupedByEmail($requestData->getLimit());

        $manager = new Manager();
        $resource = new Collection($registers, new CfdiEmailItemTransformer());
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
    public function getLastCfdiRegisters(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetLastRegistersRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var CfdiRepository $repo */
        $repo = $this->getEm()->getRepository(Cfdi::class);

        $registers = $repo->getLastRegistersGroupedByBill($requestData->getLimit());

        // todo: cambiar transformer
        $manager = new Manager();
        $resource = new Collection($registers, new CfdiEntityTransformer());
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
    public function getFilteredCfdiRegisters(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetFilteredCfdiRegistersRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var CfdiRepository $repo */
        $repo = $this->getEm()->getRepository(Cfdi::class);

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
        $resource = new Collection($registers, new CfdiEntityWithCfdiUseNameTransformer());
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
    public function getFilteredCfdiRegistersCount(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetFilteredCfdiRegistersCountRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var CfdiRepository $repo */
        $repo = $this->getEm()->getRepository(Cfdi::class);

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
    public function getCfdiXls(ServerRequestInterface $request, ResponseInterface $response)
    {
        $requestData = GetFilteredCfdiReportData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var CfdiRepository $repo */
        $repo = $this->getEm()->getRepository(Cfdi::class);

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
        $resource = new Collection($registers, new CfdiEntityWithCfdiUseNameTransformer());
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
    public function getCfdiXml(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $filesDoneDir = $this->config['FILES_DONE_DIR'] ?? '';

        $cfdiId = $args['CfdiId'] ?? 0;

        /** @var Cfdi $register */
        $register = $this->em->find(Cfdi::class, $cfdiId);

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
    public function getCfdiPdf(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $filesDoneDir = $this->config['FILES_DONE_DIR'] ?? '';

        $cfdiId = $args['CfdiId'] ?? 0;

        $register = $this->em->find(Cfdi::class, $cfdiId);

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
    public function getCfdiTaxes(ServerRequestInterface $request, ResponseInterface $response, array $args) {
        $cfdiId = $args['CfdiId'] ?? 0;

        $register = $this->em->find(Cfdi::class, $cfdiId);

        if (!$register)
            throw new ValidationException('The requested register does not exists');

        $taxes = $register->getTaxes()->toArray();

        $manager = new Manager();
        $resource = new Collection($taxes, new CfdiTaxTransformer());
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
    public function getCfdiTransferTotal(ServerRequestInterface $request, ResponseInterface $response){
        $requestData = GetCfdiTotalRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var CfdiRepository $repo */
        $repo = $this->getEm()->getRepository(Cfdi::class);

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
    public function getCfdiWithheldTotal(ServerRequestInterface $request, ResponseInterface $response){
        $requestData = GetCfdiTotalRequestData::makeFromArray($request->getQueryParams());
        $requestData->validate();

        /** @var CfdiRepository $repo */
        $repo = $this->getEm()->getRepository(Cfdi::class);

        $total = $repo->getWithheldTaxesTotalByFilter($requestData->getFilter());

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write(\json_encode(['total' => (float)$total]));

        return $response;     
    }
}