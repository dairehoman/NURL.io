<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/moderator")
 */
class ModeratorController extends Controller
{
    /**
     * @Route("/", name="moderator_home")
     * @Security("has_role('ROLE_MODERATOR')")
     */
    public function indexAction(Request $request)
    {
        $argsArray =  [ ];
        $templateName = 'moderator/index';
        return $this->render($templateName . '.html.twig', $argsArray);
    }
}