<?php

namespace Lrt\TeamBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Lrt\TeamBundle\Entity\PrizeList;

/**
 * User: alex
 * Date: 30/12/12
 */
class LoadPrizeListData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $this->manager = $manager;

        $user1 = $this->getReference('alexandre1');
        $user2 = $this->getReference('julien1');
        $user3 = $this->getReference('jeremy1');
        $user4 = $this->getReference('nicolas1');

        //ALEX
        $this->newPrize('Critérium de Lavaré',2011,1,$user1);
        $this->newPrize('Semi-marathon de Lyon',2011,2,$user1);
        $this->newPrize('Semi-marathon de Beauvais',2011,2,$user1);
        $this->newPrize('Marathon de Beauvais',2011,2,$user1);
        $this->newPrize('6h de Troyes (Trio)',2011,2,$user1);
        $this->newPrize('Trophée de Saint-Germain-en-Laye',2011,6,$user1);
        $this->newPrize('6h de Clermont (Solo)',2010,3,$user1);
        $this->newPrize('Picardie Inline Cup',2010,2,$user1);

        //JULIEN
        $this->newPrize('Trophée de Saint-Germain-en-Laye',2011,2,$user2);
        $this->newPrize('Critérium de Lavaré',2011,4,$user2);
        $this->newPrize('Marathon de Beauvais',2011,3,$user2);
        $this->newPrize('Marathon de Berlin',2011,3,$user2);
        $this->newPrize('6h de Clermont (Solo)',2011,2,$user2);
        $this->newPrize('6h de Troyes (Duo)',2011,2,$user2);
        $this->newPrize('Coupe de France Marathons',2011,14,$user2);
        $this->newPrize('Semi-marathon de Beauvais',2009,2,$user2);
        $this->newPrize('Semi-marathon de Saint-Denis',2009,6,$user2);

        //JEREM
        $this->newPrize('6h de Clermont (Solo)',2011,1,$user3);
        $this->newPrize('Semi-marathon de Beauvais',2011,1,$user3);
        $this->newPrize('Critérium de Lavaré',2011,2,$user3);
        $this->newPrize('Trophée de Saint-Germain-en-Laye',2011,4,$user3);
        $this->newPrize('6h de Troyes (Duo)',2011,2,$user3);
        $this->newPrize('6h de Clermont (Solo)',2010,2,$user3);
        $this->newPrize('Critérium de Lavaré',2010,6,$user3);
        $this->newPrize('Critérium de Lavaré',2009,3,$user3);
        $this->newPrize('Semi-marathon de Beauvais',2008,1,$user3);
        $this->newPrize('Semi-marathon de Saint-Denis',2008,2,$user3);
        $this->newPrize('Marathon de Goëlo',2008,3,$user3);

        //Nico
        $this->newPrize('Trophée de Saint-Germain-en-Laye',2011,2,$user4);
        $this->newPrize('Critérium de Lavaré',2011,1,$user4);
        $this->newPrize('Picardie Inline Cup (J)',2010,1,$user4);
        $this->newPrize('6h de Clermont (Solo)',2010,6,$user4);
        $this->newPrize('FIC Rennes',2010,1,$user4);
        $this->newPrize('Critérium de Lavaré',2010,1,$user4);
        $this->newPrize('Marathon de Zurich (J)',2009,1,$user4);
        $this->newPrize('Marathon de Berlin (J)',2009,1,$user4);
        $this->newPrize('Marathon de Beauvais (J)',2009,1,$user4);
    }

    protected function newPrize($name,$year,$position,$user)
    {

        $prize = new PrizeList();
        $prize->setYear($year);
        $prize->setPosition($position);
        $prize->setName($name);
        $prize->setUser($user);

        $this->manager->persist($prize);
        $this->manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}
