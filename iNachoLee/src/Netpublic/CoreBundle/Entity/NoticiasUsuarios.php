<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NoticiasUsuarios
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Netpublic\CoreBundle\Entity\Usuario;
/**
 * @ORM\Entity
 * @ORM\Table(name="noticias_usuarios")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\NoticiasUsuariosRepository")
 */
class NoticiasUsuarios {
         /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     *
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $es_leida;
        
    /**
    * @ORM\ManyToOne(targetEntity="Usuario",inversedBy="noticias_usuarios")    
    */    
    protected $usuarios;
    /**
    * @ORM\ManyToOne(targetEntity="Noticia",inversedBy="noticias_usuarios")    
    */    
    protected $noticias; 
    

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
     * Set es_leida
     *
     * @param boolean $esLeida
     */
    public function setEsLeida($esLeida)
    {
        $this->es_leida = $esLeida;
    }

    /**
     * Get es_leida
     *
     * @return boolean 
     */
    public function getEsLeida()
    {
        return $this->es_leida;
    }

    /**
     * Set usuarios
     *
     * @param Netpublic\CoreBundle\Entity\Usuario $usuarios
     */
    public function setUsuarios(\Netpublic\CoreBundle\Entity\Usuario $usuarios)
    {
        $this->usuarios = $usuarios;
    }

    /**
     * Get usuarios
     *
     * @return Netpublic\CoreBundle\Entity\Usuario 
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    /**
     * Set noticias
     *
     * @param Netpublic\CoreBundle\Entity\Noticia $noticias
     */
    public function setNoticias(\Netpublic\CoreBundle\Entity\Noticia $noticias)
    {
        $this->noticias = $noticias;
    }

    /**
     * Get noticias
     *
     * @return Netpublic\CoreBundle\Entity\Noticia 
     */
    public function getNoticias()
    {
        return $this->noticias;
    }
}
