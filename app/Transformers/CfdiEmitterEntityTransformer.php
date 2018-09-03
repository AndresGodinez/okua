<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 2/08/18
 * Time: 06:23 PM
 */

namespace App\Transformers;


use App\Entities\CfdiEmitter;
use League\Fractal\TransformerAbstract;

/**
 * Class BillInfoClientEntityTransformer
 * @package App\Transformers
 */
class CfdiEmitterEntityTransformer extends TransformerAbstract
{
    /**
     * @param CfdiEmitter $item
     * @return array
     */
    public function transform(CfdiEmitter $item)
    {
        return [
            'emitterName' => $item->getEmitterName(),
            'emitterRfc' => $item->getEmitterRfc(),
        ];
    }
}