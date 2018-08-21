<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 2/05/18
 * Time: 11:45 AM
 */

namespace App\Traits;


use League\Flysystem\Filesystem;

/**
 * Trait LocalFilesystemViewTrait
 * @package App\Traits
 */
trait LocalFilesystemViewTrait
{
    /** @var null|Filesystem */
    protected $localFilesystem = null;

    /**
     * @return Filesystem|null
     */
    public function getLocalFilesystem(): Filesystem
    {
        return $this->localFilesystem;
    }

    /**
     * @param Filesystem|null $localFilesystem
     */
    public function setLocalFilesystem(Filesystem $localFilesystem)
    {
        $this->localFilesystem = $localFilesystem;
    }
}
