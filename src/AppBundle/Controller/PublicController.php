<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PublicController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexNurlAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $nurls = $em->getRepository('AppBundle:Nurl')->findAll();
        $collections = $em->getRepository('AppBundle:Collection')->findAll();

        return $this->render('public/index.html.twig', array(
            'nurls' => $nurls,
            'collections' => $collections,
        ));
    }
}