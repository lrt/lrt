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
use JMS\DiExtraBundle\Annotation\Service;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JMS\DiExtraBundle\Annotation as DI;
use Lrt\UserBundle\Entity\User;
use Lrt\UserBundle\Form\UserType;

/**
 * Profile controller.
 *
 * @Route("/profil")
 */
class ProfileController extends Controller
{

    /** @DI\Inject("doctrine.orm.entity_manager") */
    public $em;

    /**
     * @Route("/{id}", name="user_profile_show")
     * @ParamConverter("user", class="UserBundle:User", options={"id" = "id"})
     * @Template()
     */
    public function myProfileAction(User $user)
    {
        return $this->render('UserBundle:Profile:myProfile.html.twig', array('profile' => $user));
    }

    /**
     * @Route("/edit/{id}", name="user_profile_edit")
     * @ParamConverter("user", class="UserBundle:User", options={"id" = "id"})
     * @Template()
     */
    public function editAction(User $user)
    {
        $form = $this->createForm($this->container->get('users.form.userType'), $user);
        $change_pass_form = $this->createForm($this->container->get('users.form.userChangePasswordType'), new \FOS\UserBundle\Form\Model\ChangePassword());

        return $this->render('UserBundle:Profile:edit.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
            'form_pass' => $change_pass_form->createView()
        ));
    }
}
