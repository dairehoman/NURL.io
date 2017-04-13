<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PublicController extends Controller
{

    /**
     * @Route("/", name="")
     */
    public function indexAction(Request $request)
    {
        return $this->redirect('pub_nurl');
    }

    /**
     * @Route("/pub_nurl", name="pub_nurl")
     */
    public function indexNurlAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $nurls = $em->getRepository('AppBundle:Nurl')->findAll();

        return $this->render('public/index.nurls.html.twig', array(
            'nurls' => $nurls,
        ));
    }

    /**
     * @Route("/pub_collection", name="pub_collection")
     */
    public function indexCollectionAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $collections = $em->getRepository('AppBundle:Collection')->findAll();
        $nurls = $em->getRepository('AppBundle:Nurl')->findAll();

        return $this->render('public/index.collections.html.twig', array(
            'collections' => $collections,
            'nurls' => $nurls,
        ));
    }
}