<?php

/**
 * @category Entity
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\VideoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lrt\AdminBundle\Entity\EventRequest;

/**
 * @ORM\Entity(repositoryClass="Lrt\VideoBundle\Repository\VideoRepository")
 */
class Video extends EventRequest
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
}
