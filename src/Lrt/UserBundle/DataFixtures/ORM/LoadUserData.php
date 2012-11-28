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

        $this->newUser('alexandre', 'alexandre', 'seiller','alexandre.seiller@longchamp-roller-team.com', true, 'ROLE_ADMIN','alexandre1');
        $this->newUser('jeremy', 'jeremy', 'dubosc', 'jeremy.dubosc@longchamp-roller-team.com', true, 'ROLE_ADMIN','jeremy1');
        $this->newUser('julien', 'julien', 'morelle','julien.morelle@longchamp-roller-team.com', true, 'ROLE_ADMIN','julien1');
    }

    protected  function newUser($userName, $firstName, $lastName, $email, $enabled, $role, $reference)
    {
        $user = new User();
        $user->setUsername($userName);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setEmail($email);
        $user->setEnabled($enabled);
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

