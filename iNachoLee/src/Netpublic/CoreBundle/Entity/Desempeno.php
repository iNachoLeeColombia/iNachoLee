<?php
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Desempeno
 *
 * @author yuri
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="desempeno")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\DesempenoRepository")
 */


class Desempeno {
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $descripcion_inf;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $observacion_perdida;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $observacion_sobresaliente;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $descripcion_deficiente;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $descripcion_insuficiente;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $descripcion_aceptable;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $descripcion_sobresaliente;
    
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $descripcion_excelente;
    /**
     *
     * @ORM\ManyToOne(targetEntity="AspectoEvaluar",inversedBy="desempeno")
     */
    protected $aspecto_evaluar;
     /**
     *
     * @ORM\ManyToMany(targetEntity="Grupo",inversedBy="desempeno")
     */
    protected $grupo;
    /**
     *
     * @ORM\ManyToOne(targetEntity="Profesor",inversedBy="desempeno")
     */
    protected $profesor;
    /**
     *
     * @ORM\ManyToOne(targetEntity="CargaAcademica",inversedBy="desempeno")
     */
    protected $asignatura;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Dimension",inversedBy="desempeno_periodo")
     */
    protected $periodo;
     /**
     *
     * @ORM\OneToMany(targetEntity="ActividadDesempeno",mappedBy="desempeno")
     */
    protected $porcentaje;
    /**
     *
     * @ORM\OneToMany(targetEntity="AlumnoDesempeno",mappedBy="desempeno")
     */
    protected $nota_desempeno;
    /**
     *
     * @ORM\ManyToMany(targetEntity="Dimension",inversedBy="desempeno")
     */
    protected $actividades_disponibles;
    public function __toString() {
        return $this->descripcion_inf.$this->periodo;
    }


       /**
     * Constructor
     */
    public function __construct()
    {
        $this->grupo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->porcentaje = new \Doctrine\Common\Collections\ArrayCollection();
        $this->nota_desempeno = new \Doctrine\Common\Collections\ArrayCollection();
        $this->actividades_disponibles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set descripcion_inf
     *
     * @param string $descripcionInf
     * @return Desempeno
     */
    public function setDescripcionInf($descripcionInf)
    {
        $this->descripcion_inf = $descripcionInf;

        return $this;
    }

    /**
     * Get descripcion_inf
     *
     * @return string 
     */
    public function getDescripcionInf()
    {
        return $this->descripcion_inf;
    }

    /**
     * Set observacion_perdida
     *
     * @param string $observacionPerdida
     * @return Desempeno
     */
    public function setObservacionPerdida($observacionPerdida)
    {
        $this->observacion_perdida = $observacionPerdida;

        return $this;
    }

    /**
     * Get observacion_perdida
     *
     * @return string 
     */
    public function getObservacionPerdida()
    {
        return $this->observacion_perdida;
    }

    /**
     * Set observacion_sobresaliente
     *
     * @param string $observacionSobresaliente
     * @return Desempeno
     */
    public function setObservacionSobresaliente($observacionSobresaliente)
    {
        $this->observacion_sobresaliente = $observacionSobresaliente;

        return $this;
    }

    /**
     * Get observacion_sobresaliente
     *
     * @return string 
     */
    public function getObservacionSobresaliente()
    {
        return $this->observacion_sobresaliente;
    }

    /**
     * Set descripcion_deficiente
     *
     * @param string $descripcionDeficiente
     * @return Desempeno
     */
    public function setDescripcionDeficiente($descripcionDeficiente)
    {
        $this->descripcion_deficiente = $descripcionDeficiente;

        return $this;
    }

    /**
     * Get descripcion_deficiente
     *
     * @return string 
     */
    public function getDescripcionDeficiente()
    {
        return $this->descripcion_deficiente;
    }

    /**
     * Set descripcion_insuficiente
     *
     * @param string $descripcionInsuficiente
     * @return Desempeno
     */
    public function setDescripcionInsuficiente($descripcionInsuficiente)
    {
        $this->descripcion_insuficiente = $descripcionInsuficiente;

        return $this;
    }

    /**
     * Get descripcion_insuficiente
     *
     * @return string 
     */
    public function getDescripcionInsuficiente()
    {
        return $this->descripcion_insuficiente;
    }

    /**
     * Set descripcion_aceptable
     *
     * @param string $descripcionAceptable
     * @return Desempeno
     */
    public function setDescripcionAceptable($descripcionAceptable)
    {
        $this->descripcion_aceptable = $descripcionAceptable;

        return $this;
    }

    /**
     * Get descripcion_aceptable
     *
     * @return string 
     */
    public function getDescripcionAceptable()
    {
        return $this->descripcion_aceptable;
    }

    /**
     * Set descripcion_sobresaliente
     *
     * @param string $descripcionSobresaliente
     * @return Desempeno
     */
    public function setDescripcionSobresaliente($descripcionSobresaliente)
    {
        $this->descripcion_sobresaliente = $descripcionSobresaliente;

        return $this;
    }

    /**
     * Get descripcion_sobresaliente
     *
     * @return string 
     */
    public function getDescripcionSobresaliente()
    {
        return $this->descripcion_sobresaliente;
    }

    /**
     * Set descripcion_excelente
     *
     * @param string $descripcionExcelente
     * @return Desempeno
     */
    public function setDescripcionExcelente($descripcionExcelente)
    {
        $this->descripcion_excelente = $descripcionExcelente;

        return $this;
    }

    /**
     * Get descripcion_excelente
     *
     * @return string 
     */
    public function getDescripcionExcelente()
    {
        return $this->descripcion_excelente;
    }

    /**
     * Set aspecto_evaluar
     *
     * @param \Netpublic\CoreBundle\Entity\AspectoEvaluar $aspectoEvaluar
     * @return Desempeno
     */
    public function setAspectoEvaluar(\Netpublic\CoreBundle\Entity\AspectoEvaluar $aspectoEvaluar = null)
    {
        $this->aspecto_evaluar = $aspectoEvaluar;

        return $this;
    }

    /**
     * Get aspecto_evaluar
     *
     * @return \Netpublic\CoreBundle\Entity\AspectoEvaluar 
     */
    public function getAspectoEvaluar()
    {
        return $this->aspecto_evaluar;
    }

    /**
     * Add grupo
     *
     * @param \Netpublic\CoreBundle\Entity\Grupo $grupo
     * @return Desempeno
     */
    public function addGrupo(\Netpublic\CoreBundle\Entity\Grupo $grupo)
    {
        $this->grupo[] = $grupo;

        return $this;
    }

    /**
     * Remove grupo
     *
     * @param \Netpublic\CoreBundle\Entity\Grupo $grupo
     */
    public function removeGrupo(\Netpublic\CoreBundle\Entity\Grupo $grupo)
    {
        $this->grupo->removeElement($grupo);
    }

    /**
     * Get grupo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Set profesor
     *
     * @param \Netpublic\CoreBundle\Entity\Profesor $profesor
     * @return Desempeno
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
     * Set asignatura
     *
     * @param \Netpublic\CoreBundle\Entity\CargaAcademica $asignatura
     * @return Desempeno
     */
    public function setAsignatura(\Netpublic\CoreBundle\Entity\CargaAcademica $asignatura = null)
    {
        $this->asignatura = $asignatura;

        return $this;
    }

    /**
     * Get asignatura
     *
     * @return \Netpublic\CoreBundle\Entity\CargaAcademica 
     */
    public function getAsignatura()
    {
        return $this->asignatura;
    }

    /**
     * Set periodo
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $periodo
     * @return Desempeno
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

    /**
     * Add porcentaje
     *
     * @param \Netpublic\CoreBundle\Entity\ActividadDesempeno $porcentaje
     * @return Desempeno
     */
    public function addPorcentaje(\Netpublic\CoreBundle\Entity\ActividadDesempeno $porcentaje)
    {
        $this->porcentaje[] = $porcentaje;

        return $this;
    }

    /**
     * Remove porcentaje
     *
     * @param \Netpublic\CoreBundle\Entity\ActividadDesempeno $porcentaje
     */
    public function removePorcentaje(\Netpublic\CoreBundle\Entity\ActividadDesempeno $porcentaje)
    {
        $this->porcentaje->removeElement($porcentaje);
    }

    /**
     * Get porcentaje
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPorcentaje()
    {
        return $this->porcentaje;
    }

    /**
     * Add nota_desempeno
     *
     * @param \Netpublic\CoreBundle\Entity\AlumnoDesempeno $notaDesempeno
     * @return Desempeno
     */
    public function addNotaDesempeno(\Netpublic\CoreBundle\Entity\AlumnoDesempeno $notaDesempeno)
    {
        $this->nota_desempeno[] = $notaDesempeno;

        return $this;
    }

    /**
     * Remove nota_desempeno
     *
     * @param \Netpublic\CoreBundle\Entity\AlumnoDesempeno $notaDesempeno
     */
    public function removeNotaDesempeno(\Netpublic\CoreBundle\Entity\AlumnoDesempeno $notaDesempeno)
    {
        $this->nota_desempeno->removeElement($notaDesempeno);
    }

    /**
     * Get nota_desempeno
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNotaDesempeno()
    {
        return $this->nota_desempeno;
    }

    /**
     * Add actividades_disponibles
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $actividadesDisponibles
     * @return Desempeno
     */
    public function addActividadesDisponible(\Netpublic\CoreBundle\Entity\Dimension $actividadesDisponibles)
    {
        $this->actividades_disponibles[] = $actividadesDisponibles;

        return $this;
    }

    /**
     * Remove actividades_disponibles
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $actividadesDisponibles
     */
    public function removeActividadesDisponible(\Netpublic\CoreBundle\Entity\Dimension $actividadesDisponibles)
    {
        $this->actividades_disponibles->removeElement($actividadesDisponibles);
    }

    /**
     * Get actividades_disponibles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActividadesDisponibles()
    {
        return $this->actividades_disponibles;
    }
}
