<?php
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="horario_grupo")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\HorarioGrupoRepository")
 */
class HorarioGrupo {
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * 0 esta libre
     * 1 esta ocupada
     * 2 es dia festivo
     * 3 es para guardar hora
     * @ORM\Column(type="integer")
     */
    protected $tipo;
    /**
     * @ORM\Column(type="integer")
     */
    protected $dia_columna;
    /**
     * @ORM\Column(type="integer")
     */
    protected $hora_fila;
    
   /**
    * @ORM\ManyToOne(targetEntity="CargaAcademica",inversedBy="horario_grupo")
    */    
   protected $carga_academica;
   /**
    * @ORM\ManyToOne(targetEntity="Grupo",inversedBy="horario_grupo")
    */    
   protected $grupo;

   /**
    *
    * @ORM\Column(type="integer",nullable=true)
    */
   protected $posicion;
   /**
    *
    * @ORM\Column(type="integer",nullable=true)
    */
   protected $posicion_columna;
       /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $valor;



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
     * @return HorarioGrupo
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
     * Set dia_columna
     *
     * @param integer $diaColumna
     * @return HorarioGrupo
     */
    public function setDiaColumna($diaColumna)
    {
        $this->dia_columna = $diaColumna;
    
        return $this;
    }

    /**
     * Get dia_columna
     *
     * @return integer 
     */
    public function getDiaColumna()
    {
        return $this->dia_columna;
    }

    /**
     * Set hora_fila
     *
     * @param integer $horaFila
     * @return HorarioGrupo
     */
    public function setHoraFila($horaFila)
    {
        $this->hora_fila = $horaFila;
    
        return $this;
    }

    /**
     * Get hora_fila
     *
     * @return integer 
     */
    public function getHoraFila()
    {
        return $this->hora_fila;
    }

    /**
     * Set posicion
     *
     * @param integer $posicion
     * @return HorarioGrupo
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
     * Set posicion_columna
     *
     * @param integer $posicionColumna
     * @return HorarioGrupo
     */
    public function setPosicionColumna($posicionColumna)
    {
        $this->posicion_columna = $posicionColumna;
    
        return $this;
    }

    /**
     * Get posicion_columna
     *
     * @return integer 
     */
    public function getPosicionColumna()
    {
        return $this->posicion_columna;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return HorarioGrupo
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    
        return $this;
    }

    /**
     * Get valor
     *
     * @return string 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set carga_academica
     *
     * @param \Netpublic\CoreBundle\Entity\CargaAcademica $cargaAcademica
     * @return HorarioGrupo
     */
    public function setCargaAcademica(\Netpublic\CoreBundle\Entity\CargaAcademica $cargaAcademica = null)
    {
        $this->carga_academica = $cargaAcademica;
    
        return $this;
    }

    /**
     * Get carga_academica
     *
     * @return \Netpublic\CoreBundle\Entity\CargaAcademica 
     */
    public function getCargaAcademica()
    {
        return $this->carga_academica;
    }

    /**
     * Set grupo
     *
     * @param \Netpublic\CoreBundle\Entity\Grupo $grupo
     * @return HorarioGrupo
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
