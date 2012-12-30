<?php

namespace Lrt\TeamBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Lrt\TeamBundle\Entity\Team;

/**
 * User: alex
 * Date: 30/12/12
 */
class LoadTeamData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $this->manager = $manager;

        $this->createTeam('Equipe 1','equipe-1');
        $this->createTeam('Equipe 2','equipe-2');
    }

    protected function createTeam($name,$reference)
    {

        $team = new Team();
        $team->setName($name);

        $this->addReference($reference,$team);

        $this->manager->persist($team);
        $this->manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
