<?php
namespace Netpublic\RedsaberBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="respuesta")
 * @ORM\Entity(repositoryClass="Netpublic\RedsaberBundle\Repository\RepuestaRepository")
 */
class Respueta {
    //put your code here
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
    protected $indice;
    /**
    *
    * 1 : MATRIX_HOJA_RESPUESTAS_ALUMNOS
    * 2 : MATRIX_PORCENTAJE
    * 3 : MATRIX_HOJA_REPUESTAS_CORRECTAS 
    * @ORM\Column(type="integer",nullable=false)
    */
    protected $tipo;

    /**
     *
     * @ORM\Column(type="integer",nullable=false)
     */
    protected $alumno_referencia;
    /**
     *
     * @ORM\OneToMany(targetEntity="Buble",mappedBy="respuesta")
     */
    protected $buble;
    /**
     *
     * @ORM\Column(type="integer",nullable=false)
     */
    protected $bloque;
    /**
    * @ORM\ManyToOne(targetEntity="ExamenIcfes",inversedBy="respuesta_examen")    
    *
    *     
    */   
    protected $examen;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->buble = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set indice
     *
     * @param integer $indice
     * @return Respueta
     */
    public function setIndice($indice)
    {
        $this->indice = $indice;

        return $this;
    }

    /**
     * Get indice
     *
     * @return integer 
     */
    public function getIndice()
    {
        return $this->indice;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     * @return Respueta
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
     * Set alumno_referencia
     *
     * @param integer $alumnoReferencia
     * @return Respueta
     */
    public function setAlumnoReferencia($alumnoReferencia)
    {
        $this->alumno_referencia = $alumnoReferencia;

        return $this;
    }

    /**
     * Get alumno_referencia
     *
     * @return integer 
     */
    public function getAlumnoReferencia()
    {
        return $this->alumno_referencia;
    }

    /**
     * Set bloque
     *
     * @param integer $bloque
     * @return Respueta
     */
    public function setBloque($bloque)
    {
        $this->bloque = $bloque;

        return $this;
    }

    /**
     * Get bloque
     *
     * @return integer 
     */
    public function getBloque()
    {
        return $this->bloque;
    }

    /**
     * Add buble
     *
     * @param \Netpublic\RedsaberBundle\Entity\Buble $buble
     * @return Respueta
     */
    public function addBuble(\Netpublic\RedsaberBundle\Entity\Buble $buble)
    {
        $this->buble[] = $buble;

        return $this;
    }

    /**
     * Remove buble
     *
     * @param \Netpublic\RedsaberBundle\Entity\Buble $buble
     */
    public function removeBuble(\Netpublic\RedsaberBundle\Entity\Buble $buble)
    {
        $this->buble->removeElement($buble);
    }

    /**
     * Get buble
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBuble()
    {
        return $this->buble;
    }

    /**
     * Set examen
     *
     * @param \Netpublic\RedsaberBundle\Entity\ExamenIcfes $examen
     * @return Respueta
     */
    public function setExamen(\Netpublic\RedsaberBundle\Entity\ExamenIcfes $examen = null)
    {
        $this->examen = $examen;

        return $this;
    }

    /**
     * Get examen
     *
     * @return \Netpublic\RedsaberBundle\Entity\ExamenIcfes 
     */
    public function getExamen()
    {
        return $this->examen;
    }
}
