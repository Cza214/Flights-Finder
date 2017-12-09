<?php

namespace FlightBundle\Controller;

use FlightBundle\Entity\Favorites;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Favorite controller.
 *
 * @Route("favorites")
 * @Security("has_role('ROLE_USER')");
 */
class FavoritesController extends Controller
{

    /**
     * Add new favorite record
     *
     * @Route("/new/{from}/{to}")
     */
    public function newAction(Request $req,$from,$to){

        $em = $this->getDoctrine()->getManager();

        $favorite = new Favorites();
        $favorite->setArrival($to);
        $favorite->setDeparture($from);
        $favorite->setUser($this->getUser());
        $em->remove($favorite);
        $em->persist($favorite);
        $em->flush();

        return $this->redirect($req->headers->get('referer'));
    }

    /**
     * Show all records by user
     *
     * @Route("/show")
     */
    public function showAction(){

        $em = $this->getDoctrine()->getManager();

        $favorites = $em->getRepository("FlightBundle:Favorites")->findBy([
          'user' => $this->getUser()
        ]);

        return $this->render('FlightBundle:Favorites:favorites_content.html.twig',['favorites' => $favorites]);
    }

    /**
     * Delete record
     *
     * @param $id
     * @Route("/delete/{id}")
     */
    public function deleteAction(Request $req,$id){

        $em = $this->getDoctrine()->getManager();

        $element = $em->getRepository('FlightBundle:Favorites')->find($id);
        if($element) {
            $em->remove($element);
            $em->flush();
        }

        return $this->redirect($req->headers->get('referer'));
    }
}
