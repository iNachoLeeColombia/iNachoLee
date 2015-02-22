<?php
namespace Netpublic\RedsaberBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="temas_evaluados")
 * @ORM\Entity(repositoryClass="Netpublic\RedsaberBundle\Repository\TemaevaluadoRepository")
 */
class TemasEvaluados {
     /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     *
     * @ORM\Column(type="integer",nullable=false)
     */
    protected $es_evaluado;
    /**
     *
     * @ORM\Column(type="integer",nullable=false)
     */
    protected $nro_vecesevaluados;
     /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $ultima_fecha_evaluado; 
    /**
    * @ORM\ManyToOne(targetEntity="Netpublic\CoreBundle\Entity\Profesor",inversedBy="temas_evaluado")    
     *
     *     
     */   
    protected $profesor;
    /**
     * @ORM\ManyToOne(targetEntity="Netpublic\CoreBundle\Entity\Dimension",inversedBy="temas_evaluado")    
     *
     *     
     */   
    protected $ano_escolar;
    /**
     * @ORM\ManyToOne(targetEntity="PlanArea",inversedBy="temas_evaluado")    
     *
     *     
     */   
    protected $tema;
    

    
 
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
     * Set es_evaluado
     *
     * @param integer $esEvaluado
     * @return TemasEvaluados
     */
    public function setEsEvaluado($esEvaluado)
    {
        $this->es_evaluado = $esEvaluado;

        return $this;
    }

    /**
     * Get es_evaluado
     *
     * @return integer 
     */
    public function getEsEvaluado()
    {
        return $this->es_evaluado;
    }

    /**
     * Set nro_vecesevaluados
     *
     * @param integer $nroVecesevaluados
     * @return TemasEvaluados
     */
    public function setNroVecesevaluados($nroVecesevaluados)
    {
        $this->nro_vecesevaluados = $nroVecesevaluados;

        return $this;
    }

    /**
     * Get nro_vecesevaluados
     *
     * @return integer 
     */
    public function getNroVecesevaluados()
    {
        return $this->nro_vecesevaluados;
    }

    /**
     * Set ultima_fecha_evaluado
     *
     * @param \DateTime $ultimaFechaEvaluado
     * @return TemasEvaluados
     */
    public function setUltimaFechaEvaluado($ultimaFechaEvaluado)
    {
        $this->ultima_fecha_evaluado = $ultimaFechaEvaluado;

        return $this;
    }

    /**
     * Get ultima_fecha_evaluado
     *
     * @return \DateTime 
     */
    public function getUltimaFechaEvaluado()
    {
        return $this->ultima_fecha_evaluado;
    }

    /**
     * Set profesor
     *
     * @param \Netpublic\CoreBundle\Entity\Profesor $profesor
     * @return TemasEvaluados
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
     * Set ano_escolar
     *
     * @param \Netpublic\CoreBundle\Entity\Dimension $anoEscolar
     * @return TemasEvaluados
     */
    public function setAnoEscolar(\Netpublic\CoreBundle\Entity\Dimension $anoEscolar = null)
    {
        $this->ano_escolar = $anoEscolar;

        return $this;
    }

    /**
     * Get ano_escolar
     *
     * @return \Netpublic\CoreBundle\Entity\Dimension 
     */
    public function getAnoEscolar()
    {
        return $this->ano_escolar;
    }

    /**
     * Set tema
     *
     * @param \Netpublic\RedsaberBundle\Entity\PlanArea $tema
     * @return TemasEvaluados
     */
    public function setTema(\Netpublic\RedsaberBundle\Entity\PlanArea $tema = null)
    {
        $this->tema = $tema;

        return $this;
    }

    /**
     * Get tema
     *
     * @return \Netpublic\RedsaberBundle\Entity\PlanArea 
     */
    public function getTema()
    {
        return $this->tema;
    }
}
