<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Smi
 *
 * @ORM\Table(name="smi")
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
     * @var int
     *
     * @ORM\Column(name="unp", type="integer", unique=true)
     */
    private $unp;

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
}

