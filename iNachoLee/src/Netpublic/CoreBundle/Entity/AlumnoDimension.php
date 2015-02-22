<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AlumnoDimension
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Netpublic\CoreBundle\Entity\Rest;
/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks() 
 * @ORM\Table(name="alumno_dimension")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\NotaRepository")
 */

class AlumnoDimension {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Alumno",inversedBy="nota")     
     *
     */
    protected $alumno;
    /**
     * @ORM\ManyToOne(targetEntity="Dimension",inversedBy="nota")
     *
     */
    protected $dimension;    
    /**
     * @ORM\ManyToOne(targetEntity="Asignatura",inversedBy="nota")
     *
     */
    protected $asignatura;               
    /**
     * @ORM\Column(type="float")
     */
    protected $nota;        
    /**
     * @ORM\Column(type="float",nullable=true)
     */
    protected $nota_buffered;        

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $numero_cambios;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $fecha_ultimo_cambio;     
   /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $fecha_ultimo_ingreso;     

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $es_modificada;
    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $es_ingresadad;
       /**
     *
     * @ORM\OneToMany(targetEntity="NotaRecuperacion",mappedBy="nota")
     */
    protected $nota_recuperacion;
 
   
    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $es_error;
    /**
    * @ORM\OneToMany(targetEntity="Netpublic\RedsaberBundle\Entity\AlumnoExamen",mappedBy="nota")  
    *    
    * 
    */    
    protected $examen_alumnos;

    /*
    **
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $rest=new Rest();
        $rest->setUdate($this->nota);
    }
    public function __toString(){
        return "$this->nota";
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
     * Set nota
     *
     * @param float $nota
     * @return AlumnoDimension
     */
    public function setNota($nota=0)
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
     * Set numero_cambios
     *
     * @param integer $numeroCambios
     * @return AlumnoDimension
     */
    public function setNumeroCambios($numeroCambios)
    {
        $this->numero_cambios = $numeroCambios;
    
        return $this;
    }

    /**
     * Get numero_cambios
     *
     * @return integer 
     */
    public function getNumeroCambios()
    {
        return $this->numero_cambios;
    }

    /**
     * Set fecha_ultimo_cambio
     *
     * @param \DateTime $fechaUltimoCambio
     * @return AlumnoDimension
     */
    public function setFechaUltimoCambio($fechaUltimoCambio)
    {
        $this->fecha_ultimo_cambio = $fechaUltimoCambio;
    
        return $this;
    }

    /**
     * Get fecha_ultimo_cambio
     *
     * @return \DateTime 
     */
    public function getFechaUltimoCambio()
    {
        return $this->fecha_ultimo_cambio;
    }

    /**
     * Set es_modificada
     *
     * @param boolean $esModificada
     * @return AlumnoDimension
     */
    public function setEsModificada($esModificada)
    {
        $this->es_modificada = $esModificada;
    
        return $this;
    }

    /**
     * Get es_modificada
     *
     * @return boolean 
     */
    public function getEsModificada()
    {
        return $this->es_modificada;
    }

    /**
     * Set alumno
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $alumno
     * @return AlumnoDimension
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
     * Set dimension
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $dimension
     * @return AlumnoDimension
     */
    public function setDimension(\Netpublic\CoreBundle\Entity\Dimension $dimension = null)
    {
        $this->dimension = $dimension;
    
        return $this;
    }

    /**
     * Get dimension
     *
     * @return \Netpublic\CoreBundle\Entity\Dimension 
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * Set asignatura
     *
     * @param \Netpublic\CoreBundle\Entity\Asignatura $asignatura
     * @return AlumnoDimension
     */
    public function setAsignatura(\Netpublic\CoreBundle\Entity\Asignatura $asignatura = null)
    {
        $this->asignatura = $asignatura;
    
        return $this;
    }

    /**
     * Get asignatura
     *
     * @return \Netpublic\CoreBundle\Entity\Asignatura 
     */
    public function getAsignatura()
    {
        return $this->asignatura;
    }

    /**
     * Set es_error
     *
     * @param boolean $esError
     * @return AlumnoDimension
     */
    public function setEsError($esError)
    {
        $this->es_error = $esError;
    
        return $this;
    }

    /**
     * Get es_error
     *
     * @return boolean 
     */
    public function getEsError()
    {
        return $this->es_error;
    }

    /**
     * Set nota_buffered
     *
     * @param float $notaBuffered
     * @return AlumnoDimension
     */
    public function setNotaBuffered($notaBuffered)
    {
        $this->nota_buffered = $notaBuffered;
    
        return $this;
    }

    /**
     * Get nota_buffered
     *
     * @return float 
     */
    public function getNotaBuffered()
    {
        return $this->nota_buffered;
    }

    /**
     * Set es_ingresadad
     *
     * @param boolean $esIngresadad
     * @return AlumnoDimension
     */
    public function setEsIngresadad($esIngresadad)
    {
        $this->es_ingresadad = $esIngresadad;
    
        return $this;
    }

    /**
     * Get es_ingresadad
     *
     * @return boolean 
     */
    public function getEsIngresadad()
    {
        return $this->es_ingresadad;
    }

    /**
     * Set fecha_ultimo_ingreso
     *
     * @param \DateTime $fechaUltimoIngreso
     * @return AlumnoDimension
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
     * Constructor
     */
    public function __construct()
    {
        $this->nota_recuperacion = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add nota_recuperacion
     *
     * @param \Netpublic\CoreBundle\Entity\NotaRecuperacion $notaRecuperacion
     * @return AlumnoDimension
     */
    public function addNotaRecuperacion(\Netpublic\CoreBundle\Entity\NotaRecuperacion $notaRecuperacion)
    {
        $this->nota_recuperacion[] = $notaRecuperacion;

        return $this;
    }

    /**
     * Remove nota_recuperacion
     *
     * @param \Netpublic\CoreBundle\Entity\NotaRecuperacion $notaRecuperacion
     */
    public function removeNotaRecuperacion(\Netpublic\CoreBundle\Entity\NotaRecuperacion $notaRecuperacion)
    {
        $this->nota_recuperacion->removeElement($notaRecuperacion);
    }

    /**
     * Get nota_recuperacion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNotaRecuperacion()
    {
        return $this->nota_recuperacion;
    }

    /**
     * Add examen_alumnos
     *
     * @param \Netpublic\RedsaberBundle\Entity\AlumnoExamen $examenAlumnos
     * @return AlumnoDimension
     */
    public function addExamenAlumno(\Netpublic\RedsaberBundle\Entity\AlumnoExamen $examenAlumnos)
    {
        $this->examen_alumnos[] = $examenAlumnos;

        return $this;
    }

    /**
     * Remove examen_alumnos
     *
     * @param \Netpublic\RedsaberBundle\Entity\AlumnoExamen $examenAlumnos
     */
    public function removeExamenAlumno(\Netpublic\RedsaberBundle\Entity\AlumnoExamen $examenAlumnos)
    {
        $this->examen_alumnos->removeElement($examenAlumnos);
    }

    /**
     * Get examen_alumnos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExamenAlumnos()
    {
        return $this->examen_alumnos;
    }
}
