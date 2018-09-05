<?php
/**
 * Created by PhpStorm.
 * FilterReceptor: alberto
 * Date: 3/09/18
 * Time: 02:51 PM
 */

namespace Tests\Api;


use App\Entities\FilterReceptor;
use App\Exceptions\ApiSecurityException;
use App\Repositories\FilterReceptorRepository;
use App\Site\SiteContainer;
use App\Utils\EntityUtils;
use Doctrine\ORM\EntityManager;
use League\Container\Container;
use League\FactoryMuffin\FactoryMuffin;
use League\Route\RouteCollection;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;


/**
 * Class CrudFilterReceptorApiViewTest
 * @package Tests\Api
 */
class CrudFilterReceptorApiViewTest extends TestCase
{
    const BASE_ROUTE = '/api/filter-receptor';

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
            'rfc' => 'test',
            'valid' => 1,
        ];

        EntityUtils::$mockedEm = $this->createMock(EntityManager::class);

        EntityUtils::$mockedEm->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(FilterReceptor::class));

        EntityUtils::$mockedEm->expects($this->once())
            ->method('flush')
            ->with($this->isInstanceOf(FilterReceptor::class));

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

        $mockedRepo = $this->createMock(FilterReceptorRepository::class);

        $mockedRegisters = [];
        \array_push($mockedRegisters, self::$fm->instance(FilterReceptor::class, ['id' => 1]));
        \array_push($mockedRegisters, self::$fm->instance(FilterReceptor::class, ['id' => 2]));
        \array_push($mockedRegisters, self::$fm->instance(FilterReceptor::class, ['id' => 3]));
        \array_push($mockedRegisters, self::$fm->instance(FilterReceptor::class, ['id' => 4]));
        \array_push($mockedRegisters, self::$fm->instance(FilterReceptor::class, ['id' => 5]));

        $mockedRepo->expects($this->once())
            ->method('findAll')
            ->willReturn($mockedRegisters);

        EntityUtils::$mockedEm->expects($this->once())
            ->method('getRepository')
            ->with(FilterReceptor::class)
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
        $this->assertArrayHasKey('rfc', $item0);
        $this->assertArrayHasKey('valid', $item0);
    }

    public function testReadRegisterSuccessfully()
    {
        EntityUtils::$mockedEm = $this->createMock(EntityManager::class);

        $mockedRepo = $this->createMock(FilterReceptorRepository::class);

        $mockedRegister = self::$fm->instance(FilterReceptor::class, ['id' => 1]);

        $mockedRepo->expects($this->once())
            ->method('find')
            ->willReturn($mockedRegister);

        EntityUtils::$mockedEm->expects($this->once())
            ->method('getRepository')
            ->with(FilterReceptor::class)
            ->willReturn($mockedRepo);

        $request = TestUtils::makeServerRequestMock('GET', self::BASE_ROUTE . '/1');
        $request = $request->withHeader('authorization', 'Bearer ' . TestUtils::API_TOKEN);

        $response = self::$router->dispatch($request, self::$container->get('response'));

        TestUtils::runDefaultTestsJsonApiResponse($this, $response);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('id', $responseArray);
        $this->assertArrayHasKey('rfc', $responseArray);
        $this->assertArrayHasKey('valid', $responseArray);
        $this->assertEquals(1, (int)$responseArray['id']);
    }

    public function testUpdateRegisterSuccessfully()
    {
        $body = [
            'rfc' => 'test',
            'valid' => 0,
        ];

        EntityUtils::$mockedEm = $this->createMock(EntityManager::class);

        $mockedRepo = $this->createMock(FilterReceptorRepository::class);

        $mockedRegister = self::$fm->instance(FilterReceptor::class, ['id' => 1]);

        $mockedRepo->expects($this->once())
            ->method('find')
            ->with($this->identicalTo(1))
            ->willReturn($mockedRegister);

        EntityUtils::$mockedEm->expects($this->once())
            ->method('getRepository')
            ->with(FilterReceptor::class)
            ->willReturn($mockedRepo);

        EntityUtils::$mockedEm->expects($this->once())
            ->method('merge')
            ->with($this->isInstanceOf(FilterReceptor::class));

        EntityUtils::$mockedEm->expects($this->once())
            ->method('flush')
            ->with($this->isInstanceOf(FilterReceptor::class));

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

        $mockedRepo = $this->createMock(FilterReceptorRepository::class);

        $mockedRegister = self::$fm->instance(FilterReceptor::class, ['id' => 1]);

        EntityUtils::$mockedEm->expects($this->once())
            ->method('find')
            ->with(FilterReceptor::class, $this->identicalTo(1))
            ->willReturn($mockedRegister);

        EntityUtils::$mockedEm->expects($this->once())
            ->method('remove')
            ->with($this->isInstanceOf(FilterReceptor::class));

        EntityUtils::$mockedEm->expects($this->once())
            ->method('flush')
            ->with($this->isInstanceOf(FilterReceptor::class));

        $request = TestUtils::makeServerRequestMock('DELETE', self::BASE_ROUTE . '/1');
        $request = $request->withHeader('authorization', 'Bearer ' . TestUtils::API_TOKEN);

        $response = self::$router->dispatch($request, self::$container->get('response'));

        TestUtils::runDefaultTestsJsonApiResponse($this, $response);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('id', $responseArray);
        $this->assertArrayHasKey('msg', $responseArray);
    }
}