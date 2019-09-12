<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     * @ORM\Column(name="brief", type="string", length=255, nullable=true)
     */
    private $brief;

    /**
     * timezone
     * @var \DateTime
     * @ORM\Column(name="data_start", type="datetimetz", nullable=true)
     */
    private $dataStart;

    /**
     * timezone
     * @var \DateTime
     * @ORM\Column(name="data_end", type="datetimetz", nullable=true)
     */
    private $dataEnd;

    /**
     * no timezone
     * @var \DateTime
     * @ORM\Column(name="data_created", type="datetime")
     */
    private $dataCreated;

    public function __construct()
    {
        $this->dataCreated = new \DateTime();
    }

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
     * @var int
     * @ORM\ManyToOne(targetEntity="Evtip")
     * @ORM\JoinColumn(name="evtip_id", referencedColumnName="id")
     */
    private $evtip;

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
     * @param string $brief
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
     * @return string
     */
    public function getBrief()
    {
        return $this->brief;
    }

    /**
     * Set dataStart
     *
     * @param \DateTime $dataStart
     *
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
}

