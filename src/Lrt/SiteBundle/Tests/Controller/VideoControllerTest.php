<?php

namespace Lrt\SiteBundle\Tests\Controller;

use Lrt\SiteBundle\Tests\Controller\LrtWebTestCase;

class VideoControllerTest extends LrtWebTestCase
{

    /**
     * @test
     * @testdox Modifier une video via un id qui n'existe pas
     * @group video
     * @group SiteBundle
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
     * @testdox Ajouter une vidéo
     * @group video
     * @group SiteBundle
     */
    public function addVideoValid()
    {
        $this->login($this->client, array('user' => 'alexandre'));

        $crawler = $this->client->request('GET', '/video/new');

        $form = $crawler->selectButton('Valider')->form(array(
            'lrt_videobundle_videotype[title]' => 'Video Test',
            'lrt_videobundle_videotype[description]' => 'is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged',
            'lrt_videobundle_videotype[isPublished]' => '1',
            'lrt_videobundle_videotype[isHighlighted]' => '0',
        ));

        $this->client->submit($form);
        $crawler = $this->client->getCrawler();
        $this->assertTrue($crawler->filter('html:contains("Video ajoutée avec succès.")')->count() > 0);
    }

    /**
     * @test
     * @testdox Modifier une video existante
     * @group video
     * @group SiteBundle
     */
    public function editVideoValid()
    {
        $this->login($this->client, array('user' => 'alexandre'));

        $video = $this->em->getRepository('SiteBundle:Video')->findOneBy(array('title' => 'Video Test'));

        $crawler = $this->client->request('GET', '/video/'.$video->getId().'/edit');

        $form = $crawler->selectButton('Valider')->form(array(
            'lrt_videobundle_videotype[title]' => 'Nouvelle video behat',
            'lrt_videobundle_videotype[description]' => 'is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged',
            'lrt_videobundle_videotype[isPublished]' => '1',
            'lrt_videobundle_videotype[isHighlighted]' => '0',
        ));

        $this->client->submit($form);
        $crawler = $this->client->getCrawler();
        
        $this->assertTrue($crawler->filter('html:contains("Modification de la vidéo Nouvelle video behat réussi avec succès.")')->count() > 0);
    }
}

