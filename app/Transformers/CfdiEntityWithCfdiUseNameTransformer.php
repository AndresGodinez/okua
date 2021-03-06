<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 2/08/18
 * Time: 08:50 PM
 */

namespace App\Transformers;


use App\Entities\Cfdi;
use League\Fractal\TransformerAbstract;

/**
 * Class CfdiEntityWithCfdiUseNameTransformer
 * @package App\Transformers
 */
class CfdiEntityWithCfdiUseNameTransformer extends TransformerAbstract
{
    /**
     * @param array $itemArr
     * @return array
     */
    public function transform(array $itemArr)
    {
        /** @var Cfdi $item */
        $item = $itemArr[0];
        $cfdiUseName = $itemArr['cfdiUseName'] ?? null;

        return [
            'id' => (int)$item->getId(),
            'email' => $item->getEmail(),
            'emitterName' => $item->getEmitterName(),
            'emitterRfc' => $item->getEmitterRfc(),
            'uuid' => $item->getUuid(),
            'cfdiUseSatCode' => $item->getCfdiUseSatCode(),
            'cfdiUseName' => $cfdiUseName,
            'subtotal' => (float)$item->getSubtotal(),
            'discount' => (float)$item->getDiscount(),
            'total' => (float)$item->getTotal(),
            'currency' => $item->getCurrency(),
            'type' => $item->getType(),
            'paymentType' => $item->getPaymentType(),
            'documentDatetime' => $item->getDocumentDatetime()->format('Y-m-d H:i:s'),
            'stampDatetime' => $item->getStampDatetime()->format('Y-m-d H:i:s'),
            'emailDatetime' => $item->getEmailDatetime()->format('Y-m-d H:i:s'),
            'regDatetime' => $item->getRegDatetime()->format('Y-m-d H:i:s'),
            'stampStatus' => (int)$item->getStampStatus(),
            'hasPdf' => (int)$item->getHasPdf(),
        ];
    }
}