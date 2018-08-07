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
 * Class BillInfoGroupByEmailItemTransformer
 * @package App\Transformers
 */
class BillInfoGroupByEmailItemTransformer extends TransformerAbstract
{
    /**
     * @param array $item
     * @return array
     */
    public function transform(array $item)
    {
        return [
            'id' => 0,
            'email' => $item['email'],
            'amount' => (float)$item['amount'],
        ];
    }
}