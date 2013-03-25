<?php

namespace Lrt\SiteBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EventRepository extends EntityRepository
{
    public function getEvents()
    {
        $qb = $this->getEntityManager()->createQueryBuilder('a');
        $qb->select('e')
                ->from('SiteBundle:Event', 'e')
                ->orderBy('e.dateDeb');
        
        return $qb->getQuery()->getArrayResult();
    }
}

