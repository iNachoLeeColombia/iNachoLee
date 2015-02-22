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
 * @ORM\Table(name="buble")
 * @ORM\Entity(repositoryClass="Netpublic\RedsaberBundle\Repository\BubleRepository")
 */
class Buble 
{
    /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Respueta",inversedBy="buble")    
     *
     *     
     */   
    protected $respuesta;
    /**
     *
     * @ORM\Column(type="integer",nullable=false)
     */
    protected $estado;
    /**
     *
     * @ORM\Column(type="string",nullable=false)
     */
    protected $label;
    /**
     *
     * @ORM\Column(type="string",nullable=false)
     */
    protected $descripcion;
    


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
     * Set estado
     *
     * @param integer $estado
     * @return Buble
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
     * Set label
     *
     * @param string $label
     * @return Buble
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Buble
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set respuesta
     *
     * @param \Netpublic\RedsaberBundle\Entity\Respueta $respuesta
     * @return Buble
     */
    public function setRespuesta(\Netpublic\RedsaberBundle\Entity\Respueta $respuesta = null)
    {
        $this->respuesta = $respuesta;

        return $this;
    }

    /**
     * Get respuesta
     *
     * @return \Netpublic\RedsaberBundle\Entity\Respueta 
     */
    public function getRespuesta()
    {
        return $this->respuesta;
    }
}
