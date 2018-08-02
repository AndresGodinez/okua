<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 1/08/18
 * Time: 11:18 PM
 */

namespace App\Utils;


class SecurityUtils
{
    const USER_PSWD_SEED = 'o9@l8$c#0n4kU$A_';

    /**
     * @param string $val Password string
     * @param string $seed Seed to secure the password
     * @return bool|string
     */
    public static function generateSecurePswd($val, $seed)
    {
        return \password_hash($val . '_' . $seed, \PASSWORD_BCRYPT);
    }

    /**
     * @param string $val Password string
     * @param string $seed Seed to secure the password
     * @param string $hash Hash stored in DB
     * @return bool
     */
    public static function verifySecurePaswFromHash($val, $seed, $hash)
    {
        return \password_verify($val . '_' . $seed, $hash);
    }
}