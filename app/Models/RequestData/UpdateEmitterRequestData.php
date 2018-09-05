<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 05:50 PM
 */

namespace App\Models\RequestData;


/**
 * Class UpdateEmitterRequestData
 * @package App\Models\RequestData
 */
class UpdateEmitterRequestData extends EmitterRequestData
{
    /**
     * @return string
     */
    public function __toString()
    {
        return \sprintf("<UpdateEmitterRequestData [name: %s, rfc: %s, email: %s]>",
            $this->name, $this->rfc, $this->email);
    }
}