<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 03:58 PM
 */

namespace App\Factories\RequestData;


use App\Models\RequestData\UpdateEmailServiceConfigRequestData;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class UpdateEmailServiceConfigRequestDataFactory
 * @package App\Factories\RequestData
 */
class UpdateEmailServiceConfigRequestDataFactory
{
    /**
     * @param ServerRequestInterface $request
     * @return UpdateEmailServiceConfigRequestData
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();

        $inst = new UpdateEmailServiceConfigRequestData();

        $inst->setHostname($data['hostname'] ?? '');
        $inst->setInboxName($data['inboxName'] ?? 'INBOX');
        $inst->setUsername($data['username'] ?? '');
        $inst->setPswd($data['pswd'] ?? '');
        $inst->setTagOk($data['tagOk'] ?? 'Processed');
        $inst->setTagIssue($data['tagIssue'] ?? 'Issues');

        return $inst;
    }
}