<?php

/**
 * @category Testing
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\CMSBundle\Tests\Controller;

use Lrt\SiteBundle\Tests\Controller\LrtWebTestCase;

class CategoryControllerTest extends LrtWebTestCase
{
    
    /**
     * @test
     * @testdox Accès à la liste des catégories
     * @group cat
     */
    public function listCategory()
    {
        $this->login($this->client, array('user' => 'alexandre'));
        $this->client->request('GET', '/category');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    
    /**
     * @test
     * @testdox Création d'une nouvelle catégorie après avoir appuyer sur "valider" on renvoie un message.
     * @group cat
     */
    public function addCategory()
    {
        $this->login($this->client, array('user' => 'alexandre'));
        $crawler = $this->client->request('GET', '/category/new');

        $form = $crawler->selectButton('Create')->form(array(
            'lrt_cmsbundle_categorytype[name]' => 'Nouvelle catégorie',
        ));

        $crawler = $this->client->submit($form);

        $categoryRepository = $this->em->getRepository('CMSBundle:Category');
        $category = $categoryRepository->findOneBy(array('name' => 'Nouvelle catégorie'));
        $this->assertNotEmpty($category);
    }

    /**
     * @test
     * @testdox Modifier une catégorie via un id qui n'existe pas
     * @group cat
     */
    public function editInvalidCategory()
    {
        $this->login($this->client, array('user' => 'alexandre'));
        $this->client->request('GET', '/category/99999999/edit');
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @testdox La catégorie que l'on veut afficher n'existe pas alors on retourne 404.
     * @group cat
     */
    public function showWithUnknownCategoryReturns404()
    {
        $this->login($this->client, array('user' => 'alexandre'));
        $this->client->request('GET', '/category/99999999/show');
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @testdox La catégorie que l'on veut afficher existe alors on retourne 200.
     * @group cat
     */
    public function showWithknownCategoryReturns404()
    {
        $this->login($this->client, array('user' => 'alexandre'));
        $this->client->request('GET', '/category/1/show');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
