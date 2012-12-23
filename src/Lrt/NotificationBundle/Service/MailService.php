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

/**
 * @Service("lrt.service.mail")
 */
class MailService
{

    /**
     * @DI\Inject("mailer")
     */
    public $mailer;

    public function sendMessage($subject, $sender, $receiver, $body)
    {
        if (!is_object($this->mailer)) {
            new \Exception('Mailer has not been injected !');
            return false;
        }

        if ($sender != null) {

            $mail = \Swift_Message::newInstance();

            $mail

                ->setFrom($sender)
                ->setTo($receiver)
                ->setSubject($subject)
                ->setBody($body)
                ->setContentType('text/html');


            $this->mailer->send($mail);

            return true;
        }
        return false;
    }

}

?>
