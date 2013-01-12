<?php

namespace Lrt\UserBundle\Tests\Controller;

use Lrt\SiteBundle\Tests\Controller\LrtWebTestCase;

/**
 * @category Testing
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */
class UserControllerTest extends LrtWebTestCase
{
    /**
     * @test
     * @group user
     */
    public function testCompleteScenario()
    {
        $this->login($this->client, array('user' => 'alexandre'));

        $crawler = $this->client->request('GET', '/user/');
        $this->assertTrue(200 === $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->click($crawler->selectLink('Créer un nouvel utilisateur')->link());

        $form = $crawler->selectButton('Valider')->form(array(
            'lrt_userbundle_usertype[username]' => 'Test',
            'lrt_userbundle_usertype[email]' => 'test@longchamp-roller-team.com',
            'lrt_userbundle_usertype[plainPassword][first]' => 'c##15KLmdf',
            'lrt_userbundle_usertype[plainPassword][second]' => 'c##15KLmdf',
            'lrt_userbundle_usertype[lastName]' => 'Test',
            'lrt_userbundle_usertype[firstName]' => 'Test',
        ));

        $crawler = $this->client->submit($form);

        // Check data in the show view
        $this->assertTrue($crawler->filter('td:contains("Test")')->count() > 0);

        // Edit the entity
        $crawler = $this->client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Modifier')->form(array(
            'lrt_userbundle_usertype[lastName]' => 'Test - modifié',
            'lrt_userbundle_usertype[plainPassword][first]' => 'c##15KLmdf',
            'lrt_userbundle_usertype[plainPassword][second]' => 'c##15KLmdf',
        ));

        $crawler = $this->client->submit($form);

        $userRepository = $this->em->getRepository('UserBundle:User');
        $user = $userRepository->findOneBy(array('lastName' => 'Test - modifié'));

        $this->assertNotEmpty($user);
    }
}
