<?php

namespace Lrt\CalendarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Lrt\AdminBundle\Entity\EventRequest;

/**
 * @ORM\Entity
 * @ORM\Table(name="event")
 */
class Event extends EventRequest
{
    /**
     * @ORM\Column(name="date_deb", type="date", nullable=true)
     */
    protected $dateDeb;

    /**
     * @ORM\Column(name="date_end", type="date", nullable=true)
     */
    protected $dateEnd;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     */
    protected $place;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     */
    protected $website;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     */
    protected $description;

    /**
     * Set dateDeb
     *
     * @param date $dateDeb
     */
    public function setDateDeb($dateDeb)
    {
        $this->dateDeb = $dateDeb;
    }

    /**
     * Get dateDeb
     *
     * @return date
     */
    public function getDateDeb()
    {
        return $this->dateDeb;
    }

    /**
     * Set dateEnd
     *
     * @param date $dateEnd
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;
    }

    /**
     * Get dateEnd
     *
     * @return date
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set place
     *
     * @param string $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }

    /**
     * Get place
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set website
     *
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
