<?php

namespace Lrt\VideoBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Lrt\VideoBundle\Entity\Video;

/**
 * User: alex
 * Date: 27/12/12
 */
class LoadVideoData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $this->manager = $manager;
        $user = $this->getReference('alexandre1');

        $this->newVideo($user,'Longchamp @t Barcelone');
        $this->newVideo($user,'Longchamp @t Corée du Sud');
        $this->newVideo($user,'Longchamp @t Téléthon 2012');
    }

    protected function newVideo($user,$title)
    {
        $video = new Video();

        $video->setTitle($title);
        $video->setUser($user);
        $video->setDescription('Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Na. Cras elementum molestie vestibulum. Morbi id quam nisl. Praesent hendrerit, orci sed elementum lobortis.');
        $video->setIsValid(Video::IS_VALIDATED);
        $video->setDateSubmission(new \DateTime('22-01-2013'));

        $this->manager->persist($video);
        $this->manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}
