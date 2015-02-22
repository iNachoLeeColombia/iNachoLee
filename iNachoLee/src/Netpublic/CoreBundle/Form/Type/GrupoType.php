<?php
namespace Netpublic\CoreBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GrupoType
 *
 * @author yuri
 */
class GrupoType extends AbstractType {
     public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre');
        //$builder->add('alumnos', 'collection', array('type' => new AlumnoType()));
    }
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Netpublic\CoreBundle\Entity\Grupo',
        );
    }
    public function getName()
    {
        return 'grupo';
    }

    
}

?>
