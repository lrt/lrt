<?php

namespace Lrt\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\SecurityExtraBundle\Annotation\Secure;

class DefaultController extends Controller
{

    /** @DI\Inject("doctrine.orm.entity_manager") */
    public $em;

    /** @DI\Inject("security.context") */
    private $sc;

    /**
     * @Route("/dashboard", name="dashboard")
     * @Secure(roles="ROLE_ADMIN,ROLE_MEMBER,ROLE_SUPERVISEUR")
     * @Template()
     */
    public function dashboardAction()
    {
        $user = $this->sc->getToken()->getUser();

        if ($user->hasGroup('member')) {

            return $this->redirect($this->generateUrl('user_profile_show', array('id' => $user->getId())));

        } else {
            $articles = $this->em->getRepository('CMSBundle:Article')->findAll();
            $users = $this->em->getRepository('UserBundle:User')->findAll();
            $videos = $this->em->getRepository('VideoBundle:Video')->findAll();

            return array(
                'articles' => $articles,
                'users' => $users,
                'videos' => $videos
            );
        }
    }
}
