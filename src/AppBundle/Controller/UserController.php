<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * User controller.
 *
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="user_home")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction(Request $request)
    {
        $argsArray =  [ ];
        $templateName = 'user/index';
        return $this->render($templateName . '.html.twig', $argsArray);
    }
}
