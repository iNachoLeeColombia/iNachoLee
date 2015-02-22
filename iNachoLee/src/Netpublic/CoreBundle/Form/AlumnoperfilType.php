<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AlumnoperfilType
 *
 * @author yuri
 */

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
class AlumnoperfilType  extends AbstractType{
      public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('sede',null,array('attr'=>  array("")))
            //->add('nombre')
            //->add('nombre1')    
            ///->add('apellido')
            //->add('apellido1')                    
            ->add('movil')
            //->add('grupo',null,array('required'=>FALSE))
            //->add('grado')
            /*->add('tipo_documento','choice',array(
                'choices'=>array(
                    '0'=>'   ',
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
            ->add('cedula')    */
            //->add('departamento')
            // ->add('acudiente')   
             /*->add('acudiente', 'entity', array(
                     'class' => 'NetpublicCoreBundle:Alumno',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.tipo=1')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))   */
                
             ->add('departamento', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))   
            //->add('municipio')
              ->add('municipio', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=14')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                    
            ->add('fecha_nacimiento')
            //->add('depto_nacimiento')                
            //->add('municipio_nacimiento')                                
            ->add('depto_nacimiento', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))      
            ->add('municipio_nacimiento', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                                 
            //->add('genero')
             ->add('genero','choice',array(
                'choices'=>array(
                    '0'=>'   ',
                    '1'=>'Masculino',
                    '2'=>'Femenino'         
                )
            ))
            //->add('jornada') 
            ->add('jornada','choice',array(
                'choices'=>array(
                    '0'=>'   ',
                    '1'=>'Completa',
                    '2'=>'Mañana',
                    '3'=>'Tarde',
                    '4'=>'Nocturna',
                    '5'=>'Fin de semana'                    
                )
            ))                                   
                                             
            //->add('foto_academica','file',array('required'=>FALSE))
            //->add('foto_firma','file',array('required'=>FALSE))                                                        
            ->add('direccion_residencia')
            ->add('telefono')            
            ->add('tipo_sangre','choice',array(
                'choices'=>array(
                    '0'=>'O+',
                    '1'=>'O-',
                    '2'=>'A-',
                    '3'=>'A+',
                    '4'=>'B-',
                    '5'=>'B+',                    
                    '4'=>'C-',
                    '5'=>'C+'                                        
                )
            ))                                   
                                     
            //->add('depto_ubicacion')                                                
            //->add('municipio_ubicacion')
             ->add('depto_ubicacion', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))      
            ->add('municipio_ubicacion', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                    
            //->add('zona')
            ->add('zona','choice',array(
                'choices'=>array(
                    '1'=>'Urbana',
                    '2'=>'Rural'
                )
            ))                                      
            ->add('localidad_vereda')
            ->add('barrio')                
            //->add('estrato_socioeconomico')    
             ->add('estrato_socioeconomico','choice',array(
                'choices'=>array(
                    '0'=>'Estrato 0',
                    '1'=>'Estrato 1',
                    '2'=>'Estrato 2',
                    '3'=>'Estrato 3',
                    '4'=>'Estrato 4',
                    '5'=>'Estrato 5',
                    '6'=>'Estrato 6'  
                )
            ))                                                                                      
     
            //->add('sisben')
            ->add('sisben','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '1'=>'1',
                    '2'=>'2',
                    '3'=>'3',
                    '4'=>'4',
                    '5'=>'5',
                    '9'=>'No Aplica'  
                )
            ))                                         
            ->add('eps')
            ->add('ars')
            //->add('poblacion_vitima_conflito')     
            ->add('poblacion_vitima_conflito','choice',array(
                'choices'=>array(
                    '1'=>'En situación de desplazamiento',
                    '2'=>'Desvinculados de grupos armados',
                    '3'=>'Hijos de adultos desmovilizados',
                    '9'=>'No Aplica '
                   
                )
            ))                                                                                      
                                   
            //->add('ultimo_depto_expulsor')                                                            
            ->add('tipo_municipio_expulsor')
            ->add('ultimo_depto_expulsor', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))      
                                                 
            //->add('es_sector_privado')
             ->add('es_sector_privado','choice',array(
                'choices'=>array(
                    '1'=>'Si',
                    '2'=>'No'                                      
                )
            ))                                   
           // ->add('es_otro_municipio')
            ->add('es_otro_municipio','choice',array(
                'choices'=>array(
                    '1'=>'Si',
                    '2'=>'No'                                      
                )
            ))                                                 
            //->add('tipo_discapacidad') 
             ->add('tipo_discapacidad','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '1'=>'Sordera Profunda',
                    '2'=>'Hipoacusia o Baja audición',
                    '3'=>'Baja visión diagnosticada',
                    '4'=>'Ceguera',
                    '5'=>'Parálisis cerebral',
                    '6'=>'Lesión neuromuscular' ,
                    '7'=>'Autismo',
                    '8'=>'Deficiencia cognitiva (Retardo Mental)',
                    '9'=>'Síndrome de Down',
                    '10'=>'Múltiple  ',                    
                    '99'=>'No aplica'
                )
            ))                                   
                                              
            //->add('capacidad_excepcionales')   
               ->add('capacidad_excepcionales','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '1'=>'Superdotado',
                    '2'=>'Con talento científico',
                    '3'=>'Con talento tecnológico',
                    '4'=>'Con talento subjetivo',
                    '5'=>'No Aplica'
                    
                )
            ))                                   
                                     
            ->add('etnia')
            /* ->add('etnia', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=8')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              )) */                                   
            ->add('resguardo')
            /*->add('resguardo', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=9')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              )) */                                    
            ->add('parentesco')
            ->add('empresa')                
            ->add('telefono_empresa')                                                
            ->add('ocupacion')
            ->add('email')
            ->add('colegio_estudio_ultimo_ano')
            ->add('direccion_colegio_proveniente')                
            ->add('ano')                                
            //->add('motivo_retiro')
            //->add('grado_proveniente')  
            //->add('situacion_academica_ano_anterior')                                
            /*   ->add('situacion_academica_ano_anterior','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '0'=>'No Estudio',
                    '1'=>'Aprobo',
                    '2'=>'Reprobo',
                    '8'=>'No Culmino los Estudios',

                    
                )
            ))*/                                   
                                                                                     
            //->add('condicion_finalizar_ano_anterior')
             /*  ->add('condicion_finalizar_ano_anterior','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '3'=>'Deserto',
                    '5'=>'Transladado a Otra Institución',
                    '9'=>'No Aplica'

                )
            ))*/                                   
                                                                                     
            //->add('repitente')       
            /*   ->add('repitente','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '1'=>'No Repintente',
                    '2'=>'Repitente'
                )
            ))                                   
              */                                                                       
              /* ->add('es_nuevo','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '1'=>'No es Nuevo',
                    '2'=>'Nuevo'
                )
            ))  */                                 
                                                                                     
              /* ->add('es_habilitacion','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '1'=>'No Habilito',
                    '2'=>'Habilito'
                )
            ))                                   
                                                                                     
               ->add('posicion_academica')                                   
                */                                                                     

        ;
    }

    public function getName()
    {
        return 'alumno_perfil';
    }
        public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Netpublic\CoreBundle\Entity\Alumno',
        );
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\Alumno',
        ));
    }
}

?>
