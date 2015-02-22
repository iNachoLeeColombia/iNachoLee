<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AlumnoDimension
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="alumno_desempeno")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\AlumnodesempenoRepository")
 */

class AlumnoDesempeno {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Alumno",inversedBy="nota_desempeno") 
     * 
     */
    protected $alumno;
    /**
     * @ORM\ManyToOne(targetEntity="Dimension",inversedBy="nota_desempeno")
     *
     */
    protected $dimension;    
    /**
     * @ORM\ManyToOne(targetEntity="Asignatura",inversedBy="nota_desempeno")
     *
     */
    protected $asignatura;    
    /**
     * @ORM\ManyToOne(targetEntity="Desempeno",inversedBy="nota_desempeno")
     *
     */
    protected $desempeno;       
    
    
    /**
     * @ORM\Column(type="float")
     */
    protected $index_desempeno;
 
     /**
     *
     * @ORM\OneTomany(targetEntity="DescriptorAdicional",mappedBy="alumno_desempeno")
     */
    protected $descriptor_adicional;
    /**
     * @ORM\Column(type="integer")
     */
    protected $tiene_descriptor_adicional;
    /**
     * @ORM\Column(type="integer")
     */
    protected $es_imprimir_boletin;
 
    public function __toString() {
        return $this->alumno.$this->asignatura.$this->index_desempeno;
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
     * Set index_desempeno
     *
     * @param float $indexDesempeno
     */
    public function setIndexDesempeno($indexDesempeno)
    {
        $this->index_desempeno = $indexDesempeno;
    }

    /**
     * Get index_desempeno
     *
     * @return float 
     */
    public function getIndexDesempeno()
    {
        return $this->index_desempeno;
    }

    /**
     * Set alumno
     *
     * @param Netpublic\CoreBundle\Entity\Alumno $alumno
     */
    public function setAlumno(\Netpublic\CoreBundle\Entity\Alumno $alumno)
    {
        $this->alumno = $alumno;
    }

    /**
     * Get alumno
     *
     * @return Netpublic\CoreBundle\Entity\Alumno 
     */
    public function getAlumno()
    {
        return $this->alumno;
    }

    /**
     * Set dimension
     *
     * @param Netpublic\CoreBundle\Entity\Dimension $dimension
     */
    public function setDimension(\Netpublic\CoreBundle\Entity\Dimension $dimension)
    {
        $this->dimension = $dimension;
    }

    /**
     * Get dimension
     *
     * @return Netpublic\CoreBundle\Entity\Dimension 
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * Set asignatura
     *
     * @param Netpublic\CoreBundle\Entity\Asignatura $asignatura
     */
    public function setAsignatura(\Netpublic\CoreBundle\Entity\Asignatura $asignatura)
    {
        $this->asignatura = $asignatura;
    }

    /**
     * Get asignatura
     *
     * @return Netpublic\CoreBundle\Entity\Asignatura 
     */
    public function getAsignatura()
    {
        return $this->asignatura;
    }

    /**
     * Set desempeno
     *
     * @param Netpublic\CoreBundle\Entity\Desempeno $desempeno
     */
    public function setDesempeno(\Netpublic\CoreBundle\Entity\Desempeno $desempeno)
    {
        $this->desempeno = $desempeno;
    }

    /**
     * Get desempeno
     *
     * @return Netpublic\CoreBundle\Entity\Desempeno 
     */
    public function getDesempeno()
    {
        return $this->desempeno;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->descriptor_adicional = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add descriptor_adicional
     *
     * @param \Netpublic\CoreBundle\Entity\DescriptorAdicional $descriptorAdicional
     * @return AlumnoDesempeno
     */
    public function addDescriptorAdicional(\Netpublic\CoreBundle\Entity\DescriptorAdicional $descriptorAdicional)
    {
        $this->descriptor_adicional[] = $descriptorAdicional;

        return $this;
    }

    /**
     * Remove descriptor_adicional
     *
     * @param \Netpublic\CoreBundle\Entity\DescriptorAdicional $descriptorAdicional
     */
    public function removeDescriptorAdicional(\Netpublic\CoreBundle\Entity\DescriptorAdicional $descriptorAdicional)
    {
        $this->descriptor_adicional->removeElement($descriptorAdicional);
    }

    /**
     * Get descriptor_adicional
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDescriptorAdicional()
    {
        return $this->descriptor_adicional;
    }

    /**
     * Set tiene_descriptor_adicional
     *
     * @param integer $tieneDescriptorAdicional
     * @return AlumnoDesempeno
     */
    public function setTieneDescriptorAdicional($tieneDescriptorAdicional)
    {
        $this->tiene_descriptor_adicional = $tieneDescriptorAdicional;

        return $this;
    }

    /**
     * Get tiene_descriptor_adicional
     *
     * @return integer 
     */
    public function getTieneDescriptorAdicional()
    {
        return $this->tiene_descriptor_adicional;
    }

    /**
     * Set es_imprimir_boletin
     *
     * @param integer $esImprimirBoletin
     * @return AlumnoDesempeno
     */
    public function setEsImprimirBoletin($esImprimirBoletin)
    {
        $this->es_imprimir_boletin = $esImprimirBoletin;

        return $this;
    }

    /**
     * Get es_imprimir_boletin
     *
     * @return integer 
     */
    public function getEsImprimirBoletin()
    {
        return $this->es_imprimir_boletin;
    }
}
