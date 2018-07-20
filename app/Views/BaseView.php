<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 13/04/18
 * Time: 05:32 PM
 */

namespace App\Views;


use App\Traits\ConfigurableViewTrait;
use App\Traits\EngineTemplatesTrait;

/**
 * Class BaseView
 * @package App\Views
 */
class BaseView
{
    use ConfigurableViewTrait;

    use EngineTemplatesTrait;
}