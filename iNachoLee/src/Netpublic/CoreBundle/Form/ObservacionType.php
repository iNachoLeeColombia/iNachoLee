<?php

namespace Netpublic\CoreBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ObservacionType extends AbstractType
{
    private $ano_escolar_activo;
    public function __construct($ano_escolar_activo=0){
        $this->ano_escolar_activo=$ano_escolar_activo;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id=  $this->ano_escolar_activo;
        $builder
             ->add('tipo','choice',array(
                'choices'=>array(
                    '0'=>'Disciplina y Comportamiento',
                    '1'=>'Desarrollo de Valores',
                    '2'=>'Dificultades',
                    '3'=>"Estado Nutricional",
                    '5'=>"Desarrollo Fisico",
                    "6"=>"Aptitudes",
                    '7'=>"Dificultades(Visuales,Auditivas,Motrices,Expresivas)",
                    '8'=>"Otros"
                    
                )
            ))         
            ->add('contenido')
           // ->add('dueno')
            ->add('periodo', 'entity', array(                     
                     'class' => 'NetpublicCoreBundle:Dimension',
                     'multiple'=>FALSE,
                     'query_builder' => function($repository) use ($id) { 
                              $query=$repository->createQueryBuilder('F');
                             $query=$query->where('F.padre = :id')->setParameter('id', $id);
                             $query=$query->andWhere('F.tipo =1');                            
                             return $query;
                                               
                                             
                                             
                            },
                      'required' => false              
                    ))
                  


        ;
    }

    public function getName()
    {
        return 'ntp_inacholeebundle_observaciontype';
    }
        public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\Observacion',
        ));
    }

}
