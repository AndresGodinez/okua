<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 25/06/18
 * Time: 04:34 PM
 */

namespace App\Traits;
use Doctrine\ORM\EntityManager;


/**
 * Trait EntityManagerViewTrait
 * @package App\Traits
 */
trait EntityManagerViewTrait
{
    /** @var EntityManager|null */
    protected $em = null;

    /**
     * @return EntityManager|null
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @param EntityManager $em
     */
    public function setEm($em)
    {
        $this->em = $em;
    }
}