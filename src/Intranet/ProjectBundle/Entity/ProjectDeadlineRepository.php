<?php

namespace Intranet\ProjectBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProjectDeadlineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectDeadlineRepository extends EntityRepository
{    
    public function findNextDeadlines($user_id, $max)
    {
        $queryBuilder = $this->_em->createQueryBuilder()
                ->select('d')
                ->from($this->_entityName, 'd')
                ->leftJoin('d.project', 'p')
                ->leftJoin('pg.users', 'u')
                ->leftJoin('pg.project', 'p')
                ->where('p.id = :project_id')
                ->andWhere('u.id = :user_id')
                ->setParameter('user_id', $user_id);

        $query = $queryBuilder->getQuery();

        try
        {
            $result = $query->getSingleResult();
        }
        catch (\Doctrine\Orm\NoResultException $e)
        {
            $result = null;
        }

        return null;
        return $result;
    }

}
