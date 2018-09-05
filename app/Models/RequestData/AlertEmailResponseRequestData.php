<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 05:50 PM
 */

namespace App\Models\RequestData;
use App\Exceptions\ValidationException;
use App\Interfaces\IValidableRequest;


/**
 * Class AlertEmailResponseRequestData
 * @package App\Models\RequestData
 */
class AlertEmailResponseRequestData implements IValidableRequest
{
    /** @var int */
    protected $code = 0;

    /** @var string */
    protected $internalMsg = '';

    /** @var string */
    protected $emailMsg = '';

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code)
    {
        $this->code = $code;
    }

    /**
     * @return null|string
     */
    public function getInternalMsg()
    {
        return $this->internalMsg;
    }

    /**
     * @param null|string $internalMsg
     */
    public function setInternalMsg($internalMsg)
    {
        $this->internalMsg = $internalMsg;
    }

    /**
     * @return null|string
     */
    public function getEmailMsg()
    {
        return $this->emailMsg;
    }

    /**
     * @param null|string $emailMsg
     */
    public function setEmailMsg($emailMsg)
    {
        $this->emailMsg = $emailMsg;
    }

    /**
     * @throws ValidationException
     */
    public function validate()
    {
        if (!$this->code || $this->internalMsg === null || $this->emailMsg === null) {
            throw new ValidationException('Invalid request parameters');
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return \sprintf("<AlertEmailResponseRequestData [code: %d, internalMsg: %s, emailMsg: %s]>",
            $this->code, $this->internalMsg, $this->emailMsg);
    }
}