<?php

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class DimensionType extends AbstractType
{
    protected $tipo;
    public function __construct($tipo=1)         
    {
        $this->tipo=$tipo;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $id=  $this->tipo;
        $builder
            ->add('nombre')
            
            /*->add('es_carita_feliz', 'choice', array(
                  'choices'   => array(0 => "0.0 - 5.0", 1 =>'Carita Feliz'),
                  'required'  => true))*/
            ->add('padre', 'entity', array(                     
                     'class' => 'NetpublicCoreBundle:Dimension',
                     'multiple'=>FALSE,
                     'query_builder' => function($repository) use ($id) { 
                            if($id==6){
                              $query=$repository->createQueryBuilder('F');
                              $query=$query->where('F.tipo = :id')->setParameter('id', 1);;
			      $query=$query->orWhere('F.tipo=6'); 	
                            }
                            else{
                              $query=$repository->createQueryBuilder('F');
                              $query=$query->where('F.tipo = :id')->setParameter('id', $id);;
                              //if($id==1)
                                  //  $query=$query->orWhere('F.tipo=4');
                            } 
                             return $query;
                                               
                                             
                                             
                            },
                      'required' => false              
                    ))
                  
            ->add('asignatura', 'entity', array(
                    "mapped" => false,
                     'class' => 'NetpublicCoreBundle:Asignatura',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->orderBy('u.nombre', 'ASC');
                                        },
                     'required' => false              
                                                
                    ))   
            /* ->add('grupo', 'entity', array(
                     'class' => 'NetpublicCoreBundle:Grupo',
                     'multiple'=>TRUE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->orderBy('u.nombre', 'ASC');
                                        },
                      'required' => false              
                                                
                    )) */                                                                          
            ->add('ponderado')
            ->add('fecha_inicio',NULL,array(  
                'empty_value' => array('year' => 'Ano', 'month' => 'Mes', 'day' => 'Dia'),
                'label'=> "Fecha De inicio(Entrega de Notas)."
            ))
            ->add('fecha_final',null,array(
                'empty_value' => array('year' => 'Ano', 'month' => 'Mes', 'day' => 'Dia'),
                "label"=>"Fecha Final(Entrega De Notas)."
                ))
            ->add('periodoacademico','entity',array(  
                "mapped" => false,
                'empty_value' => '             ',
                'class' => 'NetpublicCoreBundle:Dimension',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.tipo=1')  
                                                      ;
                                        },
            ))
            ->add('ano_escolar','entity',array(
                "mapped" => false,
                'empty_value' => '             ',
                'class' => 'NetpublicCoreBundle:Dimension',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.tipo=0')  
                                                      ->orderBy('u.nombre', 'ASC');
                                        },
            ));
            $builder->add('nivel');
            
                                        
    }

    public function getName()
    {
        return 'dimension';
    }
     public function getDefaultOptions(array $options)
    {
        return array(
            'tipo' => $this->tipo,
        );
    }
    public function createuery(){
        
    }
    public function qqq(EntityRepository $er) {
        return $er->createQueryBuilder('u')
                  ->where("u.tipo=:tipo")  
                  ->orderBy('u.nombre', 'ASC')
                  ->setParameter('tipo', $this->tipo);
        }
        
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\Dimension',
        ));
    }
}
