<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TemaAsignatura
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="tema_asignatura")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\TemaasignaturaRepository")
 */
class TemaAsignatura {
     /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
    * @ORM\ManyToOne(targetEntity="Asignatura",inversedBy="tema_asignatura")   
    * 
    */    
    protected $asignatura;
    /**
    *
    * @ORM\Column(type="text")
    */
   protected $tema;

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
     * Set tema
     *
     * @param text $tema
     */
    public function setTema($tema)
    {
        $this->tema = $tema;
    }

    /**
     * Get tema
     *
     * @return text 
     */
    public function getTema()
    {
        return $this->tema;
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
}
