<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 30/07/18
 * Time: 04:23 PM
 */
/** @noinspection PhpUnhandledExceptionInspection */

/** @var $fm \League\FactoryMuffin\FactoryMuffin */

use League\FactoryMuffin\Faker\Facade as Faker;


$fm->define(\App\Entities\BillInfoTax::class)->setDefinitions([
    'taxSatCode' => Faker::randomElement(['001','002','003']),
    'type' => Faker::randomElement(['t','w']),
    'taxFactor' => Faker::randomElement(['exempt','rate','fee']),
    'taxRateFee' => Faker::randomElement([0.00, 0.16]),
    'amount' => Faker::randomFloat(2, 0, 1000),
]);
