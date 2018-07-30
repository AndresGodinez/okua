<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 26/07/18
 * Time: 03:48 PM
 */
/** @noinspection PhpUnhandledExceptionInspection */

/** @var $fm \League\FactoryMuffin\FactoryMuffin */

 use League\FactoryMuffin\Faker\Facade as Faker;


$fm->define(\App\Entities\User::class)->setDefinitions([
    'name' => Faker::name(),
    'username' => Faker::userName(),
    'email'    => Faker::freeEmail(),
    'pswd'    => Faker::password(),
]);