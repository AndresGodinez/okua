<?php

namespace Tests;

use App\Entities\CfdiUse;
use App\Site\SiteContainer;
use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManager;
use League\Container\Container;
use League\FactoryMuffin\FactoryMuffin;
use PHPUnit\Framework\TestCase;


/**
 * Class CfdiUseEntityTest
 * @package Tests
 */
class CfdiUseEntityTest extends TestCase
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
        if (!defined("BASE_DIR")) {
            define("BASE_DIR", \realpath(__DIR__ . "/../"));
        }

        if (!defined("TESTING")) {
            define("TESTING", true);
        }

        self::$fm = new FactoryMuffin();


        /** @noinspection PhpDynamicAsStaticMethodCallInspection */
        self::$fm->loadFactories(__DIR__ . DIRECTORY_SEPARATOR . 'factories');

        self::$container = SiteContainer::make();

        self::$em = self::$container->get('entity-manager');

        $classMetadata = self::$em->getClassMetadata(CfdiUse::class);
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

        $classMetadata = self::$em->getClassMetadata(CfdiUse::class);
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
        /** @var CfdiUse $testRegister */
        $testRegister = self::$fm->instance(CfdiUse::class);

        self::$em->persist($testRegister);
        self::$em->flush();

        $this->assertEquals(1, $testRegister->getId());
    }
}