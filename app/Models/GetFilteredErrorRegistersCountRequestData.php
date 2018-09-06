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
class GetFilteredErrorRegistersCountRequestData implements IValidableRequest
{
    /**
     * @param $data
     * @return GetFilteredWarningRegistersRequestData
     */
    public static function makeFromArray($data)
    {
        $startDatetime = $data['startDatetime'] ?? '';
        $endDatetime = $data['endDatetime'] ?? '';

        $filterDateType = $data['filterDateType'] ?? 1;
        $filterDateType = (int)$filterDateType;

        $inst = new GetFilteredErrorRegistersCountRequestData($startDatetime, $endDatetime, $filterDateType);

        return $inst;
    }

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
    public function __construct(string $startDatetime, string $endDatetime, int $filterDateType)
    {
        $this->startDatetime = $startDatetime;
        $this->endDatetime = $endDatetime;
        $this->filterDateType = $filterDateType;
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
        return \sprintf("<GetFilteredBillInfoRegistersRequestData [startDatetime: %s, endDatetime: %s, filterDateType: %d]>",
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
        if (!$this->startDatetime) {
            throw new ValidationException('Invalid start datetime parameter.');
        }

        if (!$this->endDatetime) {
            throw new ValidationException('Invalid end datetime parameter.');
        }
    }
}