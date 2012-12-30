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
}
