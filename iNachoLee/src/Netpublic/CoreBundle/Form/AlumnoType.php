<?php

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class AlumnoType extends AbstractType
{
    protected $nombre="ntp_inacholeebundle_alumnotype";
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           
            ->add('nombre',null,
                    array(
                        'label'=>'Primer Nombre.',
                        'attr'=>array("class"=>"form-control")
                        ))
            ->add('nombre1',null,
                    array(
                        'label'=>'Segundo Nombre.','required'=>FALSE,
                        'attr'=>array("class"=>"form-control")
                        ))
            ->add('apellido',null,
                    array(
                        'label'=>'Primer apellido.','required'=>FALSE,
                        'attr'=>array("class"=>"form-control")
                        ))                                                
            ->add('apellido1',null,
                    array(
                        'label'=>'Segundo apellido.','required'=>FALSE,
                        'attr'=>array("class"=>"form-control")
                        ))                                                
                                                        
            ->add('movil',null,
                    array(
                        'label'=>'Movil.','required'=>FALSE,
                        'attr'=>array("class"=>"form-control")
                        ))            
            ->add('sede',null,
                    array(
                        'label'=>'Sede.','required'=>FALSE,
                        'attr'=>array("class"=>"form-control")
                        ))
            ->add('grado',null,
                    array(
                        'required'=>FALSE,
                        'attr'=>array(
                            'class'=>"form-control",
                            'onchange'=>'getGruposGradoEstandar("ntp_inacholeebundle_alumnotype_grado","ntp_inacholeebundle_alumnotype_grupo");'
                        )
                        ))    
            ->add('grupo',null,
                    array(
                        'label'=>'GRUPO.','required'=>FALSE,
                        'attr'=>array("class"=>"form-control")
                        ))            
            ->add('tipo_documento','choice',array(
                'attr'=>array('class'=>"form-control"),
                 'empty_value' => '             ',
                'choices'=>array(                   
                    '1'=>'Cedula Ciudadania',
                    '2'=>'Tarjeta de Identidad',
                    '3'=>"Cédula de Extranjería ó Identificación de Extranjería",
                    '4'=>"Registro Civil de Nacimiento",
                    "5"=>"Número de Identificación Personal (NIP)",
                    '6'=>"Número Único de Identificación Personal (NUIP)",
                    '7'=>"Número de Identificación establecido por la Secretaría de  Educación",
                    "8"=>"Certificado Cabildo"
                )
            ))
             ->add('tipo','choice',array(
                 'attr'=>array('class',"form-control"),
                  'empty_value' => 'Es Alumno|Acudiente',
                'choices'=>array(                    
                    '0'=>'Alumno',
                    '1'=>'Acudiente'
                   
                )
            ))                                
            ->add('cedula','text',  array(
                'attr'=>  array('onblur'=> 'getAlumnoCedulaAlumno();','class'=>"form-control")
            ))
            ->add('foto_academica','file',array('required'=>FALSE))    
            ->add('foto_firma','file',array('required'=>FALSE))        
                
            
        ;
    }

    public function getName()
    {
        return $this->nombre;
    }
    public function setName($nombre){
        $this->nombre=$nombre;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\Alumno',
        ));
    }
}
