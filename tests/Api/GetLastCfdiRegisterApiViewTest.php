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
 * Class GetLastBillInfoRegisterApiViewTest
 * @package Tests\Api
 */
class GetLastBillInfoRegisterApiViewTest extends TestCase
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

        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info/last-registers');
        self::$router->dispatch($request, self::$container->get('response'));
    }

    public function testGetLastRegistersWithLimit()
    {
        $now = new \DateTime();

        self::$em->beginTransaction();
        try {
            $register = self::$fm->instance(Cfdi::class, ['type' => 'I', 'total' => 500, 'emailDatetime' => $now, 'email' => 'carlos.hernandez@connectit.com.mx']);
            self::$em->persist($register);

            $now1 = clone $now;
            $now1->modify('-1 day');
            $register = self::$fm->instance(Cfdi::class, ['type' => 'I', 'total' => 500, 'emailDatetime' => $now1, 'email' => 'carlos.hernandez@connectit.com.mx']);
            self::$em->persist($register);


            $register = self::$fm->instance(Cfdi::class, ['type' => 'I', 'total' => 500, 'emailDatetime' => $now1, 'email' => 'carlos.hernandez@connectit.com.mx']);
            self::$em->persist($register);

            $now2 = clone $now1;
            $now2->modify('-1 hour');
            $register = self::$fm->instance(Cfdi::class, ['type' => 'I', 'total' => 500, 'emailDatetime' => $now2, 'email' => 'israel.torres@connectit.com.mx']);
            self::$em->persist($register);

            $now3 = clone $now2;
            $now3->modify('-1 hour');
            $register = self::$fm->instance(Cfdi::class, ['type' => 'I', 'total' => 500, 'emailDatetime' => $now3, 'email' => 'adan.morales@connectit.com.mx']);
            self::$em->persist($register);

            $now4 = clone $now3;
            $now4->modify('-1 hour');
            $register = self::$fm->instance(Cfdi::class, ['type' => 'I', 'total' => 500, 'emailDatetime' => $now4, 'email' => 'adan.morales@connectit.com.mx']);
            self::$em->persist($register);

            $now5 = clone $now4;
            $now5->modify('-1 minute');
            $register = self::$fm->instance(Cfdi::class, ['type' => 'I', 'total' => 500, 'emailDatetime' => $now5, 'email' => 'diego.soto@connectit.com.mx']);
            self::$em->persist($register);

            self::$em->flush();
            self::$em->commit();
        } catch (ORMException $e) {
            self::$em->rollback();
        }

        $limit = 5;
        $request = TestUtils::makeServerRequestMock('GET', '/api/bill-info/last-registers', ['limit' => $limit]);
        $response = self::$router->dispatch($request, self::$container->get('response'));

        $this->assertNotNull($response);
        $this->assertTrue($response->hasHeader(TestUtils::HEADER_CONTENT_TYPE));

        $contentType = $response->getHeaderLine(TestUtils::HEADER_CONTENT_TYPE);
        $this->assertEquals($contentType, TestUtils::CONTENT_TYPE_APPLICATION_JSON_UTF8);

        $responseArray = \json_decode($response->getBody(), true);

        $this->assertArrayHasKey('data', $responseArray);
        $this->assertEquals($limit, \count($responseArray['data']));

        $item0 = $responseArray['data'][0];

        $this->assertArrayHasKey('emitterRfc', $item0);
        $this->assertArrayHasKey('emitterName', $item0);
        $this->assertArrayHasKey('email', $item0);
        $this->assertArrayHasKey('emailDatetime', $item0);
        $this->assertArrayHasKey('total', $item0);
        $this->assertArrayHasKey('stampStatus', $item0);
        $this->assertArrayHasKey('hasPdf', $item0);
    }
}