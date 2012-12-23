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
use JMS\DiExtraBundle\Annotation as DI;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Lrt\SiteBundle\Form\Type\EnquiryType;

/**
 * Enquiry controller.
 *
 * @Route("/contact")
 */
class EnquiryController extends Controller
{
    /**
     * Page Contact.
     *
     * @Route("/", name="contact")
     * @Template()
     */
    public function indexAction()
    {

    }

}
