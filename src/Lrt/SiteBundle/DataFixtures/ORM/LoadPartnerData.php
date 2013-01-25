<?php

namespace Lrt\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Lrt\SiteBundle\Entity\Partner;

class LoadPartnerData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = $this->getReference('alexandre1');

        $partner = new Partner();
        $partner->setName('Synergie');
        $partner->setDescription('description de l\'entreprise');
        $partner->setWebsite("http://www.monsite.fr");
        $partner->setUser($user);
        $partner->setIsValid(1);

        $partner2 = new Partner();
        $partner2->setName('RS2P');
        $partner2->setDescription('description de l\'entreprise');
        $partner2->setWebsite("http://www.monsite.fr");
        $partner2->setUser($user);
        $partner2->setIsValid(1);

        $partner3 = new Partner();
        $partner3->setName('IENA');
        $partner3->setDescription('description de l\'entreprise');
        $partner3->setWebsite("http://www.monsite.fr");
        $partner3->setUser($user);
        $partner3->setIsValid(1);

        $partner4 = new Partner();
        $partner4->setName('Groupe Matis');
        $partner4->setDescription('description de l\'entreprise');
        $partner4->setWebsite("http://www.monsite.fr");
        $partner4->setUser($user);
        $partner4->setIsValid(1);

        $partner5 = new Partner();
        $partner5->setName('Groupe Arcade');
        $partner5->setDescription('description de l\'entreprise');
        $partner5->setWebsite("http://www.monsite.fr");
        $partner5->setUser($user);
        $partner5->setIsValid(1);

        $manager->persist($partner);
        $manager->persist($partner2);
        $manager->persist($partner3);
        $manager->persist($partner4);
        $manager->persist($partner5);

        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }
}
