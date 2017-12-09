<?php
/**
 * Created by PhpStorm.
 * User: czaop
 * Date: 01.12.2017
 * Time: 21:11
 */

namespace FlightBundle\Flight;

class Flight
{
    /**
     * @var
     *
     * @return string
     */
    private $departure;

    /**
     * @var
     *
     * @return string
     */
    private $arrival;

    /**
     * @var
     *
     * @return \DateTime
     */
    private $departureTime;

    /**
     * @var
     *
     * @return \DateTime
     */
    private $arrivalTime;

    /**
     * @var
     *
     * @return array
     */
    private $price;

    /**
     * @var
     *
     * @return array
     */
    private $otherDays;
    /**
     * @var
     *
     * @return string
     */
    private $flightNumber;

    /**
     * @return mixed
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     * @param mixed $departure
     */
    public function setDeparture($departure)
    {
        $this->departure = $departure;
    }

    /**
     * @return mixed
     */
    public function getArrival()
    {
        return $this->arrival;
    }

    /**
     * @param mixed $arrival
     */
    public function setArrival($arrival)
    {
        $this->arrival = $arrival;
    }

    /**
     * @return mixed
     */
    public function getDepartureTime()
    {
        return $this->departureTime->format('H:i');
    }

    /**
     * @param mixed $departureTime
     */
    public function setDepartureTime($departureTime)
    {
        $this->departureTime = $departureTime;
    }

    /**
     * @return mixed
     */
    public function getArrivalTime()
    {
        return $this->arrivalTime->format('H:i');
    }

    /**
     * @param mixed $arrivalTime
     */
    public function setArrivalTime($arrivalTime)
    {
        $this->arrivalTime = $arrivalTime;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getOtherDays()
    {
        return $this->otherDays;
    }

    /**
     * @param mixed $otherDays
     */
    public function setOtherDays($otherDays)
    {
        $this->otherDays = $otherDays;
    }

    /**
     * @return mixed
     */
    public function getFlightNumber()
    {
        return $this->flightNumber;
    }

    /**
     * @param mixed $flightNumber
     */
    public function setFlightNumber($flightNumber)
    {
        $this->flightNumber = $flightNumber;
    }



}