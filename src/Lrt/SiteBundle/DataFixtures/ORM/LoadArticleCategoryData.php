<?php

namespace Lrt\SiteBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Lrt\SiteBundle\Entity\Category;

class LoadArticleCategoryData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $category1 = new Category();
        $category1->setName("Actualités");

        $category2 = new Category();
        $category2->setName("Association");

        $category3 = new Category();
        $category3->setName("Compétition");

        $category4 = new Category();
        $category4->setName("Autres");

        $manager->persist($category1);
        $manager->persist($category2);
        $manager->persist($category3);
        $manager->persist($category4);

        $this->addReference('category1',$category1);
        $this->addReference('category2',$category2);
        $this->addReference('category3',$category3);
        $this->addReference('category4',$category4);

        $manager->flush();
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
