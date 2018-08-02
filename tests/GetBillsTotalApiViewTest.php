<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 2/08/18
 * Time: 02:50 PM
 */

namespace Tests;


use App\Entities\BillInfo;
use App\Exceptions\ValidationException;
use App\Site\SiteContainer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use League\Container\Container;
use League\FactoryMuffin\FactoryMuffin;
use League\Route\RouteCollection;
use PHPUnit\Framework\TestCase;

class GetBillsTotalApiViewTest extends TestCase
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

        self::$router = self::$container->get('router');

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
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function setUp()
    {
        if (!self::$em || !self::$em->isOpen()) {
            self::$em = self::$container->get('entity-manager');
        }

        $billInfoMetadata = self::$em->getClassMetadata(BillInfo::class);
        self::$em->getConnection()->exec('ALTER TABLE ' . $billInfoMetadata->getTableName() . ' AUTO_INCREMENT = 1');
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function tearDown()
    {
        $billInfoMetadata = self::$em->getClassMetadata(BillInfo::class);
        self::$em->getConnection()->exec('TRUNCATE ' . $billInfoMetadata->getTableName());
    }

    public function testUpAndRunning()
    {
        $this->expectException(ValidationException::class);

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info/total');
        self::$router->dispatch($request, self::$container->get('response'));
    }

    public function testFilterByWeek()
    {
        $now = new \DateTime();

        self::$em->beginTransaction();
        try {
            $register = self::$fm->instance(BillInfo::class, ['type' => 'I', 'total' => 500, 'emailDatetime' => $now]);
            self::$em->persist($register);

            $register = self::$fm->instance(BillInfo::class, ['type' => 'I', 'total' => 500, 'emailDatetime' => $now]);
            self::$em->persist($register);

            self::$em->flush();
            self::$em->commit();
        } catch (ORMException $e) {
            self::$em->rollback();
        }

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info/total', ['filter' => 'week']);
        $response = self::$router->dispatch($request, self::$container->get('response'));

        $this->assertNotNull($response);
        $this->assertTrue($response->hasHeader(TestUtils::HEADER_CONTENT_TYPE));

        $contentType = $response->getHeaderLine(TestUtils::HEADER_CONTENT_TYPE);
        $this->assertEquals($contentType, TestUtils::CONTENT_TYPE_APPLICATION_JSON_UTF8);

        $responseArray = \json_decode($response->getBody(), true);
        $this->assertArrayHasKey('total', $responseArray);

        $total = $responseArray['total'];

        $this->assertTrue(\is_numeric($total));
        $this->assertEquals($total, 1000);
    }
}