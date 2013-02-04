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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Lrt\CMSBundle\Entity\Article;
use Lrt\CMSBundle\Entity\Content;
use Lrt\CMSBundle\Form\Handler\ArticleHandler;

/**
 * Article controller.
 *
 * @Route("/article")
 */
class ArticleController extends Controller
{
    /**
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /** @DI\Inject("security.context") */
    private $sc;

    /**
     * Lists all Article entities.
     *
     * @Route("/", name="article")
     * @Secure(roles="ROLE_ADMIN,ROLE_MEMBER,ROLE_SUPERVISEUR")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm($this->container->get('form.cms.article.filter.type'), array());
        $form->bind($request);
        $data = $form->getData();

        if($form->isValid()) {

            $articles = $this->em->getRepository('CMSBundle:Article')->filter($data['title'], $data['isPublic'], $data['category']);

            return array('entities' => $articles,'form' => $form->createView(), 'nb' => count($articles));

        } else {
            return $this->redirect($this->generateUrl('article'));
        }
    }

    /**
     * Lists all Article draft.
     *
     * @Route("/draft", name="article_draft")
     * @Secure(roles="ROLE_ADMIN,ROLE_MEMBER,ROLE_SUPERVISEUR")
     * @Template("CMSBundle:Article:draft.html.twig")
     */
    public function listDraftAction()
    {
        $user = $this->sc->getToken()->getUser();

        if($user) {
            $articles = $this->em->getRepository('CMSBundle:Article')->getArticlesDraftsByUser($user);

            return array('entities' => $articles, 'nb' => count($articles));
        } else {
            throw $this->createNotFoundException('Vous devez être connecté pour accèder à cette page.');
        }
    }

    /**
     * Lists all Article in bin.
     *
     * @Route("/corbeille", name="article_bin")
     * @Secure(roles="ROLE_ADMIN,ROLE_MEMBER,ROLE_SUPERVISEUR")
     * @Template("CMSBundle:Article:bin.html.twig")
     */
    public function listBinAction()
    {
        $articles = $this->em->getRepository('CMSBundle:Article')->getArticlesInBin();

        return array('entities' => $articles, 'nb' => count($articles));
    }

    /**
     * Finds and displays a Article entity.
     *
     * @Route("/{id}/show", name="article_show", requirements={"id" = "\d+"})
     * @ParamConverter("article", class="CMSBundle:Article", options={"id" = "id"})
     * @Secure(roles="ROLE_ADMIN,ROLE_MEMBER,ROLE_SUPERVISEUR")
     * @Template("CMSBundle:Article:show.html.twig")
     */
    public function showAction(Article $article)
    {
        return array(
            'article' => $article
        );
    }

    /**
     * Display a article in front
     *
     * @Route("/{id}/view", name="article_view")
     * @ParamConverter("article", class="CMSBundle:Article", options={"id" = "id"})
     * @Template("CMSBundle:Article:view.html.twig")
     */
    public function viewAction(Article $article)
    {
        return array(
            'article' => $article
        );
    }

    /**
     * Displays a form to create a new Article entity.
     *
     * @Route("/new", name="article_new")
     * @Secure(roles="ROLE_ADMIN,ROLE_MEMBER,ROLE_SUPERVISEUR")
     * @Template()
     */
    public function newAction()
    {
        $article = new Article();

        $form = $this->createForm($this->container->get('form.cms.article.type'), $article);

        return array(
            'article' => $article,
            'form'    => $form->createView(),
        );
    }

    /**
     * Creates a new Article entity.
     *
     * @Route("/create", name="article_create")
     * @Secure(roles="ROLE_ADMIN,ROLE_MEMBER,ROLE_SUPERVISEUR")
     * @Method("POST")
     * @Template("CMSBundle:Article:new.html.twig")
     */
    public function createAction()
    {
        $user = $this->sc->getToken()->getUser();

        if($user) {

            $article  = new Article();
            $article->setUser($user);

            $form = $this->createForm($this->container->get('form.cms.article.type'), $article);
            $formHandler = new ArticleHandler($form, $this->getRequest(), $this->em);

            if($formHandler->process()) {

                return $this->redirect($this->generateUrl('article'));
            }

            return array('entity' => $article,'form' => $form->createView());

        } else {
            throw $this->createNotFoundException('Vous devez être connecté pour accèder à cette page.');
        }
    }

    /**
     * Displays a form to edit an existing Article entity.
     *
     * @Route("/{id}/edit", name="article_edit", requirements={"id" = "\d+"})
     * @ParamConverter("article", class="CMSBundle:Article", options={"id" = "id"})
     * @Secure(roles="ROLE_ADMIN,ROLE_MEMBER,ROLE_SUPERVISEUR")
     * @Template()
     */
    public function editAction(Article $article)
    {
        $editForm = $this->createForm($this->container->get('form.cms.article.type'), $article);

        return array(
            'article'   => $article,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Article entity.
     *
     * @Route("/{id}/update", name="article_update", requirements={"id" = "\d+"})
     * @ParamConverter("article", class="CMSBundle:Article", options={"id" = "id"})
     * @Secure(roles="ROLE_ADMIN,ROLE_MEMBER,ROLE_SUPERVISEUR")
     * @Method("POST")
     * @Template("CMSBundle:Article:edit.html.twig")
     */
    public function updateAction(Request $request, Article $article)
    {
        $user = $this->sc->getToken()->getUser();

        if($user) {

            $form = $this->createForm($this->container->get('form.cms.article.type'), $article);
            $formHandler = new ArticleHandler($form, $request, $this->em);

            if($formHandler->process()) {

                $this->get('session')->setFlash('success', 'Modification de l\'article '.$article->getTitle().' réussi avec succès.' );
                return $this->redirect($this->generateUrl('article_edit', array('id' => $article->getId())));
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
     * Add article in bin.
     *
     * @Route("/{id}/delete", name="article_delete", requirements={"id" = "\d+"})
     * @ParamConverter("article", class="CMSBundle:Article", options={"id" = "id"})
     * @Secure(roles="ROLE_ADMIN,ROLE_SUPERVISEUR")
     * @Method("GET")
     */
    public function deleteAction(Article $article)
    {
        $user = $this->sc->getToken()->getUser();

        if($user) {

            $article->setStatus(Content::BIN); //corbeille

            $this->em->persist($article);
            $this->em->flush();

            return $this->redirect($this->generateUrl('article'));

        } else {
            throw $this->createNotFoundException('Vous devez être connecté pour accèder à cette page.');
        }
    }

    /**
     * @Route("/export", name="export_article")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function exportAction()
    {
        $exportArticles = $this->container->get('service.export_articles');
        $csvReadyArticles = $exportArticles->generateCsvReadyDatas();

        if(!is_object($csvReadyArticles)) {
            return $this->get('session')->setFlash('error', 'Impossible d\'exporter la liste des articles');
        } else {
            return $csvReadyArticles;
        }
    }
}
