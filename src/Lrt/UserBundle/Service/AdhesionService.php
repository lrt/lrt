<?php

namespace Lrt\UserBundle\Service;

use JMS\DiExtraBundle\Annotation as DI;
use Lrt\UserBundle\Entity\User;

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
     * @DI\Inject("lrt.service.mail")
     * @var \Lrt\NotificationBundle\Service\MailService
     */
    public $mailService;

    /**
     * Retourne la liste des nouveaux adhérents
     */
    public function getAdherents()
    {
        return $this->em->getRepository('UserBundle:User')->getAdhesion();
    }

    /**
     * Valider une demande d'adhésion
     * @param \Lrt\UserBundle\Entity\User $user
     */
    public function validate(User $user)
    {
        $user->setDateValidation(new \DateTime());
        $user->setEnabled(User::IS_ACTIVE);

        $this->em->persist($user);
        $this->em->flush();

        $this->mailService->sendMessage("Validation de votre adhésion", "no-reply@longchamp-roller-team.com", $user->getEmail(), "Votre demande d'adhésion est validé.");
    }

    /**
     * Rejeter une demande d'adhésion
     * @param \Lrt\UserBundle\Entity\User $user
     */
    public function reject(User $user)
    {
        $user->setDateValidation(new \DateTime());
        $user->setEnabled(User::IS_REJECT_ADHESION);

        $this->em->persist($user);
        $this->em->flush();

        $this->mailService->sendMessage("Rejet de votre demande d'adhésion", "no-reply@longchamp-roller-team.com", $user->getEmail(), "Votre demande d'adhésion a été rejeté.");
    }

    /**
     * Relancer une demande d'adhésion
     * @param \Lrt\UserBundle\Entity\User $user
     */
    public function revival(User $user)
    {
        $currentDate = new \DateTime();
        $dateSubmission = $user->getDateSubmission();
        $interval = $dateSubmission->diff($currentDate, true)->days;

        if ($interval > 0) {
            $user->setDateLastRevival($currentDate);
            $this->em->persist($user);
            $this->em->flush();

            $this->mailService->sendMessage("Valider votre adhésion", "no-reply@longchamp-roller-team.com", $user->getEmail(), "Il manque des informations pour valider votre adhésion.");
        }
    }
}
