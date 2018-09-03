<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 2/08/18
 * Time: 06:23 PM
 */

namespace App\Transformers;


use League\Fractal\TransformerAbstract;

/**
 * Class CfdiGroupByCfdiUseItemTransformer
 * @package App\Transformers
 */
class CfdiGroupByCfdiUseItemTransformer extends TransformerAbstract
{
    /**
     * @param array $item
     * @return array
     */
    public function transform(array $item)
    {
        return [
            'id' => 0,
            'cfdiUseSatCode' => $item['cfdiUseSatCode'],
            'cfdiUseName' => $item['cfdiUseName'],
            'amount' => (float)$item['amount'],
        ];
    }
}