<?php

namespace Lrt\CMSBundle\Tests\Controller;

use Lrt\SiteBundle\Tests\Controller\LrtWebTestCase;

/**
 * @category Testing
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */
class ArticleControllerTest extends LrtWebTestCase
{

    /**
     * @test
     * @testdox Accès à la liste des articles
     * @group article
     */
    public function listArticle()
    {
        $client = static::createClient();
        $this->login($client, array('user' => 'alexandre'));
        $client->request('GET', '/article');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @testdox Modifier un article dont les données seraient valide
     * @group cat
     */
    public function editArticleValid()
    {
        $client = static::createClient();
        $this->login($client, array('user' => 'alexandre'));
        $this->em = $client->getContainer()->get('doctrine')->getEntityManager();

        $articleRepository = $this->em->getRepository('CMSBundle:Article');
        $article = $articleRepository->findOneBy(array('title' => 'Article 1'));

        $crawler = $client->request('GET', '/article/'.$article->getId().'/edit');

        $form = $crawler->selectButton('Edit')->form(array(
            'lrt_cmsbundle_articletype[title]' => 'Nouveau Site',
        ));

        $crawler = $client->submit($form);

        $test = $articleRepository->findOneBy(array('title' => 'Nouveau Site'));

        $this->assertNotEmpty($test);
    }

    /**
     * @test
     * @testdox Modifier un article via un id qui n'existe pas
     * @group article
     */
    public function editInvalidArticle()
    {
        $client = static::createClient();
        $this->login($client, array('user' => 'alexandre'));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
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
        $this->login($client, array('user' => 'alexandre'));
        $client->request('GET', '/article/99999999/show');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @testdox L'article que l'on veut afficher existe alors on retourne 200.
     * @group article
     */
    public function showWithknownArticleReturns200()
    {
        $client = static::createClient();
        $this->login($client, array('user' => 'alexandre'));
        $client->request('GET', '/article/1/show');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}