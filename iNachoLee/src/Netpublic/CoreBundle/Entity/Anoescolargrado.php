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
/**
 * @ORM\Entity
 * @ORM\Table(name="ano_escolar_grado")
 *                                                                                      
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\AnoescolargradoRepository")
 */
class Anoescolargrado {
    /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
    * @ORM\ManyToOne(targetEntity="Alumno",inversedBy="alumno_cursado")  
    *     */    
    protected $alumno;

    /**
    * @ORM\ManyToOne(targetEntity="Dimension",inversedBy="ano_cursado")  
    *     */    
    protected $anoescolar;

    /**
    * @ORM\ManyToOne(targetEntity="Grado",inversedBy="grado_cursado")  
    *     */    
    protected $grado;
    /**
    * @ORM\ManyToOne(targetEntity="Grupo",inversedBy="grupo_cursado")  
    *
     */    
    protected $grupo;

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
     * Set alumno
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $alumno
     * @return Anoescolargrado
     */
    public function setAlumno(\Netpublic\CoreBundle\Entity\Alumno $alumno = null)
    {
        $this->alumno = $alumno;

        return $this;
    }

    /**
     * Get alumno
     *
     * @return \Netpublic\CoreBundle\Entity\Alumno 
     */
    public function getAlumno()
    {
        return $this->alumno;
    }

    /**
     * Set anoescolar
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $anoescolar
     * @return Anoescolargrado
     */
    public function setAnoescolar(\Netpublic\CoreBundle\Entity\Dimension $anoescolar = null)
    {
        $this->anoescolar = $anoescolar;

        return $this;
    }

    /**
     * Get anoescolar
     *
     * @return \Netpublic\CoreBundle\Entity\Dimension 
     */
    public function getAnoescolar()
    {
        return $this->anoescolar;
    }

    /**
     * Set grado
     *
     * @param \Netpublic\CoreBundle\Entity\Grado $grado
     * @return Anoescolargrado
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

    /**
     * Set grupo
     *
     * @param \Netpublic\CoreBundle\Entity\Grupo $grupo
     * @return Anoescolargrado
     */
    public function setGrupo(\Netpublic\CoreBundle\Entity\Grupo $grupo = null)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo
     *
     * @return \Netpublic\CoreBundle\Entity\Grupo 
     */
    public function getGrupo()
    {
        return $this->grupo;
    }
}
