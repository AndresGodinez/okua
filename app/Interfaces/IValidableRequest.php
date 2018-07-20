<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 8/06/18
 * Time: 04:25 PM
 */

namespace App\Interfaces;


use App\Exceptions\ValidationException;

interface IValidableRequest
{
    /**
     * @throws ValidationException
     */
    public function validate();
}