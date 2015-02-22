<?php
namespace Netpublic\CoreBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AlumnoDimensionType
 *
 * @author yuri
 */
class AlumnodimensionType extends AbstractType{
    private $id;
    public $tipo;
    public $es_hija_periodo;
    private $alumno_id;
    private $es_ready_only;
    public function __construct($id=0,$tipo=-1,$es_hija_periodo=false,$alumno_id=0,$es_ready_only=FALSE) {
        $this->id=$id;     
        $this->tipo=$tipo;
        $this->es_hija_periodo=$es_hija_periodo;
        $this->alumno_id=$alumno_id;
        $this->es_ready_only=$es_ready_only;
        
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $disabled="1";
        switch ($this->tipo) {
            case 1:{
                $class="grupoPeriodoFinal input_nota notas_alumno{$this->alumno_id} notas_alumno_padre{$this->alumno_id}";
                $disabled="disabled";
                break;
            }
            case 4:{
                 $class="grupoAtividades input_nota grupoB notas_alumno{$this->alumno_id}";
                 if($this->es_hija_periodo)
                     $class="grupoPeriodoFinal input_nota notas_alumno{$this->alumno_id}  notas_alumno_padre{$this->alumno_id}";
                break;
            }
            case 3:{
                 $class="grupoAsistencia input_nota notas_alumno_fallas{$this->alumno_id}";
                break;
            }
            default:
                $class="input_nota";
                break;
        }
        
        $propiedades=array(
            'label' => "notas",            
            'onclick' => "procesarClick(this);",
            'onfocus' => "procesarFocus(this);",
            'onblur' => "procesarOnblur(this);",
            'class' => $class,
            'style' =>"width: 40px; height: 35px;",
            'data-id'=>  $this->id,
            'data-alumno'=>  $this->alumno_id
           
        );
        if($this->es_ready_only){
            $propiedades["disabled"]="disabled";
        }
	if ($this->tipo==1){
		;//$propiedades["disabled"]='disabled';	
	}
        $options = array(
        'required' => TRUE,
        'attr' => $propiedades
    );
        $builder->add('nota','text',$options);   
        //$builder->add('id','hidden');

        
        
    }
    public function getName()
    {
        return "r".$this->id;
    }

    
}

?>
