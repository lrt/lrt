<?php

namespace Lrt\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;
use Lrt\UserBundle\Entity\User;
use Lrt\UserBundle\Form\UserType;

/**
 * Profile controller.
 *
 * @Route("/profile")
 */
class ProfileController extends Controller
{

    /** @DI\Inject("doctrine.orm.entity_manager") */
    public $em;

    /**
     * @Route("/myprofile/{id}", name="user_profile")
     * @Template()
     */
    public function myProfileAction($id)
    {
        $user = $this->em->getRepository('UserBundle:User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        return $this->render('UserBundle:Profile:myProfile.html.twig');
    }
}
