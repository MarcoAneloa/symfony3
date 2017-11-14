<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13/11/17
 * Time: 10:32
 */

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserController extends Controller{

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request){
        $authenticationUtils= $this->get("security.authentication_utils");
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render("BlogBundle:User:login.html.twig",array(
            "error" => $error,
            "last_username" => $lastUsername
        ));

    }

}