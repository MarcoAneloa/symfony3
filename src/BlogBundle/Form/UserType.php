<?php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,array('label'=>'Nombre','required'=>'required',
                'attr'=>array('class'=>'form-name form')))
            ->add('surname',TextType::class,array('label'=>'Apellido','required'=>'required',
                'attr'=>array('class'=>'form-surname form')))
            ->add('email',EmailType::class,array('label'=>'Email','required'=>'required',
                'attr'=>array('class'=>'form-email form')))
            ->add('password',PasswordType::class,array('label'=>'Contraseña','required'=>'required',
                'attr'=>array('class'=>'form-password form')))
            ->add('Gurdar',SubmitType::class,array(
                'attr'=>array('class'=>'form-submit btn btn-success')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\User'
        ));
    }
}
