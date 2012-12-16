<?php

namespace Lrt\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\DiExtraBundle\Annotation as DI;

class DefaultController extends Controller
{
    /**
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;

    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
        $articles = $this->em->getRepository('SiteBundle:Article')->getLatestArticles(5);

        return array('articles' => $articles);
    }
}
