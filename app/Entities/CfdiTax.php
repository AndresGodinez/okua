<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 26/07/18
 * Time: 11:45 AM
 */

namespace App\Entities;


use App\Entities\Mappings\CfdiTaxMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class CfdiTax
 * @package App\Entities
 */
class CfdiTax
{
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new CfdiTaxMetadataBuilder;
        $builder($metadata);
    }

    /** @var null|int */
    private $id;

    /** @var string */
    private $taxSatCode;

    /** @var string */
    private $type;

    /** @var null|string */
    private $taxFactor;

    /** @var float */
    private $taxRateFee;

    /** @var float */
    private $amount;    

    /** @var Cfdi */
    private $billInfo;

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
    public function getTaxSatCode()
    {
        return $this->taxSatCode;
    }

    /**
     * @param mixed $taxSatCode
     *
     * @return self
     */
    public function setTaxSatCode($taxSatCode)
    {
        $this->taxSatCode = $taxSatCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxFactor()
    {
        return $this->taxFactor;
    }

    /**
     * @param mixed $taxFactor
     *
     * @return self
     */
    public function setTaxFactor($taxFactor)
    {
        $this->taxFactor = $taxFactor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxRateFee()
    {
        return $this->taxRateFee;
    }

    /**
     * @param mixed $taxRateFee
     *
     * @return self
     */
    public function setTaxRateFee($taxRateFee)
    {
        $this->taxRateFee = $taxRateFee;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     *
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return Cfdi
     */
    public function getBillInfo()
    {
        return $this->billInfo;
    }

    /**
     * @param Cfdi $billInfo
     *
     * @return self
     */
    public function setBillInfo($billInfo)
    {
        $this->billInfo = $billInfo;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return \sprintf(
            "<CfdiTax [id: %d, taxSatCode: %s, type: %s, taxFactor: %s, taxRateFee: %f, amount: %f, billInfoId: %d]>",
            !!$this->getId() ? $this->getId() : 0,
            $this->getTaxSatCode(),
            $this->getType(),
            $this->getTaxFactor(),
            $this->getTaxRateFee(),
            $this->getAmount(),
            !!$this->getBillInfo() ? $this->getBillInfo()->getId() : 0
        );
    }
}