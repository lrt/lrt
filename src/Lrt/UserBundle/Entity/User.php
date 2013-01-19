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
use Lrt\CMSBundle\Entity\Content;

/**
 * @ORM\Entity(repositoryClass="Lrt\UserBundle\Repository\UserRepository")
 * @ORM\Table(name="membre")
 */
class User extends BaseUser
{
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
     * @ORM\OneToMany(targetEntity="\Lrt\CMSBundle\Entity\Content", mappedBy="user")
     */
    protected $content;

    /**
     * @ORM\OneToMany(targetEntity="\Lrt\SiteBundle\Entity\Partner", mappedBy="user")
     */
    protected $partners;

    /**
     * @ORM\OneToMany(targetEntity="\Lrt\VideoBundle\Entity\Video", mappedBy="user")
     */
    protected $videos;

    /**
     * @ORM\ManyToOne(targetEntity="\Lrt\TeamBundle\Entity\Team")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $team;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
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
        $this->firstName.' '.$this->lastName;
    }

    /**
     * Add content
     *
     * @param \Lrt\CMSBundle\Entity\Content $content
     * @return void
     */
    public function addContent(\Lrt\CMSBundle\Entity\Content $content)
    {
        $this->content[] = $content;
    }

    /**
     * Get content
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Add partner
     *
     * @param \Lrt\SiteBundle\Entity\Partner $partner
     * @return void
     */
    public function addPartners(\Lrt\SiteBundle\Entity\Partner $partner)
    {
        $this->partners[] = $partner;
    }

    /**
     * Get partner
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPartners()
    {
        return $this->partners;
    }

    /**
     * Add videos
     *
     * @param \Lrt\VideoBundle\Entity\Video $videos
     * @return void
     */
    public function addVideo(\Lrt\VideoBundle\Entity\Video $videos)
    {
        $this->videos[] = $videos;
    }

    /**
     * Get videos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVideos()
    {
        return $this->videos;
    }

    public function getStatus() {
        if($this->enabled === true) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Remove content
     *
     * @param \Lrt\CMSBundle\Entity\Content $content
     */
    public function removeContent(\Lrt\CMSBundle\Entity\Content $content)
    {
        $this->content->removeElement($content);
    }

    /**
     * Remove partner
     *
     * @param \Lrt\SiteBundle\Entity\Partner $partner
     */
    public function removePartner(\Lrt\SiteBundle\Entity\Partner $partner)
    {
        $this->content->removeElement($partner);
    }

    /**
     * Remove videos
     *
     * @param \Lrt\VideoBundle\Entity\Video $videos
     */
    public function removeVideo(\Lrt\VideoBundle\Entity\Video $videos)
    {
        $this->videos->removeElement($videos);
    }

    /**
     * Set team
     *
     * @param \Lrt\TeamBundle\Entity\Team $team
     * @return User
     */
    public function setTeam(\Lrt\TeamBundle\Entity\Team $team = null)
    {
        $this->team = $team;
    
        return $this;
    }

    /**
     * Get team
     *
     * @return \Lrt\TeamBundle\Entity\Team
     */
    public function getTeam()
    {
        return $this->team;
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
}