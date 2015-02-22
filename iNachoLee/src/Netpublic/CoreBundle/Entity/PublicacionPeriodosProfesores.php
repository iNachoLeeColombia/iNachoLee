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
 * @ORM\Table(name="publicidad_periodos_profesores")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\PublicacionperiodosprofesoresRepository")
 */
class PublicacionPeriodosProfesores {
    
    /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
    * @ORM\ManyToOne(targetEntity="Profesor",inversedBy="publicida_periodos_profesores")    
    */    
    protected $profesor; //Horarios de toda la disponibilidad de el aula de clase   
    /**
    * @ORM\ManyToOne(targetEntity="Dimension",inversedBy="publicida_periodos_profesores")    
    */    
    protected $periodo_academico; //Horarios de toda la disponibilidad de el aula de clase   
    /**
     *
     * @ORM\Column(type="integer")
     */
    protected $tipo;
     /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $fecha_ultimo_publicacion;     
 
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $fecha_ultimo_ingreso;
       /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $fecha_ultimo_calificaion;     
 
 


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
     * @return PublicacionPeriodosProfesores
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    
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
     * Set profesor
     *
     * @param \Netpublic\CoreBundle\Entity\Profesor $profesor
     * @return PublicacionPeriodosProfesores
     */
    public function setProfesor(\Netpublic\CoreBundle\Entity\Profesor $profesor = null)
    {
        $this->profesor = $profesor;
    
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
     * Set periodo_academico
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $periodoAcademico
     * @return PublicacionPeriodosProfesores
     */
    public function setPeriodoAcademico(\Netpublic\CoreBundle\Entity\Dimension $periodoAcademico = null)
    {
        $this->periodo_academico = $periodoAcademico;    

    }

    /**
     * Get periodo_academico
     *
     * @return \Netpublic\CoreBundle\Entity\Dimension 
     */
    public function getPeriodoAcademico()
    {
        return $this->periodo_academico;
    }

    /**
     * Set fecha_ultimo_publicacion
     *
     * @param \DateTime $fechaUltimoPublicacion
     * @return PublicacionPeriodosProfesores
     */
    public function setFechaUltimoPublicacion($fechaUltimoPublicacion)
    {
        $this->fecha_ultimo_publicacion = $fechaUltimoPublicacion;
    
        return $this;
    }

    /**
     * Get fecha_ultimo_publicacion
     *
     * @return \DateTime 
     */
    public function getFechaUltimoPublicacion()
    {
        return $this->fecha_ultimo_publicacion;
    }

    /**
     * Set fecha_ultimo_ingreso
     *
     * @param \DateTime $fechaUltimoIngreso
     * @return PublicacionPeriodosProfesores
     */
    public function setFechaUltimoIngreso($fechaUltimoIngreso)
    {
        $this->fecha_ultimo_ingreso = $fechaUltimoIngreso;
    
        return $this;
    }

    /**
     * Get fecha_ultimo_ingreso
     *
     * @return \DateTime 
     */
    public function getFechaUltimoIngreso()
    {
        return $this->fecha_ultimo_ingreso;
    }

    /**
     * Set fecha_ultimo_calificaion
     *
     * @param \DateTime $fechaUltimoCalificaion
     * @return PublicacionPeriodosProfesores
     */
    public function setFechaUltimoCalificaion($fechaUltimoCalificaion)
    {
        $this->fecha_ultimo_calificaion = $fechaUltimoCalificaion;
    
        return $this;
    }

    /**
     * Get fecha_ultimo_calificaion
     *
     * @return \DateTime 
     */
    public function getFechaUltimoCalificaion()
    {
        return $this->fecha_ultimo_calificaion;
    }
}
