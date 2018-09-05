<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 5/09/18
 * Time: 02:10 PM
 */

namespace App\Transformers;


use App\Entities\FilterReceptor;
use League\Fractal\TransformerAbstract;


/**
 * Class FilterReceptorItemTransformer
 * @package App\Transformers
 */
class FilterReceptorItemTransformer extends TransformerAbstract
{
    /**
     * @param FilterReceptor $item
     * @return array
     */
    public function transform(FilterReceptor $item)
    {
        return [
            'id' => (int)$item->getId(),
            'rfc' => $item->getRfc(),
            'valid' => (int)$item->getValid(),
        ];
    }
}