<?php
/**
 * Created by PhpStorm.
 * User: czaop
 * Date: 02.12.2017
 * Time: 11:32
 */
namespace FlightBundle\Flight;

class Ryanair implements Airline
{
    private $departure;
    private $arrival;
    private $data;
    private $uri = "https://desktopapps.ryanair.com";
    private $url = "/v4/pl-pl/availability?";
    private $method = "GET";

    /**
     * ARyanair constructor.
     * @param $from
     * @param $to
     * @param $data
     */
    public function __construct($from,$to,$data)
    {
        $this->departure = $from;
        $this->arrival = $to;
        $this->data = $data;
    }

        // Convert JSON to Array of Flights

    /**
     *  CONVERTING JSON TO ARRAY OF FLIGHT
     *
     * @param $body
     * @return array
     */
    public function convertToArray($body){

        $data = json_decode($body);
        $data = $data->trips[0];

        $flights = [];

        foreach($data->dates as $key => $value){
            foreach($value->flights as $key2 => $value2){

                $flight = new Flight();

                $flight->setDeparture($value2->segments[0]->origin);
                $flight->setArrival($value2->segments[0]->destination);
                $flight->setDepartureTime(new \DateTime($value2->segments[0]->time[0]));
                $flight->setArrivalTime(new \DateTime($value2->segments[0]->time[1]));
                $flight->setFlightNumber($value2->segments[0]->flightNumber);
                $flight->setPrice($value2->regularFare->fares[0]->amount);

                $flights[] = $flight;
            }
        }

        return $flights;

    }

    /** DATA FOR CONNECT */

    public function getQueryDataJson(){
        return '';
    }
    /**
     * @return array
     */
    public function getQueryData()
    {
        return [
            'ADT' => 1,
            'CHD' => 0,
            'DateOut' => $this->data,
            'Destination' => $this->arrival,
            'FlexDaysOut' => 0,
            'INF' => 0,
            'IncludeConnectingFlights' => 'true',
            'Origin' => $this->departure,
            'RoundTrip' => 'false',
            'TEEN' => 0,
            'ToUs' => 'AGREED',
            'exists' => 'false',
            'promoCode' => ''
        ];
    }

    /**
     * @return array
     */
    public function getQueryHeaders()
    {
        return [
            'Accept' => 'application/json, text/plain, */*',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Accept-Language' => 'pl-PL,pl;q=0.9,en-US;q=0.8,en;q=0.7',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'Cookie' => 'AMCV_64456A9C54FA26ED0A4C98A5%40AdobeOrg=-894706358%7CMCIDTS%7C17494%7CMCMID%7C21043351462731338710464276822517415641%7CMCAAMLH-1511870793%7C6%7CMCAAMB-1512125459%7CRKhpRz8krg2tLO6pguXWp5olkAcUniQYPHaMWWgdJ3xzPWQmdj0y%7CMCOPTOUT-1511527859s%7CNONE%7CMCSYNCSOP%7C411-17499%7CMCAID%7CNONE%7CvVersion%7C2.3.0; s_nr2=1511521496117-Repeat; RYANSESSION=WipNDAolAvQAAFbzSzgAAAAi; mbox=PC#bab56241f6ea4e16916027df76fd70c2.26_31#1574510796|session#db9be40ec52e442f8cc875283938c64d#1512723539; check=true',
            'Host' => 'desktopapps.ryanair.com',
            'Origin' => 'https://www.ryanair.com',
            'Pragma' => 'no-cache',
            'Referer' => 'https://www.ryanair.com/ie/en/booking/home',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36'
        ];
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $departure
     */
    public function setDeparture($departure)
    {
        $this->departure = $departure;
    }

    /**
     * @param mixed $arrival
     */
    public function setArrival($arrival)
    {
        $this->arrival = $arrival;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }



}