<?php

namespace Lrt\SiteBundle\Tests\Controller;

use Lrt\SiteBundle\Tests\Controller\LrtWebTestCase;

class EventControllerTest extends LrtWebTestCase
{
    /**
     * @test
     * @testdox Modifier un event via un id qui n'existe pas
     * @group event
     * @group SiteBundle
     */
    public function editInvalidEvent()
    {
        $client = static::createClient();
        $this->login($client, array('user' => 'alexandre'));
        $client->request('GET', '/event/99999999/edit');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
    
    /**
     * @test
     * @testdox Ajouter un évènement
     * @group ko
     * @group SiteBundle
     */
    public function addEventValid()
    {
        $this->login($this->client, array('user' => 'alexandre'));

        $crawler = $this->client->request('GET', '/event/new');

        $form = $crawler->selectButton('Valider')->form(array(
            'lrt_calendarbundle_eventtype[title]' => 'Nouvelle évènement',
            'lrt_calendarbundle_eventtype[dateDeb]' => '10/03/2013',
            'lrt_calendarbundle_eventtype[dateEnd]' => '10/03/2013',
            'lrt_calendarbundle_eventtype[place]' => 'Paris',
            'lrt_calendarbundle_eventtype[website]' => 'http://www.myevent.com',
            'lrt_calendarbundle_eventtype[description]' => 'is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged',
        ));

        $this->client->submit($form);
        $crawler = $this->client->getCrawler();
                
        $this->assertTrue($crawler->filter('html:contains("Evènement ajouté avec succès.")')->count() > 0);
    }

    /**
     * @test
     * @testdox Modifier une video existante
     * @group event
     * @group SiteBundle
     */
    public function editEventValid()
    {
        $this->login($this->client, array('user' => 'alexandre'));

        $event = $this->em->getRepository('SiteBundle:Event')->findOneBy(array('title' => 'Nouvelle évènement'));

        $crawler = $this->client->request('GET', '/event/'.$event->getId().'/edit');

        $form = $crawler->selectButton('Modifier')->form(array(
            'lrt_calendarbundle_eventtype[title]' => 'Nouvelle évènement',
            'lrt_calendarbundle_eventtype[dateDeb]' => '12/03/2013',
            'lrt_calendarbundle_eventtype[dateEnd]' => '12/03/2013',
            'lrt_calendarbundle_eventtype[place]' => 'Strasbourg',
            'lrt_calendarbundle_eventtype[website]' => 'http://www.myevent.com',
            'lrt_calendarbundle_eventtype[description]' => 'is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged',
        ));

        $this->client->submit($form);
        $crawler = $this->client->getCrawler();
        
        $this->assertTrue($crawler->filter('html:contains("Modification de l\'évènement Nouvelle évènement réussi avec succès.")')->count() > 0);
    }
}

