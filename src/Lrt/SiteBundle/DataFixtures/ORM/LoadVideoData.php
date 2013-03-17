<?php

namespace Lrt\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Lrt\SiteBundle\Entity\Video;

class LoadVideoData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $path_server = 'http://video.longchamp-roller-team.com/';

        $user = $this->getReference('julien1');

        $this->newVideo('39th Marathon de Berlin','description de la video', $path_server.'39th_berlin_skating_marathon_by_longchamp_roller_team.mp4',$user);
        $this->newVideo('Corée du Sud','description de la video', $path_server.'longchamp_roller_team_@_corée_du_sud_640x360.mp4',$user);
        $this->newVideo('Teaser Téléthon 2012','description de la video',$path_server.'longchamp_roller_team_@_téléthon_2012_(teaser)_640x360.mp4',$user);
        $this->newVideo('Téléthon 2012','description de la video',$path_server.'longchamp_roller_team_#telethon2012_640x480.mp4',$user);
        $this->newVideo('Ligne Droite 1992-2012','description de la video',$path_server.'ligne_droite_1992_2012_20_ans_de_passion_640x360.mp4',$user);
    }

    protected function newVideo($title, $description, $path, $user)
    {
        $video = new Video();
        $video->setTitle($title);
        $video->setPath($path);
        $video->setDescription($description);
        $video->setDateSubmission(new \DateTime);
        $video->setUser($user);

        $this->manager->persist($video);
        $this->manager->flush();

    }

    public function getOrder()
    {
        return 5;
    }
}
