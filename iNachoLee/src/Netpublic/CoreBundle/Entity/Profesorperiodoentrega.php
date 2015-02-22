<?php
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Desempeno
 *
 * @author yuri
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="profesor_peridoentrega")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\ProfesorperiodoentregaRepository")
 */


class Profesorperiodoentrega {
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;
     /**
     *
     * @ORM\ManyToOne(targetEntity="Dimension",inversedBy="profesor_periodo_entrega")
     */
    protected $periodo;
     /**
     *
     * @ORM\ManyToOne(targetEntity="Profesor",inversedBy="profesor_periodo_entrega")
     */
    protected $profesor;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $fecha_inicio;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $fecha_final;    




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
     * Set fecha_inicio
     *
     * @param \DateTime $fechaInicio
     * @return Profesorperiodoentrega
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
     * Set fecha_final
     *
     * @param \DateTime $fechaFinal
     * @return Profesorperiodoentrega
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fecha_final = $fechaFinal;
    
        return $this;
    }

    /**
     * Get fecha_final
     *
     * @return \DateTime 
     */
    public function getFechaFinal()
    {
        return $this->fecha_final;
    }

    /**
     * Set periodo
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $periodo
     * @return Profesorperiodoentrega
     */
    public function setPeriodo(\Netpublic\CoreBundle\Entity\Dimension $periodo = null)
    {
        $this->periodo = $periodo;
    
        return $this;
    }

    /**
     * Get periodo
     *
     * @return \Netpublic\CoreBundle\Entity\Dimension 
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Set profesor
     *
     * @param \Netpublic\CoreBundle\Entity\Profesor $profesor
     * @return Profesorperiodoentrega
     */
    public function setProfesor(\Netpublic\CoreBundle\Entity\Profesor $profesor = null)
    {
        $this->profesor = $profesor;
    
        return $this;
    }

    /**
     * Get profesor
     *
     * @return \Netpublic\CoreBundle\Entity\Profesor 
     */
    public function getProfesor()
    {
        return $this->profesor;
    }
}
