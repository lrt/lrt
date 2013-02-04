<?php

namespace Lrt\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
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
    /**
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;

    /** @DI\Inject("lrt.service.mail")
     *  @var \Lrt\NotificationBundle\Service\MailService
     */
    public $mailService;

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

            $user->setUsername(strtolower($user->getFirstName().''.$user->getLastName()));

            $user->setPlainPassword("test");
            $encoder = new MessageDigestPasswordEncoder('sha512');
            $password = $encoder->encodePassword('test', $user->getSalt());
            $user->setPassword($password);

            $user->setEnabled(0);
            $user->setDateValidation(new \DateTime());

            $this->em->persist($user);
            $this->em->flush();

            $this->mailService->sendMessage("Nouvelle adhésion", "no-reply@longchamp-roller-team.com", "longchamp-roller-team@laposte.net", "Test");

            $this->get('session')->setFlash('success', 'Un e-mail vous sera envoyez.');
            return $this->redirect($this->generateUrl('user_adhesion_show', array('id' => $user->getId())));
        }

        return array(
            'entity' => $user,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}/show", name="user_adhesion_show", requirements={"id" = "\d+"})
     * @ParamConverter("user", class="UserBundle:User", options={"id" = "id"})
     * @Template()
     */
    public function showAction(User $user)
    {
        return array(
            'user' => $user,
        );
    }
}
