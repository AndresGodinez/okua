<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 30/07/18
 * Time: 03:48 PM
 */

namespace App\Entities\Mappings;


use App\Repositories\BillInfoRepository;
use App\Utils\EntityUtils;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;
use App\Entities\BillInfoTax;

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

        $builder->createField('email', 'string')->length(100)->build();
        $builder->createField('emitterName', 'string')->columnName('emitter_name')->length(255)->build();
        $builder->createField('emitterRfc', 'string')->columnName('emitter_rfc')->length(255)->build();
        $builder->createField('uuid', 'string')->length(255)->unique()->build();
        $builder->createField('cfdiUseSatCode', 'string')->columnName('cfdi_use_sat_code')->length(255)->build();
        $builder->createField('subtotal', 'decimal')->columnName('subtotal')->precision(12)->scale(5)->build();
        $builder->createField('discount', 'decimal')->columnName('discount')->precision(12)->scale(5)->build();
        $builder->createField('total', 'decimal')->columnName('total')->precision(12)->scale(5)->build();
        $builder->createField('currency', 'string')->columnName('currency')->length(45)->build();
        $builder->createField('type','string')->columnName('type')->length(5)->build();
        $builder->createField('paymentType', 'string')->columnName('payment_type')->length(5)->build();
        $builder->createField('documentDatetime', 'datetime')->columnName('document_datetime')->build();
        $builder->createField('stampDatetime', 'datetime')->columnName('stamp_datetime')->build();
        $builder->createField('emailDatetime', 'datetime')->columnName('email_datetime')->build();
        $builder->createField('regDatetime', 'datetime')->columnName('reg_datetime')->build();
        $builder->createField('filesPath', 'string')->columnName('files_path')->build();
        $builder->createField('transferTaxes', 'decimal')->columnName('transfer_taxes')->precision(12)->scale(5)->build();
        $builder->createField('withheldTaxes', 'decimal')->columnName('withheld_taxes')->precision(12)->scale(5)->build();
        $builder->createField('stampStatus', 'smallint')->columnName('stamp_status')->option('default', EntityUtils::STAMP_STATUS_NOT_DEFINED)->build();
        $builder->createField('hasPdf', 'smallint')->columnName('has_pdf')->option('default', 1)->build();

        $builder->createOneToMany('taxes', BillInfoTax::class)->mappedBy('billInfo')->cascadeAll()->build();

        $builder->addIndex(['cfdi_use_sat_code'], 's02_bill_info_cfdi_use_sat_code_index');
        $builder->addIndex(['document_datetime'], 's02_bill_info_document_datetime_index');
        $builder->addIndex(['email_datetime'], 's02_bill_info_email_datetime_index');
        $builder->addIndex(['email'], 's02_bill_info_email_index');
        $builder->addIndex(['emitter_rfc'], 's02_bill_info_emitter_rfc_index');
        $builder->addIndex(['type'], 's02_bill_info_type_index');
    }
}