<?php

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HorarioGrupoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo')
            ->add('dia_columna')
            ->add('hora_fila')
            ->add('posicion')
            ->add('posicion_columna')
            ->add('valor')
            ->add('carga_academica')
            ->add('grupo')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\HorarioGrupo'
        ));
    }

    public function getName()
    {
        return 'netpublic_bundle_corebundle_horariogrupotype';
    }
}
