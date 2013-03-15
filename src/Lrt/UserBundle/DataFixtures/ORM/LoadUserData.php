<?php

namespace Lrt\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Lrt\UserBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $groupSuperviseur = $this->getReference('superviseur-group');
        $groupMember = $this->getReference('member-group');
        $groupAdmin = $this->getReference('admin-group');

        //ADMIN
        $this->newUser('alexandre', 'alexandre.seiller@longchamp-roller-team.com', true, $groupAdmin, 'ROLE_ADMIN', 'alexandre1');
        $this->newUser('jeremy', 'jeremy.dubosc@longchamp-roller-team.com', true, $groupSuperviseur, 'ROLE_SUPERVISEUR', 'jeremy1');
        $this->newUser('julien', 'julien.morelle@longchamp-roller-team.com', true, $groupSuperviseur, 'ROLE_SUPERVISEUR', 'julien1');
        $this->newUser('nicolas', 'nicolas.prat@longchamp-roller-team.com', true, $groupMember, 'ROLE_MEMBER', 'nicolas1');
    }

    protected function newUser($userName, $email, $enabled, $group, $role, $reference)
    {
        $user = new User();
        $user->setUsername($userName);
        $user->setEmail($email);
        $user->setEnabled($enabled);
        $user->addRole($role);
        $user->addGroup($group);
        $user->setDateSubmission(new \DateTime());
        $user->setPlainPassword('test');
        $this->addReference($reference, $user);

        $this->manager->persist($user);
        $this->manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }

}

