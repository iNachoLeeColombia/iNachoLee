<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Colegio
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Netpublic\CoreBundle\Util\Util;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="colegio")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\ColegioRepository")
 */
class Colegio {
     /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
     /**
     *
     * @ORM\Column(type="string")
     */
    protected $nombre;
     /**
     *
     * @ORM\Column(type="string",nullable=true)
     */
    protected $slug;
     /**
     *
     * @ORM\Column(type="string",nullable=true)
     */
    protected $codigo_dane;
    /**
    * @ORM\ManyToOne(targetEntity="Profesor",inversedBy="colegio")    
    */    
    protected $rector;
    /**
    * @ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_sector")    
    */    
    protected $sector;
    /**
    * @ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_calendario")    
    */    

    protected $calendario; 
    /**
    * @ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_propiedad_juridica")    
    */    

    protected $propiedad_juridica;  
     /**
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $numero_sedes; 
    /**
    * @ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_nucleo")    
    */    
    protected $nucleo;   
    /**
    * @ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_genero")    
    */    

    protected $genero;  
     /**     
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $es_subsidio; 
    /**
    * @ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_discapacidades")    
    */    
    protected $discapacidades; 
    /**
    * @ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_capacidades_excepcionales")    
    */    
    protected $capacidades_excepcionales;    
    /**
    * @ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_etnias")    
    */    

    protected $etnias;
    /**
    * @ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_resguardo")    
    */    

    protected $resguardo;
    /**
    * @ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_novedad_inst")    
    */    
    protected $novedad_inst;
    /**
    * @ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_metodologia")    
    */    

    protected $metodologia;  
    /**
    * @ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_zona")    
    */    
    protected $zona;    
     /**
     *    
     * @ORM\Column(type="string",nullable=true)
     */
    protected $barrio; 
     /**
     *
     * @ORM\Column(type="string",nullable=true)
     */
    protected $direccion;     
    /**
    * @ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_depto")    
    */    
    protected $depto;
    /**
    * @ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_municipio")    
    */    

    protected $municipio;   
     /**
     *
     * @ORM\Column(type="string",nullable=true)
     */
    protected $telefono; 
     /**
     *
     * @ORM\Column(type="string",nullable=true)
     */
    protected $fax; 
     /**
     *
     * @ORM\Column(type="string",nullable=true)
     */
    protected $web; 
        
     /**
     *
     * @ORM\Column(type="string",nullable=true)
     */
    protected $email; 
     /**
     *
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $es_principal;   
     /**
     *
     * @ORM\Column(type="string",nullable=true)
     */
    protected $numero_linc_func;     
     /**
     *
     * @ORM\Column(type="string",nullable=true)
     */
    protected $resolucion;         
    /**
    * @ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_regimen_costos")    
    */    
    protected $regimen_costos;
    /**
    * @ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_rango_promedio")    
    */    

    protected $rango_promedio;    
    /**
    * @ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_idioma")    
    */    
    protected $idioma;    
    
    /**
    * @ORM\ManyToOne(targetEntity="ValorVariable",inversedBy="v_nucle_privado")    
    */    

    protected $nucleo_privado;                 
     /**
     *
     * @ORM\Column(type="float",nullable=true)
     */
    protected $nota_minima;
     /**
     *
      * TIPO_VALORACION:
      * TIPO 0: De 0 5
      * TIPO 1: De 0-10
      * TIPO 2: Letras BUENO ,MALO,
      * TIPO 3: Carita FEliz
      * 
      * 
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $tipo_valoracion; 
     /**
     *
     * @ORM\Column(type="float",nullable=true)
     */
    protected $valor_minimo_deficiente;   
    /**
     *
     * @ORM\Column(type="float",nullable=true)
     */
    protected $valor_maximo_deficiente;   
/**
     *
     * @ORM\Column(type="float",nullable=true)
     */
    protected $valor_minimo_insuficiente;   
    /**
     *
     * @ORM\Column(type="float",nullable=true)
     */
    protected $valor_maximo_insuficiente;   
/**
     *
     * @ORM\Column(type="float",nullable=true)
     */
    protected $valor_minimo_aceptable;   
    /**
     *
     * @ORM\Column(type="float",nullable=true)
     */
    protected $valor_maximo_aceptable;   
   /**
     *
     * @ORM\Column(type="float",nullable=true)
     */
    protected $valor_minimo_sobresaliente;   
    /**
     *
     * @ORM\Column(type="float",nullable=true)
     */
    protected $valor_maximo_sobresaliente;   
/**
     *
     * @ORM\Column(type="float",nullable=true)
     */
    protected $valor_minimo_excelente;   
    /**
     *
     * @ORM\Column(type="float",nullable=true)
     */
    protected $valor_maximo_excelente;   
    /**
     *
     * @ORM\Column(type="text",nullable=true)
     */
    protected $himno_colegio;
    /**
     * @Assert\File(
     *     maxSize = "5M",
     *     maxSizeMessage = "Tu foto esta muy grande."     
     * )
     */

    private $escudo_colegio;
    /**
    * @ORM\OneToMany(targetEntity="Alumno",mappedBy="sede")      
    */    
    protected $alumno;
    /**
    * @ORM\OneToMany(targetEntity="Profesor",mappedBy="sede")      
    */    
    protected $profesor;   
   /**
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $numero_certificados;   
   /**
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $numero_areas_minimo;   
   /**
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $maximo_areas_habilitar;   
     /**
      *
      * @ORM\Column(type="integer",nullable=true)
     */
    protected $numero_cifrasignificativa; 
     /**
      *
      * @ORM\Column(type="integer",nullable=true)
     */
    protected $valor_defecto; 
     /**
      *
      * @ORM\Column(type="integer",nullable=true)
     */
    protected $plantilla_boletin_preescolar; 
     /**
      *
      * @ORM\Column(type="integer",nullable=true)
     */
    protected $plantilla_boletin_basica_primaria; 
     /**
      *
      * @ORM\Column(type="integer",nullable=true)
     */
    protected $plantilla_boletin_basica_secundaria; 
     /**
      *
      * @ORM\Column(type="integer",nullable=true)
     */
    protected $plantilla_boletin_media; 
     /**
      *
      * @ORM\Column(type="integer",nullable=true)
     */
    protected $nro_clases_dia; 
     /**
      *
      * @ORM\Column(type="boolean",nullable=true)
     */
    protected $es_aulafija; 
     /**
      *
      * @ORM\Column(type="integer",nullable=true)
     */
    protected $nro_diasentremismaclase; 
    
    /**
    * @ORM\OneToMany(targetEntity="CondicionCargaacademicacolegio",mappedBy="colegio")      
    */    
    protected $condicion_horario_clase;   
    /**
    * @ORM\OneToMany(targetEntity="Auditoria",mappedBy="sede")      
    */    
   protected $auditoria;
    /**
    * @ORM\ManyToOne(targetEntity="Dimension",inversedBy="v1")    
    */    

    protected $ano_siguiente;    
    /**
    * @ORM\ManyToOne(targetEntity="Dimension",inversedBy="v2")    
    */    

    protected $ano_anterior;    
    /**
    * @ORM\OneToMany(targetEntity="Netpublic\RedsaberBundle\Entity\BancoPregunta",mappedBy="dueno_institucion")      
    */    
    protected $banco_pregunta;
     /**
     *    
     * @ORM\Column(type="string",nullable=true)
     */
    protected $nombre_corto; 
    
    public function __toString(){
        return $this->nombre;
    }

   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->alumno = new \Doctrine\Common\Collections\ArrayCollection();
        $this->profesor = new \Doctrine\Common\Collections\ArrayCollection();
        $this->condicion_horario_clase = new \Doctrine\Common\Collections\ArrayCollection();
        $this->auditoria = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Colegio
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
     * Set slug
     *
     * @param string $slug
     * @return Colegio
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set codigo_dane
     *
     * @param string $codigoDane
     * @return Colegio
     */
    public function setCodigoDane($codigoDane)
    {
        $this->codigo_dane = $codigoDane;

        return $this;
    }

    /**
     * Get codigo_dane
     *
     * @return string 
     */
    public function getCodigoDane()
    {
        return $this->codigo_dane;
    }

    /**
     * Set numero_sedes
     *
     * @param integer $numeroSedes
     * @return Colegio
     */
    public function setNumeroSedes($numeroSedes)
    {
        $this->numero_sedes = $numeroSedes;

        return $this;
    }

    /**
     * Get numero_sedes
     *
     * @return integer 
     */
    public function getNumeroSedes()
    {
        return $this->numero_sedes;
    }

    /**
     * Set es_subsidio
     *
     * @param boolean $esSubsidio
     * @return Colegio
     */
    public function setEsSubsidio($esSubsidio)
    {
        $this->es_subsidio = $esSubsidio;

        return $this;
    }

    /**
     * Get es_subsidio
     *
     * @return boolean 
     */
    public function getEsSubsidio()
    {
        return $this->es_subsidio;
    }
    /**
     * Get es_subsidio
     *
     * @return boolean 
     */
    public function getEscudoColegio()
    {
        return $this->escudo_colegio;
    }
/**
     * Get es_subsidio
     *
     * @return boolean 
     */
    public function setEscudoColegio($escudo)
    {
        return $this->escudo_colegio=$escudo;
    }

    /**
     * Set barrio
     *
     * @param string $barrio
     * @return Colegio
     */
    public function setBarrio($barrio)
    {
        $this->barrio = $barrio;

        return $this;
    }

    /**
     * Get barrio
     *
     * @return string 
     */
    public function getBarrio()
    {
        return $this->barrio;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Colegio
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Colegio
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
     * Set fax
     *
     * @param string $fax
     * @return Colegio
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set web
     *
     * @param string $web
     * @return Colegio
     */
    public function setWeb($web)
    {
        $this->web = $web;

        return $this;
    }

    /**
     * Get web
     *
     * @return string 
     */
    public function getWeb()
    {
        return $this->web;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Colegio
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
     * Set es_principal
     *
     * @param boolean $esPrincipal
     * @return Colegio
     */
    public function setEsPrincipal($esPrincipal)
    {
        $this->es_principal = $esPrincipal;

        return $this;
    }

    /**
     * Get es_principal
     *
     * @return boolean 
     */
    public function getEsPrincipal()
    {
        return $this->es_principal;
    }

    /**
     * Set numero_linc_func
     *
     * @param string $numeroLincFunc
     * @return Colegio
     */
    public function setNumeroLincFunc($numeroLincFunc)
    {
        $this->numero_linc_func = $numeroLincFunc;

        return $this;
    }

    /**
     * Get numero_linc_func
     *
     * @return string 
     */
    public function getNumeroLincFunc()
    {
        return $this->numero_linc_func;
    }

    /**
     * Set resolucion
     *
     * @param string $resolucion
     * @return Colegio
     */
    public function setResolucion($resolucion)
    {
        $this->resolucion = $resolucion;

        return $this;
    }

    /**
     * Get resolucion
     *
     * @return string 
     */
    public function getResolucion()
    {
        return $this->resolucion;
    }

    /**
     * Set nota_minima
     *
     * @param float $notaMinima
     * @return Colegio
     */
    public function setNotaMinima($notaMinima)
    {
        $this->nota_minima = $notaMinima;

        return $this;
    }

    /**
     * Get nota_minima
     *
     * @return float 
     */
    public function getNotaMinima()
    {
        return $this->nota_minima;
    }

    /**
     * Set tipo_valoracion
     *
     * @param integer $tipoValoracion
     * @return Colegio
     */
    public function setTipoValoracion($tipoValoracion)
    {
        $this->tipo_valoracion = $tipoValoracion;

        return $this;
    }

    /**
     * Get tipo_valoracion
     *
     * @return integer 
     */
    public function getTipoValoracion()
    {
        return $this->tipo_valoracion;
    }

    /**
     * Set valor_minimo_deficiente
     *
     * @param float $valorMinimoDeficiente
     * @return Colegio
     */
    public function setValorMinimoDeficiente($valorMinimoDeficiente)
    {
        $this->valor_minimo_deficiente = $valorMinimoDeficiente;

        return $this;
    }

    /**
     * Get valor_minimo_deficiente
     *
     * @return float 
     */
    public function getValorMinimoDeficiente()
    {
        return $this->valor_minimo_deficiente;
    }

    /**
     * Set valor_maximo_deficiente
     *
     * @param float $valorMaximoDeficiente
     * @return Colegio
     */
    public function setValorMaximoDeficiente($valorMaximoDeficiente)
    {
        $this->valor_maximo_deficiente = $valorMaximoDeficiente;

        return $this;
    }

    /**
     * Get valor_maximo_deficiente
     *
     * @return float 
     */
    public function getValorMaximoDeficiente()
    {
        return $this->valor_maximo_deficiente;
    }

    /**
     * Set valor_minimo_insuficiente
     *
     * @param float $valorMinimoInsuficiente
     * @return Colegio
     */
    public function setValorMinimoInsuficiente($valorMinimoInsuficiente)
    {
        $this->valor_minimo_insuficiente = $valorMinimoInsuficiente;

        return $this;
    }

    /**
     * Get valor_minimo_insuficiente
     *
     * @return float 
     */
    public function getValorMinimoInsuficiente()
    {
        return $this->valor_minimo_insuficiente;
    }

    /**
     * Set valor_maximo_insuficiente
     *
     * @param float $valorMaximoInsuficiente
     * @return Colegio
     */
    public function setValorMaximoInsuficiente($valorMaximoInsuficiente)
    {
        $this->valor_maximo_insuficiente = $valorMaximoInsuficiente;

        return $this;
    }

    /**
     * Get valor_maximo_insuficiente
     *
     * @return float 
     */
    public function getValorMaximoInsuficiente()
    {
        return $this->valor_maximo_insuficiente;
    }

    /**
     * Set valor_minimo_aceptable
     *
     * @param float $valorMinimoAceptable
     * @return Colegio
     */
    public function setValorMinimoAceptable($valorMinimoAceptable)
    {
        $this->valor_minimo_aceptable = $valorMinimoAceptable;

        return $this;
    }

    /**
     * Get valor_minimo_aceptable
     *
     * @return float 
     */
    public function getValorMinimoAceptable()
    {
        return $this->valor_minimo_aceptable;
    }

    /**
     * Set valor_maximo_aceptable
     *
     * @param float $valorMaximoAceptable
     * @return Colegio
     */
    public function setValorMaximoAceptable($valorMaximoAceptable)
    {
        $this->valor_maximo_aceptable = $valorMaximoAceptable;

        return $this;
    }

    /**
     * Get valor_maximo_aceptable
     *
     * @return float 
     */
    public function getValorMaximoAceptable()
    {
        return $this->valor_maximo_aceptable;
    }

    /**
     * Set valor_minimo_sobresaliente
     *
     * @param float $valorMinimoSobresaliente
     * @return Colegio
     */
    public function setValorMinimoSobresaliente($valorMinimoSobresaliente)
    {
        $this->valor_minimo_sobresaliente = $valorMinimoSobresaliente;

        return $this;
    }

    /**
     * Get valor_minimo_sobresaliente
     *
     * @return float 
     */
    public function getValorMinimoSobresaliente()
    {
        return $this->valor_minimo_sobresaliente;
    }

    /**
     * Set valor_maximo_sobresaliente
     *
     * @param float $valorMaximoSobresaliente
     * @return Colegio
     */
    public function setValorMaximoSobresaliente($valorMaximoSobresaliente)
    {
        $this->valor_maximo_sobresaliente = $valorMaximoSobresaliente;

        return $this;
    }

    /**
     * Get valor_maximo_sobresaliente
     *
     * @return float 
     */
    public function getValorMaximoSobresaliente()
    {
        return $this->valor_maximo_sobresaliente;
    }

    /**
     * Set valor_minimo_excelente
     *
     * @param float $valorMinimoExcelente
     * @return Colegio
     */
    public function setValorMinimoExcelente($valorMinimoExcelente)
    {
        $this->valor_minimo_excelente = $valorMinimoExcelente;

        return $this;
    }

    /**
     * Get valor_minimo_excelente
     *
     * @return float 
     */
    public function getValorMinimoExcelente()
    {
        return $this->valor_minimo_excelente;
    }

    /**
     * Set valor_maximo_excelente
     *
     * @param float $valorMaximoExcelente
     * @return Colegio
     */
    public function setValorMaximoExcelente($valorMaximoExcelente)
    {
        $this->valor_maximo_excelente = $valorMaximoExcelente;

        return $this;
    }

    /**
     * Get valor_maximo_excelente
     *
     * @return float 
     */
    public function getValorMaximoExcelente()
    {
        return $this->valor_maximo_excelente;
    }

    /**
     * Set himno_colegio
     *
     * @param string $himnoColegio
     * @return Colegio
     */
    public function setHimnoColegio($himnoColegio)
    {
        $this->himno_colegio = $himnoColegio;

        return $this;
    }

    /**
     * Get himno_colegio
     *
     * @return string 
     */
    public function getHimnoColegio()
    {
        return $this->himno_colegio;
    }

    /**
     * Set numero_certificados
     *
     * @param integer $numeroCertificados
     * @return Colegio
     */
    public function setNumeroCertificados($numeroCertificados)
    {
        $this->numero_certificados = $numeroCertificados;

        return $this;
    }

    /**
     * Get numero_certificados
     *
     * @return integer 
     */
    public function getNumeroCertificados()
    {
        return $this->numero_certificados;
    }

    /**
     * Set numero_areas_minimo
     *
     * @param integer $numeroAreasMinimo
     * @return Colegio
     */
    public function setNumeroAreasMinimo($numeroAreasMinimo)
    {
        $this->numero_areas_minimo = $numeroAreasMinimo;

        return $this;
    }

    /**
     * Get numero_areas_minimo
     *
     * @return integer 
     */
    public function getNumeroAreasMinimo()
    {
        return $this->numero_areas_minimo;
    }

    /**
     * Set maximo_areas_habilitar
     *
     * @param integer $maximoAreasHabilitar
     * @return Colegio
     */
    public function setMaximoAreasHabilitar($maximoAreasHabilitar)
    {
        $this->maximo_areas_habilitar = $maximoAreasHabilitar;

        return $this;
    }

    /**
     * Get maximo_areas_habilitar
     *
     * @return integer 
     */
    public function getMaximoAreasHabilitar()
    {
        return $this->maximo_areas_habilitar;
    }

    /**
     * Set numero_cifrasignificativa
     *
     * @param integer $numeroCifrasignificativa
     * @return Colegio
     */
    public function setNumeroCifrasignificativa($numeroCifrasignificativa)
    {
        $this->numero_cifrasignificativa = $numeroCifrasignificativa;

        return $this;
    }

    /**
     * Get numero_cifrasignificativa
     *
     * @return integer 
     */
    public function getNumeroCifrasignificativa()
    {
        return $this->numero_cifrasignificativa;
    }

    /**
     * Set valor_defecto
     *
     * @param integer $valorDefecto
     * @return Colegio
     */
    public function setValorDefecto($valorDefecto)
    {
        $this->valor_defecto = $valorDefecto;

        return $this;
    }

    /**
     * Get valor_defecto
     *
     * @return integer 
     */
    public function getValorDefecto()
    {
        return $this->valor_defecto;
    }

    /**
     * Set plantilla_boletin_preescolar
     *
     * @param integer $plantillaBoletinPreescolar
     * @return Colegio
     */
    public function setPlantillaBoletinPreescolar($plantillaBoletinPreescolar)
    {
        $this->plantilla_boletin_preescolar = $plantillaBoletinPreescolar;

        return $this;
    }

    /**
     * Get plantilla_boletin_preescolar
     *
     * @return integer 
     */
    public function getPlantillaBoletinPreescolar()
    {
        return $this->plantilla_boletin_preescolar;
    }

    /**
     * Set plantilla_boletin_basica_primaria
     *
     * @param integer $plantillaBoletinBasicaPrimaria
     * @return Colegio
     */
    public function setPlantillaBoletinBasicaPrimaria($plantillaBoletinBasicaPrimaria)
    {
        $this->plantilla_boletin_basica_primaria = $plantillaBoletinBasicaPrimaria;

        return $this;
    }

    /**
     * Get plantilla_boletin_basica_primaria
     *
     * @return integer 
     */
    public function getPlantillaBoletinBasicaPrimaria()
    {
        return $this->plantilla_boletin_basica_primaria;
    }

    /**
     * Set plantilla_boletin_basica_secundaria
     *
     * @param integer $plantillaBoletinBasicaSecundaria
     * @return Colegio
     */
    public function setPlantillaBoletinBasicaSecundaria($plantillaBoletinBasicaSecundaria)
    {
        $this->plantilla_boletin_basica_secundaria = $plantillaBoletinBasicaSecundaria;

        return $this;
    }

    /**
     * Get plantilla_boletin_basica_secundaria
     *
     * @return integer 
     */
    public function getPlantillaBoletinBasicaSecundaria()
    {
        return $this->plantilla_boletin_basica_secundaria;
    }

    /**
     * Set plantilla_boletin_media
     *
     * @param integer $plantillaBoletinMedia
     * @return Colegio
     */
    public function setPlantillaBoletinMedia($plantillaBoletinMedia)
    {
        $this->plantilla_boletin_media = $plantillaBoletinMedia;

        return $this;
    }

    /**
     * Get plantilla_boletin_media
     *
     * @return integer 
     */
    public function getPlantillaBoletinMedia()
    {
        return $this->plantilla_boletin_media;
    }

    /**
     * Set nro_clases_dia
     *
     * @param integer $nroClasesDia
     * @return Colegio
     */
    public function setNroClasesDia($nroClasesDia)
    {
        $this->nro_clases_dia = $nroClasesDia;

        return $this;
    }

    /**
     * Get nro_clases_dia
     *
     * @return integer 
     */
    public function getNroClasesDia()
    {
        return $this->nro_clases_dia;
    }

    /**
     * Set es_aulafija
     *
     * @param boolean $esAulafija
     * @return Colegio
     */
    public function setEsAulafija($esAulafija)
    {
        $this->es_aulafija = $esAulafija;

        return $this;
    }

    /**
     * Get es_aulafija
     *
     * @return boolean 
     */
    public function getEsAulafija()
    {
        return $this->es_aulafija;
    }

    /**
     * Set nro_diasentremismaclase
     *
     * @param integer $nroDiasentremismaclase
     * @return Colegio
     */
    public function setNroDiasentremismaclase($nroDiasentremismaclase)
    {
        $this->nro_diasentremismaclase = $nroDiasentremismaclase;

        return $this;
    }

    /**
     * Get nro_diasentremismaclase
     *
     * @return integer 
     */
    public function getNroDiasentremismaclase()
    {
        return $this->nro_diasentremismaclase;
    }

    /**
     * Set rector
     *
     * @param \Netpublic\CoreBundle\Entity\Profesor $rector
     * @return Colegio
     */
    public function setRector(\Netpublic\CoreBundle\Entity\Profesor $rector = null)
    {
        $this->rector = $rector;

        return $this;
    }

    /**
     * Get rector
     *
     * @return \Netpublic\CoreBundle\Entity\Profesor 
     */
    public function getRector()
    {
        return $this->rector;
    }

    /**
     * Set sector
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $sector
     * @return Colegio
     */
    public function setSector(\Netpublic\CoreBundle\Entity\ValorVariable $sector = null)
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * Get sector
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * Set calendario
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $calendario
     * @return Colegio
     */
    public function setCalendario(\Netpublic\CoreBundle\Entity\ValorVariable $calendario = null)
    {
        $this->calendario = $calendario;

        return $this;
    }

    /**
     * Get calendario
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getCalendario()
    {
        return $this->calendario;
    }

    /**
     * Set propiedad_juridica
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $propiedadJuridica
     * @return Colegio
     */
    public function setPropiedadJuridica(\Netpublic\CoreBundle\Entity\ValorVariable $propiedadJuridica = null)
    {
        $this->propiedad_juridica = $propiedadJuridica;

        return $this;
    }

    /**
     * Get propiedad_juridica
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getPropiedadJuridica()
    {
        return $this->propiedad_juridica;
    }

    /**
     * Set nucleo
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $nucleo
     * @return Colegio
     */
    public function setNucleo(\Netpublic\CoreBundle\Entity\ValorVariable $nucleo = null)
    {
        $this->nucleo = $nucleo;

        return $this;
    }

    /**
     * Get nucleo
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getNucleo()
    {
        return $this->nucleo;
    }

    /**
     * Set genero
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $genero
     * @return Colegio
     */
    public function setGenero(\Netpublic\CoreBundle\Entity\ValorVariable $genero = null)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set discapacidades
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $discapacidades
     * @return Colegio
     */
    public function setDiscapacidades(\Netpublic\CoreBundle\Entity\ValorVariable $discapacidades = null)
    {
        $this->discapacidades = $discapacidades;

        return $this;
    }

    /**
     * Get discapacidades
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getDiscapacidades()
    {
        return $this->discapacidades;
    }

    /**
     * Set capacidades_excepcionales
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $capacidadesExcepcionales
     * @return Colegio
     */
    public function setCapacidadesExcepcionales(\Netpublic\CoreBundle\Entity\ValorVariable $capacidadesExcepcionales = null)
    {
        $this->capacidades_excepcionales = $capacidadesExcepcionales;

        return $this;
    }

    /**
     * Get capacidades_excepcionales
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getCapacidadesExcepcionales()
    {
        return $this->capacidades_excepcionales;
    }

    /**
     * Set etnias
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $etnias
     * @return Colegio
     */
    public function setEtnias(\Netpublic\CoreBundle\Entity\ValorVariable $etnias = null)
    {
        $this->etnias = $etnias;

        return $this;
    }

    /**
     * Get etnias
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getEtnias()
    {
        return $this->etnias;
    }

    /**
     * Set resguardo
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $resguardo
     * @return Colegio
     */
    public function setResguardo(\Netpublic\CoreBundle\Entity\ValorVariable $resguardo = null)
    {
        $this->resguardo = $resguardo;

        return $this;
    }

    /**
     * Get resguardo
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getResguardo()
    {
        return $this->resguardo;
    }

    /**
     * Set novedad_inst
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $novedadInst
     * @return Colegio
     */
    public function setNovedadInst(\Netpublic\CoreBundle\Entity\ValorVariable $novedadInst = null)
    {
        $this->novedad_inst = $novedadInst;

        return $this;
    }

    /**
     * Get novedad_inst
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getNovedadInst()
    {
        return $this->novedad_inst;
    }

    /**
     * Set metodologia
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $metodologia
     * @return Colegio
     */
    public function setMetodologia(\Netpublic\CoreBundle\Entity\ValorVariable $metodologia = null)
    {
        $this->metodologia = $metodologia;

        return $this;
    }

    /**
     * Get metodologia
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getMetodologia()
    {
        return $this->metodologia;
    }

    /**
     * Set zona
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $zona
     * @return Colegio
     */
    public function setZona(\Netpublic\CoreBundle\Entity\ValorVariable $zona = null)
    {
        $this->zona = $zona;

        return $this;
    }

    /**
     * Get zona
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getZona()
    {
        return $this->zona;
    }

    /**
     * Set depto
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $depto
     * @return Colegio
     */
    public function setDepto(\Netpublic\CoreBundle\Entity\ValorVariable $depto = null)
    {
        $this->depto = $depto;

        return $this;
    }

    /**
     * Get depto
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getDepto()
    {
        return $this->depto;
    }

    /**
     * Set municipio
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $municipio
     * @return Colegio
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
     * Set regimen_costos
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $regimenCostos
     * @return Colegio
     */
    public function setRegimenCostos(\Netpublic\CoreBundle\Entity\ValorVariable $regimenCostos = null)
    {
        $this->regimen_costos = $regimenCostos;

        return $this;
    }

    /**
     * Get regimen_costos
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getRegimenCostos()
    {
        return $this->regimen_costos;
    }

    /**
     * Set rango_promedio
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $rangoPromedio
     * @return Colegio
     */
    public function setRangoPromedio(\Netpublic\CoreBundle\Entity\ValorVariable $rangoPromedio = null)
    {
        $this->rango_promedio = $rangoPromedio;

        return $this;
    }

    /**
     * Get rango_promedio
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getRangoPromedio()
    {
        return $this->rango_promedio;
    }

    /**
     * Set idioma
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $idioma
     * @return Colegio
     */
    public function setIdioma(\Netpublic\CoreBundle\Entity\ValorVariable $idioma = null)
    {
        $this->idioma = $idioma;

        return $this;
    }

    /**
     * Get idioma
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getIdioma()
    {
        return $this->idioma;
    }

    /**
     * Set nucleo_privado
     *
     * @param \Netpublic\CoreBundle\Entity\ValorVariable $nucleoPrivado
     * @return Colegio
     */
    public function setNucleoPrivado(\Netpublic\CoreBundle\Entity\ValorVariable $nucleoPrivado = null)
    {
        $this->nucleo_privado = $nucleoPrivado;

        return $this;
    }

    /**
     * Get nucleo_privado
     *
     * @return \Netpublic\CoreBundle\Entity\ValorVariable 
     */
    public function getNucleoPrivado()
    {
        return $this->nucleo_privado;
    }

    /**
     * Add alumno
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $alumno
     * @return Colegio
     */
    public function addAlumno(\Netpublic\CoreBundle\Entity\Alumno $alumno)
    {
        $this->alumno[] = $alumno;

        return $this;
    }

    /**
     * Remove alumno
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $alumno
     */
    public function removeAlumno(\Netpublic\CoreBundle\Entity\Alumno $alumno)
    {
        $this->alumno->removeElement($alumno);
    }

    /**
     * Get alumno
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAlumno()
    {
        return $this->alumno;
    }

    /**
     * Add profesor
     *
     * @param \Netpublic\CoreBundle\Entity\Profesor $profesor
     * @return Colegio
     */
    public function addProfesor(\Netpublic\CoreBundle\Entity\Profesor $profesor)
    {
        $this->profesor[] = $profesor;

        return $this;
    }

    /**
     * Remove profesor
     *
     * @param \Netpublic\CoreBundle\Entity\Profesor $profesor
     */
    public function removeProfesor(\Netpublic\CoreBundle\Entity\Profesor $profesor)
    {
        $this->profesor->removeElement($profesor);
    }

    /**
     * Get profesor
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProfesor()
    {
        return $this->profesor;
    }

    /**
     * Add condicion_horario_clase
     *
     * @param \Netpublic\CoreBundle\Entity\CondicionCargaacademicacolegio $condicionHorarioClase
     * @return Colegio
     */
    public function addCondicionHorarioClase(\Netpublic\CoreBundle\Entity\CondicionCargaacademicacolegio $condicionHorarioClase)
    {
        $this->condicion_horario_clase[] = $condicionHorarioClase;

        return $this;
    }

    /**
     * Remove condicion_horario_clase
     *
     * @param \Netpublic\CoreBundle\Entity\CondicionCargaacademicacolegio $condicionHorarioClase
     */
    public function removeCondicionHorarioClase(\Netpublic\CoreBundle\Entity\CondicionCargaacademicacolegio $condicionHorarioClase)
    {
        $this->condicion_horario_clase->removeElement($condicionHorarioClase);
    }

    /**
     * Get condicion_horario_clase
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCondicionHorarioClase()
    {
        return $this->condicion_horario_clase;
    }

    /**
     * Add auditoria
     *
     * @param \Netpublic\CoreBundle\Entity\Auditoria $auditoria
     * @return Colegio
     */
    public function addAuditorium(\Netpublic\CoreBundle\Entity\Auditoria $auditoria)
    {
        $this->auditoria[] = $auditoria;

        return $this;
    }

    /**
     * Remove auditoria
     *
     * @param \Netpublic\CoreBundle\Entity\Auditoria $auditoria
     */
    public function removeAuditorium(\Netpublic\CoreBundle\Entity\Auditoria $auditoria)
    {
        $this->auditoria->removeElement($auditoria);
    }

    /**
     * Get auditoria
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAuditoria()
    {
        return $this->auditoria;
    }

    /**
     * Set ano_siguiente
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $anoSiguiente
     * @return Colegio
     */
    public function setAnoSiguiente(\Netpublic\CoreBundle\Entity\Dimension $anoSiguiente = null)
    {
        $this->ano_siguiente = $anoSiguiente;

        return $this;
    }

    /**
     * Get ano_siguiente
     *
     * @return \Netpublic\CoreBundle\Entity\Dimension 
     */
    public function getAnoSiguiente()
    {
        return $this->ano_siguiente;
    }

    /**
     * Set ano_anterior
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $anoAnterior
     * @return Colegio
     */
    public function setAnoAnterior(\Netpublic\CoreBundle\Entity\Dimension $anoAnterior = null)
    {
        $this->ano_anterior = $anoAnterior;

        return $this;
    }

    /**
     * Get ano_anterior
     *
     * @return \Netpublic\CoreBundle\Entity\Dimension 
     */
    public function getAnoAnterior()
    {
        return $this->ano_anterior;
    }

    /**
     * Add banco_pregunta
     *
     * @param \Netpublic\RedsaberBundle\Entity\BancoPregunta $bancoPregunta
     * @return Colegio
     */
    public function addBancoPreguntum(\Netpublic\RedsaberBundle\Entity\BancoPregunta $bancoPregunta)
    {
        $this->banco_pregunta[] = $bancoPregunta;

        return $this;
    }

    /**
     * Remove banco_pregunta
     *
     * @param \Netpublic\RedsaberBundle\Entity\BancoPregunta $bancoPregunta
     */
    public function removeBancoPreguntum(\Netpublic\RedsaberBundle\Entity\BancoPregunta $bancoPregunta)
    {
        $this->banco_pregunta->removeElement($bancoPregunta);
    }

    /**
     * Get banco_pregunta
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBancoPregunta()
    {
        return $this->banco_pregunta;
    }

    /**
     * Set nombre_corto
     *
     * @param string $nombreCorto
     * @return Colegio
     */
    public function setNombreCorto($nombreCorto)
    {
        $this->nombre_corto = $nombreCorto;

        return $this;
    }

    /**
     * Get nombre_corto
     *
     * @return string 
     */
    public function getNombreCorto()
    {
        return $this->nombre_corto;
    }
}
