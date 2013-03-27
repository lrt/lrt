<?php

namespace Lrt\SiteBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Lrt\UserBundle\Entity\User;
use Lrt\SiteBundle\Entity\Activity;

class VideoRepository extends EntityRepository
{

    /**
     * Retourne la liste des vidéos d'un contributeur
     * @param \Lrt\UserBundle\Entity\User $user
     * @return array
     */
    public function getVideosByUser(User $user)
    {
        $sql = 'SELECT v FROM SiteBundle:Video v
                JOIN UserBundle:User u WITH v.user = u.id
                WHERE v.user = :user ';

        $query = $this->getEntityManager()->createQuery($sql)
                ->setParameter('user', $user);

        return $query->getResult();
    }

    /**
     * Retourne la liste des vidéos en attente de validation
     * @return array
     */
    public function getVideosNotValidated()
    {
        $sql = 'SELECT v FROM SiteBundle:Video v
                JOIN UserBundle:User u WITH v.user = u.id
                AND v.isValid = :valid';

        $query = $this->getEntityManager()->createQuery($sql)
                ->setParameter('valid', Activity::IS_NOT_VALIDATED);

        return $query->getResult();
    }

    /**
     * Retourne la liste des vidéos mise en avant
     * @return array
     */
    public function getVideosIsHighlighted()
    {
        $qb = $this->createQueryBuilder('v')
                ->select('v')
                ->where('v.isHighlighted  = :isHighlighted')
                ->orderBy('v.dateSubmission', 'DESC')
                    ->setParameter('isHighlighted', 1);
        
        $qb->setMaxResults(4);

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * Retourne la liste des vidéos
     * @param integer $limit
     * @return array
     */
    public function getLatestVideos($limit)
    {
        $qb = $this->createQueryBuilder('v')
                ->select('v')
                ->orderBy('v.dateSubmission', 'DESC');

        if (!is_null($limit)) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * Filtre sur les vidéos
     */
    public function filter($title = '', $status = '', $publish = '')
    {
        $queryStr = 'SELECT v FROM SiteBundle:Video v
                     WHERE 1 = 1 ';

        if ($title != null && $title != '') {
            $queryStr .= ' AND v.title LIKE :title ';
        }
        if ($status != null && $status != '') {
            $queryStr .= ' AND v.isPublished = :status ';
        }
        if ($publish != null && $publish != '') {
            $queryStr .= ' AND v.isPublic = :publish ';
        }

        $query = $this->getEntityManager()->createQuery($queryStr);

        if ($title != null && $title != '') {
            $query->setParameter('title', '%'.$title.'%');
        }
        if ($status != null && $status != '') {
            $query->setParameter('status', '%'.$status.'%');
        }
        if ($publish != null && $publish != '') {
            $query->setParameter('publish', '%'.$publish.'%');
        }

        return $query->getResult();
    }

}

