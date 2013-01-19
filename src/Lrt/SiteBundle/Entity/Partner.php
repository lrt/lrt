<?php

namespace Lrt\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="partner")
 */
class Partner
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * @ORM\Column(name="description", type="string", length=4000)
     */
    protected $description;

    /**
     * @var string $description
     *
     * @ORM\Column(name="website", type="string", length=125)
     * @Assert\NotBlank()
     * @Assert\Url(message="Vous devez saisir une adresse de site correct.")
     */
    protected $website;

    /**
     * @ORM\ManyToOne(targetEntity="\Lrt\UserBundle\Entity\User", inversedBy="partners")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

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

    /**
     * Set user
     *
     * @param \Lrt\UserBundle\Entity\User $user
     * @internal param $User
     */
    public function setUser(\Lrt\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return \Lrt\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
