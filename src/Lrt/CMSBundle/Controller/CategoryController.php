<?php

namespace Lrt\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Lrt\CMSBundle\Entity\Category;
use Lrt\CMSBundle\Form\Type\CategoryType;

/**
 * Category controller.
 *
 * @category Controller
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 *
 * @Route("/category")
 */
class CategoryController extends Controller
{
    /** @DI\Inject("doctrine.orm.entity_manager") */
    public $em;

    /** @DI\Inject("security.context") */
    public $sc;

    /**
     * Lists all Category entities.
     *
     * @Route("/", name="category")
     * @Template()
     */
    public function indexAction()
    {
        $entities = $this->em->getRepository('CMSBundle:Category')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Category entity.
     *
     * @Route("/{id}/show", name="category_show", requirements={"id" = "\d+"})
     * @ParamConverter("category", class="CMSBundle:Category", options={"id" = "id"})
     * @Template()
     */
    public function showAction(Category $category)
    {
        return array(
            'entity' => $category,
        );
    }

    /**
     * Displays a form to create a new Category entity.
     *
     * @Route("/new", name="category_new")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function newAction()
    {
        $user = $this->sc->getToken()->getUser();

        if(is_object($user)) {
            $entity = new Category();
            $form   = $this->createForm(new CategoryType(), $entity);

            return array(
                'entity' => $entity,
                'form'   => $form->createView(),
            );
        }  else {
            return new Response('Vous devez être connecté', 404);
        }
    }

    /**
     * Creates a new Category entity.
     *
     * @Route("/create", name="category_create")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("POST")
     * @Template("CMSBundle:Category:new.html.twig")
     */
    public function createAction(Request $request)
    {

        $user = $this->sc->getToken()->getUser();

        if(is_object($user)) {
            $entity  = new Category();
            $form = $this->createForm(new CategoryType(), $entity);
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('category_show', array('id' => $entity->getId())));
            }

            return array(
                'entity' => $entity,
                'form'   => $form->createView(),
            );
        } else {
            return new Response('Vous devez être connecté', 404);
        }
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", name="category_edit", requirements={"id" = "\d+"})
     * @ParamConverter("category", class="CMSBundle:Category", options={"id" = "id"})
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function editAction(Category $category)
    {
        $user = $this->sc->getToken()->getUser();

        if(is_object($user)) {

            $editForm = $this->createForm(new CategoryType(), $category);

            return array(
                'entity'      => $category,
                'edit_form'   => $editForm->createView(),
            );
        } else {
            return new Response('Vous devez être connecté', 404);
        }
    }

    /**
     * Edits an existing Category entity.
     *
     * @Route("/{id}/update", name="category_update", requirements={"id" = "\d+"})
     * @ParamConverter("category", class="CMSBundle:Category", options={"id" = "id"})
     * @Secure(roles="ROLE_ADMIN")
     * @Method("POST")
     * @Template("CMSBundle:Category:edit.html.twig")
     */
    public function updateAction(Request $request, Category $category)
    {
        $user = $this->sc->getToken()->getUser();

        if(is_object($user)) {

            $editForm = $this->createForm(new CategoryType(), $category);
            $editForm->bind($request);

            if ($editForm->isValid()) {
                $this->em->persist($category);
                $this->em->flush();

                return $this->redirect($this->generateUrl('category_edit', array('id' => $category->getId())));
            }

            return array(
                'entity'    => $category,
                'edit_form' => $editForm->createView(),
            );
        } else {
            return new Response('Vous devez être connecté', 404);
        }
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}/delete", name="category_delete", requirements={"id" = "\d+"})
     * @ParamConverter("category", class="CMSBundle:Category", options={"id" = "id"})
     * @Secure(roles="ROLE_ADMIN")
     * @Method("POST")
     */
    public function deleteAction(Request $request, Category $category)
    {
        $user = $this->sc->getToken()->getUser();

        if(is_object($user)) {
            $form = $this->createDeleteForm($category->getId());
            $form->bind($request);

            if ($form->isValid()) {

                $this->em->remove($category);
                $this->em->flush();
            }

            return $this->redirect($this->generateUrl('category'));
        } else {
            return new Response('Vous devez être connecté', 404);
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
