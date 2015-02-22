<?php

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CondicionGrupoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo')
            ->add('dia_columna')
            ->add('hora_fila')
            ->add('valor')
            ->add('grupo')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\CondicionGrupo'
        ));
    }

    public function getName()
    {
        return 'netpublic_bundle_corebundle_condiciongrupotype';
    }
}
