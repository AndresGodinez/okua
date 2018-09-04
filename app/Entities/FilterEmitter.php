<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 09:52 PM
 */

namespace App\Entities;


use App\Entities\Mappings\FilterEmitterMetadataBuilder;
use App\Utils\EntityUtils;
use Doctrine\ORM\Mapping\ClassMetadata;


/**
 * Class FilterEmitter
 * @package App\Entities
 */
class FilterEmitter
{
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new FilterEmitterMetadataBuilder();
        $builder($metadata);
    }

    /** @var null|int */
    private $id;

    /** @var null|string */
    private $rfc;

    /** @var null|int */
    private $valid = EntityUtils::REG_STATUS_ACTIVE;

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
     * @return int|null
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * @param int|null $valid
     */
    public function setValid(int $valid)
    {
        $this->valid = $valid;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return \sprintf("<FilterEmitter [id: %d, rfc: %s, valid: %d]>",
            $this->getId() ?? 0, $this->getRfc(), $this->getValid());
    }
}