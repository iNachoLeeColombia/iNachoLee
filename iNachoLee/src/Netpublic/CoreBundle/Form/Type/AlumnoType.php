<?php

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class AlumnoType extends AbstractType
{
    protected $nombre="ntp_inacholeebundle_alumnotype";
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           
            ->add('nombre',null,array('label'=>'Primer Nombre.'))
            ->add('nombre1',null,array('label'=>'Segundo Nombre.','required'=>FALSE))
            ->add('apellido',null,array('label'=>'Primer Apellido.'))                                                
            ->add('apellido1',null,array('label'=>'Segundo Apellido.'))                                                
                                                        
            ->add('movil')
            
            ->add('sede')
            //->add('grupo',null,array('required'=>FALSE))
            ->add('grado')
            ->add('tipo_documento','choice',array(
                 'empty_value' => '             ',
                'choices'=>array(                   
                    '1'=>'Cedula Ciudadania',
                    '2'=>'Tarjeta de Identidad',
                    '3'=>"Cédula de Extranjería ó Identificación de Extranjería",
                    '5'=>"Registro Civil de Nacimiento",
                    "6"=>"Número de Identificación Personal (NIP)",
                    '7'=>"Número Único de Identificación Personal (NUIP)",
                    '8'=>"Número de Identificación establecido por la Secretaría de  Educación",
                    "9"=>"Certificado Cabildo"
                )
            ))
             ->add('tipo','choice',array(
                  'empty_value' => '             ',
                'choices'=>array(                    
                    '0'=>'Alumno',
                    '1'=>'Acudiente'
                   
                )
            ))                                
            ->add('cedula','text',  array(
                'attr'=>  array('onblur'=> 'getAlumnoCedulaAlumno();')
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
}
