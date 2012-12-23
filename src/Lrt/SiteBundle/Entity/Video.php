<?php

namespace Lrt\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="video")
 * @ORM\HasLifecycleCallbacks()
 */
class Video
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="\Lrt\UserBundle\Entity\User", inversedBy="videos")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $author;

    /**
     * @ORM\Column(name="vimeo_id", type="integer")
     */
    protected $vimeoId;

    /**
     * @ORM\Column(name="is_autoplay", type="integer")
     */
    protected $isAutoPlay;

    /**
     * @ORM\Column(name="is_published", type="integer")
     */
    protected $isPublished;

    /**
     * @ORM\Column(name="is_public", type="integer")
     */
    protected $isPublic;

    /**
     * @ORM\Column(name="is_highlighted", type="integer")
     */
    protected $isHighlighted;

    public function __construct()
    {
        $this->setIsPublic(0);
        $this->setIsPublished(0);
        $this->setIsHighlighted(0);
        $this->setIsAutoPlay(0);
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

    /**
     * Set author
     *
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set vimeoId
     *
     * @param integer $vimeoId
     */
    public function setVimeoId($vimeoId)
    {
        $this->vimeoId = $vimeoId;
    }

    /**
     * Get vimeoId
     *
     * @return integer
     */
    public function getVimeoId()
    {
        return $this->vimeoId;
    }

    /**
     * Set isPublished
     *
     * @param integer $isPublished
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;
    }

    /**
     * Get isPublished
     *
     * @return integer
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * Set isPublic
     *
     * @param integer $isPublic
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;
    }

    /**
     * Get isPublic
     *
     * @return integer
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * Set isHighlighted
     *
     * @param integer $isHighlighted
     */
    public function setIsHighlighted($isHighlighted)
    {
        $this->isHighlighted = $isHighlighted;
    }

    /**
     * Get isHighlighted
     *
     * @return integer
     */
    public function getIsHighlighted()
    {
        return $this->isHighlighted;
    }

    /**
     * Set isAutoPlay
     *
     * @param integer $isAutoPlay
     */
    public function setIsAutoPlay($isAutoPlay)
    {
        $this->isAutoPlay = $isAutoPlay;
    }

    /**
     * Get isAutoPlay
     *
     * @return integer
     */
    public function getIsAutoPlay()
    {
        return $this->isAutoPlay;
    }
}
