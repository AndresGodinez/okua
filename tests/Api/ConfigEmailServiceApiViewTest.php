<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 02:40 PM
 */

namespace Tests\Api;


use App\Exceptions\ApiSecurityException;
use App\Site\SiteContainer;
use App\Utils\RequestUtils;
use App\Utils\SharedConfigUtils;
use League\Container\Container;
use League\Route\RouteCollection;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;


/**
 * Class ConfigEmailServiceApiViewTest
 * @package Tests\Api
 */
class ConfigEmailServiceApiViewTest extends TestCase
{
    const BASE_ROUTE = '/api/config/email-service';

    /** @var Container */
    protected static $container = null;

    /** @var null|RouteCollection */
    public static $router = null;

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \League\FactoryMuffin\Exceptions\DirectoryNotFoundException
     */
    public static function setUpBeforeClass()
    {
        self::$container = SiteContainer::make();

        TestUtils::initConsts();
    }

    protected function setUp()
    {
        self::$router = self::$container->get('router');
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function tearDown()
    {
        self::$router = null;
    }

    public function testReadUpAndRunning()
    {
        $this->expectException(ApiSecurityException::class);

        $request = TestUtils::makeServerRequestMock('GET', self::BASE_ROUTE);
        self::$router->dispatch($request, self::$container->get('response'));
    }

    public function testUpdateUpAndRunning()
    {
        $this->expectException(ApiSecurityException::class);

        $request = TestUtils::makeServerRequestMock('PUT', self::BASE_ROUTE);
        self::$router->dispatch($request, self::$container->get('response'));
    }

    /**
     * @throws \App\Exceptions\ApiInternalException
     * @throws \SecurityException
     */
    public function testReadConfigSuccessfully()
    {
        $fs = self::$container->get('shared-filesystem');
        $serviceConfig = TestUtils::mockEmailServiceConfig();
        $file = TestUtils::TEST_EMAIL_SERVICE_CONFIG_FILEPATH;

        $config = self::$container->get('config');
        $k = $config['OKUA_SHARED_CONFIG_KEY'];

        SharedConfigUtils::writeEmailServiceConfig($fs, $file, $serviceConfig, $k);

        $request = TestUtils::makeServerRequestMock('GET', self::BASE_ROUTE);
        $request = $request->withHeader(RequestUtils::HEADER_AUTHORIZATION, 'Bearer ' . TestUtils::API_TOKEN);

        $response = self::$router->dispatch($request, self::$container->get('response'));

        TestUtils::runDefaultTestsJsonApiResponse($this, $response);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertNotNull($responseArray);
        $this->assertArrayHasKey('hostname', $responseArray);
        $this->assertArrayHasKey('inboxName', $responseArray);
        $this->assertArrayHasKey('username', $responseArray);
        $this->assertArrayHasKey('tagOk', $responseArray);
        $this->assertArrayHasKey('tagIssue', $responseArray);
        $this->assertArrayNotHasKey('pswd', $responseArray);
    }

    /**
     * @throws \App\Exceptions\ApiInternalException
     * @throws \SecurityException
     */
    public function testUpdateConfigSuccessfully()
    {
        $fs = self::$container->get('shared-filesystem');
        $serviceConfig = TestUtils::mockEmailServiceConfig();
        $file = TestUtils::TEST_EMAIL_SERVICE_CONFIG_FILEPATH;

        $config = self::$container->get('config');
        $k = $config['OKUA_SHARED_CONFIG_KEY'];

        SharedConfigUtils::writeEmailServiceConfig($fs, $file, $serviceConfig, $k);

        $hostname = 'new hostname';
        $serviceConfig->setHostname($hostname);
        $body = $serviceConfig->toArray();

        SharedConfigUtils::$EMAIL_SERVICE_FILE_PATH = $file;

        $request = TestUtils::makeServerRequestMock('PUT', self::BASE_ROUTE, [], $body);
        $request = $request->withHeader(RequestUtils::HEADER_AUTHORIZATION, 'Bearer ' . TestUtils::API_TOKEN);

        $response = self::$router->dispatch($request, self::$container->get('response'));

        TestUtils::runDefaultTestsJsonApiResponse($this, $response);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertNotNull($responseArray);
        $this->assertArrayHasKey('msg', $responseArray);

        $newConfig = SharedConfigUtils::readEmailServiceConfig($fs, $file, $k);
        $this->assertEquals($hostname, $newConfig['hostname']);
        $this->assertEquals($serviceConfig->getUsername(), $newConfig['username']);
    }
}