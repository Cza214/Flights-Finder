<?php

namespace FlightBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use FlightBundle\Entity\History;
use FlightBundle\Flight\WizzAir;
use FlightBundle\Flight\Ryanair;
use FlightBundle\Flight\EasyJet;
use FlightBundle\Flight\Query;
use FlightBundle\Entity\User;

/**
 * Class FlightController
 * @package FlightBundle\Controller
 * @Route("/flight")
 */
class FlightController extends Controller
{
    /**
     * Find flights for parameters
     *
     * @Route("/{departure}/{arrival}/{date}/")
     */
    public function flightAction($departure, $arrival, $date){
        $flights = [];
        $dateBack = '';

        $flights['departure'] = $this->prepareConnect($departure,$arrival,$date);
        $favorite = $this->getFavorite($departure,$arrival);

        $returnArguments = [
            'flights' => $flights,
            'date' => $date,
            'dateBack' => $dateBack,
            'status' => $favorite
        ];

        dump($favorite);
        return $this->render('FlightBundle:Flight:flight_content.html.twig',$returnArguments);
    }
    /**
     * Find flights with return for parameters
     *
     * @Route("/{departure}/{arrival}/{date}/{return}")
     */
    public function flightReturnAction($departure, $arrival, $date, $return){
        $flights = [];
        $dateBack = $return;

        $flights['departure'] = $this->prepareConnect($departure,$arrival,$date);
        $flights['arrival'] = $this->prepareConnect($arrival,$departure,$return);

        $favorite = $this->getFavorite($departure,$arrival);

        $returnArguments = [
            'flights' => $flights,
            'date' => $date,
            'dateBack' => $dateBack,
            'status' => $favorite
        ];

        return $this->render('FlightBundle:Flight:flight_content.html.twig',$returnArguments);
    }

    /**
     * Prepare connect
     *
     * @param $departure
     * @param $arrival
     * @param $date
     * @return array
     */
    private function prepareConnect($departure,$arrival,$date){

        $flights = [];

        $user = $this->getUser();

        if($user !== null){
            $em = $this->getDoctrine()->getManager();

            $history = new History();
            $history->setDeparture($departure);
            $history->setArrival($arrival);
            $history->setDate(new \DateTime($date));
            $history->setUser($user);

            dump($history);
            $em->persist($history);
            $em->flush();
        }

        $wizzair = new WizzAir($departure,$arrival,$date);
        $easyjet = new EasyJet($departure,$arrival,$date);
        $ryanair = new Ryanair($departure,$arrival,$date);

        $flights = Query::getConnectAll(array($ryanair,$easyjet,$wizzair));
        $flights = array_merge(...$flights);

        return $flights;
    }

    /**
     * Return favorite row for logged user
     *
     * @param $departure
     * @param $arrival
     * @return object
     * @Security("has_role('ROLE_USER')")
     */
    private function getFavorite($departure,$arrival){

        $em = $this->getDoctrine()->getManager();
        $favoritesRepository = $em->getRepository('FlightBundle:Favorites');
        $favorites = $favoritesRepository->findOneBy([
                'user' => $this->getUser(),
                'departure' => $departure,
                'arrival' => $arrival
            ]);
        return $favorites;
    }
}
