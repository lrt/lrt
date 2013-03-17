<?php

namespace Lrt\CMSBundle\Tests\Repository;

use Lrt\CarmaBundle\Tests\CarmaWebTestCase;

class ActivityRepositoryTest extends CarmaWebTestCase
{

    /**
     * @test
     * @testdox Recupère la liste des vidéos et articles validés
     * @group activity
     */
    public function getArticlesVideosValidated()
    {

        $result = $this->em->getRepository('SiteBundle:Activity')->getArticlesVideos();
                
        $this->assertNotNull($result);
        $this->assertTrue(is_object($result));
        $this->assertNotEquals(0, count($result));
    }

}

