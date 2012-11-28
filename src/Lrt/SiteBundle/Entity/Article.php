<?php

namespace Lrt\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Lrt\UserBundle\Entity\User;
use Lrt\SiteBundle\Entity\Category;

/**
 * @ORM\Entity(repositoryClass="Lrt\SiteBundle\Repository\ArticleRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields="title", message="Un article existe déjà avec ce titre.")
 */
class Article extends Content
{
    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    protected $status;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isPublic;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="categories")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function getStatusLabel()
    {
        $enumStatusArticle = new \Lrt\SiteBundle\Enum\StatusArticleEnum();
        $data_label = $enumStatusArticle->getData();

        return (isset($data_label[$this->status])) ? $data_label[$this->status] : '';
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
}
