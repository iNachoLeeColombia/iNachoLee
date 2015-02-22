<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Netpublic\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="rest")
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Repository\RestRepository")
 */
class Rest 
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
     * @ORM\Column(type="string",nullable=false)
     */
    protected $udate;

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
     * Set udate
     *
     * @param string $udate
     * @return Rest
     */
    public function setUdate($udate)
    {
        $this->udate = $udate;

        return $this;
    }

    /**
     * Get udate
     *
     * @return string 
     */
    public function getUdate()
    {
        return $this->udate;
    }
}
