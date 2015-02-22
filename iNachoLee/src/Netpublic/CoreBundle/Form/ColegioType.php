<?php

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ColegioType extends AbstractType
{
    private $name="coelgio";
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('codigo_dane')
            ->add('numero_cifrasignificativa')
            ->add('numero_sedes','choice',array(
                 'choices'=>array(
                     '0'=>'0',
                     '1'=>'1',
                     '2'=>'2',
                     '3'=>'3',                     
                     '4'=>'4',
                     '5'=>'5',
                     '6'=>'6',
                     '7'=>'7',
                     '8'=>'8',
                     '9'=>'9',
                     '10'=>'10',
                     '11'=>'11',
                     '12'=>'12',
                     '13'=>'13',
                     '14'=>'14',
                     '15'=>'15',
                     '16'=>'16',
                     '17'=>'17',
                     '18'=>'18',
                     '19'=>'19',
                     '20'=>'20',
                     '21'=>'21',
                     '22'=>'22',
                     '23'=>'23',
                     '24'=>'24',
                     '25'=>'25',
                     '26'=>'26',
                     '27'=>'27',
                     '28'=>'28',
                     '29'=>'29',
                     '30'=>'30',
                     '31'=>'31',
                     '32'=>'32',
                     '33'=>'33'

                 ),
                 'empty_value'=>'Selecciona Numero de sedes'
             ))     
            ->add('es_subsidio')
            ->add('barrio')
            ->add('direccion')
            ->add('telefono')
            ->add('fax','text',array('required'=>FALSE,
                'label'=>"NIT"
            ))
            ->add('web')
            ->add('email')
            ->add('es_principal')
            ->add('numero_linc_func')
            ->add('rector')
            //->add('sector')
            ->add('sector', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=1')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))     
            //->add('calendario')
            ->add('calendario', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=3')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                                 
            //->add('propiedad_juridica')
            ->add('propiedad_juridica', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=4')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                                                                                 
            //->add('nucleo')*/
            ->add('nucleo', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=5')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                                 
            ->add('genero', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=2')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              )) 
            //->add('discapacidades')
            ->add('discapacidades', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=6')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                                             
            //->add('capacidades_excepcionales')
             ->add('capacidades_excepcionales', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=7')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                                                                                             
            //->add('etnias')
            ->add('etnias', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=8')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                                                                                                                                             
            //->add('resguardo')
            ->add('resguardo', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=9')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                                                                                                                                                                                              
            //->add('novedad_inst')
           ->add('novedad_inst', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=10')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                                                                                                                                                                                                                                               
            //->add('zona')                                     
                                                
            //->add('metodologia')
            ->add('metodologia', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=11')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                                                                                                                                                                                                                                               
            //->add('zona')
            ->add('zona', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=12')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                                                                                                                                                                                                                                               
                                                
            //->add('depto')
            ->add('depto', 'entity', array(
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
                                                 
            //->add('regimen_costos')
            ->add('regimen_costos', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=16')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                                                                                                                                                                                                                                               
                                                
            //->add('rango_promedio')
            ->add('rango_promedio', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=17')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                                                                                                                                                                                                                                               
                                                
            //->add('idioma')
            ->add('idioma', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=18')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                                                                                                                                                                                                                                               
                                                
            //->add('nucleo_privado')
            ->add('nucleo_privado', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=19')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))
             ->add('nota_minima')
             ->add('tipo_valoracion','choice',array(
                 'choices'=>array(
                     '0'=>'Valores: 1 - 5',
                     '1'=>'Valores: 1 - 10',
                     '2'=>'Valores: 0 - 5',
                     '3'=>'Valores: 0 - 10'                     
                 ),
                 'empty_value'=>'Selecciona Valoración'
             )) 
             ->add('valor_minimo_deficiente')
             ->add('valor_maximo_deficiente')                                                 
             ->add('valor_minimo_insuficiente')
             ->add('valor_maximo_insuficiente')                                                 
             ->add('valor_minimo_aceptable')
             ->add('valor_maximo_aceptable')                                                 
             ->add('valor_minimo_sobresaliente')
             ->add('valor_maximo_sobresaliente')                                                 
             ->add('maximo_areas_habilitar')
             //->add('valor_maximo_excelente')   
             ->add('escudo_colegio','file',array('required'=>FALSE))                                  
             ->add('himno_colegio')                                 
                                                
                                                
                                    
        ;
    }

     public function getName()
    {
        return $this->name;
    }
    public function setName($name){
        $this->name=$name;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\Colegio',
        ));
    }
}
