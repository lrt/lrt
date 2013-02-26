<?php

/**
 * @category Testing Repository
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\CMSBundle\Tests\Repository;

use Lrt\SiteBundle\Tests\Controller\LrtWebTestCase;

class ArticleRepositoryTest extends LrtWebTestCase {

    const LIMIT = 5;
    
    /**
     * @test
     * @testdox Recupère la liste des derniers articles avec une limite définie
     * @group art
     */
    public function getLatestArticlesWithLimit() {

        $rpArticle = $this->em->getRepository('CMSBundle:Article')->getLatestArticles(self::LIMIT);
        
        $this->assertNotEmpty($rpArticle);
        $this->assertEquals(self::LIMIT, count($rpArticle));
    }
    
    /**
    * @test
    * @testdox Recupère la liste des articles d'une catégorie
    * @group art
    */
    public function getArticlesByCategoryReturnArray() {

        $rpCategory = $this->em->getRepository('CMSBundle:Category')->findOneBy(array('name' => 'Actualités'));
        
        $result = $this->em->getRepository('CMSBundle:Article')->getArticlesByCategory($rpCategory->getName());
        $this->assertNotNull($result);
        $this->assertTrue(is_array($result));
        $this->assertNotEquals(0, count($result));
    }
    
    /**
    * @test
    * @testdox Recupère la liste des articles d'un utilisateur (auteur)
    * @group art
    */
    public function getArticlesByUserReturnArray() {

        $user = $this->em->getRepository('UserBundle:User')->findOneBy(array('username' => 'alexandre'));

        $result = $this->em->getRepository('CMSBundle:Article')->getArticlesByUser($user);
        $this->assertNotNull($result);
        $this->assertTrue(is_array($result));
        $this->assertNotEquals(0, count($result));
    }

    /**
     * @test
     * @testdox Recupère la liste des articles en attente de validation
     * @group art
     */
    public function getArticlesNotValidatedTest() {

        $result = $this->em->getRepository('CMSBundle:Article')->getArticlesNotValidated();
        $this->assertNotNull($result);
        $this->assertTrue(is_array($result));
        $this->assertNotEquals(0, count($result));
    }
}
