<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MatriculaAlumno
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="nota_recuperacion")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\NotaRecuperacionRepository")
 */
class NotaRecuperacion {
      /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="AlumnoDimension",inversedBy="nota_recuperacion")    
    */
   protected $nota;
   
   
    /**
    * @ORM\ManyToOne(targetEntity="Dimension",inversedBy="ano_recuperacion")    
    */    
    protected $ano_escolar;
    
    /**
     * @ORM\Column(type="float",nullable=true)
     */
    protected $nota_recuperacion;
     /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $observacion;

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
     * Set nota_recuperacion
     *
     * @param float $notaRecuperacion
     * @return NotaRecuperacion
     */
    public function setNotaRecuperacion($notaRecuperacion)
    {
        $this->nota_recuperacion = $notaRecuperacion;

        return $this;
    }

    /**
     * Get nota_recuperacion
     *
     * @return float 
     */
    public function getNotaRecuperacion()
    {
        return $this->nota_recuperacion;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return NotaRecuperacion
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
     * Set nota
     *
     * @param \Netpublic\CoreBundle\Entity\AlumnoDimension $nota
     * @return NotaRecuperacion
     */
    public function setNota(\Netpublic\CoreBundle\Entity\AlumnoDimension $nota = null)
    {
        $this->nota = $nota;

        return $this;
    }

    /**
     * Get nota
     *
     * @return \Netpublic\CoreBundle\Entity\AlumnoDimension 
     */
    public function getNota()
    {
        return $this->nota;
    }

    /**
     * Set ano_escolar
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $anoEscolar
     * @return NotaRecuperacion
     */
    public function setAnoEscolar(\Netpublic\CoreBundle\Entity\Dimension $anoEscolar = null)
    {
        $this->ano_escolar = $anoEscolar;

        return $this;
    }

    /**
     * Get ano_escolar
     *
     * @return \Netpublic\CoreBundle\Entity\Dimension 
     */
    public function getAnoEscolar()
    {
        return $this->ano_escolar;
    }
}
