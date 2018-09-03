<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/08/18
 * Time: 04:32 PM
 */

namespace App\Entities;


use App\Entities\Mappings\CfdiEmitterMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class CfdiEmitter
 * @package App\Entities
 */
class CfdiEmitter
{
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new CfdiEmitterMetadataBuilder();
        $builder($metadata);
    }

    /** @var string */
    protected $emitterName = '';

    /** @var string */
    protected $emitterRfc = '';

    /**
     * CfdiEmitter constructor.
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
        return \sprintf("<CfdiEmitter [emitterName: %s, emitterRfc: %s]>", $this->emitterName, $this->emitterRfc);
    }
}