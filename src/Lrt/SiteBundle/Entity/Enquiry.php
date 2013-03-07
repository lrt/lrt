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

    public function getEmail()
    {
        return $this->email;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getBody()
    {
        return $this->body;
    }
}
