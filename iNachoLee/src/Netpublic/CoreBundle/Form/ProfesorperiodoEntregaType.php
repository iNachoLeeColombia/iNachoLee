<?php

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;
class ProfesorperiodoEntregaType extends AbstractType

{
    private $id_profesor;
    private $id_ano_activo;
    
    public function __construct($id_ano_activo=0,$id_profesor=0) {
        $this->id_ano_activo=$id_ano_activo;     
        $this->id_profesor=$id_profesor;
       
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    /*
     ,null,array(    
                'attr'=>array('onfocus'=>'javascript:this.blur(); return false;')
                )   
    }*/
        $id_profesor= $this->id_profesor;
        $id_ano_activo=$this->id_ano_activo;
        $b=$builder->add('profesor', 'entity', array(                     
                     'class' => 'NetpublicCoreBundle:Profesor',
                     'multiple'=>FALSE,
                     'query_builder' => function($repository) use ($id_profesor) { 
                              $query=$repository->createQueryBuilder('F');
                              $query=$query->where('F.id = :id')->setParameter('id', $id_profesor);
                              
                             return $query;
                                               
                                             
                                             
                            },
                      'required' => false              
                    ));
        $b=$b->add('periodo', 'entity', array(                     
                     'class' => 'NetpublicCoreBundle:Dimension',
                     'multiple'=>FALSE,
                     'query_builder' => function($repository) use ($id_ano_activo) { 
                              $query=$repository->createQueryBuilder('F');
                              $query=$query->where('F.tipo =1');
                              $query=$query->andWhere('F.padre=:id')->setParameter('id', $id_ano_activo);
                              
                             return $query;
                                               
                                             
                                             
                            },
                      'required' => false              
                    ));                            
        //$b=$b->add('periodo');
        //$b=$b->add('profesor');
        //$b=$b->add('fecha_inicio');
        //$b=$b->add('fecha_final'); 
         $b=$b->add('fecha_inicio',NULL,array(  
                'empty_value' => array('year' => 'Ano', 'month' => 'Mes', 'day' => 'Dia'),
                'label'=> "Fecha De inicio(Entrega de Notas)."
            ));
          $b=$b->add('fecha_final',null,array(
                'empty_value' => array('year' => 'Ano', 'month' => 'Mes', 'day' => 'Dia'),
                "label"=>"Fecha Final(Entrega De Notas)."
                ))
        ;
    }

    public function getName()
    {
        return 'ntp_inacholeebundle_profesorperiodoentregatype';
    }
        public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\Profesorperiodoentrega',
        ));
    }

}
