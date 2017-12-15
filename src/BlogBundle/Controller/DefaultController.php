<?php

namespace BlogBundle\Controller;

use BlogBundle\BlogBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/old")
     */
    //Metodo para traer lista
    public function oldAction()
    {
        $em=$this->getDoctrine()->getEntityManager();
        $entry_repo=$em->getRepository('BlogBundle:Entry');
        $entries=$entry_repo->findAll();

        foreach ($entries as $entry){
            echo $entry->getTitle().'</br>';
            echo $entry->getCategory()->getName().'</br>';
            echo $entry->getUser()->getName().'</br>';

            $tags= $entry->getEntryTag();

            foreach ($tags as $tag){
                echo $tag->getTag()->getName().", ";
            }

            echo "<hr/>";
        }
        die();

        /*$em=$this->getDoctrine()->getEntityManager();
        $category_repo=$em->getRepository('BlogBundle:Category');
        $categories=$category_repo->findAll();

        foreach ($categories as $category){
            echo $category->getName().'</br>';

            $entries= $category->getEntries();

            foreach ($entries as $entry){
                echo $entry->getTitle().", ";
            }

            echo "<hr/>";
        }
        die();*/

       /* $em=$this->getDoctrine()->getEntityManager();
        $tag_repo=$em->getRepository('BlogBundle:Tag');
        $tags=$tag_repo->findAll();

        foreach ($tags as $tag){
            echo $tag->getName().'</br>';

            $tags= $tag->getEntryTag();

            foreach ($tags as $tag){
                echo $tag->getEntry()->getTitle().", ";
            }

            echo "<hr/>";
        }
        die();*/

        return $this->render('BlogBundle::layout.html.twig');
    }

    /**
     * @Route("/old2", name="home")
     */
    public function indexAction()
    {
        return $this->render('BlogBundle:Default:index.html.twig');
    }


}
