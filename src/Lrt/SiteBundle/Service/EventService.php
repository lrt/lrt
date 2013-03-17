<?php

namespace Lrt\SiteBundle\Service;

use JMS\DiExtraBundle\Annotation as DI;
use Lrt\SiteBundle\Entity\Event;

/**
 * @DI\Service("service.event")
 */
class EventService
{
    /**
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;

    /**
     * @DI\Inject("kernel")
     */
    public $kernel;
    
    /**
     * Mise à jour d'un évènement
     * @param \Lrt\SiteBundle\Service\Event $event
     */
    public function updateEvent(Event $event)
    {
        $this->em->persist($event);
        $this->em->flush();
    }
    
    /**
     * Mise à jour d'un évènement
     * @param \Lrt\SiteBundle\Service\Event $event
     */
    public function deleteEvent(Event $event)
    {
        $this->em->remove($event);
        $this->em->flush();
    }
    
    /**
     * Retourne l'ensemble des évènements sous forme JSON
     */
    public function getEvents()
    {
        $events = $this->em->getRepository('SiteBundle:Event')->findAll();

        $data_source = array();

        foreach($events as $event)
        {
            array_push($data_source, array(
                'id'    => $event->getId(),
                'title' => $event->getTitle(),
                'start' => $event->getDateDeb()->format('Y-m-d'),
                'end'   => $event->getDateEnd()->format('Y-m-d'),
            ));
        }

        $data = json_encode($data_source);

        $fp = fopen($this->kernel->getRootDir().'/../web/data/events/'.'data.json', 'w+');
        fputs($fp, $data);
        fclose($fp);

        return true;
    }
}
