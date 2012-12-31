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
        // Create a new client to browse the application
        $client = static::createClient();

        $this->login($client, array('user' => 'alexandre'));

        // Create a new entry in the database
        $crawler = $client->request('GET', '/user/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Créer un nouvel utilisateur')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Valider')->form(array(
            'lrt_userbundle_usertype[username]' => 'Test',
            'lrt_userbundle_usertype[email]' => 'test@longchamp-roller-team.com',
            'lrt_userbundle_usertype[plainPassword][first]' => 'c##15KLmdf',
            'lrt_userbundle_usertype[plainPassword][second]' => 'c##15KLmdf',
            'lrt_userbundle_usertype[lastName]' => 'Test',
            'lrt_userbundle_usertype[firstName]' => 'Test',
        ));

        $crawler = $client->submit($form);

        // Check data in the show view
        $this->assertTrue($crawler->filter('td:contains("Test")')->count() > 0);

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Modifier')->form(array(
            'lrt_userbundle_usertype[lastName]' => 'Test - modifié',
            'lrt_userbundle_usertype[plainPassword][first]' => 'c##15KLmdf',
            'lrt_userbundle_usertype[plainPassword][second]' => 'c##15KLmdf',
        ));

        $crawler = $client->submit($form);

        $this->em = $client->getContainer()->get('doctrine')->getEntityManager();
        $userRepository = $this->em->getRepository('UserBundle:User');
        $user = $userRepository->findOneBy(array('lastName' => 'Test - modifié'));

        $this->assertNotEmpty($user);
    }
}
