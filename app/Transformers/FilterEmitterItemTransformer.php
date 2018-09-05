<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 5/09/18
 * Time: 02:10 PM
 */

namespace App\Transformers;


use App\Entities\FilterEmitter;
use League\Fractal\TransformerAbstract;


/**
 * Class FilterEmitterItemTransformer
 * @package App\Transformers
 */
class FilterEmitterItemTransformer extends TransformerAbstract
{
    /**
     * @param FilterEmitter $item
     * @return array
     */
    public function transform(FilterEmitter $item)
    {
        return [
            'id' => (int)$item->getId(),
            'rfc' => $item->getRfc(),
            'valid' => (int)$item->getValid(),
        ];
    }
}