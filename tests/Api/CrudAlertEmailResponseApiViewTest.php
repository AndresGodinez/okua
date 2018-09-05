<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 02:51 PM
 */

namespace Tests\Api;


use App\Entities\AlertEmailResponse;
use App\Exceptions\ApiInternalException;
use App\Exceptions\ApiSecurityException;
use App\Repositories\AlertEmailResponseRepository;
use App\Site\SiteContainer;
use App\Utils\EntityUtils;
use Doctrine\ORM\EntityManager;
use League\Container\Container;
use League\FactoryMuffin\FactoryMuffin;
use League\Route\RouteCollection;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;


/**
 * Class CrudAlertEmailResponseApiViewTest
 * @package Tests\Api
 */
class CrudAlertEmailResponseApiViewTest extends TestCase
{
    const BASE_ROUTE = '/api/alert-email-response';

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

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function setUp()
    {
        EntityUtils::$mockedEm = null;

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

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function testCreateRegisterSuccessfully()
    {
        $body = [
            'code' => 1,
            'internalMsg' => 'test',
            'emailMsg' => 'test',
        ];

        EntityUtils::$mockedEm = $this->createMock(EntityManager::class);

        EntityUtils::$mockedEm->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(AlertEmailResponse::class));

        EntityUtils::$mockedEm->expects($this->once())
            ->method('flush')
            ->with($this->isInstanceOf(AlertEmailResponse::class));

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

        $mockedRepo = $this->createMock(AlertEmailResponseRepository::class);

        $mockedRegisters = [];
        \array_push($mockedRegisters, self::$fm->instance(AlertEmailResponse::class, ['id' => 1]));
        \array_push($mockedRegisters, self::$fm->instance(AlertEmailResponse::class, ['id' => 2]));
        \array_push($mockedRegisters, self::$fm->instance(AlertEmailResponse::class, ['id' => 3]));
        \array_push($mockedRegisters, self::$fm->instance(AlertEmailResponse::class, ['id' => 4]));
        \array_push($mockedRegisters, self::$fm->instance(AlertEmailResponse::class, ['id' => 5]));

        $mockedRepo->expects($this->once())
            ->method('findAll')
            ->willReturn($mockedRegisters);

        EntityUtils::$mockedEm->expects($this->once())
            ->method('getRepository')
            ->with(AlertEmailResponse::class)
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
        $this->assertArrayHasKey('code', $item0);
        $this->assertArrayHasKey('internalMsg', $item0);
        $this->assertArrayHasKey('emailMsg', $item0);
    }

    public function testReadRegisterSuccessfully()
    {
        EntityUtils::$mockedEm = $this->createMock(EntityManager::class);

        $mockedRepo = $this->createMock(AlertEmailResponseRepository::class);

        $mockedRegister = self::$fm->instance(AlertEmailResponse::class, ['id' => 1]);

        $mockedRepo->expects($this->once())
            ->method('find')
            ->willReturn($mockedRegister);

        EntityUtils::$mockedEm->expects($this->once())
            ->method('getRepository')
            ->with(AlertEmailResponse::class)
            ->willReturn($mockedRepo);

        $request = TestUtils::makeServerRequestMock('GET', self::BASE_ROUTE . '/1');
        $request = $request->withHeader('authorization', 'Bearer ' . TestUtils::API_TOKEN);

        $response = self::$router->dispatch($request, self::$container->get('response'));

        TestUtils::runDefaultTestsJsonApiResponse($this, $response);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('id', $responseArray);
        $this->assertArrayHasKey('code', $responseArray);
        $this->assertArrayHasKey('internalMsg', $responseArray);
        $this->assertArrayHasKey('emailMsg', $responseArray);
        $this->assertEquals(1, (int)$responseArray['id']);
    }

    public function testUpdateRegisterSuccessfully()
    {
        $body = [
            'code' => 2,
            'internalMsg' => 'test',
            'emailMsg' => 'test',
        ];

        EntityUtils::$mockedEm = $this->createMock(EntityManager::class);

        $mockedRepo = $this->createMock(AlertEmailResponseRepository::class);

        $mockedRegister = self::$fm->instance(AlertEmailResponse::class, ['id' => 1]);

        $mockedRepo->expects($this->once())
            ->method('find')
            ->with($this->identicalTo(1))
            ->willReturn($mockedRegister);

        EntityUtils::$mockedEm->expects($this->once())
            ->method('getRepository')
            ->with(AlertEmailResponse::class)
            ->willReturn($mockedRepo);

        EntityUtils::$mockedEm->expects($this->once())
            ->method('merge')
            ->with($this->isInstanceOf(AlertEmailResponse::class));

        EntityUtils::$mockedEm->expects($this->once())
            ->method('flush')
            ->with($this->isInstanceOf(AlertEmailResponse::class));

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
        $request = TestUtils::makeServerRequestMock('DELETE', self::BASE_ROUTE . '/1');
        $request = $request->withHeader('authorization', 'Bearer ' . TestUtils::API_TOKEN);

        $response = self::$router->dispatch($request, self::$container->get('response'));

        TestUtils::runDefaultTestsJsonApiResponse($this, $response);

        $this->assertEquals(403, $response->getStatusCode());
    }
}