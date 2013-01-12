<?php

/**
 * @category Controller
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Lrt\CMSBundle\Entity\Article;
use Lrt\CMSBundle\Form\Handler\ArticleHandler;
use Lrt\CMSBundle\Form\Type\ArticleType;

/**
 * Article controller.
 *
 * @Route("/article")
 */
class ArticleController extends Controller
{
    /** @DI\Inject("security.context") */
    public $sc;

    /** @DI\Inject("doctrine.orm.entity_manager") */
    public $em;

    /** @DI\Inject("form.cms.article.filter.type") */
    public $articleFilter;

    /** @DI\Inject("form.cms.article.type") */
    public $am;

    /**
     * Lists all Article entities.
     *
     * @Route("/", name="article")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm($this->articleFilter, array());
        $form->bind($request);
        $data = $form->getData();

        if($form->isValid()) {

            $articles = $this->em->getRepository('CMSBundle:Article')->filter($data['title'], $data['status'], $data['isPublic'], $data['category']);

            return array('entities' => $articles,'form' => $form->createView(), 'nb' => count($articles));

        } else {
            return $this->redirect($this->generateUrl('article'));
        }
    }

    /**
     * Finds and displays a Article entity.
     *
     * @Route("/{id}/show", name="article_show")
     * @Template("CMSBundle:Article:show.html.twig")
     */
    public function showAction($id)
    {
        $article = $this->em->getRepository('CMSBundle:Article')->find($id);

        if (!$article) {
            throw $this->createNotFoundException('Aucun article ne correspond à vos critères.');
        }

        return array('entity' => $article);
    }

    /**
     * Displays a form to create a new Article entity.
     *
     * @Route("/new", name="article_new")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function newAction()
    {
        $article = new Article();

        $form = $this->createForm(new ArticleType(), $article);

        return array(
            'entity' => $article,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Article entity.
     *
     * @Route("/create", name="article_create")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("POST")
     * @Template("CMSBundle:Article:new.html.twig")
     */
    public function createAction()
    {
        $user = $this->sc->getToken()->isAuthenticated();

        if($user) {

            $article  = new Article();
            $article->setUser($user);

            $form = $this->createForm($this->am, $article);
            $formHandler = new ArticleHandler($form, $this->getRequest(), $this->em);

            if($formHandler->process()) {

                return $this->redirect($this->generateUrl('article_show', array('id' => $article->getId())));
            }

            return array('entity' => $article,'form' => $form->createView());

        } else {
            throw $this->createNotFoundException('Vous devez être connecté pour accèder à cette page.');
        }
    }

    /**
     * Displays a form to edit an existing Article entity.
     *
     * @Route("/{id}/edit", name="article_edit")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function editAction($id)
    {
        $user = $this->sc->getToken()->isAuthenticated();

        if($user) {

            $entity = $this->em->getRepository('CMSBundle:Article')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Article entity.');
            }

            $editForm = $this->createForm(new ArticleType(), $entity);

            return array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
            );
        } else {
            throw $this->createNotFoundException('Vous devez être connecté pour accèder à cette page.');
        }
    }

    /**
     * Edits an existing Article entity.
     *
     * @Route("/{id}/update", name="article_update")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("POST")
     * @Template("CMSBundle:Article:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $user = $this->sc->getToken()->isAuthenticated();

        if($user) {
            $article = $this->em->getRepository('CMSBundle:Article')->find($id);

            if (!$article) {
                throw $this->createNotFoundException('Aucun article ne correspond à votre demande.');
            }

            $form = $this->createForm($this->am, $article);
            $formHandler = new ArticleHandler($form, $this->getRequest(), $this->em);

            if($formHandler->process()) {
                return $this->redirect($this->generateUrl('article_edit', array('id' => $id)));
            }

            return array(
                'entity' => $article,
                'edit_form' => $form->createView(),
            );
        } else {
            throw $this->createNotFoundException('Vous devez être connecté pour accèder à cette page.');
        }
    }

    /**
     * Deletes a Article entity.
     *
     * @Route("/{id}/delete", name="article_delete")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $user = $this->sc->getToken()->isAuthenticated();

        if($user) {
            $form = $this->createDeleteForm($id);
            $form->bind($request);

            if ($form->isValid()) {

                $entity = $this->em->getRepository('CMSBundle:Article')->find($id);

                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Article entity.');
                }

                $this->em->remove($entity);
                $this->em->flush();
            }

            return $this->redirect($this->generateUrl('article'));
        } else {
            throw $this->createNotFoundException('Vous devez être connecté pour accèder à cette page.');
        }
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
