<?php

namespace Lrt\CMSBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * User: alex
 * Date: 23/12/12
 */
class CategoryControllerTest extends WebTestCase
{

    /**
     * @test
     * @testdox Création d'une nouvelle catégorie après avoir appuyer sur "valider" on renvoie un message.
     * @group article
     */
    public function addCategory()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/category/new');

        $form = $crawler->selectButton('Create')->form(array(
            'lrt_cmsbundle_categorytype[name]' => 'test',
        ));

        $crawler = $client->submit($form);

        $this->assertTrue($crawler->filter('html:contains("test")')->count() > 0);
    }

    /**
     * @test
     * @testdox Modifier une catégorie via un id qui n'existe pas
     * @group article
     */
    public function editInvalidCategory()
    {
        $client = static::createClient();
        $client->request('GET', '/category/99999999/edit');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @testdox La catégorie que l'on veut afficher n'existe pas alors on retourne 404.
     * @group article
     */
    public function showWithUnknownCategoryReturns404()
    {
        $client = static::createClient();
        $client->request('GET', '/category/99999999/show');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
