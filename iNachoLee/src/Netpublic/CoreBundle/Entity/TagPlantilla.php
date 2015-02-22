<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ActividadDesempeno
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="tag_plantilla_bc3")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\tagplantillaRepository")
 */

class TagPlantilla {
         /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string")   
     * 
     */
    protected $tag;
    /**
     * @ORM\Column(type="string")   
     * 
     */
    protected $label;
    
    
    /**
     * @ORM\Column(type="integer",nullable=true)   
     * 
     */
    protected $referencia;
    

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
     * Set tag
     *
     * @param string $tag
     * @return TagPlantilla
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string 
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set referencia
     *
     * @param integer $referencia
     * @return TagPlantilla
     */
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;

        return $this;
    }

    /**
     * Get referencia
     *
     * @return integer 
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * Set label
     *
     * @param string $label
     * @return TagPlantilla
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string 
     */
    public function getLabel()
    {
        return $this->label;
    }
}
