<?php

/**
 * @category Testing Repository
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\CMSBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * User: alex
 * Date: 23/12/12
 */
class ArticleRepositoryTest extends WebTestCase
{

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client;
     */
    protected $client;

    protected function setup()
    {
        $this->client = static::createClient(array('environment' => 'test'));
        $this->em = $this->client->getContainer()->get('doctrine')->getEntityManager();
    }

    /**
     * @test
     * @testdox Recupère la liste des derniers articles avec une limite définie
     * @group art
     */
    public function getLatestArticlesWithLimit()
    {

        $limit = 5;

        $rpArticle = $this->em->getRepository('CMSBundle:Article')->getLatestArticles($limit);

        $this->assertNotEmpty($rpArticle);
    }
}
