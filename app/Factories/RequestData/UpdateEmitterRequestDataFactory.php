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
use App\Models\RequestData\UpdateEmitterRequestData;
use App\Models\RequestData\UpdateEmailServiceConfigRequestData;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class UpdateEmitterRequestDataFactory
 * @package App\Factories\RequestData
 */
class UpdateEmitterRequestDataFactory
{
    /**
     * @param ServerRequestInterface $request
     * @return UpdateEmitterRequestData
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();

        $inst = new UpdateEmitterRequestData();

        $inst->setName(isset($data['name']) ?? '');
        $inst->setRfc($data['rfc'] ?? '');
        $inst->setEmail($data['email'] ?? '');

        return $inst;
    }
}