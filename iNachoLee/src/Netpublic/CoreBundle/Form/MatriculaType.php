<?php

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class MatriculaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('es_matricula')
            ->add('es_pago_matricula')
            ->add('es_papeles')
            ->add('observaciones')
            ->add('alumno')    
        ;
    }

    public function getName()
    {
        return 'ntp_inacholeebundle_matriculatype';
    }
        public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\Matricula',
        ));
    }

}
