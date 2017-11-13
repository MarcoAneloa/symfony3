<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Curso;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Tests\Compiler\C;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use AppBundle\Form\CursoType;
use Symfony\Component\Validator\Constraints as Assert;

class PruebaController extends Controller
{

    //Todos lo metodos funcionan son la base: symfony
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

    public function createAction(){

        $curso= new Curso();

        $curso->setTitulo('Matematica');
        $curso->setDescripcion('Materia super genial.!!!!');
        $curso->setPrecio(2.6);

        $em= $this->getDoctrine()->getManager();
        $em->persist($curso);
        $flush=$em->flush();

        if($flush != null){
            echo 'El curso no se ha creado bien';
        }else{
            echo 'El curso se ha creado correctamente';
        }
        die();
    }

    public function readAction(){
        $em= $this->getDoctrine()->getManager();
        $cursos_repo= $em->getRepository('AppBundle:Curso');
        $cursos=$cursos_repo->findAll();

        //$precio_2=$cursos_repo->findOneByPrecio(2.6);
        //echo $precio_2->getTitulo();

        foreach ($cursos as $curso){
            echo $curso->getTitulo()."</br>";
            echo $curso->getDescripcion()."</br>";
            echo $curso->getPrecio()."</br>";
        }

        die();
    }


    public function updateAction($id,$titulo,$descripcion,$precio){
        $em= $this->getDoctrine()->getManager();
        $cursos_repo= $em->getRepository('AppBundle:Curso');

        $curso=$cursos_repo->find($id);

        $curso->setTitulo($titulo);
        $curso->setDescripcion($descripcion);
        $curso->setPrecio($precio);

        $em->persist($curso);
        $flush=$em->flush();

        if($flush != null){
            echo 'El curso no se actualizado bien';
        }else{
            echo 'El curso se actualizado correctamente';
        }
        die();
    }


    public function deleteAction($id){
        $em= $this->getDoctrine()->getManager();
        $cursos_repo= $em->getRepository('AppBundle:Curso');

        $curso=$cursos_repo->find($id);

        $em->remove($curso);
        $flush=$em->flush();

        if($flush != null){
            echo 'El curso no se elimino';
        }else{
            echo 'El curso se elimino';
        }
        die();
    }

    public function navigateAction(){
        $em= $this->getDoctrine()->getManager();
        $db=$em->getConnection();

        $query="SELECT * FROM cursos";

        $stmt = $db->prepare($query);
        $params = array();
        $stmt-> execute($params);

        $cursos = $stmt->fetchAll();

        foreach ($cursos as $curso){
            echo $curso["titulo"]."</br>";
        }
        die();
    }

    public function navigate1Action(){
        $em= $this->getDoctrine()->getManager();

        $query= $em->createQuery('SELECT c FROM AppBundle:Curso c 
                WHERE c.precio > :precio')->setParameter("precio","5");

        $cursos=$query->getResult();

        foreach ($cursos as $curso){
            echo $curso->getTitulo()."</br>";
        }
        die();
    }

    public function navigate2Action(){
        $em= $this->getDoctrine()->getManager();
        $cursos_repo= $em->getRepository('AppBundle:Curso');
/*
        $query= $cursos_repo->createQueryBuilder('c')
            ->where("c.precio >:precio")
            ->setParameter("precio","5")
            ->getQuery();


        $cursos=$query->getResult();*/

        $cursos=$cursos_repo->getCursos();

        foreach ($cursos as $curso){
            echo $curso->getTitulo()."</br>";
        }
        die();
    }

    public function formAction(Request $request){
        $curso= new Curso();
        $form=$this->createForm(CursoType::class,$curso);

        $form->handleRequest($request);

        if($form->isValid()){
            $status='Formulario Valido';

            $data=array(
                'titulo'=> $form->get('titulo')->getData(),
                "descripcion"=> $form->get('descripcion')->getData(),
                'precio' => $form->get('precio')->getData()
            );
        }else{
            $status=null;
            $data=null;
        }

        return $this->render('AppBundle:pruebas:form.html.twig',
            array('form'=> $form->createView(),
                'status'=>$status,
                'data'=>$data
            ));
    }

    public function validarEmailAction($email){
        $emailContraint = new Assert\Email();

        $emailContraint->message = "Pasame un buen correo";

        $error = $this->get("validator")->validate($email,$emailContraint);

        if(count($error)==0){
            echo "<h1>Correo valido !!!!!! </h1>";
        }else{
            echo $error[0]->getMessage();
        }

        die();
    }
}
