<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Grado
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Netpublic\CoreBundle\Util\Util;                                               
/**
 * @ORM\Entity
 * @ORM\Table(name="grado_promovido")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\GradopromovidoRepository")
 */
class Gradopromovido {
    /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;    
    /**
    * @ORM\ManyToOne(targetEntity="Grado",inversedBy="grado_promovido")  
    *     */    
    protected $grado_actual;
    /**
    * @ORM\ManyToOne(targetEntity="Grado",inversedBy="grado_promovido_siguiente")  
    *     */    
    protected $grado_siguiente;
     /**
    * @ORM\OneToMany(targetEntity="Anoescolargrado",mappedBy="grupo")  
    *     */    
    protected $grupo_cursado;

    
    public function __toString() {
        return "Grado Actual:".$this->grado_actual." - "."Grado Siguiente:".$this->grado_siguiente;
        
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
     * Set grado_actual
     *
     * @param \Netpublic\CoreBundle\Entity\Grado $gradoActual
     * @return Gradopromovido
     */
    public function setGradoActual(\Netpublic\CoreBundle\Entity\Grado $gradoActual = null)
    {
        $this->grado_actual = $gradoActual;
    
        return $this;
    }

    /**
     * Get grado_actual
     *
     * @return \Netpublic\CoreBundle\Entity\Grado 
     */
    public function getGradoActual()
    {
        return $this->grado_actual;
    }

    /**
     * Set grado_siguiente
     *
     * @param \Netpublic\CoreBundle\Entity\Grado $gradoSiguiente
     * @return Gradopromovido
     */
    public function setGradoSiguiente(\Netpublic\CoreBundle\Entity\Grado $gradoSiguiente = null)
    {
        $this->grado_siguiente = $gradoSiguiente;
    
        return $this;
    }

    /**
     * Get grado_siguiente
     *
     * @return \Netpublic\CoreBundle\Entity\Grado 
     */
    public function getGradoSiguiente()
    {
        return $this->grado_siguiente;
    }

    /**
     * Set cond_habilitacion
     *
     * @param \Netpublic\CoreBundle\Entity\CriterioPromocion $condHabilitacion
     * @return Gradopromovido
     */
    public function setCondHabilitacion(\Netpublic\CoreBundle\Entity\CriterioPromocion $condHabilitacion = null)
    {
        $this->cond_habilitacion = $condHabilitacion;
    
        return $this;
    }

    /**
     * Get cond_habilitacion
     *
     * @return \Netpublic\CoreBundle\Entity\CriterioPromocion 
     */
    public function getCondHabilitacion()
    {
        return $this->cond_habilitacion;
    }

    /**
     * Set cond_perder
     *
     * @param \Netpublic\CoreBundle\Entity\CriterioPromocion $condPerder
     * @return Gradopromovido
     */
    public function setCondPerder(\Netpublic\CoreBundle\Entity\CriterioPromocion $condPerder = null)
    {
        $this->cond_perder = $condPerder;
    
        return $this;
    }

    /**
     * Get cond_perder
     *
     * @return \Netpublic\CoreBundle\Entity\CriterioPromocion 
     */
    public function getCondPerder()
    {
        return $this->cond_perder;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->grupo_cursado = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add grupo_cursado
     *
     * @param \Netpublic\CoreBundle\Entity\Anoescolargrado $grupoCursado
     * @return Gradopromovido
     */
    public function addGrupoCursado(\Netpublic\CoreBundle\Entity\Anoescolargrado $grupoCursado)
    {
        $this->grupo_cursado[] = $grupoCursado;

        return $this;
    }

    /**
     * Remove grupo_cursado
     *
     * @param \Netpublic\CoreBundle\Entity\Anoescolargrado $grupoCursado
     */
    public function removeGrupoCursado(\Netpublic\CoreBundle\Entity\Anoescolargrado $grupoCursado)
    {
        $this->grupo_cursado->removeElement($grupoCursado);
    }

    /**
     * Get grupo_cursado
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGrupoCursado()
    {
        return $this->grupo_cursado;
    }
}
