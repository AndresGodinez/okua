<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 03:58 PM
 */

namespace App\Factories\RequestData;


use App\Models\RequestData\UpdateAlertEmailResponseRequestData;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class UpdateAlertEmailResponseRequestDataFactory
 * @package App\Factories\RequestData
 */
class UpdateAlertEmailResponseRequestDataFactory
{
    /**
     * @param ServerRequestInterface $request
     * @return UpdateAlertEmailResponseRequestData
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();

        $inst = new UpdateAlertEmailResponseRequestData();

        $inst->setCode(isset($data['code']) ? (int)$data['code'] : -1);
        $inst->setInternalMsg($data['internalMsg'] ?? null);
        $inst->setEmailMsg($data['emailMsg'] ?? null);

        return $inst;
    }
}