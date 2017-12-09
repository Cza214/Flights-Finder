<?php
/**
 * Created by PhpStorm.
 * User: czaop
 * Date: 02.12.2017
 * Time: 11:32
 */
namespace FlightBundle\Flight;

class WizzAir implements Airline
{
    private $departure;
    private $arrival;
    private $data;
    private $uri = "";
    private $url = "https://be.wizzair.com/7.6.4/Api/search/search";
    private $method = "POST";

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
     * CONVERTING JSON TO ARRAY OF FLIGHT
     *
     * @param $body
     * @return array
     */
    public function convertToArray($body){

        $data = json_decode($body);
        $data = $data->outboundFlights;

        $flights = [];

        foreach($data as $value){
            $flight = new Flight();
            $flight->setDeparture($value->departureStation);
            $flight->setArrival($value->arrivalStation);
            $flight->setFlightNumber($value->carrierCode.$value->flightNumber);
            $flight->setDepartureTime(new \DateTime($value->departureDateTime));
            $flight->setArrivalTime(new \DateTime($value->arrivalDateTime));
            $flight->setPrice($value->fares[3]->basePrice->amount);
            $flights[] = $flight;
        }
        return $flights;

    }

    /** DATA FOR CONNECT */

    public function getQueryData(){
        return '';
    }
    public function getQueryDataJson()
    {
        return [
            'isFlightChange' => false,
            'isSeniorOrStudent' => false,
            'flightList' => [
                [
                    'departureStation' => $this->departure,
                    'arrivalStation' => $this->arrival,
                    'departureDate' => $this->data
                ]
            ],
            'adultCount'=>1,
            'childCount'=>0,
            'infantCount'=>0,
            'wdc'=>true,
            'rescueFareCode'=>'',
        ];
    }

    public function getQueryHeaders()
    {
        return [
            'Host' => 'be.wizzair.com',
            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0',
            'Accept' => 'application/json',
            'Accept-Language' => 'en-US,en;q=0.5',
            'Referer' => 'https://wizzair.com/pl-pl/main-page/',
            'Content-Type' => 'application/json',
            'Origin' => 'https://wizzair.com',
            'Connection' => 'keep-alive'
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