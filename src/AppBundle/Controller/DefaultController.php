<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction(Request $request)
    {
        $argsArray =  [ ];
        $templateName = 'index';
        return $this->render($templateName . '.html.twig', $argsArray);
    }
    /**
     * @Route("/clear_session", name="clear_session")
     */
    public function clearSessionAction(Request $request)
    {
        $session = new Session();
        $session->clear();
        return $this->redirectToRoute('index');
    }
}