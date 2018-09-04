<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 07:59 PM
 */

namespace Tests\Entities;

use App\Entities\Emitter;
use App\Site\SiteContainer;
use Doctrine\DBAL\ConnectionException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use League\Container\Container;
use League\FactoryMuffin\FactoryMuffin;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;


/**
 * Class EmitterEntityTest
 * @package Tests\Entities
 */
class EmitterEntityTest extends TestCase
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

        $metadata = self::$em->getClassMetadata(Emitter::class);
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

        $metadata = self::$em->getClassMetadata(Emitter::class);
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
        $register = self::$fm->instance(Emitter::class);

        self::$em->persist($register);
        self::$em->flush();

        $this->assertEquals($register->getId(), 1);
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testErrorNullName()
    {
        $this->expectException(\TypeError::class);

        $register = self::$fm->instance(Emitter::class, ['name' => null]);
        self::$em->persist($register);
        self::$em->flush();
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testErrorNullRfc()
    {
        $this->expectException(\TypeError::class);

        $register = self::$fm->instance(Emitter::class, ['rfc' => null]);
        self::$em->persist($register);
        self::$em->flush();
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testErrorNullEmail()
    {
        $this->expectException(\TypeError::class);

        $register = self::$fm->instance(Emitter::class, ['email' => null]);
        self::$em->persist($register);
        self::$em->flush();
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testErrorSameRfc()
    {
        $this->expectException(UniqueConstraintViolationException::class);

        $register = self::$fm->instance(Emitter::class, ['rfc' => 'CTS140515S7A']);
        self::$em->persist($register);
        self::$em->flush();

        $register = self::$fm->instance(Emitter::class, ['rfc' => 'CTS140515S7A']);
        self::$em->persist($register);
        self::$em->flush();
    }
}