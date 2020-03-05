<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Smi
 *
 * @ORM\Table(name="smi",
 *     options={"collate":"utf8mb4_general_ci", "charset":"utf8mb4", "engine":"InnoDB"})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SmiRepository")
 */
class Smi
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
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="owner", type="string", length=255)
     */
    private $owner;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="string", length=512, nullable=true)
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="head", type="string", length=255, nullable=true)
     */
    private $head;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", nullable=true)
     */
    private $tel;

    /**
     * @var int
     *
     * @ORM\Column(name="unp", type="integer", unique=true)
     */
    private $unp;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    private $region;

    /**
     * One smi has many users. This is the inverse side.
     * @ORM\OneToMany(targetEntity="User", mappedBy="smi")
     */
    private $users;

    public function __construct() {
        $this->users = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Smi
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set owner
     *
     * @param string $owner
     *
     * @return Smi
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @return string
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getHead(): ?string
    {
        return $this->head;
    }

    /**
     * @param string $head
     */
    public function setHead(string $head): void
    {
        $this->head = $head;
    }

    /**
     * @return string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getTel(): ?string
    {
        return $this->tel;
    }

    /**
     * @param string $tel
     */
    public function setTel(string $tel): void
    {
        $this->tel = $tel;
    }

    /**
     * Set unp
     *
     * @param integer $unp
     *
     * @return Smi
     */
    public function setUnp($unp)
    {
        $this->unp = $unp;

        return $this;
    }

    /**
     * Get unp
     *
     * @return int
     */
    public function getUnp()
    {
        return $this->unp;
    }

    /**
     * Set region
     *
     * @param integer $region
     *
     * @return Smi
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
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}

