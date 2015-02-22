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
 * @ORM\Table(name="plantilla_bc3")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\plantillaRepository")
 */

class Plantillabc3 {
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="text")   
     * 
     */
    protected $contenido;
    /**
     * @ORM\Column(type="integer")   
     * 
     */
    protected $referecnia;
     /**
     * @ORM\Column(type="integer")   
     * 
     *tipo=0  Boletin
     *tipo=1  Constancia
     *tipo=2  Certificado
     *tipo=3  carnet      
     */
    protected $tipo;

    /**
     * @ORM\Column(type="text")   
     * 
     */
    protected $contenido_estatico;


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
     * Set contenido
     *
     * @param string $contenido
     * @return Plantillabc3
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return string 
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set referecnia
     *
     * @param integer $referecnia
     * @return Plantillabc3
     */
    public function setReferecnia($referecnia)
    {
        $this->referecnia = $referecnia;

        return $this;
    }

    /**
     * Get referecnia
     *
     * @return integer 
     */
    public function getReferecnia()
    {
        return $this->referecnia;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     * @return Plantillabc3
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
     * Set contenido_estatico
     *
     * @param string $contenidoEstatico
     * @return Plantillabc3
     */
    public function setContenidoEstatico($contenidoEstatico)
    {
        $this->contenido_estatico = $contenidoEstatico;

        return $this;
    }

    /**
     * Get contenido_estatico
     *
     * @return string 
     */
    public function getContenidoEstatico()
    {
        return $this->contenido_estatico;
    }
}
