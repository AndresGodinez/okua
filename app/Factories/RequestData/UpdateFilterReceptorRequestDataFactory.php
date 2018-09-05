<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 03:58 PM
 */

namespace App\Factories\RequestData;


use App\Models\RequestData\UpdateFilterReceptorRequestData;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class UpdateFilterReceptorRequestDataFactory
 * @package App\Factories\RequestData
 */
class UpdateFilterReceptorRequestDataFactory
{
    /**
     * @param ServerRequestInterface $request
     * @return UpdateFilterReceptorRequestData
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();

        $inst = new UpdateFilterReceptorRequestData();

        $inst->setRfc($data['rfc'] ?? '');
        $inst->setValid($data['valid'] ?? -1);

        return $inst;
    }
}