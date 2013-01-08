<?php

/**
 * @category Testing Controller
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\VideoBundle\Tests\Controller;

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
            '--out' => 'build/logs/features/VideoBundle/,build/logs/features/VideoBundle/index.html',
            'features' => '@VideoBundle'
        ));
        $output = new ConsoleOutput();
        $app = new BehatApplication('DEV');
        $app->setAutoExit(false);
        $result = $app->run($input, $output);
        $this->assertEquals(0, $result, 'Au moins un des scénarios Behat ne passe pas dans VideoBundle, pour plus d\'info allez dans build/logs/features/VideoBundle/ !');
    }

}
