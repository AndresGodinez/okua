<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 05:50 PM
 */

namespace App\Models\RequestData;


/**
 * Class CreateFilterReceptorRequestData
 * @package App\Models\RequestData
 */
class CreateFilterReceptorRequestData extends FilterReceptorRequestData
{
    /**
     * @return string
     */
    public function __toString()
    {
        return \sprintf("<CreateFilterReceptorRequestData [rfc: %s, valid: %d]>",
            $this->rfc, $this->valid);
    }
}