<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 08:43 PM
 */

namespace App\Entities\Mappings;


use App\Repositories\EmitterRepository;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class EmitterMetadataBuilder
 * @package App\Entities\Mappings
 */
class EmitterMetadataBuilder
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('s04_emitters');
        $builder->setCustomRepositoryClass(EmitterRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();

        $builder->createField('rfc', 'string')->unique()->length(20)->build();
        $builder->createField('name', 'string')->length(255)->build();
        $builder->createField('email', 'string')->length(255)->build();

        $builder->addIndex(['email'], 's04_emitters_email_index');
    }
}