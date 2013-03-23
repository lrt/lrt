<?php

namespace Lrt\AdhesionBundle\Service;

use JMS\DiExtraBundle\Annotation as DI;
use Lrt\AdhesionBundle\Entity\Adherent;

/**
 * @DI\Service("lrt.service.adhesion")
 */
class AdhesionService
{

    /**
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;

    /**
     * @DI\Inject("carma.service.mail")
     * @var \Lrt\CarmaBundle\Service\MailService
     */
    public $mailService;

    /** @DI\Inject("service_container") */
    public $container;

    /** @DI\Inject("translator") */
    public $tr;

    /**
     * Retourne la liste des nouveaux adhérents
     */
    public function getAdherents()
    {
        return $this->em->getRepository('AdhesionBundle:Adherent')->getAdherents();
    }

    /**
     * Nouvelle une demande d'adhésion
     * @param \Lrt\AdhesionBundle\Entity\Adherent $adherent
     */
    public function newAdhesion(Adherent $adherent)
    {
        $adherent->setIsValid(Adherent::IS_NOT_ACTIVE);
        $adherent->setDateSubmission(new \DateTime());

        $this->em->persist($adherent);
        $this->em->flush();

        $messageAdherent = $this->tr->trans('adhesion.email.new.message', array(
            '%username%' => $adherent->getFullName(),
            '%numAdhesion%' => $adherent->getMatricule()));

        $messageAdmin = $this->tr->trans('adhesion.email.new.admin.message', array(
            '%username%' => $adherent->getFullName(),
            '%numAdhesion%' => $adherent->getMatricule()));

        //Send to adherent
        $this->mailService->sendMessage(
                $adherent->getEmail(),
                $this->tr->trans('adhesion.email.new.subject'),
                $messageAdherent);

        //Send to LRT
        $this->mailService->sendMessage(
                $this->container->getParameter('mailer_sender_address'),
                $this->tr->trans('adhesion.email.new.admin.subject'),
                $messageAdmin);

        return $adherent;
    }

    /**
     * Valider une demande d'adhésion
     * @param \Lrt\AdhesionBundle\Entity\Adherent $adherent
     */
    public function validate(Adherent $adherent)
    {
        $adherent->setDateValidation(new \DateTime());
        $adherent->setIsValid(Adherent::IS_ACTIVE);

        /* $user->setUsername(strtolower($user->getFirstName() . '' . $user->getLastName()));
          $user->setPlainPassword("test");
          $encoder = new MessageDigestPasswordEncoder('sha512');
          $password = $encoder->encodePassword('test', $user->getSalt());
          $user->setPassword($password); */

        $message = $this->tr->trans('adhesion.email.accept.message', array(
            '%username%' => $adherent->getFullName(),
            '%dateDebutAdhesion%' => $this->container->getParameter('app.adhesion.debut'),
            '%dateFinAdhesion%' => $this->container->getParameter('app.adhesion.fin')
        ));

        $this->em->persist($adherent);
        $this->em->flush();

        $this->mailService->sendMessage(
            $adherent->getEmail(),
            $this->tr->trans('adhesion.email.accept.subject'),
            $message);

        return $adherent;
    }

    /**
     * Rejeter une demande d'adhésion
     * @param \Lrt\AdhesionBundle\Entity\Adherent $user
     */
    public function reject(Adherent $adherent)
    {
        $adherent->setDateValidation(new \DateTime());
        $adherent->setIsValid(Adherent::IS_REJECT);

        $this->em->persist($adherent);
        $this->em->flush();

        $message = $this->tr->trans('adhesion.email.reject.message', array(
            '%username%' => $adherent->getFullName(),
        ));

        $this->mailService->sendMessage(
            $adherent->getEmail(),
            $this->tr->trans('adhesion.email.reject.subject'),
            $message
        );

        return $adherent;
    }

    /**
     * Relancer une demande d'adhésion
     * @param \Lrt\AdhesionBundle\Entity\Adherent $user
     */
    public function revival(Adherent $adherent)
    {
        $currentDate = new \DateTime();
        $dateSubmission = $adherent->getDateSubmission();
        $interval = $dateSubmission->diff($currentDate, true)->days;

        if ($interval > 0) {
            $adherent->setDateLastRevival($currentDate);
            $this->em->persist($adherent);
            $this->em->flush();

            $message = $this->tr->trans('adhesion.email.revival.message', array(
                '%username%' => $adherent->getFullName(),
            ));

            $this->mailService->sendMessage(
                    $adherent->getEmail(),
                    $this->tr->trans('adhesion.email.revival.subject'), $message);

            return true;
        }

        return false;
    }

}
