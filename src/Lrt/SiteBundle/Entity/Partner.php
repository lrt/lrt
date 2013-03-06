<?php

namespace Lrt\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Lrt\SiteBundle\Entity\Activity;

/**
 * @ORM\Entity
 * @ORM\Table(name="partner")
 */
class Partner extends Activity
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
     * @Assert\File(maxSize="6000000",mimeTypes= {"image/jpeg","image/gif","image/png"},mimeTypesMessage= "Format de fichier non valide")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $picture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $path;

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

    public function getFullPicturePath()
    {
        return null === $this->picture ? null : $this->getUploadRootDir() . $this->picture;
    }

    public function getWebPath()
    {
        return null === $this->picture ? null : $this->getUploadDir() . '/' . $this->picture;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return $this->getTmpUploadRootDir() . $this->getId() . "/";
    }

    protected function getTmpUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__ . '/../../../../web/uploads/partners/';
    }

    protected function getUploadDir()
    {
        return 'uploads/partners';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function uploadPicture()
    {
        // the file property can be empty if the field is not required
        if (null === $this->picture) {
            return;
        }
        if (!$this->id) {
            $this->picture->move($this->getTmpUploadRootDir(), $this->picture->getClientOriginalName());
        } else {
            $this->picture->move($this->getUploadRootDir(), $this->picture->getClientOriginalName());
        }
        $this->setPath($this->getUploadDir() . '/' . $this->getId() . '/' . $this->picture->getClientOriginalName());
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
        if (!is_dir($this->getUploadRootDir())) {
            mkdir($this->getUploadRootDir());
        }
        copy($this->getTmpUploadRootDir() . $this->picture, $this->getFullPicturePath());
        @unlink($this->getTmpUploadRootDir() . $this->picture);
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
