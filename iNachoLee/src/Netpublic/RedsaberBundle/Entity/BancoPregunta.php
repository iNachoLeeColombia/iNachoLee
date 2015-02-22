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
namespace Netpublic\RedsaberBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="banco_pregunta")
 * @ORM\Entity(repositoryClass="Netpublic\RedsaberBundle\Repository\BancopreguntaRepository")
 */
class BancoPregunta 
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
     * @ORM\Column(type="integer",nullable=false)
     */
    protected $es_publico;
    /**
    * @ORM\ManyToOne(targetEntity="Pregunta",inversedBy="banco_pregunta")    
    *
    *     
    */   
    protected $pregunta;
    /**
    * @ORM\ManyToOne(targetEntity="Netpublic\CoreBundle\Entity\Colegio",inversedBy="banco_pregunta")    
     *
     *     
     */   
    protected $dueno_institucion;


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
     * Set es_publico
     *
     * @param integer $esPublico
     * @return BancoPregunta
     */
    public function setEsPublico($esPublico)
    {
        $this->es_publico = $esPublico;

        return $this;
    }

    /**
     * Get es_publico
     *
     * @return integer 
     */
    public function getEsPublico()
    {
        return $this->es_publico;
    }

    /**
     * Set pregunta
     *
     * @param \Netpublic\RedsaberBundle\Entity\Pregunta $pregunta
     * @return BancoPregunta
     */
    public function setPregunta(\Netpublic\RedsaberBundle\Entity\Pregunta $pregunta = null)
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    /**
     * Get pregunta
     *
     * @return \Netpublic\RedsaberBundle\Entity\Pregunta 
     */
    public function getPregunta()
    {
        return $this->pregunta;
    }

    /**
     * Set dueno_institucion
     *
     * @param \Netpublic\CoreBundle\Entity\Colegio $duenoInstitucion
     * @return BancoPregunta
     */
    public function setDuenoInstitucion(\Netpublic\CoreBundle\Entity\Colegio $duenoInstitucion = null)
    {
        $this->dueno_institucion = $duenoInstitucion;

        return $this;
    }

    /**
     * Get dueno_institucion
     *
     * @return \Netpublic\CoreBundle\Entity\Colegio 
     */
    public function getDuenoInstitucion()
    {
        return $this->dueno_institucion;
    }
}
