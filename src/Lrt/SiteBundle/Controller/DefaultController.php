<?php

/**
 * @category Controller
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;
use Lrt\SiteBundle\Form\Type\EnquiryType;
use Lrt\SiteBundle\Entity\Enquiry;

class DefaultController extends Controller
{
    /**
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;

    /**
     * @DI\Inject("lrt.service.mail")
     * @var \Lrt\NotificationBundle\Service\MailService
     */
    public $mailService;

    /**
     * @DI\Inject("knp_paginator")
     */
    public $paginator;

    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
        $articles = $this->em->getRepository('CMSBundle:Article')->getLatestArticles(5);

        return array('articles' => $articles);
    }

    /**
     * @Route("/blog", name="blog")
     * @Template("SiteBundle:Default:blog.html.twig")
     */
    public function blogAction(Request $request)
    {
        $articles = $this->em->getRepository('CMSBundle:Article')->findAll();

        $page = $request->query->get('page', 1);
        $pagination = $this->paginator->paginate(
            $articles,$page,$this->container->getParameter('knp_limit_per_page')
        );
        $arrayPagination = compact('pagination');

        return array('articles' => $arrayPagination['pagination']);
    }

    /**
     * @Route("/information/{page}", name="show_page")
     * @Cache(smaxage="600")
     * @Template()
     */
    public function showAction($page)
    {
        $template = sprintf("SiteBundle:Page:%s.html.twig", $page);

        try {
            $response = $this->render($template);
            return $response;
        } catch (\Exception $e) {
            return new Response("Aucune page ne correspond à votre demande.", 404);
        }
    }

    /**
     * @Route("/contact", name="contact")
     * @Template("SiteBundle:Page:contact.html.twig")
     * @Method({"GET", "POST"})
     */
    public function contactActon(Request $request)
    {
        $enquiry = new Enquiry();
        $form = $this->createForm($this->container->get('form.site.contact.type'), $enquiry);

        if($request->isXmlHttpRequest()) {
            $form->bind($request);
            if ($form->isValid()) {
                $this->mailService->sendMessage($enquiry->getSubject(), $enquiry->getEmail(), "alexandre.seiller92@gmail.com", $enquiry->getBody());
            }
        }

        return $this->render('SiteBundle:Page:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
