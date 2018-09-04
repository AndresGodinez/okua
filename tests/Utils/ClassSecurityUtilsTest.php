<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 11:40 AM
 */

namespace Tests\Utils;


use App\Utils\SecurityUtils;
use PHPUnit\Framework\TestCase;


/**
 * Class ClassSecurityUtilsTest
 * @package Utils
 */
class ClassSecurityUtilsTest extends TestCase
{
    const TEST_AES_KEY = 'aaabbb';
    const TEST_AES_DATA = 'my test text';
    const TEST_AES_ENC_DATA = 'U2FsdGVkX19OTfmdTsL7ecQNpEr9Be1X53/rMFAdgkKV+4TN6X6o8yYYHlO88qg+';

    /**
     * @throws \SecurityException
     */
    public function testEncryptDataAes()
    {
        $enc = SecurityUtils::encryptDataAes(self::TEST_AES_DATA, self::TEST_AES_KEY);

        $this->assertNotNull($enc);
    }

    /**
     * @throws \SecurityException
     */
    public function testDecryptDataAes()
    {
        $dec = SecurityUtils::decryptDataAes(self::TEST_AES_ENC_DATA, self::TEST_AES_KEY);

        $this->assertNotNull($dec);
        $this->assertEquals(self::TEST_AES_DATA, $dec);
    }
}