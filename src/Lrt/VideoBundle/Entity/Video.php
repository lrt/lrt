<?php

/**
 * @category Entity
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\VideoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Lrt\VideoBundle\Repository\VideoRepository")
 * @ORM\Table(name="video")
 * @ORM\HasLifecycleCallbacks()
 */
class Video
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
    protected $user;

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

    /**
     * @ORM\Column(name="is_valid", type="integer")
     */
    protected $isValid;

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
     * Set user
     *
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Get auser
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
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
}
