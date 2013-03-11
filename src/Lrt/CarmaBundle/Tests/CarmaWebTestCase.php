<?php

namespace Lrt\CarmaBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\Console\Input\ArrayInput;
use Behat\Behat\Console\BehatApplication;
use Symfony\Component\Console\Output\ConsoleOutput;

abstract class CarmaWebTestCase extends WebTestCase
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var HttpKernelInterface
     */
    protected $kern;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var EntityManager
     */
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
     * @param string $username
     * @param string $password
     * @return Client
     */
    protected function login(Client $client, $user)
    {
        $client->followRedirects();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form();

        $form['_username'] = $user['user'];
        $form['_password'] = 'test';

        $this->client->submit($form);

        return $this->client;
    }

    protected function userFixturesLoad()
    {
        $loader = new \Doctrine\Common\DataFixtures\Loader();
        $loader->loadFromDirectory('src/Grdf/UserBundle/DataFixtures/ORM/');
    }

    public function scenariosMeetAcceptanceCriteria($bundleName)
    {
        if (!is_dir('build/logs/features/' . $bundleName)) {
            if (!is_dir('build/logs/features/')) {
                mkdir('build/logs/features/');
            }
            mkdir('build/logs/features/' . $bundleName);
        }

        $input = new ArrayInput(array(
                '--format' => 'junit,html',
                '--out' => 'build/logs/features/' . $bundleName . ',build/logs/features/' . $bundleName . '/index.html',
                'features' => '@' . $bundleName
            ));
        $output = new ConsoleOutput();
        $app = new BehatApplication('DEV');
        $app->setAutoExit(false);
        $result = $app->run($input, $output);
        $this->assertEquals(0, $result, 'Au moins un des scénarios Behat ne passe pas dans ' . $bundleName . ', pour plus d\'info allez dans build/logs/features/ !');
    }

}

