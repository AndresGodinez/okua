<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 8/06/18
 * Time: 04:27 PM
 */

namespace App\Exceptions;


use Throwable;

/**
 * Class ValidationException
 * @package App\Exceptions
 */
class ValidationException extends \Exception
{
    /**
     * ValidationException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}