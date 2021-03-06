<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AspectoEvaluar
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="aspecto_evaluar")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\AspectoEvaluarRepository")
 */

class AspectoEvaluar {
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
     protected $id;
     
    /**
     *
     * @ORM\OneToMany(targetEntity="Desempeno",mappedBy="aspecto_evaluar")
     */
    protected $desempeno;
     /**
     * @ORM\Column(type="string")
     */
    protected $nombre;

    public function __toString() {
        return $this->nombre;
    }



    public function __construct()
    {
        $this->desempeno = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add desempeno
     *
     * @param Netpublic\CoreBundle\Entity\Desempeno $desempeno
     */
    public function addDesempeno(\Netpublic\CoreBundle\Entity\Desempeno $desempeno)
    {
        $this->desempeno[] = $desempeno;
    }

    /**
     * Get desempeno
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDesempeno()
    {
        return $this->desempeno;
    }

    /**
     * Remove desempeno
     *
     * @param \Netpublic\CoreBundle\Entity\Desempeno $desempeno
     */
    public function removeDesempeno(\Netpublic\CoreBundle\Entity\Desempeno $desempeno)
    {
        $this->desempeno->removeElement($desempeno);
    }
}
