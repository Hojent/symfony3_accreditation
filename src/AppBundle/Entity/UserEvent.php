<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="user_event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserEventRepository")
 */
class UserEvent
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(name="event_id", type="integer")
     */
    private $eventId;

    /**
     * @var int
     * @ORM\Column(name="status", type="integer", options={"default":0} )
     */
    private $status;

    /**
     * no timezone
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    public function __construct($userId, $eventId)
    {
        $this->date = new \DateTime();
        $this->userId = $userId;
        $this->eventId = $eventId;

    }


    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Get eventId
     *
     * @return int
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function __toString()
    {
       return $this->getDate();
    }

}

