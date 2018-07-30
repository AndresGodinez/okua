<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 30/07/18
 * Time: 03:48 PM
 */

namespace App\Entities;


use App\Entities\Mappings\BillInfoMetadataBuilder;
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
    private $rfcEmitter;

    /** @var null|string */
    private $email;

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
    private $emailDatetime;

    /** @var null|\DateTime */
    private $stampDatetime;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return null|string
     */
    public function getRfcEmitter(): ?string
    {
        return $this->rfcEmitter;
    }

    /**
     * @param null|string $rfcEmitter
     */
    public function setRfcEmitter(?string $rfcEmitter): void
    {
        $this->rfcEmitter = $rfcEmitter;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return null|string
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @param null|string $uuid
     */
    public function setUuid(?string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return null|string
     */
    public function getCfdiUseSatCode(): ?string
    {
        return $this->cfdiUseSatCode;
    }

    /**
     * @param null|string $cfdiUseSatCode
     */
    public function setCfdiUseSatCode(?string $cfdiUseSatCode): void
    {
        $this->cfdiUseSatCode = $cfdiUseSatCode;
    }

    /**
     * @return float|null
     */
    public function getSubtotal(): ?float
    {
        return $this->subtotal;
    }

    /**
     * @param float|null $subtotal
     */
    public function setSubtotal(?float $subtotal): void
    {
        $this->subtotal = $subtotal;
    }

    /**
     * @return float|null
     */
    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    /**
     * @param float|null $discount
     */
    public function setDiscount(?float $discount): void
    {
        $this->discount = $discount;
    }

    /**
     * @return float|null
     */
    public function getTotal(): ?float
    {
        return $this->total;
    }

    /**
     * @param float|null $total
     */
    public function setTotal(?float $total): void
    {
        $this->total = $total;
    }

    /**
     * @return null|string
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param null|string $currency
     */
    public function setCurrency(?string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param null|string $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return null|string
     */
    public function getPaymentType(): ?string
    {
        return $this->paymentType;
    }

    /**
     * @param null|string $paymentType
     */
    public function setPaymentType(?string $paymentType): void
    {
        $this->paymentType = $paymentType;
    }

    /**
     * @return \DateTime|null
     */
    public function getEmailDatetime(): ?\DateTime
    {
        return $this->emailDatetime;
    }

    /**
     * @param \DateTime|null $emailDatetime
     */
    public function setEmailDatetime(?\DateTime $emailDatetime): void
    {
        $this->emailDatetime = $emailDatetime;
    }

    /**
     * @return \DateTime|null
     */
    public function getStampDatetime(): ?\DateTime
    {
        return $this->stampDatetime;
    }

    /**
     * @param \DateTime|null $stampDatetime
     */
    public function setStampDatetime(?\DateTime $stampDatetime): void
    {
        $this->stampDatetime = $stampDatetime;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $emailDatetimeStr = !!$this->getEmailDatetime() ? $this->getEmailDatetime()->format('Y-m-d H:i:s') : '';
        $stampDatetimeStr = !!$this->getStampDatetime() ? $this->getStampDatetime()->format('Y-m-d H:i:s') : '';

        return \sprintf(
            '<BillInfo [id: %d, rfcEmitter: %s, email: %s, uuid: %s, cfdiUseSatCode: %s, subtotal: %f, discount: %f, total: %f, currency: %s, type: %s, paymentType: %s, emailDatetime: %s, stampDatetime: %s]>',
            !!$this->getId() ? $this->getId() : 0,
            $this->getRfcEmitter(),
            $this->getEmail(),
            $this->getUuid(),
            $this->getCfdiUseSatCode(),
            $this->getSubtotal(),
            $this->getDiscount(),
            $this->getTotal(),
            $this->getCurrency(),
            $this->getType(),
            $this->getPaymentType(),
            $emailDatetimeStr,
            $stampDatetimeStr
        );
    }
}