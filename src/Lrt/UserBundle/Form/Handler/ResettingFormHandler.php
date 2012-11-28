<?php

namespace Lrt\UserBundle\Form\Handler;

use FOS\UserBundle\Form\Handler\ResettingFormHandler as BaseHandler;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class ResettingFormHandler extends BaseHandler 
{
    protected function onSuccess(UserInterface $user)
    {
        $this->userManager->updateUser($user);
    }
}
