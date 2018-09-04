<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 02:51 PM
 */

namespace Tests\Api;


use App\Exceptions\ApiSecurityException;
use App\Site\SiteContainer;
use League\Container\Container;
use League\Route\RouteCollection;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;


/**
 * Class CrudUserApiViewTest
 * @package Tests\Api
 */
class CrudUserApiViewTest extends TestCase
{
    const BASE_ROUTE = '/api/user';

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

    public function testCreateUpAndRunning()
    {
        $this->expectException(ApiSecurityException::class);

        $request = TestUtils::makeServerRequestMock('POST', self::BASE_ROUTE);
        self::$router->dispatch($request, self::$container->get('response'));
    }

    public function testReadRegistersUpAndRunning()
    {
        $this->expectException(ApiSecurityException::class);

        $request = TestUtils::makeServerRequestMock('GET', self::BASE_ROUTE);
        self::$router->dispatch($request, self::$container->get('response'));
    }

    public function testReadRegisterUpAndRunning()
    {
        $this->expectException(ApiSecurityException::class);

        $request = TestUtils::makeServerRequestMock('GET', self::BASE_ROUTE . '/1');
        self::$router->dispatch($request, self::$container->get('response'));
    }

    public function testUpdateUpAndRunning()
    {
        $this->expectException(ApiSecurityException::class);

        $request = TestUtils::makeServerRequestMock('PUT', self::BASE_ROUTE . '/1');
        self::$router->dispatch($request, self::$container->get('response'));
    }

    public function testDeleteUpAndRunning()
    {
        $this->expectException(ApiSecurityException::class);

        $request = TestUtils::makeServerRequestMock('DELETE', self::BASE_ROUTE . '/1');
        self::$router->dispatch($request, self::$container->get('response'));
    }

    public function testCreateRegisterSuccessfully()
    {
        $request = TestUtils::makeServerRequestMock('POST', self::BASE_ROUTE);
        $request = $request->withHeader('authorization', 'Bearer ' . TestUtils::API_TOKEN);

        $response = self::$router->dispatch($request, self::$container->get('response'));

        TestUtils::runDefaultTestsJsonApiResponse($this, $response);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('id', $responseArray);
        $this->assertArrayHasKey('msg', $responseArray);
    }

    public function testReadRegistersSuccessfully()
    {
        $request = TestUtils::makeServerRequestMock('GET', self::BASE_ROUTE);
        $request = $request->withHeader('authorization', 'Bearer ' . TestUtils::API_TOKEN);

        $response = self::$router->dispatch($request, self::$container->get('response'));

        TestUtils::runDefaultTestsJsonApiResponse($this, $response);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('data', $responseArray);

        $responseDataArray = $responseArray['data'];

        $this->assertNotNull($responseDataArray);
        $this->assertCount(10, $responseDataArray);

        $item0 = $responseDataArray[0];
        $this->assertArrayHasKey('id', $item0);
        $this->assertArrayHasKey('name', $item0);
        $this->assertArrayHasKey('regStatus', $item0);
    }

    public function testReadRegisterSuccessfully()
    {
        $request = TestUtils::makeServerRequestMock('GET', self::BASE_ROUTE . '/1');
        $request = $request->withHeader('authorization', 'Bearer ' . TestUtils::API_TOKEN);

        $response = self::$router->dispatch($request, self::$container->get('response'));

        TestUtils::runDefaultTestsJsonApiResponse($this, $response);
        
        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('id', $responseArray);
        $this->assertArrayHasKey('name', $responseArray);
        $this->assertArrayHasKey('regStatus', $responseArray);
    }

    public function testUpdateRegisterSuccessfully()
    {
        $request = TestUtils::makeServerRequestMock('PUT', self::BASE_ROUTE . '/1');
        $request = $request->withHeader('authorization', 'Bearer ' . TestUtils::API_TOKEN);

        $response = self::$router->dispatch($request, self::$container->get('response'));

        TestUtils::runDefaultTestsJsonApiResponse($this, $response);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('id', $responseArray);
        $this->assertArrayHasKey('msg', $responseArray);
    }

    public function testDeleteRegisterSuccessfully()
    {
        $request = TestUtils::makeServerRequestMock('DELETE', self::BASE_ROUTE . '/1');
        $request = $request->withHeader('authorization', 'Bearer ' . TestUtils::API_TOKEN);

        $response = self::$router->dispatch($request, self::$container->get('response'));

        TestUtils::runDefaultTestsJsonApiResponse($this, $response);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('id', $responseArray);
        $this->assertArrayHasKey('msg', $responseArray);
    }
}