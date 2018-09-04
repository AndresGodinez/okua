<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 08:46 PM
 */

namespace App\Entities;


use App\Entities\Mappings\TmpEmitterMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;


/**
 * Class TmpEmitter
 * @package App\Entities
 */
class TmpEmitter
{
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new TmpEmitterMetadataBuilder();
        $builder($metadata);
    }

    /** @var null|int */
    private $id;

    /** @var null|string */
    private $name;

    /** @var null|string */
    private $rfc;

    /** @var null|string */
    private $email;

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
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getRfc()
    {
        return $this->rfc;
    }

    /**
     * @param null|string $rfc
     */
    public function setRfc(string $rfc)
    {
        $this->rfc = $rfc;
    }

    /**
     * @return null|string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return \sprintf("<TmpEmitter [id: %d, name: %s, rfc: %s, email: %s]>",
            $this->getId() ?? 0,
            $this->getName(),
            $this->getRfc(),
            $this->getEmail()
        );
    }
}