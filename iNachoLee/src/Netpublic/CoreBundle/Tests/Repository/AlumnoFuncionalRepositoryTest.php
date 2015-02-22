<?php
namespace Netpublic\CoreBundle\Tests\Repository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Netpublic\CoreBundle\Entity\Grupo;
use Netpublic\CoreBundle\Entity\Alumno;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AlumnoRepository
 *
 * @author yuri
 */
class AlumnoFuncionalRepositoryTest extends WebTestCase{
    private $_em;
    /*public function setUp(){
        $kernel = static::createKernel();
        $kernel->boot();
        $this->_em = $kernel->getContainer()
                    ->get('doctrine.orm.entity_manager');
        
        
    }*/
    /*public function testListarAlumnoGrupo(){
        $grupo=1;
        $alumnos=$this->_em
                ->getRepository("NetpublicCoreBundle:Alumno")
                ->listarAlumnosGrupo($grupo)->getResult();
        //Prueba que se listen los alumnos de un grupo determinado
        //$this->assertEquals(count($alumnos),50);
        
    }*/
    
}

?>
