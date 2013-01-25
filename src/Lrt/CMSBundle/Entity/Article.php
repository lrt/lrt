<?php

/**
 * @category Entity
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Lrt\CMSBundle\Entity\Category;
use Lrt\AdminBundle\Entity\EventRequest;

/**
 * @ORM\Entity(repositoryClass="Lrt\CMSBundle\Repository\ArticleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Article extends EventRequest
{
    const DRAFTS = 2;
    const IMMEDIATE = 3;
    const BIN = 4;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
     */
    protected $content;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    protected $status;

    /**
     * @ORM\Column(name="is_public", type="boolean", nullable=true)
     */
    protected $isPublic;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="categories")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @Assert\File(maxSize="6000000",mimeTypes= {"image/jpeg","image/gif","image/png"},mimeTypesMessage= "Format de fichier non valide")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $picture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $path;


    /**
     * Set content
     *
     * @param $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set status
     *
     * @param integer $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set isPublic
     *
     * @param boolean $isPublic
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;
    }

    /**
     * Get isPublic
     *
     * @return boolean
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * Set category
     *
     * @param Category $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set picture
     *
     * @param string $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**UPLOAD IMAGE*/

    /**
     * Set path
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    public function getFullPicturePath() {
        return null === $this->picture ? null : $this->getUploadRootDir(). $this->picture;
    }

    public function getWebPath()
    {
        return null === $this->picture ? null : $this->getUploadDir().'/'.$this->picture;
    }

    protected function getUploadRootDir() {
        // the absolute directory path where uploaded documents should be saved
        return $this->getTmpUploadRootDir().$this->getId()."/";
    }

    protected function getTmpUploadRootDir() {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__ . '/../../../../web/uploads/articles/';
    }

    protected function getUploadDir()
    {
        return 'uploads/articles';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function uploadPicture() {
        // the file property can be empty if the field is not required
        if (null === $this->picture) {
            return;
        }
        if(!$this->id){
            $this->picture->move($this->getTmpUploadRootDir(), $this->picture->getClientOriginalName());
        }else{
            $this->picture->move($this->getUploadRootDir(), $this->picture->getClientOriginalName());
        }
        $this->setPath($this->getUploadDir().'/'.$this->getId().'/'.$this->picture->getClientOriginalName());
        $this->setPicture($this->picture->getClientOriginalName());

    }

    /**
     * @ORM\PostPersist()
     */
    public function movePicture()
    {
        if (null === $this->picture) {
            return;
        }
        if(!is_dir($this->getUploadRootDir())){
            mkdir($this->getUploadRootDir());
        }
        copy($this->getTmpUploadRootDir().$this->picture, $this->getFullPicturePath());
        @unlink($this->getTmpUploadRootDir().$this->picture);
    }

    /**
     * @ORM\PreRemove()
     */
    public function removePicture()
    {
        @unlink($this->getFullPicturePath());
        //rmdir($this->getUploadRootDir());
    }
}