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
 * Trait SharedFilesystemViewTrait
 * @package App\Traits
 */
trait SharedFilesystemViewTrait
{
    /** @var null|Filesystem */
    protected $sharedFilesystem = null;

    /**
     * @return Filesystem|null
     */
    public function getSharedFilesystem()
    {
        return $this->sharedFilesystem;
    }

    /**
     * @param Filesystem|null $sharedFilesystem
     */
    public function setSharedFilesystem(Filesystem $sharedFilesystem)
    {
        $this->sharedFilesystem = $sharedFilesystem;
    }
}
