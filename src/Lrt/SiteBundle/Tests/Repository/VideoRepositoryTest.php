<?php

/**
 * @category Testing Repository
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\CMSBundle\Tests\Repository;

use Lrt\CarmaBundle\Tests\CarmaWebTestCase;

class VideoRepositoryTest extends CarmaWebTestCase
{
    /**
     * @test
     * @testdox Recupère la liste vidéos non validé
     * @group vrt
     */
    public function getVideosNotValidated() {

        $result = $this->em->getRepository('SiteBundle:Video')->getVideosNotValidated();
        
        $this->assertNotNull($result);
        $this->assertTrue(is_array($result));
        $this->assertNotEquals(0, count($result));
    }
    
    /**
     * @test
     * @testdox Recupère la liste vidéos pour un utilisateur
     * @group vrt
     */
    public function getVideosByUserReturnArray() {
        
        $user = $this->em->getRepository('UserBundle:User')->findOneBy(array('username' => 'julien'));
        $result = $this->em->getRepository('SiteBundle:Video')->getVideosByUser($user);
        
        $this->assertNotNull($result);
        $this->assertTrue(is_array($result));
        $this->assertNotEquals(0, count($result));
    }
}

