<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 1/08/18
 * Time: 11:18 PM
 */

namespace App\Utils;


use Legierski\AES\AES;

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

    /**
     * Encrypt a JWT token
     * @param string $data
     * @param string $key
     * @return string
     * @throws \SecurityException
     */
    public static function encryptDataAes(string $data, string $key)
    {
        try {
            $data = \base64_encode($data);

            $hexKey = \bin2hex($key);
            $hexKey = \strtolower($hexKey);

            $aes = new AES();
            return $aes->encrypt($data, $hexKey);
        } catch (\Exception $err) {
            \error_log($err->getMessage());
            throw new \SecurityException('Error encoding the string');
        }
    }

    /**
     * Decrypt an AES token
     * @param string $encData
     * @param string $key
     * @return string
     * @throws \SecurityException
     */
    public static function decryptDataAes(string $encData, string $key)
    {
        try {
            $hexKey = \bin2hex($key);
            $hexKey = \strtolower($hexKey);

            $aes = new AES();
            $data = $aes->decrypt($encData, $hexKey);

            return \base64_decode($data);
        } catch (\Exception $e) {
            \error_log($e->getMessage());
            throw new \SecurityException('Error decoding the string');
        }
    }
}