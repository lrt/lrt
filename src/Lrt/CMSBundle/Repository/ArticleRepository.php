<?php

namespace Lrt\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;
use JMS\DiExtraBundle\Annotation as DI;
use Lrt\UserBundle\Entity\User;
use Lrt\CMSBundle\Entity\Article;
use Lrt\SiteBundle\Entity\Activity;

class ArticleRepository extends EntityRepository
{    
    /**
     * Retourne la liste des articles
     * @param integer $limit
     * @return array
     */
    public function getLatestArticles($limit)
    {
        $qb = $this->createQueryBuilder('a')
                ->select('a.id, a.title, a.content, c.name as category_name, a.path')
                ->join('a.category', 'c')
                ->where('a.status = ?1')
                ->setParameter(1, Article::IMMEDIATE);

        if (!is_null($limit)) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * Retourne la liste des articles d'un utilisateur en mode brouillon
     * @param \Lrt\UserBundle\Entity\User $user
     * @return array
     */
    public function getArticlesDraftsByUser(User $user)
    {
        $sql = 'SELECT a FROM CMSBundle:Article a
                JOIN CMSBundle:Category c WITH a.category = c.id
                JOIN UserBundle:User u WITH a.user = u.id
                WHERE a.user = :user
                AND a.status = :status';

        $query = $this->getEntityManager()->createQuery($sql)
            ->setParameter('user', $user)
            ->setParameter('status', Article::DRAFTS);

        return $query->getResult();
    }

    /**
     * Retourne la liste des articles dans la corbeille
     * @return array
     */
    public function getArticlesInBin()
    {
        $sql = 'SELECT a FROM CMSBundle:Article a
                JOIN CMSBundle:Category c WITH a.category = c.id
                AND a.status = :status';

        $query = $this->getEntityManager()->createQuery($sql)
            ->setParameter('status', Article::BIN);

        return $query->getResult();
    }

    /**
     * Retourne la liste des articles en attente de validation
     * @return array
     */
    public function getArticlesNotValidated()
    {
        $sql = 'SELECT a FROM CMSBundle:Article a
                JOIN CMSBundle:Category c WITH a.category = c.id
                AND a.isValid = :valid';

        $query = $this->getEntityManager()->createQuery($sql)
            ->setParameter('valid', Activity::IS_NOT_VALIDATED);

        return $query->getResult();
    }

    /**
     * Retourne la liste des articles par catégories
     * @param string $categoryName
     * @return array
     */
    public function getArticlesByCategory($categoryName)
    {
        $qb = $this->createQueryBuilder('a')
                ->select('a.id, a.title, a.content, c.name as category_name')
                ->join('a.category', 'c')
                ->where('c.name = ?1')
                ->setParameter(1, $categoryName);

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * Retourne la liste des articles dont l'utilisateur est l'auteur
     * @param \Lrt\UserBundle\Entity\User $user
     * @return array
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
     * @param string $publish
     * @param string $category
     * @return array
     */
    public function filter($title = '', $publish = '',$category = '')
    {        
        $queryStr = 'SELECT a FROM CMSBundle:Article a
                     JOIN CMSBundle:Category c WITH a.category = c.id
                     WHERE 1 = 1
                     AND a.status != '.Article::BIN.' ';
                
        if ($title != null && $title != '') {
            $queryStr.= ' AND a.title LIKE :title ';
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
        if ($publish != null && $publish != '') {
            $query->setParameter('publish', '%'.$publish.'%');
        }
        if ($category != null && $category != '') {
            $query->setParameter('category', $category->getId());
        }
        
        return $query->getResult();
    }

}
