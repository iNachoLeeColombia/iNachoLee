<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ValorVariable
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Netpublic\CoreBundle\Entity\Usuario;
/**
 * @ORM\Entity
 * @ORM\Table(name="valor_variable")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\ValorVariableRepository")
 */
class ValorVariable {
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
    protected $valor;    
    /**
    * @ORM\ManyToOne(targetEntity="Variable",inversedBy="valor_variable")    
    */    
    protected $variable;
     /**
     *
     * @ORM\Column(type="string")
     */    
     protected $descripcion;
    /** 
     * @ORM\OneToMany(targetEntity="Colegio",mappedBy="sector")    
    */    
    protected $v_sector;
    /**
    * @ORM\OneToMany(targetEntity="Colegio",mappedBy="calendario")    
    */    

    protected $v_calendario; 
    /**
    * @ORM\OneToMany(targetEntity="Colegio",mappedBy="propiedad_juridica")    
    */    

    protected $v_propiedad_juridica;  

    /**
    * @ORM\OneToMany(targetEntity="Colegio",mappedBy="nucleo")    
    */    
    protected $v_nucleo;   
    /**
    * @ORM\OneToMany(targetEntity="Colegio",mappedBy="genero")    
    */    

    protected $v_genero;       
    /**
    * @ORM\OneToMany(targetEntity="Colegio",mappedBy="discapacidades")    
    */    
    protected $v_discapacidades; 
    /**
    * @ORM\OneToMany(targetEntity="Colegio",mappedBy="capacidades_excepcionales")    
    */    
    protected $v_capacidades_excepcionales;    
    /**
    * @ORM\OneToMany(targetEntity="Colegio",mappedBy="etnias")    
    */    

    protected $v_etnias;
    /**
    * @ORM\OneToMany(targetEntity="Colegio",mappedBy="resguardo")    
    */    

    protected $v_resguardo;
    /**
    * @ORM\OneToMany(targetEntity="Colegio",mappedBy="novedad_inst")    
    */    
    protected $v_novedad_inst;
    /**
    * @ORM\OneToMany(targetEntity="Colegio",mappedBy="metodologia")    
    */    

    protected $v_metodologia;  
    /**
    * @ORM\OneToMany(targetEntity="Colegio",mappedBy="zona")    
    */    
    protected $v_zona;    
    /**
    * @ORM\OneToMany(targetEntity="Colegio",mappedBy="depto")    
    */    
    protected $v_depto;
    /**
    * @ORM\OneToMany(targetEntity="Colegio",mappedBy="municipio")    
    */    

    protected $v_municipio;   
    /**
    * @ORM\OneToMany(targetEntity="Alumno",mappedBy="depto_nacimiento")    
    */    
    protected $v_dpto_fecha_nacimiento;
    /**
    * @ORM\OneToMany(targetEntity="Alumno",mappedBy="municipio_nacimiento")    
    */    

    protected $v_municipio_fecha_nacimiento;     
       /**
    * @ORM\OneToMany(targetEntity="Alumno",mappedBy="depto_ubicacion")    
    */    
    protected $v_depto_ubicacion;
    
    /**
    * @ORM\OneToMany(targetEntity="Alumno",mappedBy="municipio_ubicacion")    
    */    

    protected $v_municipio_ubicacion;   
        /**
    * @ORM\OneToMany(targetEntity="Alumno",mappedBy="ultimo_depto_expulsor")    
    */    
    protected $v_municipio_expulsor;
    /**
    * @ORM\OneToMany(targetEntity="Colegio",mappedBy="regimen_costos")    
    */    
    protected $v_regimen_costos;
    /**
    * @ORM\OneToMany(targetEntity="Colegio",mappedBy="rango_promedio")    
    */    

    protected $v_rango_promedio;    
    /**
    * @ORM\OneToMany(targetEntity="Colegio",mappedBy="idioma")    
    */    
    protected $v_idioma;    
    /**
    * @ORM\OneToMany(targetEntity="Colegio",mappedBy="nucleo_privado")    
    */  
    protected $v_nucle_privado;
    
    /**
    * @ORM\OneToMany(targetEntity="Alumno",mappedBy="departamento")    
    */ 
    protected $v_dpto_cedula;
    /**
    * @ORM\OneToMany(targetEntity="Alumno",mappedBy="municipio")    
    */ 
    protected $v_municipio_cedula;
    public function __toString() {
        return $this->descripcion;
    }

  
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->v_sector = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_calendario = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_propiedad_juridica = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_nucleo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_genero = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_discapacidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_capacidades_excepcionales = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_etnias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_resguardo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_novedad_inst = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_metodologia = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_zona = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_depto = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_municipio = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_dpto_fecha_nacimiento = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_municipio_fecha_nacimiento = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_depto_ubicacion = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_municipio_ubicacion = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_municipio_expulsor = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_regimen_costos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_rango_promedio = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_idioma = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_nucle_privado = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_dpto_cedula = new \Doctrine\Common\Collections\ArrayCollection();
        $this->v_municipio_cedula = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set valor
     *
     * @param integer $valor
     * @return ValorVariable
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return ValorVariable
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set variable
     *
     * @param \Netpublic\CoreBundle\Entity\Variable $variable
     * @return ValorVariable
     */
    public function setVariable(\Netpublic\CoreBundle\Entity\Variable $variable = null)
    {
        $this->variable = $variable;
    
        return $this;
    }

    /**
     * Get variable
     *
     * @return \Netpublic\CoreBundle\Entity\Variable 
     */
    public function getVariable()
    {
        return $this->variable;
    }

    /**
     * Add v_sector
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vSector
     * @return ValorVariable
     */
    public function addVSector(\Netpublic\CoreBundle\Entity\Colegio $vSector)
    {
        $this->v_sector[] = $vSector;
    
        return $this;
    }

    /**
     * Remove v_sector
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vSector
     */
    public function removeVSector(\Netpublic\CoreBundle\Entity\Colegio $vSector)
    {
        $this->v_sector->removeElement($vSector);
    }

    /**
     * Get v_sector
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVSector()
    {
        return $this->v_sector;
    }

    /**
     * Add v_calendario
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vCalendario
     * @return ValorVariable
     */
    public function addVCalendario(\Netpublic\CoreBundle\Entity\Colegio $vCalendario)
    {
        $this->v_calendario[] = $vCalendario;
    
        return $this;
    }

    /**
     * Remove v_calendario
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vCalendario
     */
    public function removeVCalendario(\Netpublic\CoreBundle\Entity\Colegio $vCalendario)
    {
        $this->v_calendario->removeElement($vCalendario);
    }

    /**
     * Get v_calendario
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVCalendario()
    {
        return $this->v_calendario;
    }

    /**
     * Add v_propiedad_juridica
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vPropiedadJuridica
     * @return ValorVariable
     */
    public function addVPropiedadJuridica(\Netpublic\CoreBundle\Entity\Colegio $vPropiedadJuridica)
    {
        $this->v_propiedad_juridica[] = $vPropiedadJuridica;
    
        return $this;
    }

    /**
     * Remove v_propiedad_juridica
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vPropiedadJuridica
     */
    public function removeVPropiedadJuridica(\Netpublic\CoreBundle\Entity\Colegio $vPropiedadJuridica)
    {
        $this->v_propiedad_juridica->removeElement($vPropiedadJuridica);
    }

    /**
     * Get v_propiedad_juridica
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVPropiedadJuridica()
    {
        return $this->v_propiedad_juridica;
    }

    /**
     * Add v_nucleo
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vNucleo
     * @return ValorVariable
     */
    public function addVNucleo(\Netpublic\CoreBundle\Entity\Colegio $vNucleo)
    {
        $this->v_nucleo[] = $vNucleo;
    
        return $this;
    }

    /**
     * Remove v_nucleo
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vNucleo
     */
    public function removeVNucleo(\Netpublic\CoreBundle\Entity\Colegio $vNucleo)
    {
        $this->v_nucleo->removeElement($vNucleo);
    }

    /**
     * Get v_nucleo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVNucleo()
    {
        return $this->v_nucleo;
    }

    /**
     * Add v_genero
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vGenero
     * @return ValorVariable
     */
    public function addVGenero(\Netpublic\CoreBundle\Entity\Colegio $vGenero)
    {
        $this->v_genero[] = $vGenero;
    
        return $this;
    }

    /**
     * Remove v_genero
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vGenero
     */
    public function removeVGenero(\Netpublic\CoreBundle\Entity\Colegio $vGenero)
    {
        $this->v_genero->removeElement($vGenero);
    }

    /**
     * Get v_genero
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVGenero()
    {
        return $this->v_genero;
    }

    /**
     * Add v_discapacidades
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vDiscapacidades
     * @return ValorVariable
     */
    public function addVDiscapacidade(\Netpublic\CoreBundle\Entity\Colegio $vDiscapacidades)
    {
        $this->v_discapacidades[] = $vDiscapacidades;
    
        return $this;
    }

    /**
     * Remove v_discapacidades
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vDiscapacidades
     */
    public function removeVDiscapacidade(\Netpublic\CoreBundle\Entity\Colegio $vDiscapacidades)
    {
        $this->v_discapacidades->removeElement($vDiscapacidades);
    }

    /**
     * Get v_discapacidades
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVDiscapacidades()
    {
        return $this->v_discapacidades;
    }

    /**
     * Add v_capacidades_excepcionales
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vCapacidadesExcepcionales
     * @return ValorVariable
     */
    public function addVCapacidadesExcepcionale(\Netpublic\CoreBundle\Entity\Colegio $vCapacidadesExcepcionales)
    {
        $this->v_capacidades_excepcionales[] = $vCapacidadesExcepcionales;
    
        return $this;
    }

    /**
     * Remove v_capacidades_excepcionales
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vCapacidadesExcepcionales
     */
    public function removeVCapacidadesExcepcionale(\Netpublic\CoreBundle\Entity\Colegio $vCapacidadesExcepcionales)
    {
        $this->v_capacidades_excepcionales->removeElement($vCapacidadesExcepcionales);
    }

    /**
     * Get v_capacidades_excepcionales
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVCapacidadesExcepcionales()
    {
        return $this->v_capacidades_excepcionales;
    }

    /**
     * Add v_etnias
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vEtnias
     * @return ValorVariable
     */
    public function addVEtnia(\Netpublic\CoreBundle\Entity\Colegio $vEtnias)
    {
        $this->v_etnias[] = $vEtnias;
    
        return $this;
    }

    /**
     * Remove v_etnias
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vEtnias
     */
    public function removeVEtnia(\Netpublic\CoreBundle\Entity\Colegio $vEtnias)
    {
        $this->v_etnias->removeElement($vEtnias);
    }

    /**
     * Get v_etnias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVEtnias()
    {
        return $this->v_etnias;
    }

    /**
     * Add v_resguardo
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vResguardo
     * @return ValorVariable
     */
    public function addVResguardo(\Netpublic\CoreBundle\Entity\Colegio $vResguardo)
    {
        $this->v_resguardo[] = $vResguardo;
    
        return $this;
    }

    /**
     * Remove v_resguardo
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vResguardo
     */
    public function removeVResguardo(\Netpublic\CoreBundle\Entity\Colegio $vResguardo)
    {
        $this->v_resguardo->removeElement($vResguardo);
    }

    /**
     * Get v_resguardo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVResguardo()
    {
        return $this->v_resguardo;
    }

    /**
     * Add v_novedad_inst
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vNovedadInst
     * @return ValorVariable
     */
    public function addVNovedadInst(\Netpublic\CoreBundle\Entity\Colegio $vNovedadInst)
    {
        $this->v_novedad_inst[] = $vNovedadInst;
    
        return $this;
    }

    /**
     * Remove v_novedad_inst
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vNovedadInst
     */
    public function removeVNovedadInst(\Netpublic\CoreBundle\Entity\Colegio $vNovedadInst)
    {
        $this->v_novedad_inst->removeElement($vNovedadInst);
    }

    /**
     * Get v_novedad_inst
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVNovedadInst()
    {
        return $this->v_novedad_inst;
    }

    /**
     * Add v_metodologia
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vMetodologia
     * @return ValorVariable
     */
    public function addVMetodologia(\Netpublic\CoreBundle\Entity\Colegio $vMetodologia)
    {
        $this->v_metodologia[] = $vMetodologia;
    
        return $this;
    }

    /**
     * Remove v_metodologia
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vMetodologia
     */
    public function removeVMetodologia(\Netpublic\CoreBundle\Entity\Colegio $vMetodologia)
    {
        $this->v_metodologia->removeElement($vMetodologia);
    }

    /**
     * Get v_metodologia
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVMetodologia()
    {
        return $this->v_metodologia;
    }

    /**
     * Add v_zona
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vZona
     * @return ValorVariable
     */
    public function addVZona(\Netpublic\CoreBundle\Entity\Colegio $vZona)
    {
        $this->v_zona[] = $vZona;
    
        return $this;
    }

    /**
     * Remove v_zona
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vZona
     */
    public function removeVZona(\Netpublic\CoreBundle\Entity\Colegio $vZona)
    {
        $this->v_zona->removeElement($vZona);
    }

    /**
     * Get v_zona
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVZona()
    {
        return $this->v_zona;
    }

    /**
     * Add v_depto
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vDepto
     * @return ValorVariable
     */
    public function addVDepto(\Netpublic\CoreBundle\Entity\Colegio $vDepto)
    {
        $this->v_depto[] = $vDepto;
    
        return $this;
    }

    /**
     * Remove v_depto
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vDepto
     */
    public function removeVDepto(\Netpublic\CoreBundle\Entity\Colegio $vDepto)
    {
        $this->v_depto->removeElement($vDepto);
    }

    /**
     * Get v_depto
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVDepto()
    {
        return $this->v_depto;
    }

    /**
     * Add v_municipio
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vMunicipio
     * @return ValorVariable
     */
    public function addVMunicipio(\Netpublic\CoreBundle\Entity\Colegio $vMunicipio)
    {
        $this->v_municipio[] = $vMunicipio;
    
        return $this;
    }

    /**
     * Remove v_municipio
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vMunicipio
     */
    public function removeVMunicipio(\Netpublic\CoreBundle\Entity\Colegio $vMunicipio)
    {
        $this->v_municipio->removeElement($vMunicipio);
    }

    /**
     * Get v_municipio
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVMunicipio()
    {
        return $this->v_municipio;
    }

    /**
     * Add v_dpto_fecha_nacimiento
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $vDptoFechaNacimiento
     * @return ValorVariable
     */
    public function addVDptoFechaNacimiento(\Netpublic\CoreBundle\Entity\Alumno $vDptoFechaNacimiento)
    {
        $this->v_dpto_fecha_nacimiento[] = $vDptoFechaNacimiento;
    
        return $this;
    }

    /**
     * Remove v_dpto_fecha_nacimiento
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $vDptoFechaNacimiento
     */
    public function removeVDptoFechaNacimiento(\Netpublic\CoreBundle\Entity\Alumno $vDptoFechaNacimiento)
    {
        $this->v_dpto_fecha_nacimiento->removeElement($vDptoFechaNacimiento);
    }

    /**
     * Get v_dpto_fecha_nacimiento
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVDptoFechaNacimiento()
    {
        return $this->v_dpto_fecha_nacimiento;
    }

    /**
     * Add v_municipio_fecha_nacimiento
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $vMunicipioFechaNacimiento
     * @return ValorVariable
     */
    public function addVMunicipioFechaNacimiento(\Netpublic\CoreBundle\Entity\Alumno $vMunicipioFechaNacimiento)
    {
        $this->v_municipio_fecha_nacimiento[] = $vMunicipioFechaNacimiento;
    
        return $this;
    }

    /**
     * Remove v_municipio_fecha_nacimiento
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $vMunicipioFechaNacimiento
     */
    public function removeVMunicipioFechaNacimiento(\Netpublic\CoreBundle\Entity\Alumno $vMunicipioFechaNacimiento)
    {
        $this->v_municipio_fecha_nacimiento->removeElement($vMunicipioFechaNacimiento);
    }

    /**
     * Get v_municipio_fecha_nacimiento
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVMunicipioFechaNacimiento()
    {
        return $this->v_municipio_fecha_nacimiento;
    }

    /**
     * Add v_depto_ubicacion
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $vDeptoUbicacion
     * @return ValorVariable
     */
    public function addVDeptoUbicacion(\Netpublic\CoreBundle\Entity\Alumno $vDeptoUbicacion)
    {
        $this->v_depto_ubicacion[] = $vDeptoUbicacion;
    
        return $this;
    }

    /**
     * Remove v_depto_ubicacion
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $vDeptoUbicacion
     */
    public function removeVDeptoUbicacion(\Netpublic\CoreBundle\Entity\Alumno $vDeptoUbicacion)
    {
        $this->v_depto_ubicacion->removeElement($vDeptoUbicacion);
    }

    /**
     * Get v_depto_ubicacion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVDeptoUbicacion()
    {
        return $this->v_depto_ubicacion;
    }

    /**
     * Add v_municipio_ubicacion
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $vMunicipioUbicacion
     * @return ValorVariable
     */
    public function addVMunicipioUbicacion(\Netpublic\CoreBundle\Entity\Alumno $vMunicipioUbicacion)
    {
        $this->v_municipio_ubicacion[] = $vMunicipioUbicacion;
    
        return $this;
    }

    /**
     * Remove v_municipio_ubicacion
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $vMunicipioUbicacion
     */
    public function removeVMunicipioUbicacion(\Netpublic\CoreBundle\Entity\Alumno $vMunicipioUbicacion)
    {
        $this->v_municipio_ubicacion->removeElement($vMunicipioUbicacion);
    }

    /**
     * Get v_municipio_ubicacion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVMunicipioUbicacion()
    {
        return $this->v_municipio_ubicacion;
    }

    /**
     * Add v_municipio_expulsor
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $vMunicipioExpulsor
     * @return ValorVariable
     */
    public function addVMunicipioExpulsor(\Netpublic\CoreBundle\Entity\Alumno $vMunicipioExpulsor)
    {
        $this->v_municipio_expulsor[] = $vMunicipioExpulsor;
    
        return $this;
    }

    /**
     * Remove v_municipio_expulsor
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $vMunicipioExpulsor
     */
    public function removeVMunicipioExpulsor(\Netpublic\CoreBundle\Entity\Alumno $vMunicipioExpulsor)
    {
        $this->v_municipio_expulsor->removeElement($vMunicipioExpulsor);
    }

    /**
     * Get v_municipio_expulsor
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVMunicipioExpulsor()
    {
        return $this->v_municipio_expulsor;
    }

    /**
     * Add v_regimen_costos
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vRegimenCostos
     * @return ValorVariable
     */
    public function addVRegimenCosto(\Netpublic\CoreBundle\Entity\Colegio $vRegimenCostos)
    {
        $this->v_regimen_costos[] = $vRegimenCostos;
    
        return $this;
    }

    /**
     * Remove v_regimen_costos
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vRegimenCostos
     */
    public function removeVRegimenCosto(\Netpublic\CoreBundle\Entity\Colegio $vRegimenCostos)
    {
        $this->v_regimen_costos->removeElement($vRegimenCostos);
    }

    /**
     * Get v_regimen_costos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVRegimenCostos()
    {
        return $this->v_regimen_costos;
    }

    /**
     * Add v_rango_promedio
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vRangoPromedio
     * @return ValorVariable
     */
    public function addVRangoPromedio(\Netpublic\CoreBundle\Entity\Colegio $vRangoPromedio)
    {
        $this->v_rango_promedio[] = $vRangoPromedio;
    
        return $this;
    }

    /**
     * Remove v_rango_promedio
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vRangoPromedio
     */
    public function removeVRangoPromedio(\Netpublic\CoreBundle\Entity\Colegio $vRangoPromedio)
    {
        $this->v_rango_promedio->removeElement($vRangoPromedio);
    }

    /**
     * Get v_rango_promedio
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVRangoPromedio()
    {
        return $this->v_rango_promedio;
    }

    /**
     * Add v_idioma
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vIdioma
     * @return ValorVariable
     */
    public function addVIdioma(\Netpublic\CoreBundle\Entity\Colegio $vIdioma)
    {
        $this->v_idioma[] = $vIdioma;
    
        return $this;
    }

    /**
     * Remove v_idioma
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vIdioma
     */
    public function removeVIdioma(\Netpublic\CoreBundle\Entity\Colegio $vIdioma)
    {
        $this->v_idioma->removeElement($vIdioma);
    }

    /**
     * Get v_idioma
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVIdioma()
    {
        return $this->v_idioma;
    }

    /**
     * Add v_nucle_privado
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vNuclePrivado
     * @return ValorVariable
     */
    public function addVNuclePrivado(\Netpublic\CoreBundle\Entity\Colegio $vNuclePrivado)
    {
        $this->v_nucle_privado[] = $vNuclePrivado;
    
        return $this;
    }

    /**
     * Remove v_nucle_privado
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vNuclePrivado
     */
    public function removeVNuclePrivado(\Netpublic\CoreBundle\Entity\Colegio $vNuclePrivado)
    {
        $this->v_nucle_privado->removeElement($vNuclePrivado);
    }

    /**
     * Get v_nucle_privado
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVNuclePrivado()
    {
        return $this->v_nucle_privado;
    }

    /**
     * Add v_dpto_cedula
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $vDptoCedula
     * @return ValorVariable
     */
    public function addVDptoCedula(\Netpublic\CoreBundle\Entity\Alumno $vDptoCedula)
    {
        $this->v_dpto_cedula[] = $vDptoCedula;
    
        return $this;
    }

    /**
     * Remove v_dpto_cedula
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $vDptoCedula
     */
    public function removeVDptoCedula(\Netpublic\CoreBundle\Entity\Alumno $vDptoCedula)
    {
        $this->v_dpto_cedula->removeElement($vDptoCedula);
    }

    /**
     * Get v_dpto_cedula
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVDptoCedula()
    {
        return $this->v_dpto_cedula;
    }

    /**
     * Add v_municipio_cedula
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $vMunicipioCedula
     * @return ValorVariable
     */
    public function addVMunicipioCedula(\Netpublic\CoreBundle\Entity\Alumno $vMunicipioCedula)
    {
        $this->v_municipio_cedula[] = $vMunicipioCedula;
    
        return $this;
    }

    /**
     * Remove v_municipio_cedula
     *
     * @param \Netpublic\CoreBundle\Entity\Alumno $vMunicipioCedula
     */
    public function removeVMunicipioCedula(\Netpublic\CoreBundle\Entity\Alumno $vMunicipioCedula)
    {
        $this->v_municipio_cedula->removeElement($vMunicipioCedula);
    }

    /**
     * Get v_municipio_cedula
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVMunicipioCedula()
    {
        return $this->v_municipio_cedula;
    }

    /**
     * Add v_metodologia
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vMetodologia
     * @return ValorVariable
     */
    public function addVMetodologium(\Netpublic\CoreBundle\Entity\Colegio $vMetodologia)
    {
        $this->v_metodologia[] = $vMetodologia;

        return $this;
    }

    /**
     * Remove v_metodologia
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $vMetodologia
     */
    public function removeVMetodologium(\Netpublic\CoreBundle\Entity\Colegio $vMetodologia)
    {
        $this->v_metodologia->removeElement($vMetodologia);
    }
}
