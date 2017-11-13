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

class UserController extends Controller{

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