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
 * @ORM\Table(name="alumno")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\AlumnoRepository")
 */
class Alumno 
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
     *
     * @ORM\Column(type="string",nullable=true)
     */
    protected $nombre1;
    /**
     *
     * @ORM\Column(type="string",nullable=true)
     */
    protected $apellido;
    /**
     *
     * @ORM\Column(type="string",nullable=true)
     */
    protected $apellido1;
    /**
     *
     * @ORM\Column(type="string",length=14,nullable=true)
     */
    protected $movil;

    /**
    * @ORM\ManyToOne(targetEntity="Grupo",inversedBy="alumnos")    
     *
     *     */    
    protected $grupo;
    
    /**
    * @ORM\ManyToOne(targetEntity="Grupo",inversedBy="alumnos_promovido")    
     *
     *     */    
    protected $grupo_promovido;
    /**
    * @ORM\ManyToOne(targetEntity="Grado",inversedBy="alumnos")    
    *
     */    
    protected $grado;    
    /**
     *
     * @ORM\OneToMany(targetEntity="AlumnoDimension",mappedBy="alumno",cascade={"persist", "remove"})
     */
    protected $nota;
     /**
     *
     * @ORM\OneToMany(targetEntity="AlumnoDesempeno",mappedBy="alumno",cascade={"persist", "remove"})
     */
    protected $nota_desempeno;
    /**
    * @ORM\OneToMany(targetEntity="MatriculaAlumno",mappedBy="alumno",cascade={"persist", "remove"})    
    */    
    protected $matricula_alumno;
    /**
     * @ORM\Column(type="string")
     */
    protected $cedula;
    /**
     * @ORM\Column(type="integer")
     */
    protected $tipo_documento;    
    
    /**
    * @ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_dpto_cedula")    
    */
    protected $departamento;    
    /**
     *@ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_municipio_cedula")    
     */
    protected $municipio;

     /**
     * @ORM\Column(type="date",nullable=true)
     */
    protected $fecha_nacimiento;
     /**
    * @ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_dpto_fecha_nacimiento")    
    */
    protected $depto_nacimiento;    
    /**
     *@ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_municipio_fecha_nacimiento")    
     */
    protected $municipio_nacimiento;    
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $genero; 
    /**
     * @Assert\File(
     *     maxSize = "2M",
     *     maxSizeMessage = "Tu foto esta muy grande."     
     * )
     */

    public $foto_academica;  
       /**
     * @Assert\File(
     *     maxSize = "2M",
     *     maxSizeMessage = "Tu foto esta muy grande."     
     * )
     */

    public $foto_firma;
     /**
     * @ORM\Column(type="integer",nullable=true)
     */    
    protected $tipo_sangre;    
    //Ubicacion del Estudiante
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $direccion_residencia;    
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $telefono;    
    /**
     *@ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_depto_ubicacion")    
     */
    protected $depto_ubicacion;    
    /**
     *@ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_municipio_ubicacion")    
     */
    protected $municipio_ubicacion;    
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $zona;    
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $localidad_vereda;    
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $barrio;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $estrato_socioeconomico; 
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $sisben;    
    //Información de Seguridad social del alumno
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $eps;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $ars;    
    //Datos adicionales
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $poblacion_vitima_conflito;
    /**
     *@ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_municipio_expulsor")    
     */
    protected $ultimo_depto_expulsor;    
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $tipo_municipio_expulsor;    
    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $es_sector_privado;    
    /**
     * @ORM\Column(type="boolean",nullable=true)
     * 
     */    
    protected $es_otro_municipio;    
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $tipo_discapacidad;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $capacidad_excepcionales;    
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $etnia;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $resguardo;    
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $parentesco;    
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $empresa;    
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $telefono_empresa;    
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $ocupacion;    
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $email;    
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $colegio_estudio_ultimo_ano;    
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $direccion_colegio_proveniente;    
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $grado_proveniente;    
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $ano;    
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $motivo_retiro;    
    
    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $es_resposable;
     /**
     *@ORM\ManyToOne(targetEntity="Alumno",inversedBy="alumno_acudiente")    
     */
    protected $acudiente;
     /**
     *@ORM\ManyToOne(targetEntity="Alumno",inversedBy="padre")    
     */
    protected $padre;
     /**
     *@ORM\ManyToOne(targetEntity="Alumno",inversedBy="madre")    
     */
    protected $madre;    
     /**
     *@ORM\OneToMany(targetEntity="Alumno",mappedBy="acudiente",cascade={"persist", "remove"})    
     */
    protected $alumno_acudiente;
    
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    //Tipos de alumnos
    // acudiente tipo=1
    // alumno  tipo0
    protected $tipo=0;
    /**
     *
     * @ORM\OneToOne(targetEntity="Usuario",inversedBy="alumno")
     */
    protected $usuario;
     /**
    * @ORM\ManyToOne(targetEntity="Colegio",inversedBy="alumno")      * 
    */    
    protected $sede;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    //Tipos de alumnos
    // acudiente tipo=1
    // alumno  tipo0
    protected $jornada;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    //Tipos de alumnos
    // acudiente tipo=1
    // alumno  tipo0
    protected $subsidiado;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    //Tipos de alumnos
    // acudiente tipo=1
    // alumno  tipo0
    protected $alumno_madre_cabeza_familia;
        /**
     * @ORM\Column(type="integer",nullable=true)
     */
    //Tipos de alumnos
    // acudiente tipo=1
    // alumno  tipo0
    protected $beneficiario_madre_cabeza_familia;
         /**
     * @ORM\Column(type="integer",nullable=true)
     */
    //Tipos de alumnos
    // acudiente tipo=1
    // alumno  tipo0
    protected $beneficiario_veterano_militar;
         /**
     * @ORM\Column(type="integer",nullable=true)
     */
    //Tipos de alumnos
    // acudiente tipo=1
    // alumno  tipo0
    protected $beneficiario_heroes_nacion;
    /**
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    /*
     * 0 = NO ESTUDIO
     * 1 = APROBO
     * 2 = REPROBO
     * 8 = NO CULMINO LOS ESTUDIOS 
     * 
     */
    protected $situacion_academica_ano_anterior;
    /**
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    /*
     * 3 = DESERTO
     * 5 = TRANSLADA A OTRA INSTITUCION
     * 9 = NO APLICA
     * 
     */
    protected $condicion_finalizar_ano_anterior;
      /**
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    /*
     * 3 = DESERTO
     * 5 = TRANSLADA A OTRA INSTITUCION
     * 9 = NO APLICA
     * 
     */
    protected $repitente;
      /**
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    /*
     * 2 = Nuevo
     * 5 = TRANSLADA A OTRA INSTITUCION
     * 9 = NO APLICA
     * 
     */
    protected $es_nuevo;
      /**
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    /*
     * 0 = Habilito
     * 1 = No Habilito
     * 
     */
    protected $es_habilitacion;
    
     /**
    * @ORM\OneToMany(targetEntity="Observacion",mappedBy="alumno",cascade={"persist", "remove"})      
    */    
    protected $observacion;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $posicion_academica;
    /**
     *
     * @ORM\OneToMany(targetEntity="NivelAcademico",mappedBy="alumno",cascade={"persist", "remove"})
     */
    protected $nivel_academico;
    /**
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $es_recuperacion;
    /**
    * @ORM\OneToMany(targetEntity="ProfesorSolicitud",mappedBy="alumno")      
    */    
   protected $solicitud;
     /**
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    /*
     * 0 = No Tiene Novedad
     * 1 = Tiene Novedad
     * 
     */
    protected $tiene_novedad;
     /**
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    /*
     * 0 = No es una adicion
     * 1 = Es una alumno adicionado
     * 
     */
    protected $es_adicion;
     /**
     * @ORM\Column(type="string",nullable=true)
     */
   
    protected $nombre_completo;
    /**
    * @ORM\OneToMany(targetEntity="Anoescolargrado",mappedBy="alumno")  
    *    
    * 
    */    
    protected $alumno_cursado;
    /**
    * @ORM\OneToMany(targetEntity="Netpublic\RedsaberBundle\Entity\Pregunta",mappedBy="alumno")  
    *    
    * 
    */    
    protected $pregunta_alumno;
    
    public function __toString() {
        return $this->apellido."  ".$this->apellido1." ".$this->nombre."  ".$this->nombre1;
   
    }
    public function getNombreCompleto(){
        return $this->nombre_completo;
  
    }
      public function setNombreCompleto($nombre_completo){
        $this->nombre_completo=$nombre_completo;
    }
  
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->nota = new \Doctrine\Common\Collections\ArrayCollection();
        $this->nota_desempeno = new \Doctrine\Common\Collections\ArrayCollection();
        $this->matricula_alumno = new \Doctrine\Common\Collections\ArrayCollection();
        $this->alumno_acudiente = new \Doctrine\Common\Collections\ArrayCollection();
        $this->observacion = new \Doctrine\Common\Collections\ArrayCollection();
        $this->nivel_academico = new \Doctrine\Common\Collections\ArrayCollection();
        $this->solicitud = new \Doctrine\Common\Collections\ArrayCollection();
        $this->alumno_cursado = new \Doctrine\Common\Collections\ArrayCollection();
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
     public function getFotoAcademica()
    {
        return $this->foto_academica;
    }
/**
     * Get es_subsidio
     *
     * @return boolean 
     */
    public function setFotoAcademic($escudo)
    {
        return $this->foto_academica=$escudo;
    }


    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Alumno
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        $cadena=  $this->nombre.  $this->nombre1.  $this->apellido.  $this->apellido1;
        $this->nombre_completo=  \Netpublic\CoreBundle\Util\Util::getSlug($cadena,"");
    
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
     * Set nombre1
     *
     * @param string $nombre1
     * @return Alumno
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
     * @return Alumno
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
     * @return Alumno
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
     * Set movil
     *
     * @param string $movil
     * @return Alumno
     */
    public function setMovil($movil)
    {
        $this->movil = $movil;

        return $this;
    }

    /**
     * Get movil
     *
     * @return string 
     */
    public function getMovil()
    {
        return $this->movil;
    }

    /**
     * Set cedula
     *
     * @param string $cedula
     * @return Alumno
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
     * Set tipo_documento
     *
     * @param integer $tipoDocumento
     * @return Alumno
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
     * Set fecha_nacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return Alumno
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
     * Set genero
     *
     * @param integer $genero
     * @return Alumno
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
     * Set tipo_sangre
     *
     * @param integer $tipoSangre
     * @return Alumno
     */
    public function setTipoSangre($tipoSangre)
    {
        $this->tipo_sangre = $tipoSangre;

        return $this;
    }

    /**
     * Get tipo_sangre
     *
     * @return integer 
     */
    public function getTipoSangre()
    {
        return $this->tipo_sangre;
    }

    /**
     * Set direccion_residencia
     *
     * @param string $direccionResidencia
     * @return Alumno
     */
    public function setDireccionResidencia($direccionResidencia)
    {
        $this->direccion_residencia = $direccionResidencia;

        return $this;
    }

    /**
     * Get direccion_residencia
     *
     * @return string 
     */
    public function getDireccionResidencia()
    {
        return $this->direccion_residencia;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Alumno
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set zona
     *
     * @param integer $zona
     * @return Alumno
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
     * Set localidad_vereda
     *
     * @param string $localidadVereda
     * @return Alumno
     */
    public function setLocalidadVereda($localidadVereda)
    {
        $this->localidad_vereda = $localidadVereda;

        return $this;
    }

    /**
     * Get localidad_vereda
     *
     * @return string 
     */
    public function getLocalidadVereda()
    {
        return $this->localidad_vereda;
    }

    /**
     * Set barrio
     *
     * @param integer $barrio
     * @return Alumno
     */
    public function setBarrio($barrio)
    {
        $this->barrio = $barrio;

        return $this;
    }

    /**
     * Get barrio
     *
     * @return integer 
     */
    public function getBarrio()
    {
        return $this->barrio;
    }

    /**
     * Set estrato_socioeconomico
     *
     * @param integer $estratoSocioeconomico
     * @return Alumno
     */
    public function setEstratoSocioeconomico($estratoSocioeconomico)
    {
        $this->estrato_socioeconomico = $estratoSocioeconomico;

        return $this;
    }

    /**
     * Get estrato_socioeconomico
     *
     * @return integer 
     */
    public function getEstratoSocioeconomico()
    {
        return $this->estrato_socioeconomico;
    }

    /**
     * Set sisben
     *
     * @param integer $sisben
     * @return Alumno
     */
    public function setSisben($sisben)
    {
        $this->sisben = $sisben;

        return $this;
    }

    /**
     * Get sisben
     *
     * @return integer 
     */
    public function getSisben()
    {
        return $this->sisben;
    }

    /**
     * Set eps
     *
     * @param integer $eps
     * @return Alumno
     */
    public function setEps($eps)
    {
        $this->eps = $eps;

        return $this;
    }

    /**
     * Get eps
     *
     * @return integer 
     */
    public function getEps()
    {
        return $this->eps;
    }

    /**
     * Set ars
     *
     * @param integer $ars
     * @return Alumno
     */
    public function setArs($ars)
    {
        $this->ars = $ars;

        return $this;
    }

    /**
     * Get ars
     *
     * @return integer 
     */
    public function getArs()
    {
        return $this->ars;
    }

    /**
     * Set poblacion_vitima_conflito
     *
     * @param integer $poblacionVitimaConflito
     * @return Alumno
     */
    public function setPoblacionVitimaConflito($poblacionVitimaConflito)
    {
        $this->poblacion_vitima_conflito = $poblacionVitimaConflito;

        return $this;
    }

    /**
     * Get poblacion_vitima_conflito
     *
     * @return integer 
     */
    public function getPoblacionVitimaConflito()
    {
        return $this->poblacion_vitima_conflito;
    }

    /**
     * Set tipo_municipio_expulsor
     *
     * @param integer $tipoMunicipioExpulsor
     * @return Alumno
     */
    public function setTipoMunicipioExpulsor($tipoMunicipioExpulsor)
    {
        $this->tipo_municipio_expulsor = $tipoMunicipioExpulsor;

        return $this;
    }

    /**
     * Get tipo_municipio_expulsor
     *
     * @return integer 
     */
    public function getTipoMunicipioExpulsor()
    {
        return $this->tipo_municipio_expulsor;
    }

    /**
     * Set es_sector_privado
     *
     * @param boolean $esSectorPrivado
     * @return Alumno
     */
    public function setEsSectorPrivado($esSectorPrivado)
    {
        $this->es_sector_privado = $esSectorPrivado;

        return $this;
    }

    /**
     * Get es_sector_privado
     *
     * @return boolean 
     */
    public function getEsSectorPrivado()
    {
        return $this->es_sector_privado;
    }

    /**
     * Set es_otro_municipio
     *
     * @param boolean $esOtroMunicipio
     * @return Alumno
     */
    public function setEsOtroMunicipio($esOtroMunicipio)
    {
        $this->es_otro_municipio = $esOtroMunicipio;

        return $this;
    }

    /**
     * Get es_otro_municipio
     *
     * @return boolean 
     */
    public function getEsOtroMunicipio()
    {
        return $this->es_otro_municipio;
    }

    /**
     * Set tipo_discapacidad
     *
     * @param integer $tipoDiscapacidad
     * @return Alumno
     */
    public function setTipoDiscapacidad($tipoDiscapacidad)
    {
        $this->tipo_discapacidad = $tipoDiscapacidad;

        return $this;
    }

    /**
     * Get tipo_discapacidad
     *
     * @return integer 
     */
    public function getTipoDiscapacidad()
    {
        return $this->tipo_discapacidad;
    }

    /**
     * Set capacidad_excepcionales
     *
     * @param integer $capacidadExcepcionales
     * @return Alumno
     */
    public function setCapacidadExcepcionales($capacidadExcepcionales)
    {
        $this->capacidad_excepcionales = $capacidadExcepcionales;

        return $this;
    }

    /**
     * Get capacidad_excepcionales
     *
     * @return integer 
     */
    public function getCapacidadExcepcionales()
    {
        return $this->capacidad_excepcionales;
    }

    /**
     * Set etnia
     *
     * @param integer $etnia
     * @return Alumno
     */
    public function setEtnia($etnia)
    {
        $this->etnia = $etnia;

        return $this;
    }

    /**
     * Get etnia
     *
     * @return integer 
     */
    public function getEtnia()
    {
        return $this->etnia;
    }

    /**
     * Set resguardo
     *
     * @param integer $resguardo
     * @return Alumno
     */
    public function setResguardo($resguardo)
    {
        $this->resguardo = $resguardo;

        return $this;
    }

    /**
     * Get resguardo
     *
     * @return integer 
     */
    public function getResguardo()
    {
        return $this->resguardo;
    }

    /**
     * Set parentesco
     *
     * @param string $parentesco
     * @return Alumno
     */
    public function setParentesco($parentesco)
    {
        $this->parentesco = $parentesco;

        return $this;
    }

    /**
     * Get parentesco
     *
     * @return string 
     */
    public function getParentesco()
    {
        return $this->parentesco;
    }

    /**
     * Set empresa
     *
     * @param string $empresa
     * @return Alumno
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return string 
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set telefono_empresa
     *
     * @param string $telefonoEmpresa
     * @return Alumno
     */
    public function setTelefonoEmpresa($telefonoEmpresa)
    {
        $this->telefono_empresa = $telefonoEmpresa;

        return $this;
    }

    /**
     * Get telefono_empresa
     *
     * @return string 
     */
    public function getTelefonoEmpresa()
    {
        return $this->telefono_empresa;
    }

    /**
     * Set ocupacion
     *
     * @param string $ocupacion
     * @return Alumno
     */
    public function setOcupacion($ocupacion)
    {
        $this->ocupacion = $ocupacion;

        return $this;
    }

    /**
     * Get ocupacion
     *
     * @return string 
     */
    public function getOcupacion()
    {
        return $this->ocupacion;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Alumno
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set colegio_estudio_ultimo_ano
     *
     * @param integer $colegioEstudioUltimoAno
     * @return Alumno
     */
    public function setColegioEstudioUltimoAno($colegioEstudioUltimoAno)
    {
        $this->colegio_estudio_ultimo_ano = $colegioEstudioUltimoAno;

        return $this;
    }

    /**
     * Get colegio_estudio_ultimo_ano
     *
     * @return integer 
     */
    public function getColegioEstudioUltimoAno()
    {
        return $this->colegio_estudio_ultimo_ano;
    }

    /**
     * Set direccion_colegio_proveniente
     *
     * @param string $direccionColegioProveniente
     * @return Alumno
     */
    public function setDireccionColegioProveniente($direccionColegioProveniente)
    {
        $this->direccion_colegio_proveniente = $direccionColegioProveniente;

        return $this;
    }

    /**
     * Get direccion_colegio_proveniente
     *
     * @return string 
     */
    public function getDireccionColegioProveniente()
    {
        return $this->direccion_colegio_proveniente;
    }

    /**
     * Set grado_proveniente
     *
     * @param string $gradoProveniente
     * @return Alumno
     */
    public function setGradoProveniente($gradoProveniente)
    {
        $this->grado_proveniente = $gradoProveniente;

        return $this;
    }

    /**
     * Get grado_proveniente
     *
     * @return string 
     */
    public function getGradoProveniente()
    {
        return $this->grado_proveniente;
    }

    /**
     * Set ano
     *
     * @param string $ano
     * @return Alumno
     */
    public function setAno($ano)
    {
        $this->ano = $ano;

        return $this;
    }

    /**
     * Get ano
     *
     * @return string 
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * Set motivo_retiro
     *
     * @param string $motivoRetiro
     * @return Alumno
     */
    public function setMotivoRetiro($motivoRetiro)
    {
        $this->motivo_retiro = $motivoRetiro;

        return $this;
    }

    /**
     * Get motivo_retiro
     *
     * @return string 
     */
    public function getMotivoRetiro()
    {
        return $this->motivo_retiro;
    }

    /**
     * Set es_resposable
     *
     * @param boolean $esResposable
     * @return Alumno
     */
    public function setEsResposable($esResposable)
    {
        $this->es_resposable = $esResposable;

        return $this;
    }

    /**
     * Get es_resposable
     *
     * @return boolean 
     */
    public function getEsResposable()
    {
        return $this->es_resposable;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     * @return Alumno
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
     * Set jornada
     *
     * @param integer $jornada
     * @return Alumno
     */
    public function setJornada($jornada)
    {
        $this->jornada = $jornada;

        return $this;
    }

    /**
     * Get jornada
     *
     * @return integer 
     */
    public function getJornada()
    {
        return $this->jornada;
    }

    /**
     * Set subsidiado
     *
     * @param integer $subsidiado
     * @return Alumno
     */
    public function setSubsidiado($subsidiado)
    {
        $this->subsidiado = $subsidiado;

        return $this;
    }

    /**
     * Get subsidiado
     *
     * @return integer 
     */
    public function getSubsidiado()
    {
        return $this->subsidiado;
    }

    /**
     * Set alumno_madre_cabeza_familia
     *
     * @param integer $alumnoMadreCabezaFamilia
     * @return Alumno
     */
    public function setAlumnoMadreCabezaFamilia($alumnoMadreCabezaFamilia)
    {
        $this->alumno_madre_cabeza_familia = $alumnoMadreCabezaFamilia;

        return $this;
    }

    /**
     * Get alumno_madre_cabeza_familia
     *
     * @return integer 
     */
    public function getAlumnoMadreCabezaFamilia()
    {
        return $this->alumno_madre_cabeza_familia;
    }

    /**
     * Set beneficiario_madre_cabeza_familia
     *
     * @param integer $beneficiarioMadreCabezaFamilia
     * @return Alumno
     */
    public function setBeneficiarioMadreCabezaFamilia($beneficiarioMadreCabezaFamilia)
    {
        $this->beneficiario_madre_cabeza_familia = $beneficiarioMadreCabezaFamilia;

        return $this;
    }

    /**
     * Get beneficiario_madre_cabeza_familia
     *
     * @return integer 
     */
    public function getBeneficiarioMadreCabezaFamilia()
    {
        return $this->beneficiario_madre_cabeza_familia;
    }

    /**
     * Set beneficiario_veterano_militar
     *
     * @param integer $beneficiarioVeteranoMilitar
     * @return Alumno
     */
    public function setBeneficiarioVeteranoMilitar($beneficiarioVeteranoMilitar)
    {
        $this->beneficiario_veterano_militar = $beneficiarioVeteranoMilitar;

        return $this;
    }

    /**
     * Get beneficiario_veterano_militar
     *
     * @return integer 
     */
    public function getBeneficiarioVeteranoMilitar()
    {
        return $this->beneficiario_veterano_militar;
    }

    /**
     * Set beneficiario_heroes_nacion
     *
     * @param integer $beneficiarioHeroesNacion
     * @return Alumno
     */
    public function setBeneficiarioHeroesNacion($beneficiarioHeroesNacion)
    {
        $this->beneficiario_heroes_nacion = $beneficiarioHeroesNacion;

        return $this;
    }

    /**
     * Get beneficiario_heroes_nacion
     *
     * @return integer 
     */
    public function getBeneficiarioHeroesNacion()
    {
        return $this->beneficiario_heroes_nacion;
    }

    /**
     * Set situacion_academica_ano_anterior
     *
     * @param integer $situacionAcademicaAnoAnterior
     * @return Alumno
     */
    public function setSituacionAcademicaAnoAnterior($situacionAcademicaAnoAnterior)
    {
        $this->situacion_academica_ano_anterior = $situacionAcademicaAnoAnterior;

        return $this;
    }

    /**
     * Get situacion_academica_ano_anterior
     *
     * @return integer 
     */
    public function getSituacionAcademicaAnoAnterior()
    {
        return $this->situacion_academica_ano_anterior;
    }

    /**
     * Set condicion_finalizar_ano_anterior
     *
     * @param integer $condicionFinalizarAnoAnterior
     * @return Alumno
     */
    public function setCondicionFinalizarAnoAnterior($condicionFinalizarAnoAnterior)
    {
        $this->condicion_finalizar_ano_anterior = $condicionFinalizarAnoAnterior;

        return $this;
    }

    /**
     * Get condicion_finalizar_ano_anterior
     *
     * @return integer 
     */
    public function getCondicionFinalizarAnoAnterior()
    {
        return $this->condicion_finalizar_ano_anterior;
    }

    /**
     * Set repitente
     *
     * @param integer $repitente
     * @return Alumno
     */
    public function setRepitente($repitente)
    {
        $this->repitente = $repitente;

        return $this;
    }

    /**
     * Get repitente
     *
     * @return integer 
     */
    public function getRepitente()
    {
        return $this->repitente;
    }

    /**
     * Set es_nuevo
     *
     * @param integer $esNuevo
     * @return Alumno
     */
    public function setEsNuevo($esNuevo)
    {
        $this->es_nuevo = $esNuevo;

        return $this;
    }

    /**
     * Get es_nuevo
     *
     * @return integer 
     */
    public function getEsNuevo()
    {
        return $this->es_nuevo;
    }

    /**
     * Set es_habilitacion
     *
     * @param integer $esHabilitacion
     * @return Alumno
     */
    public function setEsHabilitacion($esHabilitacion)
    {
        $this->es_habilitacion = $esHabilitacion;

        return $this;
    }

    /**
     * Get es_habilitacion
     *
     * @return integer 
     */
    public function getEsHabilitacion()
    {
        return $this->es_habilitacion;
    }

    /**
     * Set posicion_academica
     *
     * @param integer $posicionAcademica
     * @return Alumno
     */
    public function setPosicionAcademica($posicionAcademica)
    {
        $this->posicion_academica = $posicionAcademica;

        return $this;
    }

    /**
     * Get posicion_academica
     *
     * @return integer 
     */
    public function getPosicionAcademica()
    {
        return $this->posicion_academica;
    }

    /**
     * Set es_recuperacion
     *
     * @param integer $esRecuperacion
     * @return Alumno
     */
    public function setEsRecuperacion($esRecuperacion)
    {
        $this->es_recuperacion = $esRecuperacion;

        return $this;
    }

    /**
     * Get es_recuperacion
     *
     * @return integer 
     */
    public function getEsRecuperacion()
    {
        return $this->es_recuperacion;
    }

    /**
     * Set tiene_novedad
     *
     * @param integer $tieneNovedad
     * @return Alumno
     */
    public function setTieneNovedad($tieneNovedad)
    {
        $this->tiene_novedad = $tieneNovedad;

        return $this;
    }

    /**
     * Get tiene_novedad
     *
     * @return integer 
     */
    public function getTieneNovedad()
    {
        return $this->tiene_novedad;
    }

    /**
     * Set es_adicion
     *
     * @param integer $esAdicion
     * @return Alumno
     */
    public function setEsAdicion($esAdicion)
    {
        $this->es_adicion = $esAdicion;

        return $this;
    }

    /**
     * Get es_adicion
     *
     * @return integer 
     */
    public function getEsAdicion()
    {
        return $this->es_adicion;
    }

    /**
     * Set grupo
     *
     * @param \Netpublic\CoreBundle\Entity\Grupo $grupo
     * @return Alumno
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
     * Set grupo_promovido
     *
     * @param \Netpublic\CoreBundle\Entity\Grupo $grupoPromovido
     * @return Alumno
     */
    public function setGrupoPromovido(\Netpublic\CoreBundle\Entity\Grupo $grupoPromovido = null)
    {
        $this->grupo_promovido = $grupoPromovido;

        return $this;
    }

    /**
     * Get grupo_promovido
     *
     * @return \Netpublic\CoreBundle\Entity\Grupo 
     */
    public function getGrupoPromovido()
    {
        return $this->grupo_promovido;
    }

    /**
     * Set grado
     *
     * @param \Netpublic\CoreBundle\Entity\Grado $grado
     * @return Alumno
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
     * Add nota
     *
     * @param \Netpublic\CoreBundle\Entity\AlumnoDimension $nota
     * @return Alumno
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
     * @return Alumno
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
     * Add matricula_alumno
     *
     * @param \Netpublic\CoreBundle\Entity\MatriculaAlumno $matriculaAlumno
     * @return Alumno
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
     * Set departamento
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $departamento
     * @return Alumno
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
     * @return Alumno
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
     * Set depto_nacimiento
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $deptoNacimiento
     * @return Alumno
     */
    public function setDeptoNacimiento(\Netpublic\CoreBundle\Entity\ValorVariable $deptoNacimiento = null)
    {
        $this->depto_nacimiento = $deptoNacimiento;

        return $this;
    }

    /**
     * Get depto_nacimiento
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getDeptoNacimiento()
    {
        return $this->depto_nacimiento;
    }

    /**
     * Set municipio_nacimiento
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $municipioNacimiento
     * @return Alumno
     */
    public function setMunicipioNacimiento(\Netpublic\CoreBundle\Entity\ValorVariable $municipioNacimiento = null)
    {
        $this->municipio_nacimiento = $municipioNacimiento;

        return $this;
    }

    /**
     * Get municipio_nacimiento
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getMunicipioNacimiento()
    {
        return $this->municipio_nacimiento;
    }

    /**
     * Set depto_ubicacion
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $deptoUbicacion
     * @return Alumno
     */
    public function setDeptoUbicacion(\Netpublic\CoreBundle\Entity\ValorVariable $deptoUbicacion = null)
    {
        $this->depto_ubicacion = $deptoUbicacion;

        return $this;
    }

    /**
     * Get depto_ubicacion
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getDeptoUbicacion()
    {
        return $this->depto_ubicacion;
    }

    /**
     * Set municipio_ubicacion
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $municipioUbicacion
     * @return Alumno
     */
    public function setMunicipioUbicacion(\Netpublic\CoreBundle\Entity\ValorVariable $municipioUbicacion = null)
    {
        $this->municipio_ubicacion = $municipioUbicacion;

        return $this;
    }

    /**
     * Get municipio_ubicacion
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getMunicipioUbicacion()
    {
        return $this->municipio_ubicacion;
    }

    /**
     * Set ultimo_depto_expulsor
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $ultimoDeptoExpulsor
     * @return Alumno
     */
    public function setUltimoDeptoExpulsor(\Netpublic\CoreBundle\Entity\ValorVariable $ultimoDeptoExpulsor = null)
    {
        $this->ultimo_depto_expulsor = $ultimoDeptoExpulsor;

        return $this;
    }

    /**
     * Get ultimo_depto_expulsor
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getUltimoDeptoExpulsor()
    {
        return $this->ultimo_depto_expulsor;
    }

    /**
     * Set acudiente
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $acudiente
     * @return Alumno
     */
    public function setAcudiente(\Netpublic\CoreBundle\Entity\Alumno $acudiente = null)
    {
        $this->acudiente = $acudiente;

        return $this;
    }

    /**
     * Get acudiente
     *
     * @return \Netpublic\CoreBundle\Entity\Alumno 
     */
    public function getAcudiente()
    {
        return $this->acudiente;
    }

    /**
     * Set padre
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $padre
     * @return Alumno
     */
    public function setPadre(\Netpublic\CoreBundle\Entity\Alumno $padre = null)
    {
        $this->padre = $padre;

        return $this;
    }

    /**
     * Get padre
     *
     * @return \Netpublic\CoreBundle\Entity\Alumno 
     */
    public function getPadre()
    {
        return $this->padre;
    }

    /**
     * Set madre
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $madre
     * @return Alumno
     */
    public function setMadre(\Netpublic\CoreBundle\Entity\Alumno $madre = null)
    {
        $this->madre = $madre;

        return $this;
    }

    /**
     * Get madre
     *
     * @return \Netpublic\CoreBundle\Entity\Alumno 
     */
    public function getMadre()
    {
        return $this->madre;
    }

    /**
     * Add alumno_acudiente
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $alumnoAcudiente
     * @return Alumno
     */
    public function addAlumnoAcudiente(\Netpublic\CoreBundle\Entity\Alumno $alumnoAcudiente)
    {
        $this->alumno_acudiente[] = $alumnoAcudiente;

        return $this;
    }

    /**
     * Remove alumno_acudiente
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $alumnoAcudiente
     */
    public function removeAlumnoAcudiente(\Netpublic\CoreBundle\Entity\Alumno $alumnoAcudiente)
    {
        $this->alumno_acudiente->removeElement($alumnoAcudiente);
    }

    /**
     * Get alumno_acudiente
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAlumnoAcudiente()
    {
        return $this->alumno_acudiente;
    }

    /**
     * Set usuario
     *
     * @param \Netpublic\CoreBundle\Entity\Usuario $usuario
     * @return Alumno
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
     * Set sede
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $sede
     * @return Alumno
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
     * @return Alumno
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
     * Add nivel_academico
     *
     * @param \Netpublic\CoreBundle\Entity\NivelAcademico $nivelAcademico
     * @return Alumno
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
     * Add solicitud
     *
     * @param \Netpublic\CoreBundle\Entity\ProfesorSolicitud $solicitud
     * @return Alumno
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
     * Add alumno_cursado
     *
     * @param \Netpublic\CoreBundle\Entity\Anoescolargrado $alumnoCursado
     * @return Alumno
     */
    public function addAlumnoCursado(\Netpublic\CoreBundle\Entity\Anoescolargrado $alumnoCursado)
    {
        $this->alumno_cursado[] = $alumnoCursado;

        return $this;
    }

    /**
     * Remove alumno_cursado
     *
     * @param \Netpublic\CoreBundle\Entity\Anoescolargrado $alumnoCursado
     */
    public function removeAlumnoCursado(\Netpublic\CoreBundle\Entity\Anoescolargrado $alumnoCursado)
    {
        $this->alumno_cursado->removeElement($alumnoCursado);
    }

    /**
     * Get alumno_cursado
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAlumnoCursado()
    {
        return $this->alumno_cursado;
    }

    /**
     * Add pregunta_alumno
     *
     * @param \Netpublic\RedsaberBundle\Entity\Pregunta $preguntaAlumno
     * @return Alumno
     */
    public function addPreguntaAlumno(\Netpublic\RedsaberBundle\Entity\Pregunta $preguntaAlumno)
    {
        $this->pregunta_alumno[] = $preguntaAlumno;

        return $this;
    }

    /**
     * Remove pregunta_alumno
     *
     * @param \Netpublic\RedsaberBundle\Entity\Pregunta $preguntaAlumno
     */
    public function removePreguntaAlumno(\Netpublic\RedsaberBundle\Entity\Pregunta $preguntaAlumno)
    {
        $this->pregunta_alumno->removeElement($preguntaAlumno);
    }

    /**
     * Get pregunta_alumno
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPreguntaAlumno()
    {
        return $this->pregunta_alumno;
    }
}
