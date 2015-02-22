<?php

namespace Netpublic\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AnoGrado
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Netpublic\CoreBundle\Entity\AnoGradoRepository")
 */
class AnoGrado
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
