<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 2/05/18
 * Time: 11:45 AM
 */

namespace App\Traits;


trait ConfigurableViewTrait
{
    /** @var array */
    protected $config = [];

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }
}
