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
 * @ORM\Table(name="pregunta")
 * @ORM\Entity(repositoryClass="Netpublic\RedsaberBundle\Repository\PreguntaRepository")
 */
class Pregunta 
{
    /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Contenido",inversedBy="preguntas")    
     *
     */   
    protected $contenido;
    /**
     *
     * @ORM\OneToMany(targetEntity="BancoPregunta",mappedBy="pregunta")
     */
    protected $banco_pregunta;
    /**
    * @ORM\OneToMany(targetEntity="PreguntaExamen",mappedBy="pregunta")    
    */    
    protected $pregunta_examen;
    /**
     *
     * @ORM\Column(type="string",nullable=false)
     */
    protected $label;
    /**
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $porcentaje;
    /**
     *
     * @ORM\Column(type="string",nullable=true)
     */
    protected $descripcion_A;
    /**
     *
     * @ORM\Column(type="string",nullable=true)
     */
    protected $descripcion_B;
    /**
     *
     * @ORM\Column(type="string",nullable=true)
     */
    protected $descripcion_C;
    /**
     *
     * @ORM\Column(type="string",nullable=true)
     */
    protected $descripcion_D;
    /**
     * @ORM\ManyToMany(targetEntity="Componente",inversedBy="preguntas")    
     *
     */   
    protected $componente;
    
    /**
     * @ORM\ManyToMany(targetEntity="PlanArea",inversedBy="preguntas")    
     *
     */   
    protected $temas;
    /**
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $estado;
    
    /**
    * @ORM\ManyToOne(targetEntity="Netpublic\CoreBundle\Entity\Profesor",inversedBy="pregunta")    
     *
     *     
     */   
    protected $creador_examen;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $fecha_prublicacion;     
    /**
    * @ORM\ManyToOne(targetEntity="Netpublic\CoreBundle\Entity\Grado",inversedBy="pregunta")    
     *
     *     
     */   
    protected $grado;
    

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->banco_pregunta = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pregunta_examen = new \Doctrine\Common\Collections\ArrayCollection();
        $this->componente = new \Doctrine\Common\Collections\ArrayCollection();
        $this->temas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set label
     *
     * @param string $label
     * @return Pregunta
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string 
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set porcentaje
     *
     * @param integer $porcentaje
     * @return Pregunta
     */
    public function setPorcentaje($porcentaje)
    {
        $this->porcentaje = $porcentaje;

        return $this;
    }

    /**
     * Get porcentaje
     *
     * @return integer 
     */
    public function getPorcentaje()
    {
        return $this->porcentaje;
    }

    /**
     * Set descripcion_A
     *
     * @param string $descripcionA
     * @return Pregunta
     */
    public function setDescripcionA($descripcionA)
    {
        $this->descripcion_A = $descripcionA;

        return $this;
    }

    /**
     * Get descripcion_A
     *
     * @return string 
     */
    public function getDescripcionA()
    {
        return $this->descripcion_A;
    }

    /**
     * Set descripcion_B
     *
     * @param string $descripcionB
     * @return Pregunta
     */
    public function setDescripcionB($descripcionB)
    {
        $this->descripcion_B = $descripcionB;

        return $this;
    }

    /**
     * Get descripcion_B
     *
     * @return string 
     */
    public function getDescripcionB()
    {
        return $this->descripcion_B;
    }

    /**
     * Set descripcion_C
     *
     * @param string $descripcionC
     * @return Pregunta
     */
    public function setDescripcionC($descripcionC)
    {
        $this->descripcion_C = $descripcionC;

        return $this;
    }

    /**
     * Get descripcion_C
     *
     * @return string 
     */
    public function getDescripcionC()
    {
        return $this->descripcion_C;
    }

    /**
     * Set descripcion_D
     *
     * @param string $descripcionD
     * @return Pregunta
     */
    public function setDescripcionD($descripcionD)
    {
        $this->descripcion_D = $descripcionD;

        return $this;
    }

    /**
     * Get descripcion_D
     *
     * @return string 
     */
    public function getDescripcionD()
    {
        return $this->descripcion_D;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     * @return Pregunta
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return integer 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fecha_prublicacion
     *
     * @param \DateTime $fechaPrublicacion
     * @return Pregunta
     */
    public function setFechaPrublicacion($fechaPrublicacion)
    {
        $this->fecha_prublicacion = $fechaPrublicacion;

        return $this;
    }

    /**
     * Get fecha_prublicacion
     *
     * @return \DateTime 
     */
    public function getFechaPrublicacion()
    {
        return $this->fecha_prublicacion;
    }

    /**
     * Set contenido
     *
     * @param \Netpublic\RedsaberBundle\Entity\Contenido $contenido
     * @return Pregunta
     */
    public function setContenido(\Netpublic\RedsaberBundle\Entity\Contenido $contenido = null)
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return \Netpublic\RedsaberBundle\Entity\Contenido 
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Add banco_pregunta
     *
     * @param \Netpublic\RedsaberBundle\Entity\BancoPregunta $bancoPregunta
     * @return Pregunta
     */
    public function addBancoPreguntum(\Netpublic\RedsaberBundle\Entity\BancoPregunta $bancoPregunta)
    {
        $this->banco_pregunta[] = $bancoPregunta;

        return $this;
    }

    /**
     * Remove banco_pregunta
     *
     * @param \Netpublic\RedsaberBundle\Entity\BancoPregunta $bancoPregunta
     */
    public function removeBancoPreguntum(\Netpublic\RedsaberBundle\Entity\BancoPregunta $bancoPregunta)
    {
        $this->banco_pregunta->removeElement($bancoPregunta);
    }

    /**
     * Get banco_pregunta
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBancoPregunta()
    {
        return $this->banco_pregunta;
    }

    /**
     * Add pregunta_examen
     *
     * @param \Netpublic\RedsaberBundle\Entity\PreguntaExamen $preguntaExamen
     * @return Pregunta
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
     * Add componente
     *
     * @param \Netpublic\RedsaberBundle\Entity\Componente $componente
     * @return Pregunta
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
     * Add temas
     *
     * @param \Netpublic\RedsaberBundle\Entity\PlanArea $temas
     * @return Pregunta
     */
    public function addTema(\Netpublic\RedsaberBundle\Entity\PlanArea $temas)
    {
        $this->temas[] = $temas;

        return $this;
    }

    /**
     * Remove temas
     *
     * @param \Netpublic\RedsaberBundle\Entity\PlanArea $temas
     */
    public function removeTema(\Netpublic\RedsaberBundle\Entity\PlanArea $temas)
    {
        $this->temas->removeElement($temas);
    }

    /**
     * Get temas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTemas()
    {
        return $this->temas;
    }

    /**
     * Set creador_examen
     *
     * @param \Netpublic\CoreBundle\Entity\Profesor $creadorExamen
     * @return Pregunta
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
     * Set grado
     *
     * @param \Netpublic\CoreBundle\Entity\Grado $grado
     * @return Pregunta
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
}
