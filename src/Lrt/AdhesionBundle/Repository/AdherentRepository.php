<?php

/**
 * @category Repository
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\AdhesionBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Lrt\AdhesionBundle\Entity\Adherent;

class AdherentRepository extends EntityRepository
{
    /**
     * Liste les nouvelles adhésion
     * @return array
     */
    public function getAdherents()
    {
        $qb = $this->createQueryBuilder('u')
            ->where('u.isValid = :isValid')
            ->orWhere('u.isValid = :isNotValid')
            ->orderBy('u.lastName')
            ->setParameter('isValid', Adherent::IS_ACTIVE)
            ->setParameter('isNotValid', Adherent::IS_NOT_ACTIVE)
        ;

        $query = $qb->getQuery();

        return $query->getResult();
    }
}

