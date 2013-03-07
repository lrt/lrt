<?php

namespace Lrt\SiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JMS\DiExtraBundle\Annotation as DI;
use Lrt\SiteBundle\Entity\Event;

/**
 * Event controller.
 *
 * @Route("/event")
 */
class EventController extends Controller
{

    /**
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;

    /**
     * @DI\Inject("service.event")
     * @var \Lrt\SiteBundle\Service\EventService
     */
    public $eventService;

    /**
     * Lists all Event entities.
     *
     * @Route("/", name="event")
     * @Secure(roles="ROLE_MEMBER,ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @Template()
     */
    public function indexAction()
    {
        $this->eventService->getEvents();

        return array();
    }

    /**
     * Finds and displays a Event entity.
     *
     * @Route("/{id}/show", name="event_show")
     * @Secure(roles="ROLE_MEMBER,ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @ParamConverter("event", class="SiteBundle:Event", options={"id" = "id"})
     * @Template()
     */
    public function showAction(Event $event)
    {
        return array(
            'entity' => $event,
        );
    }

    /**
     * Displays a form to create a new Event entity.
     *
     * @Route("/new", name="event_new")
     * @Secure(roles="ROLE_MEMBER,ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @Template()
     */
    public function newAction()
    {
        $event = new Event();
        $form = $this->createForm($this->container->get('form.site.event.type'), $event);

        return array(
            'entity' => $event,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Event entity.
     *
     * @Route("/create", name="event_create")
     * @Secure(roles="ROLE_MEMBER,ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @Method("POST")
     * @Template("SiteBundle:Event:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm($this->container->get('form.site.event.type'), $event);
        $form->bind($request);

        if ($form->isValid()) {
            $this->eventService->updateEvent($event);
            
            $this->get('session')->setFlash('success', 'Evènement ajouté avec succès.');
            return $this->redirect($this->generateUrl('event'));
        }

        return array(
            'entity' => $event,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Event entity.
     *
     * @Route("/{id}/edit", name="event_edit")
     * @Secure(roles="ROLE_MEMBER,ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @ParamConverter("event", class="SiteBundle:Event", options={"id" = "id"})
     * @Template()
     */
    public function editAction(Event $event)
    {
        $editForm = $this->createForm($this->container->get('form.site.event.type'), $event);

        return array(
            'entity' => $event,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Event entity.
     *
     * @Route("/{id}/update", name="event_update")
     * @Secure(roles="ROLE_MEMBER,ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @ParamConverter("event", class="SiteBundle:Event", options={"id" = "id"})
     * @Method("POST")
     * @Template("SiteBundle:Event:edit.html.twig")
     */
    public function updateAction(Request $request, Event $event)
    {
        $editForm = $this->createForm($this->container->get('form.site.event.type'), $event);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->eventService->updateEvent($event);

            $this->get('session')->setFlash('success', 'Modification de l\'évènement ' . $event->getTitle() . ' réussi avec succès.');
            return $this->redirect($this->generateUrl('event_edit', array('id' => $event->getId())));
        }

        return array(
            'entity' => $event,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Event entity.
     *
     * @Route("/{id}/delete", name="event_delete")
     * @Secure(roles="ROLE_MEMBER,ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @ParamConverter("event", class="SiteBundle:Event", options={"id" = "id"})
     * @Method("GET")
     */
    public function deleteAction(Event $event)
    {
        $this->eventService->deleteEvent($event);

        $this->get('session')->setFlash('success', 'Evènement supprimer avec succès.');
        return $this->redirect($this->generateUrl('event'));
    }

}
