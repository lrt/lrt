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
    * Displays a list adhesion
    *
    * @Route("/", name="adhesion_display")
    * @Secure(roles="ROLE_ADMIN,ROLE_SUPERVISEUR")
    * @Template("UserBundle:Adhesion:index.html.twig")
    */
    public function indexAction()
    {
        $users = $this->em->getRepository('UserBundle:User')->getAdhesion();

        return array('users' => $users,'nb' => count($users));
    }

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
        $form = $this->createForm($userType, $user);

        return array(
            'entity' => $user,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new User entity.
     *
     * @Route("/confirm", name="adhesion_confirm")
     * @Template("UserBundle:Adhesion:confirm.html.twig")
     */
    public function confirmAction()
    {

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
        $form = $this->createForm($this->container->get('users.form.adhesionType'),$user);

        if($request->isXmlHttpRequest()) {
            $form->bind($request);
            if ($form->isValid()) {
                $user->setUsername(strtolower($user->getFirstName().''.$user->getLastName()));

                $user->setPlainPassword("test");
                $encoder = new MessageDigestPasswordEncoder('sha512');
                $password = $encoder->encodePassword('test', $user->getSalt());
                $user->setPassword($password);

                $user->setEnabled(User::IS_NOT_ACTIVE);
                $user->setIsAdhesion(User::IS_NEW_ADHESION);
                $user->setDateSubmission(new \DateTime());

                $this->em->persist($user);
                $this->em->flush();

                $this->mailService->sendMessage("Nouvelle adhésion", "no-reply@longchamp-roller-team.com", "longchamp-roller-team@laposte.net", "Test");

                //$this->get('session')->setFlash('success', 'Un e-mail vous sera envoyez.');
                //return $this->redirect($this->generateUrl('user_adhesion_show', array('id' => $user->getId())));
            }
        }

        return array(
            'entity' => $user,
            'form'   => $form->createView(),
        );
    }

    /**
     * @Route("/{id}/validate", name="user_adhesion_validate", requirements={"id" = "\d+"})
     * @ParamConverter("user", class="UserBundle:User", options={"id" = "id"})
     * @Secure(roles="ROLE_SUPERVISEUR")
     * @Method("GET")
     * @Template("UserBundle:Adhesion:index.html.twig")
     */
    public function validateAction(User $user)
    {
        if($result = $this->em->getRepository('UserBundle:User')->findOneBy(array('isAdhesion' => User::IS_NEW_ADHESION))) {

            $user->setDateValidation(new \DateTime());
            $user->setEnabled(User::IS_ACTIVE);

            $this->get('fos_user.user_manager')->updateUser($user, false);
            $this->em->flush();
            $this->mailService->sendMessage("Validation de votre adhésion", "no-reply@longchamp-roller-team.com", $user->getEmail(), "Votre demande d'adhésion est validé.");

            $this->get('session')->setFlash('success', 'La demande de l\'adhérent a été validé.');
            return $this->redirect($this->generateUrl('adhesion_display'));
        }
        return $this->redirect($this->generateUrl('adhesion_display'));
    }

    /**
     * @Route("/{id}/reject", name="user_adhesion_reject", requirements={"id" = "\d+"})
     * @ParamConverter("user", class="UserBundle:User", options={"id" = "id"})
     * @Secure(roles="ROLE_SUPERVISEUR")
     * @Method("GET")
     * @Template("UserBundle:Adhesion:index.html.twig")
     */
    public function rejectAction(User $user)
    {
        if($result = $this->em->getRepository('UserBundle:User')->findOneBy(array('isAdhesion' => User::IS_NEW_ADHESION))) {

            //UPDATE USER ??

            $this->mailService->sendMessage("Validation de votre adhésion", "no-reply@longchamp-roller-team.com", $user->getEmail(), "Votre demande d'adhésion a été rejeté.");

            $this->get('session')->setFlash('success', 'La demande de l\'adhérent a été rejeté.');
            return $this->redirect($this->generateUrl('adhesion_display'));
        }
        return $this->redirect($this->generateUrl('adhesion_display'));
    }

    /**
     * RELANCER UN ADHERENT
     *
     * @Route("/{id}/revival", name="user_adhesion_validate_revival", requirements={"id" = "\d+"})
     * @ParamConverter("user", class="UserBundle:User", options={"id" = "id"})
     * @Secure(roles="ROLE_SUPERVISEUR")
     * @Method("GET")
     * @Template("UserBundle:Adhesion:index.html.twig")
     */
    public function revivalAction(User $user)
    {
        if($result = $this->em->getRepository('UserBundle:User')->findOneBy(array('isAdhesion' => User::IS_NEW_ADHESION))) {

            $currentDate = new \DateTime();
            $dateSubmission = $user->getDateSubmission();
            $interval = $dateSubmission->diff($currentDate, true)->days;

            if($interval > 0) {
                $user->setDateLastRevival($currentDate);
                $this->get('fos_user.user_manager')->updateUser($user, false);
                $this->em->flush();

                $this->mailService->sendMessage("Valider votre adhésion", "no-reply@longchamp-roller-team.com", $user->getEmail(), "Il manque des informations pour valider votre adhésion.");

                $this->get('session')->setFlash('success', 'Votre message a été envoyé.');
                return $this->redirect($this->generateUrl('adhesion_display'));
            }
            $this->get('session')->setFlash('error', 'Votre demande de relance doit être supérieur à  la date de la demande.');
            return $this->redirect($this->generateUrl('adhesion_display'));
        }
        return $this->redirect($this->generateUrl('adhesion_display'));
    }

    /**
     * Show User entity.
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
