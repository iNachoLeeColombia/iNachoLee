<?php

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Netpublic\CoreBundle\Form\GradoType;
use Doctrine\ORM\EntityRepository;

class AsignaturaType extends AbstractType
{
    private $entity;
    public function __construct($entity=null){
        $this->entity=$entity;
            
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id_grado=0;
        if($this->entity)
            $id_grado=  $this->entity->getId();
        $builder
            ->add('nombre')
//            ->add("frucuencia_semana")   
            ->add('frucuencia_semana','choice',array(
                 'choices'=>array(
                     '1'=>'Una',
                     '2'=>'Dos',			
                     '3'=>'Tres',                     
                     '4'=>'Cuatro',
                     '5'=>'Cinco',
                     '6'=>'Seis',
                     '7'=>'Siente'
                 ),
                 'empty_value'=>'Frecuencia en la Semana'
             ))     

//            ->add('duracion_minutos')
            ->add('duracion_minutos','choice',array(
                 'choices'=>array(
                     '30'=>'Media Hora',
                     '60'=>'1 Hora',			
                     '90'=>'1 Hora y Media',                     
                     '120'=>'2 Horas',
                     '150'=>'2 Horas Y Media',		     
                     '180'=>'3 Horas',
                     '210'=>'3 Horas Y Media',
                     '240'=>'4 Hora',			
                     '270'=>'4 Hora y Media',                     
                     '300'=>'5 Horas',
                     '330'=>'5 Horas Y Media',		     
                     '360'=>'6 Horas',
                     '390'=>'6 Horas Y Media',
                     '420'=>'7 Hora',			
                     '450'=>'7 Hora y Media',                     
                     '480'=>'8 Horas',
                     '510'=>'8 Horas Y Media',		     
                     '540'=>'9 Horas',
                     '570'=>'9 Horas Y Media',
                     '600'=>'10 Horas',		     
                     '630'=>'10 Horas Y Media',
                     '660'=>'11 Horas',
                     '690'=>'11 Hora Y Media',			
                     '720'=>'12 Hora',                     
                     '750'=>'12 Horas Y Media',
                     '780'=>'13 Horas',		     
                     '810'=>'13 Horas Y Media',
                 ),
                 'empty_value'=>'Horas Semanales'
             ))     
	    
            ->add('grado', 'entity', array(
                     'attr'=>array(
                         "onchange"=>"getAreasGradoEstandar('ntp_inacholeebundle_asignaturatype_grado','ntp_inacholeebundle_asignaturatype_area')"
                     ),
                     'class' => 'NetpublicCoreBundle:Grado',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->orderBy('u.id', 'ASC');
                                        },
                    ))
            //->add('area') 
            ->add('area', 'entity', array(
                     'class' => 'NetpublicCoreBundle:Asignatura',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er ) use ($id_grado) {
                                            $query=$er->createQueryBuilder('u');
                                            $query=$query->where('u.es_area = :es_area') ;
                                            $query=$query->setParameter('es_area',1);
                                            if($id_grado){
                                                $query=$query->andWhere('u.grado =:id_grado');
                                                $query=$query->setParameter('id_grado',$id_grado);
                                            }
                                            $query=$query->orderBy('u.id', 'ASC');
                                            return  $query;
                                        },
                    ))                                    
        ;
    }

    public function getName()
    {
        return 'ntp_inacholeebundle_asignaturatype';
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\Asignatura',
        ));
    }
}
