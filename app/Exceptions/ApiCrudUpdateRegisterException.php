<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 06:15 PM
 */

namespace App\Exceptions;


use Throwable;


/**
 * Class ApiCrudUpdateRegisterException
 * @package App\Exceptions
 */
class ApiCrudUpdateRegisterException extends \Exception
{
    /**
     * ValidationException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        if (!$message) $message = 'Can not update the register';

        parent::__construct($message, $code, $previous);
    }
}