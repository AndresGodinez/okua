<?php
/**
 * Created by Sublime Text.
 * User: Diego
 * Date: 18/08/18
 * Time: 11:47 AM
 */

namespace App\Repositories;


use App\Entities\ProcessError;
use App\Models\RangeTimeFilter;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class ProcessErrorRepository
 * @package App\Repositories
 */

class processErrorRepository extends EntityRepository {

	/**
     * @param $limit
     * @return mixed
     */
    public function getLastProcessError($limit)
    {
        $qb = $this->createQueryBuilder('a');
        //$qb->select('a.id', 'a.code', 'a.description', 'a.email', 'a.emailDatetime');
        $qb->orderBy('a.id', 'DESC');
        $qb->setMaxResults($limit);

        return $qb->getQuery()->execute();
    }
}