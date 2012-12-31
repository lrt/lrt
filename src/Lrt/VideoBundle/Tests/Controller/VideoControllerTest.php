<?php

namespace Lrt\VideoBundle\Tests\Controller;

use Lrt\SiteBundle\Tests\Controller\LrtWebTestCase;

/**
 * @category Testing
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */
class VideoControllerTest extends LrtWebTestCase
{

    /**
     * @test
     * @testdox Accès à la liste des videos
     * @group video
     */
    public function listVideo()
    {
        $client = static::createClient();
        $this->login($client, array('user' => 'alexandre'));
        $this->em = $client->getContainer()->get('doctrine')->getEntityManager();
        $client->request('GET', '/video');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $videoRepository = $this->em->getRepository('VideoBundle:Video');
        $video = $videoRepository->findAll();
        $this->assertNotEmpty($video);
    }

    /**
     * @test
     * @testdox Modifier une vidéo dont les données seraient valide
     * @group video
     */
    public function editVideoValid()
    {
        $client = static::createClient();
        $this->login($client, array('user' => 'alexandre'));
        $this->em = $client->getContainer()->get('doctrine')->getEntityManager();

        $videoRepository = $this->em->getRepository('VideoBundle:Video');
        $video = $videoRepository->findOneBy(array('title' => 'Longchamp @t Barcelone'));

        $crawler = $client->request('GET', '/video/'.$video->getId().'/edit');

        $form = $crawler->selectButton('Edit')->form(array(
            'lrt_videobundle_videotype[title]' => 'Longchamp - Barcelone',
        ));

        $crawler = $client->submit($form);

        $test = $videoRepository->findOneBy(array('title' => 'Longchamp - Barcelone'));

        $this->assertNotEmpty($test);
    }

    /**
     * @test
     * @testdox Modifier une video via un id qui n'existe pas
     * @group video
     */
    public function editInvalidVideo()
    {
        $client = static::createClient();
        $this->login($client, array('user' => 'alexandre'));
        $client->request('GET', '/video/99999999/edit');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @testdox La video que l'on veut afficher n'existe pas alors on retourne 404.
     * @group article
     */
    public function showWithUnknownVideoReturns404()
    {
        $client = static::createClient();
        $this->login($client,'alexandre');
        $client->request('GET', '/video/99999999/show');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
