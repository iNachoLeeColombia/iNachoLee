<?php

namespace Netpublic\RedsaberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlanAreaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre','hidden')
            ->add('anchor_interno','hidden')
            ->add('contenido')
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\RedsaberBundle\Entity\PlanArea'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'netpublic_redsaberbundle_planarea';
    }
}
