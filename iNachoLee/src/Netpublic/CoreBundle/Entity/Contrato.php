<?php
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Netpublic\CoreBundle\Entity\Usuario;

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
 * @ORM\Table(name="contrato")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\ContratoRepository")
 */

class Contrato {
        /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;
     /**
     * @ORM\Column(type="float")
     */
    protected $horas_contratadas;
     /**
     * @ORM\Column(type="float")
     */
    protected $horas_buffer;    
    /**
    * @ORM\ManyToOne(targetEntity="Profesor",inversedBy="contrato")
    * 
     *  
     */
   protected $profesor_contrato;
    /**
    * @ORM\ManyToOne(targetEntity="Asignatura",inversedBy="contrato")
    * 
     */
   protected $asignatura;
   protected $grado;
   public function __toString() {
       return " Materias -".$this->asignatura." Horas Contratadas-".$this->horas_contratadas;
   }
   public function getGrado(){
       return $this->grado;
   }
   public function setGrado(Grado $grado){
       $this->grado=$grado;
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
     * Set horas_contratadas
     *
     * @param integer $horasContratadas
     */
    public function setHorasContratadas($horasContratadas)
    {
        $this->horas_contratadas = $horasContratadas;
    }

    /**
     * Get horas_contratadas
     *
     * @return integer 
     */
    public function getHorasContratadas()
    {
        return $this->horas_contratadas;
    }

    /**
     * Set horas_buffer
     *
     * @param integer $horasBuffer
     */
    public function setHorasBuffer($horasBuffer)
    {
        $this->horas_buffer = $horasBuffer;
    }

    /**
     * Get horas_buffer
     *
     * @return integer 
     */
    public function getHorasBuffer()
    {
        return $this->horas_buffer;
    }

    /**
     * Set profesor_contrato
     *
     * @param Netpublic\CoreBundle\Entity\Profesor $profesorContrato
     */
    public function setProfesorContrato(\Netpublic\CoreBundle\Entity\Profesor $profesorContrato)
    {
        $this->profesor_contrato = $profesorContrato;
    }

    /**
     * Get profesor_contrato
     *
     * @return Netpublic\CoreBundle\Entity\Profesor 
     */
    public function getProfesorContrato()
    {
        return $this->profesor_contrato;
    }

    /**
     * Set asignatura
     *
     * @param Netpublic\CoreBundle\Entity\Asignatura $asignatura
     */
    public function setAsignatura(\Netpublic\CoreBundle\Entity\Asignatura $asignatura)
    {
        $this->asignatura = $asignatura;
    }

    /**
     * Get asignatura
     *
     * @return Netpublic\CoreBundle\Entity\Asignatura 
     */
    public function getAsignatura()
    {
        return $this->asignatura;
    }
}
