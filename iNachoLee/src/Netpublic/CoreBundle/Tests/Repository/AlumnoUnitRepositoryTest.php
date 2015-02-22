<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AlumnoUnitRepository
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Tests\Repository;

use Doctrine\Tests\OrmTestCase;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping\Driver\DriverChain;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Netpublic\CoreBundle\Entity\Grupo;
class AlumnoUnitRepositoryTest extends OrmTestCase{
    private $_em;
    /*public function setUp(){
        $reader = new AnnotationReader();
        $reader->setIgnoreNotImportedAnnotations(true);
        $reader->setEnableParsePhpImports(true);
        $metadataDriver = new AnnotationDriver(
            $reader,
            // provide the namespace of the entities you want to tests
            'Ntp\\InacholeeBundle\\Entity'
        );

        $this->_em = $this->_getTestEntityManager();

        $this->_em->getConfiguration()
            ->setMetadataDriverImpl($metadataDriver);

        // allows you to use the AcmeProductBundle:Product syntax
        $this->_em->getConfiguration()->setEntityNamespaces(array(
            'NetpublicCoreBundle' => 'Ntp\\InacholeeBundle\\Entity'
        ));
    }*/
    /*public function testListarAlumnosGrupo(){
        
        $query=$this->_em->getRepository("NetpublicCoreBundle:Alumno")
                ->listarAlumnosGrupo('1');
        
        $this->assertEquals("SELECT a FROM NetpublicCoreBundle:Alumno a JOIN a.grupo g WHERE g.id=:id",$query->getDql());
        
    }*/
}

?>
