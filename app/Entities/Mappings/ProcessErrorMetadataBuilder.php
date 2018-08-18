<?php
/**
 * Created by Sublime Text.
 * User: Diego
 * Date: 18/08/18
 * Time: 11:51 AM
 */

namespace App\Entities\Mappings;


use App\Repositories\ProcessErrorRepository;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class ProcessErrorMetadataBuilder
 * @package App\Entities\Mappings
 */
class ProcessErrorMetadataBuilder
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('l01_process_errors');
        $builder->setCustomRepositoryClass(ProcessErrorRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();
        $builder->createField('code', 'string')->length(255)->build();
        $builder->createField('description', 'string')->length(255)->build();
        $builder->createField('email', 'string')->length(100)->build();
        $builder->createField('emailDatetime', 'datetime')->columnName('email_datetime')->build();
        $builder->createField('regDatetime', 'datetime')
            ->columnName('reg_datetime')
            ->build();
    }
}