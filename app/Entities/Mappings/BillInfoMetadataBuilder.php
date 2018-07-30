<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 30/07/18
 * Time: 03:48 PM
 */

namespace App\Entities\Mappings;


use App\Repositories\BillInfoRepository;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class BillInfoMetadataBuilder
 * @package App\Entities\Mappings
 */
class BillInfoMetadataBuilder
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('s02_bill_info');
        $builder->setCustomRepositoryClass(BillInfoRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();

        $builder->createField('rfcEmitter', 'string')->columnName('rfc_emisor')->length(255)->build();
        $builder->createField('email', 'string')->columnName('email')->length(100)->build();
        $builder->createField('uuid', 'string')->length(255)->unique()->build();
        $builder->createField('cfdiUseSatCode', 'string')->columnName('uso_cfdi')->length(255)->build();
        $builder->createField('subtotal', 'decimal')->columnName('subtotal')->precision(12)->scale(5)->build();
        $builder->createField('discount', 'decimal')->columnName('descuento')->precision(12)->scale(5)->build();
        $builder->createField('total', 'decimal')->columnName('total')->precision(12)->scale(5)->build();
        $builder->createField('currency', 'string')->columnName('moneda')->length(45)->build();
        $builder->createField('type','string')->columnName('tipo_comprobante')->length(255)->build();
        $builder->createField('paymentType', 'string')->columnName('metodo_pago')->length(255)->build();
        $builder->createField('emailDatetime', 'datetime')->columnName('fecha_documento')->length(255)->build();
        $builder->createField('stampDatetime', 'datetime')->columnName('fecha_timbrado')->length(255)->build();

        $builder->addIndex(['email'], 's02_bill_info_email_index');
        $builder->addIndex(['fecha_documento'], 's02_bill_info_fecha_documento_index');
        $builder->addIndex(['fecha_timbrado'], 's02_bill_info_fecha_timbrado_index');
        $builder->addIndex(['uuid'], 's02_bill_info_uuid_index');
    }
}