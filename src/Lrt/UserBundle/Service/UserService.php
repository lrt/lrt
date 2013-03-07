<?php

namespace Lrt\UserBundle\Service;

use JMS\DiExtraBundle\Annotation as DI;
use Lrt\UserBundle\Entity\User;

/**
 * @DI\Service("lrt.service.user")
 */
class UserService
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
     * Activé un compte utilisateur
     * @param \Lrt\UserBundle\Entity\User $user
     */
    public function enabled(User $user)
    {
        $user->setEnabled(User::IS_ACTIVE);

        $this->em->persist($user);
        $this->em->flush();
        
        $this->mailService->sendMessage($user->getEmail(), "Compte activé", "Votre compte vient d'être activé par un administrateur.");
    }
    
    public function enabledOff(User $user)
    {
        $user->setEnabled(User::IS_NOT_ACTIVE);
        
        $this->em->persist($user);
        $this->em->flush();
        
        $this->mailService->sendMessage($user->getEmail(), "Compte désactivé", "Votre compte vient d'être désactivé par un administrateur.");
    }

}

