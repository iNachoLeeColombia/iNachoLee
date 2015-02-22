<?php

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
class GradoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')            
            ->add('niveles_educativo', 'choice', array(
                'choices'=>array(
                    '1'=>"Nivel PreEscolar",
                    '2'=>"Básica Primaria",
                    '3'=>'Básica Secundaria',
                    '4'=>'Media'
                )
             ))     
            ->add('grado', 'entity', array(
                     'empty_value'=>'No Aplica',
                      "mapped" => false,
                      "required"=>false,
                      "label"=> "Copiar AREAS | ASIGNATURAS De:",
                      'class' => 'NetpublicCoreBundle:Grado',
                      'multiple'=>FALSE,
                      'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))     
                                                
            
           
        ;
    }

    public function getName()
    {
        return 'ntp_inacholeebundle_gradotype';
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\Grado',
        ));
    }
}
