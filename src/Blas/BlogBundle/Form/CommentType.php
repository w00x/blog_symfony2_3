<?php

namespace Blas\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment','textarea', array(
                                                'attr' => array('placeholder'=>'Agrega un comentario')
                                            ))
            ->add('owner', null, array(
                                    'attr' => array('placeholder'=>'Ingresa tu nombre')
                                ))
            ->add('comentar','submit', array(
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
            'data_class' => 'Blas\BlogBundle\Entity\Comment'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'blas_blogbundle_comment';
    }
}
