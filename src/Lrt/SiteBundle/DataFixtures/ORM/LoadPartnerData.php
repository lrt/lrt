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
        $this->manager = $manager;

        $user = $this->getReference('alexandre1');

        $this->newPartner('Synergie','description de l\'entreprise','http://www.synergie.fr',$user);
        $this->newPartner('RS2P','description de l\'entreprise','http://www.cabinet-iena.com',$user);
        $this->newPartner('IENA','description de l\'entreprise','http://www.monsite.fr',$user);
        $this->newPartner('Groupe Matis','description de l\'entreprise','http://www.matis-group.com',$user);
        $this->newPartner('Groupe Arcade','description de l\'entreprise','http://www.arcade-groupe.com',$user);
    }

    protected function newPartner($name,$description,$website,$user)
    {
        $partner = new Partner();
        $partner->setName($name);
        $partner->setDescription($description);
        $partner->setWebsite($website);
        $partner->setUser($user);
        $partner->setIsValid(1);

        $this->manager->persist($partner);
        $this->manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }
}
