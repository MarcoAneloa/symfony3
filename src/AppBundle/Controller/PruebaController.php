<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PruebaController extends Controller
{

    public function indexAction(Request $request,$name,$page)
    {
        //var_dump($request->query->get("hola"));
        //var_dump($request->get("hola-post"));
        //die();
        //return $this->redirect($this->generateUrl('homepage'));
        //return $this->redirect($this->container->get('router')->getContext()->getBaseUrl()."/hello?hola=true");
        //return $this->redirect($request->getBaseUrl()."/hello?hola=true");
        $productos=array(array('producto' => 'servicio 1', 'precio' => '1'),
        array('producto' => 'servicio 2', 'precio' => '2'),
        array('producto' => 'servicio 3', 'precio' => '3'),
        array('producto' => 'servicio 4', 'precio' => '4'));


        $frutas=array('manzana' => 'verde', 'pera' => 'cafe');


        return $this->render('AppBundle:pruebas:index.html.twig',
            array('texto'=> $name.' Texto desde el controlador '.$page,
                'productos' => $productos,
                'frutas' => $frutas
            ));
    }


}
