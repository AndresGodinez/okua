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
 * Class EmitterRequestData
 * @package App\Models\RequestData
 */
class EmitterRequestData implements IValidableRequest
{
    /** @var string */
    protected $name = '';

    /** @var string */
    protected $rfc = '';

    /** @var string */
    protected $email = '';

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

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
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }
    
    /**
     * @throws ValidationException
     */
    public function validate()
    {
        if (!$this->name || !$this->rfc || !$this->email) {
            throw new ValidationException('Invalid request parameters');
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return \sprintf("<EmitterRequestData [name: %s, rfc: %s, email: %s]>",
            $this->name, $this->rfc, $this->email);
    }
}