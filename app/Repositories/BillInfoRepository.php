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
use Doctrine\ORM\QueryBuilder;

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

    /**
     * @param $limit
     * @return mixed
     */
    public function getLastRegistersGroupedByEmail($limit)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select('a.email', 'a.emailDatetime');
        $qb->orderBy('a.emailDatetime', 'DESC');
        $qb->groupBy('a.email');
        $qb->groupBy('a.emailDatetime');
        $qb->setMaxResults($limit);

        return $qb->getQuery()->execute();
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param \DateTime|null $startDatetime
     * @param \DateTime|null $endDatetime
     * @param string $emitterRfc
     * @param float $initialAmount
     * @param float $finalAmount
     * @return mixed
     */
    public function getFilteredRegisters(
        int $limit,
        int $offset,
        ?\DateTime $startDatetime,
        ?\DateTime $endDatetime,
        string $emitterRfc = '',
        float $initialAmount = 0.00,
        float $finalAmount = 0.00
    ) {
        $qb = $this->createQueryBuilder('a');

        $this->prepareFilteredRegistersQuery($qb, $startDatetime, $endDatetime, $emitterRfc, $initialAmount, $finalAmount);

        $qb->orderBy('a.emailDatetime', 'DESC');
        $qb->setMaxResults($limit);
        $qb->setFirstResult($offset);

        return $qb->getQuery()->execute();
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param \DateTime|null $startDatetime
     * @param \DateTime|null $endDatetime
     * @param string $emitterRfc
     * @param float $initialAmount
     * @param float $finalAmount
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getFilteredRegistersCount(
        ?\DateTime $startDatetime,
        ?\DateTime $endDatetime,
        string $emitterRfc = '',
        float $initialAmount = 0.00,
        float $finalAmount = 0.00
    ) {
        $qb = $this->createQueryBuilder('a');
        $qb->select('COUNT(a.id) AS total');

        $this->prepareFilteredRegistersQuery($qb, $startDatetime, $endDatetime, $emitterRfc, $initialAmount, $finalAmount);

        return $qb->getQuery()->getSingleScalarResult();
    }

    private function prepareFilteredRegistersQuery(
        QueryBuilder &$qb,
        ?\DateTime $startDatetime,
        ?\DateTime $endDatetime,
        string $emitterRfc = '',
        float $initialAmount = 0.00,
        float $finalAmount = 0.00
    )
    {
        $qb->where('a.type = :type');
        $qb->andWhere('a.emailDatetime BETWEEN :startDatetime AND :endDatetime');

        if (!!$emitterRfc) {
            $qb->andWhere('a.emitterRfc = :emitterRfc');
        }

        if ($initialAmount > 0) {
            $qb->andWhere('a.total >= :initialAmount');
        }

        if ($finalAmount > 0) {
            $qb->andWhere('a.total <= :finalAmount');
        }

        $parameters = [
            'type' => 'I',
            'startDatetime' => $startDatetime,
            'endDatetime' => $endDatetime,
        ];

        if (!!$emitterRfc) {
            $parameters['emitterRfc'] = $emitterRfc;
        }

        if ($initialAmount > 0) {
            $parameters['initialAmount'] = $initialAmount;
        }

        if ($finalAmount > 0) {
            $parameters['finalAmount'] = $finalAmount;
        }

        $qb->setParameters($parameters);
    }
}