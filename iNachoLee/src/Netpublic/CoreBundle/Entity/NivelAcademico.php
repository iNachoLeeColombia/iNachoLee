<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="nivel_academico")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\NivelacademicoRepository")
 */
class NivelAcademico {
    
    /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $puesto;
    /**
     * tipo=0 grupo     
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $tipo;
        /**
     * @ORM\Column(type="float",nullable=true)
     */
    protected $nota=0;

     /**
    * @ORM\ManyToOne(targetEntity="Alumno",inversedBy="nivel_academico")    
    */    
    protected $alumno;
     /**
    * @ORM\ManyToOne(targetEntity="Dimension",inversedBy="nivel_academico")    
    */    
    protected $periodo_actual;
    /**
     *@ORM\Column(type="date",nullable=true) 
     */
    protected $fecha_actualizacion;
    
    public function __toString(){
        return "".$this->puesto;
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
     * Set puesto
     *
     * @param integer $puesto
     * @return NivelAcademico
     */
    public function setPuesto($puesto)
    {
        $this->puesto = $puesto;
    
        return $this;
    }

    /**
     * Get puesto
     *
     * @return integer 
     */
    public function getPuesto()
    {
        return $this->puesto;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     * @return NivelAcademico
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
     * Set nota
     *
     * @param float $nota
     * @return NivelAcademico
     */
    public function setNota($nota)
    {
        $this->nota = $nota;
    
        return $this;
    }

    /**
     * Get nota
     *
     * @return float 
     */
    public function getNota()
    {
        return $this->nota;
    }

    /**
     * Set fecha_actualizacion
     *
     * @param \DateTime $fechaActualizacion
     * @return NivelAcademico
     */
    public function setFechaActualizacion($fechaActualizacion)
    {
        $this->fecha_actualizacion = $fechaActualizacion;
    
        return $this;
    }

    /**
     * Get fecha_actualizacion
     *
     * @return \DateTime 
     */
    public function getFechaActualizacion()
    {
        return $this->fecha_actualizacion;
    }

    /**
     * Set alumno
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $alumno
     * @return NivelAcademico
     */
    public function setAlumno(\Netpublic\CoreBundle\Entity\Alumno $alumno = null)
    {
        $this->alumno = $alumno;
    
        return $this;
    }

    /**
     * Get alumno
     *
     * @return \Netpublic\CoreBundle\Entity\Alumno 
     */
    public function getAlumno()
    {
        return $this->alumno;
    }

    /**
     * Set periodo_actual
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $periodoActual
     * @return NivelAcademico
     */
    public function setPeriodoActual(\Netpublic\CoreBundle\Entity\Dimension $periodoActual = null)
    {
        $this->periodo_actual = $periodoActual;
    
        return $this;
    }

    /**
     * Get periodo_actual
     *
     * @return \Netpublic\CoreBundle\Entity\Dimension 
     */
    public function getPeriodoActual()
    {
        return $this->periodo_actual;
    }
}
