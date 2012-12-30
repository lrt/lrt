<?php

/**
 * @category Controller
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use JMS\DiExtraBundle\Annotation as DI;

class DefaultController extends Controller
{
    /**
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;

    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
        $articles = $this->em->getRepository('CMSBundle:Article')->getLatestArticles(5);

        return array('articles' => $articles);
    }

    /**
     * @Route("/information/{page}", name="show_page")
     * @Template()
     */
    public function showAction($page)
    {
        $template = sprintf("SiteBundle:Page:%s.html.twig", $page);

        try {
            $response = $this->render($template);
            $response->setSharedMaxAge(600);
            return $response;
        } catch (\Exception $e) {
            return new Response("Aucune page ne correspond à votre demande.", 404);
        }
    }
}
