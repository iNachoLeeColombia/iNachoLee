<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CargaAcademicaAutomatica
 *
 * @author yuri
 */

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Netpublic\CoreBundle\Form\GrupoType;
use Netpublic\CoreBundle\Form\ProfesorType;
use Netpublic\CoreBundle\Form\AsignaturaType;
use Doctrine\ORM\EntityRepository;
class CargaAcademicaAutomaticaType  extends AbstractType {
        public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dias_entre_clases','text')
                 ->add('duracion_clases','text')
            ;
    }

    public function getName()
    {
        return 'carga_automatica';
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\CargaAcademicaAutomatica',
        ));
    }
    
}

?>
