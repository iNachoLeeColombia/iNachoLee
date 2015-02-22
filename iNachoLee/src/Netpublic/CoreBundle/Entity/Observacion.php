<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Observacion
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="observacion")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\ObservacionRepository")
 */
class Observacion {
   /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     *
     * @ORM\Column(type="integer")
     */
    /**
     * 0= Disciplina y Comportamiento
     * 1= Desarrollo de Valores
     * 2= Dificultades
     * 3= Estado Nutricional
     * 4= Desarrollo Fisico
     * 5= Aptitudes
     * 6= Dificultades(Visuales,Auditivas,Motrices,Expresivas)
     * 3= Otros
     */
    protected $tipo;
     /**
     *
     * @ORM\Column(type="text")
     */
    protected $contenido;
    /**
    * @ORM\ManyToOne(targetEntity="Profesor",inversedBy="observacion")    
    *
    */    
    protected $dueno; 
    /**
    * @ORM\ManyToOne(targetEntity="Alumno",inversedBy="observacion")    
    *
    */    
    protected $alumno; 
    /**
    * @ORM\ManyToOne(targetEntity="Dimension",inversedBy="observacion")    
    *
    */    
    protected $periodo; 
    public function __toString() {
        return $this->contenido;
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
     * Set tipo
     *
     * @param integer $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * Get tipo
     *
     * @return integer 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set contenido
     *
     * @param text $contenido
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;
    }

    /**
     * Get contenido
     *
     * @return text 
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set dueno
     *
     * @param Netpublic\CoreBundle\Entity\Profesor $dueno
     */
    public function setDueno(\Netpublic\CoreBundle\Entity\Profesor $dueno)
    {
        $this->dueno = $dueno;
    }

    /**
     * Get dueno
     *
     * @return Netpublic\CoreBundle\Entity\Profesor 
     */
    public function getDueno()
    {
        return $this->dueno;
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
     * Set periodo
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $periodo
     * @return Observacion
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
}
