<?php

/*
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
 * @ORM\Table(name="profesor_solicitud")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\ProfesorsolicitudRepository")
 */
class ProfesorSolicitud
{
    /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
     /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $fecha_solicitud;
     /**
     *
     * @ORM\ManyToOne(targetEntity="Grupo",inversedBy="solicitud")
     */
    protected $grupo;
     /**
     *
     * @ORM\ManyToOne(targetEntity="Profesor",inversedBy="solicitud")
     */
    protected $profesor;
     /**
     *
     * @ORM\ManyToOne(targetEntity="Alumno",inversedBy="solicitud")
     */
    protected $alumno;
     /**
     *
     * @ORM\ManyToOne(targetEntity="Auditoria",inversedBy="solicitud")
     */
    protected $auditoria;
    /**
     * 0: Adicion
     * 1: cambiar de grupo
     * 2: Retirar
     * @ORM\Column(type="integer")
     */
    protected $tipo;
    /**
     * 0: No se ha realizado la solicitud
     * 1: Se ha realizado la solicitud
     * @ORM\Column(type="integer")
     */
    protected $es_realizada;


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
     * Set fecha_solicitud
     *
     * @param \DateTime $fechaSolicitud
     * @return ProfesorSolicitud
     */
    public function setFechaSolicitud($fechaSolicitud)
    {
        $this->fecha_solicitud = $fechaSolicitud;
    
        return $this;
    }

    /**
     * Get fecha_solicitud
     *
     * @return \DateTime 
     */
    public function getFechaSolicitud()
    {
        return $this->fecha_solicitud;
    }

    /**
     * Set grupo
     *
     * @param \Netpublic\CoreBundle\Entity\Grupo $grupo
     * @return ProfesorSolicitud
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

    /**
     * Set profesor
     *
     * @param \Netpublic\CoreBundle\Entity\Profesor $profesor
     * @return ProfesorSolicitud
     */
    public function setProfesor(\Netpublic\CoreBundle\Entity\Profesor $profesor = null)
    {
        $this->profesor = $profesor;
    
        return $this;
    }

    /**
     * Get profesor
     *
     * @return \Netpublic\CoreBundle\Entity\Profesor 
     */
    public function getProfesor()
    {
        return $this->profesor;
    }

    /**
     * Set alumno
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $alumno
     * @return ProfesorSolicitud
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
     * Set auditoria
     *
     * @param \Netpublic\CoreBundle\Entity\Auditoria $auditoria
     * @return ProfesorSolicitud
     */
    public function setAuditoria(\Netpublic\CoreBundle\Entity\Auditoria $auditoria = null)
    {
        $this->auditoria = $auditoria;
    
        return $this;
    }

    /**
     * Get auditoria
     *
     * @return \Netpublic\CoreBundle\Entity\Auditoria 
     */
    public function getAuditoria()
    {
        return $this->auditoria;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     * @return ProfesorSolicitud
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

    /**
     * Set es_realizada
     *
     * @param integer $esRealizada
     * @return ProfesorSolicitud
     */
    public function setEsRealizada($esRealizada)
    {
        $this->es_realizada = $esRealizada;
    
        return $this;
    }

    /**
     * Get es_realizada
     *
     * @return integer 
     */
    public function getEsRealizada()
    {
        return $this->es_realizada;
    }
}
