<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 08:43 PM
 */

namespace App\Entities\Mappings;


use App\Repositories\FilterEmitterRepository;
use App\Utils\EntityUtils;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class FilterEmitterMetadataBuilder
 * @package App\Entities\Mappings
 */
class FilterEmitterMetadataBuilder
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);
        
        $builder->setTable('s05_filter_emitters');
        $builder->setCustomRepositoryClass(FilterEmitterRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();

        $builder->createField('rfc', 'string')->unique()->length(20)->build();
        $builder->createField('valid', 'smallint')->option('default', EntityUtils::REG_STATUS_ACTIVE)->build();
    }
}