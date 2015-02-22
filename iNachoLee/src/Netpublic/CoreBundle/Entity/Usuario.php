<?php
namespace Netpublic\CoreBundle\Entity;
 
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
 
/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 */
class Usuario implements UserInterface, \Serializable

{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
 
    /**
     * @ORM\Column(name="usuario", type="string", length=255,nullable=true)
     */
    protected $username;
 
    /**
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;
 
    /**
     * @ORM\Column(name="salt", type="string", length=255,nullable=true)
     */
    protected $salt;
 
    /**
     * @ORM\ManyToMany(targetEntity="Rol")
     * @ORM\JoinTable(name="usuario_rol",
     *     joinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="rol_id", referencedColumnName="id")}
     * )
     */
    protected $user_rol;
    /**
     *
     * @ORM\OneToOne(targetEntity="Profesor",mappedBy="usuario")
     * 
     */
    protected $profesor;
    /**
     *
     * @ORM\OneToOne(targetEntity="Alumno",mappedBy="usuario")
     * 
     */    
    protected $alumno;
    /**
     *
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $es_alumno;
    /**
     *
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $es_cambio_contrasena;
    
    /**
    * @ORM\OneToMany(targetEntity="NoticiasUsuarios",mappedBy="usuarios")    
    */    
    protected $noticias_usuarios;
    /**
    * @ORM\OneToMany(targetEntity="Foto",mappedBy="usuario")   
     * 
     *      
     */    
    protected $foto;  
    
    protected $accountNonExpired;
    protected $credentialsNonExpired;
    protected $accountNonLocked;
    /**
     * @ORM\OneToMany(targetEntity="MensajeUsuario",mappedBy="destinatario")     
     */
    protected $mensaje_envio_d;
    /**
     * @ORM\OneToMany(targetEntity="MensajeUsuario",mappedBy="remitente")     
     */
    protected $mensaje_envio_r;
    /**
     *
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $es_cambio_fotoperfil;
     /**
     *
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $es_fotoperfil;

    public function serialize()
    {
       return serialize($this->getId());
    }
 
    public function unserialize($data)
    {
        $this->id = unserialize($data);
    }
    public function __toString() {
        $nombre= $this->username;
        return "$nombre";
    }
    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

   
    /**
     * {@inheritdoc}
     */
    public function isAccountNonExpired()
    {
        return $this->accountNonExpired;
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonLocked()
    {
        return $this->accountNonLocked;
    }

    /**
     * {@inheritdoc}
     */
    public function isCredentialsNonExpired()
    {
        return $this->credentialsNonExpired;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
    }

    /**
     * {@inheritDoc}
     */
     public function equals(UserInterface $user)
    {
       
       return md5($this->getUsername()) == md5($user->getUsername());
    }
    /**
     * Gets an array of roles.
     * 
     * @return array An array of Role objects
     */
    public function getRoles()
    {
        return $this->getUserRol()->toArray();
    }


  
    public function __construct()
    {
        $this->user_rol = new \Doctrine\Common\Collections\ArrayCollection();
    $this->noticias_usuarios = new \Doctrine\Common\Collections\ArrayCollection();
    $this->foto = new \Doctrine\Common\Collections\ArrayCollection();
    $this->mensaje_envio_d = new \Doctrine\Common\Collections\ArrayCollection();
    $this->mensaje_envio_r = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set es_alumno
     *
     * @param boolean $esAlumno
     */
    public function setEsAlumno($esAlumno)
    {
        $this->es_alumno = $esAlumno;
    }

    /**
     * Get es_alumno
     *
     * @return boolean 
     */
    public function getEsAlumno()
    {
        return $this->es_alumno;
    }

    /**
     * Set es_cambio_contrasena
     *
     * @param boolean $esCambioContrasena
     */
    public function setEsCambioContrasena($esCambioContrasena)
    {
        $this->es_cambio_contrasena = $esCambioContrasena;
    }

    /**
     * Get es_cambio_contrasena
     *
     * @return boolean 
     */
    public function getEsCambioContrasena()
    {
        return $this->es_cambio_contrasena;
    }

    /**
     * Add user_rol
     *
     * @param Netpublic\CoreBundle\Entity\Rol $userRol
     */
    public function addRol(\Netpublic\CoreBundle\Entity\Rol $userRol)
    {
        $this->user_rol[] = $userRol;
    }

    /**
     * Get user_rol
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUserRol()
    {
        return $this->user_rol;
    }

    /**
     * Set profesor
     *
     * @param Netpublic\CoreBundle\Entity\Profesor $profesor
     */
    public function setProfesor(\Netpublic\CoreBundle\Entity\Profesor $profesor)
    {
        $this->profesor = $profesor;
    }

    /**
     * Get profesor
     *
     * @return Netpublic\CoreBundle\Entity\Profesor 
     */
    public function getProfesor()
    {
        return $this->profesor;
    }

    /**
     * Set alumno
     *
     * @param Netpublic\CoreBundle\Entity\Alumno $alumno
     */
    public function setAlumno(\Netpublic\CoreBundle\Entity\Alumno $alumno)
    {
        $this->alumno = $alumno;
    }

    /**
     * Get alumno
     *
     * @return Netpublic\CoreBundle\Entity\Alumno 
     */
    public function getAlumno()
    {
        return $this->alumno;
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
------------------------------------------------------------
     * 
     * 
     *      * Add foto
     *
     * @param Netpublic\CoreBundle\Entity\Foto $foto
     */
    public function addFoto(\Netpublic\CoreBundle\Entity\Foto $foto)
    {
        $this->foto[] = $foto;
    }

    /**
     * Get foto
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Add mensaje_envio_d
     *
     * @param Netpublic\CoreBundle\Entity\MensajeUsuario $mensajeEnvioD
     */
    public function addMensajeUsuario(\Netpublic\CoreBundle\Entity\MensajeUsuario $mensajeEnvioD)
    {
        $this->mensaje_envio_d[] = $mensajeEnvioD;
    }

    /**
     * Get mensaje_envio_d
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMensajeEnvioD()
    {
        return $this->mensaje_envio_d;
    }

    /**
     * Get mensaje_envio_r
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMensajeEnvioR()
    {
        return $this->mensaje_envio_r;
    }

    /**
     * Set es_cambio_fotoperfil
     *
     * @param boolean $esCambioFotoperfil
     */
    public function setEsCambioFotoperfil($esCambioFotoperfil)
    {
        $this->es_cambio_fotoperfil = $esCambioFotoperfil;
    }

    /**
     * Get es_cambio_fotoperfil
     *
     * @return boolean 
     */
    public function getEsCambioFotoperfil()
    {
        return $this->es_cambio_fotoperfil;
    }

    /**
     * Set es_fotoperfil
     *
     * @param boolean $esFotoperfil
     */
    public function setEsFotoperfil($esFotoperfil)
    {
        $this->es_fotoperfil = $esFotoperfil;
    }

    /**
     * Get es_fotoperfil
     *
     * @return boolean 
     */
    public function getEsFotoperfil()
    {
        return $this->es_fotoperfil;
    }

    /**
     * Add user_rol
     *
     * @param \Netpublic\CoreBundle\Entity\Rol $userRol
     * @return Usuario
     */
    public function addUserRol(\Netpublic\CoreBundle\Entity\Rol $userRol)
    {
        $this->user_rol[] = $userRol;
    
        return $this;
    }

    /**
     * Remove user_rol
     *
     * @param \Netpublic\CoreBundle\Entity\Rol $userRol
     */
    public function removeUserRol(\Netpublic\CoreBundle\Entity\Rol $userRol)
    {
        $this->user_rol->removeElement($userRol);
    }

    /**
     * Add noticias_usuarios
     *
     * @param \Netpublic\CoreBundle\Entity\NoticiasUsuarios $noticiasUsuarios
     * @return Usuario
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

    /**
     * Remove foto
     *
     * @param \Netpublic\CoreBundle\Entity\Foto $foto
     */
    public function removeFoto(\Netpublic\CoreBundle\Entity\Foto $foto)
    {
        $this->foto->removeElement($foto);
    }

    /**
     * Add mensaje_envio_d
     *
     * @param \Netpublic\CoreBundle\Entity\MensajeUsuario $mensajeEnvioD
     * @return Usuario
     */
    public function addMensajeEnvioD(\Netpublic\CoreBundle\Entity\MensajeUsuario $mensajeEnvioD)
    {
        $this->mensaje_envio_d[] = $mensajeEnvioD;
    
        return $this;
    }

    /**
     * Remove mensaje_envio_d
     *
     * @param \Netpublic\CoreBundle\Entity\MensajeUsuario $mensajeEnvioD
     */
    public function removeMensajeEnvioD(\Netpublic\CoreBundle\Entity\MensajeUsuario $mensajeEnvioD)
    {
        $this->mensaje_envio_d->removeElement($mensajeEnvioD);
    }

    /**
     * Add mensaje_envio_r
     *
     * @param \Netpublic\CoreBundle\Entity\MensajeUsuario $mensajeEnvioR
     * @return Usuario
     */
    public function addMensajeEnvioR(\Netpublic\CoreBundle\Entity\MensajeUsuario $mensajeEnvioR)
    {
        $this->mensaje_envio_r[] = $mensajeEnvioR;
    
        return $this;
    }

    /**
     * Remove mensaje_envio_r
     *
     * @param \Netpublic\CoreBundle\Entity\MensajeUsuario $mensajeEnvioR
     */
    public function removeMensajeEnvioR(\Netpublic\CoreBundle\Entity\MensajeUsuario $mensajeEnvioR)
    {
        $this->mensaje_envio_r->removeElement($mensajeEnvioR);
    }
}
