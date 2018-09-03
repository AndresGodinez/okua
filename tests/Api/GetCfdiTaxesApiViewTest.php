<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 2/08/18
 * Time: 02:50 PM
 */

namespace Tests\Api;


use App\Entities\Cfdi;
use App\Entities\CfdiTax;
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

class GetCfdiTaxesApiViewTest extends TestCase
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

        $cfdiMetadata = self::$em->getClassMetadata(Cfdi::class);
        self::$em->getConnection()->exec('TRUNCATE ' . $cfdiMetadata->getTableName());

        $cfdiTaxMetadata = self::$em->getClassMetadata(CfdiTax::class);
        self::$em->getConnection()->exec('TRUNCATE ' . $cfdiTaxMetadata->getTableName());
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

        $cfdiMetadata = self::$em->getClassMetadata(Cfdi::class);
        self::$em->getConnection()->exec('TRUNCATE ' . $cfdiMetadata->getTableName());

        $cfdiTaxMetadata = self::$em->getClassMetadata(CfdiTax::class);
        self::$em->getConnection()->exec('TRUNCATE ' . $cfdiTaxMetadata->getTableName());
    }

    public function testUpAndRunning()
    {
        $this->expectException(ValidationException::class);

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info/1/taxes');
        self::$router->dispatch($request, self::$container->get('response'));
    }

    public function testGetCfdiTaxes()
    {
        self::$em->beginTransaction();
        try {
            /** @var Cfdi $register */
            $register = self::$fm->instance(Cfdi::class, [
                'type' => 'I',
                'subtotal' => 431.03,
                'discount' => 0.00,
                'transferTaxes' => 68.97,
                'withheldTaxes' => 0.00,
                'total' => 500,
                'emailDatetime' => new \DateTime()
            ]);

            /** @var CfdiTax $taxRegister */
            $taxRegister = self::$fm->instance(CfdiTax::class, [
                'taxSatCode' => '002',
                'type' => 't',
                'taxFactor' => 'rate',
                'taxRateFee' => 0.16,
                'amount' => 68.97,
            ]);
            $taxRegister->setCfdi($register);

            /** @var CfdiTax $taxRegister2 */
            $taxRegister2 = self::$fm->instance(CfdiTax::class, [
                'taxSatCode' => '002',
                'type' => 't',
                'taxFactor' => 'rate',
                'taxRateFee' => 0.00,
                'amount' => 0.00,
            ]);
            $taxRegister2->setCfdi($register);

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

    public function testGetCfdiTaxesItemHasCorrectKeys()
    {
        self::$em->beginTransaction();
        try {
            /** @var Cfdi $register */
            $register = self::$fm->instance(Cfdi::class, [
                'type' => 'I',
                'subtotal' => 431.03,
                'discount' => 0.00,
                'transferTaxes' => 68.97,
                'withheldTaxes' => 0.00,
                'total' => 500,
                'emailDatetime' => new \DateTime()
            ]);

            /** @var CfdiTax $taxRegister */
            $taxRegister = self::$fm->instance(CfdiTax::class, [
                'taxSatCode' => '002',
                'type' => 't',
                'taxFactor' => 'rate',
                'taxRateFee' => 0.16,
                'amount' => 68.97,
            ]);
            $taxRegister->setCfdi($register);

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

    public function testErrorGetCfdiTaxesRegisterNotFound()
    {
        $this->expectException(ValidationException::class);

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info/1/taxes');
        self::$router->dispatch($request, self::$container->get('response'));
    }

    public function testGetCfdiTaxesNoTaxes()
    {
        self::$em->beginTransaction();
        try {
            /** @var Cfdi $register */
            $register = self::$fm->instance(Cfdi::class, [
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