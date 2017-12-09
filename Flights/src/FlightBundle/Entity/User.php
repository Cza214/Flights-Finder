<?php

namespace FlightBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="FlightBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="History", mappedBy="user")
     */
    private $history;

    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="Favorites", mappedBy="user")
     */
    private $favorites;

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
        parent::__construct();
        $this->history = new ArrayCollection();
    }

    /**
     * Add history
     *
     * @param \FlightBundle\Entity\History $history
     *
     * @return User
     */
    public function addHistory(\FlightBundle\Entity\History $history)
    {
        $this->history[] = $history;

        return $this;
    }

    /**
     * Remove history
     *
     * @param \FlightBundle\Entity\History $history
     */
    public function removeHistory(\FlightBundle\Entity\History $history)
    {
        $this->history->removeElement($history);
    }

    /**
     * Get history
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * Add favorite
     *
     * @param \FlightBundle\Entity\Favorites $favorite
     *
     * @return User
     */
    public function addFavorite(\FlightBundle\Entity\Favorites $favorite)
    {
        $this->favorites[] = $favorite;

        return $this;
    }

    /**
     * Remove favorite
     *
     * @param \FlightBundle\Entity\Favorites $favorite
     */
    public function removeFavorite(\FlightBundle\Entity\Favorites $favorite)
    {
        $this->favorites->removeElement($favorite);
    }

    /**
     * Get favorites
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFavorites()
    {
        return $this->favorites;
    }
}
