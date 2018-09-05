<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 5/09/18
 * Time: 02:10 PM
 */

namespace App\Transformers;


use App\Entities\Emitter;
use League\Fractal\TransformerAbstract;


/**
 * Class EmitterItemTransformer
 * @package App\Transformers
 */
class EmitterItemTransformer extends TransformerAbstract
{
    /**
     * @param Emitter $item
     * @return array
     */
    public function transform(Emitter $item)
    {
        return [
            'id' => $item->getId(),
            'name' => $item->getName(),
            'rfc' => $item->getRfc(),
            'email' => $item->getEmail(),
        ];
    }
}