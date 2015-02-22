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
 * @ORM\Table(name="condicion_profesor")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\CondicionprofesorRepository")
 */
class CondicionProfesor {
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
    * @ORM\ManyToOne(targetEntity="Profesor",inversedBy="condicion_profesor")
    */    
   protected $profesor;


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
     * @return CondicionProfesor
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
     * @return CondicionProfesor
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
     * @return CondicionProfesor
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
     * @return CondicionProfesor
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
     * Set profesor
     *
     * @param \Netpublic\CoreBundle\Entity\Profesor $profesor
     * @return CondicionProfesor
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
}
