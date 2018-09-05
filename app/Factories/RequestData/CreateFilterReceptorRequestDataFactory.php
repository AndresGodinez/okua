<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 03:58 PM
 */

namespace App\Factories\RequestData;


use App\Models\RequestData\CreateFilterReceptorRequestData;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class CreateFilterReceptorRequestDataFactory
 * @package App\Factories\RequestData
 */
class CreateFilterReceptorRequestDataFactory
{
    /**
     * @param ServerRequestInterface $request
     * @return CreateFilterReceptorRequestData
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();

        $inst = new CreateFilterReceptorRequestData();

        $inst->setRfc($data['rfc'] ?? '');
        $inst->setValid($data['valid'] ?? -1);

        return $inst;
    }
}