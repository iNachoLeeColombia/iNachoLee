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
 * @ORM\Table(name="descriptores_adicional")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\DescriptorioAdicionalRepository")
 */


class DescriptorAdicional {
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $es_visible_boletin;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $observacion;
    /**
     *
     * @ORM\ManyToOne(targetEntity="AlumnoDesempeno",inversedBy="descriptor_adicional")
     */
    protected $alumno_desempeno;

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
     * Set es_visible_boletin
     *
     * @param \int $esVisibleBoletin
     * @return DescriptorAdicional
     */
    public function setEsVisibleBoletin(\int $esVisibleBoletin)
    {
        $this->es_visible_boletin = $esVisibleBoletin;

        return $this;
    }

    /**
     * Get es_visible_boletin
     *
     * @return \int 
     */
    public function getEsVisibleBoletin()
    {
        return $this->es_visible_boletin;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return DescriptorAdicional
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string 
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set alumno_desempeno
     *
     * @param \Netpublic\CoreBundle\Entity\AlumnoDesempeno $alumnoDesempeno
     * @return DescriptorAdicional
     */
    public function setAlumnoDesempeno(\Netpublic\CoreBundle\Entity\AlumnoDesempeno $alumnoDesempeno = null)
    {
        $this->alumno_desempeno = $alumnoDesempeno;

        return $this;
    }

    /**
     * Get alumno_desempeno
     *
     * @return \Netpublic\CoreBundle\Entity\AlumnoDesempeno 
     */
    public function getAlumnoDesempeno()
    {
        return $this->alumno_desempeno;
    }
}
