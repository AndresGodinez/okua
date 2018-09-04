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


/**
 * Class GetCfdiTransferTaxesTotalApiViewTest
 * @package Tests\Api
 */
class GetCfdiTransferTaxesTotalApiViewTest extends TestCase
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

        self::$em = self::$container->get('entity-manager');

        $billInfoMetadata = self::$em->getClassMetadata(Cfdi::class);
        self::$em->getConnection()->exec('TRUNCATE ' . $billInfoMetadata->getTableName());
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

        $billInfoMetadata = self::$em->getClassMetadata(Cfdi::class);
        self::$em->getConnection()->exec('TRUNCATE ' . $billInfoMetadata->getTableName());
    }

    public function testUpAndRunning()
    {
        $this->expectException(ValidationException::class);

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info/taxes/transfer/total');
        self::$router->dispatch($request, self::$container->get('response'));
    }

    public function testFilterByWeek()
    {
        $now = new \DateTime();

        self::$em->beginTransaction();
        try {
            $register = self::$fm->instance(Cfdi::class, ['type' => 'I', 'transferTaxes' => 500, 'emailDatetime' => $now]);
            self::$em->persist($register);

            $register = self::$fm->instance(Cfdi::class, ['type' => 'I', 'transferTaxes' => 500, 'emailDatetime' => $now]);
            self::$em->persist($register);

            self::$em->flush();
            self::$em->commit();
        } catch (ORMException $e) {
            self::$em->rollback();
        }

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info/taxes/transfer/total', ['filter' => 'week']);
        $response = self::$router->dispatch($request, self::$container->get('response'));

        $this->assertNotNull($response);
        $this->assertTrue($response->hasHeader(TestUtils::HEADER_CONTENT_TYPE));

        $contentType = $response->getHeaderLine(TestUtils::HEADER_CONTENT_TYPE);
        $this->assertEquals($contentType, TestUtils::CONTENT_TYPE_APPLICATION_JSON_UTF8);

        $responseArray = \json_decode($response->getBody(), true);
        $this->assertArrayHasKey('total', $responseArray);

        $total = $responseArray['total'];

        $this->assertTrue(\is_numeric($total));
        $this->assertEquals(1000, $total);
    }

    public function testFilterByMonth()
    {
        $now = new \DateTime();

        self::$em->beginTransaction();
        try {
            $register = self::$fm->instance(Cfdi::class, ['type' => 'I', 'transferTaxes' => 500, 'emailDatetime' => $now]);
            self::$em->persist($register);

            $register = self::$fm->instance(Cfdi::class, ['type' => 'I', 'transferTaxes' => 500, 'emailDatetime' => $now]);
            self::$em->persist($register);

            $pastMonth = clone $now;
            $pastMonth->modify('first day of last month');
            $register = self::$fm->instance(Cfdi::class, ['type' => 'I', 'transferTaxes' => 500, 'emailDatetime' => $pastMonth]);
            self::$em->persist($register);

            self::$em->flush();
            self::$em->commit();
        } catch (ORMException $e) {
            self::$em->rollback();
        }

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info/taxes/transfer/total', ['filter' => 'month']);
        $response = self::$router->dispatch($request, self::$container->get('response'));

        $this->assertNotNull($response);
        $this->assertTrue($response->hasHeader(TestUtils::HEADER_CONTENT_TYPE));

        $contentType = $response->getHeaderLine(TestUtils::HEADER_CONTENT_TYPE);
        $this->assertEquals($contentType, TestUtils::CONTENT_TYPE_APPLICATION_JSON_UTF8);

        $responseArray = \json_decode($response->getBody(), true);
        $this->assertArrayHasKey('total', $responseArray);

        $total = $responseArray['total'];

        $this->assertTrue(\is_numeric($total));
        $this->assertEquals(1000, $total);
    }

    public function testFilterByYear()
    {
        $now = new \DateTime();

        self::$em->beginTransaction();
        try {
            $register = self::$fm->instance(Cfdi::class, ['type' => 'I', 'transferTaxes' => 100, 'emailDatetime' => $now]);
            self::$em->persist($register);

            $register = self::$fm->instance(Cfdi::class, ['type' => 'I', 'transferTaxes' => 100, 'emailDatetime' => $now]);
            self::$em->persist($register);

            $pastDatetime = clone $now;
            $pastDatetime->modify('first day of january');
            $pastDatetime->modify('yesterday');
            $register = self::$fm->instance(Cfdi::class, ['type' => 'I', 'transferTaxes' => 500, 'emailDatetime' => $pastDatetime]);
            self::$em->persist($register);

            self::$em->flush();
            self::$em->commit();
        } catch (ORMException $e) {
            self::$em->rollback();
        }

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info/taxes/transfer/total', ['filter' => 'year']);
        $response = self::$router->dispatch($request, self::$container->get('response'));

        $this->assertNotNull($response);
        $this->assertTrue($response->hasHeader(TestUtils::HEADER_CONTENT_TYPE));

        $contentType = $response->getHeaderLine(TestUtils::HEADER_CONTENT_TYPE);
        $this->assertEquals($contentType, TestUtils::CONTENT_TYPE_APPLICATION_JSON_UTF8);

        $responseArray = \json_decode($response->getBody(), true);
        $this->assertArrayHasKey('total', $responseArray);

        $total = $responseArray['total'];

        $this->assertTrue(\is_numeric($total));
        $this->assertEquals(200, $total);
    }
}