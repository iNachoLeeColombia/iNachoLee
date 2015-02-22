<?php

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class GrupoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('nombre')
            ->add('director_grupo')    
            ->add('grado', 'entity', array(
                     'class' => 'NetpublicCoreBundle:Grado',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->orderBy('u.id', 'ASC');
                                        },
                    )) 
            
        ;
    }

    public function getName()
    {
        return 'ntp_inacholeebundle_grupotype';
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\Grupo',
        ));
    }
}
