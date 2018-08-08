<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 26/07/18
 * Time: 11:45 AM
 */

namespace App\Entities;


use App\Entities\Mappings\CfdiUseMetadataBuilder;
use App\Utils\EntityUtils;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class CfdiUse
 * @package App\Entities
 */
class CfdiUse
{
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new CfdiUseMetadataBuilder;
        $builder($metadata);
    }

    /** @var null|int */
    private $id;

    /** @var null|string */
    private $name;

    /** @var null|string */
    private $satCode;

    /** @var int */
    private $regStatus = EntityUtils::REG_STATUS_ACTIVE;

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
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getSatCode()
    {
        return $this->satCode;
    }

    /**
     * @param null|string $satCode
     */
    public function setSatCode($satCode)
    {
        $this->satCode = $satCode;
    }

    /**
     * @return int
     */
    public function getRegStatus()
    {
        return $this->regStatus;
    }

    /**
     * @param int $regStatus
     */
    public function setRegStatus($regStatus)
    {
        $this->regStatus = $regStatus;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return \sprintf(
            '<CfdiUse [id: %d, name: %s, satCode: %s, regStatus: %d]>',
            !!$this->getId() ? $this->getId() : 0,
            $this->getName(),
            $this->getSatCode(),
            $this->getRegStatus()
        );
    }
}