<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 07:39 PM
 */

namespace App\Transformers;


use App\Entities\AlertEmailResponse;
use League\Fractal\TransformerAbstract;


/**
 * Class AlertEmailResponseItemTransformer
 * @package App\Transformers
 */
class AlertEmailResponseItemTransformer extends TransformerAbstract
{
    /**
     * @param AlertEmailResponse $item
     * @return array
     */
    public function transform(AlertEmailResponse $item)
    {
        return [
            'id' => (int)$item->getId(),
            'code' => (int)$item->getCode(),
            'internalMsg' => $item->getInternalMsg(),
            'emailMsg' => $item->getEmailMsg(),
        ];
    }
}