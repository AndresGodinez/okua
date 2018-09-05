<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 05:50 PM
 */

namespace App\Models\RequestData;


/**
 * Class UpdateAlertEmailResponseRequestData
 * @package App\Models\RequestData
 */
class UpdateAlertEmailResponseRequestData extends AlertEmailResponseRequestData
{
    /**
     * @return string
     */
    public function __toString()
    {
        return \sprintf("<UpdateAlertEmailResponseRequestData [code: %d, internalMsg: %s, emailMsg: %s]>",
            $this->code, $this->internalMsg, $this->emailMsg);
    }
}