<?php

namespace Lrt\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * Enquiry controller.
 *
 * @category Controller
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 *
 * @Route("/contact")
 */
class EnquiryController extends Controller
{

    /**
     *
     * @Route("/", name="form_contact")
     * @Template()
     */
    public function indexAction()
    {
        $form = $this->createForm($this->container->get('form.enquiryType'), array());

        $form->bindRequest($request);
        $data = $form->getData();

        return array('form' => $form->createView());
    }
}
