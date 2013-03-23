<?php

namespace Lrt\AdhesionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Lrt\AdhesionBundle\Repository\AdherentRepository")
 * @ORM\Table(name="adherent")
 * @UniqueEntity("licence")
 */
class Adherent
{

    const IS_NOT_ACTIVE = 0;
    const IS_ACTIVE = 1;
    const IS_REJECT = 2;
    const IS_REVIVAL = 3;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="firstName", type="string")
     * @Assert\NotBlank()
     */
    protected $firstName;

    /**
     * @ORM\Column(name="lastName", type="string")
     * @Assert\NotBlank()
     */
    protected $lastName;

    /**
     * @var string
     * @ORM\Column(name="email", type="string")
     * @Assert\Regex("/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/")
     */
    protected $email;

    /**
     * @var \DateTime $date_validation
     *
     * @ORM\Column(name="licence", type="integer", nullable=true)
     */
    protected $licence;

    /**
     * @var \DateTime $birthday
     *
     * @ORM\Column(name="birthday", type="date", nullable=true)
     */
    protected $birthday;

    /**
     * @ORM\Column(name="gender", type="string", nullable=true)
     * @Assert\NotBlank()
     */
    protected $gender;

    /**
     * @ORM\Column(name="phone", type="string", nullable=true)
     * @Assert\Regex(
     *      pattern="/^(0[1-9][-.\s]?(\d{2}[-.\s]?){3}\d{2})$/",
     *      message="Ce numéro de téléphone n'est pas valide, il doit avoir les indicatifs 01 à 06 et 08 et il doit y avoir un .- ou un espace entre deux chiffres."
     * )
     */
    protected $phone;

    /**
     * @ORM\Column(name="address", type="string", nullable=true)
     * @Assert\NotBlank()
     */
    protected $address;

    /**
     * @ORM\Column(name="city", type="string", nullable=true)
     * @Assert\NotBlank()
     */
    protected $city;

    /**
     * @ORM\Column(name="zipCode", type="string", nullable=true)
     * @Assert\NotBlank()
     */
    protected $zipCode;

    /**
     * @var \DateTime $date_validation
     *
     * @ORM\Column(name="date_validation", type="datetime", nullable=true)
     */
    protected $dateValidation;

    /**
     * @var \DateTime $date_last_revival
     *
     * @ORM\Column(name="date_last_revival", type="datetime", nullable=true)
     */
    protected $dateLastRevival;

    /**
     * @var \DateTime $date_submission
     *
     * @ORM\Column(name="date_submission", type="datetime")
     */
    protected $dateSubmission;

    /**
     * @ORM\Column(name="is_valid", type="integer")
     */
    protected $isValid;

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
     * Set firstName
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set licence
     *
     * @param $licence
     */
    public function setLicence($licence)
    {
        $this->licence = $licence;
    }

    /**
     * Get licence
     *
     * @return string
     */
    public function getLicence()
    {
        return $this->licence;
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

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Set gender
     *
     * @param $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set address
     *
     * @param $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set zipCode
     *
     * @param $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set phone
     *
     * @param $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set date_validation
     *
     * @param \DateTime $dateValidation
     * @return User
     */
    public function setDateValidation($dateValidation)
    {
        $this->dateValidation = $dateValidation;

        return $this;
    }

    /**
     * Get date_validation
     *
     * @return \DateTime
     */
    public function getDateValidation()
    {
        return $this->dateValidation;
    }

    /**
     * Set date_submission
     *
     * @param \DateTime $dateSubmission
     * @return User
     */
    public function setDateSubmission($dateSubmission)
    {
        $this->dateSubmission = $dateSubmission;

        return $this;
    }

    /**
     * Get date_submission
     *
     * @return \DateTime
     */
    public function getDateSubmission()
    {
        return $this->dateSubmission;
    }

    /**
     * Set $date_last_revival
     *
     * @param \DateTime $dateLastRevival
     * @return User
     */
    public function setDateLastRevival($dateLastRevival)
    {
        $this->dateLastRevival = $dateLastRevival;

        return $this;
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

    /**
     * Get $date_last_revival
     *
     * @return \DateTime
     */
    public function getDateLastRevival()
    {
        return $this->dateLastRevival;
    }

    public function getMatricule()
    {
        return 'ADH'.$this->dateValidation->format('Ymd').$this->id;
    }

}

