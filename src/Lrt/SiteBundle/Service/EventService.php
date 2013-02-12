<?php

namespace Lrt\SiteBundle\Service;

use JMS\DiExtraBundle\Annotation as DI;

class EventService
{
    /**
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;

    /**
     * Retourne l'ensemble des évènements sous forme JSON
     */
    public function getEvents()
    {
        $events = $this->em->getRepository('CMSBundle:Article')->getLatestArticles(5);

        return json_encode($events);
    }
}
