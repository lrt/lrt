<?php

namespace Lrt\TeamBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Lrt\TeamBundle\Entity\PrizeList;
use Lrt\TeamBundle\Form\PrizeListType;

/**
 * PrizeList controller.
 *
 * @Route("/prizelist")
 */
class PrizeListController extends Controller
{
    /**
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * Lists all PrizeList entities.
     *
     * @Route("/", name="prizelist")
     * @Template()
     */
    public function indexAction()
    {
        $entities = $this->em->getRepository('TeamBundle:PrizeList')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a PrizeList entity.
     *
     * @Route("/{id}/show", name="prizelist_show")
     * @Template()
     */
    public function showAction($id)
    {
        $entity = $this->em->getRepository('TeamBundle:PrizeList')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PrizeList entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new PrizeList entity.
     *
     * @Route("/new", name="prizelist_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PrizeList();
        $form   = $this->createForm(new PrizeListType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new PrizeList entity.
     *
     * @Route("/create", name="prizelist_create")
     * @Method("POST")
     * @Template("TeamBundle:PrizeList:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new PrizeList();
        $form = $this->createForm(new PrizeListType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $this->em->persist($entity);
            $this->em->flush();

            return $this->redirect($this->generateUrl('prizelist_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PrizeList entity.
     *
     * @Route("/{id}/edit", name="prizelist_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $entity = $this->em->getRepository('TeamBundle:PrizeList')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PrizeList entity.');
        }

        $editForm = $this->createForm(new PrizeListType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing PrizeList entity.
     *
     * @Route("/{id}/update", name="prizelist_update")
     * @Method("POST")
     * @Template("TeamBundle:PrizeList:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $entity = $this->em->getRepository('TeamBundle:PrizeList')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PrizeList entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PrizeListType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->em->persist($entity);
            $this->em->flush();

            return $this->redirect($this->generateUrl('prizelist_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a PrizeList entity.
     *
     * @Route("/{id}/delete", name="prizelist_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $entity = $this->em->getRepository('TeamBundle:PrizeList')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PrizeList entity.');
            }

            $this->em->remove($entity);
            $this->em->flush();
        }

        return $this->redirect($this->generateUrl('prizelist'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
