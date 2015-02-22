<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Asignatura
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="asignatura")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\AsignaturaRepository")
 */
class Asignatura {
    /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     *
     * @ORM\Column(type="string")
     */
    protected $nombre;
    

    /**
     * @ORM\OneToMany(targetEntity="CargaAcademica",mappedBy="asignatura")
     */
    protected $carga_academica;
    /**
    * @ORM\OneToMany(targetEntity="Dimension",mappedBy="asignatura")    
    */
    //Actividades que el profesor crea para evaluar estudiantes
    protected $dimension;
    /**
    * @ORM\ManyToOne(targetEntity="Grado",inversedBy="asignatura")   
    * 
    */    
    protected $grado;
     
    /**
     *
     * @ORM\OneToMany(targetEntity="AlumnoDimension",mappedBy="asignatura")
     */
    protected $nota;
    /**
     *
     * @ORM\OneToMany(targetEntity="AlumnoDesempeno",mappedBy="asignatura")
     */
    protected $nota_desempeno;
 
    /**
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $duracion_minutos;
    
     
   
   /**
    *
    * @ORM\Column(type="integer",nullable=true)
    */
   protected $frucuencia_semana;
   /**
    * @ORM\ManyToOne(targetEntity="Asignatura",inversedBy="asgs")
    * 
    * 
    */
   protected $area;
   /**
    * @ORM\OneToMany(targetEntity="Asignatura",mappedBy="area")
    * 
    * 
    */
   protected $asgs;
   
   /**
    *
    * @ORM\Column(type="boolean",nullable=true)
    */
   protected $es_area;
    /**
    * @ORM\OneToMany(targetEntity="TemaAsignatura",mappedBy="asignatura")   
    * 
    */    
    protected $tema_asignatura;
    /**
    * @ORM\OneToMany(targetEntity="CriterioPromocion",mappedBy="area_asignatura")   
    * 
    */    
    protected $criterio_promocion;
   /**
    *
    * @ORM\Column(type="string",nullable=true)
    */
   protected $color;
    /**
    * @ORM\OneToMany(targetEntity="CondicionAsignatura",mappedBy="asignatura")   
    * 
    */    
    protected $condicion_asignatura;
    /**
     * @ORM\OneToMany(targetEntity="Netpublic\RedsaberBundle\Entity\PlanArea",mappedBy="alumno")  
     * 
    */    
    protected $plan_area;
    
    
    public function __toString() {
        return $this->nombre;
    }

  
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->carga_academica = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dimension = new \Doctrine\Common\Collections\ArrayCollection();
        $this->nota = new \Doctrine\Common\Collections\ArrayCollection();
        $this->nota_desempeno = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tema_asignatura = new \Doctrine\Common\Collections\ArrayCollection();
        $this->criterio_promocion = new \Doctrine\Common\Collections\ArrayCollection();
        $this->condicion_asignatura = new \Doctrine\Common\Collections\ArrayCollection();
        $this->plan_area = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     * @return Asignatura
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set duracion_minutos
     *
     * @param integer $duracionMinutos
     * @return Asignatura
     */
    public function setDuracionMinutos($duracionMinutos)
    {
        $this->duracion_minutos = $duracionMinutos;

        return $this;
    }

    /**
     * Get duracion_minutos
     *
     * @return integer 
     */
    public function getDuracionMinutos()
    {
        return $this->duracion_minutos;
    }

    /**
     * Set frucuencia_semana
     *
     * @param integer $frucuenciaSemana
     * @return Asignatura
     */
    public function setFrucuenciaSemana($frucuenciaSemana)
    {
        $this->frucuencia_semana = $frucuenciaSemana;

        return $this;
    }

    /**
     * Get frucuencia_semana
     *
     * @return integer 
     */
    public function getFrucuenciaSemana()
    {
        return $this->frucuencia_semana;
    }

    /**
     * Set es_area
     *
     * @param boolean $esArea
     * @return Asignatura
     */
    public function setEsArea($esArea)
    {
        $this->es_area = $esArea;

        return $this;
    }

    /**
     * Get es_area
     *
     * @return boolean 
     */
    public function getEsArea()
    {
        return $this->es_area;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return Asignatura
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Add carga_academica
     *
     * @param \Netpublic\CoreBundle\Entity\CargaAcademica $cargaAcademica
     * @return Asignatura
     */
    public function addCargaAcademica(\Netpublic\CoreBundle\Entity\CargaAcademica $cargaAcademica)
    {
        $this->carga_academica[] = $cargaAcademica;

        return $this;
    }

    /**
     * Remove carga_academica
     *
     * @param \Netpublic\CoreBundle\Entity\CargaAcademica $cargaAcademica
     */
    public function removeCargaAcademica(\Netpublic\CoreBundle\Entity\CargaAcademica $cargaAcademica)
    {
        $this->carga_academica->removeElement($cargaAcademica);
    }

    /**
     * Get carga_academica
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCargaAcademica()
    {
        return $this->carga_academica;
    }

    /**
     * Add dimension
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $dimension
     * @return Asignatura
     */
    public function addDimension(\Netpublic\CoreBundle\Entity\Dimension $dimension)
    {
        $this->dimension[] = $dimension;

        return $this;
    }

    /**
     * Remove dimension
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $dimension
     */
    public function removeDimension(\Netpublic\CoreBundle\Entity\Dimension $dimension)
    {
        $this->dimension->removeElement($dimension);
    }

    /**
     * Get dimension
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * Set grado
     *
     * @param \Netpublic\CoreBundle\Entity\Grado $grado
     * @return Asignatura
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

    /**
     * Add nota
     *
     * @param \Netpublic\CoreBundle\Entity\AlumnoDimension $nota
     * @return Asignatura
     */
    public function addNotum(\Netpublic\CoreBundle\Entity\AlumnoDimension $nota)
    {
        $this->nota[] = $nota;

        return $this;
    }

    /**
     * Remove nota
     *
     * @param \Netpublic\CoreBundle\Entity\AlumnoDimension $nota
     */
    public function removeNotum(\Netpublic\CoreBundle\Entity\AlumnoDimension $nota)
    {
        $this->nota->removeElement($nota);
    }

    /**
     * Get nota
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNota()
    {
        return $this->nota;
    }

    /**
     * Add nota_desempeno
     *
     * @param \Netpublic\CoreBundle\Entity\AlumnoDesempeno $notaDesempeno
     * @return Asignatura
     */
    public function addNotaDesempeno(\Netpublic\CoreBundle\Entity\AlumnoDesempeno $notaDesempeno)
    {
        $this->nota_desempeno[] = $notaDesempeno;

        return $this;
    }

    /**
     * Remove nota_desempeno
     *
     * @param \Netpublic\CoreBundle\Entity\AlumnoDesempeno $notaDesempeno
     */
    public function removeNotaDesempeno(\Netpublic\CoreBundle\Entity\AlumnoDesempeno $notaDesempeno)
    {
        $this->nota_desempeno->removeElement($notaDesempeno);
    }

    /**
     * Get nota_desempeno
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNotaDesempeno()
    {
        return $this->nota_desempeno;
    }

    /**
     * Set area
     *
     * @param \Netpublic\CoreBundle\Entity\Asignatura $area
     * @return Asignatura
     */
    public function setArea(\Netpublic\CoreBundle\Entity\Asignatura $area = null)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return \Netpublic\CoreBundle\Entity\Asignatura 
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Add tema_asignatura
     *
     * @param \Netpublic\CoreBundle\Entity\TemaAsignatura $temaAsignatura
     * @return Asignatura
     */
    public function addTemaAsignatura(\Netpublic\CoreBundle\Entity\TemaAsignatura $temaAsignatura)
    {
        $this->tema_asignatura[] = $temaAsignatura;

        return $this;
    }

    /**
     * Remove tema_asignatura
     *
     * @param \Netpublic\CoreBundle\Entity\TemaAsignatura $temaAsignatura
     */
    public function removeTemaAsignatura(\Netpublic\CoreBundle\Entity\TemaAsignatura $temaAsignatura)
    {
        $this->tema_asignatura->removeElement($temaAsignatura);
    }

    /**
     * Get tema_asignatura
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTemaAsignatura()
    {
        return $this->tema_asignatura;
    }

    /**
     * Add criterio_promocion
     *
     * @param \Netpublic\CoreBundle\Entity\CriterioPromocion $criterioPromocion
     * @return Asignatura
     */
    public function addCriterioPromocion(\Netpublic\CoreBundle\Entity\CriterioPromocion $criterioPromocion)
    {
        $this->criterio_promocion[] = $criterioPromocion;

        return $this;
    }

    /**
     * Remove criterio_promocion
     *
     * @param \Netpublic\CoreBundle\Entity\CriterioPromocion $criterioPromocion
     */
    public function removeCriterioPromocion(\Netpublic\CoreBundle\Entity\CriterioPromocion $criterioPromocion)
    {
        $this->criterio_promocion->removeElement($criterioPromocion);
    }

    /**
     * Get criterio_promocion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCriterioPromocion()
    {
        return $this->criterio_promocion;
    }

    /**
     * Add condicion_asignatura
     *
     * @param \Netpublic\CoreBundle\Entity\CondicionAsignatura $condicionAsignatura
     * @return Asignatura
     */
    public function addCondicionAsignatura(\Netpublic\CoreBundle\Entity\CondicionAsignatura $condicionAsignatura)
    {
        $this->condicion_asignatura[] = $condicionAsignatura;

        return $this;
    }

    /**
     * Remove condicion_asignatura
     *
     * @param \Netpublic\CoreBundle\Entity\CondicionAsignatura $condicionAsignatura
     */
    public function removeCondicionAsignatura(\Netpublic\CoreBundle\Entity\CondicionAsignatura $condicionAsignatura)
    {
        $this->condicion_asignatura->removeElement($condicionAsignatura);
    }

    /**
     * Get condicion_asignatura
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCondicionAsignatura()
    {
        return $this->condicion_asignatura;
    }

    /**
     * Add plan_area
     *
     * @param \Netpublic\RedsaberBundle\Entity\PlanArea $planArea
     * @return Asignatura
     */
    public function addPlanArea(\Netpublic\RedsaberBundle\Entity\PlanArea $planArea)
    {
        $this->plan_area[] = $planArea;

        return $this;
    }

    /**
     * Remove plan_area
     *
     * @param \Netpublic\RedsaberBundle\Entity\PlanArea $planArea
     */
    public function removePlanArea(\Netpublic\RedsaberBundle\Entity\PlanArea $planArea)
    {
        $this->plan_area->removeElement($planArea);
    }

    /**
     * Get plan_area
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlanArea()
    {
        return $this->plan_area;
    }

    /**
     * Add asgs
     *
     * @param \Netpublic\CoreBundle\Entity\Asignatura $asgs
     * @return Asignatura
     */
    public function addAsg(\Netpublic\CoreBundle\Entity\Asignatura $asgs)
    {
        $this->asgs[] = $asgs;

        return $this;
    }

    /**
     * Remove asgs
     *
     * @param \Netpublic\CoreBundle\Entity\Asignatura $asgs
     */
    public function removeAsg(\Netpublic\CoreBundle\Entity\Asignatura $asgs)
    {
        $this->asgs->removeElement($asgs);
    }

    /**
     * Get asgs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAsgs()
    {
        return $this->asgs;
    }
}
