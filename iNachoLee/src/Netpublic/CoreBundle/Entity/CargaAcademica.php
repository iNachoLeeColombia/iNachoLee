<?php
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CargaAcademica
 *
 * @author yuri
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="carga_academica")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\CargaAcademicaRepository")
 */

class CargaAcademica {
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;
    /**
    * @ORM\ManyToOne(targetEntity="Profesor",inversedBy="carga_academica")
    * 
     */
   protected $profesor;
    /**
    * @ORM\ManyToOne(targetEntity="Profesor",inversedBy="carga_academicaprof")
    * 
     */
   protected $profesor_dueno;

   /**
    * @ORM\ManyToOne(targetEntity="Grupo",inversedBy="carga_academica")
    * 
    */
   protected $grupo;
   /**
    * @ORM\ManyToOne(targetEntity="Asignatura",inversedBy="carga_academica")
    * 
    */    
   protected $asignatura;
   /**
     * 
     * @ORM\Column(type="boolean",nullable=true)
     * 
     * 
     */
    protected $es_carga_academica;
     /**
     * 
     * @ORM\Column(type="integer",nullable=true)
     * 
     * 
     */
    protected $estado_asignacion;

   /**
     * 
     * @ORM\Column(type="boolean",nullable=true)
     * 
     * 
     */
    protected $tiene_profesor;
    /**
    * @ORM\OneToMany(targetEntity="HorarioClase",mappedBy="carga_academica")
    */
   protected $horario_clase;
   /**
    * @ORM\OneToMany(targetEntity="CondicionContrato",mappedBy="carga_academica")
    */
   protected $condicion_contrato;
   /**
    * @ORM\OneToMany(targetEntity="HorarioGrupo",mappedBy="carga_academica")
    */
   protected $horario_grupo;
   
    /**
     * @ORM\OneToMany(targetEntity="Desempeno",mappedBy="asignatura")
     */
    protected $desempeno;
    /**
    * @ORM\ManyToOne(targetEntity="Dimension",inversedBy="carga_academica")
    * 
    */    
   protected $ano_escolar;
    /**
    * @ORM\ManyToOne(targetEntity="Dimension",inversedBy="ca_evaluacion")
    * 
    */    
   protected $padre_evaluacion;

    public function __toString() {
        if($this->profesor!=null)
        return $this->asignatura."-".$this->profesor."(".$this->getAsignatura()->getGrado().")";
        if($this->profesor==null)
            return $this->asignatura."- Aun no tiene";
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->horario_clase = new \Doctrine\Common\Collections\ArrayCollection();
        $this->condicion_contrato = new \Doctrine\Common\Collections\ArrayCollection();
        $this->horario_grupo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->desempeno = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set es_carga_academica
     *
     * @param boolean $esCargaAcademica
     * @return CargaAcademica
     */
    public function setEsCargaAcademica($esCargaAcademica)
    {
        $this->es_carga_academica = $esCargaAcademica;

        return $this;
    }

    /**
     * Get es_carga_academica
     *
     * @return boolean 
     */
    public function getEsCargaAcademica()
    {
        return $this->es_carga_academica;
    }

    /**
     * Set estado_asignacion
     *
     * @param integer $estadoAsignacion
     * @return CargaAcademica
     */
    public function setEstadoAsignacion($estadoAsignacion)
    {
        $this->estado_asignacion = $estadoAsignacion;

        return $this;
    }

    /**
     * Get estado_asignacion
     *
     * @return integer 
     */
    public function getEstadoAsignacion()
    {
        return $this->estado_asignacion;
    }

    /**
     * Set tiene_profesor
     *
     * @param boolean $tieneProfesor
     * @return CargaAcademica
     */
    public function setTieneProfesor($tieneProfesor)
    {
        $this->tiene_profesor = $tieneProfesor;

        return $this;
    }

    /**
     * Get tiene_profesor
     *
     * @return boolean 
     */
    public function getTieneProfesor()
    {
        return $this->tiene_profesor;
    }

    /**
     * Set profesor
     *
     * @param \Netpublic\CoreBundle\Entity\Profesor $profesor
     * @return CargaAcademica
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
     * Set profesor_dueno
     *
     * @param \Netpublic\CoreBundle\Entity\Profesor $profesorDueno
     * @return CargaAcademica
     */
    public function setProfesorDueno(\Netpublic\CoreBundle\Entity\Profesor $profesorDueno = null)
    {
        $this->profesor_dueno = $profesorDueno;

        return $this;
    }

    /**
     * Get profesor_dueno
     *
     * @return \Netpublic\CoreBundle\Entity\Profesor 
     */
    public function getProfesorDueno()
    {
        return $this->profesor_dueno;
    }

    /**
     * Set grupo
     *
     * @param \Netpublic\CoreBundle\Entity\Grupo $grupo
     * @return CargaAcademica
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

    /**
     * Set asignatura
     *
     * @param \Netpublic\CoreBundle\Entity\Asignatura $asignatura
     * @return CargaAcademica
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
     * Add horario_clase
     *
     * @param \Netpublic\CoreBundle\Entity\HorarioClase $horarioClase
     * @return CargaAcademica
     */
    public function addHorarioClase(\Netpublic\CoreBundle\Entity\HorarioClase $horarioClase)
    {
        $this->horario_clase[] = $horarioClase;

        return $this;
    }

    /**
     * Remove horario_clase
     *
     * @param \Netpublic\CoreBundle\Entity\HorarioClase $horarioClase
     */
    public function removeHorarioClase(\Netpublic\CoreBundle\Entity\HorarioClase $horarioClase)
    {
        $this->horario_clase->removeElement($horarioClase);
    }

    /**
     * Get horario_clase
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHorarioClase()
    {
        return $this->horario_clase;
    }

    /**
     * Add condicion_contrato
     *
     * @param \Netpublic\CoreBundle\Entity\CondicionContrato $condicionContrato
     * @return CargaAcademica
     */
    public function addCondicionContrato(\Netpublic\CoreBundle\Entity\CondicionContrato $condicionContrato)
    {
        $this->condicion_contrato[] = $condicionContrato;

        return $this;
    }

    /**
     * Remove condicion_contrato
     *
     * @param \Netpublic\CoreBundle\Entity\CondicionContrato $condicionContrato
     */
    public function removeCondicionContrato(\Netpublic\CoreBundle\Entity\CondicionContrato $condicionContrato)
    {
        $this->condicion_contrato->removeElement($condicionContrato);
    }

    /**
     * Get condicion_contrato
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCondicionContrato()
    {
        return $this->condicion_contrato;
    }

    /**
     * Add horario_grupo
     *
     * @param \Netpublic\CoreBundle\Entity\HorarioGrupo $horarioGrupo
     * @return CargaAcademica
     */
    public function addHorarioGrupo(\Netpublic\CoreBundle\Entity\HorarioGrupo $horarioGrupo)
    {
        $this->horario_grupo[] = $horarioGrupo;

        return $this;
    }

    /**
     * Remove horario_grupo
     *
     * @param \Netpublic\CoreBundle\Entity\HorarioGrupo $horarioGrupo
     */
    public function removeHorarioGrupo(\Netpublic\CoreBundle\Entity\HorarioGrupo $horarioGrupo)
    {
        $this->horario_grupo->removeElement($horarioGrupo);
    }

    /**
     * Get horario_grupo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHorarioGrupo()
    {
        return $this->horario_grupo;
    }

    /**
     * Add desempeno
     *
     * @param \Netpublic\CoreBundle\Entity\Desempeno $desempeno
     * @return CargaAcademica
     */
    public function addDesempeno(\Netpublic\CoreBundle\Entity\Desempeno $desempeno)
    {
        $this->desempeno[] = $desempeno;

        return $this;
    }

    /**
     * Remove desempeno
     *
     * @param \Netpublic\CoreBundle\Entity\Desempeno $desempeno
     */
    public function removeDesempeno(\Netpublic\CoreBundle\Entity\Desempeno $desempeno)
    {
        $this->desempeno->removeElement($desempeno);
    }

    /**
     * Get desempeno
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDesempeno()
    {
        return $this->desempeno;
    }

    /**
     * Set ano_escolar
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $anoEscolar
     * @return CargaAcademica
     */
    public function setAnoEscolar(\Netpublic\CoreBundle\Entity\Dimension $anoEscolar = null)
    {
        $this->ano_escolar = $anoEscolar;

        return $this;
    }

    /**
     * Get ano_escolar
     *
     * @return \Netpublic\CoreBundle\Entity\Dimension 
     */
    public function getAnoEscolar()
    {
        return $this->ano_escolar;
    }

    /**
     * Set padre_evaluacion
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $padreEvaluacion
     * @return CargaAcademica
     */
    public function setPadreEvaluacion(\Netpublic\CoreBundle\Entity\Dimension $padreEvaluacion = null)
    {
        $this->padre_evaluacion = $padreEvaluacion;

        return $this;
    }

    /**
     * Get padre_evaluacion
     *
     * @return \Netpublic\CoreBundle\Entity\Dimension 
     */
    public function getPadreEvaluacion()
    {
        return $this->padre_evaluacion;
    }
}
