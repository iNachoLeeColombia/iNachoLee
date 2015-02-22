<?php
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Contrato
 *
 * @author yuri
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="condicion_ca_colegio")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\CondicioncacolegioRepository")
 */

class CondicionCargaacademicacolegio {
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
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $dia_columna;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $hora_fila;
    
   /**
    * @ORM\ManyToOne(targetEntity="Colegio",inversedBy="condicion_horario_clase")
    */    
   protected $colegio;
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
     * @return CondicionCargaacademicacolegio
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
     * @return CondicionCargaacademicacolegio
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
     * @return CondicionCargaacademicacolegio
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
     * Set colegio
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $colegio
     * @return CondicionCargaacademicacolegio
     */
    public function setColegio(\Netpublic\CoreBundle\Entity\Colegio $colegio = null)
    {
        $this->colegio = $colegio;
    
        return $this;
    }

    /**
     * Get colegio
     *
     * @return \Netpublic\CoreBundle\Entity\Colegio 
     */
    public function getColegio()
    {
        return $this->colegio;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return CondicionCargaacademicacolegio
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
}
