<?php
namespace Netpublic\CoreBundle\Tests\Repository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CargaAcademicaFuncionalRepositoryTest
 *
 * @author yuri
 */
class CargaAcademicaFuncionalRepositoryTest  extends WebTestCase{
    private $_em;
    public function setUp(){
        $kernel = static::createKernel();
        $kernel->boot();
        $this->_em = $kernel->getContainer()
                    ->get('doctrine.orm.entity_manager');
        
        
    }
    public function testAsignarCargaAcademica(){
        
        /*$repositorios=$this->_em
                ->getRepository("NetpublicCoreBundle:CargaAcademica");       
        $grado=  $this->_em->getRepository("NetpublicCoreBundle:Grado")->find(1);
        $aula=  $this->_em->getRepository("NetpublicCoreBundle:Aula")->find(1);
        $Profesor=  $this->_em->getRepository("NetpublicCoreBundle:Profesor")->find(1);
        
        $hs_todos=$repositorios->verificarCargaAcademica();
        $es_viable_hc=$hs_todos['es_viable_hc'];
        $this->assertEquals(1,$es_viable_hc);
        
        $asignaturas=$grado->getAsignaturas();
        $grupos=$grado->getGrupo();
        $dia_inicio_jornada=1;
        $dia_final_jornada=7;
        $resultado=$repositorios->asignarCargaAcademica($asignaturas,$grupos[0],$dia_inicio_jornada,$dia_final_jornada);
        $this->assertEquals(2,$resultado); 
        
        $hor_clase=$aula->getHorarioClase();
        $hor_clase[1]->setDiaSemana(4);
        $grupo=new \Netpublic\CoreBundle\Entity\Grupo();
        $grupo->setGrado($grado);
        $grupo->setNombre("Primero A");
        $grado->addGrupo($grupo);
        $this->_em->persist($grupo);
        $this->_em->persist($hor_clase[1]);
        $this->_em->flush();
        $hs_todos=$repositorios->verificarCargaAcademica();
        $es_viable_hc=$hs_todos['es_viable_hc'];
        $this->assertEquals(1,$es_viable_hc);
        
        
        $resultado=$repositorios->asignarCargaAcademica($asignaturas,$grupos[0],$dia_inicio_jornada,$dia_final_jornada);
        $this->assertEquals(2,$resultado);
        //Devolvemos contexto
        //$this->_em->remove($profesor);
        //this->_em->flush();*/
    }
}

?>
