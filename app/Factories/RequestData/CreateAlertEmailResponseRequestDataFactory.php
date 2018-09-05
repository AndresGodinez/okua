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
use App\Models\RequestData\UpdateEmailServiceConfigRequestData;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class CreateAlertEmailResponseRequestDataFactory
 * @package App\Factories\RequestData
 */
class CreateAlertEmailResponseRequestDataFactory
{
    /**
     * @param ServerRequestInterface $request
     * @return CreateAlertEmailResponseRequestData
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();

        $inst = new CreateAlertEmailResponseRequestData();

        $inst->setCode(isset($data['code']) ? (int)$data['code'] : -1);
        $inst->setInternalMsg($data['internalMsg'] ?? null);
        $inst->setEmailMsg($data['emailMsg'] ?? null);

        return $inst;
    }
}