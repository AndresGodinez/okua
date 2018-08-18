<?php

namespace App\Transformers;


use App\Entities\ProcessError;
use League\Fractal\TransformerAbstract;

/**
 * Class ProcessErrorItemTransformer
 * @package App\Transformers
 */
class ProcessErrorItemTransformer extends TransformerAbstract
{
    /**
     * @param ProcessError $item
     * @return array
     */
    public function transform(ProcessError $item)
    {
        return [
            'id' => (int)$item->getId(),
            'code' => $item->getCode(),
            'description' => $item->getDescription(),
            'email' => $item->getEmail(),
            'emailDatetime' => $item->getEmailDatetime()->format('Y-m-d H:i:s'),
        ];
    }
}