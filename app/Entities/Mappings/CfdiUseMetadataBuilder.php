<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 26/07/18
 * Time: 11:51 AM
 */

namespace App\Entities\Mappings;


use App\Repositories\CfdiUseRepository;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class UserMetadataBuilder
 * @package App\Entities\Mappings
 */
class CfdiUseMetadataBuilder
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('s03_cfdi_uses');
        $builder->setCustomRepositoryClass(CfdiUseRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();

        $builder->createField('name', 'string')->length(255)->build();
        $builder->createField('satCode', 'string')->length(100)->unique()->columnName('sat_code')->build();
        
        $builder->createField('regStatus', 'integer')
            ->columnName('reg_status')
            ->option('default', 1)
            ->build();

        $builder->addIndex(['sat_code'], 's03_cfdi_uses_sat_code_index');
    }
}