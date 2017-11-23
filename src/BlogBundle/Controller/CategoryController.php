<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13/11/17
 * Time: 10:32
 */

namespace BlogBundle\Controller;

use BlogBundle\Entity;
use BlogBundle\Entity\Category;
use BlogBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Common\Collections\ArrayCollection;

class CategoryController extends Controller{

    private $session;

    public function __construct(){
        $this->session= new Session();
    }

    /**
     * @Route("/category/index", name="blog_index_category")
     */
    public function indexAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $category_repo = $em->getRepository('BlogBundle:Category');
        $categories = $category_repo->findAll();

        return $this->render("BlogBundle:Category:index.html.twig", array(
            "categories" => $categories
        ));
    }

    /**
     * @Route("/category/add", name="blog_add_category")
     */
    public function addAction(Request $request){
        $category= new Category();
        $form = $this->createForm(CategoryType::class,$category);

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            if($form->isValid()){
                $em = $this->getDoctrine()->getEntityManager();

                $category = new Category();
                $category->setName($form->get('name')->getData());
                $category->setDescription($form->get('description')->getData());

                $em->persist($category);
                $flush = $em->flush();

                if($flush==null){
                    $status="La etiqueta se a editado correctamente";
                }else{
                    $status="Error al editar la etiqueta";
                }
            }else{
                $status="La etiqueta no se ha editado, porque el formulario no es valido";
            }
            $this->session->getFlashBag()->add('status',$status);
            return $this->redirectToRoute('blog_index_category');
        }

        return $this->render("BlogBundle:Category:add.html.twig", array(
            "form" => $form->createView()
        ));
    }

    /**
     * @Route ("category/delete/{id}",name="blog_delete_category")
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $category_repo = $em->getRepository('BlogBundle:Category');
        $category = $category_repo->find($id);
        if(count($category->getEntries())==0){
            $em->remove($category);
            $em->flush();
        }
        return $this->redirectToRoute('blog_index_category');
    }

    /**
     * @Route("category/edit/{id}",name="blog_edit_category")
     */
    public function editAction(Request $request,$id){
        $em = $this->getDoctrine()->getEntityManager();
        $category_repo = $em->getRepository('BlogBundle:Category');
        $category = $category_repo->find($id);

        $form = $this->createForm(CategoryType::class,$category);

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            if($form->isValid()){
                $category->setName($form->get('name')->getData());
                $category->setDescription($form->get('description')->getData());

                $em->persist($category);
                $flush = $em->flush();

                if($flush==null){
                    $status="La etiqueta se a creado correctamente";
                }else{
                    $status="Error al añadir la etiqueta";
                }
            }else{
                $status="la etiqueta no se ha creado, porque el formulario no es valido";
            }
            $this->session->getFlashBag()->add('status',$status);
            return $this->redirectToRoute('blog_index_category');
        }

        return $this->render("BlogBundle:Category:edit.html.twig", array(
            "form" => $form->createView()
        ));
    }


}