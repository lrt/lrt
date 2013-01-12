<?php

/**
 * @category Testing Repository
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\VideoBundle\Tests\Repository;

use Lrt\SiteBundle\Tests\Controller\LrtWebTestCase;

class VideoRepositoryTest extends LrtWebTestCase {
    
    /**
    * @test
    * @testdox Recupère la liste des vidéos d'un utilisateur (auteur)
    * @group vrt
    */
    public function getVideosByUserReturnArray() {

        $user = $this->em->getRepository('UserBundle:User')->findOneBy(array('username' => 'alexandre'));
        $this->assertNotNull($user);
        
        $rpVideo = $this->em->getRepository('VideoBundle:Video')->getVideosByUser($user);
        $this->assertNotEmpty($rpVideo);
    }
}

