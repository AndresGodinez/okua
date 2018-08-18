<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/08/18
 * Time: 04:15 PM
 */

namespace App\Api;


use App\Entities\BillInfoClient;
use App\Traits\EntityManagerViewTrait;
use App\Transformers\BillInfoClientEntityTransformer;
use App\Utils\ResponseUtils;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class BillInfoCfdiUseApiView
 * @package App\Api
 */
class BillInfoCfdiUseApiView extends BaseApiView
{
    use EntityManagerViewTrait;

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function getRegistersOrderedByName(ServerRequestInterface $request, ResponseInterface $response)
    {
        ResponseUtils::addContentTypeJsonHeader($response);

        $repo = $this->em->getRepository(BillInfoClient::class);
        $registers = $repo->findAll();

        $manager = new Manager();
        $resource = new Collection($registers, new BillInfoClientEntityTransformer());
        $data = $manager->createData($resource)->toJson();

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write($data);

        return $response;
    }
}