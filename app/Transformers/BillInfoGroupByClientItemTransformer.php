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
 * Class BillInfoGroupByClientItemTransformer
 * @package App\Transformers
 */
class BillInfoGroupByClientItemTransformer extends TransformerAbstract
{
    /**
     * @param array $item
     * @return array
     */
    public function transform(array $item)
    {
        return [
            'id' => 0,
            'clientName' => $item['emitterName'],
            'clientRfc' => $item['emitterRfc'],
            'amount' => (float)$item['amount'],
        ];
    }
}