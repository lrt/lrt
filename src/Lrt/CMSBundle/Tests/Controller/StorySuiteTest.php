<?php

/**
 * @category Testing Controller
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\CMSBundle\Tests\Controller;

use Lrt\SiteBundle\Tests\Controller\LrtWebTestCase;

class StorySuiteTest extends LrtWebTestCase
{

    /**
     * @test
     * @group stories
     */
    public function behatIsOk()
    {
        $this->scenariosMeetAcceptanceCriteria('CMSBundle');
    }
}
