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

        $this->newVideo('39th Marathon de Berlin', 'description de la video', $path_server . 'berlin_skating_marathon', new \DateTime('06/10/2012'), $user);
        $this->newVideo('Corée du Sud', 'Le 16 septembre 2012 avait lieu à Jeonju (Corée du Sud) la cinquième et dernière étape de la Coupe du Monde de Roller Marathon 2012. Le team LONGCHAMP ROLLER TEAM était aligné au départ de cette épreuve qui fêtait cette année son dixième anniversaire et intégrait pour la première fois le calendrier de la Coupe du Monde. Un grand Merci à Hinnerk FEMERLING et Christophe AUDOIRE.', $path_server . 'longchamp_roller_team_@_corée_du_sud_640x360', new \DateTime('16-09-2012'), $user);
        $this->newVideo('Teaser Téléthon 2012', 'OSEZ VAINCRE ! L\'association Longchamp Roller Team se mobilise pour le Téléthon 2012 et vous invite à participer aux "6 heures roller du 16ème arrondissement de Paris". L\'épreuve se déroulera le samedi 8 décembre 2012 de 11 heures à 17 heures sur la piste de La Muette. En Relais ou en solo, l\'objectif étant de réunir le maximum de monde pour la même cause : vaincre les maladies neuromusculaires. Une participation d\'au moins 4 euros par personne sera reversée à l\'Association Française contre les Myopathies (AFM). Alors venez nous rejoindre et osez vaincre !
    L’épreuve des « 6 heures roller du 16ème arrondissement de Paris Téléthon 2012 » est une épreuve loisir ouverte à tous et qui vous donnera l\’occasion de rouler à votre guise quel que soit votre niveau, en solo ou en relais.', $path_server . 'longchamp_roller_team_@_téléthon_2012_(teaser)_640x360', new \DateTime('12/12/2012'), $user);
        $this->newVideo('Téléthon 2012', 'description de la video', $path_server . 'longchamp_roller_team_#telethon2012_640x480', new \DateTime('21-01-2013'), $user);
        $this->newVideo('Ligne Droite 1992-2012', 'Leader dans le secteur de la distribution de matériel de roller course, la société LIGNE DROITE fête cette année ses 20 ans.', $path_server . 'ligne_droite_1992_2012_20_ans_de_passion_640x360', new \DateTime('21-03-2012'), $user);
        $this->newVideo('In the shade of skates', 'description de la video', $path_server . 'in_the_shade_of_skates_1280x720', new \DateTime('23-03-2013'), $user);
    }

    protected function newVideo($title, $description, $path, $date, $user)
    {
        $video = new Video();
        $video->setTitle($title);
        $video->setPath($path);
        $video->setDescription($description);
        $video->setDateSubmission($date);
        $video->setUser($user);

        $this->manager->persist($video);
        $this->manager->flush();

    }

    public function getOrder()
    {
        return 5;
    }
}
