<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 11:04 AM
 */

namespace App\Utils;


use App\Exceptions\ApiInternalException;
use App\Models\EmailServiceConfig;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem;

class SharedConfigUtils
{
    public static $EMAIL_SERVICE_FILE_PATH = '/config/email-serv.data';

    /**
     * @param Filesystem $fs
     * @param string $file
     * @param string $key
     * @return array
     * @throws ApiInternalException
     * @throws \SecurityException
     */
    public static function readEmailServiceConfig(Filesystem $fs, string $file, string $key)
    {
        try {
            $content = $fs->read($file);

            $baseData = 'Salted__' . $content;
            $encJsonData = \base64_encode($baseData);
            $jsonData = SecurityUtils::decryptDataAes($encJsonData, $key);

            $data = \json_decode($jsonData, true);
        } catch (FileNotFoundException $e) {
            \error_log($e->getMessage());
            $data = self::initEmailServiceConfig($fs, $file, $key);
        }

        return $data;
    }

    /**
     * @param Filesystem $fs
     * @param string $file
     * @param EmailServiceConfig $config
     * @param string $key
     * @return array
     * @throws ApiInternalException
     * @throws \SecurityException
     */
    public static function writeEmailServiceConfig(Filesystem $fs, string $file, EmailServiceConfig $config, string $key)
    {
        $data = $config->toArray();

        $jsonData = \json_encode($data);
        $encJsonData = SecurityUtils::encryptDataAes($jsonData, $key);

        $baseData = \base64_decode($encJsonData);

        $contents = \substr($baseData, 8);
        try {
            $fs->put($file, $contents);
        } catch (FileExistsException $e) {
            throw new ApiInternalException('Can not create email service file');
        }

        return $data;
    }

    /**
     * @param Filesystem $fs
     * @param string $file
     * @param string $key
     * @return array
     * @throws ApiInternalException
     * @throws \SecurityException
     */
    public static function initEmailServiceConfig(Filesystem $fs, string $file, string $key)
    {
        // initial (empty) email service configuration
        $config = new EmailServiceConfig();

        return self::writeEmailServiceConfig($fs, $file, $config, $key);
    }
}