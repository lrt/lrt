<?php

namespace Lrt\CMSBundle\Tests\Command;

use Lrt\SiteBundle\Tests\Controller\LrtWebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application as App;
use Symfony\Component\Console\Tester\CommandTester;
use Lrt\CMSBundle\Command\GenerateFluxRssCommand;

class GenerateFluxRssCommandTest extends LrtWebTestCase
{
    public $application;
    public $command;
    public $commandTester;

    public function setup()
    {
        $kernel = $this->createKernel();
        $kernel->boot();

        $this->application = new App($kernel);
        $this->application->add(new GenerateFluxRssCommand());

        $this->command = $this->application->find('cms:generate:rss');

        $this->commandTester = new CommandTester($this->command);
    }

    /**
     * @test
     * @group generateFluxRSSCommand
     */
    public function executeTest()
    {

        $this->commandTester->execute(array('command' => $this->command->getName(),
            '--env=test'
        ));

        $this->assertEquals('Operation reussi.', trim($this->commandTester->getDisplay()));
    }
}
