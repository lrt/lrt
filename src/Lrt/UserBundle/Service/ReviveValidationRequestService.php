<?php

namespace Lrt\UserBundle\Service;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("lrt.service.revive_validation_request")
 */
class ReviveValidationRequestService
{
    /**
     * nombre de jours avant relance d'une demande
     */
    public $daysBeforeRevive = 7;

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
     * Relance les demandes en attente de validation
     * @param \Datetime $currentDate
     * @return boolean
     */
    public function reviveValidationRequest($currentDate)
    {
        $requests = $this->em->getRepository('UserBundle:User')->getRequestsNotValidated($currentDate);

        if ($requests) {

            foreach ($requests as $adhesion) {

                $dateSubmission = $adhesion->getDateSubmission();
                $interval = $dateSubmission->diff($currentDate, true)->days;

                if ($interval % $this->daysBeforeRevive == 0) {

                    $userAppliant = $adhesion->getUser();

                    if (!is_null($userAppliant)) {

                        //TODO-alex ENVOIE MAIL AUX MEMBRE DU BUREAU + ADHERENT ?
                    }
                }
            }
        }
        return false;
    }
}
