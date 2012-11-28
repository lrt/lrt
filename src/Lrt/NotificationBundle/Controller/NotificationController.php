<?php

namespace Lrt\NotificationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Response;

/**
 * Notification controller.
 *
 * @Route("/notification")
 */
class NotificationController extends Controller
{

    /** @DI\Inject("doctrine.orm.entity_manager") */
    public $em;

    /** @DI\Inject("security.context") */
    public $sc;

    /**
     * Lists all Notifications.
     *
     * @Route("/", name="list_notification")
     * @Template()
     */
    public function listAction()
    {

    }
}
