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
 * Class FilterEmitterRequestData
 * @package App\Models\RequestData
 */
class FilterEmitterRequestData implements IValidableRequest
{
    /** @var string */
    protected $rfc = '';

    /** @var int */
    protected $valid = 1;

    /**
     * @return string
     */
    public function getRfc()
    {
        return $this->rfc;
    }

    /**
     * @param string $rfc
     */
    public function setRfc(string $rfc)
    {
        $this->rfc = $rfc;
    }

    /**
     * @return int
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * @param int $valid
     */
    public function setValid(int $valid)
    {
        $this->valid = $valid;
    }
    
    /**
     * @throws ValidationException
     */
    public function validate()
    {
        if (!$this->rfc || ($this->valid != 1 && $this->valid != 0)) {
            throw new ValidationException('Invalid request parameters');
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return \sprintf("<FilterEmitterRequestData [rfc: %s, valid: %d]>",
            $this->rfc, $this->valid);
    }
}