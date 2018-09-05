<?php
/**
 * Created by PhpStorm.
 * Emitter: alberto
 * Date: 3/09/18
 * Time: 02:51 PM
 */

namespace Tests\Api;


use App\Entities\Emitter;
use App\Exceptions\ApiSecurityException;
use App\Repositories\EmitterRepository;
use App\Site\SiteContainer;
use App\Utils\EntityUtils;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use League\Container\Container;
use League\FactoryMuffin\FactoryMuffin;
use League\Route\RouteCollection;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;


/**
 * Class CrudEmitterApiViewTest
 * @package Tests\Api
 */
class CrudEmitterApiViewTest extends TestCase
{
    const BASE_ROUTE = '/api/emitter';

    /** @var Container */
    protected static $container = null;

    /** @var null|RouteCollection */
    public static $router = null;

    /** @var null|FactoryMuffin */
    protected static $fm = null;

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \League\FactoryMuffin\Exceptions\DirectoryNotFoundException
     */
    public static function setUpBeforeClass()
    {
        self::$container = SiteContainer::make();

        TestUtils::initConsts();

        self::$fm = TestUtils::initFactories();

        EntityUtils::$mockedEm = null;
    }

    public static function tearDownAfterClass()
    {
        EntityUtils::$mockedEm = null;
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
        $body = [
            'name' => 'test',
            'rfc' => 'test',
            'email' => 'test',
        ];

        EntityUtils::$mockedEm = $this->createMock(EntityManager::class);

        EntityUtils::$mockedEm->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Emitter::class));

        EntityUtils::$mockedEm->expects($this->once())
            ->method('flush')
            ->with($this->isInstanceOf(Emitter::class));

        $request = TestUtils::makeServerRequestMock('POST', self::BASE_ROUTE, [], $body);
        $request = $request->withHeader('authorization', 'Bearer ' . TestUtils::API_TOKEN);

        $response = self::$router->dispatch($request, self::$container->get('response'));

        TestUtils::runDefaultTestsJsonApiResponse($this, $response);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('id', $responseArray);
        $this->assertArrayHasKey('msg', $responseArray);
    }

    public function testReadRegistersSuccessfully()
    {
        EntityUtils::$mockedEm = $this->createMock(EntityManager::class);

        $mockedRepo = $this->createMock(EmitterRepository::class);

        $mockedRegisters = [];
        \array_push($mockedRegisters, self::$fm->instance(Emitter::class, ['id' => 1]));
        \array_push($mockedRegisters, self::$fm->instance(Emitter::class, ['id' => 2]));
        \array_push($mockedRegisters, self::$fm->instance(Emitter::class, ['id' => 3]));
        \array_push($mockedRegisters, self::$fm->instance(Emitter::class, ['id' => 4]));
        \array_push($mockedRegisters, self::$fm->instance(Emitter::class, ['id' => 5]));

        $mockedRepo->expects($this->once())
            ->method('findAll')
            ->willReturn($mockedRegisters);

        EntityUtils::$mockedEm->expects($this->once())
            ->method('getRepository')
            ->with(Emitter::class)
            ->willReturn($mockedRepo);

        $request = TestUtils::makeServerRequestMock('GET', self::BASE_ROUTE);
        $request = $request->withHeader('authorization', 'Bearer ' . TestUtils::API_TOKEN);

        $response = self::$router->dispatch($request, self::$container->get('response'));

        TestUtils::runDefaultTestsJsonApiResponse($this, $response);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('data', $responseArray);

        $responseDataArray = $responseArray['data'];

        $this->assertNotNull($responseDataArray);
        $this->assertCount(5, $responseDataArray);

        $item0 = $responseDataArray[0];
        $this->assertArrayHasKey('id', $item0);
        $this->assertArrayHasKey('name', $item0);
        $this->assertArrayHasKey('rfc', $item0);
        $this->assertArrayHasKey('email', $item0);
    }

    public function testReadRegisterSuccessfully()
    {
        EntityUtils::$mockedEm = $this->createMock(EntityManager::class);

        $mockedRepo = $this->createMock(EmitterRepository::class);

        $mockedRegister = self::$fm->instance(Emitter::class, ['id' => 1]);

        $mockedRepo->expects($this->once())
            ->method('find')
            ->willReturn($mockedRegister);

        EntityUtils::$mockedEm->expects($this->once())
            ->method('getRepository')
            ->with(Emitter::class)
            ->willReturn($mockedRepo);

        $request = TestUtils::makeServerRequestMock('GET', self::BASE_ROUTE . '/1');
        $request = $request->withHeader('authorization', 'Bearer ' . TestUtils::API_TOKEN);

        $response = self::$router->dispatch($request, self::$container->get('response'));

        TestUtils::runDefaultTestsJsonApiResponse($this, $response);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('id', $responseArray);
        $this->assertArrayHasKey('name', $responseArray);
        $this->assertArrayHasKey('rfc', $responseArray);
        $this->assertArrayHasKey('email', $responseArray);
        $this->assertEquals(1, (int)$responseArray['id']);
    }

    public function testUpdateRegisterSuccessfully()
    {
        $body = [
            'name' => 'test',
            'rfc' => 'test',
            'email' => 'test',
        ];

        EntityUtils::$mockedEm = $this->createMock(EntityManager::class);

        $mockedRepo = $this->createMock(EmitterRepository::class);

        $mockedRegister = self::$fm->instance(Emitter::class, ['id' => 1]);

        $mockedRepo->expects($this->once())
            ->method('find')
            ->with($this->identicalTo(1))
            ->willReturn($mockedRegister);

        EntityUtils::$mockedEm->expects($this->once())
            ->method('getRepository')
            ->with(Emitter::class)
            ->willReturn($mockedRepo);

        EntityUtils::$mockedEm->expects($this->once())
            ->method('merge')
            ->with($this->isInstanceOf(Emitter::class));

        EntityUtils::$mockedEm->expects($this->once())
            ->method('flush')
            ->with($this->isInstanceOf(Emitter::class));

        $request = TestUtils::makeServerRequestMock('PUT', self::BASE_ROUTE . '/1', [], $body);
        $request = $request->withHeader('authorization', 'Bearer ' . TestUtils::API_TOKEN);

        $response = self::$router->dispatch($request, self::$container->get('response'));

        TestUtils::runDefaultTestsJsonApiResponse($this, $response);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('id', $responseArray);
        $this->assertArrayHasKey('msg', $responseArray);
    }

    public function testDeleteRegisterSuccessfully()
    {
        EntityUtils::$mockedEm = $this->createMock(EntityManager::class);

        $mockedRepo = $this->createMock(EmitterRepository::class);

        $mockedRegister = self::$fm->instance(Emitter::class, ['id' => 1]);

        EntityUtils::$mockedEm->expects($this->once())
            ->method('find')
            ->with(Emitter::class, $this->identicalTo(1))
            ->willReturn($mockedRegister);

        EntityUtils::$mockedEm->expects($this->once())
            ->method('remove')
            ->with($this->isInstanceOf(Emitter::class));

        EntityUtils::$mockedEm->expects($this->once())
            ->method('flush')
            ->with($this->isInstanceOf(Emitter::class));

        $request = TestUtils::makeServerRequestMock('DELETE', self::BASE_ROUTE . '/1');
        $request = $request->withHeader('authorization', 'Bearer ' . TestUtils::API_TOKEN);

        $response = self::$router->dispatch($request, self::$container->get('response'));

        TestUtils::runDefaultTestsJsonApiResponse($this, $response);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('id', $responseArray);
        $this->assertArrayHasKey('msg', $responseArray);
    }
}