<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 2/08/18
 * Time: 06:23 PM
 */

namespace App\Transformers;


use App\Entities\Cfdi;
use League\Fractal\TransformerAbstract;

/**
 * Class CfdiEmailItemTransformer
 * @package App\Transformers
 */
class CfdiEmailItemTransformer extends TransformerAbstract
{
    /**
     * @param array $item
     * @return array
     */
    public function transform(array $item)
    {
        return [
            'email' => $item['email'],
            'emailDatetime' => $item['emailDatetime']->format('Y-m-d H:i:s'),
        ];
    }
}