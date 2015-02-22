<?php
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Netpublic\CoreBundle\Entity\Usuario;
use Symfony\Component\Validator\Constraints as Assert;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * Description of CargaAcademica
 *
 * @author yuri
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="profesor")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\ProfesorRepository")
 */

class Profesor 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;
    /**
     * @ORM\Column(type="string")
     */
    protected $nombre;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $nombre1;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $apellido;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $apellido1;
     /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $tipo_documento; 
    /**
     * @ORM\Column(type="string")
     */
    
    protected $cedula;
    
    /**
    * @ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_dpto_cedula")    
    */
    protected $departamento;    
    /**
     *@ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_municipio_cedula")    
     */
    protected $municipio;
    
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $url_foto;    
    
    
    
    /**
    * @ORM\OneToMany(targetEntity="CargaAcademica",mappedBy="profesor")
    */
   protected $carga_academica;
    /**
    * @ORM\OneToMany(targetEntity="CargaAcademica",mappedBy="profesor_dueno")
    */
   protected $carga_academicaprof;

   /**
     *
     * @ORM\OneToMany(targetEntity="Dimension",mappedBy="profesor")
     */
    protected $dimension;
    /**
    * @ORM\OneToMany(targetEntity="Desempeno",mappedBy="profesor")
    */
   protected $desempeno;
    /**
    * @ORM\OneToMany(targetEntity="Colegio",mappedBy="rector")
    */
   protected $colegio;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $horas_trabajo_semanales;
    /**
     *
     * @ORM\OneToOne(targetEntity="Usuario",inversedBy="profesor")
     * 
     *      */
    protected $usuario;
    
     /**
     *
     * @ORM\OneToMany(targetEntity="Profesorperiodoentrega",mappedBy="profesor")
     */
    protected $profesor_periodo_entrega;
     /**
    * @ORM\OneToMany(targetEntity="Grupo",mappedBy="director_grupo")
    */
   protected $grupo_dir;
    /**
     * TIPO de administrador
     * 
     * TIPO=1 Rector
     * TIPO=2 Profesor Normal
     * TIPO=3 Secretaria Auxiliar 
     * @ORM\Column(type="integer",nullable=true)
     */   
   protected $tipo;
   /**
     * @Assert\File(
     *     maxSize = "5M",
     *     maxSizeMessage = "Tu foto esta muy grande."     
     * )
     */
   public $foto_academica;  
   /**
     * @Assert\File(
     *     maxSize = "5M",
     *     maxSizeMessage = "Tu foto esta muy grande."     
     * )
     */
   public $foto_firma;
    /**
    * @ORM\ManyToOne(targetEntity="Colegio",inversedBy="profesor")       
    */    
    protected $sede;
    /**
    * @ORM\OneToMany(targetEntity="Observacion",mappedBy="dueno")      
    */    
    protected $observacion;
    /**
     * Estado Civil
     * 
     * TIPO=0 Soltero
     * TIPO=1 CAsado     
     * @ORM\Column(type="integer",nullable=true)
     */   
   protected $estado_civil;
     /**
     * Numero de Hijos
     * 
     * 
     *      
     * @ORM\Column(type="integer",nullable=true)
     */   
   protected $numero_hijos;
      /**
     * @ORM\Column(type="date",nullable=true)
     */
    protected $fecha_retiro;  
       /**
     * @ORM\Column(type="date",nullable=true)
     */
    protected $fecha_nacimiento;
      /**
     * @ORM\Column(type="date",nullable=true)
     */
    protected $fecha_vinculacion;
    /**
     * @ORM\Column(type="string",nullable=true)
     */   
   protected $libreta_militar;     
   /**
     * @ORM\Column(type="string",nullable=true)
     */   
   protected $distrito; 
   /**
     * @ORM\Column(type="string",nullable=true)
     */   
   protected $clase;
   /**
     * @ORM\Column(type="string",nullable=true)
     */   
   protected $resolucion_nombramiento;
   /**
     * @ORM\Column(type="boolean",nullable=true)
     */   
   protected $es_activo; 
   /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $genero;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $nivel_educativo_aprobado;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $ubicacion;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $cargo;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $zona;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $fuente_recursos;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $tipo_vinculacion;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $nombre_cargo;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $doc_dir_comision;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $amenazados;
     /**
     * @ORM\Column(type="date",nullable=true)
     */
    protected $fecha_status_amenazado;  
      /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $grado_escalafon;  
     /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $sobresueldo_recibido;  
     /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $nivel_ensenanza;  
     /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $etnoeducador;  
     /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $area_ensenanza_nombrado;  
     /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $area_ensenanza_tecnica;  
   /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $descripcion_otra_area;  
    /**
    * @ORM\OneToMany(targetEntity="HorarioClase",mappedBy="profesor")      
    */    
    protected $horario_clase;
    /**
     *
     * @ORM\OneToMany(targetEntity="PublicacionPeriodosProfesores",mappedBy="profesor")
     */
    protected $publicida_periodos_profesores;
    /**
     *
     * @ORM\OneToMany(targetEntity="CondicionProfesor",mappedBy="profesor")
     */
    protected $condicion_profesor;
    /**
    * @ORM\OneToMany(targetEntity="ProfesorSolicitud",mappedBy="profesor")      
    */    
   protected $solicitud;
     /**
     * @ORM\Column(type="string",nullable=true)
     */
   
    protected $nombre_completo;
    /**
    * @ORM\OneToMany(targetEntity="Netpublic\RedsaberBundle\Entity\Pregunta",mappedBy="creador_examen")  
    *     
    */    
    protected $pregunta;
    /**
     * @ORM\OneToMany(targetEntity="Netpublic\RedsaberBundle\Entity\TemasEvaluados",mappedBy="profesor")  
     * 
    */    
    protected $temas_evaluado;

    
    
    
    
    
   
    
   public function __toString(){
       return $this->apellido."   ".$this->apellido1."   ".$this->nombre."   ".$this->nombre1;
   }

 
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->carga_academica = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dimension = new \Doctrine\Common\Collections\ArrayCollection();
        $this->desempeno = new \Doctrine\Common\Collections\ArrayCollection();
        $this->colegio = new \Doctrine\Common\Collections\ArrayCollection();
        $this->profesor_periodo_entrega = new \Doctrine\Common\Collections\ArrayCollection();
        $this->grupo_dir = new \Doctrine\Common\Collections\ArrayCollection();
        $this->observacion = new \Doctrine\Common\Collections\ArrayCollection();
        $this->horario_clase = new \Doctrine\Common\Collections\ArrayCollection();
        $this->publicida_periodos_profesores = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Profesor
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        $cadena=  $this->nombre.  $this->nombre1.  $this->apellido.  $this->apellido1;
        $this->nombre_completo=  \Netpublic\CoreBundle\Util\Util::getSlug($cadena,"");
    
        return $this;
    }
    public function getNombreCompleto(){
        return $this->nombre_completo;
  
    }
      public function setNombreCompleto($nombre_completo){
        $this->nombre_completo=$nombre_completo;
    }
    public function getFotoAcademica(){
        return $this->foto_academica;
  
    }
      public function setFotoAcademica($nombre_completo){
        $this->foto_academica=$nombre_completo;
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
     * Set nombre1
     *
     * @param string $nombre1
     * @return Profesor
     */
    public function setNombre1($nombre1)
    {
        $this->nombre1 = $nombre1;
    
        return $this;
    }

    /**
     * Get nombre1
     *
     * @return string 
     */
    public function getNombre1()
    {
        return $this->nombre1;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     * @return Profesor
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    
        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set apellido1
     *
     * @param string $apellido1
     * @return Profesor
     */
    public function setApellido1($apellido1)
    {
        $this->apellido1 = $apellido1;
    
        return $this;
    }

    /**
     * Get apellido1
     *
     * @return string 
     */
    public function getApellido1()
    {
        return $this->apellido1;
    }

    /**
     * Set tipo_documento
     *
     * @param integer $tipoDocumento
     * @return Profesor
     */
    public function setTipoDocumento($tipoDocumento)
    {
        $this->tipo_documento = $tipoDocumento;
    
        return $this;
    }

    /**
     * Get tipo_documento
     *
     * @return integer 
     */
    public function getTipoDocumento()
    {
        return $this->tipo_documento;
    }

    /**
     * Set cedula
     *
     * @param string $cedula
     * @return Profesor
     */
    public function setCedula($cedula)
    {
        $this->cedula = $cedula;
    
        return $this;
    }

    /**
     * Get cedula
     *
     * @return string 
     */
    public function getCedula()
    {
        return $this->cedula;
    }

    /**
     * Set url_foto
     *
     * @param string $urlFoto
     * @return Profesor
     */
    public function setUrlFoto($urlFoto)
    {
        $this->url_foto = $urlFoto;
    
        return $this;
    }

    /**
     * Get url_foto
     *
     * @return string 
     */
    public function getUrlFoto()
    {
        return $this->url_foto;
    }

    /**
     * Set horas_trabajo_semanales
     *
     * @param integer $horasTrabajoSemanales
     * @return Profesor
     */
    public function setHorasTrabajoSemanales($horasTrabajoSemanales)
    {
        $this->horas_trabajo_semanales = $horasTrabajoSemanales;
    
        return $this;
    }

    /**
     * Get horas_trabajo_semanales
     *
     * @return integer 
     */
    public function getHorasTrabajoSemanales()
    {
        return $this->horas_trabajo_semanales;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     * @return Profesor
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
     * Set estado_civil
     *
     * @param integer $estadoCivil
     * @return Profesor
     */
    public function setEstadoCivil($estadoCivil)
    {
        $this->estado_civil = $estadoCivil;
    
        return $this;
    }

    /**
     * Get estado_civil
     *
     * @return integer 
     */
    public function getEstadoCivil()
    {
        return $this->estado_civil;
    }

    /**
     * Set numero_hijos
     *
     * @param integer $numeroHijos
     * @return Profesor
     */
    public function setNumeroHijos($numeroHijos)
    {
        $this->numero_hijos = $numeroHijos;
    
        return $this;
    }

    /**
     * Get numero_hijos
     *
     * @return integer 
     */
    public function getNumeroHijos()
    {
        return $this->numero_hijos;
    }

    /**
     * Set fecha_retiro
     *
     * @param \DateTime $fechaRetiro
     * @return Profesor
     */
    public function setFechaRetiro($fechaRetiro)
    {
        $this->fecha_retiro = $fechaRetiro;
    
        return $this;
    }

    /**
     * Get fecha_retiro
     *
     * @return \DateTime 
     */
    public function getFechaRetiro()
    {
        return $this->fecha_retiro;
    }

    /**
     * Set fecha_nacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return Profesor
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fecha_nacimiento = $fechaNacimiento;
    
        return $this;
    }

    /**
     * Get fecha_nacimiento
     *
     * @return \DateTime 
     */
    public function getFechaNacimiento()
    {
        return $this->fecha_nacimiento;
    }

    /**
     * Set fecha_vinculacion
     *
     * @param \DateTime $fechaVinculacion
     * @return Profesor
     */
    public function setFechaVinculacion($fechaVinculacion)
    {
        $this->fecha_vinculacion = $fechaVinculacion;
    
        return $this;
    }

    /**
     * Get fecha_vinculacion
     *
     * @return \DateTime 
     */
    public function getFechaVinculacion()
    {
        return $this->fecha_vinculacion;
    }

    /**
     * Set libreta_militar
     *
     * @param string $libretaMilitar
     * @return Profesor
     */
    public function setLibretaMilitar($libretaMilitar)
    {
        $this->libreta_militar = $libretaMilitar;
    
        return $this;
    }

    /**
     * Get libreta_militar
     *
     * @return string 
     */
    public function getLibretaMilitar()
    {
        return $this->libreta_militar;
    }

    /**
     * Set distrito
     *
     * @param string $distrito
     * @return Profesor
     */
    public function setDistrito($distrito)
    {
        $this->distrito = $distrito;
    
        return $this;
    }

    /**
     * Get distrito
     *
     * @return string 
     */
    public function getDistrito()
    {
        return $this->distrito;
    }

    /**
     * Set clase
     *
     * @param string $clase
     * @return Profesor
     */
    public function setClase($clase)
    {
        $this->clase = $clase;
    
        return $this;
    }

    /**
     * Get clase
     *
     * @return string 
     */
    public function getClase()
    {
        return $this->clase;
    }

    /**
     * Set resolucion_nombramiento
     *
     * @param string $resolucionNombramiento
     * @return Profesor
     */
    public function setResolucionNombramiento($resolucionNombramiento)
    {
        $this->resolucion_nombramiento = $resolucionNombramiento;
    
        return $this;
    }

    /**
     * Get resolucion_nombramiento
     *
     * @return string 
     */
    public function getResolucionNombramiento()
    {
        return $this->resolucion_nombramiento;
    }

    /**
     * Set es_activo
     *
     * @param boolean $esActivo
     * @return Profesor
     */
    public function setEsActivo($esActivo)
    {
        $this->es_activo = $esActivo;
    
        return $this;
    }

    /**
     * Get es_activo
     *
     * @return boolean 
     */
    public function getEsActivo()
    {
        return $this->es_activo;
    }

    /**
     * Set genero
     *
     * @param integer $genero
     * @return Profesor
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;
    
        return $this;
    }

    /**
     * Get genero
     *
     * @return integer 
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set nivel_educativo_aprobado
     *
     * @param integer $nivelEducativoAprobado
     * @return Profesor
     */
    public function setNivelEducativoAprobado($nivelEducativoAprobado)
    {
        $this->nivel_educativo_aprobado = $nivelEducativoAprobado;
    
        return $this;
    }

    /**
     * Get nivel_educativo_aprobado
     *
     * @return integer 
     */
    public function getNivelEducativoAprobado()
    {
        return $this->nivel_educativo_aprobado;
    }

    /**
     * Set ubicacion
     *
     * @param integer $ubicacion
     * @return Profesor
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;
    
        return $this;
    }

    /**
     * Get ubicacion
     *
     * @return integer 
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * Set cargo
     *
     * @param integer $cargo
     * @return Profesor
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
    
        return $this;
    }

    /**
     * Get cargo
     *
     * @return integer 
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set zona
     *
     * @param integer $zona
     * @return Profesor
     */
    public function setZona($zona)
    {
        $this->zona = $zona;
    
        return $this;
    }

    /**
     * Get zona
     *
     * @return integer 
     */
    public function getZona()
    {
        return $this->zona;
    }

    /**
     * Set fuente_recursos
     *
     * @param integer $fuenteRecursos
     * @return Profesor
     */
    public function setFuenteRecursos($fuenteRecursos)
    {
        $this->fuente_recursos = $fuenteRecursos;
    
        return $this;
    }

    /**
     * Get fuente_recursos
     *
     * @return integer 
     */
    public function getFuenteRecursos()
    {
        return $this->fuente_recursos;
    }

    /**
     * Set tipo_vinculacion
     *
     * @param integer $tipoVinculacion
     * @return Profesor
     */
    public function setTipoVinculacion($tipoVinculacion)
    {
        $this->tipo_vinculacion = $tipoVinculacion;
    
        return $this;
    }

    /**
     * Get tipo_vinculacion
     *
     * @return integer 
     */
    public function getTipoVinculacion()
    {
        return $this->tipo_vinculacion;
    }

    /**
     * Set nombre_cargo
     *
     * @param integer $nombreCargo
     * @return Profesor
     */
    public function setNombreCargo($nombreCargo)
    {
        $this->nombre_cargo = $nombreCargo;
    
        return $this;
    }

    /**
     * Get nombre_cargo
     *
     * @return integer 
     */
    public function getNombreCargo()
    {
        return $this->nombre_cargo;
    }

    /**
     * Set doc_dir_comision
     *
     * @param integer $docDirComision
     * @return Profesor
     */
    public function setDocDirComision($docDirComision)
    {
        $this->doc_dir_comision = $docDirComision;
    
        return $this;
    }

    /**
     * Get doc_dir_comision
     *
     * @return integer 
     */
    public function getDocDirComision()
    {
        return $this->doc_dir_comision;
    }

    /**
     * Set amenazados
     *
     * @param integer $amenazados
     * @return Profesor
     */
    public function setAmenazados($amenazados)
    {
        $this->amenazados = $amenazados;
    
        return $this;
    }

    /**
     * Get amenazados
     *
     * @return integer 
     */
    public function getAmenazados()
    {
        return $this->amenazados;
    }

    /**
     * Set fecha_status_amenazado
     *
     * @param \DateTime $fechaStatusAmenazado
     * @return Profesor
     */
    public function setFechaStatusAmenazado($fechaStatusAmenazado)
    {
        $this->fecha_status_amenazado = $fechaStatusAmenazado;
    
        return $this;
    }

    /**
     * Get fecha_status_amenazado
     *
     * @return \DateTime 
     */
    public function getFechaStatusAmenazado()
    {
        return $this->fecha_status_amenazado;
    }

    /**
     * Set grado_escalafon
     *
     * @param string $gradoEscalafon
     * @return Profesor
     */
    public function setGradoEscalafon($gradoEscalafon)
    {
        $this->grado_escalafon = $gradoEscalafon;
    
        return $this;
    }

    /**
     * Get grado_escalafon
     *
     * @return string 
     */
    public function getGradoEscalafon()
    {
        return $this->grado_escalafon;
    }

    /**
     * Set sobresueldo_recibido
     *
     * @param integer $sobresueldoRecibido
     * @return Profesor
     */
    public function setSobresueldoRecibido($sobresueldoRecibido)
    {
        $this->sobresueldo_recibido = $sobresueldoRecibido;
    
        return $this;
    }

    /**
     * Get sobresueldo_recibido
     *
     * @return integer 
     */
    public function getSobresueldoRecibido()
    {
        return $this->sobresueldo_recibido;
    }

    /**
     * Set nivel_ensenanza
     *
     * @param integer $nivelEnsenanza
     * @return Profesor
     */
    public function setNivelEnsenanza($nivelEnsenanza)
    {
        $this->nivel_ensenanza = $nivelEnsenanza;
    
        return $this;
    }

    /**
     * Get nivel_ensenanza
     *
     * @return integer 
     */
    public function getNivelEnsenanza()
    {
        return $this->nivel_ensenanza;
    }

    /**
     * Set etnoeducador
     *
     * @param integer $etnoeducador
     * @return Profesor
     */
    public function setEtnoeducador($etnoeducador)
    {
        $this->etnoeducador = $etnoeducador;
    
        return $this;
    }

    /**
     * Get etnoeducador
     *
     * @return integer 
     */
    public function getEtnoeducador()
    {
        return $this->etnoeducador;
    }

    /**
     * Set area_ensenanza_nombrado
     *
     * @param integer $areaEnsenanzaNombrado
     * @return Profesor
     */
    public function setAreaEnsenanzaNombrado($areaEnsenanzaNombrado)
    {
        $this->area_ensenanza_nombrado = $areaEnsenanzaNombrado;
    
        return $this;
    }

    /**
     * Get area_ensenanza_nombrado
     *
     * @return integer 
     */
    public function getAreaEnsenanzaNombrado()
    {
        return $this->area_ensenanza_nombrado;
    }

    /**
     * Set area_ensenanza_tecnica
     *
     * @param integer $areaEnsenanzaTecnica
     * @return Profesor
     */
    public function setAreaEnsenanzaTecnica($areaEnsenanzaTecnica)
    {
        $this->area_ensenanza_tecnica = $areaEnsenanzaTecnica;
    
        return $this;
    }

    /**
     * Get area_ensenanza_tecnica
     *
     * @return integer 
     */
    public function getAreaEnsenanzaTecnica()
    {
        return $this->area_ensenanza_tecnica;
    }

    /**
     * Set descripcion_otra_area
     *
     * @param string $descripcionOtraArea
     * @return Profesor
     */
    public function setDescripcionOtraArea($descripcionOtraArea)
    {
        $this->descripcion_otra_area = $descripcionOtraArea;
    
        return $this;
    }

    /**
     * Get descripcion_otra_area
     *
     * @return string 
     */
    public function getDescripcionOtraArea()
    {
        return $this->descripcion_otra_area;
    }

    /**
     * Set departamento
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $departamento
     * @return Profesor
     */
    public function setDepartamento(\Netpublic\CoreBundle\Entity\ValorVariable $departamento = null)
    {
        $this->departamento = $departamento;
    
        return $this;
    }

    /**
     * Get departamento
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * Set municipio
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $municipio
     * @return Profesor
     */
    public function setMunicipio(\Netpublic\CoreBundle\Entity\ValorVariable $municipio = null)
    {
        $this->municipio = $municipio;
    
        return $this;
    }

    /**
     * Get municipio
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Add carga_academica
     *
     * @param \Netpublic\CoreBundle\Entity\CargaAcademica $cargaAcademica
     * @return Profesor
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
     * Add dimension
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $dimension
     * @return Profesor
     */
    public function addDimension(\Netpublic\CoreBundle\Entity\Dimension $dimension)
    {
        $this->dimension[] = $dimension;
    
        return $this;
    }

    /**
     * Remove dimension
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $dimension
     */
    public function removeDimension(\Netpublic\CoreBundle\Entity\Dimension $dimension)
    {
        $this->dimension->removeElement($dimension);
    }

    /**
     * Get dimension
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * Add desempeno
     *
     * @param \Netpublic\CoreBundle\Entity\Desempeno $desempeno
     * @return Profesor
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
     * Add colegio
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $colegio
     * @return Profesor
     */
    public function addColegio(\Netpublic\CoreBundle\Entity\Colegio $colegio)
    {
        $this->colegio[] = $colegio;
    
        return $this;
    }

    /**
     * Remove colegio
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $colegio
     */
    public function removeColegio(\Netpublic\CoreBundle\Entity\Colegio $colegio)
    {
        $this->colegio->removeElement($colegio);
    }

    /**
     * Get colegio
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getColegio()
    {
        return $this->colegio;
    }

    /**
     * Set usuario
     *
     * @param \Netpublic\CoreBundle\Entity\Usuario $usuario
     * @return Profesor
     */
    public function setUsuario(\Netpublic\CoreBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;
    
        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Netpublic\CoreBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Add profesor_periodo_entrega
     *
     * @param \Netpublic\CoreBundle\Entity\Profesorperiodoentrega $profesorPeriodoEntrega
     * @return Profesor
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
     * Add grupo_dir
     *
     * @param \Netpublic\CoreBundle\Entity\Grupo $grupoDir
     * @return Profesor
     */
    public function addGrupoDir(\Netpublic\CoreBundle\Entity\Grupo $grupoDir)
    {
        $this->grupo_dir[] = $grupoDir;
    
        return $this;
    }

    /**
     * Remove grupo_dir
     *
     * @param \Netpublic\CoreBundle\Entity\Grupo $grupoDir
     */
    public function removeGrupoDir(\Netpublic\CoreBundle\Entity\Grupo $grupoDir)
    {
        $this->grupo_dir->removeElement($grupoDir);
    }

    /**
     * Get grupo_dir
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGrupoDir()
    {
        return $this->grupo_dir;
    }

    /**
     * Set sede
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $sede
     * @return Profesor
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
     * Add observacion
     *
     * @param \Netpublic\CoreBundle\Entity\Observacion $observacion
     * @return Profesor
     */
    public function addObservacion(\Netpublic\CoreBundle\Entity\Observacion $observacion)
    {
        $this->observacion[] = $observacion;
    
        return $this;
    }

    /**
     * Remove observacion
     *
     * @param \Netpublic\CoreBundle\Entity\Observacion $observacion
     */
    public function removeObservacion(\Netpublic\CoreBundle\Entity\Observacion $observacion)
    {
        $this->observacion->removeElement($observacion);
    }

    /**
     * Get observacion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Add horario_clase
     *
     * @param \Netpublic\CoreBundle\Entity\HorarioClase $horarioClase
     * @return Profesor
     */
    public function addHorarioClase(\Netpublic\CoreBundle\Entity\HorarioClase $horarioClase)
    {
        $this->horario_clase[] = $horarioClase;
    
        return $this;
    }

    /**
     * Remove horario_clase
     *
     * @param \Netpublic\CoreBundle\Entity\HorarioClase $horarioClase
     */
    public function removeHorarioClase(\Netpublic\CoreBundle\Entity\HorarioClase $horarioClase)
    {
        $this->horario_clase->removeElement($horarioClase);
    }

    /**
     * Get horario_clase
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHorarioClase()
    {
        return $this->horario_clase;
    }

    /**
     * Add publicida_periodos_profesores
     *
     * @param \Netpublic\CoreBundle\Entity\PublicacionPeriodosProfesores $publicidaPeriodosProfesores
     * @return Profesor
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
     * Add condicion_profesor
     *
     * @param \Netpublic\CoreBundle\Entity\CondicionProfesor $condicionProfesor
     * @return Profesor
     */
    public function addCondicionProfesor(\Netpublic\CoreBundle\Entity\CondicionProfesor $condicionProfesor)
    {
        $this->condicion_profesor[] = $condicionProfesor;
    
        return $this;
    }

    /**
     * Remove condicion_profesor
     *
     * @param \Netpublic\CoreBundle\Entity\CondicionProfesor $condicionProfesor
     */
    public function removeCondicionProfesor(\Netpublic\CoreBundle\Entity\CondicionProfesor $condicionProfesor)
    {
        $this->condicion_profesor->removeElement($condicionProfesor);
    }

    /**
     * Get condicion_profesor
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCondicionProfesor()
    {
        return $this->condicion_profesor;
    }

    /**
     * Add solicitud
     *
     * @param \Netpublic\CoreBundle\Entity\ProfesorSolicitud $solicitud
     * @return Profesor
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
     * Add carga_academicaprof
     *
     * @param \Netpublic\CoreBundle\Entity\CargaAcademica $cargaAcademicaprof
     * @return Profesor
     */
    public function addCargaAcademicaprof(\Netpublic\CoreBundle\Entity\CargaAcademica $cargaAcademicaprof)
    {
        $this->carga_academicaprof[] = $cargaAcademicaprof;
    
        return $this;
    }

    /**
     * Remove carga_academicaprof
     *
     * @param \Netpublic\CoreBundle\Entity\CargaAcademica $cargaAcademicaprof
     */
    public function removeCargaAcademicaprof(\Netpublic\CoreBundle\Entity\CargaAcademica $cargaAcademicaprof)
    {
        $this->carga_academicaprof->removeElement($cargaAcademicaprof);
    }

    /**
     * Get carga_academicaprof
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCargaAcademicaprof()
    {
        return $this->carga_academicaprof;
    }

    /**
     * Add pregunta
     *
     * @param \Netpublic\RedsaberBundle\Entity\Pregunta $pregunta
     * @return Profesor
     */
    public function addPreguntum(\Netpublic\RedsaberBundle\Entity\Pregunta $pregunta)
    {
        $this->pregunta[] = $pregunta;

        return $this;
    }

    /**
     * Remove pregunta
     *
     * @param \Netpublic\RedsaberBundle\Entity\Pregunta $pregunta
     */
    public function removePreguntum(\Netpublic\RedsaberBundle\Entity\Pregunta $pregunta)
    {
        $this->pregunta->removeElement($pregunta);
    }

    /**
     * Get pregunta
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPregunta()
    {
        return $this->pregunta;
    }

    /**
     * Add temas_evaluado
     *
     * @param \Netpublic\RedsaberBundle\Entity\TemasEvaluados $temasEvaluado
     * @return Profesor
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
}
