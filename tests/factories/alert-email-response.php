<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 07:32 PM
 */
/** @noinspection PhpUnhandledExceptionInspection */

/** @var $fm \League\FactoryMuffin\FactoryMuffin */

use League\FactoryMuffin\Faker\Facade as Faker;


$fm->define(\App\Entities\AlertEmailResponse::class)->setDefinitions([
    'code' => Faker::randomNumber(2),
    'internalMsg' => Faker::text(),
    'emailMsg' => Faker::text(),
]);
