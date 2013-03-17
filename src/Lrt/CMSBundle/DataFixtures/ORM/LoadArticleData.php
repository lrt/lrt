<?php

namespace Lrt\CMSBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Lrt\CMSBundle\Entity\Article;
use Lrt\SiteBundle\Entity\Activity;

class LoadArticleData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $user = $this->getReference('alexandre1');
        $user2 = $this->getReference('nicolas1');

        $category = $this->getReference('category1');

        $this->newArticle($category,'Article 1',$user,Activity::IS_VALIDATED);
        $this->newArticle($category,'Article 2',$user,Activity::IS_VALIDATED);
        $this->newArticle($category,'Article 3',$user,Activity::IS_VALIDATED);
        $this->newArticle($category,'Article 4',$user,Activity::IS_VALIDATED);
        $this->newArticle($category,'Article 5',$user,Activity::IS_VALIDATED);
        $this->newArticle($category,'Article 6',$user,Activity::IS_VALIDATED);
        $this->newArticle($category,'Article 7',$user,Activity::IS_VALIDATED);
        $this->newArticle($category,'Article 8',$user,Activity::IS_VALIDATED);
        $this->newArticle($category,'Article 9',$user2,Activity::IS_NOT_VALIDATED);
    }

    protected function newArticle($category,$title,$user,$valid)
    {
        $article = new Article();
        $article->setCategory($category);
        $article->setTitle($title);
        $article->setContent('is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.');
        $article->setIsValid($valid);
        $article->setUser($user);
        $article->setDateSubmission(new \DateTime('22-01-2013'));
        if($valid === 0) {
            $article->setStatus(Article::DRAFTS);
            $article->setIsPublic(0);
        } else {
            $article->setStatus(Article::IMMEDIATE);
            $article->setIsPublic(1);
        }

        $this->manager->persist($article);
        $this->manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
