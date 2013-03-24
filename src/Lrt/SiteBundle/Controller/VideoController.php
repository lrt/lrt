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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Lrt\SiteBundle\Entity\Video;
use Lrt\SiteBundle\Form\Handler\VideoHandler;

/**
 * Video controller.
 *
 * @Route("/video")
 */
class VideoController extends Controller
{

    /** @DI\Inject("security.context") */
    public $sc;

    /** @DI\Inject("doctrine.orm.entity_manager") */
    public $em;

    /**
     * Lists all Video entities.
     *
     * @Route("/", name="video")
     * @Secure(roles="ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm($this->container->get('form.video.filter.type'), array());
        $form->bind($request);
        $data = $form->getData();

        if ($form->isValid()) {

            $videos = $this->em->getRepository('SiteBundle:Video')->filter($data['title'], $data['status'], $data['isPublic']);

            return array('entities' => $videos, 'form' => $form->createView(), 'nb' => count($videos));
        } else {
            return $this->redirect($this->generateUrl('video'));
        }
    }

    /**
     * Finds and displays a Video entity.
     *
     * @Route("/{id}/show", name="video_show")
     * @ParamConverter("video", class="SiteBundle:Video", options={"id" = "id"})
     * @Template()
     */
    public function showAction(Video $video)
    {
        return array(
            'entity' => $video,
        );
    }

    /**
     * Displays a form to create a new Video entity.
     *
     * @Route("/new", name="video_new")
     * @Secure(roles="ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @Template()
     */
    public function newAction()
    {
        $video = new Video();
        $form = $this->createForm($this->container->get('form.site.video.type'), $video);

        return array(
            'entity' => $video,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Video entity.
     *
     * @Route("/create", name="video_create")
     * @Secure(roles="ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @Method("POST")
     * @Template("SiteBundle:Video:new.html.twig")
     */
    public function createAction(Request $request)
    {

        $user = $this->sc->getToken()->getUser();

        $video = new Video();
        $video->setUser($user);
        $form = $this->createForm($this->container->get('form.site.video.type'), $video);
        $formHandler = new VideoHandler($form, $request, $this->em);

        if ($formHandler->process()) {

            $this->get('session')->setFlash('success', 'Video ajoutée avec succès.');
            return $this->redirect($this->generateUrl('video'));
        }

        return array(
            'entity' => $video,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Video entity.
     *
     * @Route("/{id}/edit", name="video_edit")
     * @ParamConverter("video", class="SiteBundle:Video", options={"id" = "id"})
     * @Secure(roles="ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @Template()
     */
    public function editAction(Video $video)
    {

        $editForm = $this->createForm($this->container->get('form.site.video.type'), $video);

        return array(
            'entity' => $video,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Video entity.
     *
     * @Route("/{id}/update", name="video_update")
     * @ParamConverter("video", class="SiteBundle:Video", options={"id" = "id"})
     * @Secure(roles="ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @Method("POST")
     * @Template("SiteBundle:Video:edit.html.twig")
     */
    public function updateAction(Request $request, Video $video)
    {

        $editForm = $this->createForm($this->container->get('form.site.video.type'), $video);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->em->persist($video);
            $this->em->flush();

            $this->get('session')->setFlash('success', 'Modification de la vidéo '.$video->getTitle().' réussi avec succès.');
            return $this->redirect($this->generateUrl('video_edit', array('id' => $video->getId())));
        }

        return array(
            'entity' => $video,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Video entity.
     *
     * @Route("/{id}/delete", name="video_delete")
     * @ParamConverter("video", class="SiteBundle:Video", options={"id" = "id"})
     * @Secure(roles="ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @Method("GET")
     */
    public function deleteAction(Video $video)
    {
        $this->em->remove($video);
        $this->em->flush();

        $this->get('session')->setFlash('success', 'Video supprimer avec succès.');
        return $this->redirect($this->generateUrl('video'));
    }

}
