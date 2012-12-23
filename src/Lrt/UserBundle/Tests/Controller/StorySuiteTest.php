<?php

namespace Lrt\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Behat\Behat\Console\BehatApplication;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StorySuiteTest extends WebTestCase
{

    /**
     * @var Client;
     */
    protected $client;

    protected function setup()
    {
        $this->client = static::createClient(array('environment' => 'test'));
        $this->client->followRedirects();
    }

    /**
     * @test
     * @group stories
     */
    public function scenariosMeetAcceptanceCriteria()
    {
        $input = new ArrayInput(array(
            '--format' => 'junit,html',
            '--out' => 'build/logs/features,build/logs/features/index.html',
            'features' => '@UserBundle'
        ));
        $output = new ConsoleOutput();
        $app = new BehatApplication('DEV');
        $app->setAutoExit(false);
        $result = $app->run($input, $output);
        $this->assertEquals(0, $result, 'Au moins un des scénarios Behat ne passe pas dans UserBundle !');
    }

}
