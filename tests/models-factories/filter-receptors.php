<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 08:03 PM
 */

/** @noinspection PhpUnhandledExceptionInspection */

/** @var $fm \League\FactoryMuffin\FactoryMuffin */

use League\FactoryMuffin\Faker\Facade as Faker;


$fm->define(\App\Entities\FilterReceptor::class)->setDefinitions([
    'rfc' => Faker::regexify('[A-Z]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z\d]{3}'),
    'valid' => 1,
]);