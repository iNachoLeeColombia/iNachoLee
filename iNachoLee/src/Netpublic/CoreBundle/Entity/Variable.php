<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Colegio
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Netpublic\CoreBundle\Entity\Usuario;
/**
 * @ORM\Entity
 * @ORM\Table(name="variable")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\VariableRepository")
 */
class Variable {
     /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
     /**
     *
     * @ORM\Column(type="string")
     */    
    protected $nombre;    
    /**
    * @ORM\OneToMany(targetEntity="ValorVariable",mappedBy="ValorVariable")    
    */    
    protected $valor_variable;
    protected $v_nucleo_privado;    
    public function __toString() {
        return $this->nombre;
    }
    
    public function __construct()
    {
        $this->valor_variable = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add valor_variable
     *
     * @param Netpublic\CoreBundle\Entity\ValorVariable $valorVariable
     */
    public function addValorVariable(\Netpublic\CoreBundle\Entity\ValorVariable $valorVariable)
    {
        $this->valor_variable[] = $valorVariable;
    }

    /**
     * Get valor_variable
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getValorVariable()
    {
        return $this->valor_variable;
    }

    /**
     * Remove valor_variable
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $valorVariable
     */
    public function removeValorVariable(\Netpublic\CoreBundle\Entity\ValorVariable $valorVariable)
    {
        $this->valor_variable->removeElement($valorVariable);
    }
}
