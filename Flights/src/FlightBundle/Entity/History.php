<?php

namespace FlightBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * History
 *
 * @ORM\Table(name="history")
 * @ORM\Entity(repositoryClass="FlightBundle\Repository\HistoryRepository")
 */
class History
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
     * @ORM\Column(name="departure", type="string", length=100)
     */
    private $departure;

    /**
     * @var string
     *
     * @ORM\Column(name="arrival", type="string", length=100)
     */
    private $arrival;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;
    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="history")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    /**
     * Set departure
     *
     * @param string $departure
     *
     * @return History
     */
    public function setDeparture($departure)
    {
        $this->departure = $departure;

        return $this;
    }

    /**
     * Get departure
     *
     * @return string
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     * Set arrival
     *
     * @param string $arrival
     *
     * @return History
     */
    public function setArrival($arrival)
    {
        $this->arrival = $arrival;

        return $this;
    }

    /**
     * Get arrival
     *
     * @return string
     */
    public function getArrival()
    {
        return $this->arrival;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return History
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set user
     *
     * @param \FlightBundle\Entity\User $user
     *
     * @return History
     */
    public function setUser(\FlightBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \FlightBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
