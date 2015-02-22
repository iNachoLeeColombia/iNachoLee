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
 * @ORM\Table(name="grupo_promovido")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\GrupopromovidoRepository")
 */
class Grupopromovido {
    /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;    
    /**
    * @ORM\ManyToOne(targetEntity="Grupo",inversedBy="grupo_promovido")  
    *     */    
    protected $grupo_actual;
    /**
    * @ORM\ManyToOne(targetEntity="Grupo",inversedBy="grupo_promovido_siguiente")  
    *     */    
    protected $grupo_siguiente;
    
    /**
    * @ORM\ManyToOne(targetEntity="Grado",inversedBy="grupo_promovido")    
    */    

    protected $grado;                 
    

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
     * Set grupo_actual
     *
     * @param \Netpublic\CoreBundle\Entity\Grupo $grupoActual
     * @return Grupopromovido
     */
    public function setGrupoActual(\Netpublic\CoreBundle\Entity\Grupo $grupoActual = null)
    {
        $this->grupo_actual = $grupoActual;
    
        return $this;
    }

    /**
     * Get grupo_actual
     *
     * @return \Netpublic\CoreBundle\Entity\Grupo 
     */
    public function getGrupoActual()
    {
        return $this->grupo_actual;
    }

    /**
     * Set grupo_siguiente
     *
     * @param \Netpublic\CoreBundle\Entity\Grupo $grupoSiguiente
     * @return Grupopromovido
     */
    public function setGrupoSiguiente(\Netpublic\CoreBundle\Entity\Grupo $grupoSiguiente = null)
    {
        $this->grupo_siguiente = $grupoSiguiente;
    
        return $this;
    }

    /**
     * Get grupo_siguiente
     *
     * @return \Netpublic\CoreBundle\Entity\Grupo 
     */
    public function getGrupoSiguiente()
    {
        return $this->grupo_siguiente;
    }

    /**
     * Set grado
     *
     * @param \Netpublic\CoreBundle\Entity\Grado $grado
     * @return Grupopromovido
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
}
