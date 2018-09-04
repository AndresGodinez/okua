<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 11:31 AM
 */

namespace App\Interfaces;


/**
 * Interface IArraySerializableModel
 * @package App\Interfaces
 */
interface IArraySerializableModel
{
    /**
     * @return array
     */
    public function toArray();
}