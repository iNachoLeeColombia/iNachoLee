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
 * @ORM\Table(name="pregunta_examen")
 * @ORM\Entity(repositoryClass="Netpublic\RedsaberBundle\Repository\PreguntaexamenRepository")
 */

class PreguntaExamen {
    /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
    * @ORM\ManyToOne(targetEntity="ExamenIcfes",inversedBy="pregunta_examen")    
    *
    *     
    */   
    protected $examen;
    /**
    * @ORM\ManyToOne(targetEntity="Pregunta",inversedBy="pregunta_examen")    
     *
     *     
     */   
    protected $pregunta;
    /**
     *
     * @ORM\Column(type="integer",nullable=false)
     */
    protected $posicion=0;
    

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
     * Set examen
     *
     * @param \Netpublic\RedsaberBundle\Entity\ExamenIcfes $examen
     * @return PreguntaExamen
     */
    public function setExamen(\Netpublic\RedsaberBundle\Entity\ExamenIcfes $examen = null)
    {
        $this->examen = $examen;

        return $this;
    }

    /**
     * Get examen
     *
     * @return \Netpublic\RedsaberBundle\Entity\ExamenIcfes 
     */
    public function getExamen()
    {
        return $this->examen;
    }

    /**
     * Set pregunta
     *
     * @param \Netpublic\RedsaberBundle\Entity\Pregunta $pregunta
     * @return PreguntaExamen
     */
    public function setPregunta(\Netpublic\RedsaberBundle\Entity\Pregunta $pregunta = null)
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    /**
     * Get pregunta
     *
     * @return \Netpublic\RedsaberBundle\Entity\Pregunta 
     */
    public function getPregunta()
    {
        return $this->pregunta;
    }

    /**
     * Set posicion
     *
     * @param integer $posicion
     * @return PreguntaExamen
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
}
