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


// init muffins factory
$fm = new \League\FactoryMuffin\FactoryMuffin();

$factoriesPath = BASE_DIR . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'factories';

/** @noinspection PhpUnhandledExceptionInspection */
$fm->loadFactories($factoriesPath);

// insert bills-info
$em->getConnection()->beginTransaction();

$now = new \DateTime();

$billInfo = $fm->instance(\App\Entities\BillInfo::class, [
    'email' => 'israel.torres@connectit.com.mx',
    'type' => 'I',
    'documentDatetime' => $now,
    'emailDatetime' => $now,
    'stampDatetime' => $now,
    'regDatetime' => $now,
]);
$em->persist($billInfo);

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