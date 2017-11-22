<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13/11/17
 * Time: 10:32
 */

namespace BlogBundle\Controller;

use BlogBundle\Entity\Tag;
use BlogBundle\Form\TagType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class TagController extends Controller{

    private $session;

    public function __construct(){
        $this->session= new Session();
    }

    /**
     * @Route("/tags/add", name="blog_add_tag")
     */
    public function addTag(Request $request){
        $tag= new Tag();
        $form = $this->createForm(TagType::class,$tag);

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            if($form->isValid()){
                $status="La etiqueta se a creado correctamente";
            }else{
                $status="la etiqueta no se ha creado, porque el formulario no es valido";
            }
            $this->session->getFlashBag()->add('status',$status);
        }

        return $this->render("BlogBundle:Tag:add.html.twig", array(
            "form" => $form->createView()
        ));
    }


}