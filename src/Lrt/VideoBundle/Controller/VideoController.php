<?php

/**
 * @category Controller
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\VideoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Lrt\VideoBundle\Entity\Video;
use Lrt\VideoBundle\Form\Handler\VideoHandler;
use Lrt\VideoBundle\Form\Type\VideoType;

/**
 * Video controller.
 *
 * @Route("/video")
 */
class VideoController extends Controller {

    /** @DI\Inject("security.context") */
    public $sc;

    /** @DI\Inject("doctrine.orm.entity_manager") */
    public $em;

    /** @DI\Inject("form.video.filter.type") */
    public $videoFilter;

    /**
     * Lists all Video entities.
     *
     * @Route("/", name="video")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm($this->videoFilter, array());
        $form->bind($request);
        $data = $form->getData();

        if($form->isValid()) {

            $videos = $this->em->getRepository('VideoBundle:Video')->filter($data['title'], $data['status'], $data['isPublic']);

            return array('entities' => $videos,'form' => $form->createView(),'nb' => count($videos));

        } else {
            return $this->redirect($this->generateUrl('video'));
        }
    }

    /**
     * Finds and displays a Video entity.
     *
     * @Route("/{id}/show", name="video_show")
     * @ParamConverter("video", class="VideoBundle:Video", options={"id" = "id"})
     * @Template()
     */
    public function showAction(Video $video) {

        return array(
            'entity' => $video,
        );
    }

    /**
     * Displays a form to create a new Video entity.
     *
     * @Route("/new", name="video_new")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function newAction() {
        $video = new Video();
        $form = $this->createForm(new VideoType(), $video);

        return array(
            'entity' => $video,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Video entity.
     *
     * @Route("/create", name="video_create")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("POST")
     * @Template("VideoBundle:Video:new.html.twig")
     */
    public function createAction(Request $request) {
        $user = $this->sc->getToken()->getUser();

        if (is_object($user)) {

            $video = new Video();
            $video->setUser($user);
            $form = $this->createForm(new VideoType(), $video);
            $formHandler = new VideoHandler($form, $request, $this->em);

            if ($formHandler->process()) {

                return $this->redirect($this->generateUrl('video_show', array('id' => $video->getId())));
            }

            return array(
                'entity' => $video,
                'form' => $form->createView(),
            );
        } else {
            return new Response('Vous devez être connecté', 404);
        }
    }

    /**
     * Displays a form to edit an existing Video entity.
     *
     * @Route("/{id}/edit", name="video_edit")
     * @ParamConverter("video", class="VideoBundle:Video", options={"id" = "id"})
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function editAction(Video $video) {

        $user = $this->sc->getToken()->getUser();

        if (is_object($user)) {

            $editForm = $this->createForm(new VideoType(), $video);

            return array(
                'entity' => $video,
                'edit_form' => $editForm->createView(),
            );
        } else {
            return new Response('Vous devez être connecté', 404);
        }
    }

    /**
     * Edits an existing Video entity.
     *
     * @Route("/{id}/update", name="video_update")
     * @ParamConverter("video", class="VideoBundle:Video", options={"id" = "id"})
     * @Secure(roles="ROLE_ADMIN")
     * @Method("POST")
     * @Template("VideoBundle:Video:edit.html.twig")
     */
    public function updateAction(Request $request, Video $video) {

        $user = $this->sc->getToken()->getUser();

        if (is_object($user)) {

            $editForm = $this->createForm(new VideoType(), $video);
            $editForm->bind($request);

            if ($editForm->isValid()) {
                $this->em->persist($video);
                $this->em->flush();

                return $this->redirect($this->generateUrl('video_edit', array('id' => $video->getId())));
            }

            return array(
                'entity' => $video,
                'edit_form' => $editForm->createView(),
            );
        } else {
            return new Response('Vous devez être connecté', 404);
        }
    }

    /**
     * Deletes a Video entity.
     *
     * @Route("/{id}/delete", name="video_delete")
     * @ParamConverter("video", class="VideoBundle:Video", options={"id" = "id"})
     * @Secure(roles="ROLE_ADMIN")
     * @Method("POST")
     */
    public function deleteAction(Request $request, Video $video) {

        $form = $this->createDeleteForm($video->getId());
        $form->bind($request);

        if ($form->isValid()) {

            $this->em->remove($video);
            $this->em->flush();
        }

        return $this->redirect($this->generateUrl('video'));
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

}
