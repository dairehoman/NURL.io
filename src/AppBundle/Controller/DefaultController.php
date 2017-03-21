<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    /**
     * @Route("/", name="index")
     */
    public function indexAction(Request $request) {
        $argsArray = [ ];

        $templateName = 'index';
        return $this->render($templateName . '.html.twig', $argsArray); }
}
