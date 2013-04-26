<?php

namespace Intranet\ScheduleBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ScheduleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ScheduleRepository extends EntityRepository
{

    public function findCoursesFromDate($date)
    {
        $date_from = new \DateTime($date->format('Y') . '-' . $date->format('m') . '-' . $date->format('d') . ' 00:00:00');
        $date_to = new \DateTime($date->format('Y') . '-' . $date->format('m') . '-' . ($date->format('d') + 1) . ' 00:00:00');

        $queryBuilder = $this->createQueryBuilder('s');

        $queryBuilder = $this->_em->createQueryBuilder()
                ->select('s')
                ->from($this->_entityName, 's')
                ->where($queryBuilder->expr()->between('s.date', ':date_from', ':date_to'))
                ->setParameter('date_from', $date_from, \Doctrine\DBAL\Types\Type::DATETIME)
                ->setParameter('date_to', $date_to, \Doctrine\DBAL\Types\Type::DATETIME);

        $query = $queryBuilder->getQuery();

        $results = $query->getResult();

        return $results;
    }

    public function findNextCourses($date, $max)
    {
        $queryBuilder = $this->createQueryBuilder('s');

        $queryBuilder = $this->_em->createQueryBuilder()
                ->select('s')
                ->from($this->_entityName, 's')
                ->where('s.date >= :date')
                ->add('orderBy', 's.date ASC')
                //->setFirstResult($offset)
                ->setMaxResults($max)
                ->setParameter('date', $date, \Doctrine\DBAL\Types\Type::DATETIME);

        $query = $queryBuilder->getQuery();

        $results = $query->getResult();

        return $results;
    }

}
