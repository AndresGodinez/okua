<?php

namespace App\Transformers;


use App\Entities\ProcessWarning;
use League\Fractal\TransformerAbstract;

/**
 * Class ProcessWarningItemTransformer
 * @package App\Transformers
 */
class ProcessWarningItemTransformer extends TransformerAbstract
{
    /**
     * @param ProcessWarning $item
     * @return array
     */
    public function transform(ProcessWarning $item)
    {
        return [
            'id' => (int)$item->getId(),
            'code' => $item->getCode(),
            'description' => $item->getDescription(),
            'email' => $item->getEmail(),
            'emailDatetime' => $item->getEmailDatetime()->format('Y-m-d H:i:s'),
            'regDatetime' => $item->getRegDatetime()->format('Y-m-d H:i:s'),
            'cfdiId' => (int)$item->getCfdiId(),
        ];
    }
}