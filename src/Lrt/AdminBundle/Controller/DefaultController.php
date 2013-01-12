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

    /**
     * @Route("/dashboard", name="dashboard")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function dashboardAction()
    {
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
