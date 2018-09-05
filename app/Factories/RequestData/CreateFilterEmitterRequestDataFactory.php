<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 03:58 PM
 */

namespace App\Factories\RequestData;


use App\Models\RequestData\CreateFilterEmitterRequestData;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class CreateFilterEmitterRequestDataFactory
 * @package App\Factories\RequestData
 */
class CreateFilterEmitterRequestDataFactory
{
    /**
     * @param ServerRequestInterface $request
     * @return CreateFilterEmitterRequestData
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();

        $inst = new CreateFilterEmitterRequestData();

        $inst->setRfc($data['rfc'] ?? '');
        $inst->setValid($data['valid'] ?? -1);

        return $inst;
    }
}