<?php
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Contrato
 *
 * @author yuri
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="criterio_promocion")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\CriteriopromocionRepository")
 */

class CriterioPromocion {
         /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;
     /**
      * Tipo=0 Criterio Por perdida De Año
      * Tipo=1 Criterio Para habilitar
      * @ORM\Column(type="integer")
     */
    protected $tipo;
     /**
      * Nro areas|asignaturas perdididas|habilitadas
     * @ORM\Column(type="float",nullable=true)
     */
    protected $valor;    
    /**
     * Es area|Asignaturas perdidas
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $es_area_asg;
    /**
     * set asignatura perdidas o ganadas
     * @ORM\ManyToOne(targetEntity="Asignatura",inversedBy="criterio_promocion")
     * 
     *  
     */
   protected $area_asignatura;   
    /**
     * 
    * @ORM\Column(type="string",nullable=true))
    * 
     */
   protected $simbolo;
    /**
    * @ORM\ManyToOne(targetEntity="Grado",inversedBy="cond_perder")    
    */    
    protected $grado;
   
    public function __toString(){
        $grado='';
        if($this->grado==null){
            $grado=" todos los grados";
        }
        else{
            $grado="{{$this->grado}}";
        }
        if($this->tipo==0){
            $tipo="Habilita"; 
        }
        else{
            $tipo="Pierde";
        }
        if($this->es_area_asg==0){
            $es_area_asg="nro areas"; 
        }
        else{
            $es_area_asg="nro asignaturas";
        }
        $res="$tipo año escolar en $grado si $es_area_asg perdidas es ".$this->simbolo.$this->valor; 
       
        return $res;
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     * @return CriterioPromocion
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return integer 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set valor
     *
     * @param float $valor
     * @return CriterioPromocion
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return float 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set es_area_asg
     *
     * @param integer $esAreaAsg
     * @return CriterioPromocion
     */
    public function setEsAreaAsg($esAreaAsg)
    {
        $this->es_area_asg = $esAreaAsg;

        return $this;
    }

    /**
     * Get es_area_asg
     *
     * @return integer 
     */
    public function getEsAreaAsg()
    {
        return $this->es_area_asg;
    }

    /**
     * Set simbolo
     *
     * @param string $simbolo
     * @return CriterioPromocion
     */
    public function setSimbolo($simbolo)
    {
        $this->simbolo = $simbolo;

        return $this;
    }

    /**
     * Get simbolo
     *
     * @return string 
     */
    public function getSimbolo()
    {
        return $this->simbolo;
    }

    /**
     * Set area_asignatura
     *
     * @param \Netpublic\CoreBundle\Entity\Asignatura $areaAsignatura
     * @return CriterioPromocion
     */
    public function setAreaAsignatura(\Netpublic\CoreBundle\Entity\Asignatura $areaAsignatura = null)
    {
        $this->area_asignatura = $areaAsignatura;

        return $this;
    }

    /**
     * Get area_asignatura
     *
     * @return \Netpublic\CoreBundle\Entity\Asignatura 
     */
    public function getAreaAsignatura()
    {
        return $this->area_asignatura;
    }

    /**
     * Set grado
     *
     * @param \Netpublic\CoreBundle\Entity\Grado $grado
     * @return CriterioPromocion
     */
    public function setGrado(\Netpublic\CoreBundle\Entity\Grado $grado = null)
    {
        $this->grado = $grado;

        return $this;
    }

    /**
     * Get grado
     *
     * @return \Netpublic\CoreBundle\Entity\Grado 
     */
    public function getGrado()
    {
        return $this->grado;
    }
}
