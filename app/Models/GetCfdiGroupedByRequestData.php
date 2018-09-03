<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 2/08/18
 * Time: 02:45 PM
 */

namespace App\Models;
use App\Exceptions\ValidationException;
use App\Interfaces\IValidableRequest;


/**
 * Class GetCfdiGroupedByRequestData
 * @package App\Models
 */
class GetCfdiGroupedByRequestData implements IValidableRequest
{
    /**
     * @param $data
     * @return GetCfdiGroupedByRequestData
     */
    public static function makeFromArray($data)
    {
        $limit = $data['limit'] ?? 0;
        $offset = $data['offset'] ?? 0;
        $filter = $data['filter'] ?? '';

        return new GetCfdiGroupedByRequestData($limit, $offset, $filter);
    }

    /** @var int */
    protected $limit = 0;

    /** @var int */
    protected $offset = 0;

    /** @var string */
    protected $filter = '';

    /**
     * GetCfdiGroupedByRequestData constructor.
     * @param int $limit
     * @param int $offset
     * @param string $filter
     */
    public function __construct(int $limit, int $offset, string $filter)
    {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->filter = $filter;
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
    public function getFilter(): string
    {
        return $this->filter;
    }

    /**
     * @param string $filter
     */
    public function setFilter(string $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return \sprintf("<GetCfdiGroupedByRequestData [limit: %d, offset: %d, filter: %s]>", $this->limit, $this->offset, $this->filter);
    }

    /**
     * @throws ValidationException
     */
    public function validate()
    {
        if ($this->limit == 0) {
            throw new ValidationException('Invalid requested page');
        }

        if (!\in_array($this->filter, [RangeTimeFilter::FILTER_WEEK, RangeTimeFilter::FILTER_MONTH, RangeTimeFilter::FILTER_YEAR])) {
            throw new ValidationException('Invalid filter type');
        }
    }
}