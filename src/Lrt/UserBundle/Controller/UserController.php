<?php

/**
 * @category Controller
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Lrt\UserBundle\Entity\User;
use Lrt\UserBundle\Form\UserType;

class UserController extends Controller
{
    /** @DI\Inject("doctrine.orm.entity_manager") */
    public $em;

    /**
     * Lists all User entities.
     *
     * @Route("/", name="user")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm($this->container->get('users.form.userFilterType'), array());
        $form->bind($request);
        $data = $form->getData();

        if($form->isValid()) {

            $users = $this->em->getRepository('UserBundle:User')->filter($data['login'], $data['nom'], $data['type'], $data['email'], $data['status']);

            return array('entities' => $users,'form' => $form->createView(),'nb' => count($users));

        } else {
            return $this->redirect($this->generateUrl('user'));
        }
    }

    /**
     * @Route("/export", name="export_user")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function exportAction()
    {
        $exportUsers = $this->container->get('service.export_users');
        $csvReadyUsers = $exportUsers->generateCsvReadyDatas();

        if(!is_object($csvReadyUsers)) {
            return $this->get('session')->setFlash('error', 'Impossible d\'exporter la liste des utilisateurs');
        } else {
            return $csvReadyUsers;
        }
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}/show", name="user_show", requirements={"id" = "\d+"})
     * @ParamConverter("user", class="UserBundle:User", options={"id" = "id"})
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function showAction(User $user)
    {
        return array(
            'entity' => $user,
        );
    }

    /**
     * Displays a form to create a new User entity.
     *
     * @Route("/new", name="user_new")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function newAction()
    {
        $user = new User();

        $userType = $this->container->get('users.form.userRegisterType');
        $form   = $this->createForm($userType, $user);

        return array(
            'entity' => $user,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new User entity.
     *
     * @Route("/create", name="user_create")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("POST")
     * @Template("UserBundle:User:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $user  = new User();
        $form = $this->createForm(new UserType(), $user);
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

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="user_edit", requirements={"id" = "\d+"})
     * @ParamConverter("user", class="UserBundle:User", options={"id" = "id"})
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function editAction(User $user)
    {
        $editForm = $this->createForm(new UserType(), $user);

        return array(
            'entity'    => $user,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}/update", name="user_update", requirements={"id" = "\d+"})
     * @ParamConverter("user", class="UserBundle:User", options={"id" = "id"})
     * @Secure(roles="ROLE_ADMIN")
     * @Method("POST")
     * @Template("UserBundle:User:edit.html.twig")
     */
    public function updateAction(Request $request, User $user)
    {
        $editForm = $this->createForm(new UserType(), $user);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->em->persist($user);
            $this->em->flush();

            return $this->redirect($this->generateUrl('user_edit', array('id' => $user->getId())));
        }

        return array(
            'entity'      => $user,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * @Route("/{id}/activate", name="activate_user")
     * @ParamConverter("user", class="UserBundle:User", options={"id" = "id"})
     * @Secure(roles="ROLE_ADMIN")
     * @Method("GET")
     * @Template("UserBundle:User:index.html.twig")
     */
    public function enabledAction(User $user)
    {
        $user->setEnabled(1);

        $this->get('fos_user.user_manager')->updateUser($user, false);

        $this->em->flush();

        $this->get('session')->setFlash('success', 'Le compte est activé.');
        return $this->redirect($this->generateUrl('user'));
    }

    /**
     * @Route("/{id}/deactivate", name="deactivate_user")
     * @ParamConverter("user", class="UserBundle:User", options={"id" = "id"})
     * @Secure(roles="ROLE_ADMIN")
     * @Method("GET")
     * @Template("UserBundle:User:index.html.twig")
     */
    public function enabledOffAction(User $user)
    {
        $user->setEnabled(0);

        $this->get('fos_user.user_manager')->updateUser($user, false);

        $this->em->flush();

        $this->get('session')->setFlash('success', 'Le compte est désactivé.');
        return $this->redirect($this->generateUrl('user'));
    }

}
