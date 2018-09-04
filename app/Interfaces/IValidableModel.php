<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 11:30 AM
 */

namespace App\Interfaces;


use App\Exceptions\ValidationException;


/**
 * Interface IValidableModel
 * @package App\Interfaces
 */
interface IValidableModel
{
    /**
     * @throws ValidationException
     */
    public function validate();
}