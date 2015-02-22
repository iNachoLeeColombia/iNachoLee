<?php

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Netpublic\CoreBundle\Form\GrupoType;
use Netpublic\CoreBundle\Form\ProfesorType;
use Netpublic\CoreBundle\Form\AsignaturaType;
use Doctrine\ORM\EntityRepository;
use Netpublic\CoreBundle\Entity\HorarioAula;

class CargaAcademicaType extends AbstractType
{
    protected $nombre;
    //
    protected $horario_aula;
    public function __construct(HorarioAula $horario_aula){        
        $this->horario_aula=$horario_aula;
        
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $aula_id=$this->horario_aula->getAula()->getId();
        $asignatura= $this->horario_aula->getAsignatura()->getId();
        $builder->add('profesor')
                 ->add('grupo')
                ->add('asignatura')
                 ->add('aula')
                 //->add('horario_aula')
                ->add('horario_aula', 'entity', array(
                     'class' => 'NetpublicCoreBundle:HorarioAula',
                     'multiple'=>FALSE,
                     "empty_value"=>"$this->horario_aula",
                     'query_builder' => function($repository) use ($asignatura,$aula_id) { 
                             return $repository->createQueryBuilder('F')
                                               ->where('F.asignatura=:asignatura_id') 
                                               ->andWhere('F.aula=:aula_id')                                               
                                               ->setParameters(array(
                                                "asignatura_id"=>$asignatura,
                                                "aula_id"=>$aula_id   
                                               ));
                            },
                      'required' => false              
                    ))
            ;
    }

    public function getName()
    {
        return $this->nombre;
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Netpublic\CoreBundle\Entity\CargaAcademica',
        );
    }
    public function setName($nombre){
        $this->nombre=$nombre;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\CargaAcademica',
        ));
    }
}
