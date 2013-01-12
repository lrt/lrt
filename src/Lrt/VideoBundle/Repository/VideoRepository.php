<?php

namespace Lrt\VideoBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Lrt\UserBundle\Entity\User;

class VideoRepository extends EntityRepository
{
    /**
    * Retourne la liste des vidéos d'un contributeur
    * @param Lrt\UserBundle\Entity\User $user
    */
    public function getVideosByUser(User $user)
    {
        $sql = 'SELECT v FROM VideoBundle:Video v
                JOIN UserBundle:User u WITH v.user = u.id
                WHERE v.user = :user ';
        
        $query = $this->getEntityManager()->createQuery($sql)
                    ->setParameter('user', $user);
       
        return $query->getResult();
    }

    /**
     * Filtre sur les vidéos
     */
    public function filter($title = '',$status = '',$publish = '')
    {
        $queryStr = 'SELECT v FROM VideoBundle:Video v
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

