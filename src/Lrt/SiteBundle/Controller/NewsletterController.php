<?php

namespace Lrt\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;
use Lrt\SiteBundle\Entity\Newsletter;

class NewsletterController extends Controller
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
     * @Template("SiteBundle:Newsletter:new.html.twig")
     */
    public function newAction()
    {
        $newsletter = new Newsletter();
        $form = $this->createForm($this->container->get('form.site.newsletter.type'), $newsletter);

        return array(
            'newsletter' => $newsletter,
            'form_newsletter' => $form->createView(),
        );
    }

    /**
     * @Route("/subscribe", name="newsletter_subscribe")
     * @Method("POST")
     */
    public function subscribeAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {

            $email = $request->request->get('email');
            $findEmail = $this->em->getRepository("SiteBundle:Newsletter")->findOneBy(array('email' => $email));

            if(!$findEmail) {
                $newsletter = new Newsletter();
                $newsletter->setEmail($email);
                $this->em->persist($newsletter);
                $this->em->flush();

                $this->mailService->sendMessage("Newsletter", "no-reply@longchamp-roller-team.com", "longchamp-roller-team@laposte.net", "Test");
            }
        }
        return false;
    }
}
