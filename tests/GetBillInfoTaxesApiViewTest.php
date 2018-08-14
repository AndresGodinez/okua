<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 2/08/18
 * Time: 02:50 PM
 */

namespace Tests;


use App\Entities\BillInfo;
use App\Entities\BillInfoTax;
use App\Exceptions\ValidationException;
use App\Site\SiteContainer;
use App\Site\SiteRouter;
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

        $billInfoTaxMetadata = self::$em->getClassMetadata(BillInfoTax::class);
        self::$em->getConnection()->exec('TRUNCATE ' . $billInfoTaxMetadata->getTableName());
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

        $billInfoMetadata = self::$em->getClassMetadata(BillInfo::class);
        self::$em->getConnection()->exec('TRUNCATE ' . $billInfoMetadata->getTableName());

        $billInfoTaxMetadata = self::$em->getClassMetadata(BillInfoTax::class);
        self::$em->getConnection()->exec('TRUNCATE ' . $billInfoTaxMetadata->getTableName());
    }

    public function testUpAndRunning()
    {
        $this->expectException(ValidationException::class);

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info/1/taxes');
        self::$router->dispatch($request, self::$container->get('response'));
    }

    public function testGetBillInfoTaxes()
    {
        self::$em->beginTransaction();
        try {
            /** @var BillInfo $register */
            $register = self::$fm->instance(BillInfo::class, [
                'type' => 'I',
                'subtotal' => 431.03,
                'discount' => 0.00,
                'transferTaxes' => 68.97,
                'withheldTaxes' => 0.00,
                'total' => 500,
                'emailDatetime' => new \DateTime()
            ]);

            /** @var BillInfoTax $taxRegister */
            $taxRegister = self::$fm->instance(BillInfoTax::class, [
                'taxSatCode' => '002',
                'type' => 't',
                'taxFactor' => 'rate',
                'taxRateFee' => 0.16,
                'amount' => 68.97,
            ]);
            $taxRegister->setBillInfo($register);

            /** @var BillInfoTax $taxRegister2 */
            $taxRegister2 = self::$fm->instance(BillInfoTax::class, [
                'taxSatCode' => '002',
                'type' => 't',
                'taxFactor' => 'rate',
                'taxRateFee' => 0.00,
                'amount' => 0.00,
            ]);
            $taxRegister2->setBillInfo($register);

            $register->addTax($taxRegister);
            $register->addTax($taxRegister2);

            self::$em->persist($register);

            self::$em->flush();
            self::$em->commit();
        } catch (ORMException $e) {
            self::$em->rollback();
        }

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info/1/taxes');
        $response = self::$router->dispatch($request, self::$container->get('response'));

        $this->assertNotNull($response);
        $this->assertTrue($response->hasHeader(TestUtils::HEADER_CONTENT_TYPE));

        $contentType = $response->getHeaderLine(TestUtils::HEADER_CONTENT_TYPE);
        $this->assertEquals($contentType, TestUtils::CONTENT_TYPE_APPLICATION_JSON_UTF8);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('data', $responseArray);
        $this->assertNotEmpty($responseArray['data']);
        $this->assertEquals(2, \count($responseArray['data']));
    }

    public function testGetBillInfoTaxesItemHasCorrectKeys()
    {
        self::$em->beginTransaction();
        try {
            /** @var BillInfo $register */
            $register = self::$fm->instance(BillInfo::class, [
                'type' => 'I',
                'subtotal' => 431.03,
                'discount' => 0.00,
                'transferTaxes' => 68.97,
                'withheldTaxes' => 0.00,
                'total' => 500,
                'emailDatetime' => new \DateTime()
            ]);

            /** @var BillInfoTax $taxRegister */
            $taxRegister = self::$fm->instance(BillInfoTax::class, [
                'taxSatCode' => '002',
                'type' => 't',
                'taxFactor' => 'rate',
                'taxRateFee' => 0.16,
                'amount' => 68.97,
            ]);
            $taxRegister->setBillInfo($register);

            $register->addTax($taxRegister);

            self::$em->persist($register);

            self::$em->flush();
            self::$em->commit();
        } catch (ORMException $e) {
            self::$em->rollback();
        }

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info/1/taxes');
        $response = self::$router->dispatch($request, self::$container->get('response'));

        $this->assertNotNull($response);
        $this->assertTrue($response->hasHeader(TestUtils::HEADER_CONTENT_TYPE));

        $contentType = $response->getHeaderLine(TestUtils::HEADER_CONTENT_TYPE);
        $this->assertEquals($contentType, TestUtils::CONTENT_TYPE_APPLICATION_JSON_UTF8);

        $responseArray = \json_decode($response->getBody(), true);

        $item = $responseArray['data'][0];
        $this->assertArrayHasKey('id', $item);
        $this->assertArrayHasKey('taxSatCode', $item);
        $this->assertArrayHasKey('type', $item);
        $this->assertArrayHasKey('taxFactor', $item);
        $this->assertArrayHasKey('taxRateFee', $item);
        $this->assertArrayHasKey('amount', $item);
    }

    public function testErrorGetBillInfoTaxesRegisterNotFound()
    {
        $this->expectException(ValidationException::class);

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info/1/taxes');
        self::$router->dispatch($request, self::$container->get('response'));
    }

    public function testGetBillInfoTaxesNoTaxes()
    {
        self::$em->beginTransaction();
        try {
            /** @var BillInfo $register */
            $register = self::$fm->instance(BillInfo::class, [
                'type' => 'I',
                'subtotal' => 431.03,
                'discount' => 0.00,
                'transferTaxes' => 68.97,
                'withheldTaxes' => 0.00,
                'total' => 500,
                'emailDatetime' => new \DateTime()
            ]);

            self::$em->persist($register);

            self::$em->flush();
            self::$em->commit();
        } catch (ORMException $e) {
            self::$em->rollback();
        }

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info/1/taxes');
        $response = self::$router->dispatch($request, self::$container->get('response'));

        $this->assertNotNull($response);
        $this->assertTrue($response->hasHeader(TestUtils::HEADER_CONTENT_TYPE));

        $contentType = $response->getHeaderLine(TestUtils::HEADER_CONTENT_TYPE);
        $this->assertEquals($contentType, TestUtils::CONTENT_TYPE_APPLICATION_JSON_UTF8);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('data', $responseArray);
        $this->assertEmpty($responseArray['data']);
    }
}