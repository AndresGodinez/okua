<?php

namespace Tests;

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
 * Created by PhpStorm.
 * User: alberto
 * Date: 26/07/18
 * Time: 12:38 PM
 */
class UserEntityTest extends TestCase
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
        $userMetadata = self::$em->getClassMetadata(User::class);
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

        $userMetadata = self::$em->getClassMetadata(User::class);
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
        $user = self::$fm->instance(User::class);

        self::$em->persist($user);
        self::$em->flush();

        $this->assertEquals($user->getId(), 1);
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testErrorSameUsername()
    {
        $this->expectException(UniqueConstraintViolationException::class);

        $user = self::$fm->instance(User::class, ['username' => 'admin']);
        self::$em->persist($user);
        self::$em->flush();

        $user = self::$fm->instance(User::class, ['username' => 'admin']);
        self::$em->persist($user);
        self::$em->flush();
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testErrorSameEmail()
    {
        $this->expectException(UniqueConstraintViolationException::class);

        $user = self::$fm->instance(User::class, ['email' => 'admin@connectit.com.mx']);
        self::$em->persist($user);
        self::$em->flush();

        $user = self::$fm->instance(User::class, ['email' => 'admin@connectit.com.mx']);
        self::$em->persist($user);
        self::$em->flush();
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testCreateWithRegCreationDate()
    {
        $regCreationDate = new \DateTime();
        /** @var User $user */
        $user = self::$fm->instance(User::class, ['regCreationDate' => $regCreationDate]);
        self::$em->persist($user);
        self::$em->flush();

        $this->assertEquals($user->getId(), 1);

        /** @var User $dbRegister */
        $dbRegister = self::$em->find(User::class, 1);
        $this->assertNotNull($dbRegister);
        $this->assertEquals($dbRegister->getRegCreationDate(), $regCreationDate);
        $this->assertEquals($dbRegister->getRegStatus(), EntityUtils::REG_STATUS_ACTIVE);
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testSetRegStatusZero()
    {
        $user = self::$fm->instance(User::class);
        self::$em->persist($user);
        self::$em->flush();

        $this->assertEquals($user->getId(), 1);

        /** @var User $dbRegister */
        $dbRegister = self::$em->find(User::class, 1);
        $this->assertNotNull($dbRegister);
        $this->assertEquals($dbRegister->getRegStatus(), EntityUtils::REG_STATUS_ACTIVE);

        $dbRegister->setRegStatus(EntityUtils::REG_STATUS_INACTIVE);
        self::$em->persist($user);
        self::$em->flush();

        /** @var User $dbRegister */
        $dbRegister = self::$em->find(User::class, 1);
        $this->assertEquals($dbRegister->getId(), 1);
        $this->assertEquals($dbRegister->getRegStatus(), EntityUtils::REG_STATUS_INACTIVE);
    }
}