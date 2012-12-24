<?php

/**
 * @category Controller
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\SiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Lrt\SiteBundle\Entity\Video;
use Lrt\SiteBundle\Form\Type\VideoType;

/**
 * Video controller.
 *
 * @Route("/video")
 */
class VideoController extends Controller
{

    /** @DI\Inject("doctrine.orm.entity_manager") */
    public $em;

    /**
     * Lists all Video entities.
     *
     * @Route("/", name="video")
     * @Template()
     */
    public function indexAction()
    {
        $entities = $this->em->getRepository('SiteBundle:Video')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Video entity.
     *
     * @Route("/{id}/show", name="video_show")
     * @Template()
     */
    public function showAction($id)
    {
        $entity = $this->em->getRepository('SiteBundle:Video')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Video entity.');
        }

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Video entity.
     *
     * @Route("/new", name="video_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Video();
        $form   = $this->createForm(new VideoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Video entity.
     *
     * @Route("/create", name="video_create")
     * @Method("POST")
     * @Template("SiteBundle:Video:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Video();
        $form = $this->createForm(new VideoType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $this->em->persist($entity);
            $this->em->flush();

            return $this->redirect($this->generateUrl('video_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Video entity.
     *
     * @Route("/{id}/edit", name="video_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $entity = $this->em->getRepository('SiteBundle:Video')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Video entity.');
        }

        $editForm = $this->createForm(new VideoType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Video entity.
     *
     * @Route("/{id}/update", name="video_update")
     * @Method("POST")
     * @Template("SiteBundle:Video:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $entity = $this->em->getRepository('SiteBundle:Video')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Video entity.');
        }

        $editForm = $this->createForm(new VideoType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->em->persist($entity);
            $this->em->flush();

            return $this->redirect($this->generateUrl('video_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Video entity.
     *
     * @Route("/{id}/delete", name="video_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $entity = $this->em->getRepository('SiteBundle:Video')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Video entity.');
            }

            $this->em->remove($entity);
            $this->em->flush();
        }

        return $this->redirect($this->generateUrl('video'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
