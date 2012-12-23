<?php

/**
 * @category Service
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\NotificationBundle\Service;

use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;
use Lrt\NotificationBundle\Entity\Notification;

/**
 * Service de notification
 * @Service("lrt.service.notification")
 */
class NotificationService
{

    /**
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;

    /**
     * @DI\Inject("lrt.service.mail")
     * @var \Lrt\NotificationBundle\Service\MailService
     */
    public $mailService;

    /**
     * Envoie un mail à tous les utilisateurs
     */
    protected function sendNotificationByMail()
    {
        $this->mailService->sendMessage('Test','demo@gmail.com','demo2@gmail.com','test');
    }
}
