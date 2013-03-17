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

    /**
     * Retourne la liste des nouveaux adhérents
     */
    public function getAdherents()
    {
        return $this->em->getRepository('AdhesionBundle:Adherent')->getAdherents();
    }

    /**
     * Valider une demande d'adhésion
     * @param \Lrt\AdhesionBundle\Entity\Adherent $adherent
     */
    public function validate(Adherent $adherent)
    {
        $adherent->setDateValidation(new \DateTime());
        $adherent->setIsValid(Adherent::IS_ACTIVE);

        $this->em->persist($adherent);
        $this->em->flush();

        $this->mailService->sendMessage($adherent->getEmail(), "Validation de votre adhésion", "Votre demande d'adhésion est validé.");
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

        $this->mailService->sendMessage($adherent->getEmail(), "Rejet de votre demande d'adhésion", "Votre demande d'adhésion a été rejeté.");
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

            $this->mailService->sendMessage($adherent->getEmail(), "Relance demande de validation d'adhésion", "Il manque des informations pour valider votre adhésion.");
            return true;
        }

        return false;
    }

}
