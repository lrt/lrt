<?php

namespace Lrt\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Lrt\SiteBundle\Entity\Event;

class LoadEventData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->newEvent('Challenge piste',new \DateTime('2013-03-24'),new \DateTime('2013-03-24'),'Tournan en Brie','http://www.monsite.fr','Test');
        $this->newEvent('Les trois pistes',new \DateTime('2013-03-30'),new \DateTime('2013-04-01'),'Pibrac-Valence d\'Agen-Gujan Mestras','http://www.monsite.fr','Test');
        $this->newEvent('GP Saint-Germain-en-laye',new \DateTime('2013-04-14'),new \DateTime('2013-04-14'),'St German en Laye','http://www.monsite.fr','Test');
        //$this->newEvent('Régionaux route',new \DateTime('2013-04-27'),new \DateTime('2013-24-28'),'Breuillet','http://www.monsite.fr','Test');
        $this->newEvent('Marathon de Beauvais',new \DateTime('2013-05-01'),new \DateTime('2013-05-01'),'Beauvais','http://www.monsite.fr','Test');
        $this->newEvent('Course à Saint-Denis',new \DateTime('2013-05-09'),new \DateTime('2013-05-09'),'St Denis','http://www.monsite.fr','Test');
        $this->newEvent('6h du circuit carole',new \DateTime('2013-05-19'),new \DateTime('2013-05-19'),'Tremblay en France','http://www.monsite.fr','Test');
        $this->newEvent('24h du Mans Roller',new \DateTime('2013-05-25'),new \DateTime('2013-05-26'),'Le Mans','http://www.monsite.fr','Test');
        $this->newEvent('Régionaux piste',new \DateTime('2013-06-02'),new \DateTime('2013-06-02'),'Villeparisis','http://www.monsite.fr','Test');
        $this->newEvent('CFRM',new \DateTime('2013-06-09'),new \DateTime('2013-06-09'),'Dijon','http://www.monsite.fr','Test');
        $this->newEvent('CFRM',new \DateTime('2013-06-23'),new \DateTime('2013-06-23'),'Strabourg','http://www.monsite.fr','Test');
        $this->newEvent('France piste',new \DateTime('2013-06-14'),new \DateTime('2013-06-16'),'Coulaines','http://www.monsite.fr','Test');
        $this->newEvent('Challenge du centre',new \DateTime('2013-09-15'),new \DateTime('2013-09-15'),'Loiret','http://www.monsite.fr','Test');
        $this->newEvent('CFRM',new \DateTime('2013-09-22'),new \DateTime('2013-09-22'),'Lyon','http://www.monsite.fr','Test');
        $this->newEvent('Marathon de Berlin',new \DateTime('2013-09-28'),new \DateTime('2013-09-28'),'Berlin','http://www.monsite.fr','Test');
        $this->newEvent('Championnat de France Marathon',new \DateTime('2013-10-05'),new \DateTime('2013-10-06'),'Grenade','http://www.monsite.fr','Test');
    }

    protected function newEvent($title,$dateDeb,$dateEnd,$place,$website,$description)
    {
        $event = new Event();
        $event->setTitle($title);
        $event->setDateDeb($dateDeb);
        $event->setDateEnd($dateEnd);
        $event->setPlace($place);
        $event->setWebsite($website);
        $event->setDescription($description);

        $this->manager->persist($event);
        $this->manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }
}
