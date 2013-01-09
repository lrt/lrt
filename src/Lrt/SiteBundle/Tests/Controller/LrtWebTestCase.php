<?php

namespace Lrt\SiteBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

abstract class LrtWebTestCase extends WebTestCase
{
    
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client;
     */
    protected $client;
    protected $em;

    protected function setup()
    {
        $this->client = static::createClient(array('environment' => 'test'));
        $this->client->followRedirects();
        $this->em = $this->client->getContainer()->get('doctrine')->getEntityManager();
    }
    
    /**
     * Do login for user
     *
     * @param Client $client
     * @param type $role
     * @return Client
     */
    protected function login(Client $client, $user)
    {
        $client->followRedirects();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form();

        $form['_username'] = $user['user'];
        $form['_password'] = 'test';

        $client->submit($form);

        return $client;
    }

    protected function fixturesLoad($em)
    {
        $loader = new \Doctrine\Common\DataFixtures\Loader();
        $loader->loadFromDirectory('src/Lrt/UserBundle/DataFixtures/ORM/');
        $purger = new ORMPurger();
        $executor = new ORMExecutor($em, $purger);
        $executor->execute($loader->getFixtures());
    }
}
