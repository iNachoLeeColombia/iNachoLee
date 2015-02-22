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
 * @ORM\Table(name="contenido_redsaber")
 * @ORM\Entity(repositoryClass="Netpublic\RedsaberBundle\Repository\ContenidoRepository")
 */

class Contenido {
     /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
    * @ORM\OneToMany(targetEntity="Pregunta",mappedBy="contenido")    
     *
     *     
     */   
    protected $preguntas;
     /**
     *
     * @ORM\Column(type="text",nullable=false)
     */
    protected $cuerpo;
 
    public function __toString() {
        return $this->cuerpo;
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
     * Set cuerpo
     *
     * @param string $cuerpo
     * @return Contenido
     */
    public function setCuerpo($cuerpo)
    {
        $this->cuerpo = $cuerpo;

        return $this;
    }

    /**
     * Get cuerpo
     *
     * @return string 
     */
    public function getCuerpo()
    {
        return $this->cuerpo;
    }

    /**
     * Add preguntas
     *
     * @param \Netpublic\RedsaberBundle\Entity\Pregunta $preguntas
     * @return Contenido
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
}
