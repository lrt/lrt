<?php

namespace Lrt\AdminBundle\Tests\Controller;

use Lrt\SiteBundle\Tests\Controller\LrtWebTestCase;

class DefaultControllerTest extends LrtWebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $this->login($client,'alexandre');
        $crawler = $client->request('GET', '/dashboard');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
