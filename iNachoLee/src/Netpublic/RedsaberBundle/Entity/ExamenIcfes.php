<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Alumno
 *
 * @author yuri
 */
namespace Netpublic\RedsaberBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="examen_icfes")
 * @ORM\Entity(repositoryClass="Netpublic\RedsaberBundle\Repository\ExamenicfesRepository")
 */
class ExamenIcfes 
{
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
    protected $nro_preguntas;
     /**
     *
     * @ORM\Column(type="integer",nullable=false)
     */
    protected $tipo;

    /**
     *
     * @ORM\Column(type="string",nullable=false)
     */
    protected $nombre;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $fecha_inicio;     
   
    

    /**
    * @ORM\ManyToOne(targetEntity="Netpublic\CoreBundle\Entity\Grado",inversedBy="examen_grado")    
     *
     *     
     */   
    protected $grados;
    /**
    * @ORM\ManyToOne(targetEntity="Netpublic\CoreBundle\Entity\Grupo",inversedBy="examen_grupo")    
     *
     *     
     */   
    protected $grupo;

    /**
    * @ORM\ManyToOne(targetEntity="Netpublic\CoreBundle\Entity\Profesor",inversedBy="examen_responsable")    
     *
     *     
     */   
    protected $reponsable;
    /**
    * @ORM\ManyToOne(targetEntity="Netpublic\CoreBundle\Entity\Profesor",inversedBy="examen_creador")    
     *
     *     
     */   
    protected $creador_examen;

    /**
    * @ORM\OneToMany(targetEntity="Alumno",mappedBy="examen")    
    */    
    protected $alumnos;
    /**
    * @ORM\OneToMany(targetEntity="AlumnoExamen",mappedBy="examen")    
    */    
    protected $alumno_examen;
    /**
     *
     * @ORM\Column(type="integer",nullable=false)
     */
    protected $hora;
    /**
     *
     * @ORM\Column(type="integer",nullable=false)
     */
    protected $minuto;
    /**
    * @ORM\OneToMany(targetEntity="PreguntaExamen",mappedBy="examen")    
    */    
    protected $pregunta_examen;

    /**
    * @ORM\OneToMany(targetEntity="Respueta",mappedBy="examen")    
    */    
    protected $respuesta_examen;
    
     /**
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $es_evalauado;
     /**
     *
     * @ORM\Column(type="integer",nullable=false)
     */
    protected $nota_maxima;

    public function __toString() {
        return $this->nombre;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->alumnos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->alumno_examen = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nro_preguntas
     *
     * @param integer $nroPreguntas
     * @return ExamenIcfes
     */
    public function setNroPreguntas($nroPreguntas)
    {
        $this->nro_preguntas = $nroPreguntas;

        return $this;
    }

    /**
     * Get nro_preguntas
     *
     * @return integer 
     */
    public function getNroPreguntas()
    {
        return $this->nro_preguntas;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     * @return ExamenIcfes
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
     * Set nombre
     *
     * @param string $nombre
     * @return ExamenIcfes
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
     * Set fecha_inicio
     *
     * @param \DateTime $fechaInicio
     * @return ExamenIcfes
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fecha_inicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fecha_inicio
     *
     * @return \DateTime 
     */
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    /**
     * Set hora
     *
     * @param integer $hora
     * @return ExamenIcfes
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return integer 
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set minuto
     *
     * @param integer $minuto
     * @return ExamenIcfes
     */
    public function setMinuto($minuto)
    {
        $this->minuto = $minuto;

        return $this;
    }

    /**
     * Get minuto
     *
     * @return integer 
     */
    public function getMinuto()
    {
        return $this->minuto;
    }

    /**
     * Set grados
     *
     * @param \Netpublic\CoreBundle\Entity\Grado $grados
     * @return ExamenIcfes
     */
    public function setGrados(\Netpublic\CoreBundle\Entity\Grado $grados = null)
    {
        $this->grados = $grados;

        return $this;
    }

    /**
     * Get grados
     *
     * @return \Netpublic\CoreBundle\Entity\Grado 
     */
    public function getGrados()
    {
        return $this->grados;
    }

    /**
     * Set reponsable
     *
     * @param \Netpublic\CoreBundle\Entity\Profesor $reponsable
     * @return ExamenIcfes
     */
    public function setReponsable(\Netpublic\CoreBundle\Entity\Profesor $reponsable = null)
    {
        $this->reponsable = $reponsable;

        return $this;
    }

    /**
     * Get reponsable
     *
     * @return \Netpublic\CoreBundle\Entity\Profesor 
     */
    public function getReponsable()
    {
        return $this->reponsable;
    }

    /**
     * Set creador_examen
     *
     * @param \Netpublic\CoreBundle\Entity\Profesor $creadorExamen
     * @return ExamenIcfes
     */
    public function setCreadorExamen(\Netpublic\CoreBundle\Entity\Profesor $creadorExamen = null)
    {
        $this->creador_examen = $creadorExamen;

        return $this;
    }

    /**
     * Get creador_examen
     *
     * @return \Netpublic\CoreBundle\Entity\Profesor 
     */
    public function getCreadorExamen()
    {
        return $this->creador_examen;
    }

    /**
     * Add alumnos
     *
     * @param \Netpublic\RedsaberBundle\Entity\Alumno $alumnos
     * @return ExamenIcfes
     */
    public function addAlumno(\Netpublic\RedsaberBundle\Entity\Alumno $alumnos)
    {
        $this->alumnos[] = $alumnos;

        return $this;
    }

    /**
     * Remove alumnos
     *
     * @param \Netpublic\RedsaberBundle\Entity\Alumno $alumnos
     */
    public function removeAlumno(\Netpublic\RedsaberBundle\Entity\Alumno $alumnos)
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
     * Add alumno_examen
     *
     * @param \Netpublic\RedsaberBundle\Entity\AlumnoExamen $alumnoExamen
     * @return ExamenIcfes
     */
    public function addAlumnoExaman(\Netpublic\RedsaberBundle\Entity\AlumnoExamen $alumnoExamen)
    {
        $this->alumno_examen[] = $alumnoExamen;

        return $this;
    }

    /**
     * Remove alumno_examen
     *
     * @param \Netpublic\RedsaberBundle\Entity\AlumnoExamen $alumnoExamen
     */
    public function removeAlumnoExaman(\Netpublic\RedsaberBundle\Entity\AlumnoExamen $alumnoExamen)
    {
        $this->alumno_examen->removeElement($alumnoExamen);
    }

    /**
     * Get alumno_examen
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAlumnoExamen()
    {
        return $this->alumno_examen;
    }

    /**
     * Add pregunta_examen
     *
     * @param \Netpublic\RedsaberBundle\Entity\PreguntaExamen $preguntaExamen
     * @return ExamenIcfes
     */
    public function addPreguntaExaman(\Netpublic\RedsaberBundle\Entity\PreguntaExamen $preguntaExamen)
    {
        $this->pregunta_examen[] = $preguntaExamen;

        return $this;
    }

    /**
     * Remove pregunta_examen
     *
     * @param \Netpublic\RedsaberBundle\Entity\PreguntaExamen $preguntaExamen
     */
    public function removePreguntaExaman(\Netpublic\RedsaberBundle\Entity\PreguntaExamen $preguntaExamen)
    {
        $this->pregunta_examen->removeElement($preguntaExamen);
    }

    /**
     * Get pregunta_examen
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPreguntaExamen()
    {
        return $this->pregunta_examen;
    }

    /**
     * Add respuesta_examen
     *
     * @param \Netpublic\RedsaberBundle\Entity\Respueta $respuestaExamen
     * @return ExamenIcfes
     */
    public function addRespuestaExaman(\Netpublic\RedsaberBundle\Entity\Respueta $respuestaExamen)
    {
        $this->respuesta_examen[] = $respuestaExamen;

        return $this;
    }

    /**
     * Remove respuesta_examen
     *
     * @param \Netpublic\RedsaberBundle\Entity\Respueta $respuestaExamen
     */
    public function removeRespuestaExaman(\Netpublic\RedsaberBundle\Entity\Respueta $respuestaExamen)
    {
        $this->respuesta_examen->removeElement($respuestaExamen);
    }

    /**
     * Get respuesta_examen
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRespuestaExamen()
    {
        return $this->respuesta_examen;
    }

    /**
     * Set es_evalauado
     *
     * @param integer $esEvalauado
     * @return ExamenIcfes
     */
    public function setEsEvalauado($esEvalauado)
    {
        $this->es_evalauado = $esEvalauado;

        return $this;
    }

    /**
     * Get es_evalauado
     *
     * @return integer 
     */
    public function getEsEvalauado()
    {
        return $this->es_evalauado;
    }

    /**
     * Set grupo
     *
     * @param \Netpublic\CoreBundle\Entity\Grupo $grupo
     * @return ExamenIcfes
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
     * Set nota_maxima
     *
     * @param integer $notaMaxima
     * @return ExamenIcfes
     */
    public function setNotaMaxima($notaMaxima)
    {
        $this->nota_maxima = $notaMaxima;

        return $this;
    }

    /**
     * Get nota_maxima
     *
     * @return integer 
     */
    public function getNotaMaxima()
    {
        return $this->nota_maxima;
    }
}
