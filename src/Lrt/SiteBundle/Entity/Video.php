<?php

/**
 * @category Entity
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lrt\SiteBundle\Entity\Activity;

/**
 * @ORM\Entity(repositoryClass="Lrt\SiteBundle\Repository\VideoRepository")
 */
class Video extends Activity
{
    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\Column(name="is_published", type="integer", nullable=true)
     */
    protected $isPublished;

    /**
     * @ORM\Column(name="is_highlighted", type="integer", nullable=true)
     */
    protected $isHighlighted;

    /**
     * @var string $description
     *
     * @ORM\Column(name="path_video", type="string", length=125, nullable=true)
     */
    protected $path;

    public function __construct()
    {
        $this->setIsPublished(0);
        $this->setIsHighlighted(0);
        $this->setDateSubmission(new \DateTime());
        $this->setIsValid(0);
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
     * Set path
     *
     * @param integer $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Get $path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
