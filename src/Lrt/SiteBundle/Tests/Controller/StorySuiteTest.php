<?php

namespace Grdf\CarmaBundle\Tests\Controller;

use Lrt\SiteBundle\Tests\Controller\LrtWebTestCase;

class StorySuiteTest extends LrtWebTestCase
{

    /**
     * @test
     * @group stories
     */
    public function behatIsOk()
    {
        $this->scenariosMeetAcceptanceCriteria('SiteBundle');
    }

}
