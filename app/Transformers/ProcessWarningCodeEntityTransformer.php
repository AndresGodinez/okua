<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 2/08/18
 * Time: 06:23 PM
 */

namespace App\Transformers;


use App\Entities\BillInfoClient;
use League\Fractal\TransformerAbstract;

/**
 * Class BillInfoClientEntityTransformer
 * @package App\Transformers
 */
class BillInfoClientEntityTransformer extends TransformerAbstract
{
    /**
     * @param BillInfoClient $item
     * @return array
     */
    public function transform(BillInfoClient $item)
    {
        return [
            'emitterName' => $item->getEmitterName(),
            'emitterRfc' => $item->getEmitterRfc(),
        ];
    }
}