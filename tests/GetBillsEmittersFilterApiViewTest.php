<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/08/18
 * Time: 04:01 PM
 */

namespace Tests;


use App\Entities\BillInfo;
use App\Exceptions\ValidationException;
use App\Site\SiteContainer;
use Doctrine\ORM\EntityManager;
use League\Container\Container;
use League\FactoryMuffin\FactoryMuffin;
use League\Route\RouteCollection;
use PHPUnit\Framework\TestCase;

class GetBillsEmittersFilterApiViewTest extends TestCase
{
    /** @var Container */
    protected static $container = null;

    /** @var EntityManager */
    protected static $em = null;

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

        self::$fm = new FactoryMuffin();

        /** @noinspection PhpDynamicAsStaticMethodCallInspection */
        self::$fm->loadFactories(__DIR__ . DIRECTORY_SEPARATOR . 'factories');

        if (!defined("BASE_DIR")) {
            define("BASE_DIR", \realpath(__DIR__ . "/../"));
        }

        if (!defined("TESTING")) {
            define("TESTING", true);
        }

        self::$em = self::$container->get('entity-manager');

        $billInfoMetadata = self::$em->getClassMetadata(BillInfo::class);
        self::$em->getConnection()->exec('TRUNCATE ' . $billInfoMetadata->getTableName());

        self::initDb();
    }

    private static function initDb()
    {
        self::$em->beginTransaction();

        try {
            $seedCount = 20;
            for ($i = 0; $i < $seedCount; ++$i) {
                $billInfo = self::$fm->instance(BillInfo::class, [
                    'type' => 'I',
                    'emitterName' => 'ISRAEL TORRES',
                    'emitterRfc' => 'TOSI830410PL7',
                ]);

                self::$em->persist($billInfo);
            }

            $register = self::$fm->instance(BillInfo::class, ['type' => 'I', 'emitterName' => 'CONEXIÓN TECNOLÓGICA SANTIAGO S.A. DE C.V.', 'emitterRfc' => 'CTS140515S7A']);
            self::$em->persist($register);

            $register = self::$fm->instance(BillInfo::class, ['type' => 'I', 'emitterName' => 'CARLOS HERNANDEZ', 'emitterRfc' => 'HEBC930922HY0']);
            self::$em->persist($register);

            self::$em->flush();
            self::$em->commit();
        } catch (ORMException $e) {
            self::$em->rollback();
        }
    }

    protected function setUp()
    {
        self::$router = self::$container->get('router');

        if (!self::$em || !self::$em->isOpen()) {
            self::$em = self::$container->get('entity-manager');
        }
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function tearDown()
    {
        self::$router = null;
    }

    public function testUpAndRunning()
    {
        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info-client');
        $response = self::$router->dispatch($request, self::$container->get('response'));

        $this->assertNotNull($response);
        $this->assertTrue($response->hasHeader(TestUtils::HEADER_CONTENT_TYPE));

        $contentType = $response->getHeaderLine(TestUtils::HEADER_CONTENT_TYPE);
        $this->assertEquals($contentType, TestUtils::CONTENT_TYPE_APPLICATION_JSON_UTF8);
    }

    public function testValidateResponseStructure()
    {
        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info-client');
        $response = self::$router->dispatch($request, self::$container->get('response'));

        $this->assertNotNull($response);
        $this->assertTrue($response->hasHeader(TestUtils::HEADER_CONTENT_TYPE));

        $contentType = $response->getHeaderLine(TestUtils::HEADER_CONTENT_TYPE);
        $this->assertEquals($contentType, TestUtils::CONTENT_TYPE_APPLICATION_JSON_UTF8);

        $responseArray = \json_decode($response->getBody(), true);
        $this->assertArrayHasKey('data', $responseArray);
        $this->assertEquals(3, \count($responseArray['data']));

        $item0 = $responseArray['data'][0];
        $this->validateBillInfoClientItemArray($item0);
    }

    private function validateBillInfoClientItemArray($item)
    {
        $this->assertArrayHasKey('emitterName', $item);
        $this->assertArrayHasKey('emitterRfc', $item);
    }
}