<?php

namespace Lrt\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;
use JMS\DiExtraBundle\Annotation as DI;
use Lrt\UserBundle\Entity\User;

class ArticleRepository extends EntityRepository
{    
    /**
     * Retourne la liste des articles
     * @param integer $limit
     * @return array
     */
    public function getLatestArticles($limit = 5)
    {
        $qb = $this->createQueryBuilder('a')
                ->select('a.id, a.title, a.content, a.slug, c.name as category_name')
                ->join('a.category', 'c')
                ->where('a.status = ?1')
                ->setParameter(1, 0);

        if (!is_null($limit)) {
            $qb->setMaxResults(5);
        }

        $qb->setMaxResults($limit);

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * Retourne la liste des articles par catégories
     * @param type $categoryName
     */
    public function getArticlesByCategory($categoryName)
    {
        $qb = $this->createQueryBuilder('a')
                ->select('a.id, a.title, a.content, a.slug, c.name as category_name')
                ->join('a.category', 'c')
                ->where('c.name = ?1')
                ->setParameter(1, $categoryName);

        return $qb->getQuery()->getArrayResult();
    }
        
    /**
    * Retourne la liste des articles dont l'utilisateur est l'auteur
    * @param Lrt\UserBundle\Entity\User $user
    */
    public function getArticlesByUser(User $user)
    {
        $sql = 'SELECT a FROM CMSBundle:Article a
                JOIN CMSBundle:Category c WITH a.category = c.id
                JOIN UserBundle:User u WITH a.user = u.id
                WHERE a.user = :user ';
        
        $query = $this->getEntityManager()->createQuery($sql)
                    ->setParameter('user', $user);
       
        return $query->getResult();
    }
    
    /**
     * Filtre sur la liste des articles
     * @param string $title
     * @param string $status
     * @param string $publish
     * @return array
     */
    public function filter($title = '',$status = '',$publish = '',$category = '')
    {        
        $queryStr = 'SELECT a FROM CMSBundle:Article a
                     JOIN CMSBundle:Category c WITH a.category = c.id
                     WHERE 1 = 1 ';
                
        if ($title != null && $title != '') {
            $queryStr.= ' AND a.title LIKE :title ';
        }
        if ($status != null && $status != '') {
            $queryStr.= ' AND a.status LIKE :status ';
        }
        if ($publish != null && $publish != '') {
            $queryStr.= ' AND a.isPublic LIKE :publish ';
        }
        if ($category != null && $category != '') {
            $queryStr.= ' AND a.category = :category ';
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
        if ($category != null && $category != '') {
            $query->setParameter('category', $category->getId());
        }
        
        return $query->getResult();
    }

}
