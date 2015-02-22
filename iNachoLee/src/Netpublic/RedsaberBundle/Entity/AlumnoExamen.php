<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AlumnoExamen
 *
 * @author yuri
 */
namespace Netpublic\RedsaberBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="alumno_examen_redsaber")
 * @ORM\Entity(repositoryClass="Netpublic\RedsaberBundle\Repository\AlumnoexamenRepository")
 */

class AlumnoExamen {
     /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
     /**
     *
     * @ORM\Column(type="integer",nullable=false)
     */
    protected $referencia;
    /**
    * @ORM\ManyToOne(targetEntity="Netpublic\CoreBundle\Entity\Alumno",inversedBy="examen_alumnos")    
     *
     *     
     */   
    protected $alumno;
    /**
     * @ORM\ManyToOne(targetEntity="ExamenIcfes",inversedBy="alumno_examen")    
     *
     *     
     */   
    protected $examen;

    /**
     * @ORM\ManyToOne(targetEntity="Netpublic\CoreBundle\Entity\AlumnoDimension",inversedBy="examen_alumnos")    
     *
     *     
     */   
    protected $nota;
     /**
     *
     * @ORM\Column(type="float",nullable=false)
     */
    protected $promedio;
     /**
     *
     * @ORM\Column(type="integer",nullable=false)
     */
    protected $estado_lectura;
    
     /**
     *
     * @ORM\Column(type="integer",nullable=false)
     */
    protected $visible;
     /**
     *
     * @ORM\Column(type="integer",nullable=false)
     */
    protected $intento;
        /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $fecha_final;     
     /**
     *
     * @ORM\Column(type="string",nullable=false)
     */
    protected $url;




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
     * Set referencia
     *
     * @param integer $referencia
     * @return AlumnoExamen
     */
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;

        return $this;
    }

    /**
     * Get referencia
     *
     * @return integer 
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * Set promedio
     *
     * @param float $promedio
     * @return AlumnoExamen
     */
    public function setPromedio($promedio)
    {
        $this->promedio = $promedio;

        return $this;
    }

    /**
     * Get promedio
     *
     * @return float 
     */
    public function getPromedio()
    {
        return $this->promedio;
    }

    /**
     * Set estado_lectura
     *
     * @param integer $estadoLectura
     * @return AlumnoExamen
     */
    public function setEstadoLectura($estadoLectura)
    {
        $this->estado_lectura = $estadoLectura;

        return $this;
    }

    /**
     * Get estado_lectura
     *
     * @return integer 
     */
    public function getEstadoLectura()
    {
        return $this->estado_lectura;
    }

    /**
     * Set alumno
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $alumno
     * @return AlumnoExamen
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
     * Set nota
     *
     * @param \Netpublic\CoreBundle\Entity\AlumnoDimension $nota
     * @return AlumnoExamen
     */
    public function setNota(\Netpublic\CoreBundle\Entity\AlumnoDimension $nota = null)
    {
        $this->nota = $nota;

        return $this;
    }

    /**
     * Get nota
     *
     * @return \Netpublic\CoreBundle\Entity\AlumnoDimension 
     */
    public function getNota()
    {
        return $this->nota;
    }

    /**
     * Set examen
     *
     * @param \Netpublic\RedsaberBundle\Entity\ExamenIcfes $examen
     * @return AlumnoExamen
     */
    public function setExamen(\Netpublic\RedsaberBundle\Entity\ExamenIcfes $examen = null)
    {
        $this->examen = $examen;

        return $this;
    }

    /**
     * Get examen
     *
     * @return \Netpublic\RedsaberBundle\Entity\ExamenIcfes 
     */
    public function getExamen()
    {
        return $this->examen;
    }

    /**
     * Set visible
     *
     * @param integer $visible
     * @return AlumnoExamen
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return integer 
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set intento
     *
     * @param integer $intento
     * @return AlumnoExamen
     */
    public function setIntento($intento)
    {
        $this->intento = $intento;

        return $this;
    }

    /**
     * Get intento
     *
     * @return integer 
     */
    public function getIntento()
    {
        return $this->intento;
    }

    /**
     * Set fecha_final
     *
     * @param \DateTime $fechaFinal
     * @return AlumnoExamen
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fecha_final = $fechaFinal;

        return $this;
    }

    /**
     * Get fecha_final
     *
     * @return \DateTime 
     */
    public function getFechaFinal()
    {
        return $this->fecha_final;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return AlumnoExamen
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }
}
