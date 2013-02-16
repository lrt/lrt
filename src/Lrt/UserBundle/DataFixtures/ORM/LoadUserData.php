<?php

namespace Lrt\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Lrt\UserBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $groupSuperviseur = $this->getReference('superviseur-group');
        $groupMember = $this->getReference('member-group');
        $groupAdmin = $this->getReference('admin-group');

        //ADMIN
        $this->newUser('alexandre', 'alexandre', 'seiller','alexandre.seiller@longchamp-roller-team.com', true, $groupAdmin ,'alexandre1');
        $this->newUser('jeremy', 'jeremy', 'dubosc', 'jeremy.dubosc@longchamp-roller-team.com', true, $groupSuperviseur,'jeremy1');
        $this->newUser('julien', 'julien', 'morelle','julien.morelle@longchamp-roller-team.com', true, $groupSuperviseur,'julien1');
        $this->newUser('nicolas', 'nicolas', 'prat','nicolas.prat@longchamp-roller-team.com', true, $groupMember ,'nicolas1');
    }

    protected function newUser($userName, $firstName, $lastName, $email, $enabled, $group, $reference)
    {
        $user = new User();
        $user->setUsername($userName);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setEmail($email);
        $user->setEnabled($enabled);
        $user->setIsAdhesion(0);
        $user->addGroup($group);
        $user->setDateValidation(new \DateTime());
        $user->setDateSubmission(new \DateTime());
        $user->setPlainPassword('test');
        $this->addReference($reference,$user);

        $this->manager->persist($user);
        $this->manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }

}

