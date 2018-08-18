<?php
/**
 * Created by Sublime Text.
 * User: Diego
 * Date: 18/08/18
 * Time: 11:47 AM
 */

namespace App\Repositories;


use App\Entities\ProcessWarning;
use App\Models\RangeTimeFilter;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class ProcessWarningRepository
 * @package App\Repositories
 */

class processWarningRepository extends EntityRepository {

	/**
     * @param $limit
     * @return mixed
     */
    public function getLastProcessWarning($limit)
    {
        $qb = $this->createQueryBuilder('a');
        //$qb->select('a.code', 'a.description', 'a.email', 'a.emailDatetime', 'a.cfdiId');
        $qb->orderBy('a.id', 'DESC');
        $qb->setMaxResults($limit);

        return $qb->getQuery()->execute();
    }

    public function getProcessWarningById($id){
        $qb = $this->createQueryBuilder('a');
        $qb->where('a.id = :id');

        $qb->setParameters([
            'id' => $id,
        ]);

        return $qb->getQuery()->execute();
    }
}