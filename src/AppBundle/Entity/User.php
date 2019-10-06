<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser ;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToMany;
use AppBundle\Entity\Event as Event;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(fields="username", message="Username already taken")
 *
 */
class User extends BaseUser implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * One User has One UserProfile.
     * @ORM\OneToOne(targetEntity="UserProfile", mappedBy="user", cascade="persist")
     * @ORM\JoinColumn(name="userprofile_id", referencedColumnName="id")
     */
    private $userprofile;

    /**
     * Many Users have Many Events.
     * @ORM\ManyToMany(targetEntity="Event", inversedBy="users")
     * @ORM\JoinTable(name="user_event")
     */
    private $events;

    /**
     * @ORM\ManyToOne(targetEntity="Smi", inversedBy="users")
     * @ORM\JoinColumn(name="smi_id", referencedColumnName="id")
     */
    private $smi;

     /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    protected $isActive;

    public function __construct()
    {
        parent::__construct();
        $this->isActive = true;
        $this->roles = ['ROLE_USER'];
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));
        $this->events = new ArrayCollection();
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        // guarantees that a user always has at least one role for security
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getSalt()
    {
        // The bcrypt and argon2i algorithms don't require a separate salt.
        // You *may* need a real salt if you choose a different encoder.
        return null;
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ]);
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    /**
     * Set smi
     * @param integer $smi
     * @return UserProfile
     */
    public function setSmi($smi)
    {
        $this->smi = $smi;

        return $this;
    }

    /**
     * Get smi
     * @return int
     */
    public function getSmi()
    {
        return $this->smi;
    }

    /**
     * @param mixed $userprofile
     */
    public function setUserprofile($userprofile): void
    {
        $this->userprofile = $userprofile;
    }

    /**
     * @return mixed
     */
    public function getUserprofile()
    {
        return $this->userprofile;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }
    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
        }
        return $this;
    }
    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
        }
        return $this;
    }
}