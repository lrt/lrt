<?php

namespace Lrt\SiteBundle\Tests\Controller;

use Lrt\SiteBundle\Tests\Controller\LrtWebTestCase;

/**
 * User: alex
 * Date: 23/12/12
 */
class DefaultControllerTest extends LrtWebTestCase
{

    /**
     * @test
     * @testdox Accès à la home du site
     * @group home
     */
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @testdox Voir une page statique existante
     * @group home
     */
    public function showPageExistsReturn200()
    {
        $client = static::createClient();
        $client->request('GET', '/information/association');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @testdox Voir une page statique non existante
     * @group home
     */
    public function showPageNotExistsReturn404()
    {
        $client = static::createClient();
        $client->request('GET', '/information/test');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @testdox Voir la partie blog
     * @group home
     */
    public function showBlogReturn200()
    {
        $client = static::createClient();
        $client->request('GET', '/blog');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
