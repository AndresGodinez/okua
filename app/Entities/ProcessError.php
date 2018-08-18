<?php
/**
* Diego
*/

namespace App\Entities;

use App\Entities\Mappings\ProcessErrorMetadataBuilder;
use App\Utils\EntityUtils;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ClassMetadata;

class ProcessError {

	/**
	* @param ClassMetadata $metadata
	*/

	public static function loadMetadata(ClassMetadata $metadata){
		$builder = new ProcessErrorMetadataBuilder();
		$builder($metadata);
	}

	/** @var null|int */
	private $id;

	/** @var null|string */
	private $code;

	/** @var null|string */
	private $description;

	/** @var null|string */
	private $email;

	/** @var null|\DateTime */
	private $emailDatetime;

	/** @var null|\DateTime */
	private $regDatetime;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     *
     * @return self
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmailDatetime()
    {
        return $this->emailDatetime;
    }

    /**
     * @param mixed $emailDatetime
     *
     * @return self
     */
    public function setEmailDatetime($emailDatetime)
    {
        $this->emailDatetime = $emailDatetime;

        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getRegDatetime()
    {
        return $this->regDatetime;
    }

    /**
     * @param mixed $regDatetime
     *
     * @return self
     */
    public function setRegDatetime($regDatetime)
    {
        $this->regDatetime = $regDatetime;

        return $this;
    }
}
