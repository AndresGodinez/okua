<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 2/08/18
 * Time: 06:23 PM
 */

namespace App\Transformers;


use League\Fractal\TransformerAbstract;
use App\Entities\BillInfoTax;
/**
 * Class BillInfoTaxTransformer
 * @package App\Transformers
 */
class BillInfoTaxTransformer extends TransformerAbstract
{
    /**
     * @param array $item
     * @return array
     */
    public function transform(BillInfoTax $item)
    {
        return [
            'id' => (int)$item->getId(),
            'taxSatCode' => $item->getTaxSatCode(),
            'type' => $item->getType(),
            'taxFactor' => $item->getTaxFactor(),
            'taxRateFee' => $item->getTaxRateFee(),
            'amount' => (float)$item->getAmount(),
        ];
    }
}