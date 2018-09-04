<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 11:05 AM
 */

namespace Tests\Utils;


use App\Models\EmailServiceConfig;
use App\Site\SiteContainer;
use App\Utils\SharedConfigUtils;
use League\Container\Container;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;


/**
 * Class ClassSharedConfigUtilsTest
 * @package Tests\Utils
 */
class ClassSharedConfigUtilsTest extends TestCase
{
    /** @var Container */
    protected static $container = null;

    protected static $k = '';

    public static function setUpBeforeClass()
    {
        self::$container = SiteContainer::make();

        TestUtils::initConsts();

        $config = self::$container->get('config');
        self::$k = $config['OKUA_SHARED_CONFIG_KEY'];
    }

    /**
     * @throws \App\Exceptions\ApiInternalException
     * @throws \SecurityException
     */
    public function testReadEmailServiceConfig()
    {
        $fs = self::$container->get('shared-filesystem');

        $hostname = 'test';
        $inboxName = 'INBOX';
        $username = 'test';
        $pswd = 'blablabla';
        $tagOk = 'OK';
        $tagIssue = 'ISSUE';

        $serviceConfig = new EmailServiceConfig();
        $serviceConfig->setHostname($hostname);
        $serviceConfig->setInboxName($inboxName);
        $serviceConfig->setUsername($username);
        $serviceConfig->setPswd($pswd);
        $serviceConfig->setTagOk($tagOk);
        $serviceConfig->setTagIssue($tagIssue);

        $readData = SharedConfigUtils::writeEmailServiceConfig($fs, TestUtils::TEST_EMAIL_SERVICE_CONFIG_FILEPATH, $serviceConfig, self::$k);

        $this->assertNotNull($readData);
        $this->assertInternalType('array', $readData);
        $this->assertEquals($hostname, $readData['hostname']);
        $this->assertEquals($inboxName, $readData['inboxName']);
        $this->assertEquals($username, $readData['username']);
        $this->assertEquals($pswd, $readData['pswd']);
        $this->assertEquals($tagOk, $readData['tagOk']);
        $this->assertEquals($tagIssue, $readData['tagIssue']);
    }

    /**
     * @throws \App\Exceptions\ApiInternalException
     * @throws \SecurityException
     */
    public function testWriteEmailServiceConfig()
    {
        $fs = self::$container->get('shared-filesystem');

        $this->assertNotNull($fs);

        $serviceConfig = new EmailServiceConfig();
        $data = SharedConfigUtils::writeEmailServiceConfig($fs, TestUtils::TEST_EMAIL_SERVICE_CONFIG_FILEPATH, $serviceConfig, self::$k);

        $this->assertNotNull($data);
    }

    /**
     * @throws \App\Exceptions\ApiInternalException
     * @throws \SecurityException
     */
    public function testInitEmailServiceConfig()
    {
        $fs = self::$container->get('shared-filesystem');

        $this->assertNotNull($fs);

        $data = SharedConfigUtils::initEmailServiceConfig($fs, TestUtils::TEST_EMAIL_SERVICE_CONFIG_FILEPATH, self::$k);

        $this->assertNotNull($data);
        $this->assertInternalType('array', $data);
        $this->assertArrayHasKey('hostname', $data);
        $this->assertArrayHasKey('inboxName', $data);
        $this->assertArrayHasKey('username', $data);
        $this->assertArrayHasKey('pswd', $data);
        $this->assertArrayHasKey('tagOk', $data);
        $this->assertArrayHasKey('tagIssue', $data);
        $this->assertArrayHasKey('tagIssue', $data);
    }
}