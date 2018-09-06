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

class ProcessErrorRepository extends EntityRepository {

	/**
     * @param $limit
     * @return mixed
     */
    public function getLastProcessError($limit)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->orderBy('a.id', 'DESC');
        $qb->setMaxResults($limit);

        return $qb->getQuery()->execute();
    }

    public function getProcessErrorById($id){
        $qb = $this->createQueryBuilder('a');
        $qb->where('a.id = :id');

        $qb->setParameters([
            'id' => $id,
        ]);

        return $qb->getQuery()->execute();
    }

    public function getFilteredRegisters(
        int $limit,
        int $offset,
        $startDatetime,
        $endDatetime,
        $filterDatetimeType = 1
    ){
        $qb = $this->createQueryBuilder('a');

        $this->prepareFilteredRegistersQuery($qb, $startDatetime, $endDatetime, $filterDatetimeType);
        $qb->setMaxResults($limit);
        $qb->setFirstResult($offset);

        return $qb->getQuery()->execute();
    }

    public function getFilteredRegistersCount(
        $startDatetime,
        $endDatetime,
        $filterDatetimeType = 1
    ){
        $qb = $this->createQueryBuilder('a');
        $qb->select('COUNT(a.id) AS total');

        $this->prepareFilteredRegistersQuery($qb, $startDatetime, $endDatetime, $filterDatetimeType);
        

        return $qb->getQuery()->getSingleScalarResult();
    }

    private function prepareFilteredRegistersQuery(
        QueryBuilder &$qb,
        $startDatetime,
        $endDatetime,
        $filterDatetimeType
    )
    {
        $qb->where('a.id > 0');

        if ($filterDatetimeType === 1){
            $qb->andWhere('a.emailDatetime BETWEEN :startDatetime AND :endDatetime');
        }elseif ($filterDatetimeType === 2){
            $qb->andWhere('a.regDatetime BETWEEN :startDatetime AND :endDatetime');
        }

        $parameters = [
            'startDatetime' => $startDatetime,
            'endDatetime' => $endDatetime,
        ];

        $qb->setParameters($parameters);
    }
}