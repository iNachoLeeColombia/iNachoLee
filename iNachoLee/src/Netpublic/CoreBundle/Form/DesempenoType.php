<?php

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class DesempenoType extends AbstractType

{
    private $profesor_id;
    public function __construct($profesor_id=0) {
        $this->profesor_id=$profesor_id;     
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id=  $this->profesor_id;
        $builder
            ->add('descripcion_inf','textarea',array(
                'attr'=>array('onkeyup'=>'generarstringdesempeno();')))                              
            
            ->add('descripcion_sobresaliente','textarea',array(
                'attr'=>array('style'=>'display:none'),
                'required'=>false
                ))
            ->add('descripcion_excelente','textarea',array(
                'attr'=>array('style'=>'display:none'),
                'required'=>false
                ))
            ->add('descripcion_aceptable','textarea',array(
                'attr'=>array('style'=>'display:none'),
                'required'=>false
                ))    
            ->add('descripcion_insuficiente','textarea',array(
                'attr'=>array('style'=>'display:none'),
                'required'=>false    
                    ))    
           // ->add('descripcion_deficiente','textarea')    
            ->add('aspecto_evaluar')
            ->add('asignatura',null,array( 'label'=>' ','attr'=>array('style'=>'display:none;')))
            ->add('grupo',null,array('label'=>' ','attr'=>array('style'=>'display:none;')))    
            //->add('profesor')
            //  ->add('asignatura', 'entity', array(                     
             //        'class' => 'NetpublicCoreBundle:CargaAcademica',
            //         'multiple'=>FALSE,
             //        'query_builder' => function($repository) use ($id) { 
                            
             //                 $query=$repository->createQueryBuilder('F');
             //                 $query=$query->where('F.profesor = :id')->setParameter('id', $id);
	     // 		      $query=$query->andWhere('F.tiene_profesor=1'); 	
             //                 return $query; 
             //               },
             //         'required' => false              
             //       ))
          //->add('periodos_academico')
            //->add('porcentaje')
            /*->add('actividades_disponibles', 'entity', array(
                     'class' => 'NetpublicCoreBundle:Dimension',
                     'multiple'=>TRUE,
                     'expanded'=>TRUE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u') 
                                                      ->where("u.tipo=4") 
                                                      ->orderBy('u.id', 'ASC');
                                        },
                    ))*/
            //->add('periodo')
            //->add('periodo', 'entity', array(
            //         'class' => 'NetpublicCoreBundle:Dimension',
            //         'multiple'=>false,                     
             //        'query_builder' => function(EntityRepository $er) {
             //                                   return $er->createQueryBuilder('u') 
             //                                         ->where("u.tipo=1") 
             //                                         ->orderBy('u.id', 'ASC');
               //                         },
              //      ))                                    
            ->add('observacion_perdida','textarea',array(
                'required'=>FALSE
            ))
            ->add('observacion_sobresaliente','textarea',array('required'=>FALSE))    
        ;
    }

    public function getName()
    {
        return 'desempenotype';
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\Desempeno',
        ));
    }
}
