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
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use BlogBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

class EntryController extends Controller{

    private $session;

    public function __construct(){
        $this->session= new Session();
    }

    /**
     * @Route("/",name="blog_index_entry")
     */
    public function  indexAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $entry_repo = $em->getRepository('BlogBundle:Entry');
        $category_repo = $em->getRepository('BlogBundle:Category');


        $entries=$entry_repo->findAll();
        $categories=$category_repo->findAll();

        return $this->render("BlogBundle:Entry:index.html.twig", array(
            "entries" => $entries,
            "categories" => $categories
        ));
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
                $em = $this->getDoctrine()->getEntityManager();
                $category_repo = $em->getRepository('BlogBundle:Category');
                $entry_repo = $em->getRepository('BlogBundle:Entry');

                $entry = new Entry();
                $entry->setTitle($form->get('title')->getData());
                $entry->setContent($form->get('content')->getData());
                $entry->setStatus($form->get('status')->getData());

                //upload file
                $file=$form["image"]->getData();
                $ext=$file->guessExtension();
                $file_name=time().".".$ext;
                $file->move("uploads", $file_name);
                $entry->setImage($file_name);

                $category=$category_repo->find($form->get('category')->getData());
                $entry->setCategory($category);

                //Obtener usuario logueado
                $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
                $user=$this->getUser();
                $entry->setUser($user);

                $em->persist($entry);
                $flush = $em->flush();

                $entry_repo->saveEntryTags(
                    $form->get('tags')->getData(),
                    $form->get('title')->getData(),
                    $form->get('category')->getData(),
                    $user,
                    $entry
                );

                if($flush==null){
                    $status="La etiqueta se a editado correctamente";
                }else{
                    $status="Error al editar la etiqueta";
                }
            }else{
                $status="La etiqueta no se ha editado, porque el formulario no es valido";
            }
            $this->session->getFlashBag()->add('status',$status);
            return $this->redirectToRoute('blog_index_entry');
        }

        return $this->render("BlogBundle:Entry:add.html.twig", array(
            "form" => $form->createView()
        ));
    }

    /**
     * @Route ("entry/delete/{id}",name="blog_delete_entry")
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $entry_repo = $em->getRepository('BlogBundle:Entry');
        $entry_tag_repo = $em->getRepository('BlogBundle:EntryTag');

        $entry = $entry_repo->find($id);
        $entry_tags=$entry_tag_repo->findBy(array("entry"=>$entry));

        foreach ($entry_tags as $et){
            if(is_object($et)){
                $em->remove($et);
                $em->flush();
            }
        }

        if(is_object($et)) {
            $em->remove($entry);
            $em->flush();
        }

        return $this->redirectToRoute('blog_index_entry');
    }
}