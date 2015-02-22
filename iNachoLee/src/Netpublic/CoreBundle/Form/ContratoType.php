<?php

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\CallbackValidator;
use Doctrine\ORM\EntityRepository;
class ContratoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('horas_contratadas')
            //->add('horas_buffer')
            //->add('profesor_contrato')
            ->add('asignatura')
            ->add('grado', 'entity',  array(
                    "mapped" => false,
                    'label'=>"Grado",
                    'attr'=>array('onChange'=>'getAsignaturaGrado(this);'),
                    'empty_value' => " ",
                    'class' => 'NetpublicCoreBundle:Grado',
                    'query_builder' => function(EntityRepository $er) {
                                            return $er->createQueryBuilder('u')
                                                      ->orderBy('u.nombre', 'ASC');
                                        },                                           )
                     
                    );
 /*
 
        $builder->addValidator(new CallbackValidator(function(FormInterface $form)
            {
                if (!$form["grado"]->getData())
                {
                    $form->addError(new FormError('Please accept the terms and conditions in order to register'));
                }
            })
        );*/
    }

    public function getName()
    {
        return 'ntp_inacholeebundle_contratotype';
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\Contrato',
        ));
    }
}
