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
use Lrt\SiteBundle\Entity\Partner;

/**
 * Partner controller.
 *
 * @Route("/partner")
 */
class PartnerController extends Controller
{

    /**
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;

    /**
     * Lists all Partner entities.
     *
     * @Route("/", name="partner")
     * @Secure(roles="ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @Template()
     */
    public function indexAction()
    {
        $entities = $this->em->getRepository('SiteBundle:Partner')->findAll();

        return array(
            'entities' => $entities,
            'nb' => count($entities)
        );
    }

    /**
     * Finds and displays a Partner entity.
     *
     * @Route("/{id}/show", name="partner_show", requirements={"id" = "\d+"})
     * @ParamConverter("partner", class="SiteBundle:Partner", options={"id" = "id"})
     * @Secure(roles="ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @Template()
     */
    public function showAction(Partner $partner)
    {
        return array(
            'entity' => $partner,
        );
    }

    /**
     * Displays a form to create a new Partner entity.
     *
     * @Route("/new", name="partner_new")
     * @Secure(roles="ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @Template()
     */
    public function newAction()
    {
        $partner = new Partner();
        $form = $this->createForm($this->container->get('form.site.partner.type'), $partner);

        return array(
            'entity' => $partner,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Partner entity.
     *
     * @Route("/create", name="partner_create")
     * @Secure(roles="ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @Method("POST")
     * @Template("SiteBundle:Partner:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $partner = new Partner();
        $form = $this->createForm($this->container->get('form.site.partner.type'), $partner);
        $form->bind($request);

        if ($form->isValid()) {
            $this->em->persist($partner);
            $this->em->flush();

            return $this->redirect($this->generateUrl('partner_show', array('id' => $partner->getId())));
        }

        return array(
            'entity' => $partner,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Partner entity.
     *
     * @Route("/{id}/edit", name="partner_edit")
     * @Secure(roles="ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @ParamConverter("partner", class="SiteBundle:Partner", options={"id" = "id"})
     * @Template()
     */
    public function editAction(Partner $partner)
    {
        $editForm = $this->createForm($this->container->get('form.site.partner.type'), $partner);

        return array(
            'entity' => $partner,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Partner entity.
     *
     * @Route("/{id}/update", name="partner_update")
     * @Secure(roles="ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @ParamConverter("partner", class="SiteBundle:Partner", options={"id" = "id"})
     * @Method("POST")
     * @Template("SiteBundle:Partner:edit.html.twig")
     */
    public function updateAction(Request $request, Partner $partner)
    {
        $editForm = $this->createForm($this->container->get('form.site.partner.type'), $partner);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->em->persist($partner);
            $this->em->flush();

            return $this->redirect($this->generateUrl('partner_edit', array('id' => $partner->getId())));
        }

        return array(
            'entity' => $partner,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Partner entity.
     *
     * @Route("/{id}/delete", name="partner_delete")
     * @Secure(roles="ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @ParamConverter("partner", class="SiteBundle:Partner", options={"id" = "id"})
     * @Method("GET")
     */
    public function deleteAction(Partner $partner)
    {
        $this->em->remove($partner);
        $this->em->flush();

        $this->get('session')->setFlash('success', 'Partenaire retirer de la liste avec succès.');
        return $this->redirect($this->generateUrl('partner'));
    }

    /**
     * @Route("/export", name="export_partner")
     * @Secure(roles="ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @Template()
     */
    public function exportAction()
    {
        $exportPartners = $this->container->get('service.export_partners');
        $csvReadyPartners = $exportPartners->generateCsvReadyDatas();

        if (!is_object($csvReadyPartners)) {
            return $this->get('session')->setFlash('error', 'Impossible d\'exporter la liste des partenaires');
        } else {
            return $csvReadyPartners;
        }
    }

}
