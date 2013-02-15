<?php

namespace Lrt\SiteBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Lrt\UserBundle\Entity\User;
use Lrt\AdminBundle\Entity\Activity;

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
     * Filtre sur les vidéos
     */
    public function filter($title = '',$status = '',$publish = '')
    {
        $queryStr = 'SELECT v FROM SiteBundle:Video v
                     WHERE 1 = 1 ';

        if ($title != null && $title != '') {
            $queryStr.= ' AND v.title LIKE :title ';
        }
        if ($status != null && $status != '') {
            $queryStr.= ' AND v.status LIKE :status ';
        }
        if ($publish != null && $publish != '') {
            $queryStr.= ' AND v.isPublic LIKE :publish ';
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

