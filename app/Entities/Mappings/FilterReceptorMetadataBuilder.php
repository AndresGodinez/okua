<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 08:43 PM
 */

namespace App\Entities\Mappings;


use App\Repositories\FilterReceptorRepository;
use App\Utils\EntityUtils;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class FilterReceptorMetadataBuilder
 * @package App\Entities\Mappings
 */
class FilterReceptorMetadataBuilder
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);
        
        $builder->setTable('s05_filter_receptors');
        $builder->setCustomRepositoryClass(FilterReceptorRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();

        $builder->createField('rfc', 'string')->unique()->length(20)->build();
        $builder->createField('valid', 'smallint')->option('default', EntityUtils::REG_STATUS_ACTIVE)->build();
    }
}