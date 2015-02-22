<?php

namespace Netpublic\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class MensajeType extends AbstractType
{
    private $tipo;
    public function __construct($tipo) {
        $this->tipo=$tipo;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $b=$builder
            ->add('destino','text',array(
                'required' => TRUE,
                'attr'=> array(
                    //'onkeyup'=> 'filtroUsuarioMensaje(this)',
                    //'onblur'=> 'filtroUsuario_no_focus()',
                   // 'onfocus'=> 'filtroUsuario_focus()'
                  //  'data-source'=>'[]',
                   'style'=>"width:0px;color:#F5F5F5;border:none;border-color:#F5F5F5;background-color:#F5F5F5;",
                    //'data-provide'=>"typeahead"
                    
               )
                
            ))
            ->add('destinot','text',array(
                'required' => FALSE,
                "mapped" => false,
                'attr'=> array(
                    //'onkeyup'=> 'filtroUsuarioMensaje(this)',
                    //'onblur'=> 'procesarDejadaFocusDestinotemporal()',
                   // 'onfocus'=> 'procesarDejadaFocusDestinotemporal()'
                    'data-source'=>'[]',
                     'data-items'=>"9",
                    'style'=>'border:none;',
                    'class'=>"span5",
                    'data-provide'=>"typeahead"
                    
               )
                
            ))    
            //->add('url_doc_adjunto')    
            ->add('doc_adjunto','file',array('required'=>FALSE))    
            ->add('cuerpo_html')            
                
            ->add('asunto','text',array(
                'attr'=>array(
                     'onfocus'=> 'procesarDejadaFocusDestinotemporal()'
                )
            ));    
            //->add('tipo')                
            if($this->tipo)
            $b->add('tipo','choice',array(
                 'choices'=>array(
                     '0'=>'Informativo',
                     '1'=>'Llamado De Atención',
                     '2'=>'Felicitaciones',
                     '3'=>'Boletines'                     
                 ),
                 'empty_value'=>'             '
             ));
            else
                            $b->add('tipo','choice',array(
                 'choices'=>array(
                     '0'=>'Informativo',
                     '1'=>'Llamado De Atención',
                     '2'=>'Felicitaciones'
                 ),
                 'empty_value'=>'             '
             ));

    }

    public function getName()
    {
        return 'ntp_inacholeebundle_mensajetype';
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Netpublic\CoreBundle\Entity\Mensaje',
        ));
    }

}
