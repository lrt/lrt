<?php

namespace Lrt\SiteBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Lrt\SiteBundle\Entity\Article;
use Lrt\SiteBundle\Enum\StatusArticleEnum;

class LoadArticleData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $statusArticleEnum = new StatusArticleEnum();
        $statusArticle = array_keys($statusArticleEnum->getData());

        $user = $this->getReference('alexandre1');
        $category = $this->getReference('category1');

        $this->newArticle($category,'Article 1',$statusArticle,$user);
        $this->newArticle($category,'Article 2',$statusArticle,$user);
        $this->newArticle($category,'Article 3',$statusArticle,$user);
        $this->newArticle($category,'Article 4',$statusArticle,$user);
        $this->newArticle($category,'Article 5',$statusArticle,$user);
        $this->newArticle($category,'Article 6',$statusArticle,$user);
        $this->newArticle($category,'Article 7',$statusArticle,$user);
        $this->newArticle($category,'Article 8',$statusArticle,$user);
    }

    protected function newArticle($category, $title, $statusArticle, $user)
    {
        $article = new Article();
        $article->setCategory($category);
        $article->setTitle($title);
        $article->setContent('is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.');
        $article->setStatus($statusArticle[rand(0, 1)]);
        $article->setIsPublic(1);
        $article->setUser($user);

        $this->manager->persist($article);
        $this->manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
