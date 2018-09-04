<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 07:25 PM
 */

namespace App\Entities\Mappings;


use App\Repositories\AlertEmailResponseRepository;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

class AlertEmailResponseMetadataBuilder
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('s05_alert_email_responses');
        $builder->setCustomRepositoryClass(AlertEmailResponseRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();

        $builder->createField('code', 'integer')->unique()->build();
        $builder->createField('internalMsg', 'string')->columnName('internal_msg')->build();
        $builder->createField('emailMsg', 'string')->columnName('email_msg')->build();
    }
}