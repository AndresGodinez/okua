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
 * Class GetFilteredWarningRegistersRequestData
 * @package App\Models
 */
class GetFilteredErrorRegistersRequestData implements IValidableRequest
{
    /**
     * @param $data
     * @return GetFilteredWarningRegistersRequestData
     */
    public static function makeFromArray($data)
    {
        $limit = $data['limit'] ?? 0;
        $offset = $data['offset'] ?? 0;
        $startDatetime = $data['startDatetime'] ?? '';
        $endDatetime = $data['endDatetime'] ?? '';

        $filterDateType = $data['filterDateType'] ?? 1;

        $limit = (int)$limit;
        $offset = (int)$offset;
        $filterDateType = (int)$filterDateType;

        $inst = new GetFilteredErrorRegistersRequestData($limit, $offset, $startDatetime, $endDatetime, $filterDateType);

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

    /** @var float */
    protected $filterDateType = 1;

    /**
     * GetFilteredBillInfoRegistersRequestData constructor.
     * @param int $limit
     * @param int $offset
     * @param string $startDatetime
     * @param string $endDatetime
     * @param int $filterDateType
     */
    public function __construct(int $limit, int $offset, string $startDatetime, string $endDatetime, int $filterDateType)
    {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->startDatetime = $startDatetime;
        $this->endDatetime = $endDatetime;
        $this->filterDateType = $filterDateType;
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
    public function setLimit(int $limit)
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
    public function setOffset(int $offset)
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
     * @return int
     */
    public function getFilterDateType(): int
    {
        return $this->filterDateType;
    }

    /**
     * @param int $filterDateType
     */
    public function setFilterDateType(int $filterDateType)
    {
        $this->FilterDateType = $filterDateType;
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
        return \sprintf("<GetFilteredBillInfoRegistersRequestData [limit: %d, offset: %d, startDatetime: %s, endDatetime: %s, filterDateType: %d]>",
            $this->limit,
            $this->offset,
            $this->startDatetime,
            $this->endDatetime,
            $this->filterDateType
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
    }
}