<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 2/08/18
 * Time: 01:43 PM
 */

namespace App\Models;


/**
 * Class CfdiEmitterFilter
 * @package App\Models
 */
class CfdiEmitterFilter
{
    /** @var string */
    protected $code;

    /** @var string */
    protected $name;

    /**
     * CfdiEmitterFilter constructor.
     * @param $code
     * @param $name
     */
    public function __construct($code, $name)
    {
        $this->code = $code;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getName(): string
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
    public function __toString()
    {
        return \sprintf("<CfdiEmitterFilter [code: %s, name: %s]>", $this->code, $this->name);
    }
}