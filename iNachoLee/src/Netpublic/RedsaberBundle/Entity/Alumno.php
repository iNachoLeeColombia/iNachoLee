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
 * @ORM\Table(name="alumno_redsaber")
 * @ORM\Entity(repositoryClass="Netpublic\RedsaberBundle\Repository\AlumnoRepository")
 */

class Alumno {
     /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
    * @ORM\ManyToOne(targetEntity="ExamenIcfes",inversedBy="alumnos")    
     *
     *     
     */   
    protected $examen;
     /**
     *
     * @ORM\Column(type="string",nullable=false)
     */
    protected $nombre_completo;


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
     * @return Alumno
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
     * Set nombre_completo
     *
     * @param string $nombreCompleto
     * @return Alumno
     */
    public function setNombreCompleto($nombreCompleto)
    {
        $this->nombre_completo = $nombreCompleto;

        return $this;
    }

    /**
     * Get nombre_completo
     *
     * @return string 
     */
    public function getNombreCompleto()
    {
        return $this->nombre_completo;
    }
}
