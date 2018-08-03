<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 26/07/18
 * Time: 11:45 AM
 */

namespace App\Entities;


use App\Entities\Mappings\UserMetadataBuilder;
use App\Utils\EntityUtils;
use DateTime;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class User
 * @package App\Entities
 */
class User
{
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new UserMetadataBuilder;
        $builder($metadata);
    }

    /** @var null|int */
    private $id;

    /** @var null|string */
    private $name;

    /** @var null|string */
    private $username;

    /** @var null|string */
    private $email;

    /** @var null|string */
    private $pswd;

    /** @var null|DateTime */
    private $regCreationDate;

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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param null|string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
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
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return null|string
     */
    public function getPswd()
    {
        return $this->pswd;
    }

    /**
     * @param null|string $pswd
     */
    public function setPswd($pswd)
    {
        $this->pswd = $pswd;
    }

    /**
     * @return DateTime|null
     */
    public function getRegCreationDate()
    {
        return $this->regCreationDate;
    }

    /**
     * @param DateTime|null $regCreationDate
     */
    public function setRegCreationDate($regCreationDate)
    {
        $this->regCreationDate = $regCreationDate;
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
            '<User [id: %d, name: %s, username: %s, email: %s, pswd: %s, regCreationDate: %s, regStatus: %d]>',
            !!$this->getId() ? $this->getId() : 0,
            $this->getName(),
            $this->getUsername(),
            $this->getEmail(),
            $this->getPswd(),
            $this->getRegCreationDate(),
            $this->getRegStatus()
        );
    }
}