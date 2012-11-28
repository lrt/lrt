<?php

namespace Lrt\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{

    public function testCompleteScenario()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user/');
        $this->assertTrue(404 === $client->getResponse()->getStatusCode());
    }
}