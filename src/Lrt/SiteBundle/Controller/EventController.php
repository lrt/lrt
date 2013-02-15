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
use Lrt\SiteBundle\Form\EventType;

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
     * @Template()
     */
    public function indexAction()
    {
        $events = $this->eventService->getEvents();

        return array(
            'entities' => $events,
        );
    }

    /**
     * Finds and displays a Event entity.
     *
     * @Route("/{id}/show", name="event_show")
     * @ParamConverter("event", class="SiteBundle:Event", options={"id" = "id"})
     * @Template()
     */
    public function showAction(Event $event)
    {
        $deleteForm = $this->createDeleteForm($event->getId());

        return array(
            'entity'      => $event,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Event entity.
     *
     * @Route("/new", name="event_new")
     * @Template()
     */
    public function newAction()
    {
        $event = new Event();
        $form   = $this->createForm(new EventType(), $event);

        return array(
            'entity' => $event,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Event entity.
     *
     * @Route("/create", name="event_create")
     * @Method("POST")
     * @Template("SiteBundle:Event:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $event  = new Event();
        $form = $this->createForm(new EventType(), $event);
        $form->bind($request);

        if ($form->isValid()) {
            $this->em->persist($event);
            $this->em->flush();

            return $this->redirect($this->generateUrl('event_show', array('id' => $event->getId())));
        }

        return array(
            'entity' => $event,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Event entity.
     *
     * @Route("/{id}/edit", name="event_edit")
     * @ParamConverter("event", class="SiteBundle:Event", options={"id" = "id"})
     * @Template()
     */
    public function editAction(Event $event)
    {
        $editForm = $this->createForm(new EventType(), $event);
        $deleteForm = $this->createDeleteForm($event->getId());

        return array(
            'entity'      => $event,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Event entity.
     *
     * @Route("/{id}/update", name="event_update")
     * @ParamConverter("event", class="SiteBundle:Event", options={"id" = "id"})
     * @Method("POST")
     * @Template("SiteBundle:Event:edit.html.twig")
     */
    public function updateAction(Request $request, Event $event)
    {
        $deleteForm = $this->createDeleteForm($event->getId());
        $editForm = $this->createForm(new EventType(), $event);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->em->persist($event);
            $this->em->flush();

            return $this->redirect($this->generateUrl('event_edit', array('id' => $event->getId())));
        }

        return array(
            'entity'      => $event,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Event entity.
     *
     * @Route("/{id}/delete", name="event_delete")
     * @ParamConverter("event", class="SiteBundle:Event", options={"id" = "id"})
     * @Method("POST")
     */
    public function deleteAction(Request $request, Event $event)
    {
        $form = $this->createDeleteForm($event->getId());
        $form->bind($request);

        if ($form->isValid()) {
            $this->em->remove($event);
            $this->em->flush();
        }

        return $this->redirect($this->generateUrl('event'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
