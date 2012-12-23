<?php

/**
 * @category Repository
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{

    /**
     * Filtre sur la liste des utilisateurs
     */
    public function filter($login = '', $nom = '', $role = 'tous', $email = '')
    {

        $em = $this->getEntityManager();

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

        $query = $em->createQuery($queryStr);


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

        return $query->getResult();
    }
}
