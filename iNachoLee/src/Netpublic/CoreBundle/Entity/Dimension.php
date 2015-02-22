<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dimension
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="dimension")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\DimensionRepository")
 */

class Dimension {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;
    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $nombre;
    
    /**
     *
     * @ORM\OneToMany(targetEntity="AlumnoDimension",mappedBy="dimension")
     */
    protected $nota;
    /**
     *
     * @ORM\OneToMany(targetEntity="AlumnoDesempeno",mappedBy="dimension")
     */
    protected $nota_desempeno;
   
    /**
     *
     * @ORM\ManyToOne(targetEntity="Grupo",inversedBy="dimensiones")
     */
    protected $grupo;

    /**
     * Get id
     *
     * @return integer 
     */
    /**
    * @ORM\ManyToOne(targetEntity="Asignatura",inversedBy="dimension")    
    */    
    protected $asignatura;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Dimension",inversedBy="padres")
     */
    protected $padre;
    
    /**
     *
     * @ORM\OneToMany(targetEntity="Dimension",mappedBy="padre")
     */
    
    protected $padres;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Profesor",inversedBy="dimension")
     */
    protected $profesor;
    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $es_item_principal;
    
    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $es_ano_escolar;
    /**
     * @ORM\Column(type="float",nullable=true)
     */
    protected $limte_inferior_nota;
    /**
     * @ORM\Column(type="float",nullable=true)
     */
    protected $limte_superior_nota;
    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $es_carita_feliz;
   
    /**
     *
     * @ORM\OneToMany(targetEntity="Desempeno",mappedBy="periodo")
     */
    
    protected $desempeno_periodo;
     /**
     *
     * @ORM\OneToMany(targetEntity="ActividadDesempeno",mappedBy="actividad")
     */
    
    protected $porcentajea;

    /**
     * 0 ---->Año escolar
     * 1 ---->Periodo
     * 2 ---->Area
     * 3 ---->Asistencia
     * 4 ---->Actividad
     * 5 ----> Promedio De Periodos
     * 6 ----> Creadas por defecto
     * 7 ----> Padre de components
     * 8 ----> Padre de 7
     */
     /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $tipo;
  
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $porcentaje;
    /**
     *
     * @ORM\ManyToMany(targetEntity="Desempeno",mappedBy="actividades_disponibles")
     */
    protected $desempeno; 
    /**
     * @ORM\OneToMany(targetEntity="MatriculaAlumno",mappedBy="ano")     
     */
    protected $matricula_alumno;    
    /**
     * @ORM\Column(type="boolean",nullable=true)
     * 
     */
    protected $es_ano_activo;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $ponderado;
     /**
     *
     * @ORM\OneToMany(targetEntity="Profesorperiodoentrega",mappedBy="periodo")
     */
    protected $profesor_periodo_entrega;
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
     * @ORM\ManyToOne(targetEntity="Dimension",inversedBy="periodoacademico")
     */        
    protected $periodoacademico;
    /**
     *
     *@ORM\Column(type="integer",nullable=true)
     */
    protected $nivel;
     /**
     *
     * @ORM\OneToMany(targetEntity="PublicacionPeriodosProfesores",mappedBy="periodo_academico")
     */
    protected $publicida_periodos_profesores;
    
    protected $ano_escolar;
    /**
    * @ORM\OneToMany(targetEntity="Anoescolargrado",mappedBy="ano_escolar")  
    *     
    */    
    protected $ano_cursado;
     /**
     *
     * @ORM\OneToMany(targetEntity="Colegio",mappedBy="ano_siguiente")
     */
    
    protected $v1;
    /**
     *
     * @ORM\OneToMany(targetEntity="Colegio",mappedBy="ano_anterior")
     */
    
    protected $v2;
   
     /**
     * @ORM\OneToMany(targetEntity="NivelAcademico",mappedBy="periodo_actual")     
     */
    protected $nivel_academico;    
   /**
     * @ORM\OneToMany(targetEntity="Observacion",mappedBy="periodo")     
     */
    protected $observaciones;    
     /**
     *
     * @ORM\OneToMany(targetEntity="CargaAcademica",mappedBy="ano_escolar")
     */
    protected $carga_academica;
   /**
     * @ORM\OneToMany(targetEntity="Netpublic\RedsaberBundle\Entity\TemasEvaluados",mappedBy="ano_escolar")  
     * 
    */    
    protected $temas_evaluado;
    /**
     *
     *@ORM\Column(type="integer",nullable=true)
     */
    protected $posicion;
    /**
     *
     *@ORM\Column(type="integer",nullable=true)
     */
    protected $bposicion;
     /**
     *
     * @ORM\OneToMany(targetEntity="CargaAcademica",mappedBy="padre_evaluacion")
     */
    protected $ca_evaluacion;
    /**
     *
     *@ORM\Column(type="integer",nullable=true)
     */
    protected $orden;
    /**
     *
     * @ORM\ManyToOne(targetEntity="Dimension",inversedBy="padresgc")
     */
    protected $padregc;
    
    /**
     *
     * @ORM\OneToMany(targetEntity="Dimension",mappedBy="padregc")
     */
    
    protected $padresgc;
    /**
     *
     *@ORM\Column(type="integer",nullable=true)
     * 7 
     * 8
     * 9
     */
    protected $tipogc;
    
    public function __toString(){
        return $this->nombre;
        
    }
    
 
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->nota = new \Doctrine\Common\Collections\ArrayCollection();
        $this->nota_desempeno = new \Doctrine\Common\Collections\ArrayCollection();
        $this->padres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->padresgc = new \Doctrine\Common\Collections\ArrayCollection();
        $this->desempeno_periodo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->porcentajea = new \Doctrine\Common\Collections\ArrayCollection();
        $this->desempeno = new \Doctrine\Common\Collections\ArrayCollection();
        $this->matricula_alumno = new \Doctrine\Common\Collections\ArrayCollection();
        $this->profesor_periodo_entrega = new \Doctrine\Common\Collections\ArrayCollection();
        $this->publicida_periodos_profesores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ano_cursado = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v2 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->nivel_academico = new \Doctrine\Common\Collections\ArrayCollection();
        $this->observaciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->carga_academica = new \Doctrine\Common\Collections\ArrayCollection();
        $this->temas_evaluado = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ca_evaluacion = new \Doctrine\Common\Collections\ArrayCollection();
        
        if($this->tipo==3){
            $this->orden=0;
        }
        if($this->tipo==1){
            $this->orden=-1;
        }
        
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
     * @return Dimension
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
     * Set es_item_principal
     *
     * @param boolean $esItemPrincipal
     * @return Dimension
     */
    public function setEsItemPrincipal($esItemPrincipal)
    {
        $this->es_item_principal = $esItemPrincipal;

        return $this;
    }

    /**
     * Get es_item_principal
     *
     * @return boolean 
     */
    public function getEsItemPrincipal()
    {
        return $this->es_item_principal;
    }

    /**
     * Set es_ano_escolar
     *
     * @param boolean $esAnoEscolar
     * @return Dimension
     */
    public function setEsAnoEscolar($esAnoEscolar)
    {
        $this->es_ano_escolar = $esAnoEscolar;

        return $this;
    }

    /**
     * Get es_ano_escolar
     *
     * @return boolean 
     */
    public function getEsAnoEscolar()
    {
        return $this->es_ano_escolar;
    }

    /**
     * Set limte_inferior_nota
     *
     * @param float $limteInferiorNota
     * @return Dimension
     */
    public function setLimteInferiorNota($limteInferiorNota)
    {
        $this->limte_inferior_nota = $limteInferiorNota;

        return $this;
    }

    /**
     * Get limte_inferior_nota
     *
     * @return float 
     */
    public function getLimteInferiorNota()
    {
        return $this->limte_inferior_nota;
    }

    /**
     * Set limte_superior_nota
     *
     * @param float $limteSuperiorNota
     * @return Dimension
     */
    public function setLimteSuperiorNota($limteSuperiorNota)
    {
        $this->limte_superior_nota = $limteSuperiorNota;

        return $this;
    }

    /**
     * Get limte_superior_nota
     *
     * @return float 
     */
    public function getLimteSuperiorNota()
    {
        return $this->limte_superior_nota;
    }

    /**
     * Set es_carita_feliz
     *
     * @param boolean $esCaritaFeliz
     * @return Dimension
     */
    public function setEsCaritaFeliz($esCaritaFeliz)
    {
        $this->es_carita_feliz = $esCaritaFeliz;

        return $this;
    }

    /**
     * Get es_carita_feliz
     *
     * @return boolean 
     */
    public function getEsCaritaFeliz()
    {
        return $this->es_carita_feliz;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     * @return Dimension
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
     * Set porcentaje
     *
     * @param integer $porcentaje
     * @return Dimension
     */
    public function setPorcentaje($porcentaje)
    {
        $this->porcentaje = $porcentaje;

        return $this;
    }

    /**
     * Get porcentaje
     *
     * @return integer 
     */
    public function getPorcentaje()
    {
        return $this->porcentaje;
    }

    /**
     * Set es_ano_activo
     *
     * @param boolean $esAnoActivo
     * @return Dimension
     */
    public function setEsAnoActivo($esAnoActivo)
    {
        $this->es_ano_activo = $esAnoActivo;

        return $this;
    }

    /**
     * Get es_ano_activo
     *
     * @return boolean 
     */
    public function getEsAnoActivo()
    {
        return $this->es_ano_activo;
    }

    /**
     * Set ponderado
     *
     * @param integer $ponderado
     * @return Dimension
     */
    public function setPonderado($ponderado)
    {
        $this->ponderado = $ponderado;

        return $this;
    }

    /**
     * Get ponderado
     *
     * @return integer 
     */
    public function getPonderado()
    {
        return $this->ponderado;
    }

    /**
     * Set fecha_inicio
     *
     * @param \DateTime $fechaInicio
     * @return Dimension
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
     * @return Dimension
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
     * Set nivel
     *
     * @param integer $nivel
     * @return Dimension
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;

        return $this;
    }

    /**
     * Get nivel
     *
     * @return integer 
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * Add nota
     *
     * @param \Netpublic\CoreBundle\Entity\AlumnoDimension $nota
     * @return Dimension
     */
    public function addNotum(\Netpublic\CoreBundle\Entity\AlumnoDimension $nota)
    {
        $this->nota[] = $nota;

        return $this;
    }

    /**
     * Remove nota
     *
     * @param \Netpublic\CoreBundle\Entity\AlumnoDimension $nota
     */
    public function removeNotum(\Netpublic\CoreBundle\Entity\AlumnoDimension $nota)
    {
        $this->nota->removeElement($nota);
    }

    /**
     * Get nota
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNota()
    {
        return $this->nota;
    }

    /**
     * Add nota_desempeno
     *
     * @param \Netpublic\CoreBundle\Entity\AlumnoDesempeno $notaDesempeno
     * @return Dimension
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
     * Set grupo
     *
     * @param \Netpublic\CoreBundle\Entity\Grupo $grupo
     * @return Dimension
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
     * Set asignatura
     *
     * @param \Netpublic\CoreBundle\Entity\Asignatura $asignatura
     * @return Dimension
     */
    public function setAsignatura(\Netpublic\CoreBundle\Entity\Asignatura $asignatura = null)
    {
        $this->asignatura = $asignatura;

        return $this;
    }

    /**
     * Get asignatura
     *
     * @return \Netpublic\CoreBundle\Entity\Asignatura 
     */
    public function getAsignatura()
    {
        return $this->asignatura;
    }

    /**
     * Set padre
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $padre
     * @return Dimension
     */
    public function setPadre(\Netpublic\CoreBundle\Entity\Dimension $padre = null)
    {
        $this->padre = $padre;

        return $this;
    }

    /**
     * Get padre
     *
     * @return \Netpublic\CoreBundle\Entity\Dimension 
     */
    public function getPadre()
    {
        return $this->padre;
    }

    /**
     * Add padres
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $padres
     * @return Dimension
     */
    public function addPadre(\Netpublic\CoreBundle\Entity\Dimension $padres)
    {
        $this->padres[] = $padres;

        return $this;
    }

    /**
     * Remove padres
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $padres
     */
    public function removePadre(\Netpublic\CoreBundle\Entity\Dimension $padres)
    {
        $this->padres->removeElement($padres);
    }

    /**
     * Get padres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPadres()
    {
        return $this->padres;
    }

    /**
     * Set profesor
     *
     * @param \Netpublic\CoreBundle\Entity\Profesor $profesor
     * @return Dimension
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
     * Add desempeno_periodo
     *
     * @param \Netpublic\CoreBundle\Entity\Desempeno $desempenoPeriodo
     * @return Dimension
     */
    public function addDesempenoPeriodo(\Netpublic\CoreBundle\Entity\Desempeno $desempenoPeriodo)
    {
        $this->desempeno_periodo[] = $desempenoPeriodo;

        return $this;
    }

    /**
     * Remove desempeno_periodo
     *
     * @param \Netpublic\CoreBundle\Entity\Desempeno $desempenoPeriodo
     */
    public function removeDesempenoPeriodo(\Netpublic\CoreBundle\Entity\Desempeno $desempenoPeriodo)
    {
        $this->desempeno_periodo->removeElement($desempenoPeriodo);
    }

    /**
     * Get desempeno_periodo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDesempenoPeriodo()
    {
        return $this->desempeno_periodo;
    }

    /**
     * Add porcentajea
     *
     * @param \Netpublic\CoreBundle\Entity\ActividadDesempeno $porcentajea
     * @return Dimension
     */
    public function addPorcentajea(\Netpublic\CoreBundle\Entity\ActividadDesempeno $porcentajea)
    {
        $this->porcentajea[] = $porcentajea;

        return $this;
    }

    /**
     * Remove porcentajea
     *
     * @param \Netpublic\CoreBundle\Entity\ActividadDesempeno $porcentajea
     */
    public function removePorcentajea(\Netpublic\CoreBundle\Entity\ActividadDesempeno $porcentajea)
    {
        $this->porcentajea->removeElement($porcentajea);
    }

    /**
     * Get porcentajea
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPorcentajea()
    {
        return $this->porcentajea;
    }

    /**
     * Add desempeno
     *
     * @param \Netpublic\CoreBundle\Entity\Desempeno $desempeno
     * @return Dimension
     */
    public function addDesempeno(\Netpublic\CoreBundle\Entity\Desempeno $desempeno)
    {
        $this->desempeno[] = $desempeno;

        return $this;
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

    /**
     * Get desempeno
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDesempeno()
    {
        return $this->desempeno;
    }

    /**
     * Add matricula_alumno
     *
     * @param \Netpublic\CoreBundle\Entity\MatriculaAlumno $matriculaAlumno
     * @return Dimension
     */
    public function addMatriculaAlumno(\Netpublic\CoreBundle\Entity\MatriculaAlumno $matriculaAlumno)
    {
        $this->matricula_alumno[] = $matriculaAlumno;

        return $this;
    }

    /**
     * Remove matricula_alumno
     *
     * @param \Netpublic\CoreBundle\Entity\MatriculaAlumno $matriculaAlumno
     */
    public function removeMatriculaAlumno(\Netpublic\CoreBundle\Entity\MatriculaAlumno $matriculaAlumno)
    {
        $this->matricula_alumno->removeElement($matriculaAlumno);
    }

    /**
     * Get matricula_alumno
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMatriculaAlumno()
    {
        return $this->matricula_alumno;
    }

    /**
     * Add profesor_periodo_entrega
     *
     * @param \Netpublic\CoreBundle\Entity\Profesorperiodoentrega $profesorPeriodoEntrega
     * @return Dimension
     */
    public function addProfesorPeriodoEntrega(\Netpublic\CoreBundle\Entity\Profesorperiodoentrega $profesorPeriodoEntrega)
    {
        $this->profesor_periodo_entrega[] = $profesorPeriodoEntrega;

        return $this;
    }

    /**
     * Remove profesor_periodo_entrega
     *
     * @param \Netpublic\CoreBundle\Entity\Profesorperiodoentrega $profesorPeriodoEntrega
     */
    public function removeProfesorPeriodoEntrega(\Netpublic\CoreBundle\Entity\Profesorperiodoentrega $profesorPeriodoEntrega)
    {
        $this->profesor_periodo_entrega->removeElement($profesorPeriodoEntrega);
    }

    /**
     * Get profesor_periodo_entrega
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProfesorPeriodoEntrega()
    {
        return $this->profesor_periodo_entrega;
    }

    /**
     * Set periodoacademico
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $periodoacademico
     * @return Dimension
     */
    public function setPeriodoacademico(\Netpublic\CoreBundle\Entity\Dimension $periodoacademico = null)
    {
        $this->periodoacademico = $periodoacademico;

        return $this;
    }

    /**
     * Get periodoacademico
     *
     * @return \Netpublic\CoreBundle\Entity\Dimension 
     */
    public function getPeriodoacademico()
    {
        return $this->periodoacademico;
    }

    /**
     * Add publicida_periodos_profesores
     *
     * @param \Netpublic\CoreBundle\Entity\PublicacionPeriodosProfesores $publicidaPeriodosProfesores
     * @return Dimension
     */
    public function addPublicidaPeriodosProfesore(\Netpublic\CoreBundle\Entity\PublicacionPeriodosProfesores $publicidaPeriodosProfesores)
    {
        $this->publicida_periodos_profesores[] = $publicidaPeriodosProfesores;

        return $this;
    }

    /**
     * Remove publicida_periodos_profesores
     *
     * @param \Netpublic\CoreBundle\Entity\PublicacionPeriodosProfesores $publicidaPeriodosProfesores
     */
    public function removePublicidaPeriodosProfesore(\Netpublic\CoreBundle\Entity\PublicacionPeriodosProfesores $publicidaPeriodosProfesores)
    {
        $this->publicida_periodos_profesores->removeElement($publicidaPeriodosProfesores);
    }

    /**
     * Get publicida_periodos_profesores
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPublicidaPeriodosProfesores()
    {
        return $this->publicida_periodos_profesores;
    }

    /**
     * Add ano_cursado
     *
     * @param \Netpublic\CoreBundle\Entity\Anoescolargrado $anoCursado
     * @return Dimension
     */
    public function addAnoCursado(\Netpublic\CoreBundle\Entity\Anoescolargrado $anoCursado)
    {
        $this->ano_cursado[] = $anoCursado;

        return $this;
    }

    /**
     * Remove ano_cursado
     *
     * @param \Netpublic\CoreBundle\Entity\Anoescolargrado $anoCursado
     */
    public function removeAnoCursado(\Netpublic\CoreBundle\Entity\Anoescolargrado $anoCursado)
    {
        $this->ano_cursado->removeElement($anoCursado);
    }

    /**
     * Get ano_cursado
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAnoCursado()
    {
        return $this->ano_cursado;
    }

    /**
     * Add v1
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $v1
     * @return Dimension
     */
    public function addV1(\Netpublic\CoreBundle\Entity\Colegio $v1)
    {
        $this->v1[] = $v1;

        return $this;
    }

    /**
     * Remove v1
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $v1
     */
    public function removeV1(\Netpublic\CoreBundle\Entity\Colegio $v1)
    {
        $this->v1->removeElement($v1);
    }

    /**
     * Get v1
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getV1()
    {
        return $this->v1;
    }

    /**
     * Add v2
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $v2
     * @return Dimension
     */
    public function addV2(\Netpublic\CoreBundle\Entity\Colegio $v2)
    {
        $this->v2[] = $v2;

        return $this;
    }

    /**
     * Remove v2
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $v2
     */
    public function removeV2(\Netpublic\CoreBundle\Entity\Colegio $v2)
    {
        $this->v2->removeElement($v2);
    }

    /**
     * Get v2
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getV2()
    {
        return $this->v2;
    }

    /**
     * Add nivel_academico
     *
     * @param \Netpublic\CoreBundle\Entity\NivelAcademico $nivelAcademico
     * @return Dimension
     */
    public function addNivelAcademico(\Netpublic\CoreBundle\Entity\NivelAcademico $nivelAcademico)
    {
        $this->nivel_academico[] = $nivelAcademico;

        return $this;
    }

    /**
     * Remove nivel_academico
     *
     * @param \Netpublic\CoreBundle\Entity\NivelAcademico $nivelAcademico
     */
    public function removeNivelAcademico(\Netpublic\CoreBundle\Entity\NivelAcademico $nivelAcademico)
    {
        $this->nivel_academico->removeElement($nivelAcademico);
    }

    /**
     * Get nivel_academico
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNivelAcademico()
    {
        return $this->nivel_academico;
    }

    /**
     * Add observaciones
     *
     * @param \Netpublic\CoreBundle\Entity\Observacion $observaciones
     * @return Dimension
     */
    public function addObservacione(\Netpublic\CoreBundle\Entity\Observacion $observaciones)
    {
        $this->observaciones[] = $observaciones;

        return $this;
    }

    /**
     * Remove observaciones
     *
     * @param \Netpublic\CoreBundle\Entity\Observacion $observaciones
     */
    public function removeObservacione(\Netpublic\CoreBundle\Entity\Observacion $observaciones)
    {
        $this->observaciones->removeElement($observaciones);
    }

    /**
     * Get observaciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Add carga_academica
     *
     * @param \Netpublic\CoreBundle\Entity\CargaAcademica $cargaAcademica
     * @return Dimension
     */
    public function addCargaAcademica(\Netpublic\CoreBundle\Entity\CargaAcademica $cargaAcademica)
    {
        $this->carga_academica[] = $cargaAcademica;

        return $this;
    }

    /**
     * Remove carga_academica
     *
     * @param \Netpublic\CoreBundle\Entity\CargaAcademica $cargaAcademica
     */
    public function removeCargaAcademica(\Netpublic\CoreBundle\Entity\CargaAcademica $cargaAcademica)
    {
        $this->carga_academica->removeElement($cargaAcademica);
    }

    /**
     * Get carga_academica
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCargaAcademica()
    {
        return $this->carga_academica;
    }

    /**
     * Add temas_evaluado
     *
     * @param \Netpublic\RedsaberBundle\Entity\TemasEvaluados $temasEvaluado
     * @return Dimension
     */
    public function addTemasEvaluado(\Netpublic\RedsaberBundle\Entity\TemasEvaluados $temasEvaluado)
    {
        $this->temas_evaluado[] = $temasEvaluado;

        return $this;
    }

    /**
     * Remove temas_evaluado
     *
     * @param \Netpublic\RedsaberBundle\Entity\TemasEvaluados $temasEvaluado
     */
    public function removeTemasEvaluado(\Netpublic\RedsaberBundle\Entity\TemasEvaluados $temasEvaluado)
    {
        $this->temas_evaluado->removeElement($temasEvaluado);
    }

    /**
     * Get temas_evaluado
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTemasEvaluado()
    {
        return $this->temas_evaluado;
    }

    /**
     * Set posicion
     *
     * @param integer $posicion
     * @return Dimension
     */
    public function setPosicion($posicion)
    {
        $this->posicion = $posicion;

        return $this;
    }

    /**
     * Get posicion
     *
     * @return integer 
     */
    public function getPosicion()
    {
        return $this->posicion;
    }

    /**
     * Add ca_evaluacion
     *
     * @param \Netpublic\CoreBundle\Entity\CargaAcademica $caEvaluacion
     * @return Dimension
     */
    public function addCaEvaluacion(\Netpublic\CoreBundle\Entity\CargaAcademica $caEvaluacion)
    {
        $this->ca_evaluacion[] = $caEvaluacion;

        return $this;
    }

    /**
     * Remove ca_evaluacion
     *
     * @param \Netpublic\CoreBundle\Entity\CargaAcademica $caEvaluacion
     */
    public function removeCaEvaluacion(\Netpublic\CoreBundle\Entity\CargaAcademica $caEvaluacion)
    {
        $this->ca_evaluacion->removeElement($caEvaluacion);
    }

    /**
     * Get ca_evaluacion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCaEvaluacion()
    {
        return $this->ca_evaluacion;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     * @return Dimension
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer 
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set bposicion
     *
     * @param integer $bposicion
     * @return Dimension
     */
    public function setBposicion($bposicion)
    {
        $this->bposicion = $bposicion;

        return $this;
    }

    /**
     * Get bposicion
     *
     * @return integer 
     */
    public function getBposicion()
    {
        return $this->bposicion;
    }

    /**
     * Set tipogc
     *
     * @param integer $tipogc
     * @return Dimension
     */
    public function setTipogc($tipogc)
    {
        $this->tipogc = $tipogc;

        return $this;
    }

    /**
     * Get tipogc
     *
     * @return integer 
     */
    public function getTipogc()
    {
        return $this->tipogc;
    }

    /**
     * Set padregc
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $padregc
     * @return Dimension
     */
    public function setPadregc(\Netpublic\CoreBundle\Entity\Dimension $padregc = null)
    {
        $this->padregc = $padregc;

        return $this;
    }

    /**
     * Get padregc
     *
     * @return \Netpublic\CoreBundle\Entity\Dimension 
     */
    public function getPadregc()
    {
        return $this->padregc;
    }

    /**
     * Add padresgc
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $padresgc
     * @return Dimension
     */
    public function addPadresgc(\Netpublic\CoreBundle\Entity\Dimension $padresgc)
    {
        $this->padresgc[] = $padresgc;

        return $this;
    }

    /**
     * Remove padresgc
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $padresgc
     */
    public function removePadresgc(\Netpublic\CoreBundle\Entity\Dimension $padresgc)
    {
        $this->padresgc->removeElement($padresgc);
    }

    /**
     * Get padresgc
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPadresgc()
    {
        return $this->padresgc;
    }
}
