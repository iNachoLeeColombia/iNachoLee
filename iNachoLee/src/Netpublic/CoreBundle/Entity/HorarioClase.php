<?php
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HorarioClase
 *
 * @author yuri
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="horario_clase")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\HorarioClaseRepository")
 */
class HorarioClase {
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * 0 esta libre
     * 1 esta ocupada
     * 2 es dia festivo
     * 3 es para guardar hora
     * 4 Reservada para una asignatura en un grupo especifico
     * @ORM\Column(type="integer")
     */
    protected $tipo;
    /**
     * @ORM\Column(type="integer")
     */
    protected $dia_columna;
    /**
     * @ORM\Column(type="integer")
     */
    protected $hora_fila;
    
   /**
    * @ORM\ManyToOne(targetEntity="CargaAcademica",inversedBy="horario_clase")
    */    
   protected $carga_academica;
   /**
    * @ORM\ManyToOne(targetEntity="Profesor",inversedBy="horario_clase")
    */    
   protected $profesor;

   /**
    *
    * @ORM\Column(type="integer",nullable=true)
    */
   protected $posicion;
   /**
    *
    * @ORM\Column(type="integer",nullable=true)
    */
   protected $posicion_columna;
       /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $valor;

   public function __toString() { 
   
       
       return ".".$this->hora_fila;
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
     * Set hora_inicio
     *
     * @param integer $horaInicio
     * @return HorarioClase
     */
    public function setHoraInicio($horaInicio)
    {
        $this->hora_inicio = $horaInicio;
    
        return $this;
    }

    /**
     * Get hora_inicio
     *
     * @return integer 
     */
    public function getHoraInicio()
    {
        return $this->hora_inicio;
    }

    /**
     * Set hora_final
     *
     * @param integer $horaFinal
     * @return HorarioClase
     */
    public function setHoraFinal($horaFinal)
    {
        $this->hora_final = $horaFinal;
    
        return $this;
    }

    /**
     * Get hora_final
     *
     * @return integer 
     */
    public function getHoraFinal()
    {
        return $this->hora_final;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     * @return HorarioClase
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
     * Set dia_columna
     *
     * @param integer $diaColumna
     * @return HorarioClase
     */
    public function setDiaColumna($diaColumna)
    {
        $this->dia_columna = $diaColumna;
    
        return $this;
    }

    /**
     * Get dia_columna
     *
     * @return integer 
     */
    public function getDiaColumna()
    {
        return $this->dia_columna;
    }

    /**
     * Set hora_fila
     *
     * @param integer $horaFila
     * @return HorarioClase
     */
    public function setHoraFila($horaFila)
    {
        $this->hora_fila = $horaFila;
    
        return $this;
    }

    /**
     * Get hora_fila
     *
     * @return integer 
     */
    public function getHoraFila()
    {
        return $this->hora_fila;
    }

    /**
     * Set posicion
     *
     * @param integer $posicion
     * @return HorarioClase
     */
    public function setPosicion($posicion)
    {
        $this->posicion = $posicion;
    
        return $this;
    }

    /**
     * Get posicion
     *
     * @return integer 
     */
    public function getPosicion()
    {
        return $this->posicion;
    }

    /**
     * Set carga_academica
     *
     * @param \Netpublic\CoreBundle\Entity\CargaAcademica $cargaAcademica
     * @return HorarioClase
     */
    public function setCargaAcademica(\Netpublic\CoreBundle\Entity\CargaAcademica $cargaAcademica = null)
    {
        $this->carga_academica = $cargaAcademica;
    
        return $this;
    }

    /**
     * Get carga_academica
     *
     * @return \Netpublic\CoreBundle\Entity\CargaAcademica 
     */
    public function getCargaAcademica()
    {
        return $this->carga_academica;
    }

    /**
     * Set profesor
     *
     * @param \Netpublic\CoreBundle\Entity\Profesor $profesor
     * @return HorarioClase
     */
    public function setProfesor(\Netpublic\CoreBundle\Entity\Profesor $profesor = null)
    {
        $this->profesor = $profesor;
    
        return $this;
    }

    /**
     * Get profesor
     *
     * @return \Netpublic\CoreBundle\Entity\Profesor 
     */
    public function getProfesor()
    {
        return $this->profesor;
    }

    /**
     * Set posicion_columna
     *
     * @param integer $posicionColumna
     * @return HorarioClase
     */
    public function setPosicionColumna($posicionColumna)
    {
        $this->posicion_columna = $posicionColumna;
    
        return $this;
    }

    /**
     * Get posicion_columna
     *
     * @return integer 
     */
    public function getPosicionColumna()
    {
        return $this->posicion_columna;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return HorarioClase
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    
        return $this;
    }

    /**
     * Get valor
     *
     * @return string 
     */
    public function getValor()
    {
        return $this->valor;
    }
}
