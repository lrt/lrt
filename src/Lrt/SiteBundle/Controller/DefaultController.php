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
use Lrt\SiteBundle\Entity\Enquiry;

class DefaultController extends Controller
{

    /**
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;

    /** @DI\Inject("mailer") */
    public $mailer;

    /**
     * @DI\Inject("carma.service.mail")
     * @var \Lrt\CarmaBundle\Service\MailService
     */
    public $mailService;

    /**
     * @DI\Inject("knp_paginator")
     */
    public $paginator;
    
    /** @DI\Inject("translator") */
    public $tr;

    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
        $articles = $this->em->getRepository('CMSBundle:Article')->getLatestArticles(5);
        $videos = $this->em->getRepository('SiteBundle:Video')->getLatestVideos(4);

        return array('articles' => $articles, 'videos' => $videos);
    }

    /**
     * @Route("/dashboard", name="dashboard")
     * @Template("SiteBundle:Admin:dashboard.html.twig")
     */
    public function dashboardAction()
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
        $activities = $this->em->getRepository('SiteBundle:Activity')->getArticlesVideos();
        $categories = $this->em->getRepository('CMSBundle:Category')->findAll();

        $page = $request->query->get('page', 1);
        $pagination = $this->paginator->paginate(
                $activities, $page, $this->container->getParameter('knp_limit_per_page')
        );
        $arrayPagination = compact('pagination');

        return array('activities' => $arrayPagination['pagination'], 'categories' => $categories);
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
     * @Route("/evenement/{page}", name="show_event_page")
     * @Cache(smaxage="600")
     * @Template()
     */
    public function showPageEventAction($page)
    {
        $template = sprintf("SiteBundle:PageEvent:%s.html.twig", $page);

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
     */
    public function contactActon(Request $request)
    {
        $enquiry = new Enquiry();
        $form = $this->createForm($this->container->get('form.site.contact.type'), $enquiry);

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $this->sendMessage($enquiry->getEmail(), $enquiry->getSubject(), $enquiry->getBody());
                $this->get('session')->getFlashBag()->add('success', 'Votre message a été envoyé.');
                return $this->redirect($this->generateUrl('contact'));
            }
        }

        return $this->render('SiteBundle:Page:contact.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    private function sendMessage($from, $subject, $body)
    {
        $mail = \Swift_Message::newInstance();
        $mail
                ->setFrom($from)
                ->setTo(array($this->container->getParameter('mailer_sender_address') => $this->container->getParameter('mailer_sender_name')))
                ->setSubject($subject)
                ->setBody($body)
                ->setContentType('text/html');
        $failures = null;
        $this->mailer->send($mail, $failures);
    }

    /**
     * @Route("/inscription-competition-muette-2013", name="competition_muette")
     * @Template("SiteBundle:PageEvent:competition-muette.html.twig")
     */
    public function competitionMuetteAction(Request $request)
    {
        $form = $this->createFormBuilder()
                ->add('licence', 'text', array('required' => false, 'label' => 'N°licence', 'attr' => array('class' => 'span4', 'placeholder' => 'facultatif')))
                ->add('firstName', 'text', array('label' => 'Prénom', 'attr' => array('class' => 'span4', 'placeholder' => 'Prénom')))
                ->add('lastName', 'text', array('label' => 'Nom', 'attr' => array('class' => 'span4', 'placeholder' => 'Nom')))
                ->add('birthday', 'genemu_jquerydate', array(
                    'widget' => 'single_text',
                    'label' => 'Date de naissance* ',
                    'format' => 'dd/MM/yyyy',
                    'attr' => array('class' => 'datepicker')
                ))
                ->add('address', 'text', array('label' => 'Adresse*', 'attr' => array('class' => 'span8')))
                ->add('city', 'text', array(
                    'label' => 'Nom',
                    'attr' => array('class' => 'span4', 'placeholder' => 'Ville')))
                ->add('zipCode', 'text', array(
                    'label' => 'Nom',
                    'max_length' => '5',
                    'attr' => array('class' => 'span4', 'placeholder' => 'Code Postal')))
                ->add('gender', 'choice', array(
                    'label' => 'Sexe*',
                    'empty_value' => 'Je suis un/une ...',
                    'choices' => array('f' => 'Femme', 'm' => 'Homme'),
                    'required' => false,
                    'attr' => array('class' => 'span8')
                ))
                ->add('phone', 'text', array(
                    'label' => 'Numéro de téléphone mobile*',
                    'max_length' => '10',
                    'attr' => array('class' => 'span8')))
                ->add('email', 'email', array(
                    'label' => 'Votre adresse e-mail actuelle*',
                    'attr' => array('class' => 'span8')))
                ->getForm();

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                
                $competiteur = $form->getData();
                
                $fullName = $competiteur['firstName'].' '.$competiteur['lastName'];
                $infosCompetiteur = $this->getInfos($competiteur);

                $messageCompetiteur = $this->tr->trans('inscription.email.new.message', array(
                    '%username%' => $fullName,
                    '%data%' => $infosCompetiteur));

                $messageAdmin = $this->tr->trans('inscription.email.new.admin.message', array(
                    '%username%' => $fullName,
                    '%data%' => $infosCompetiteur));
                
                //Send to adherent
                $this->mailService->sendMessage(
                        $competiteur['email'],
                        $this->tr->trans('inscription.email.new.subject'),
                        $messageCompetiteur);

                //Send to LRT
                $this->mailService->sendMessage(
                        $this->container->getParameter('mailer_sender_address'),
                        $this->tr->trans('inscription.email.new.admin.subject'),
                        $messageAdmin);
                
                $this->get('session')->getFlashBag()->add('success', 'Votre inscription a bien été prise en compte. A bientot');
                return $this->redirect($this->generateUrl('show_page', array('page' => 'challenge-idf-competition-muette-2013')));
            }
        }

        return array('form' => $form->createView());
    }

    private function getInfos(array $competitor)
    {
        $fullName = $competitor['lastName'].' '.$competitor['firstName'];

        if($competitor['gender'] == 'm') {
            $string  = "<p>Monsieur ".$fullName."</p><br/>";
        } else {
            $string  = "<p>Madame ".$fullName."</p><br/>";
        }

        $string .= "
                    <p>Numéro de licence :".$competitor['licence']."</p><br/>
                    <p>Date de naissance :".$competitor['birthday']->format('d/m/Y')."</p><br/>
                    <p>Adresse :".$competitor['address'].' '.$competitor['zipCode'].' '.$competitor['city']. "</p><br/>
                    <p>Téléphone :".$competitor['phone']."</p><br/>
                    <p>Email : ".$competitor['email']."</p><br/>
                  ";

        return $string;
    }

}
