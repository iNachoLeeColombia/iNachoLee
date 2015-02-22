<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Noticia
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Netpublic\CoreBundle\Entity\Usuario;
/**
 * @ORM\Entity
 * @ORM\Table(name="noticia")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\NoticiaRepository")
 */
class Noticia {
     /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     *
     * @ORM\Column(type="string")
     */
    protected $nombre;
    /**
     *
     * @ORM\Column(type="integer")
     */
    //Tipos de noticias
    //tipo=1 Noticias de llenado obligado
    //tipo=2  Noticias de Notificar
    //tipo=3 Noticias de Publicidad y de la red inacholee.com
    protected $tipo;
    
    /**
    * @ORM\OneToMany(targetEntity="NoticiasUsuarios",mappedBy="noticias")    
    */    
    protected $noticias_usuarios;
    /**
     *
     * @ORM\Column(type="string")
     */
    protected $contenido;

    public function __construct()
    {
        $this->noticias_usuarios = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
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
     * Set contenido
     *
     * @param string $contenido
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;
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
     * Add noticias_usuarios
     *
     * @param Netpublic\CoreBundle\Entity\NoticiasUsuarios $noticiasUsuarios
     */
    public function addNoticiasUsuarios(\Netpublic\CoreBundle\Entity\NoticiasUsuarios $noticiasUsuarios)
    {
        $this->noticias_usuarios[] = $noticiasUsuarios;
    }

    /**
     * Get noticias_usuarios
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getNoticiasUsuarios()
    {
        return $this->noticias_usuarios;
    }

    /**
     * Add noticias_usuarios
     *
     * @param \Netpublic\CoreBundle\Entity\NoticiasUsuarios $noticiasUsuarios
     * @return Noticia
     */
    public function addNoticiasUsuario(\Netpublic\CoreBundle\Entity\NoticiasUsuarios $noticiasUsuarios)
    {
        $this->noticias_usuarios[] = $noticiasUsuarios;
    
        return $this;
    }

    /**
     * Remove noticias_usuarios
     *
     * @param \Netpublic\CoreBundle\Entity\NoticiasUsuarios $noticiasUsuarios
     */
    public function removeNoticiasUsuario(\Netpublic\CoreBundle\Entity\NoticiasUsuarios $noticiasUsuarios)
    {
        $this->noticias_usuarios->removeElement($noticiasUsuarios);
    }
}
