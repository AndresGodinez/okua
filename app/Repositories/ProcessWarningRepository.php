<?php
/**
 * Created by Sublime Text.
 * User: Diego
 * Date: 18/08/18
 * Time: 11:47 AM
 */

namespace App\Repositories;


use Doctrine\ORM\EntityRepository;

/**
 * Class ProcessWarningRepository
 * @package App\Repositories
 */

class ProcessWarningRepository extends EntityRepository {

	/**
     * @param $limit
     * @return mixed
     */
    public function getLastProcessWarning($limit)
    {
        $qb = $this->createQueryBuilder('a');
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