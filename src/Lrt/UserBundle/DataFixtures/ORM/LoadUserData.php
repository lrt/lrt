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

        $team1 = $this->getReference('equipe-1');
        $team2 = $this->getReference('equipe-2');

        //ADMIN
        $this->newUser('alexandre', 'alexandre', 'seiller','alexandre.seiller@longchamp-roller-team.com', true, 'ROLE_ADMIN',$team2,'alexandre1');
        $this->newUser('jeremy', 'jeremy', 'dubosc', 'jeremy.dubosc@longchamp-roller-team.com', true, 'ROLE_ADMIN', $team1,'jeremy1');
        $this->newUser('julien', 'julien', 'morelle','julien.morelle@longchamp-roller-team.com', true, 'ROLE_ADMIN', $team1,'julien1');
        $this->newUser('nicolas', 'nicolas', 'prat','nicolas.prat@longchamp-roller-team.com', true, 'ROLE_ADMIN',$team1,'nicolas1');
    }

    protected function newUser($userName, $firstName, $lastName, $email, $enabled, $role, $team, $reference)
    {
        $user = new User();
        $user->setUsername($userName);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setEmail($email);
        $user->setEnabled($enabled);
        $user->setTeam($team);
        $user->addRole($role);
        $user->setPlainPassword('test');
        $this->addReference($reference,$user);
        $this->manager->persist($user);
        $this->manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }

}

?>

