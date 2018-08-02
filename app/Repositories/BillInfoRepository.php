<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 30/07/18
 * Time: 03:49 PM
 */

namespace App\Repositories;


use App\Models\RangeTimeFilter;
use Doctrine\ORM\EntityRepository;

/**
 * Class BillInfoRepository
 * @package App\Repositories
 */
class BillInfoRepository extends EntityRepository
{
    /**
     * @param $filter
     * @return mixed
     */
    public function getIncomeTotalByRangeTimeFilter($filter)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->where('a.type = :type');
        $qb->andWhere('a.emailDatetime BETWEEN :startDatetime AND :endDatetime');

        $now = new \DateTime();
        $startDatetime = clone $now;
        $endDatetime = clone $now;

        if ($filter == RangeTimeFilter::FILTER_WEEK) {
            $startDatetime->modify('monday this week');
            $startDatetime->setTime(0, 0, 0);

            $endDatetime->modify('sunday this week');
            $endDatetime->setTime(23, 59, 59);
        } else if ($filter == RangeTimeFilter::FILTER_MONTH) {
            $startDatetime->modify('first day of this month');
            $startDatetime->setTime(0, 0, 0);

            $endDatetime->modify('last day of this month');
            $endDatetime->setTime(23, 59, 59);
        } else if ($filter == RangeTimeFilter::FILTER_YEAR) {
            $startDatetime->modify('first day of january');
            $startDatetime->setTime(0, 0, 0);

            $endDatetime->modify('last day of december');
            $endDatetime->setTime(23, 59, 59);
        }

        $qb->setParameters([
            'type' => 'I',
            'startDatetime' => $startDatetime,
            'endDatetime' => $endDatetime,
        ]);

        $results = $qb->getQuery()->execute();

        $total = \array_reduce($results, function ($a, $register) {
            return $a + $register->getTotal();
        }, 0);


        return $total;
    }
}