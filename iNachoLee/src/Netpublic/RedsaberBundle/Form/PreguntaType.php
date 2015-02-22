<?php

namespace Netpublic\RedsaberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PreguntaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('contenidotexto','hidden',array(
                'mapped'=>false,
                'required'=>false,
             ))
            
            ->add('label','choice',array(
                'empty_value' => 'Cual es la Opción correcta.',
                'choices'=>array(                   
                    'A.'=>'A',
                    'B.'=>'B',
                    'C.'=>'C',
                    'D.'=>'D',
                    )
            ))
            
            ->add('descripcion_A','textarea',array(
                'label'=>'A'
            ))
            ->add('descripcion_B','textarea',array(
                'label'=>'B'
            ))
            ->add('descripcion_C','textarea',array(
                'label'=>'C'
            ))
            ->add('descripcion_D','textarea',array(
                'label'=>'D'
            ))
            ->add('componentetexto','hidden',array(
                'mapped'=>false,
                'required'=>false,
                ))
            ->add('tematexto','hidden',array(
                'mapped'=>false,
                'required'=>false,
            ))
            ->add('estado','choice',array(
                'label'=>'Banco de pregunta destino',
                 'empty_value' => 'Banco de pregunta.?',
                'choices'=>array(                   
                    '1'=>'Banco de preguntas de la Red Saber',
                    '0'=>'Banco de preguntas de la IE|CE',
                    )
            ))
            ->add('grado')
                
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\RedsaberBundle\Entity\Pregunta'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'netpublic_redsaberbundle_pregunta';
    }
}
