<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 03:58 PM
 */

namespace App\Factories\RequestData;


use App\Models\RequestData\UpdateFilterEmitterRequestData;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class UpdateFilterEmitterRequestDataFactory
 * @package App\Factories\RequestData
 */
class UpdateFilterEmitterRequestDataFactory
{
    /**
     * @param ServerRequestInterface $request
     * @return UpdateFilterEmitterRequestData
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();

        $inst = new UpdateFilterEmitterRequestData();

        $inst->setRfc($data['rfc'] ?? '');
        $inst->setValid($data['valid'] ?? -1);

        return $inst;
    }
}