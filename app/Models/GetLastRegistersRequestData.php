<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 2/08/18
 * Time: 05:46 PM
 */

namespace App\Models;


use App\Exceptions\ValidationException;
use App\Interfaces\IValidableRequest;

/**
 * Class GetLastRegistersRequestData
 * @package App\Models
 */
class GetLastRegistersRequestData implements IValidableRequest
{
    /**
     * @param $data
     * @return GetLastRegistersRequestData
     */
    public static function makeFromArray($data)
    {
        $filter = $data['limit'] ?? 0;

        return new GetLastRegistersRequestData($filter);
    }

    /** @var int */
    protected $limit;

    /**
     * GetLastBillInfoRegistersRequestData constructor.
     * @param int $limit
     */
    public function __construct(int $limit)
    {
        $this->limit = $limit;
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
     * @return string
     */
    public function __toString()
    {
        return \sprintf("<GetLastBillInfoRegistersRequestData [limit: %s]>", $this->limit);
    }

    /**
     * @throws ValidationException
     */
    public function validate()
    {
        if (!\is_int($this->limit)) {
            throw new ValidationException('Invalid limit type');
        }

        if ($this->limit <= 0) {
            throw new ValidationException('The limit must be greater than 0');
        }
    }
}