<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 03:58 PM
 */

namespace App\Factories\RequestData;


use App\Entities\AlertEmailResponse;
use App\Models\RequestData\CreateAlertEmailResponseRequestData;
use App\Models\RequestData\CreateEmitterRequestData;
use App\Models\RequestData\UpdateEmailServiceConfigRequestData;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class CreateEmitterRequestDataFactory
 * @package App\Factories\RequestData
 */
class CreateEmitterRequestDataFactory
{
    /**
     * @param ServerRequestInterface $request
     * @return CreateEmitterRequestData
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();

        $inst = new CreateEmitterRequestData();

        $inst->setName(isset($data['name']) ?? '');
        $inst->setRfc($data['rfc'] ?? '');
        $inst->setEmail($data['email'] ?? '');

        return $inst;
    }
}