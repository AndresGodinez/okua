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
 * Class GetFilteredBillInfoRegistersRequestData
 * @package App\Models
 */
class GetFilteredBillInfoRegistersRequestData implements IValidableRequest
{
    /**
     * @param $data
     * @return GetFilteredBillInfoRegistersRequestData
     */
    public static function makeFromArray($data)
    {
        $limit = $data['limit'] ?? 0;
        $offset = $data['offset'] ?? 0;
        $startDatetime = $data['startDatetime'] ?? '';
        $endDatetime = $data['endDatetime'] ?? '';

        $clientRfc = $data['clientRfc'] ?? '';
        $initialAmount = $data['initialAmount'] ?? 0.00;
        $finalAmount = $data['finalAmount'] ?? 0.00;

        $limit = (int)$limit;
        $offset = (int)$offset;

        $inst = new GetFilteredBillInfoRegistersRequestData($limit, $offset, $startDatetime, $endDatetime);

        $initialAmount = (float)$initialAmount;
        $finalAmount = (float)$finalAmount;

        $inst->setClientRfc($clientRfc);
        $inst->setInitialAmount($initialAmount);
        $inst->setFinalAmount($finalAmount);

        return $inst;
    }

    /** @var int */
    protected $limit = 0;

    /** @var int */
    protected $offset = 0;

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
     * GetFilteredBillInfoRegistersRequestData constructor.
     * @param int $limit
     * @param int $offset
     * @param string $startDatetime
     * @param string $endDatetime
     */
    public function __construct(int $limit, int $offset, string $startDatetime, string $endDatetime)
    {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->startDatetime = $startDatetime;
        $this->endDatetime = $endDatetime;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
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
    public function setStartDatetime(string $startDatetime): void
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
    public function setEndDatetime(string $endDatetime): void
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
    public function setClientRfc(string $clientRfc): void
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
    public function setInitialAmount(float $initialAmount): void
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
    public function setFinalAmount(float $finalAmount): void
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
        return \sprintf("<GetFilteredBillInfoRegistersRequestData [limit: %d, offset: %d, startDatetime: %s, endDatetime: %s, clientRfc: %s, initialAmount: %f, finalAmount: %f]>",
            $this->limit,
            $this->offset,
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
        if ($this->limit <= 0) {
            throw new ValidationException('Invalid limit parameter.');
        }

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