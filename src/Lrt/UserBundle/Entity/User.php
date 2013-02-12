<?php

/**
 * @category Entity
 * @package
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Lrt\UserBundle\Repository\UserRepository")
 * @ORM\Table(name="fos_user")
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 */
class User extends BaseUser
{
    const IS_NOT_ACTIVE = 0;
    const IS_ACTIVE = 1;
    const IS_NEW_ADHESION = 2;

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
     *      pattern="((0[0-68]([-.\s]?\d{2}){4}))",
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
     * @ORM\Column(name="is_adhesion", type="integer")
     */
    protected $isAdhesion;

    /**
     * @var string
     */
    protected $username;

    /**
     * Plain password. Used for model validation. Must not be persisted.
     * @Assert\Regex(pattern="((?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,20})", message="Ce mot de passe n'est pas valide, il doit contenir 8 carractères dont lettres majuscules, lettres minuscules, chiffres et caractères spéciaux.")
     * @var string
     */
    protected $plainPassword;

    /**
     * @var string
     * @Assert\Regex("/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/")
     */
    protected $email;

    /**
     * @ORM\ManyToMany(targetEntity="Lrt\UserBundle\Entity\Group", inversedBy="users")
     * @ORM\JoinTable(name="fos_user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * @ORM\ManyToMany(targetEntity="Lrt\SiteBundle\Entity\Event", inversedBy="users")
     * @ORM\JoinTable(name="user_event",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="event_id", referencedColumnName="id")}
     * )
     */
    protected $events;

    /**
     * @ORM\OneToMany(targetEntity="Lrt\SiteBundle\Entity\Activity", mappedBy="user")
     */
    protected $request;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->events = new ArrayCollection();
        parent::__construct();
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
     * Get $date_last_revival
     *
     * @return \DateTime
     */
    public function getDateLastRevival()
    {
        return $this->dateLastRevival;
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
     * Get date_validation
     *
     * @return \DateTime
     */
    public function getDateValidation()
    {
        return $this->dateValidation;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->firstName.' '.$this->lastName;
    }

    /**
     * Get sites
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set is_adhesion
     *
     * @param integer $isAdhesion
     */
    public function setIsAdhesion($isAdhesion)
    {
        $this->isAdhesion = $isAdhesion;
    }

    /**
     * Get is_adhesion
     *
     * @return integer
     */
    public function getIsAdhesion()
    {
        return $this->isAdhesion;
    }

    /**
     * Add request
     *
     * @param \Lrt\SiteBundle\Entity\Activity $request
     * @return User
     */
    public function addRequest(\Lrt\SiteBundle\Entity\Activity $request)
    {
        $this->request[] = $request;

        return $this;
    }

    /**
     * Remove request
     *
     * @param \Lrt\SiteBundle\Entity\Activity $request
     */
    public function removeRequest(\Lrt\SiteBundle\Entity\Activity $request)
    {
        $this->request->removeElement($request);
    }

    public function getStatus() {
        if($this->enabled === true) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getUserRoles()
    {
        foreach ($this->roles as $role) {
            if ($role == 'ROLE_MEMBER') {
                return 'Membre';
            }
            if ($role == 'ROLE_SUPERVISEUR') {
                return 'Superviseur';
            }
        }
    }

    public function resetGroups()
    {
        $this->groups = array();
    }

    /**
     * Add events
     *
     * @param \Lrt\SiteBundle\Entity\Event $events
     * @return \Lrt\SiteBundle\Entity\Event
     */
    public function addEvent(\Lrt\SiteBundle\Entity\Event $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param \Lrt\SiteBundle\Entity\Event $events
     */
    public function removeEvent(\Lrt\SiteBundle\Entity\Event $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    public function getReferenceUser()
    {
        return 'M' . $this->dateValidation->format('Ymd') . $this->id;
    }
}