<?php

namespace Lrt\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Lrt\UserBundle\Entity\Group;

class LoadGroupData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $groupMember = new Group();
        $groupMember->setName("member");
        $groupMember->setRoles(array('ROLE_MEMBER'));

        $groupSuperviseur = new Group();
        $groupSuperviseur->setName("superviseur");
        $groupSuperviseur->setRoles(array('ROLE_SUPERVISEUR'));

        $groupAdmin = new Group();
        $groupAdmin->setName("admin");
        $groupAdmin->setRoles(array('ROLE_SUPERVISEUR','ROLE_MEMBER', 'ROLE_ADMIN'));

        $manager->persist($groupMember);
        $manager->persist($groupSuperviseur);
        $manager->persist($groupAdmin);
        $manager->flush();

        $this->addReference('member-group', $groupMember);
        $this->addReference('superviseur-group', $groupSuperviseur);
        $this->addReference('admin-group', $groupAdmin);
    }

    public function getOrder()
    {
        return 1;
    }
}
