<?php

namespace Lrt\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\SerializerBundle\Annotation\Type;

/**
 * Lrt\UserBundle\Entity\Department
 *
 * @ORM\Table(name="department")
 * @ORM\Entity
 */
class Department
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Type("integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", nullable=false)
     * @Type("string")
     *
     * @var string $name
     */
    protected $name;

    /**
     * @ORM\Column(name="cp", type="integer", nullable=false)
     * @Type("string")
     *
     * @var string $cp
     */
    protected $zipCode;

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
     * @return Department
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
     * Set zipCode
     *
     * @param integer $zipCode
     * @return Department
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return integer
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }
}
