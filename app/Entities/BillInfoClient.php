<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/08/18
 * Time: 04:32 PM
 */

namespace App\Entities;


use App\Entities\Mappings\BillInfoClientMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class BillInfoClient
 * @package App\Entities
 */
class BillInfoClient
{
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new BillInfoClientMetadataBuilder();
        $builder($metadata);
    }

    /** @var string */
    protected $emitterName = '';

    /** @var string */
    protected $emitterRfc = '';

    /**
     * BillInfoClient constructor.
     * @param string $emitterName
     * @param string $emitterRfc
     */
    public function __construct(string $emitterName, string $emitterRfc)
    {
        $this->emitterName = $emitterName;
        $this->emitterRfc = $emitterRfc;
    }

    /**
     * @return string
     */
    public function getEmitterName()
    {
        return $this->emitterName;
    }

    /**
     * @param string $emitterName
     */
    public function setEmitterName($emitterName)
    {
        $this->emitterName = $emitterName;
    }

    /**
     * @return string
     */
    public function getEmitterRfc()
    {
        return $this->emitterRfc;
    }

    /**
     * @param string $emitterRfc
     */
    public function setEmitterRfc($emitterRfc)
    {
        $this->emitterRfc = $emitterRfc;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return \sprintf("<BillInfoClient [emitterName: %s, emitterRfc: %s]>", $this->emitterName, $this->emitterRfc);
    }
}