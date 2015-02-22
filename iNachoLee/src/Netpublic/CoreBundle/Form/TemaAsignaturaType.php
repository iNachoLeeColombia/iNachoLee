<?php

namespace Netpublic\CoreBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class TemaAsignaturaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tema')
            //->add('asignatura')
        ;
    }

    public function getName()
    {
        return 'ntp_inacholeebundle_temaasignaturatype';
    }
        public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\TemaAsignatura',
        ));
    }

}
