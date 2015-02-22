<?php

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
class ProfesorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('nombre',null,array(
                'attr'=>array("class"=>"form-control"),
                'label'=>'Primer Nombre.')
                 )
            ->add('nombre1',null,array(
                'label'=>'Segundo Nombre.',
                'attr'=>array("class"=>"form-control")
                ))
            ->add('apellido',null,array(
                'label'=>'Primer Apellido.',
                'attr'=>array("class"=>"form-control")
                ))                                                
            ->add('apellido1',null,array(
                'label'=>'Segundo Apellido.',
                'attr'=>array("class"=>"form-control")
                ))                    
             ->add('tipo_documento','choice',array(
                 'attr'=>array("class"=>"form-control"),
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
                )))
             ->add('tipo','choice',array(
                 'attr'=>array("class"=>"form-control"),
                 'empty_value' => '             ',
                 "required"=>false,
                'choices'=>array(                    
                    '1'=>'Rector',
                    '2'=>'Profesor Normal',
                    '3'=>"Secretaria Auxiliar",
                    '4'=>'Coordinador Acádemico',
                    '5'=>"Coordinador De Convivencia"
                   
                )))   
            ->add('cedula','text',  array(
                'attr'=>  array(
                    'onblur'=> 'getAlumnoCedulaProfesor();',
                    "class"=>"form-control"
                    )
            )) 
            ->add('sede', 'entity', array(
                 'required'=>FALSE,
                                  'empty_value' => '             ',
                     'class' => 'NetpublicCoreBundle:Colegio',
                     'multiple'=>FALSE,
                     'attr'=>array("class"=>"form-control"),
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u');
                                                      //->where('u.variable=14')  
                                                      //->orderBy('u.id', 'ASC');
                                        },
              ))           
                
            //->add('genero')    
            ->add('genero','choice',array(
                'attr'=>array("class"=>"form-control"),
                'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    
                    '1'=>'Masculino',
                    '2'=>'Femenino'
                )))                
            ->add('clase')        
            ->add('fecha_nacimiento')        
             ->add('departamento', 'entity', array(
                 'required'=>FALSE,
                                  'empty_value' => '             ',
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))       
             ->add('municipio', 'entity', array(
                 'required'=>FALSE,
                                  'empty_value' => '             ',
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=14')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))           
            //->add('estado_civil')        
            ->add('estado_civil','choice',array(
                'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(                    
                    '1'=>'Soltero',
                    '2'=>'Casado',
                    '3'=>"Union Libre"
                )))                
            ->add('numero_hijos')                        
            ->add('fecha_retiro') 
            ->add('fecha_vinculacion') 
            ->add('libreta_militar')                 
            ->add('distrito')        
            ->add('resolucion_nombramiento')        
//            ->add('nivel_educativo_aprobado')        
->add('nivel_educativo_aprobado','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'Sin titulo',
                    '2'=>'Bachiller pedagógico',
                    '3'=>'Normalista superior',
                    '4'=>"Otro bachiller",
                    '5'=>"Técnico o tecnólogo en educación",
                    "6"=>"Técnico o tecnólogo en otras áreas",
                    '7'=>"Profesional o licenciado en educación",
                    '8'=>"Profesional en otras áreas, no licenciado",
                    "9"=>"Postgrado en educación",
                    "10"=>"Postgrado en otras áreas"
                )))   
->add('ubicacion','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'1 Establecimiento educativo',
                    '2'=>'2 En Comisión',
                    '3'=>'3 Otros'

                )))    
->add('cargo','choice',array(
    'required'=>FALSE,
    'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'1 Docente',
                    '2'=>'2 Directivo Docente'                  

                )))                  
->add('zona','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'1 Zona urbana',
                    '2'=>'2 Zona rural',
                    '3'=>'3 No aplica'

                )))    
->add('fuente_recursos','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'1 SGP',
                    '2'=>'2 Recursos propios (de la Entidad Territorial)'
   
                )))    
->add('tipo_vinculacion','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'1 Con nombramiento en propiedad',
                    '2'=>'2 Con nombramiento provisional en una vacante definitiva',
                    '3'=>'3 Con nombramiento provisional en una vacante temporal',
                    '4'=>"4 Con nombramiento en período de prueba"
                   
                )))                 
->add('nombre_cargo','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'1  Docente de aula',
                    '2'=>'2 Docente con funciones de apoyo para alumnos con necesidades educativas especiales',
                    '3'=>'3 Docente con funciones de orientador',
                    '4'=>"4  Coordinador",
                    '5'=>"5  Director rural",
                    "6"=>"6  Rector",
                    '7'=>"7  Director de núcleo",
                    '8'=>"8  Supervisor de educación"
                   
                )))   
->add('doc_dir_comision','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'1 Para ocupar un cargo de libre nombramiento y remoción',
                    '2'=>'2 De estudios remunerada',
                    '3'=>'3 De estudios no remunerada',
                    '4'=>"4 De Servicios",
                    '4'=>"5 No Aplica"
                                     
                )))   
->add('amenazados','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '0'=>'No',
                    '1'=>'Si'
                 
                )))   

            
            
            ->add('fecha_status_amenazado')                        
            ->add('estado_civil')        
            ->add('numero_hijos')                                        
            ->add('fecha_retiro')        
            ->add('libreta_militar')                        
            ->add('distrito')        

->add('grado_escalafon','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'SE Sin escalafón',
                    '2'=>'BC Bachiller',
                    '3'=>'PT Profesional técnico o tecnológico en educación',
                    '4'=>"PU Profesional universitario",
                    '5'=>"Técnico o tecnólogo en educación",
                    "6"=>"IA Instructor II-A",
                    '7'=>"IB Instructor III-B",
                    '8'=>"IC Instructor IV-C",
                    "9"=>"A",
                    "10"=>"B",
                    '11'=>'01',
                    '12'=>'02',
                    '13'=>'03',
                    '14'=>"04",
                    '15'=>"05",
                    "16"=>"06",
                    '17'=>"07",
                    '18'=>"08",
                    "19"=>"09",
                    "20"=>"10",
                    '21'=>'11',
                    '22'=>'12',
                    '23'=>'13',
                    '24'=>"14",
                    '25'=>"1A",
                    "26"=>"1B",
                    '27'=>"1C",
                    '28'=>"1D",
                    "29"=>"29",
                    '30'=>"2A",
                    "31"=>"2B",
                    '32'=>"2C",
                    '33'=>"2D",
                    "34"=>"3AM Maestria",                  
                    '35'=>"3BM Maestria",
                    "36"=>"3CM Maestria",
                    '37'=>"3DM Maestria",
                    '38'=>"3AD Doctorado",
                    "39"=>"3BD Doctorado",
                    '40'=>"3CD Doctorado",
                    "41"=>"3DD Doctorado",
                  
                    
                )))                 
->add('sobresueldo_recibido','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'No Aplica / Sin Sobresueldo',
                    '2'=>'Sobresueldo 5%',
                    '3'=>'Sobresueldo 10%',
                    '4'=>"Sobresueldo 15%",
                    '5'=>"Sobresueldo 20%",
                    "6"=>"Sobresueldo 25%",
                    '7'=>"Sobresueldo 30%",
                    '8'=>"Sobresueldo 35%",
                    "9"=>"Sobresueldo 40%",
                    "10"=>"Sobresueldo 18%"                 
                    
                )))                 

->add('nivel_ensenanza','choice',array(
    'required'=>FALSE,
                'empty_value' => '0',
                'choices'=>array(
                    '1'=>'Preescolar',
                    '2'=>'Básica Primaria',
                    '3'=>'Básica Secundaria y Media',
                    '4'=>"Ciclo Complementario (Normales)",
                    '5'=>"No Aplica"                
                )))                 

->add('etnoeducador','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'Raizal',
                    '2'=>'Afrocolombiano',
                    '3'=>'Indigena',
                    '4'=>"No Aplica"                     
                )))                 
->add('area_ensenanza_nombrado','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'Preescolar',
                    '2'=>'Primaria',
                    '3'=>'Ciencias Naturales y Educación Ambiental',
                    '4'=>"Ciencias Sociales",
                    '5'=>"Educ. Artistica - Artes plásticas",
                    "6"=>"Educ. Artistica - Música",
                    '7'=>"Educ. Artistica - Artes Escenica",
                    '8'=>"Educ. Artistica - Danzas",
                    "9"=>"Educ. Física, Recreación y Deporte",
                    "10"=>"Educ. Etica y en Valores",
                    '11'=>'Educ. Religiosa',
                    '12'=>'Humanidades y Lengua Castellana',
                    '13'=>'Idioma Extranjero Francés',
                    '14'=>"Idioma Extranjero Inglés",
                    '15'=>"Matemáticas",
                    "16"=>"Tecnología e Informática",
                    '17'=>"Ciencias Naturales Química",
                    '18'=>"Ciencias Naturales Física",
                    "19"=>"Filosofía",
                    "20"=>"Ciencias Económicas y Políticas",
                    '21'=>'Areas de Apoyo Para educación Especial',
                    '22'=>'No aplica'
                )))                                       
 ->add('area_ensenanza_tecnica','choice',array(
     'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'Finanzas - Administración y Seguros',
                    '2'=>'Ventas y Servicios',
                    '3'=>'Ciencias Naturales y Aplicadas',
                    '4'=>"Salud",
                    '5'=>"Ciencias Sociales, Educación, Servicios Gubernamentales y Religión",
                    "6"=>"Cultura, Arte, Esparcimiento y Deporte",
                    '7'=>"Explotación Primaria y Extractiva",
                    '8'=>"Operadores del Equipo y Transporte Instalación y Mantenimiento",
                    "9"=>"Procesamiento, Fabricación y Ensamble",
                    "10"=>"Otras",
                    '11'=>'No aplica'
                )))                                       
           
            
            ->add('descripcion_otra_area')        
                                                                
            //->add('url_foto')
            //->add('contrato')  
           // ->add('horas_trabajo_semanales')
             ->add('foto_academica','file',array(
                 'required'=>FALSE,
                 'attr'=>array("class"=>"form-control")
                 ))    
            ->add('foto_firma','file',array(
                'required'=>FALSE,
                'attr'=>array("class"=>"form-control")
                ))            
        ;
    }

    public function getName()
    {
        return 'ntp_inacholeebundle_profesortype';
    }
        public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\Profesor',
        ));
    }

}
