<?php

namespace Lrt\SiteBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ActivityRepository extends EntityRepository
{

    /**
     * Récupère tous les articles et vidéos publiés
     */
    public function getArticlesVideos()
    {
        $qb = $this->getEntityManager()->createQueryBuilder('a');
        $qb->select('a')
                ->from('SiteBundle:Activity', 'a')
                ->where('a INSTANCE OF CMSBundle:Article')
                ->orWhere('a INSTANCE OF SiteBundle:Video')
                ->orderBy('a.dateSubmission', 'DESC');

        return $qb;
    }

}

