<?php

namespace Lrt\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Lrt\AdminBundle\Entity\EventRequest;

/**
 * @ORM\Entity
 * @ORM\Table(name="partner")
 */
class Partner extends EventRequest
{
    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=125)
     * @Assert\NotBlank(message="Vous devez saisir le nom de la société.")
     */
    protected $name;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description_partner", type="string", length=4000)
     */
    protected $description;

    /**
     * @var string $description
     *
     * @ORM\Column(name="website_partner", type="string", length=125)
     * @Assert\NotBlank()
     * @Assert\Url(message="Vous devez saisir une adresse de site correct.")
     */
    protected $website;

    /**
     * Set name
     *
     * @param string $name
     * @return \Lrt\SiteBundle\Entity\Partner
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return \Lrt\SiteBundle\Entity\Partner
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
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

    /**
     * Set website
     *
     * @param string $website
     * @return \Lrt\SiteBundle\Entity\Partner
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
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
}
