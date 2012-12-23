<?php

namespace Lrt\CMSBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * User: alex
 * Date: 23/12/12
 */
class ArticleControllerTest extends WebTestCase
{

    /**
     * @test
     * @testdox Création d'un nouvelle article après avoir appuyer sur "valider" on renvoie un message. Non connecté
     * @group article
     */
    public function addArticle()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/article/new');

        $form = $crawler->selectButton('Ajouter')->form(array(
            'lrt_cmsbundle_articletype[title]' => 154682,
            'lrt_cmsbundle_articletype[content]' => 'Test de contenu',
            'lrt_cmsbundle_articletype[status]' => 'IMMEDIATE',
            'lrt_cmsbundle_articletype[isPublic]' => 1,
            'lrt_cmsbundle_articletype[category]' => 1,
        ));

        $crawler = $client->submit($form);

        $this->assertTrue($crawler->filter('html:contains("Vous devez être connecté")')->count() > 0);
    }

    /**
     * @test
     * @testdox Modifier un article via un id qui n'existe pas
     * @group article
     */
    public function editInvalidArticle()
    {
        $client = static::createClient();
        $client->request('GET', '/article/99999999/edit');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @testdox L'article que l'on veut afficher n'existe pas alors on retourne 404.
     * @group article
     */
    public function showWithUnknownArticleReturns404()
    {
        $client = static::createClient();
        $client->request('GET', '/article/99999999/show');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
