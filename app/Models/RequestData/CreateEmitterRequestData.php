<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 05:50 PM
 */

namespace App\Models\RequestData;


/**
 * Class CreateEmitterRequestData
 * @package App\Models\RequestData
 */
class CreateEmitterRequestData extends EmitterRequestData
{
    /**
     * @return string
     */
    public function __toString()
    {
        return \sprintf("<CreateEmitterRequestData [name: %s, rfc: %s, email: %s]>",
            $this->name, $this->rfc, $this->email);
    }
}