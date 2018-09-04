<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 07:28 PM
 */

namespace App\Entities;


use App\Entities\Mappings\AlertEmailResponseMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;


/**
 * Class AlertEmailResponse
 * @package App\Entities
 */
class AlertEmailResponse
{
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new AlertEmailResponseMetadataBuilder;
        $builder($metadata);
    }

    /** @var null|int */
    protected $id;

    /** @var int */
    protected $code = 0;

    /** @var null|string */
    protected $internalMsg;

    /** @var null|string */
    protected $emailMsg;

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

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
    public function setInternalMsg(string $internalMsg)
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
    public function setEmailMsg(string $emailMsg)
    {
        $this->emailMsg = $emailMsg;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return \sprintf("<AlertEmailResponse [id: %d, code: %d, internalMsg: %s, emailMsg: %s]>",
            $this->getId() ?? 0,
                $this->getCode(),
                $this->getInternalMsg(),
                $this->getEmailMsg()
            );
    }
}