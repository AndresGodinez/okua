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
 * Class GetCfdiTotalRequestData
 * @package App\Models
 */
class GetCfdiTotalRequestData implements IValidableRequest
{
    /**
     * @param $data
     * @return GetCfdiTotalRequestData
     */
    public static function makeFromArray($data)
    {
        $filter = $data['filter'] ?? '';

        return new GetCfdiTotalRequestData($filter);
    }

    /** @var string */
    protected $filter = '';

    /**
     * GetCfdiTotalRequestData constructor.
     * @param string $filter
     */
    public function __construct(string $filter)
    {
        $this->filter = $filter;
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
        return \sprintf("<GetCfdiTotalRequestData [filter: %s]>", $this->filter);
    }

    /**
     * @throws ValidationException
     */
    public function validate()
    {
        if (!\in_array($this->filter, [RangeTimeFilter::FILTER_WEEK, RangeTimeFilter::FILTER_MONTH, RangeTimeFilter::FILTER_YEAR])) {
            throw new ValidationException('Invalid filter type');
        }
    }
}