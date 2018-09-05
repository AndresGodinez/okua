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


$fm->define(\App\Entities\Cfdi::class)->setDefinitions([
    'email' => Faker::freeEmail(),
    'emitterName' => Faker::name(),
    'emitterRfc' => Faker::regexify('[A-Z]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z\d]{3}'),
    'uuid' => Faker::regexify('[0-9A-F]{8}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{12}'),
    'cfdiUseSatCode' => Faker::randomElement(['D01','D02','D03','D04','D05','D06','D07','D08','D09','D10','G01','G02','G03','I01','I02','I03','I04','I05','I06','I07','I08','P01']),
    'subtotal' => Faker::randomFloat(2, 0, 1000),
    'discount' => Faker::randomFloat(2, 0, 1000),
    'transferTaxes' => Faker::randomFloat(2, 0, 1000),
    'withheldTaxes' => Faker::randomFloat(2, 0, 1000),
    'total' => Faker::randomFloat(2, 0, 1000),
    'currency' => 'MXN',
    'type' => Faker::randomElement(['I','E']),
    'paymentType' => Faker::randomElement(['PUE','PPD']),
    'documentDatetime' => Faker::dateTimeThisMonth(),
    'stampDatetime' => Faker::dateTimeThisMonth(),
    'emailDatetime' => Faker::dateTimeThisMonth(),
    'regDatetime' => Faker::dateTimeThisMonth(),
    'filesPath' => function ($object, $saved) {
        /** @var \App\Entities\Cfdi $object */

        $regDatetime = $object->getRegDatetime();
        $regDatetimeStr = $regDatetime->format('Y-m-d');
        $uuid = $object->getUuid();

        return \sprintf('/%s/%s', $regDatetimeStr, $uuid);
    },
    'stampStatus' => Faker::randomElement([
        \App\Utils\EntityUtils::STAMP_STATUS_NOT_DEFINED,
        \App\Utils\EntityUtils::STAMP_STATUS_ACTIVE,
        \App\Utils\EntityUtils::STAMP_STATUS_NOT_FOUND,
        \App\Utils\EntityUtils::STAMP_STATUS_CANCELED,
    ]),
    'hasPdf' => Faker::randomElement([0, 1]),
]);
