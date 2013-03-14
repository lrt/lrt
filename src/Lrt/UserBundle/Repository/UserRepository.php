<?php

/**
 * @category Repository
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Lrt\UserBundle\Entity\User;

class UserRepository extends EntityRepository
{

    /**
     * Liste les nouvelles adhésion
     * @return array
     */
    public function getAdhesion()
    {
        $qb = $this->createQueryBuilder('u')
            ->where('u.isAdhesion = :isAdhesion')
            ->orWhere('u.enabled = :isEnabled')
            ->orderBy('u.lastName')
            ->setParameter('isAdhesion', User::IS_NEW_ADHESION)
            ->setParameter('isEnabled', User::IS_ACTIVE)
        ;

        $query = $qb->getQuery();

        return $query->getResult();
    }

    /**
     * Filtre sur la liste des utilisateurs
     */
    public function filter($login = '', $nom = '', $role = '', $email = '', $status = '')
    {        
        $queryStr = 'SELECT u FROM UserBundle:User u
                    WHERE 1 = 1 ';

        if ($login != null && $login != '') {
            $queryStr.= ' AND u.username LIKE :login ';
        }

        if ($nom != null && $nom != '') {
            $queryStr.= ' AND u.lastName LIKE :nom ';
        }

        if ($role !== null && $role !== '') {
            $queryStr.= ' AND u.roles LIKE :role ';
        }

        if ($email != null && $email != '') {
            $queryStr.= ' AND u.email LIKE :email ';
        }
        
        if ($status != null && $status != '') {
            $queryStr.= ' AND u.enabled = :status ';
        } else {
            $queryStr.= ' AND u.enabled = ' .User::IS_ACTIVE ;
        }

        $query = $this->getEntityManager()->createQuery($queryStr);


        if ($login != null && $login != '') {
            $query->setParameter('login', '%'.$login.'%');
        }

        if ($nom != null && $nom != '') {
            $query->setParameter('nom', '%'.$nom.'%');
        }

        if ($role !== null && $role !== '') {
            $query->setParameter('role', '%'.$role.'%');
        }

        if ($email != null && $email != '') {
            $query->setParameter('email', '%'.$email.'%');
        }
        
        if ($status != null && $status != '') {
            $query->setParameter('status', $status);
        }

        return $query->getResult();
    }
}
