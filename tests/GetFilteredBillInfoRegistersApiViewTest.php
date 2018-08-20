<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 2/08/18
 * Time: 02:50 PM
 */

namespace Tests;


use App\Entities\BillInfo;
use App\Entities\CfdiUse;
use App\Exceptions\ValidationException;
use App\Site\SiteContainer;
use App\Site\SiteRouter;
use Doctrine\Common\Persistence\Mapping\MappingException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use League\Container\Container;
use League\FactoryMuffin\FactoryMuffin;
use League\Route\RouteCollection;
use PHPUnit\Framework\TestCase;

class GetFilteredBillInfoRegistersApiViewTest extends TestCase
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

        self::initEm();
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    private static function initEm()
    {
        self::$em = self::$container->get('entity-manager');

        $classMetadata = self::$em->getClassMetadata(BillInfo::class);
        self::$em->getConnection()->exec('TRUNCATE ' . $classMetadata->getTableName());

        $classMetadata = self::$em->getClassMetadata(CfdiUse::class);
        self::$em->getConnection()->exec('TRUNCATE ' . $classMetadata->getTableName());

        try {
            TestUtils::insertInitialCfdiUses(self::$em);
        } catch (MappingException $e) {
        } catch (ORMException $e) {
        }
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function setUp()
    {
        self::$router = self::$container->get('router');

        if (!self::$em || !self::$em->isOpen()) {
            self::initEm();
        }
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function tearDown()
    {
        self::$router = null;

        $billInfoMetadata = self::$em->getClassMetadata(BillInfo::class);
        self::$em->getConnection()->exec('TRUNCATE ' . $billInfoMetadata->getTableName());
    }

    public function testUpAndRunning()
    {
        $this->expectException(ValidationException::class);

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info');
        self::$router->dispatch($request, self::$container->get('response'));
    }

    public function testGetFilteredBillInfoRegistersWithDates()
    {
        $now = new \DateTime();

        self::$em->beginTransaction();
        try {
            $pastMonthDatetime = clone $now;
            $pastMonthDatetime->modify('first day of this month');
            $pastMonthDatetime->modify('yesterday');

            $pastMonthDatetimeCounter = 5;

            $seedCount = 10;
            for ($i = 0; $i < $seedCount; ++$i) {
                $billInfo = self::$fm->instance(BillInfo::class, [
                    'type' => 'I',
                    'emailDatetime' => $now,
                ]);

                if ($pastMonthDatetimeCounter > 0) {
                    $billInfo->setEmailDatetime($pastMonthDatetime);
                    $pastMonthDatetimeCounter--;
                }

                self::$em->persist($billInfo);
            }

            self::$em->flush();
            self::$em->commit();
        } catch (ORMException $e) {
            self::$em->rollback();
        }

        $startDatetime = clone $now;
        $startDatetime->modify('first day of this month');
        $startDatetimeStr = $startDatetime->format('Y-m-d H:i:s');

        $endDatetime = clone $now;
        $endDatetime->modify('last day of this month');
        $endDatetime->setTime(23, 59, 59);
        $endDatetimeStr = $endDatetime->format('Y-m-d H:i:s');

        $offset = 0;
        $limit = 10;

        $params = [
            'limit' => $limit,
            'offset' => $offset,
            'startDatetime' => $startDatetimeStr,
            'endDatetime' => $endDatetimeStr,
            'filterDateType' => 3,
        ];

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info', $params);
        $response = self::$router->dispatch($request, self::$container->get('response'));

        $this->assertNotNull($response);
        $this->assertTrue($response->hasHeader(TestUtils::HEADER_CONTENT_TYPE));

        $contentType = $response->getHeaderLine(TestUtils::HEADER_CONTENT_TYPE);
        $this->assertEquals($contentType, TestUtils::CONTENT_TYPE_APPLICATION_JSON_UTF8);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('data', $responseArray);
        $this->assertEquals(5, \count($responseArray['data']));

        $item0 = $responseArray['data'][0];
        $this->validateBillInfoItemArray($item0);
    }

    public function testGetFilteredBillInfoRegistersWithDatesAndClientRfc()
    {
        $now = new \DateTime();
        $testRfc = 'HEBC930922HY0';

        self::$em->beginTransaction();
        try {
            $pastMonthDatetime = clone $now;
            $pastMonthDatetime->modify('first day of this month');
            $pastMonthDatetime->modify('yesterday');

            $pastMonthDatetimeCounter = 5;
            $testRfcCounter = 3;

            $seedCount = 10;
            for ($i = 0; $i < $seedCount; ++$i) {
                $billInfo = self::$fm->instance(BillInfo::class, [
                    'type' => 'I',
                    'emailDatetime' => $now,
                ]);

                if ($pastMonthDatetimeCounter > 0) {
                    $billInfo->setEmailDatetime($pastMonthDatetime);
                    $pastMonthDatetimeCounter--;
                } else if ($testRfcCounter > 0) {
                    $billInfo->setEmitterRfc($testRfc);
                    $testRfcCounter--;
                }

                self::$em->persist($billInfo);
            }

            self::$em->flush();
            self::$em->commit();
        } catch (ORMException $e) {
            self::$em->rollback();
        }

        $startDatetime = clone $now;
        $startDatetime->modify('first day of this month');
        $startDatetimeStr = $startDatetime->format('Y-m-d H:i:s');

        $endDatetime = clone $now;
        $endDatetime->modify('last day of this month');
        $endDatetime->setTime(23, 59, 59);
        $endDatetimeStr = $endDatetime->format('Y-m-d H:i:s');

        $offset = 0;
        $limit = 10;

        $params = [
            'limit' => $limit,
            'offset' => $offset,
            'startDatetime' => $startDatetimeStr,
            'endDatetime' => $endDatetimeStr,
            'clientRfc' => $testRfc,
            'filterDateType' => 3,
        ];

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info', $params);
        $response = self::$router->dispatch($request, self::$container->get('response'));

        $this->assertNotNull($response);
        $this->assertTrue($response->hasHeader(TestUtils::HEADER_CONTENT_TYPE));

        $contentType = $response->getHeaderLine(TestUtils::HEADER_CONTENT_TYPE);
        $this->assertEquals($contentType, TestUtils::CONTENT_TYPE_APPLICATION_JSON_UTF8);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('data', $responseArray);
        $this->assertEquals(3, \count($responseArray['data']));

        $item0 = $responseArray['data'][0];
        $this->validateBillInfoItemArray($item0);

        $this->assertEquals($testRfc, $item0['emitterRfc']);
    }

    public function testGetFilteredBillInfoRegistersWithDatesAndRangeAmounts()
    {
        $now = new \DateTime();
        $testAmount = 500;

        self::$em->beginTransaction();
        try {
            $pastMonthDatetime = clone $now;
            $pastMonthDatetime->modify('first day of this month');
            $pastMonthDatetime->modify('yesterday');

            $testAmounts = 3;

            $seedCount = 10;
            for ($i = 0; $i < $seedCount; ++$i) {
                $billInfo = self::$fm->instance(BillInfo::class, [
                    'type' => 'I',
                    'total' => (2*$testAmount),
                    'emailDatetime' => $now,
                ]);

                if ($testAmounts > 0) {
                    $billInfo->setTotal($testAmount);
                    $testAmounts--;
                }

                self::$em->persist($billInfo);
            }

            self::$em->flush();
            self::$em->commit();
        } catch (\Exception $e) {
            self::$em->rollback();
        }

        $startDatetime = clone $now;
        $startDatetime->modify('first day of this month');
        $startDatetimeStr = $startDatetime->format('Y-m-d H:i:s');

        $endDatetime = clone $now;
        $endDatetime->modify('last day of this month');
        $endDatetime->setTime(23, 59, 59);
        $endDatetimeStr = $endDatetime->format('Y-m-d H:i:s');

        $offset = 0;
        $limit = 10;

        $params = [
            'limit' => $limit,
            'offset' => $offset,
            'startDatetime' => $startDatetimeStr,
            'endDatetime' => $endDatetimeStr,
            'initialAmount' => ($testAmount - 100),
            'finalAmount' => ($testAmount + 100),
            'filterDateType' => 3,
        ];

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info', $params);
        $response = self::$router->dispatch($request, self::$container->get('response'));

        $this->assertNotNull($response);
        $this->assertTrue($response->hasHeader(TestUtils::HEADER_CONTENT_TYPE));

        $contentType = $response->getHeaderLine(TestUtils::HEADER_CONTENT_TYPE);
        $this->assertEquals($contentType, TestUtils::CONTENT_TYPE_APPLICATION_JSON_UTF8);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('data', $responseArray);
        $this->assertEquals(3, \count($responseArray['data']));

        $item0 = $responseArray['data'][0];
        $this->validateBillInfoItemArray($item0);

        $this->assertEquals($testAmount, $item0['total']);
    }

    private function validateBillInfoItemArray($item)
    {
        $this->assertArrayHasKey('id', $item);
        $this->assertArrayHasKey('email', $item);
        $this->assertArrayHasKey('emitterName', $item);
        $this->assertArrayHasKey('emitterRfc', $item);
        $this->assertArrayHasKey('uuid', $item);
        $this->assertArrayHasKey('cfdiUseSatCode', $item);
        $this->assertArrayHasKey('cfdiUseName', $item);
        $this->assertArrayHasKey('subtotal', $item);
        $this->assertArrayHasKey('discount', $item);
        $this->assertArrayHasKey('total', $item);
        $this->assertArrayHasKey('currency', $item);
        $this->assertArrayHasKey('type', $item);
        $this->assertArrayHasKey('paymentType', $item);
        $this->assertArrayHasKey('documentDatetime', $item);
        $this->assertArrayHasKey('stampDatetime', $item);
        $this->assertArrayHasKey('emailDatetime', $item);
        $this->assertArrayHasKey('regDatetime', $item);
        $this->assertArrayHasKey('hasPdf', $item);
    }
}