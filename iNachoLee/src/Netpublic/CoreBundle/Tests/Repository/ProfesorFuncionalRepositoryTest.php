<?php
namespace Netpublic\CoreBundle\Tests\Repository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProfesorFuncionalRepositoryTest
 *
 * @author yuri
 */
class ProfesorFuncionalRepositoryTest extends WebTestCase {
    private $_em;
    public function setUp(){
        $kernel = static::createKernel();
        $kernel->boot();
        $this->_em = $kernel->getContainer()
                    ->get('doctrine.orm.entity_manager');
        
        
    }
    public function testGetEsHoraContratadasTodosProfesores(){
       /*   
        $repositorios=$this->_em
                ->getRepository("NetpublicCoreBundle:Profesor");
        $resultado=$repositorios->getEsHoraContratadasTodosProfesores();
        $this->assertEquals(-1,$resultado);
        //cumple con obligacion
        $grado=new \Netpublic\CoreBundle\Entity\Grado();
        $grado->setNombre("Primero");
        $this->_em->persist($grado);
        $grupo=new \Netpublic\CoreBundle\Entity\Grupo();
        $grupo->setGrado($grado);
        $grupo->setNombre("Primero A");
        $grado->addGrupo($grupo);
        $this->_em->persist($grupo);
        $asignatura=new \Netpublic\CoreBundle\Entity\Asignatura();
        $asignatura->setDuracionMinutos(120);
        $asignatura->setEsArea(FALSE);
        $asignatura->setFrucuenciaSemana(2);
        $asignatura->setGrado($grado);
        $asignatura->setNombre("Matematicas");
        $grado->addAsignatura($asignatura);
        $this->_em->persist($asignatura);
        $profesor=new \Netpublic\CoreBundle\Entity\Profesor();
        $profesor->setCedula("111");
        $profesor->setHorasTrabajoSemanales(20);
        $profesor->setNombre("mauel");
          $this->_em->persist($profesor);
        $contrato=new \Netpublic\CoreBundle\Entity\Contrato();
        $contrato->setAsignatura($asignatura);
        $contrato->setHorasBuffer(4);
        $contrato->setHorasContratadas(4);
        $contrato->setProfesorContrato($profesor);        
        $this->_em->persist($profesor);
        $this->_em->persist($contrato);
        $this->_em->flush();
        $resultado=$repositorios->getEsHoraContratadasTodosProfesores();
        $this->assertEquals(1,$resultado);
        //Que pasa Si la cantidad de horasContratadas no supera las horas de ñps grupos
        $contrato->setHorasBuffer(2);
        $contrato->setHorasContratadas(2);
       
        $this->_em->flush();
        $resultado=$repositorios->getEsHoraContratadasTodosProfesores();
        $this->assertEquals(-1,$resultado);
        //Que pasa cuando tenemos una asgitarua tipo AREA
        $area=new \Netpublic\CoreBundle\Entity\Asignatura();
        $area->setDuracionMinutos(120);
        $area->setEsArea(TRUE);
        $area->setFrucuenciaSemana(2);
        $area->setGrado($grado);
        $area->setNombre("Humanidades");
        $grado->addAsignatura($area);
        $this->_em->persist($area);
                //Modificamos la asigatura anterios
        $asignatura->setArea($area);
        $contrato->setHorasBuffer(4);
        $contrato->setHorasContratadas(4);
        $this->_em->persist($asignatura);
        
        $this->_em->flush();
        $resultado=$repositorios->getEsHoraContratadasTodosProfesores();
        $this->assertEquals(1,$resultado);
        //$this->_em->remove($profesor);
        //$this->_em->flush();
     */   
    }
}

?>
