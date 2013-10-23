<?php

namespace Intranet\ForumBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

/**
 * TopicViewRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TopicViewRepository extends EntityRepository
{
    public function getTopicView($user, $topic)
    {
        $queryBuilder = $this->_em->createQueryBuilder()
                ->select('tv')
                ->from($this->_entityName, 'tv')
                ->where('tv.user = :user')
                ->andWhere('tv.topic = :topic')
                ->setParameter('user', $user)
                ->setParameter('topic', $topic);

        $query = $queryBuilder->getQuery();

        $result = $query->getOneOrNullResult();

        return $result;
    }
    
    public function getLastPostFromTopic($topic)
    {
        $queryBuilder = $this->_em->createQueryBuilder()
                ->select('p')
                ->from('IntranetForumBundle:Post', 'p')
                ->where('p.topic = :topic')
                ->orderBy('p.createdAt', 'DESC')
                ->setParameter('topic', $topic);

        $query = $queryBuilder->getQuery();

        $result = $query->getResult();

        if (count($result) > 0)
            return $result[0];
        else
            return null;
    }
    
    public function getLastPostFromCategory($category)
    {
        $queryBuilder = $this->_em->createQueryBuilder()
                ->select('p')
                ->from('IntranetForumBundle:Post', 'p')
                ->leftJoin('IntranetForumBundle:Topic', 't', Join::WITH, 'p.topic = t.id')
                ->where('t.category = :category')
                ->orderBy('p.createdAt', 'DESC')
                ->setParameter('category', $category);

        $query = $queryBuilder->getQuery();

        $result = $query->getResult();

        if (count($result) > 0)
            return $result[0];
        else
            return null;
    }
    
    public function hasReadTopic($user, $topic)
    {
        $tv = $this->getTopicView($user, $topic);
        $lastPost = $this->getLastPostFromTopic($topic);
        
        if ($tv != null)
        {
            // There is a new post since last time ?
           if ($tv->getPost() == $lastPost)
           {
               return 1;
           }
           else
           {
               if ($tv->getUser() == $user)
                   return -1;
               else
                   return 1;
           }
        }
        else
        {
            if ($lastPost != null)
            {
                $diffNow = $lastPost->getCreatedAt()->diff(new \DateTime());

                // If the last post is older than 6 months or if the user's subscription date is after
                if ($diffNow->m > 6)
                {
                    return 1;
                }
                else
                {
                    if ($user->getCreatedAt() != null)
                    {
                        return 0;
                    }
                    else if ($lastPost->getCreatedAt() < $user->getCreatedAt())
                    {
                        return 1;
                    }
                }
            }
            else
                return 1;
        }
    }
    
    public function findTopicsByCategory($category)
    {
        $queryBuilder = $this->_em->createQueryBuilder()
                ->select('t')
                ->from('IntranetForumBundle:Topic', 't')
                ->where('t.category = :category')
                ->setParameter('category', $category);

        $query = $queryBuilder->getQuery();

        $result = $query->getResult();

        return $result;
    }
    
    public function hasReadCategory($user, $category)
    {
        $topics = $this->findTopicsByCategory($category);
        
        $notRead = false;
        foreach($topics as $topic)
        {
           $hasReadTopic = $this->hasReadTopic($user, $topic);
            if ($hasReadTopic == -1)
            {
                return -1;
            }
            else if ($hasReadTopic == 0)
            {
                $notRead = true;
            }
        }
        
        if ($notRead)
            return 0;
        else
            return 1;
    }   
}