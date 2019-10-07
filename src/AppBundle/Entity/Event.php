<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;




/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
 */
class Event
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var text
     * @ORM\Column(name="brief", type="text", nullable=true)
     */
    private $brief;

    /**
     * @var text
     * @ORM\Column(name="organizator", type="text", nullable=true)
     */
    private $organizator;

    /**
     * timezone
     * @var string
     * @ORM\Column(name="data_start", type="string", nullable=true)
     */
    private $dataStart;

    /**
     * timezone
     * @var string
     * @ORM\Column(name="data_end", type="string", nullable=true)
     */
    private $dataEnd;

    /**
     * no timezone
     * @var \DateTime
     * @ORM\Column(name="data_created", type="datetime")
     */
    private $dataCreated;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    private $region;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="City")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    private $city;

    /**
     * @var string
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Evtip")
     * @ORM\JoinColumn(name="evtip_id", referencedColumnName="id")
     */
    private $evtip;

    /**
     * Many Events have Many Users.
     * @ORM\ManyToMany(targetEntity="User", mappedBy="events")
     */
    private $users;

    public function __construct()
    {
        $this->dataCreated = new \DateTime();
        $this->users = new ArrayCollection();
    }

    /**
     * Get id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     * @param string $title
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set brief
     * @param text $brief
     * @return Event
     */
    public function setBrief($brief)
    {
        $this->brief = $brief;

        return $this;
    }

    /**
     * Get brief
     *
     * @return text
     */
    public function getBrief()
    {
        return $this->brief;
    }

    /**
     * @return text
     */
    public function getOrganizator()
    {
        return $this->organizator;
    }

    /**
     * @param text $organizator
     * @return Event
     */
    public function setOrganizator($organizator)
    {
        $this->organizator = $organizator;
    }

    /**
     * Set dataStart
     * @param \DateTime $dataStart
     * @return Event
     */
    public function setDataStart($dataStart)
    {
        $this->dataStart = $dataStart;

        return $this;
    }

    /**
     * Get dataStart
     *
     * @return \DateTime
     */
    public function getDataStart()
    {
        return $this->dataStart;
    }


    /**
     * Set dataEnd
     *
     * @param \DateTime $dataEnd
     *
     * @return Event
     */
    public function setDataEnd($dataEnd)
    {
        $this->dataEnd = $dataEnd;

        return $this;
    }

    /**
     * Get dataEnd
     *
     * @return \DateTime
     */
    public function getDataEnd()
    {
        return $this->dataEnd;
    }

    /**
     * Set dataCreated
     *
     * @param \DateTime $dataCreated
     *
     * @return Event
     */
    public function setDataCreated($dataCreated)
    {
        $this->dataCreated = $dataCreated;

        return $this;
    }

    /**
     * Get dataCreated
     *
     * @return \DateTime
     */
    public function getDataCreated()
    {
        return $this->dataCreated;
    }

    /**
     * Set region
     *
     * @param integer $region
     *
     * @return Event
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return int
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set city
     *
     * @param integer $city
     *
     * @return Event
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return int
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Get address
     * @return string
     */
    public function getAddress ()
    {
        return $this->address;
    }

    /**
     * @param $address string
     * @return Event
     */
    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

    /**
     * Set evtip
     *
     * @param integer $evtip
     *
     * @return Event
     */
    public function setEvtip($evtip)
    {
        $this->evtip = $evtip;

        return $this;
    }

    /**
     * Get evtip
     *
     * @return int
     */
    public function getEvtip()
    {
        return $this->evtip;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addEvent($this);
        }
        return $this;
    }
    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeEvent($this);
        }
        return $this;
    }
}

