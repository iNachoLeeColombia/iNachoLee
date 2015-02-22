<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ActividadDesempeno
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="actividad_desempeno")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\porcentajeRepository")
 */

class ActividadDesempeno {
      /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Desempeno",inversedBy="porcentaje")   
     * 
     */
    protected $desempeno;
    /**
     * @ORM\ManyToOne(targetEntity="Dimension",inversedBy="porcentajea")   
     * 
     */
    protected $actividad;    
   
    /**
     * @ORM\Column(type="integer")
     */
    protected $porcentaje;
    
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $descipcion_desempeno;
    public function __toString() {
        return $this->actividad."$this->porcentaje";
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
     * Set porcentaje
     *
     * @param integer $porcentaje
     * @return ActividadDesempeno
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
     * Set descipcion_desempeno
     *
     * @param integer $descipcionDesempeno
     * @return ActividadDesempeno
     */
    public function setDescipcionDesempeno($descipcionDesempeno)
    {
        $this->descipcion_desempeno = $descipcionDesempeno;
    
        return $this;
    }

    /**
     * Get descipcion_desempeno
     *
     * @return integer 
     */
    public function getDescipcionDesempeno()
    {
        return $this->descipcion_desempeno;
    }

    /**
     * Set desempeno
     *
     * @param \Netpublic\CoreBundle\Entity\Desempeno $desempeno
     * @return ActividadDesempeno
     */
    public function setDesempeno(\Netpublic\CoreBundle\Entity\Desempeno $desempeno = null)
    {
        $this->desempeno = $desempeno;
    
        return $this;
    }

    /**
     * Get desempeno
     *
     * @return \Netpublic\CoreBundle\Entity\Desempeno 
     */
    public function getDesempeno()
    {
        return $this->desempeno;
    }

    /**
     * Set actividad
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $actividad
     * @return ActividadDesempeno
     */
    public function setActividad(\Netpublic\CoreBundle\Entity\Dimension $actividad = null)
    {
        $this->actividad = $actividad;
    
        return $this;
    }

    /**
     * Get actividad
     *
     * @return \Netpublic\CoreBundle\Entity\Dimension 
     */
    public function getActividad()
    {
        return $this->actividad;
    }
}
