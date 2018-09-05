<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 05:50 PM
 */

namespace App\Models\RequestData;


/**
 * Class CreateFilterEmitterRequestData
 * @package App\Models\RequestData
 */
class CreateFilterEmitterRequestData extends FilterEmitterRequestData
{
    /**
     * @return string
     */
    public function __toString()
    {
        return \sprintf("<CreateFilterEmitterRequestData [rfc: %s, valid: %d]>",
            $this->rfc, $this->valid);
    }
}