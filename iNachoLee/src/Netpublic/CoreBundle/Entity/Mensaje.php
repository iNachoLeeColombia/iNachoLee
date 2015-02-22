<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mensaje
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="mensaje")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\mensajeRepository")
 */

class Mensaje {
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\OneToMany(targetEntity="MensajeUsuario",mappedBy="mensaje")     
     */
    protected $mensaje_envio;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $cuerpo_html;
    /**
     *Tipos De Notificacion.
     * TIPO=0 Mensaje Normal
     * TIPO=1 Mensaje LLamada de Atencion Malo
     * TIPo=2 Mesanje De Felicitaciones 
     */
    /**
     * @ORM\Column(type="integer")
     */
    protected $tipo;
    /**
     * @ORM\Column(type="string")
     */
    protected $destino;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $url_doc_adjunto;
    /**
     *@ORM\Column(type="boolean",nullable=true)
     * 
     */
    protected $es_documento_adjunto;
    public $doc_adjunto;
     /**
     * @ORM\Column(type="string")
     */
    protected $asunto;
    public function __toString() {
        return $this->asunto;
    }


    public function __construct()
    {
        $this->mensaje_envio = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set cuerpo_html
     *
     * @param text $cuerpoHtml
     */
    public function setCuerpoHtml($cuerpoHtml)
    {
        $this->cuerpo_html = $cuerpoHtml;
    }

    /**
     * Get cuerpo_html
     *
     * @return text 
     */
    public function getCuerpoHtml()
    {
        return $this->cuerpo_html;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
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
     * Set destino
     *
     * @param string $destino
     */
    public function setDestino($destino)
    {
        $this->destino = $destino;
    }

    /**
     * Get destino
     *
     * @return string 
     */
    public function getDestino()
    {
        return $this->destino;
    }

    /**
     * Set url_doc_adjunto
     *
     * @param string $urlDocAdjunto
     */
    public function setUrlDocAdjunto($urlDocAdjunto)
    {
        $this->url_doc_adjunto = $urlDocAdjunto;
    }

    /**
     * Get url_doc_adjunto
     *
     * @return string 
     */
    public function getUrlDocAdjunto()
    {
        return $this->url_doc_adjunto;
    }

    /**
     * Set es_documento_adjunto
     *
     * @param boolean $esDocumentoAdjunto
     */
    public function setEsDocumentoAdjunto($esDocumentoAdjunto)
    {
        $this->es_documento_adjunto = $esDocumentoAdjunto;
    }

    /**
     * Get es_documento_adjunto
     *
     * @return boolean 
     */
    public function getEsDocumentoAdjunto()
    {
        return $this->es_documento_adjunto;
    }

    /**
     * Set asunto
     *
     * @param string $asunto
     */
    public function setAsunto($asunto)
    {
        $this->asunto = $asunto;
    }

    /**
     * Get asunto
     *
     * @return string 
     */
    public function getAsunto()
    {
        return $this->asunto;
    }

    /**
     * Add mensaje_envio
     *
     * @param Netpublic\CoreBundle\Entity\MensajeUsuario $mensajeEnvio
     */
    public function addMensajeUsuario(\Netpublic\CoreBundle\Entity\MensajeUsuario $mensajeEnvio)
    {
        $this->mensaje_envio[] = $mensajeEnvio;
    }

    /**
     * Get mensaje_envio
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMensajeEnvio()
    {
        return $this->mensaje_envio;
    }

    /**
     * Add mensaje_envio
     *
     * @param \Netpublic\CoreBundle\Entity\MensajeUsuario $mensajeEnvio
     * @return Mensaje
     */
    public function addMensajeEnvio(\Netpublic\CoreBundle\Entity\MensajeUsuario $mensajeEnvio)
    {
        $this->mensaje_envio[] = $mensajeEnvio;
    
        return $this;
    }

    /**
     * Remove mensaje_envio
     *
     * @param \Netpublic\CoreBundle\Entity\MensajeUsuario $mensajeEnvio
     */
    public function removeMensajeEnvio(\Netpublic\CoreBundle\Entity\MensajeUsuario $mensajeEnvio)
    {
        $this->mensaje_envio->removeElement($mensajeEnvio);
    }
}
