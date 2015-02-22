<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CargaAcademicafType
 *
 * @author yuri
 */

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
//use Netpublic\CoreBundle\Form\Type\GrupoType;
//use Netpublic\CoreBundle\Form\ProfesorType;
//use Netpublic\CoreBundle\Form\AsignaturaType;
use Doctrine\ORM\EntityRepository;
class CargaAcademicafType extends AbstractType{
     public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                  ->add('grado', 'entity',  array(
                    "mapped" => false,
                    'label'=>"Grado",                    
                    'empty_value' => " ",
                    'class' => 'NetpublicCoreBundle:Grado',
                    'query_builder' => function(EntityRepository $er) {
                                            return $er->createQueryBuilder('u')
                                                      ->orderBy('u.nombre', 'ASC');
                                        },                                           )
                     
                    )
                  ->add('grupo', 'entity', array(
                     'class' => 'NetpublicCoreBundle:Grupo',
                     'empty_value'=>"Seleccione Grupo",
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->orderBy('u.nombre', 'ASC');
                                        },
                    ))  
                  ->add('asignatura', 'entity', array(
                     'class' => 'NetpublicCoreBundle:Asignatura',
                     'empty_value'=>"Seleccione Asignatura",
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->orderBy('u.nombre', 'ASC');
                                        },
                    ))     
                  ->add('profesor', 'entity', array(
                     'class' => 'NetpublicCoreBundle:Profesor',
                     'multiple'=>FALSE,
                     'empty_value'=>"Seleccione Profesor",
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->orderBy('u.nombre', 'ASC');
                                        },
                    ))
                 
                                 
                  /* ->add('horario_aula', 'entity', array(
                     'class' => 'NetpublicCoreBundle:HorarioAula',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->orderBy('u.dia', 'ASC');
                                        },
                    ))*/     
                    ->add('aula', 'entity', array(
                     'class' => 'NetpublicCoreBundle:Aula',
                     'empty_value'=>"Seleccione Aula",   
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                     ;
                                        },
                    ))                                                                             
                                                            
                                                
                                                                                        
            ;
    }

    public function getName()
    {
        return 'ntp_inacholeebundle_cargaacademicaftype';
    }
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Netpublic\CoreBundle\Entity\CargaAcademica',
        );
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\CargaAcademica',
        ));
    }
}

?>
