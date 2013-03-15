<?php

namespace Lrt\CarmaBundle\Service;

use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Service permettant d'envoyer des mails
 * Exemple d'utilisation :
 *      $this->mail->sendMessage($to, $subject, $body);
 *
 * @Service("carma.service.mail", public=true)
 */
class MailService
{

    /** @DI\Inject("service_container") */
    public $container;

    /** @DI\Inject("mailer") */
    public $mailer;

    /**
     * Retourne l'adresse utilisee pour l'envoi de mail
     *
     * @return string
     */
    public function getSenderAddress()
    {
        return $this->container->getParameter('mailer_sender_address');
    }

    /**
     * Retourne le nom utilise pour l'envoi de mail
     *
     * @return string
     */
    public function getSenderName()
    {
        return $this->container->getParameter('mailer_sender_name');
    }
    
    /**
     * Envoi de mail
     *
     * @param string $to
     * @param string $subject
     * @param Twig $body
     * @param boolean $cli
     * @return array
     */
    public function sendMessage($to, $subject, $body, $cli = false)
    {
        $mail = \Swift_Message::newInstance();
        $mail
                ->setFrom(array($this->getSenderAddress() => $this->getSenderName()))
                ->setTo($to)
                ->setSubject($subject)
                ->setBody($body)
                ->setContentType('text/html');
        $failures = null;
        $this->mailer->send($mail, $failures);
        //Flush manuel pour un envoi en mode cli
        if ($cli) {
            $transport = $this->mailer->getTransport();
            if ($transport instanceof \Swift_Transport_SpoolTransport) {
                $spool = $transport->getSpool();
                $spool->flushQueue($this->container->get('swiftmailer.transport.real'));
            }
        }
        //Retour
        return $failures;
    }

}
