<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 2/08/18
 * Time: 02:50 PM
 */

namespace Tests\Api;


use App\Entities\Cfdi;
use App\Exceptions\ValidationException;
use App\Site\SiteContainer;
use App\Site\SiteRouter;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use League\Container\Container;
use League\FactoryMuffin\FactoryMuffin;
use League\Route\RouteCollection;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;

class GetFilteredCfdiRegistersCountApiViewTest extends TestCase
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

        TestUtils::initConsts();

        self::$fm = TestUtils::initFactories();

        self::initEm();
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    private static function initEm()
    {
        self::$em = self::$container->get('entity-manager');

        $billInfoMetadata = self::$em->getClassMetadata(Cfdi::class);
        self::$em->getConnection()->exec('TRUNCATE ' . $billInfoMetadata->getTableName());
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

        $billInfoMetadata = self::$em->getClassMetadata(Cfdi::class);
        self::$em->getConnection()->exec('TRUNCATE ' . $billInfoMetadata->getTableName());
    }

    public function testUpAndRunning()
    {
        $this->expectException(ValidationException::class);

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info/count');
        self::$router->dispatch($request, self::$container->get('response'));
    }

    public function testGetFilteredBillInfoRegistersCountWithDates()
    {
        $now = new \DateTime();

        self::$em->beginTransaction();
        try {
            $pastMonthDatetime = clone $now;
            $pastMonthDatetime->modify('first day of this month');
            $pastMonthDatetime->modify('yesterday');

            $nowCounter = 5;

            $seedCount = 10;
            for ($i = 0; $i < $seedCount; ++$i) {
                $billInfo = self::$fm->instance(Cfdi::class, [
                    'type' => 'I',
                    'emailDatetime' => $pastMonthDatetime,
                ]);

                if ($nowCounter > 0) {
                    $billInfo->setEmailDatetime($now);
                    $nowCounter--;
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

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info/count', $params);
        $response = self::$router->dispatch($request, self::$container->get('response'));

        $this->assertNotNull($response);
        $this->assertTrue($response->hasHeader(TestUtils::HEADER_CONTENT_TYPE));

        $contentType = $response->getHeaderLine(TestUtils::HEADER_CONTENT_TYPE);
        $this->assertEquals($contentType, TestUtils::CONTENT_TYPE_APPLICATION_JSON_UTF8);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('count', $responseArray);
        $this->assertEquals(5, $responseArray['count']);
    }

    public function testGetFilteredBillInfoRegistersCountWithDatesAndClientRfc()
    {
        $now = new \DateTime();
        $testRfc = 'HEBC930922HY0';

        self::$em->beginTransaction();
        try {
            $testRfcCounter = 3;

            $seedCount = 10;
            for ($i = 0; $i < $seedCount; ++$i) {
                $billInfo = self::$fm->instance(Cfdi::class, [
                    'type' => 'I',
                    'emailDatetime' => $now,
                ]);

                if ($testRfcCounter > 0) {
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

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info/count', $params);
        $response = self::$router->dispatch($request, self::$container->get('response'));

        $this->assertNotNull($response);
        $this->assertTrue($response->hasHeader(TestUtils::HEADER_CONTENT_TYPE));

        $contentType = $response->getHeaderLine(TestUtils::HEADER_CONTENT_TYPE);
        $this->assertEquals($contentType, TestUtils::CONTENT_TYPE_APPLICATION_JSON_UTF8);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('count', $responseArray);
        $this->assertEquals(3, $responseArray['count']);
    }

    public function testGetFilteredBillInfoRegistersCountWithDatesAndRangeAmounts()
    {
        $now = new \DateTime();
        $testAmount = 500;

        self::$em->beginTransaction();
        try {
            $testAmounts = 3;

            $seedCount = 10;
            for ($i = 0; $i < $seedCount; ++$i) {
                $billInfo = self::$fm->instance(Cfdi::class, [
                    'type' => 'I',
                    'total' => 1000,
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
        } catch (ORMException $e) {
            echo "\n" . $e->getMessage();
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
            'initialAmount' => $testAmount,
            'finalAmount' => $testAmount,
            'filterDateType' => 3,
        ];

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info/count', $params);
        $response = self::$router->dispatch($request, self::$container->get('response'));

        $this->assertNotNull($response);
        $this->assertTrue($response->hasHeader(TestUtils::HEADER_CONTENT_TYPE));

        $contentType = $response->getHeaderLine(TestUtils::HEADER_CONTENT_TYPE);
        $this->assertEquals($contentType, TestUtils::CONTENT_TYPE_APPLICATION_JSON_UTF8);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('count', $responseArray);
        $this->assertEquals(3, $responseArray['count']);
    }
}