<?php

namespace Lrt\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\DiExtraBundle\Annotation as DI;
use Lrt\UserBundle\Entity\User;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Adhesion controller.
 *
 * @Route("/adhesion")
 */
class AdhesionController extends Controller
{
    /** @DI\Inject("doctrine.orm.entity_manager") */
    public $em;

    /**
     * Displays a form to create a new User entity.
     *
     * @Route("/new", name="adhesion_new")
     * @Template()
     */
    public function newAction()
    {
        $user = new User();

        $userType = $this->container->get('users.form.adhesionType');
        $form   = $this->createForm($userType, $user);

        return array(
            'entity' => $user,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Adhesion.
     *
     * @Route("/create", name="adhesion_create")
     * @Method("POST")
     * @Template("UserBundle:Adhesion:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $user  = new User();

        $userType = $this->container->get('users.form.adhesionType');
        $form = $this->createForm($userType,$user);
        $form->bind($request);

        if ($form->isValid()) {

            $this->em->persist($user);
            $this->em->flush();

            return $this->redirect($this->generateUrl('user_show', array('id' => $user->getId())));
        }

        return array(
            'entity' => $user,
            'form'   => $form->createView(),
        );
    }
}
