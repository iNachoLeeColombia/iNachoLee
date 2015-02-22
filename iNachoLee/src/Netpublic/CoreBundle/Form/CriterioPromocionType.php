<?php

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class CriterioPromocionType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder        
            ->add('valor','text',array(
               'attr'=>array(
                   'placeholder'=>"2 (ingrese numero)" 
               )
            ))
            ->add('tipo','choice',array(
                'choices'=>array(
                '0'=>'Habilita',
                '1'=>'Pierde'
            )))    
            ->add('es_area_asg','choice',array(
                'choices'=>array(
                '0'=>'nro areas',
                '1'=>'nro Asignaturas   '
            )))
            ->add('simbolo','choice',array(
                'choices'=>array(
                    '>'=>'>',
                    '>='=>'>=',
                    '<'=>'<',
                    '<='=>'<=',
                    '='=>'='
                )
            ))
            ->add('area_asignatura')            
            ->add('asignatura','choice',array(
             "attr"=>array(
                       "onchange" =>"getAreasAsignaturas('netpublic_bundle_corebundle_criteriopromociontype_grado','netpublic_bundle_corebundle_criteriopromociontype_area_asignatura','netpublic_bundle_corebundle_criteriopromociontype_asignatura');"
                     ),
                
                    "mapped" => false,
                'choices'=>array(
                    '1'=>'Area(s)',
                    '0'=>'Asignaturas'
                )
            ))                
            ->add('grado', 'entity', array(
                     "attr"=>array(
                       "onchange" =>"getAreasAsignaturas('netpublic_bundle_corebundle_criteriopromociontype_grado','netpublic_bundle_corebundle_criteriopromociontype_area_asignatura','netpublic_bundle_corebundle_criteriopromociontype_asignatura');"
                     ),
                     'required'=>false,
                     'empty_value' =>'Todos los grados',
                     'class' => 'NetpublicCoreBundle:Grado',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                     // ->where('u.variable=1')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))     
                
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\CriterioPromocion'
        ));
    }

    public function getName()
    {
        return 'netpublic_bundle_corebundle_criteriopromociontype';
    }
}