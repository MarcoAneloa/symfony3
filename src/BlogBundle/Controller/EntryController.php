<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13/11/17
 * Time: 10:32
 */

namespace BlogBundle\Controller;

use BlogBundle\Entity;
use BlogBundle\Entity\Entry;
use BlogBundle\Form\EntryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Common\Collections\ArrayCollection;

class EntryController extends Controller{

    private $session;

    public function __construct(){
        $this->session= new Session();
    }

    /**
     * @Route("/entry/add", name="blog_add_entry")
     */
    public function addAction(Request $request){
        $entry= new Entry();
        $form = $this->createForm(EntryType::class,$entry);

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            if($form->isValid()){
                /*$em = $this->getDoctrine()->getEntityManager();

                $category = new Category();
                $category->setName($form->get('name')->getData());
                $category->setDescription($form->get('description')->getData());

                $em->persist($category);
                $flush = $em->flush();

                if($flush==null){
                    $status="La etiqueta se a editado correctamente";
                }else{
                    $status="Error al editar la etiqueta";
                }*/
            }else{
                $status="La etiqueta no se ha editado, porque el formulario no es valido";
            }
            //$this->session->getFlashBag()->add('status',$status);
            //return $this->redirectToRoute('blog_index_category');
        }

        return $this->render("BlogBundle:Entry:add.html.twig", array(
            "form" => $form->createView()
        ));
    }
}