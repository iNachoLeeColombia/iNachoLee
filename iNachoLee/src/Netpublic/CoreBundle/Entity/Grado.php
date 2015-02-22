<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Grado
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Netpublic\CoreBundle\Util\Util;                                               
/**
 * @ORM\Entity
 * @ORM\Table(name="grado")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\GradoRepository")
 */
class Grado {
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
     * @ORM\Column=(type="string",nullable=true)      
     */
    protected $slug;
    
    /**
    * @ORM\OneToMany(targetEntity="Asignatura",mappedBy="grado")    
    */    
    protected $asignaturas;
    /**
    * @ORM\OneToMany(targetEntity="Grupo",mappedBy="grado")    
    */    
    protected $grupo;
    /**
    * @ORM\OneToMany(targetEntity="Alumno",mappedBy="grado")    
    */    
    protected $alumnos;
    
    /**
    * @ORM\ManyToOne(targetEntity="Grado",inversedBy="grado_siguiente")  
    *     */    
    protected $grado_siguiente;
    /**
     * 1 Preescolar
     * 2 Basica Primaria
     * 3 Basica Sewcuandaria
     * 4 Mdia
    * @ORM\Column=(type="integer",nullable=true)      
    */    

    protected $niveles_educativo;                 
    /**
    * @ORM\OneToMany(targetEntity="Gradopromovido",mappedBy="grado_actual")    
    */    
    protected $grado_promovido;
    /**
    * @ORM\OneToMany(targetEntity="Gradopromovido",mappedBy="grado_siguiente")    
    */    
    protected $grado_promovido_siguiente;
    /**
    * @ORM\OneToMany(targetEntity="Grupopromovido",mappedBy="grado")    
    */    
    protected $grupo_promovido;
    /**
    * @ORM\OneToMany(targetEntity="CondicionGrado",mappedBy="grado")    
    */    
    protected $condicion_grado;
     /**
    * @ORM\OneToMany(targetEntity="Anoescolargrado",mappedBy="grado")  
    *     */    
    protected $grado_cursado;
    /**
    * @ORM\OneToMany(targetEntity="Netpublic\RedsaberBundle\Entity\ExamenIcfes",mappedBy="grados")  
    *     
    */    
    protected $examen_grado;
    /**
    * @ORM\OneToMany(targetEntity="Netpublic\RedsaberBundle\Entity\Pregunta",mappedBy="grado")  
    *     
    */    
    protected $pregunta;
     /**
     * @ORM\OneToMany(targetEntity="Netpublic\RedsaberBundle\Entity\Componente",mappedBy="grado")  
     * 
    */    
    protected $componente;
     /**
     *    
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $nombre_grupo; 
    
    public function __toString() {
        return $this->nombre;
    }
        /**
     * Set nombre
     *
     * @param string $nombre
     * @return Grado
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        $this->slug= Util::getSlug($nombre,'_');    
        return $this;
    }
 
  
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->asignaturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->grupo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->alumnos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->grado_promovido = new \Doctrine\Common\Collections\ArrayCollection();
        $this->grado_promovido_siguiente = new \Doctrine\Common\Collections\ArrayCollection();
        $this->grupo_promovido = new \Doctrine\Common\Collections\ArrayCollection();
        $this->condicion_grado = new \Doctrine\Common\Collections\ArrayCollection();
        $this->grado_cursado = new \Doctrine\Common\Collections\ArrayCollection();
        $this->examen_grado = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pregunta = new \Doctrine\Common\Collections\ArrayCollection();
        $this->componente = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Grado
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
     * Set niveles_educativo
     *
     * @param string $nivelesEducativo
     * @return Grado
     */
    public function setNivelesEducativo($nivelesEducativo)
    {
        $this->niveles_educativo = $nivelesEducativo;

        return $this;
    }

    /**
     * Get niveles_educativo
     *
     * @return string 
     */
    public function getNivelesEducativo()
    {
        return $this->niveles_educativo;
    }

    /**
     * Add asignaturas
     *
     * @param \Netpublic\CoreBundle\Entity\Asignatura $asignaturas
     * @return Grado
     */
    public function addAsignatura(\Netpublic\CoreBundle\Entity\Asignatura $asignaturas)
    {
        $this->asignaturas[] = $asignaturas;

        return $this;
    }

    /**
     * Remove asignaturas
     *
     * @param \Netpublic\CoreBundle\Entity\Asignatura $asignaturas
     */
    public function removeAsignatura(\Netpublic\CoreBundle\Entity\Asignatura $asignaturas)
    {
        $this->asignaturas->removeElement($asignaturas);
    }

    /**
     * Get asignaturas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAsignaturas()
    {
        return $this->asignaturas;
    }

    /**
     * Add grupo
     *
     * @param \Netpublic\CoreBundle\Entity\Grupo $grupo
     * @return Grado
     */
    public function addGrupo(\Netpublic\CoreBundle\Entity\Grupo $grupo)
    {
        $this->grupo[] = $grupo;

        return $this;
    }

    /**
     * Remove grupo
     *
     * @param \Netpublic\CoreBundle\Entity\Grupo $grupo
     */
    public function removeGrupo(\Netpublic\CoreBundle\Entity\Grupo $grupo)
    {
        $this->grupo->removeElement($grupo);
    }

    /**
     * Get grupo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Add alumnos
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $alumnos
     * @return Grado
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
     * Set grado_siguiente
     *
     * @param \Netpublic\CoreBundle\Entity\Grado $gradoSiguiente
     * @return Grado
     */
    public function setGradoSiguiente(\Netpublic\CoreBundle\Entity\Grado $gradoSiguiente = null)
    {
        $this->grado_siguiente = $gradoSiguiente;

        return $this;
    }

    /**
     * Get grado_siguiente
     *
     * @return \Netpublic\CoreBundle\Entity\Grado 
     */
    public function getGradoSiguiente()
    {
        return $this->grado_siguiente;
    }

    /**
     * Add grado_promovido
     *
     * @param \Netpublic\CoreBundle\Entity\Gradopromovido $gradoPromovido
     * @return Grado
     */
    public function addGradoPromovido(\Netpublic\CoreBundle\Entity\Gradopromovido $gradoPromovido)
    {
        $this->grado_promovido[] = $gradoPromovido;

        return $this;
    }

    /**
     * Remove grado_promovido
     *
     * @param \Netpublic\CoreBundle\Entity\Gradopromovido $gradoPromovido
     */
    public function removeGradoPromovido(\Netpublic\CoreBundle\Entity\Gradopromovido $gradoPromovido)
    {
        $this->grado_promovido->removeElement($gradoPromovido);
    }

    /**
     * Get grado_promovido
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGradoPromovido()
    {
        return $this->grado_promovido;
    }

    /**
     * Add grado_promovido_siguiente
     *
     * @param \Netpublic\CoreBundle\Entity\Gradopromovido $gradoPromovidoSiguiente
     * @return Grado
     */
    public function addGradoPromovidoSiguiente(\Netpublic\CoreBundle\Entity\Gradopromovido $gradoPromovidoSiguiente)
    {
        $this->grado_promovido_siguiente[] = $gradoPromovidoSiguiente;

        return $this;
    }

    /**
     * Remove grado_promovido_siguiente
     *
     * @param \Netpublic\CoreBundle\Entity\Gradopromovido $gradoPromovidoSiguiente
     */
    public function removeGradoPromovidoSiguiente(\Netpublic\CoreBundle\Entity\Gradopromovido $gradoPromovidoSiguiente)
    {
        $this->grado_promovido_siguiente->removeElement($gradoPromovidoSiguiente);
    }

    /**
     * Get grado_promovido_siguiente
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGradoPromovidoSiguiente()
    {
        return $this->grado_promovido_siguiente;
    }

    /**
     * Add grupo_promovido
     *
     * @param \Netpublic\CoreBundle\Entity\Grupopromovido $grupoPromovido
     * @return Grado
     */
    public function addGrupoPromovido(\Netpublic\CoreBundle\Entity\Grupopromovido $grupoPromovido)
    {
        $this->grupo_promovido[] = $grupoPromovido;

        return $this;
    }

    /**
     * Remove grupo_promovido
     *
     * @param \Netpublic\CoreBundle\Entity\Grupopromovido $grupoPromovido
     */
    public function removeGrupoPromovido(\Netpublic\CoreBundle\Entity\Grupopromovido $grupoPromovido)
    {
        $this->grupo_promovido->removeElement($grupoPromovido);
    }

    /**
     * Get grupo_promovido
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGrupoPromovido()
    {
        return $this->grupo_promovido;
    }

    /**
     * Add condicion_grado
     *
     * @param \Netpublic\CoreBundle\Entity\CondicionGrado $condicionGrado
     * @return Grado
     */
    public function addCondicionGrado(\Netpublic\CoreBundle\Entity\CondicionGrado $condicionGrado)
    {
        $this->condicion_grado[] = $condicionGrado;

        return $this;
    }

    /**
     * Remove condicion_grado
     *
     * @param \Netpublic\CoreBundle\Entity\CondicionGrado $condicionGrado
     */
    public function removeCondicionGrado(\Netpublic\CoreBundle\Entity\CondicionGrado $condicionGrado)
    {
        $this->condicion_grado->removeElement($condicionGrado);
    }

    /**
     * Get condicion_grado
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCondicionGrado()
    {
        return $this->condicion_grado;
    }

    /**
     * Add grado_cursado
     *
     * @param \Netpublic\CoreBundle\Entity\Anoescolargrado $gradoCursado
     * @return Grado
     */
    public function addGradoCursado(\Netpublic\CoreBundle\Entity\Anoescolargrado $gradoCursado)
    {
        $this->grado_cursado[] = $gradoCursado;

        return $this;
    }

    /**
     * Remove grado_cursado
     *
     * @param \Netpublic\CoreBundle\Entity\Anoescolargrado $gradoCursado
     */
    public function removeGradoCursado(\Netpublic\CoreBundle\Entity\Anoescolargrado $gradoCursado)
    {
        $this->grado_cursado->removeElement($gradoCursado);
    }

    /**
     * Get grado_cursado
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGradoCursado()
    {
        return $this->grado_cursado;
    }

    /**
     * Add examen_grado
     *
     * @param \Netpublic\RedsaberBundle\Entity\ExamenIcfes $examenGrado
     * @return Grado
     */
    public function addExamenGrado(\Netpublic\RedsaberBundle\Entity\ExamenIcfes $examenGrado)
    {
        $this->examen_grado[] = $examenGrado;

        return $this;
    }

    /**
     * Remove examen_grado
     *
     * @param \Netpublic\RedsaberBundle\Entity\ExamenIcfes $examenGrado
     */
    public function removeExamenGrado(\Netpublic\RedsaberBundle\Entity\ExamenIcfes $examenGrado)
    {
        $this->examen_grado->removeElement($examenGrado);
    }

    /**
     * Get examen_grado
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExamenGrado()
    {
        return $this->examen_grado;
    }

    /**
     * Add pregunta
     *
     * @param \Netpublic\RedsaberBundle\Entity\Pregunta $pregunta
     * @return Grado
     */
    public function addPreguntum(\Netpublic\RedsaberBundle\Entity\Pregunta $pregunta)
    {
        $this->pregunta[] = $pregunta;

        return $this;
    }

    /**
     * Remove pregunta
     *
     * @param \Netpublic\RedsaberBundle\Entity\Pregunta $pregunta
     */
    public function removePreguntum(\Netpublic\RedsaberBundle\Entity\Pregunta $pregunta)
    {
        $this->pregunta->removeElement($pregunta);
    }

    /**
     * Get pregunta
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPregunta()
    {
        return $this->pregunta;
    }

    /**
     * Add componente
     *
     * @param \Netpublic\RedsaberBundle\Entity\Componente $componente
     * @return Grado
     */
    public function addComponente(\Netpublic\RedsaberBundle\Entity\Componente $componente)
    {
        $this->componente[] = $componente;

        return $this;
    }

    /**
     * Remove componente
     *
     * @param \Netpublic\RedsaberBundle\Entity\Componente $componente
     */
    public function removeComponente(\Netpublic\RedsaberBundle\Entity\Componente $componente)
    {
        $this->componente->removeElement($componente);
    }

    /**
     * Get componente
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComponente()
    {
        return $this->componente;
    }

    /**
     * Set nombre_grupo
     *
     * @param integer $nombreGrupo
     * @return Grado
     */
    public function setNombreGrupo($nombreGrupo)
    {
        $this->nombre_grupo = $nombreGrupo;

        return $this;
    }

    /**
     * Get nombre_grupo
     *
     * @return integer 
     */
    public function getNombreGrupo()
    {
        return $this->nombre_grupo;
    }
}
