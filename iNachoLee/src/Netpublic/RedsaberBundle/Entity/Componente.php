<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Componente
 *
 * @author yuri
 */

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
 * @ORM\Table(name="componente")
 * @ORM\Entity(repositoryClass="Netpublic\RedsaberBundle\Repository\ComponenteRepository")
 */

class Componente {
        /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
    * @ORM\ManyToOne(targetEntity="Netpublic\CoreBundle\Entity\Grado",inversedBy="componente")    
    *
    *     
    */   
    protected $grado;
     /**
     *
     * @ORM\Column(type="string",nullable=true)
     */
    protected $nombre;
    /**
     * @ORM\ManyToMany(targetEntity="Pregunta",mappedBy="componente")  
     * 
    */    
    protected $preguntas;
    /**
    * @ORM\ManyToOne(targetEntity="Componente",inversedBy="padre")    
    *
    *     
    */   
    protected $padre;
    /**
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $tipo;
    /**
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $es_ultimo;

    public function __toString() {
        return $this->nombre;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->preguntas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Componente
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
     * Set grado
     *
     * @param \Netpublic\CoreBundle\Entity\Grado $grado
     * @return Componente
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
     * Add preguntas
     *
     * @param \Netpublic\RedsaberBundle\Entity\Pregunta $preguntas
     * @return Componente
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
     * Set padre
     *
     * @param \Netpublic\RedsaberBundle\Entity\Componente $padre
     * @return Componente
     */
    public function setPadre(\Netpublic\RedsaberBundle\Entity\Componente $padre = null)
    {
        $this->padre = $padre;

        return $this;
    }

    /**
     * Get padre
     *
     * @return \Netpublic\RedsaberBundle\Entity\Componente 
     */
    public function getPadre()
    {
        return $this->padre;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     * @return Componente
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
     * Set es_ultimo
     *
     * @param integer $esUltimo
     * @return Componente
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
