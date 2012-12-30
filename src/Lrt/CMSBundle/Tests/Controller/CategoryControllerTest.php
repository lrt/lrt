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
        $client = static::createClient();
        $this->login($client,'alexandre');
        $client->request('GET', '/category');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @testdox Modifier une catégorie via un id qui n'existe pas
     * @group cat
     */
    public function editInvalidCategory()
    {
        $client = static::createClient();
        $this->login($client,'alexandre');
        $client->request('GET', '/category/99999999/edit');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @testdox Modifier une catégorie dont les données seraient valide
     * @group cat
     */
    public function editCategoryValid()
    {
        $client = static::createClient();
        $this->login($client,'alexandre');
        $this->em = $client->getContainer()->get('doctrine')->getEntityManager();

        $categoryRepository = $this->em->getRepository('CMSBundle:Category');
        $category = $categoryRepository->findOneBy(array('name' => 'Autres'));

        $crawler = $client->request('GET', '/category/'.$category->getId().'/edit');

        $form = $crawler->selectButton('Edit')->form(array(
            'lrt_cmsbundle_categorytype[name]' => 'Nouveauté',
        ));

        $crawler = $client->submit($form);

        $test = $categoryRepository->findOneBy(array('name' => 'Nouveauté'));

        $this->assertNotEmpty($test);
    }

    /**
     * @test
     * @testdox La catégorie que l'on veut afficher n'existe pas alors on retourne 404.
     * @group cat
     */
    public function showWithUnknownCategoryReturns404()
    {
        $client = static::createClient();
        $this->login($client,'alexandre');
        $client->request('GET', '/category/99999999/show');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @testdox La catégorie que l'on veut afficher existe alors on retourne 200.
     * @group cat
     */
    public function showWithknownCategoryReturns404()
    {
        $client = static::createClient();
        $this->login($client,'alexandre');
        $client->request('GET', '/category/1/show');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
