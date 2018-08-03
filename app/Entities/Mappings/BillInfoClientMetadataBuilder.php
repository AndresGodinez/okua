<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 30/07/18
 * Time: 03:48 PM
 */

namespace App\Entities\Mappings;


use App\Repositories\BillInfoClientRepository;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class BillInfoClientMetadataBuilder
 * @package App\Entities\Mappings
 */
class BillInfoClientMetadataBuilder
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('u01_bill_info_clients');
        $builder->setCustomRepositoryClass(BillInfoClientRepository::class);

        $builder->createField('emitterRfc', 'string')->columnName('emitter_rfc')->makePrimaryKey()->length(255)->build();
        $builder->createField('emitterName', 'string')->columnName('emitter_name')->length(255)->build();

        $builder->addIndex(['emitter_rfc'], 's02_bill_info_emitter_rfc_index');
    }
}