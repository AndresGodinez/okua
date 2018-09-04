<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 26/07/18
 * Time: 12:38 PM
 */

namespace Tests\Entities;

use App\Entities\AlertEmailResponse;
use App\Site\SiteContainer;
use Doctrine\DBAL\ConnectionException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use League\Container\Container;
use League\FactoryMuffin\FactoryMuffin;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;


/**
 * Class AlertEmailResponseEntityTest
 * @package Tests\Entities
 */
class AlertEmailResponseEntityTest extends TestCase
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
        $metadata = self::$em->getClassMetadata(AlertEmailResponse::class);
        self::$em->getConnection()->exec('TRUNCATE ' . $metadata->getTableName());
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

        $metadata = self::$em->getClassMetadata(AlertEmailResponse::class);
        self::$em->getConnection()->exec('ALTER TABLE ' . $metadata->getTableName() . ' AUTO_INCREMENT = 1');

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
        $register = self::$fm->instance(AlertEmailResponse::class);

        self::$em->persist($register);
        self::$em->flush();

        $this->assertEquals($register->getId(), 1);
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testErrorNullCode()
    {
        $this->expectException(\TypeError::class);

        $user = self::$fm->instance(AlertEmailResponse::class, ['code' => null]);
        self::$em->persist($user);
        self::$em->flush();
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testErrorNullInternalMsg()
    {
        $this->expectException(\TypeError::class);

        $user = self::$fm->instance(AlertEmailResponse::class, ['internalMsg' => null]);
        self::$em->persist($user);
        self::$em->flush();
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testErrorNullEmailMsg()
    {
        $this->expectException(\TypeError::class);

        $user = self::$fm->instance(AlertEmailResponse::class, ['emailMsg' => null]);
        self::$em->persist($user);
        self::$em->flush();
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testErrorSameCode()
    {
        $this->expectException(UniqueConstraintViolationException::class);

        $user = self::$fm->instance(AlertEmailResponse::class, ['code' => 1]);
        self::$em->persist($user);
        self::$em->flush();

        $user = self::$fm->instance(AlertEmailResponse::class, ['code' => 1]);
        self::$em->persist($user);
        self::$em->flush();
    }
}