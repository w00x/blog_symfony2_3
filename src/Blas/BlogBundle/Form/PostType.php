<?php

namespace Blas\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array(
                                        'attr' => array('placeholder'=>'Titulo')
                                        ))
            ->add('post','textarea', array(
                                        'attr' => array('placeholder'=>'Ingresa un post')
                                    ))
            ->add('owner', null, array(
                                        'attr' => array('placeholder'=>'Ingresa tu nombre')
                                    ))
            ->add('guardar','submit', array(
                                        'attr' => array('class'=>'btn')
                                    ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Blas\BlogBundle\Entity\Post',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // una clave única para ayudar generar el token
            'intention'       => 'task_item',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'blas_blogbundle_post';
    }
}
