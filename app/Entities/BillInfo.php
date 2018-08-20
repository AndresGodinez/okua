<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 30/07/18
 * Time: 03:48 PM
 */

namespace App\Entities;


use App\Entities\Mappings\BillInfoMetadataBuilder;
use App\Utils\EntityUtils;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ClassMetadata;

class BillInfo
{
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new BillInfoMetadataBuilder();
        $builder($metadata);
    }

    /** @var null|int */
    private $id;

    /** @var null|string */
    private $email;

    /** @var null|string */
    private $emitterName;

    /** @var null|string */
    private $emitterRfc;

    /** @var null|string */
    private $uuid;

    /** @var null|string */
    private $cfdiUseSatCode;

    /** @var null|float */
    private $subtotal;

    /** @var null|float */
    private $discount;

    /** @var null|float */
    private $total;

    /** @var null|string */
    private $currency;

    /** @var null|string */
    private $type;

    /** @var null|string */
    private $paymentType;

    /** @var null|\DateTime */
    private $documentDatetime;

    /** @var null|\DateTime */
    private $stampDatetime;

    /** @var null|\DateTime */
    private $emailDatetime;

    /** @var null|\DateTime */
    private $regDatetime;

    /** @var string */
    private $filesPath = '';

    /** @var ArrayCollection */
    private $taxes;

    /** @var float */
    private $transferTaxes;

    /** @var float */
    private $withheldTaxes;

    /** @var int */
    private $stampStatus = EntityUtils::STAMP_STATUS_NOT_DEFINED;

    /** @var int */
    private $hasPdf = 1;

    public function __construct() {
        $this->taxes = new ArrayCollection();
    }

    /**
     * @param BillInfoTax $tax
     * @return bool
     */
    public function addTax(BillInfoTax $tax)
    {
        if (!$this->taxes) {
            $this->taxes = new ArrayCollection();
        }
        return $this->taxes->add($tax);
    }

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
    public function getEmitterName()
    {
        return $this->emitterName;
    }

    /**
     * @param null|string $emitterName
     */
    public function setEmitterName($emitterName)
    {
        $this->emitterName = $emitterName;
    }

    /**
     * @return null|string
     */
    public function getEmitterRfc()
    {
        return $this->emitterRfc;
    }

    /**
     * @param null|string $emitterRfc
     */
    public function setEmitterRfc($emitterRfc)
    {
        $this->emitterRfc = $emitterRfc;
    }

    /**
     * @return null|string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param null|string $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return null|string
     */
    public function getCfdiUseSatCode()
    {
        return $this->cfdiUseSatCode;
    }

    /**
     * @param null|string $cfdiUseSatCode
     */
    public function setCfdiUseSatCode($cfdiUseSatCode)
    {
        $this->cfdiUseSatCode = $cfdiUseSatCode;
    }

    /**
     * @return float|null
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * @param float|null $subtotal
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;
    }

    /**
     * @return float|null
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param float|null $discount
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

    /**
     * @return float|null
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param float|null $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return null|string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param null|string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return null|string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param null|string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return null|string
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @param null|string $paymentType
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;
    }

    /**
     * @return \DateTime|null
     */
    public function getDocumentDatetime()
    {
        return $this->documentDatetime;
    }

    /**
     * @param \DateTime|null $documentDatetime
     */
    public function setDocumentDatetime($documentDatetime)
    {
        $this->documentDatetime = $documentDatetime;
    }

    /**
     * @return \DateTime|null
     */
    public function getStampDatetime()
    {
        return $this->stampDatetime;
    }

    /**
     * @param \DateTime|null $stampDatetime
     */
    public function setStampDatetime($stampDatetime)
    {
        $this->stampDatetime = $stampDatetime;
    }

    /**
     * @return \DateTime|null
     */
    public function getEmailDatetime()
    {
        return $this->emailDatetime;
    }

    /**
     * @param \DateTime|null $emailDatetime
     */
    public function setEmailDatetime($emailDatetime)
    {
        $this->emailDatetime = $emailDatetime;
    }

    /**
     * @return \DateTime|null
     */
    public function getRegDatetime()
    {
        return $this->regDatetime;
    }

    /**
     * @param \DateTime|null $regDatetime
     */
    public function setRegDatetime($regDatetime)
    {
        $this->regDatetime = $regDatetime;
    }

    /**
     * @return string
     */
    public function getFilesPath()
    {
        return $this->filesPath;
    }

    /**
     * @param string $filesPath
     */
    public function setFilesPath($filesPath)
    {
        $this->filesPath = $filesPath;
    }

    /**
     * @return mixed
     */
    public function getTaxes()
    {
        return $this->taxes;
    }

    /**
     * @param mixed $taxes
     *
     * @return self
     */
    public function setTaxes($taxes)
    {
        $this->taxes = $taxes;

        return $this;
    }

    public function getTransferTaxes(){
        return $this->transferTaxes;
    }

    public function setTransferTaxes($transferTaxes){
        $this->transferTaxes = $transferTaxes;

        return $this;
    }

    public function getWithheldTaxes(){
        return $this->withheldTaxes;
    }

    public function setWithheldTaxes($withheldTaxes){
        $this->withheldTaxes = $withheldTaxes;

        return $this;
    }

    /**
     * @return int
     */
    public function getStampStatus()
    {
        return $this->stampStatus;
    }

    /**
     * @param int $stampStatus
     */
    public function setStampStatus($stampStatus)
    {
        $this->stampStatus = $stampStatus;
    }

    /**
     * @return int
     */
    public function getHasPdf(): int
    {
        return $this->hasPdf;
    }

    /**
     * @param int $hasPdf
     */
    public function setHasPdf(int $hasPdf)
    {
        $this->hasPdf = $hasPdf;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $documentDatetimeStr = !!$this->getDocumentDatetime() ? $this->getDocumentDatetime()->format('Y-m-d H:i:s') : '';
        $stampDatetimeStr = !!$this->getStampDatetime() ? $this->getStampDatetime()->format('Y-m-d H:i:s') : '';
        $emailDatetimeStr = !!$this->getEmailDatetime() ? $this->getEmailDatetime()->format('Y-m-d H:i:s') : '';
        $regDatetimeStr = !!$this->getRegDatetime() ? $this->getRegDatetime()->format('Y-m-d H:i:s') : '';

        return \sprintf(
            '<BillInfo [id: %d, emitterName: %s, emitterRfc: %s, email: %s, uuid: %s, cfdiUseSatCode: %s, subtotal: %f, discount: %f, total: %f, transferTaxes: %d, withheldTaxes: %f, currency: %s, type: %s, paymentType: %s, documentDatetime: %s, stampDatetime: %s, emailDatetime: %s, regDatetime: %s, stampStatus: %d, hasPdf: %d]>',
            !!$this->getId() ? $this->getId() : 0,
            $this->getEmitterName(),
            $this->getEmitterRfc(),
            $this->getEmail(),
            $this->getUuid(),
            $this->getCfdiUseSatCode(),
            $this->getSubtotal(),
            $this->getDiscount(),
            $this->getTotal(),
            $this->getTransferTaxes(),
            $this->getWithheldTaxes(),
            $this->getCurrency(),
            $this->getType(),
            $this->getPaymentType(),
            $documentDatetimeStr,
            $stampDatetimeStr,
            $emailDatetimeStr,
            $regDatetimeStr,
            $this->getStampStatus(),
            $this->getHasPdf()
        );
    }
}