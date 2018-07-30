<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 26/07/18
 * Time: 11:51 AM
 */

namespace App\Entities\Mappings;


use App\Repositories\UserRepository;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class UserMetadataBuilder
 * @package App\Entities\Mappings
 */
class UserMetadataBuilder
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('s01_users');
        $builder->setCustomRepositoryClass(UserRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();

        $builder->createField('name', 'string')->length(100)->build();
        $builder->createField('username', 'string')->length(100)->unique()->build();
        $builder->createField('email', 'string')->length(191)->unique()->build();
        $builder->createField('pswd', 'string')->length(100)->build();

        $builder->createField('regCreationDate', 'datetime')
            ->columnName('reg_creation_date')
            ->nullable()
            ->build();

        $builder->createField('regStatus', 'integer')
            ->columnName('reg_status')
            ->option('default', 1)
            ->build();
    }
}