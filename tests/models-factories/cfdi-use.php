<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 7/08/18
 * Time: 05:40 PM
 */

/** @noinspection PhpUnhandledExceptionInspection */

/** @var $fm \League\FactoryMuffin\FactoryMuffin */

use League\FactoryMuffin\Faker\Facade as Faker;


$fm->define(\App\Entities\CfdiUse::class)->setDefinitions([
    'name' => 'test',
    'satCode' => Faker::randomElement(['D01','D02','D03','D04','D05','D06','D07','D08','D09','D10','G01','G02','G03','I01','I02','I03','I04','I05','I06','I07','I08','P01']),
    'regStatus' => 1,
]);