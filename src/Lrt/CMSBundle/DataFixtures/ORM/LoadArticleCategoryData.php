<?php

namespace Lrt\CMSBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Lrt\CMSBundle\Entity\Category;

class LoadArticleCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager)
    {

        $this->manager = $manager;

        $this->createCategory('Actualités','category1');
        $this->createCategory('Association','category2');
        $this->createCategory('Compétition','category3');
    }

    protected  function createCategory($name,$reference)
    {

        $category = new Category();
        $category->setName($name);

        $this->addReference($reference,$category);

        $this->manager->persist($category);
        $this->manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}
