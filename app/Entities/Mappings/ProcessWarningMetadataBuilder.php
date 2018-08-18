<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 26/07/18
 * Time: 11:51 AM
 */

namespace App\Entities\Mappings;


use App\Repositories\ProcessWarningRepository;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class ProcessWarningMetadataBuilder
 * @package App\Entities\Mappings
 */
class ProcessWarningMetadataBuilder
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('l01_process_warnings');
        $builder->setCustomRepositoryClass(ProcessWarningRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();
        $builder->createField('code', 'int')->option('default', -1)->build();
        $builder->createField('description', 'string')->length(255)->build();
        $builder->createField('email', 'string')->length(100)->build();
        $builder->createField('emailDatetime', 'datetime')->columnName('email_datetime')->build();
        $builder->createField('cfdiId', 'bigint')->columnName('cfdi_id')->build();
        $builder->createField('regDatetime', 'datetime')
            ->columnName('reg_datetime')
            ->build();
    }
}