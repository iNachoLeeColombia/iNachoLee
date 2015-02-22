<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Grupo
 *
 * @author yuri
 * 
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections;
use Doctrine\Common\Collections\ArrayCollection;
use Netpublic\CoreBundle\Util\Util;

/**
 * @ORM\Entity
 * @ORM\Table(name="grupo")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\GrupoRepository")
 */

class Grupo {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column=(type="string")     
     */
    protected $nombre;
    /**
     * @ORM\Column=(type="string",nullable=true)      
     */
    protected $slug;
    
    /**
     * @ORM\OneToMany(targetEntity="Alumno",mappedBy="grupo")
     */
    protected $alumnos;   
    /**
     * @ORM\OneToMany(targetEntity="Alumno",mappedBy="grupo_promovido")
     */
    protected $alumnos_promovido;   
    
    /**
     * @ORM\ManyToOne(targetEntity="Grado",inversedBy="grupo")
     * 
     *      */
    protected $grado;   

    /**
     *
     * @ORM\OneToMany(targetEntity="Dimension",mappedBy="grupo")
     */
    protected $dimensiones; 
    /**
    * @ORM\OneToMany(targetEntity="CargaAcademica",mappedBy="grupo")
    */
    
    protected $carga_academica;
    /**
     *
     * @ORM\ManyToMany(targetEntity="Desempeno",mappedBy="grupo")
     */
    protected $desempeno;     
    /**
     * @ORM\ManyToOne(targetEntity="Profesor",inversedBy="grupo_dir")
     * 
     */
    
    protected $director_grupo;  
    /**Dimension
    * @ORM\OneToMany(targetEntity="Grupopromovido",mappedBy="grupo_actual")
    */
    
    protected $grupo_promovido;
    /**
    * @ORM\OneToMany(targetEntity="CargaAcademica",mappedBy="grupo_siguiente")
    */
    
    protected $grupo_promovido_siguiente;
    /**
    * @ORM\OneToMany(targetEntity="CondicionGrupo",mappedBy="grupo")
    */
    
    protected $condicion_grupo;
    /**
    * @ORM\OneToMany(targetEntity="HorarioGrupo",mappedBy="grupo")
    */
    
    protected $horario_grupo;
    /**
    * @ORM\OneToMany(targetEntity="ProfesorSolicitud",mappedBy="grupo")      
    */    
   protected $solicitud;
    /**
    * @ORM\OneToMany(targetEntity="Netpublic\RedsaberBundle\Entity\ExamenIcfes",mappedBy="grupo")  
    *     
    */    
    protected $examen_grupo;
    /**
    * @ORM\OneToMany(targetEntity="MatriculaAlumno",mappedBy="grupo")  
    *     
    */    
    protected $matricula_alumno;
 

    public function __toString() {
        return $this->nombre;
    }
        /**
     * Set nombre
     *
     * @param string $nombre
     * @return Grupo
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        $this->slug=  Util::getSlug($nombre,'_');
        return $this;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->alumnos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->alumnos_promovido = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dimensiones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->carga_academica = new \Doctrine\Common\Collections\ArrayCollection();
        $this->desempeno = new \Doctrine\Common\Collections\ArrayCollection();
        $this->grupo_promovido_siguiente = new \Doctrine\Common\Collections\ArrayCollection();
        $this->condicion_grupo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->horario_grupo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->solicitud = new \Doctrine\Common\Collections\ArrayCollection();
        $this->examen_grupo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->matricula_alumno = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Grupo
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add alumnos
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $alumnos
     * @return Grupo
     */
    public function addAlumno(\Netpublic\CoreBundle\Entity\Alumno $alumnos)
    {
        $this->alumnos[] = $alumnos;

        return $this;
    }

    /**
     * Remove alumnos
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $alumnos
     */
    public function removeAlumno(\Netpublic\CoreBundle\Entity\Alumno $alumnos)
    {
        $this->alumnos->removeElement($alumnos);
    }

    /**
     * Get alumnos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAlumnos()
    {
        return $this->alumnos;
    }

    /**
     * Add alumnos_promovido
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $alumnosPromovido
     * @return Grupo
     */
    public function addAlumnosPromovido(\Netpublic\CoreBundle\Entity\Alumno $alumnosPromovido)
    {
        $this->alumnos_promovido[] = $alumnosPromovido;

        return $this;
    }

    /**
     * Remove alumnos_promovido
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $alumnosPromovido
     */
    public function removeAlumnosPromovido(\Netpublic\CoreBundle\Entity\Alumno $alumnosPromovido)
    {
        $this->alumnos_promovido->removeElement($alumnosPromovido);
    }

    /**
     * Get alumnos_promovido
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAlumnosPromovido()
    {
        return $this->alumnos_promovido;
    }

    /**
     * Set grado
     *
     * @param \Netpublic\CoreBundle\Entity\Grado $grado
     * @return Grupo
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
     * Add dimensiones
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $dimensiones
     * @return Grupo
     */
    public function addDimensione(\Netpublic\CoreBundle\Entity\Dimension $dimensiones)
    {
        $this->dimensiones[] = $dimensiones;

        return $this;
    }

    /**
     * Remove dimensiones
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $dimensiones
     */
    public function removeDimensione(\Netpublic\CoreBundle\Entity\Dimension $dimensiones)
    {
        $this->dimensiones->removeElement($dimensiones);
    }

    /**
     * Get dimensiones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDimensiones()
    {
        return $this->dimensiones;
    }

    /**
     * Add carga_academica
     *
     * @param \Netpublic\CoreBundle\Entity\CargaAcademica $cargaAcademica
     * @return Grupo
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
     * Add desempeno
     *
     * @param \Netpublic\CoreBundle\Entity\Desempeno $desempeno
     * @return Grupo
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
     * Set director_grupo
     *
     * @param \Netpublic\CoreBundle\Entity\Profesor $directorGrupo
     * @return Grupo
     */
    public function setDirectorGrupo(\Netpublic\CoreBundle\Entity\Profesor $directorGrupo = null)
    {
        $this->director_grupo = $directorGrupo;

        return $this;
    }

    /**
     * Get director_grupo
     *
     * @return \Netpublic\CoreBundle\Entity\Profesor 
     */
    public function getDirectorGrupo()
    {
        return $this->director_grupo;
    }

    /**
     * Add grupo_promovido_siguiente
     *
     * @param \Netpublic\CoreBundle\Entity\CargaAcademica $grupoPromovidoSiguiente
     * @return Grupo
     */
    public function addGrupoPromovidoSiguiente(\Netpublic\CoreBundle\Entity\CargaAcademica $grupoPromovidoSiguiente)
    {
        $this->grupo_promovido_siguiente[] = $grupoPromovidoSiguiente;

        return $this;
    }

    /**
     * Remove grupo_promovido_siguiente
     *
     * @param \Netpublic\CoreBundle\Entity\CargaAcademica $grupoPromovidoSiguiente
     */
    public function removeGrupoPromovidoSiguiente(\Netpublic\CoreBundle\Entity\CargaAcademica $grupoPromovidoSiguiente)
    {
        $this->grupo_promovido_siguiente->removeElement($grupoPromovidoSiguiente);
    }

    /**
     * Get grupo_promovido_siguiente
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGrupoPromovidoSiguiente()
    {
        return $this->grupo_promovido_siguiente;
    }

    /**
     * Add condicion_grupo
     *
     * @param \Netpublic\CoreBundle\Entity\CondicionGrupo $condicionGrupo
     * @return Grupo
     */
    public function addCondicionGrupo(\Netpublic\CoreBundle\Entity\CondicionGrupo $condicionGrupo)
    {
        $this->condicion_grupo[] = $condicionGrupo;

        return $this;
    }

    /**
     * Remove condicion_grupo
     *
     * @param \Netpublic\CoreBundle\Entity\CondicionGrupo $condicionGrupo
     */
    public function removeCondicionGrupo(\Netpublic\CoreBundle\Entity\CondicionGrupo $condicionGrupo)
    {
        $this->condicion_grupo->removeElement($condicionGrupo);
    }

    /**
     * Get condicion_grupo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCondicionGrupo()
    {
        return $this->condicion_grupo;
    }

    /**
     * Add horario_grupo
     *
     * @param \Netpublic\CoreBundle\Entity\HorarioGrupo $horarioGrupo
     * @return Grupo
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
     * Add solicitud
     *
     * @param \Netpublic\CoreBundle\Entity\ProfesorSolicitud $solicitud
     * @return Grupo
     */
    public function addSolicitud(\Netpublic\CoreBundle\Entity\ProfesorSolicitud $solicitud)
    {
        $this->solicitud[] = $solicitud;

        return $this;
    }

    /**
     * Remove solicitud
     *
     * @param \Netpublic\CoreBundle\Entity\ProfesorSolicitud $solicitud
     */
    public function removeSolicitud(\Netpublic\CoreBundle\Entity\ProfesorSolicitud $solicitud)
    {
        $this->solicitud->removeElement($solicitud);
    }

    /**
     * Get solicitud
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSolicitud()
    {
        return $this->solicitud;
    }

    /**
     * Add examen_grupo
     *
     * @param \Netpublic\RedsaberBundle\Entity\ExamenIcfes $examenGrupo
     * @return Grupo
     */
    public function addExamenGrupo(\Netpublic\RedsaberBundle\Entity\ExamenIcfes $examenGrupo)
    {
        $this->examen_grupo[] = $examenGrupo;

        return $this;
    }

    /**
     * Remove examen_grupo
     *
     * @param \Netpublic\RedsaberBundle\Entity\ExamenIcfes $examenGrupo
     */
    public function removeExamenGrupo(\Netpublic\RedsaberBundle\Entity\ExamenIcfes $examenGrupo)
    {
        $this->examen_grupo->removeElement($examenGrupo);
    }

    /**
     * Get examen_grupo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExamenGrupo()
    {
        return $this->examen_grupo;
    }

    /**
     * Add matricula_alumno
     *
     * @param \Netpublic\CoreBundle\Entity\MatriculaAlumno $matriculaAlumno
     * @return Grupo
     */
    public function addMatriculaAlumno(\Netpublic\CoreBundle\Entity\MatriculaAlumno $matriculaAlumno)
    {
        $this->matricula_alumno[] = $matriculaAlumno;

        return $this;
    }

    /**
     * Remove matricula_alumno
     *
     * @param \Netpublic\CoreBundle\Entity\MatriculaAlumno $matriculaAlumno
     */
    public function removeMatriculaAlumno(\Netpublic\CoreBundle\Entity\MatriculaAlumno $matriculaAlumno)
    {
        $this->matricula_alumno->removeElement($matriculaAlumno);
    }

    /**
     * Get matricula_alumno
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMatriculaAlumno()
    {
        return $this->matricula_alumno;
    }
}
