<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MatriculaAlumno
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="matricula_alumno")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\MatriculaAlumnoRepository")
 */
class MatriculaAlumno {
      /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Dimension",inversedBy="matricula_alumno")    
    */
   protected $ano;
    /**
     * @ORM\ManyToOne(targetEntity="Grupo",inversedBy="matricula_alumno")    
    */
   protected $grupo;
   
   
    /**
    * @ORM\ManyToOne(targetEntity="Alumno",inversedBy="matricula_alumno")    
    */    
    protected $alumno;
    
    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $es_matricula=null;
     /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $es_ultima_matricula=null;
    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $es_pago_matricula=null;/**
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $es_papeles=null;
    /**
     * @ORM\Column(type="string")
     */
    protected $observaciones=null;
    public function __toString(){
       return "{$this->alumno->getApellido()} {$this->alumno->getApellido1()} {$this->alumno->getNombre1()} {$this->alumno->getNombre()}";
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
     * Set es_matricula$examen_grupo
     *
     * @param boolean $esMatricula
     */
    public function setEsMatricula($esMatricula)
    {
        $this->es_matricula = $esMatricula;
    }

    /**
     * Get es_matricula
     *
     * @return boolean 
     */
    public function getEsMatricula()
    {
        return $this->es_matricula;
    }

    /**
     * Set es_pago_matricula
     *
     * @param boolean $esPagoMatricula
     */
    public function setEsPagoMatricula($esPagoMatricula)
    {
        $this->es_pago_matricula = $esPagoMatricula;
    }

    /**
     * Get es_pago_matricula
     *
     * @return boolean 
     */
    public function getEsPagoMatricula()
    {
        return $this->es_pago_matricula;
    }

    /**
     * Set es_papeles
     *
     * @param boolean $esPapeles
     */
    public function setEsPapeles($esPapeles)
    {
        $this->es_papeles = $esPapeles;
    }

    /**
     * Get es_papeles
     *
     * @return boolean 
     */
    public function getEsPapeles()
    {
        return $this->es_papeles;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set ano
     *
     * @param Netpublic\CoreBundle\Entity\Dimension $ano
     */
    public function setAno(\Netpublic\CoreBundle\Entity\Dimension $ano)
    {
        $this->ano = $ano;
    }

    /**
     * Get ano
     *
     * @return Netpublic\CoreBundle\Entity\Dimension 
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * Set alumno
     *
     * @param Netpublic\CoreBundle\Entity\Alumno $alumno
     */
    public function setAlumno(\Netpublic\CoreBundle\Entity\Alumno $alumno)
    {
        $this->alumno = $alumno;
    }

    /**
     * Get alumno
     *
     * @return Netpublic\CoreBundle\Entity\Alumno 
     */
    public function getAlumno()
    {
        return $this->alumno;
    }

    /**
     * Set es_ultima_matricula
     *
     * @param boolean $esUltimaMatricula
     */
    public function setEsUltimaMatricula($esUltimaMatricula)
    {
        $this->es_ultima_matricula = $esUltimaMatricula;
    }

    /**
     * Get es_ultima_matricula
     *
     * @return boolean 
     */
    public function getEsUltimaMatricula()
    {
        return $this->es_ultima_matricula;
    }

    /**
     * Set grupo
     *
     * @param \Netpublic\CoreBundle\Entity\Grupo $grupo
     * @return MatriculaAlumno
     */
    public function setGrupo(\Netpublic\CoreBundle\Entity\Grupo $grupo = null)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo
     *
     * @return \Netpublic\CoreBundle\Entity\Grupo 
     */
    public function getGrupo()
    {
        return $this->grupo;
    }
}
