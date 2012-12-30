<?php

namespace Lrt\NotificationBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Lrt\NotificationBundle\Service\MailService;

/**
 * @category Testing Service
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */
class MailServiceTest extends WebTestCase
{

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client;
     */
    protected $client;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    protected function setup()
    {
        $this->client = static::createClient(array('environment' => 'test'));
        $this->em = $this->client->getContainer()->get('doctrine')->getEntityManager();
        $this->mailer = $this->client->getContainer()->get('mailer');
    }

    /**
     * @test
     * @testdox Envoie d'un message de notification
     * @group mail
     */
    public function sendMessageIsOk()
    {

        $mailService = new MailService();
        $mailService->mailService = $this->mailer;

        $sender = $this->em->getRepository('UserBundle:User')->findOneBy(array('username' => 'alexandre'));
        $this->assertNotNull($sender);

        $result = $mailService->sendMessage('Test Message', $sender->getEmail(), 'webmaster@longchamp-roller-team.com', 'Message de Test');
        $this->assertNotNull($result);
    }

    /**
     * @test
     * @testdox Envoie d'un message de notification sans expéditeur
     * @group mail
     */
    public function sendMessageWithKnownReceiver()
    {

        $mailService = new MailService();
        $mailService->mailService = $this->mailer;

        $result = $mailService->sendMessage('Test Message', null, 'webmaster@longchamp-roller-team.com', 'Message de Test');
        $this->assertNotNull($result);
    }
}
