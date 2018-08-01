<?php

namespace Tests;

use App\Entities\BillInfo;
use App\Entities\User;
use App\Site\SiteContainer;
use App\Utils\EntityUtils;
use Doctrine\DBAL\ConnectionException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use League\Container\Container;
use League\FactoryMuffin\FactoryMuffin;
use PHPUnit\Framework\TestCase;


/**
 * Class BillInfoEntityTest
 * @package Tests
 */
class BillInfoEntityTest extends TestCase
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
        $userMetadata = self::$em->getClassMetadata(BillInfo::class);
        self::$em->getConnection()->exec('TRUNCATE ' . $userMetadata->getTableName());
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

        $userMetadata = self::$em->getClassMetadata(BillInfo::class);
        self::$em->getConnection()->exec('ALTER TABLE ' . $userMetadata->getTableName() . ' AUTO_INCREMENT = 1');

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
    public function testCreateUser()
    {
        $register = self::$fm->instance(BillInfo::class);

        self::$em->persist($register);
        self::$em->flush();

        $this->assertEquals($register->getId(), 1);
    }
}