<?php

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class HorarioClaseType extends AbstractType
{
    static $dias_nombres=array(
       "0"=>"Domingo",
       "1"=>"Lunes",
       "2"=>"Martes",
       "3"=>"Miercoles",
       "4"=>"Jueves",
       "5"=>"Viernes",
       "6"=>"Sabado"       
   );
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('tipo')
            ->add('hora_inicio')
            ->add('hora_final')
            //->add('dia_semana')
            ->add("dia_semana",'choice',  array(
               'choices'=> array(
                    ""=>"Seleccione Dia", 
                    "7" =>"Todos Los Dias",
                    "0"=>"Domingo",
                    "1"=>"Lunes",
                    "2"=>"Martes",
                    "3"=>"Miercoles",
                    "4"=>"Jueves",
                    "5"=>"Viernes",
                    "6"=>"Sabado"       
                )
            ))     
                
        ;
    }

    public function getName()
    {
        return 'ntp_inacholeebundle_horarioclasetype';
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\HorarioClase',
        ));
    }
}
