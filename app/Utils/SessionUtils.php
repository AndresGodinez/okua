<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 5/09/18
 * Time: 03:49 PM
 */

namespace App\Utils;


/**
 * Class SessionUtils
 * @package App\Utils
 */
class SessionUtils
{
    const CONFIG_SESSION_NAME_KEY = 'OKUA_SESSION_NAME';

    /**
     * @param string $base
     * @return string
     */
    public static function generateSessionName(string $base)
    {
        $sessionName = \md5($base);
        \session_name($sessionName);

        return $sessionName;
    }

    /**
     * @param array $config
     */
    public static function initSessionFromConfig(array $config)
    {
        if (\defined('TESTING') && !!TESTING) {
            return;
        }

        $configSessionName = $config[self::CONFIG_SESSION_NAME_KEY];

        self::generateSessionName($configSessionName);

        \session_start();
    }

    /**
     * @return bool
     */
    public static function writeAndClose()
    {
        if (\defined('TESTING') && !!TESTING) {
            return true;
        }

        \session_write_close();

        return true;
    }
}