<?php

namespace Lrt\SiteBundle\Tests\Controller;

use Lrt\CarmaBundle\Tests\CarmaWebTestCase;

/**
 * User: alex
 * Date: 23/12/12
 */
class DefaultControllerTest extends CarmaWebTestCase
{

    /**
     * @test
     * @testdox Accès à la home du site
     * @group home
     */
    public function testIndex()
    {
        $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @testdox Voir une page statique existante
     * @group home
     */
    public function showPageExistsReturn200()
    {
        $this->client->request('GET', '/information/association');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @testdox Voir une page statique non existante
     * @group home
     */
    public function showPageNotExistsReturn404()
    {
        $this->client->request('GET', '/information/test');
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @testdox Voir la partie blog
     * @group home
     */
    public function showBlogReturn200()
    {
        $this->client->request('GET', '/blog');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @testdox Contact
     * @group contact
     */
    public function contactTest()
    {
        $this->login($this->client, array('user' => 'alexandre'));

        $crawler = $this->client->request('GET', '/contact');

        $form = $crawler->selectButton('Envoyer')->form(array(
            'contact[name]' => 'Mr Behat',
            'contact[email]' => 'test@gmail.com',
            'contact[subject]' => 'Nouveau message behat',
            'contact[body]' => 'is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged',
        ));

        $this->client->submit($form);
        $crawler = $this->client->getCrawler();
    }

}
