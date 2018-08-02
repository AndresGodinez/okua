<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 1/08/18
 * Time: 11:08 PM
 */

require "../vendor/autoload.php";

if (!defined("BASE_DIR")) {
    define("BASE_DIR", \realpath(__DIR__ . "/../"));
}

$container = \App\Site\SiteContainer::make();

/** @var \Doctrine\ORM\EntityManager $em */
$em = $container->get('entity-manager');

// truncate tables

/** @noinspection PhpUnhandledExceptionInspection */
$em->getConnection()->exec('TRUNCATE ' . $em->getClassMetadata(\App\Entities\User::class)->getTableName());

/** @noinspection PhpUnhandledExceptionInspection */
$em->getConnection()->exec('TRUNCATE ' . $em->getClassMetadata(\App\Entities\BillInfo::class)->getTableName());

// init muffins factory
$fm = new \League\FactoryMuffin\FactoryMuffin();

$factoriesPath = BASE_DIR . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'factories';

/** @noinspection PhpUnhandledExceptionInspection */
$fm->loadFactories($factoriesPath);

// insert users
$em->getConnection()->beginTransaction();

$user = $fm->instance(\App\Entities\User::class, [
    "name" => "Administrador",
    "username" => "admin",
    "email" => "admin@connectit.com.mx",
    "pswd" => \App\Utils\SecurityUtils::generateSecurePswd('1', \App\Utils\SecurityUtils::USER_PSWD_SEED),
]);
$em->persist($user);

$user = $fm->instance(\App\Entities\User::class, [
    "name" => "Israel Torres",
    "username" => "itorres",
    "email" => "israel.torres@connectit.com.mx",
    "pswd" => \App\Utils\SecurityUtils::generateSecurePswd('warning83', \App\Utils\SecurityUtils::USER_PSWD_SEED),
]);
$em->persist($user);

$user = $fm->instance(\App\Entities\User::class, [
    "name" => "Adan Morales",
    "username" => "amorales",
    "email" => "adan.morales@connectit.com.mx",
    "pswd" => \App\Utils\SecurityUtils::generateSecurePswd('laMerg05', \App\Utils\SecurityUtils::USER_PSWD_SEED),
]);
$em->persist($user);

try {
    $em->flush();
    $em->commit();
} catch (\Doctrine\ORM\OptimisticLockException $e) {
    echo "\n" . $e->getMessage();
    $em->rollback();
} catch (\Doctrine\ORM\ORMException $e) {
    echo "\n" . $e->getMessage();
    $em->rollback();
}

// insert bills-info
$em->getConnection()->beginTransaction();

$seedCount = 500;
for ($i = 0; $i < $seedCount; ++$i) {
    $billInfo = $fm->instance(\App\Entities\BillInfo::class, [
        'type' => 'I',
    ]);
    $em->persist($billInfo);
}

try {
    $em->flush();
    $em->commit();
} catch (\Doctrine\ORM\OptimisticLockException $e) {
    echo "\n" . $e->getMessage();
    $em->rollback();
} catch (\Doctrine\ORM\ORMException $e) {
    echo "\n" . $e->getMessage();
    $em->rollback();
}