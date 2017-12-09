<?php
/**
 * Created by PhpStorm.
 * User: czaop
 * Date: 01.12.2017
 * Time: 22:12
 */

namespace FlightBundle\Flight;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Query
{
    // Connect API and return flights for The Airline
    /**
     *
     * @return array
     */
    public static function getConnect(Airline $airline){

        $flights = [];

        $method = $airline->getMethod();
        $base_uri = $airline->getUri();
        $url = $airline->getUrl();
        $queryData = $airline->getQueryData();
        $queryHeaders = $airline->getQueryHeaders();
        $queryDataJson = $airline->getQueryDataJson();

        $client = new Client(
            ['base_uri' => $base_uri]
        );

        try {
            $result = $client->request($method,$url,[
                'query' => $queryData,
                'headers' => $queryHeaders,
                'json' => $queryDataJson
            ]);
            dump($result);
        } catch (ClientException $e){
            return array();
        }

        // Convert JSON body to Array of Flights
        $flights = $airline->convertToArray($result->getBody());

        return $flights;
    }
    // Connect for all airlines

    public static function getConnectAll(array $flights){
        $allFlights = [];

        foreach($flights as $flight){
            $allFlights[] = self::getConnect($flight);
        }

        return $allFlights;
    }
}