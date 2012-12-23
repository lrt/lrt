<?php

namespace Lrt\SiteBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

abstract class LrtWebTestCase extends WebTestCase
{

    /**
     * Do login for user
     *
     * @param Client $client
     * @param $user
     * @internal param \Lrt\SiteBundle\Tests\Controller\type $role
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
        $loader->loadFromDirectory('src/Lrt/SiteBundle/DataFixtures/ORM/');
        $loader->loadFromDirectory('src/Lrt/UserBundle/DataFixtures/ORM/');
        $purger = new ORMPurger();
        $executor = new ORMExecutor($em, $purger);
        $executor->execute($loader->getFixtures());
    }
}
