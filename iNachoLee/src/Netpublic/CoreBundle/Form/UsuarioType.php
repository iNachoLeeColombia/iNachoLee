<?php

namespace Netpublic\CoreBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password','repeated',array(
                'type' => 'password',
                'invalid_message' => 'The password fields must match.',
                'options' => array('label' => 'Password'),
            ))
            //->add('salt')
            ->add('es_alumno')
            ->add('user_rol', 'entity', array(
                     'required' => false,
                     'class' => 'NetpublicCoreBundle:Rol',
                     'multiple'=>TRUE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->orderBy('u.role', 'ASC');
                                        },
                    ))
            ->add('profesor', 'entity', array(
                     'required' => false,
                     'class' => 'NetpublicCoreBundle:Profesor',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->orderBy('u.nombre', 'ASC');
                                        },
                    ))
            ->add('alumno', 'entity', array(
                     'required' => false,
                     'class' => 'NetpublicCoreBundle:Alumno',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->orderBy('u.nombre', 'ASC');
                                        },
                    ))
        ;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\Usuario',
        ));
    }

    public function getName()
    {
        return 'ntp_inacholeebundle_usuariotype';
    }
}
