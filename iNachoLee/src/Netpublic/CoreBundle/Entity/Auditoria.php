<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Alumno
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Netpublic\CoreBundle\Entity\Usuario;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="auditoria")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\AuditoriaRepository")
 */
class Auditoria
{
    /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     *
     * @ORM\Column(type="string",nullable=false)
     */
    protected $nombre;
        /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $fecha_inicio;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $fecha_final;    
     /**
     *
     * @ORM\ManyToOne(targetEntity="Colegio",inversedBy="auditoria")
     */
    protected $sede;
    /**
    * @ORM\OneToMany(targetEntity="ProfesorSolicitud",mappedBy="auditoria")      
    */    
   protected $solicitud;
    /**
     *  2 Revisión De Boletines Profesores
     *  1 Auditorias
     *  3 Revisión de Boletin por parte del alumno
     * @ORM\Column(type="integer",nullable=false)
     */
    protected $tipo;

   public function __toString() {
       return $this->nombre;
   }

   /**
     * Constructor
     */
    public function __construct()
    {
        $this->solicitud = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Auditoria
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
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
     * Set fecha_inicio
     *
     * @param \DateTime $fechaInicio
     * @return Auditoria
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fecha_inicio = $fechaInicio;
    
        return $this;
    }

    /**
     * Get fecha_inicio
     *
     * @return \DateTime 
     */
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    /**
     * Set fecha_final
     *
     * @param \DateTime $fechaFinal
     * @return Auditoria
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fecha_final = $fechaFinal;
    
        return $this;
    }

    /**
     * Get fecha_final
     *
     * @return \DateTime 
     */
    public function getFechaFinal()
    {
        return $this->fecha_final;
    }

    /**
     * Set sede
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $sede
     * @return Auditoria
     */
    public function setSede(\Netpublic\CoreBundle\Entity\Colegio $sede = null)
    {
        $this->sede = $sede;
    
        return $this;
    }

    /**
     * Get sede
     *
     * @return \Netpublic\CoreBundle\Entity\Colegio 
     */
    public function getSede()
    {
        return $this->sede;
    }

    /**
     * Add solicitud
     *
     * @param \Netpublic\CoreBundle\Entity\ProfesorSolicitud $solicitud
     * @return Auditoria
     */
    public function addSolicitud(\Netpublic\CoreBundle\Entity\ProfesorSolicitud $solicitud)
    {
        $this->solicitud[] = $solicitud;
    
        return $this;
    }

    /**
     * Remove solicitud
     *
     * @param \Netpublic\CoreBundle\Entity\ProfesorSolicitud $solicitud
     */
    public function removeSolicitud(\Netpublic\CoreBundle\Entity\ProfesorSolicitud $solicitud)
    {
        $this->solicitud->removeElement($solicitud);
    }

    /**
     * Get solicitud
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSolicitud()
    {
        return $this->solicitud;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     * @return Auditoria
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    
        return $this;
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
}
