<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 21/05/18
 * Time: 04:44 PM
 */

namespace App\Traits;


use League\Plates\Engine;

/**
 * Trait EngineTemplatesTrait
 * @package App\Traits
 */
trait EngineTemplatesTrait
{
    /** @var Engine */
    protected $templates;

    /**
     * @return Engine
     */
    public function getTemplates(): Engine
    {
        return $this->templates;
    }

    /**
     * @param Engine $templates
     */
    public function setTemplates(Engine $templates)
    {
        $this->templates = $templates;
    }
}