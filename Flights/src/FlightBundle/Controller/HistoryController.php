<?php

namespace FlightBundle\Controller;

use FlightBundle\Entity\History;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * History controller.
 *
 * @Route("history")
 * @Security("has_role('ROLE_USER')")
 */
class HistoryController extends Controller
{
    /**
     * Lists all history entities.
     *
     * @Route("/", name="history_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $histories = $em->getRepository('FlightBundle:History')->findBy([
            'user' => $this->getUser()
        ]);

        return $this->render('history/index.html.twig', array(
            'histories' => $histories,
        ));
    }

    /**
     * Finds and displays a history entity.
     *
     * @Route("/{id}", name="history_show")
     * @Method("GET")
     */
    public function showAction(History $history)
    {

        return $this->render('history/show.html.twig', array(
            'history' => $history,
        ));
    }

    /**
     * Delete one history record
     *
     * @param Request $req
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete/{id}")
     */
    public function deleteAction(Request $req,$id){

        $em = $this->getDoctrine()->getManager();

        $element = $em->getRepository('FlightBundle:History')->find($id);
        if($element)
        {
            $em->remove($element);
            $em->flush();
        }

        return $this->redirect($req->headers->get('referer'));
    }

    /**
     * @param Request $req
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/deleteall/")
     */
    public function deleteallAction(Request $req){
        $em = $this->getDoctrine()->getManager();

        $elements = $em->getRepository('FlightBundle:History')->findBy(['user' => $this->getUser()]);
        if($elements)
        {
            foreach($elements as $element)
            $em->remove($element);
            $em->flush();
        }
        return $this->redirect($req->headers->get('referer'));
    }
}
