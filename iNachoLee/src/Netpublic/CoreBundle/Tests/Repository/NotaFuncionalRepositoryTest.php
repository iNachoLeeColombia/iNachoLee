<?php
namespace Netpublic\CoreBundle\Tests\Repository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Netpublic\CoreBundle\Repository\NotaRepository;

use Symfony\Bundle\DoctrineFixturesBundle\Common\DataFixtures\Loader as DataFixturesLoader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotaRepositoyTest
 *
 * @author yuri
 */
class NotaFuncionalRepositoryTest  extends WebTestCase  {
    private $_em;
    /*public function setUp(){
        $kernel = static::createKernel();
        $kernel->boot();
        $this->_em = $kernel->getContainer()
                    ->get('doctrine.orm.entity_manager');
        
    }*/
   /*public function testCalificarGrupo(){
        $repositorio=$this->_em
                ->getRepository("NetpublicCoreBundle:AlumnoDimension");
        $notas_alum_dimensiones=array();
        $notas=array();
        
        $notas_alum_dimensiones[]=$repositorio->find(1);
        $notas[]=2.5;
        //prueba calificar nota a un solo alumno
        $this->assertEquals($repositorio->calificarGrupo($notas_alum_dimensiones,$notas), count($notas_alum_dimensiones));
        //Prueba Calificar varios alumnos
        $notas_alum_dimensiones[]=$repositorio->find(2);
        $notas[]=2.8;
        $this->assertEquals($repositorio->calificarGrupo($notas_alum_dimensiones,$notas), count($notas_alum_dimensiones));
        //Prueba No Calificar cuando tenemos mas notas que alumnos
        $notas_alum_dimensiones[]=$repositorio->find(3);
        $this->assertEquals($repositorio->calificarGrupo($notas_alum_dimensiones,$notas),0);
        //Prueba no tener alumnos ni notas
        $notas_alum_dimensiones=array();
        $notas=array();
        $this->assertEquals($repositorio->calificarGrupo($notas_alum_dimensiones,$notas), count($notas_alum_dimensiones));
        
        
    }*/

}

?>
