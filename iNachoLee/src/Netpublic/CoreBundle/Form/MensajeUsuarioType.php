<?php

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
class MensajeUsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha_envio')
            ->add('fecha_lectura')
            //->add('usuario')
            ->add('mensaje')
        ;
    }

    public function getName()
    {
        return 'ntp_inacholeebundle_mensajeusuariotype';
    }
        public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\MensajeUsuario',
        ));
    }

}
