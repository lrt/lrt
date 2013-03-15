<?php

namespace Lrt\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Lrt\AdhesionBundle\Entity\Adherent;

class LoadAdherentData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->newAdherent('nicolas', 'durand', new \DateTime('1968-05-01'), 'nicolas.durand@gmail.com', '0658220012', new \DateTime('2013-02-25'));
        $this->newAdherent('brigitte', 'durand', new \DateTime('1969-06-10'), 'brigitte.durand@gmail.com', '0657220012', new \DateTime('2013-02-25'));
        $this->newAdherent('john', 'doe', new \DateTime('1997-07-26'), 'john.doe@gmail.com', '0658230212', new \DateTime('2013-02-25'));
        $this->newAdherent('marcel', 'michel', new \DateTime('1988-12-19'), 'marcel.michel@gmail.com', '0622220012', new \DateTime(''));
    }
    
    protected function newAdherent($firstName, $lastName, $birthday, $email, $phone, $submission)
    {
        $adherent = new Adherent();
        $adherent->setFirstName($firstName);
        $adherent->setLastName($lastName);
        $adherent->setBirthday($birthday);
        $adherent->setAddress('85 rue des champs');
        $adherent->setCity('Paris');
        $adherent->setZipCode('75009');
        $adherent->setPhone($phone);
        $adherent->setEmail($email);
        $adherent->setIsValid(Adherent::IS_NOT_ACTIVE);
        $adherent->setDateSubmission($submission);

        $this->manager->persist($adherent);
        $this->manager->flush();
    }
    
    public function getOrder()
    {
        return 2;
    }
}

