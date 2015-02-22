<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MensajeUsuario
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="mensaje_usuario")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\MensajeUsuarioRepository")
 */

class MensajeUsuario {
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
     /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $fecha_envio;
     /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $fecha_lectura;
     /**
     * @ORM\ManyToOne(targetEntity="Usuario",inversedBy="mensaje_envio_d")     
     */
    protected $destinatario;
     /**
     * @ORM\ManyToOne(targetEntity="Usuario",inversedBy="mensaje_envio_r")     
     */
    protected $remitente;
     /**
     * @ORM\ManyToOne(targetEntity="Mensaje",inversedBy="mensaje_envio")     
     */
    protected $mensaje;
     /**
     * @ORM\Column(type="boolean",nullable=true)
     */
     protected $es_leido;

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
     * Set fecha_envio
     *
     * @param \DateTime $fechaEnvio
     * @return MensajeUsuario
     */
    public function setFechaEnvio($fechaEnvio)
    {
        $this->fecha_envio = $fechaEnvio;
    
        return $this;
    }

    /**
     * Get fecha_envio
     *
     * @return \DateTime 
     */
    public function getFechaEnvio()
    {
        return $this->fecha_envio;
    }

    /**
     * Set fecha_lectura
     *
     * @param \DateTime $fechaLectura
     * @return MensajeUsuario
     */
    public function setFechaLectura($fechaLectura)
    {
        $this->fecha_lectura = $fechaLectura;
    
        return $this;
    }

    /**
     * Get fecha_lectura
     *
     * @return \DateTime 
     */
    public function getFechaLectura()
    {
        return $this->fecha_lectura;
    }

    /**
     * Set es_leido
     *
     * @param boolean $esLeido
     * @return MensajeUsuario
     */
    public function setEsLeido($esLeido)
    {
        $this->es_leido = $esLeido;
    
        return $this;
    }

    /**
     * Get es_leido
     *
     * @return boolean 
     */
    public function getEsLeido()
    {
        return $this->es_leido;
    }

    /**
     * Set destinatario
     *
     * @param \Netpublic\CoreBundle\Entity\Usuario $destinatario
     * @return MensajeUsuario
     */
    public function setDestinatario(\Netpublic\CoreBundle\Entity\Usuario $destinatario = null)
    {
        $this->destinatario = $destinatario;
    
        return $this;
    }

    /**
     * Get destinatario
     *
     * @return \Netpublic\CoreBundle\Entity\Usuario 
     */
    public function getDestinatario()
    {
        return $this->destinatario;
    }

    /**
     * Set remitente
     *
     * @param \Netpublic\CoreBundle\Entity\Usuario $remitente
     * @return MensajeUsuario
     */
    public function setRemitente(\Netpublic\CoreBundle\Entity\Usuario $remitente = null)
    {
        $this->remitente = $remitente;
    
        return $this;
    }

    /**
     * Get remitente
     *
     * @return \Netpublic\CoreBundle\Entity\Usuario 
     */
    public function getRemitente()
    {
        return $this->remitente;
    }

    /**
     * Set mensaje
     *
     * @param \Netpublic\CoreBundle\Entity\Mensaje $mensaje
     * @return MensajeUsuario
     */
    public function setMensaje(\Netpublic\CoreBundle\Entity\Mensaje $mensaje = null)
    {
        $this->mensaje = $mensaje;
    
        return $this;
    }

    /**
     * Get mensaje
     *
     * @return \Netpublic\CoreBundle\Entity\Mensaje 
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }
}
