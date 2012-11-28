<?php

namespace Lrt\SiteBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{
    public function getLatestArticles($limit)
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a.id, a.title, a.content, a.slug, c.name as category_name')
            ->join('a.category', 'c')
            ->where('a.status = ?1')
            ->setParameter(1, 0);

        if(!is_null($limit))
        {
            $qb->setMaxResults(5);
        }

        $qb->setMaxResults($limit);

        return $qb->getQuery()->getArrayResult();
    }
}
