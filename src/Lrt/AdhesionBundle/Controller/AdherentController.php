<?php

namespace Lrt\AdhesionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use JMS\DiExtraBundle\Annotation as DI;
use Lrt\AdhesionBundle\Entity\Adherent;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Adhesion controller.
 *
 * @Route("/adhesion")
 */
class AdherentController extends Controller
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
     * @DI\Inject("lrt.service.adhesion")
     * @var \Lrt\AdhesionBundle\Service\AdhesionService
     */
    public $adhesionService;
    
    /**
     * Displays a list adhesion
     *
     * @Route("/", name="adhesion_display")
     * @Secure(roles="ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @Template("AdhesionBundle:Adherent:index.html.twig")
     */
    public function indexAction()
    {
        $adherents = $this->adhesionService->getAdherents();

        return array('adherents' => $adherents, 'nb' => count($adherents));
    }

    /**
     * Displays a form to create a new User entity.
     *
     * @Route("/new", name="adhesion_new")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function newAction(Request $request)
    {
        $adherent = unserialize($this->get('session')->get('newAdherent'));
        $this->get('session')->remove('newAdherent');
        
        if (empty($adherent)) {
            $adherent = new Adherent();
        }
        
        $adherentType = $this->container->get('form.adhesionType');
        $form = $this->createForm($adherentType, $adherent);
        
        return array(
            'entity' => $adherent,
            'form' => $form->createView(),
            'request' => $request
        );
    }
    
    /**
     * Confirm a new Adherent entity.
     * @Route("/confirm", name="adhesion_confirm")
     * @Method("POST")
     * @Template("AdhesionBundle:Adherent:confirm.html.twig")
     */
    public function confirmAction(Request $request)
    {
        $adherent = new Adherent();
        
        $adherentType = $this->container->get('form.adhesionType');
        $form = $this->createForm($adherentType, $adherent);
        $form->bind($request);
        
        $errors = $this->get('carma.service.formError')->getAllFormErrorMessages($form);
        $this->get('session')->set('newAdhesion', serialize($adherent));
        
        if ($form->isValid() && empty($errors)) {
            return array(
                'entity' => $adherent,
                'request' => $request,
            );
        } else {
            
            foreach($errors as $error){
                $this->get('session')->getFlashBag()->add('error', $error);
            }
            
            return $this->redirect($this->generateUrl('adhesion_new'));
        }
    }
    
    /**
     * Creates a new Adherent entity.
     *
     * @Route("/create", name="adhesion_create")
     * @Method("GET")
     * @Template("AdhesionBundle:Adherent:new.html.twig")
     */
    public function createAction()
    {
        $adherent = unserialize($this->get('session')->get('newAdhesion'));
        
        /*$user->setUsername(strtolower($user->getFirstName() . '' . $user->getLastName()));
        $user->setPlainPassword("test");
        $encoder = new MessageDigestPasswordEncoder('sha512');
        $password = $encoder->encodePassword('test', $user->getSalt());
        $user->setPassword($password);*/
        
        $adherent->setIsValid(Adherent::IS_NOT_ACTIVE);
        $adherent->setDateSubmission(new \DateTime());

        $this->em->persist($adherent);
        $this->em->flush();
        
        $this->mailService->sendMessage("no-reply@longchamp-roller-team.com", "Nouvelle adhésion", "Une nouvelle adhésion vient d'être effectué sur le site.");

        $this->get('session')->getFlashBag()->add('success', 'Votre demande a bien été enregistré');
        return $this->redirect($this->generateUrl('user_adhesion_show', array('id' => $adherent->getId())));
    }
    
    /**
     * @Route("/{id}/validate", name="user_adhesion_validate", requirements={"id" = "\d+"})
     * @ParamConverter("adherent", class="AdhesionBundle:Adherent", options={"id" = "id"})
     * @Secure(roles="ROLE_SUPERVISEUR")
     * @Method("GET")
     * @Template("AdhesionBundle:Adherent:index.html.twig")
     */
    public function validateAction(Adherent $adherent)
    {
        $this->adhesionService->validate($adherent);

        $this->get('session')->getFlashBag()->add('success', 'La demande d\'adhésion a été validé.');
        return $this->redirect($this->generateUrl('adhesion_display'));
    }

    /**
     * @Route("/{id}/reject", name="user_adhesion_reject", requirements={"id" = "\d+"})
     * @ParamConverter("adherent", class="AdhesionBundle:Adherent", options={"id" = "id"})
     * @Secure(roles="ROLE_SUPERVISEUR")
     * @Method("GET")
     * @Template("AdhesionBundle:Adherent:index.html.twig")
     */
    public function rejectAction(Adherent $adherent)
    {
        $this->adhesionService->reject($adherent);

        $this->get('session')->getFlashBag()->add('success', 'La demande d\'adhésion a été rejeté.');
        return $this->redirect($this->generateUrl('adhesion_display'));
    }

    /**
     * RELANCER UN ADHERENT
     *
     * @Route("/{id}/revival", name="user_adhesion_validate_revival", requirements={"id" = "\d+"})
     * @ParamConverter("adherent", class="AdhesionBundle:Adherent", options={"id" = "id"})
     * @Secure(roles="ROLE_SUPERVISEUR")
     * @Method("GET")
     * @Template("AdhesionBundle:Adherent:index.html.twig")
     */
    public function revivalAction(Adherent $adherent)
    {
        $result = $this->adhesionService->revival($adherent);
        
        if($result == true) {
            $this->get('session')->getFlashBag()->add('success', 'Votre relance a été envoyé.');
            return $this->redirect($this->generateUrl('adhesion_display'));
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Votre demande de relance doit être supérieur à  la date de la demande.');
            return $this->redirect($this->generateUrl('adhesion_display'));
        }
    }

    /**
     * Show User entity.
     *
     * @Route("/{id}/show", name="user_adhesion_show", requirements={"id" = "\d+"})
     * @ParamConverter("adherent", class="AdhesionBundle:Adherent", options={"id" = "id"})
     * @Template()
     */
    public function showAction(Adherent $adherent)
    {
        return array(
            'adherent' => $adherent,
        );
    }
}

