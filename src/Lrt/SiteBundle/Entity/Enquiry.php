<?php

namespace Lrt\SiteBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Enquiry
{

    /**
     * @Assert\NotNull()
     */
    protected $name;

    /**
     * @Assert\NotNull()
     * @Assert\Regex("/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/")
     */
    protected $email;

    /**
     * @Assert\NotNull()
     */
    protected $subject;

    /**
     * @Assert\NotNull()
     */
    protected $body;

    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set subject
     *
     * @param $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set body
     *
     * @param $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

}
