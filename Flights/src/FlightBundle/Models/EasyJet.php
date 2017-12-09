<?php
/**
 * Created by PhpStorm.
 * User: czaop
 * Date: 02.12.2017
 * Time: 11:32
 */
namespace FlightBundle\Flight;

class EasyJet implements Airline
{
    private $departure;
    private $arrival;
    private $data;
    private $uri = "https://www.easyjet.com";
    private $url = "/ejavailability/api/v14/availability/query?";
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



    /**
     *  CONVERTING JSON TO ARRAY OF FLIGHT
     *
     * @param $body
     * @return array
     */
    public function convertToArray($body){

        $data = json_decode($body);
        $data = $data->AvailableFlights;

        $flights = [];

        foreach ($data as $key => $value)
        {
            $flight = new Flight();
            $flight->setFlightNumber('U2'.$value->FlightNumber);
            $flight->setDeparture($value->DepartureIata);
            $flight->setArrival($value->ArrivalIata);
            $flight->setDepartureTime(new \DateTime($value->LocalDepartureTime));
            $flight->setArrivalTime(new \DateTime($value->LocalArrivalTime));
            $flight->setPrice($value->FlightFares[0]->Prices->Adult->PriceWithDebitCard);
            $flights[] = $flight;
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
            "AdditionalSeats" => "0",
            "AdultSeats" => "1",
            "ArrivalIata" => $this->arrival,
            "ChildSeats" => "0",
            "DepartureIata" => $this->departure,
            "IncludeFlexiFares" => "false",
            "IncludeLowestFareSeats" => "true",
            "IncludePrices" => "true",
            "Infants" => "0",
            "IsTransfer" => "false",
            "LanguageCode" => "PL",
            "MaxDepartureDate" => $this->data,
            "MinDepartureDate" => $this->data
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
            'Cookie' => 'labi=e044d7fc-7d6b-9ee8-b804-652e4ef51906; VisitorRecognition=gid=4be6f490-6c8b-4889-8cdb-b627c71f52bd&mid=0&usl=; ejCC_3=v=5038992936669620678&i=-8586900010327792702; ak_bmsc=CC76AC776B638AFA6792B7E9CD01A9D002163473D3050000D07E2A5A05E0342A~plt3kP8Ol+o9o+5gHNr+3enz9KU8xnb8yTHngKjfnnO4vueFKsyNzTuInnkXm63wSSOaVWcjIKf5PiDy4o+hSHiIgZiaf1KUk6ZOsuu5HtjoHJVQnnBJetDMt4LZyE9+VSWRZFqBs1dSpvI7fmEEFamQcOxIM2RdKyyzkAZObGch0VLCJ9QDYLujT1zQJQhVqPDKWEJA1Tiirt7bklv1tHgZdx9AsmxubF4T79l0A+lsY=; bm_sz=90670A84056BF4821398C736A07D067A~QAAQczQWAkqVKxVgAQAA68tUNoyG3arYnYdYPvdhcnlLuvMWuToMSsZ/HAfqpADnO4kZ3Gi80wDmxpTyjfGOM9CXIgrGZkNP2LYp0QcnWypB7hYK3rV5ZM7F/DSOaU1UxYyYUlYkJBSZr4tW/IJpiE7pHNRSuVO84hT6gZicASgRsfZ18sREnxSAZAqTPBFG; _gat=1; lang2012=pl-pl; idb*=%7B%22departure%22%3Anull%2C%22when%22%3Anull%2C%22flag%22%3Anull%2C%22price%22%3Anull%2C%22destination%22%3Anull%2C%22fromDate%22%3Anull%2C%22toDate%22%3Anull%2C%22customDate%22%3Anull%2C%22mapLocation%22%3Anull%2C%22moveMap%22%3Anull%2C%22region%22%3A%22pl-pl%22%7D; _abck=B2D4168514143F11CAA88EA62DF1345802163464546900005B46195AEFA4DF7A~0~WF0F23e6ZU/wWb+PlKe9ZjFIsvoeDrpkn+tH9OVA1AQ=~-1~-1; FunnelQuery=%7b%22OriginIata%22%3a%22KRK%22%2c%22DestinationIata%22%3a%22CDG%22%2c%22OutboundDate%22%3a%222017-12-19%22%2c%22ReturnDate%22%3anull%2c%22OutboundFlightNumber%22%3anull%2c%22ReturnFlightNumber%22%3anull%2c%22NumberOfAdults%22%3a1%2c%22NumberOfChildren%22%3a0%2c%22NumberOfInfants%22%3a0%2c%22OpenSearchPanel%22%3afalse%2c%22ShowFlexiFares%22%3afalse%2c%22RemainOnStep1%22%3afalse%2c%22ComponentSender%22%3a%22SearchPod2_%2fpl%2f%22%2c%22CurrencyCode%22%3anull%2c%22PaymentTypeCode%22%3anull%7d; AVLPOD=dub-avl-green; AVLPODV=exp=1512743628~acl=*~data=dub-avl-green~hmac=3c0543176b74eff971471b25017da064425ee4b4b903111fc740a0cd32be65b9; bm_mi=1E0D8D72B5323BB809A4EB0AC0CD3451~9wTVwnEHysIhFq0QmIMOxT8OYr4lK7cFDHTpvRjeyNGpTUQzqDfLlODuo8ZNAuM704pvUuIjnGT8NOaHN6Q21NQbLxOMHbSTyxEAQve2mr/AIUEXe50A8AbSiE53jNfGPABCTO1NWxcUe2VEroAfV7MGRUqnITIhUQJwmDDdtWSR5mPSFeaytSTdHFvXnoNm9KWQtbKoAzTT7lCh+1ig1gZzAzXfYOeL8LCKX2SQZgym3eOAimmr3mvb4/ZLmL4I2MGaKSR2cVi+qkAbrqfhClL1k0r/SkRKGKF898EauOs=; _ga=GA1.3.393194525.1511605852; _gid=GA1.3.524171603.1512722081; cookies.js=1; odb*=KRK; ej20SearchCookie=ej20Search_0=KRK|CDG|2017-12-19T00:00:00||1|0|0|False||0|2017-12-08 13:34:35Z; ej20RecentSearches=ej20RecentSearch_0=KRK|CDG|2017-12-19T00:00:00||1|0|0|False||0|2017-12-08 13:34:35Z&ej20RecentSearch_1=KRK|BRS|2017-12-22T00:00:00||1|0|0|False||1|2017-12-08 12:00:27Z&ej20RecentSearch_2=KRK|CDG|2017-12-29T00:00:00||1|0|0|False||2|2017-12-08 08:35:07Z&ej20RecentSearch_3=KRK|LGW|2017-12-19T00:00:00||1|0|0|False||3|2017-12-04 14:05:31Z; FunnelJourney=%7B%22CorrelationToken%22%3A%2209A84DAE-0441-5301-D80D-34D98D70E550%22%2C%22PaymentType%22%3Anull%2C%22Origin%22%3A%22KRK%22%2C%22Destination%22%3A%22CDG%22%2C%22Outbound%22%3A%222017-12-19%22%2C%22Return%22%3Anull%2C%22Component%22%3A%22SearchPod2_%2Fpl%2F%22%2C%22SearchPanelOpen%22%3Afalse%2C%22FlexiFares%22%3Afalse%2C%22Adults%22%3A1%2C%22Children%22%3A0%2C%22Infants%22%3A0%2C%22JourneyPairId%22%3A1%2C%22CarSearchQuery%22%3Anull%2C%22Pairs%22%3A%5B%5D%7D; CMSPOD=fra-sc2-green; CMSPODV=exp=1512743673~acl=*~data=fra-sc2-green~hmac=d7eb29a552abc9803a07a27b9d692e086937eac74c4e2ed052dd5121899c8456; bm_sv=A5EA900F561D2394A8E4028289A5DE65~syYu3gWyKfoywMw/lZMYrmr2HkvliB6tI5CG3vRuBxvq6BW04Y9oCAdLMdAkR0XBrObo2GGqRKJ71XuJnLctmeB0tvzyJHHwFMNuk/VEI9Slo056f9kDYzkE0mvGwW8Uy4UZMsipCz45yY1IFONKn8MoIAxrAcVPWyeGUXtLVvg=; RBKPOD=dub-rbk-green; RBKPODV=exp=1512743673~acl=*~data=dub-rbk-green~hmac=ee73767c40c2323d882698c5a4adb95c13b50c5a1fb23244c94d296f34050634; akacd_TrueClarity_SC=1513344873~rv=78~id=57cff3aed7e16b4177d7c4797dc2ef5e',
            'Host' => 'www.easyjet.com',
            'Pragma' => 'no-cache',
            'Referer' => 'https://www.easyjet.com/pl/buy/flights?isOneWay=on&pid=www.easyjet.com',
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