<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PreguntaExamen
 *
 * @author yuri
 */
namespace Netpublic\RedsaberBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="plan_area")
 * @ORM\Entity(repositoryClass="Netpublic\RedsaberBundle\Repository\PlanareaaRepository")
 */

class PlanArea {
    /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     *
     * 
     * @ORM\Column(type="string")
     * 
     */
    protected $nombre;
    
    /**
    * @ORM\ManyToOne(targetEntity="Netpublic\CoreBundle\Entity\Asignatura",inversedBy="plan_area")    
    *
    *     
    */   
    protected $asignatura;
    /**
    * @ORM\ManyToOne(targetEntity="PlanArea",inversedBy="padre")    
    *
    *     
    */   
    protected $padre;

    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $anchor_interno;
    /**
     * @ORM\Column(type="text")
     * 
     */
    protected $contenido;
    /**
     * @ORM\Column(type="integer")
     * 
     */
    protected $posicion;
    /**
     * @ORM\ManyToMany(targetEntity="Pregunta",inversedBy="temas")    
     *
     */   
    protected $preguntas;
    /**
     * @ORM\OneToMany(targetEntity="TemasEvaluados",mappedBy="tema")  
     * 
    */    
    protected $temas_evaluado;
    /**
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $es_ultimo;



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
     * @return PlanArea
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
     * Set anchor_interno
     *
     * @param string $anchorInterno
     * @return PlanArea
     */
    public function setAnchorInterno($anchorInterno)
    {
        $this->anchor_interno = $anchorInterno;

        return $this;
    }

    /**
     * Get anchor_interno
     *
     * @return string 
     */
    public function getAnchorInterno()
    {
        return $this->anchor_interno;
    }

    /**
     * Set contenido
     *
     * @param string $contenido
     * @return PlanArea
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return string 
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set padre
     *
     * @param \Netpublic\RedsaberBundle\Entity\PlanArea $padre
     * @return PlanArea
     */
    public function setPadre(\Netpublic\RedsaberBundle\Entity\PlanArea $padre = null)
    {
        $this->padre = $padre;

        return $this;
    }

    /**
     * Get padre
     *
     * @return \Netpublic\RedsaberBundle\Entity\PlanArea 
     */
    public function getPadre()
    {
        return $this->padre;
    }

    /**
     * Set posicion
     *
     * @param integer $posicion
     * @return PlanArea
     */
    public function setPosicion($posicion)
    {
        $this->posicion = $posicion;

        return $this;
    }

    /**
     * Get posicion
     *
     * @return integer 
     */
    public function getPosicion()
    {
        return $this->posicion;
    }

    /**
     * Set asignatura
     *
     * @param \Netpublic\CoreBundle\Entity\Asignatura $asignatura
     * @return PlanArea
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
     * Constructor
     */
    public function __construct()
    {
        $this->preguntas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add preguntas
     *
     * @param \Netpublic\RedsaberBundle\Entity\Pregunta $preguntas
     * @return PlanArea
     */
    public function addPregunta(\Netpublic\RedsaberBundle\Entity\Pregunta $preguntas)
    {
        $this->preguntas[] = $preguntas;

        return $this;
    }

    /**
     * Remove preguntas
     *
     * @param \Netpublic\RedsaberBundle\Entity\Pregunta $preguntas
     */
    public function removePregunta(\Netpublic\RedsaberBundle\Entity\Pregunta $preguntas)
    {
        $this->preguntas->removeElement($preguntas);
    }

    /**
     * Get preguntas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPreguntas()
    {
        return $this->preguntas;
    }

    /**
     * Add temas_evaluado
     *
     * @param \Netpublic\RedsaberBundle\Entity\TemasEvaluados $temasEvaluado
     * @return PlanArea
     */
    public function addTemasEvaluado(\Netpublic\RedsaberBundle\Entity\TemasEvaluados $temasEvaluado)
    {
        $this->temas_evaluado[] = $temasEvaluado;

        return $this;
    }

    /**
     * Remove temas_evaluado
     *
     * @param \Netpublic\RedsaberBundle\Entity\TemasEvaluados $temasEvaluado
     */
    public function removeTemasEvaluado(\Netpublic\RedsaberBundle\Entity\TemasEvaluados $temasEvaluado)
    {
        $this->temas_evaluado->removeElement($temasEvaluado);
    }

    /**
     * Get temas_evaluado
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTemasEvaluado()
    {
        return $this->temas_evaluado;
    }

    /**
     * Set es_ultimo
     *
     * @param integer $esUltimo
     * @return PlanArea
     */
    public function setEsUltimo($esUltimo)
    {
        $this->es_ultimo = $esUltimo;

        return $this;
    }

    /**
     * Get es_ultimo
     *
     * @return integer 
     */
    public function getEsUltimo()
    {
        return $this->es_ultimo;
    }
}
