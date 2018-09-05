<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 26/07/18
 * Time: 09:16 PM
 */

namespace App\Utils;


use PHPUnit\Framework\MockObject\MockObject;


/**
 * Class EntityUtils
 * @package App\Utils
 */
class EntityUtils
{
    const REG_STATUS_ACTIVE = 1;
    const REG_STATUS_INACTIVE = 0;

    const STAMP_STATUS_NOT_DEFINED = -1;
    const STAMP_STATUS_ACTIVE = 1;
    const STAMP_STATUS_NOT_FOUND = 2;
    const STAMP_STATUS_CANCELED = 3;

    /** @var null|MockObject */
    public static $mockedEm = null;

}