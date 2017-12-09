<?php

namespace FlightBundle\Flight;
/**
 * Created by PhpStorm.
 * User: czaop
 * Date: 03.12.2017
 * Time: 17:05
 */
interface Airline{

    public function getQueryData();
    public function getQueryDataJson();
    public function getQueryHeaders();
    public function getUri();
    public function getMethod();
    public function getUrl();

}