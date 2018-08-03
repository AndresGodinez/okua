<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 2/08/18
 * Time: 09:02 PM
 */

namespace App\Models;


use App\Exceptions\ValidationException;
use App\Interfaces\IValidableRequest;

/**
 * Class GetFilteredBillInfoRegistersCountRequestData
 * @package App\Models
 */
class GetFilteredBillInfoRegistersCountRequestData implements IValidableRequest
{
    /**
     * @param $data
     * @return GetFilteredBillInfoRegistersCountRequestData
     */
    public static function makeFromArray($data)
    {
        $startDatetime = $data['startDatetime'] ?? '';
        $endDatetime = $data['endDatetime'] ?? '';

        $clientRfc = $data['clientRfc'] ?? '';
        $initialAmount = $data['initialAmount'] ?? 0.00;
        $finalAmount = $data['finalAmount'] ?? 0.00;

        $inst = new GetFilteredBillInfoRegistersCountRequestData($startDatetime, $endDatetime);
        
        $initialAmount = (float)$initialAmount;
        $finalAmount = (float)$finalAmount;

        $inst->setClientRfc($clientRfc);
        $inst->setInitialAmount($initialAmount);
        $inst->setFinalAmount($finalAmount);

        return $inst;
    }

    /** @var string */
    protected $startDatetime = '';

    /** @var string */
    protected $endDatetime = '';

    /** @var string */
    protected $clientRfc = '';

    /** @var float */
    protected $initialAmount = 0.00;

    /** @var float */
    protected $finalAmount = 0.00;

    /**
     * GetFilteredBillInfoRegistersCountRequestData constructor.
     * @param string $startDatetime
     * @param string $endDatetime
     */
    public function __construct(string $startDatetime, string $endDatetime)
    {
        $this->startDatetime = $startDatetime;
        $this->endDatetime = $endDatetime;
    }

    /**
     * @return string
     */
    public function getStartDatetime(): string
    {
        return $this->startDatetime;
    }

    /**
     * @param string $startDatetime
     */
    public function setStartDatetime(string $startDatetime)
    {
        $this->startDatetime = $startDatetime;
    }

    /**
     * @return string
     */
    public function getEndDatetime(): string
    {
        return $this->endDatetime;
    }

    /**
     * @param string $endDatetime
     */
    public function setEndDatetime(string $endDatetime)
    {
        $this->endDatetime = $endDatetime;
    }

    /**
     * @return string
     */
    public function getClientRfc(): string
    {
        return $this->clientRfc;
    }

    /**
     * @param string $clientRfc
     */
    public function setClientRfc(string $clientRfc)
    {
        $this->clientRfc = $clientRfc;
    }

    /**
     * @return float
     */
    public function getInitialAmount(): float
    {
        return $this->initialAmount;
    }

    /**
     * @param float $initialAmount
     */
    public function setInitialAmount(float $initialAmount)
    {
        $this->initialAmount = $initialAmount;
    }

    /**
     * @return float
     */
    public function getFinalAmount(): float
    {
        return $this->finalAmount;
    }

    /**
     * @param float $finalAmount
     */
    public function setFinalAmount(float $finalAmount)
    {
        $this->finalAmount = $finalAmount;
    }

    /**
     * @return \DateTime
     */
    public function getStartDatetimeObj()
    {
        return new \DateTime($this->startDatetime);
    }

    /**
     * @return \DateTime
     */
    public function getEndDatetimeObj()
    {
        return new \DateTime($this->endDatetime);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return \sprintf("<GetFilteredBillInfoRegistersCountRequestData [startDatetime: %s, endDatetime: %s, clientRfc: %s, initialAmount: %f, finalAmount: %f]>",
            $this->startDatetime,
            $this->endDatetime,
            $this->clientRfc,
            $this->initialAmount,
            $this->finalAmount
        );
    }

    /**
     * @throws ValidationException
     */
    public function validate()
    {
        if (!$this->startDatetime) {
            throw new ValidationException('Invalid start datetime parameter.');
        }

        if (!$this->endDatetime) {
            throw new ValidationException('Invalid end datetime parameter.');
        }

        if ($this->finalAmount < $this->initialAmount) {
            throw new ValidationException('The range of the amount filter is invalid.');
        }
    }
}