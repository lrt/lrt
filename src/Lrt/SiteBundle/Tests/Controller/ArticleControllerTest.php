<?php

namespace Lrt\SiteBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client;
     */
    protected $client;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    protected function setup()
    {
        $this->client = static::createClient(array('environment' => 'test'));
        $this->client->followRedirects();
        $this->em = $this->client->getContainer()->get('doctrine')->getEntityManager();
    }

    /**
     * @test
     * @testdox Création d'un nouvelle article après avoir appuyer sur "valider" on renvoie un message.
     * @group act
     */
    public function addSite()
    {
        $crawler = $this->client->request('GET', '/article/new');

        $form = $crawler->selectButton('Ajouter')->form(array(
            'lrt_sitebundle_articletype[title]' => '6h de Chartres 2012',
            'lrt_sitebundle_articletype[content]' => 'Testttt',
            'lrt_sitebundle_articletype[status]' => 'IMMEDIATE',
            'lrt_sitebundle_articletype[isPublic]' => 1,
            'lrt_sitebundle_articletype[category]' => 3,
        ));

        $crawler = $this->client->submit($form);

        $this->assertTrue($crawler->filter('td:contains("6h de Chartres")')->count() > 0);
        $this->assertTrue($crawler->filter('td:contains("Testttt")')->count() > 0);
    }
}
