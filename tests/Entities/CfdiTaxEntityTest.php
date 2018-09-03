<?php

namespace Tests\Entities;

use App\Entities\Cfdi;
use App\Entities\CfdiTax;
use App\Site\SiteContainer;
use Doctrine\DBAL\ConnectionException;
use Doctrine\DBAL\Driver\PDOException;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Doctrine\ORM\EntityManager;
use League\Container\Container;
use League\FactoryMuffin\FactoryMuffin;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;


/**
 * Class CfdiTaxEntityTest
 * @package Tests
 */
class CfdiTaxEntityTest extends TestCase
{
    /** @var Container */
    protected static $container = null;

    /** @var EntityManager */
    protected static $em = null;

    /** @var null|FactoryMuffin */
    protected static $fm = null;

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \League\FactoryMuffin\Exceptions\DirectoryNotFoundException
     */
    public static function setUpBeforeClass()/* The :void return type declaration that should be here would cause a BC issue */
    {
        TestUtils::initConsts();

        self::$fm = TestUtils::initFactories();

        self::$container = SiteContainer::make();

        self::$em = self::$container->get('entity-manager');

        $classMetadata = self::$em->getClassMetadata(CfdiTax::class);
        self::$em->getConnection()->exec('TRUNCATE ' . $classMetadata->getTableName());
    }

    public static function tearDownAfterClass()
    {
        self::$em->close();
        self::$em = null;
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function setUp()
    {
        if (!self::$em || !self::$em->isOpen()) {
            self::$em = self::$container->get('entity-manager');
        }

        $classMetadata = self::$em->getClassMetadata(CfdiTax::class);
        self::$em->getConnection()->exec('ALTER TABLE ' . $classMetadata->getTableName() . ' AUTO_INCREMENT = 1');

        self::$em->getConnection()->beginTransaction();
    }

    /**
     * @throws ConnectionException
     */
    protected function tearDown()
    {
        self::$em->getConnection()->rollBack();
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testCreateRegister()
    {
        /** @var Cfdi $billInfo */
        $billInfo = self::$fm->instance(Cfdi::class);
        self::$em->persist($billInfo);
        self::$em->flush();

        /** @var CfdiTax $register */
        $register = self::$fm->instance(CfdiTax::class);
        $register->setCfdi($billInfo);

        $billInfo->addTax($register);

        self::$em->persist($register);
        self::$em->flush();

        $this->assertEquals(1, $register->getId());

        $taxes = self::$em->getRepository(CfdiTax::class)->findAll();
        $this->assertEquals(1, \count($taxes));
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testErrorCreateWithoutBillInfo()
    {
         $this->expectException(NotNullConstraintViolationException::class);

        /** @var Cfdi $register */
        $register = self::$fm->instance(CfdiTax::class);

        self::$em->persist($register);
        self::$em->flush();
    }
}