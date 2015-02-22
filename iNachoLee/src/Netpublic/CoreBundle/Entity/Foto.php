<?php

namespace Netpublic\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Foto
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    public $name;
    
/**
 * @Assert\File(maxSize="6000000")
 */
public $file;
    
    /**
    * @ORM\ManyToOne(targetEntity="Usuario",inversedBy="foto")    
    */    
    protected $usuario;    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;
    public function __toString() {
        return $this->name;
    }

 
    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads/documents';
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set usuario
     *
     * @param Netpublic\CoreBundle\Entity\Usuario $usuario
     */
    public function setUsuario(\Netpublic\CoreBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Get usuario
     *
     * @return Netpublic\CoreBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
   /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            $this->path = $this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // you must throw an exception here if the file cannot be moved
        // so that the entity is not persisted to the database
        // which the UploadedFile move() method does
        $this->file->move($this->getUploadRootDir(), $this->id.'.'.$this->file->guessExtension());

        unset($this->file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($this->file = $this->getAbsolutePath()) {
            unlink($this->file);
        }
    }

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->id.'.'.$this->path;
    }



}
