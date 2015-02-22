<?php

namespace Netpublic\RedsaberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
class ExamenIcfesType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nro_preguntas',null,
                    array(
                        'label'=>'Numero Preguntas.',
                        'attr'=>array("class"=>"form-control")
                        ))
            ->add('tipo','choice',array(
                'attr'=>array('class'=>"form-control"),
                 'empty_value' => '        ',
                'choices'=>array(                   
                    '1'=>'Examen Presencial',
                    '2'=>'Examen Virtual',
                    )
            ))
            ->add('nombre',null,
                    array(
                        'label'=>'Nombre exámen.',
                        'attr'=>array("class"=>"form-control")
                        ))
            ->add('nota_maxima')
            ->add('fecha_inicio')
            ->add('hora',null,
                    array(
                        'label'=>'Duración.',
                        'attr'=>array("class"=>"form-control")
                        ))
            ->add('minuto',null,
                    array(
                        'label'=>'Minutos.',
                        'attr'=>array("class"=>"form-control")
                        ))    
            ->add('componente','hidden',array(
                'mapped'=>false,
                'required'=>false
            ))
            ->add('grupo','entity',  array(
                     'empty_value'=>'vacio',                      
                      "required"=>false,
                      "attr"=>array(
                          "class"=>"form-control"
                      ),
                      "label"=> "Grupo a evaluar",
                      'class' => 'NetpublicCoreBundle:Grupo',
                      'multiple'=>FALSE,
                      'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                     // ->where('u.id=0')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))
            ->add('reponsable','entity',  array(
                     'empty_value'=>'vacio',                      
                      "required"=>false,
                      "attr"=>array(
                          "class"=>"form-control"
                      ),
                      "label"=> "Responsable",
                      'class' => 'NetpublicCoreBundle:Profesor',
                      'multiple'=>FALSE,
                      'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                     // ->where('u.id=0')  
                                                      ->orderBy('u.apellido', 'ASC');
                                        },
              ))
                                    
           
            ->add('grados','entity',  array(
                     'empty_value'=>'Grado',                      
                      "required"=>false,
                      "attr"=>array(
                          'onchange'=>"loadGrupoExamen('netpublic_redsaberbundle_examenicfes_grados');getGruposGradoEstandar('netpublic_redsaberbundle_examenicfes_grados','netpublic_redsaberbundle_examenicfes_grupo');",
                          "class"=>"form-control"
                          ),
                      "label"=> "Grado",
                      'class' => 'NetpublicCoreBundle:Grado',
                      'multiple'=>FALSE,
                      'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\RedsaberBundle\Entity\ExamenIcfes'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'netpublic_redsaberbundle_examenicfes';
    }
}
