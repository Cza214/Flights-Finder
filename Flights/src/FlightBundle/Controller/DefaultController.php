<?php

namespace FlightBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('FlightBundle:Flight:flight_form_content.html.twig',['dep' => '', 'arr' => '']);
    }
}
