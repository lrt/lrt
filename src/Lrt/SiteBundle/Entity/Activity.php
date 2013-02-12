<?php

namespace Lrt\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lrt\SiteBundle\Entity\Activity
 * @ORM\Entity(repositoryClass="Lrt\SiteBundle\Repository\ActivityRepository")
 * @ORM\Table(name="activity")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"video" = "Video",
 *                        "event" = "Event",
 *                        "partner" = "Partner",
 *                        "article" = "Lrt\CMSBundle\Entity\Article"
 *                      })
 */
class Activity
{
    const IS_NOT_VALIDATED = 0;
    const IS_VALIDATED = 1;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime $date_submission
     *
     * @ORM\Column(name="date_submission", type="datetime")
     */
    protected $dateSubmission;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(name="is_valid", type="integer")
     */
    protected $isValid;

    /**
     * @ORM\ManyToOne(targetEntity="\Lrt\UserBundle\Entity\User", inversedBy="request")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    protected $user;

    public function __construct()
    {
        $this->setDateSubmission(new \DateTime());
        $this->setIsValid(0);
    }

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
     * Set date_submission
     *
     * @param \DateTime $dateSubmission
     * @return Activity
     */
    public function setDateSubmission($dateSubmission)
    {
        $this->dateSubmission = $dateSubmission;

        return $this;
    }

    /**
     * Get date_submission
     *
     * @return \DateTime
     */
    public function getDateSubmission()
    {
        return $this->dateSubmission;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set is_valid
     *
     * @param integer $isValid
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;
    }

    /**
     * Get is_valid
     *
     * @return integer
     */
    public function getIsValid()
    {
        return $this->isValid;
    }

    /**
     * Set user
     *
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }
}
