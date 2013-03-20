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

    /**
     * @DI\Inject("carma.service.mail")
     * @var \Lrt\CarmaBundle\Service\MailService
     */
    public $mailService;

    /**
     * @Route("/subscribe", name="newsletter_subscribe")
     * @Template("SiteBundle:Newsletter:new.html.twig")
     * @Method({"GET", "POST"})
     */
    public function subscribeAction(Request $request)
    {
        $newsletter = new Newsletter();
        $form = $this->createForm($this->container->get('form.site.newsletter.type'), $newsletter);

        if ($request->isXmlHttpRequest()) {
            $form->bind($request);
            $findEmail = $this->em->getRepository("SiteBundle:Newsletter")->findOneBy(array('email' => $newsletter->getEmail()));
            if (!$findEmail) {
                $newsletter->setEmail($newsletter->getEmail());
                $this->em->persist($newsletter);
                $this->em->flush();

                $this->mailService->sendMessage("Newsletter", "no-reply@longchamp-roller-team.com", "longchamp-roller-team@laposte.net", "Test");
            }
        }
        return array(
            'newsletter' => $newsletter,
            'form_newsletter' => $form->createView(),
        );
    }

}
