<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 26/07/18
 * Time: 11:51 AM
 */

namespace App\Entities\Mappings;


use App\Repositories\CfdiTaxRepository;
use App\Entities\Cfdi;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class BillInfoTaxMetadataBuilder
 * @package App\Entities\Mappings
 */
class CfdiTaxMetadataBuilder
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('s02_cfdi_taxes');
        $builder->setCustomRepositoryClass(CfdiTaxRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();

        $builder->createField('taxSatCode', 'string')->length(20)->columnName('tax_sat_code')->build();
        $builder->createField('type', 'string')->length(10)->build();
        $builder->createField('taxFactor', 'string')->length(20)->columnName('tax_factor')->build();
        $builder->createField('taxRateFee', 'decimal')->columnName('tax_rate_fee')->precision(10)->scale(6)->build();
        $builder->createField('amount', 'decimal')->precision(12)->scale(5)->build();

        $builder->createManyToOne('billInfo', Cfdi::class)->addJoinColumn('bill_info_id', 'id')->inversedBy('taxes')->build();
    }
}