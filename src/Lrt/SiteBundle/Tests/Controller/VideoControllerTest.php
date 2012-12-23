<?php

namespace Lrt\SiteBundle\Tests\Controller;

use Lrt\SiteBundle\Tests\Controller\LrtWebTestCase;

/**
 * @category Testing
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */
class VideoControllerTest extends LrtWebTestCase
{

    /**
     * @test
     * @testdox Modifier une video via un id qui n'existe pas
     * @group video
     */
    public function editInvalidVideo()
    {
        $client = static::createClient();
        $client->request('GET', '/video/99999999/edit');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @testdox La video que l'on veut afficher n'existe pas alors on retourne 404.
     * @group article
     */
    public function showWithUnknownVideoReturns404()
    {
        $client = static::createClient();
        $client->request('GET', '/video/99999999/show');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
