<?php
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Grupo
 *
 * @author yuri
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="condicion_asignatura")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\CondicionasignaturaRepository")
 */


class CondicionAsignatura {
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
     * @ORM\Column(type="string",nullable=true)
     */
    protected $valor;
   /**
    * @ORM\ManyToOne(targetEntity="Asignatura",inversedBy="condicion_asignatura")
    */    
   protected $asignatura;

 

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
     * @return CondicionAsignatura
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
     * @return CondicionAsignatura
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
     * @return CondicionAsignatura
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
     * Set valor
     *
     * @param string $valor
     * @return CondicionAsignatura
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
     * Set asignatura
     *
     * @param \Netpublic\CoreBundle\Entity\Asignatura $asignatura
     * @return CondicionAsignatura
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
}
