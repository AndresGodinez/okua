<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 05:50 PM
 */

namespace App\Models\RequestData;


/**
 * Class UpdateFilterReceptorRequestData
 * @package App\Models\RequestData
 */
class UpdateFilterReceptorRequestData extends FilterReceptorRequestData
{
    /**
     * @return string
     */
    public function __toString()
    {
        return \sprintf("<UpdateFilterReceptorRequestData [rfc: %s, valid: %d]>",
            $this->rfc, $this->valid);
    }
}