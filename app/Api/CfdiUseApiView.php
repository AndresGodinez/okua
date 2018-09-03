<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/08/18
 * Time: 04:15 PM
 */

namespace App\Api;


use App\Entities\CfdiEmitter;
use App\Traits\EntityManagerViewTrait;
use App\Transformers\CfdiEmitterEntityTransformer;
use App\Utils\ResponseUtils;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class CfdiUseApiView
 * @package App\Api
 */
class CfdiUseApiView extends BaseApiView
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

        $repo = $this->em->getRepository(CfdiEmitter::class);
        $registers = $repo->findAll();

        $manager = new Manager();
        $resource = new Collection($registers, new CfdiEmitterEntityTransformer());
        $data = $manager->createData($resource)->toJson();

        ResponseUtils::addContentTypeJsonHeader($response);
        $response->getBody()->write($data);

        return $response;
    }
}