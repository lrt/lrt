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

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime $date_created
     *
     * @ORM\Column(name="date_created", type="datetime")
     */
    protected $dateCreated;

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
     * Set date_created
     *
     * @param \DateTime $dateCreated
     * @return User
     */
    public function setDateSubmission($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get date_created
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
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

    public function getStatus()
    {
        if ($this->enabled === true) {
            return 1;
        } else {
            return 0;
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

    public function getRolesName()
    {
        foreach ($this->roles as $role) {
            if ($role == 'ROLE_SUPERVISEUR') {
                return 'Superviseur';
            }
            if ($role == 'ROLE_MEMBER') {
                return 'Membre';
            }
            if ($role == 'ROLE_ADMIN') {
                return 'Administrateur';
            }
        }

        return 'inconnu';
    }
}