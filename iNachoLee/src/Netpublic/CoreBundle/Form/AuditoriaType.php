<?php

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AuditoriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('tipo','choice',array(
                 'empty_value' => '             ',
                'choices'=>array(                   
                    '1'=>'Auditoria',
                    '2'=>'Revisión De Boletines Director De grupo',
                    '3'=>'Revisión De Boletin Alumno',
                    
                )
            ))
   
            ->add('fecha_inicio')
            ->add('fecha_final')
            ->add('sede')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\Auditoria'
        ));
    }

    public function getName()
    {
        return 'netpublic_bundle_corebundle_auditoriatype';
    }
}
