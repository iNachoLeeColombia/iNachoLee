<?php
namespace Netpublic\CoreBundle\Tests\Repository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Netpublic\CoreBundle\Entity\Aula;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GradoFuncionalRepositoryTest
 *
 * @author yuri
 */
class GradoFuncionalRepositoryTest extends WebTestCase{
    private $_em;
    public function setUp(){
        $kernel = static::createKernel();
        $kernel->boot();
        $this->_em = $kernel->getContainer()
                    ->get('doctrine.orm.entity_manager');       
        
    }
    public function testGetHorasNecesariasTodoGrupos(){
       /* 
        $repositorios=$this->_em
                ->getRepository("NetpublicCoreBundle:Grado");
        $resultado=$repositorios->getHorasNecesariasTodoGrupos();
        //Que pasa cuando Grupos,Asignaturas,Grados.        
        $this->assertEquals(0,$resultado);
        //Que pasa cuando tenemos solo grupo y Grado.
        $grado=new \Netpublic\CoreBundle\Entity\Grado();
        $grado->setNombre("Primero");
        $this->_em->persist($grado);
        $grupo=new \Netpublic\CoreBundle\Entity\Grupo();
        $grupo->setNombre("Primero A");
        $grupo->setGrado($grado);
        $this->_em->persist($grupo);
        $this->_em->flush();
        $resultado=$repositorios->getHorasNecesariasTodoGrupos();
        $this->assertEquals(0,$resultado);
        //Que pasa Cuando hay Grados,Asignaturas pero no tenemos Grupo.
        //Eliminino grupo
        $this->_em->remove($grupo);
        $this->_em->flush();
        //Area
        $area=new \Netpublic\CoreBundle\Entity\Asignatura();
        $area->setNombre("Ciencias Exactas.");        
        $area->setEsArea(TRUE);        
        $area->setGrado($grado);
        $this->_em->persist($area);
        //Asignaturas
        $asiganturas=new \Netpublic\CoreBundle\Entity\Asignatura();
        $asiganturas->setNombre("Matematicas");
        $asiganturas->setDuracionMinutos(120);
        $asiganturas->setEsArea(FALSE);
        $asiganturas->setFrucuenciaSemana(2);
        $asiganturas->setGrado($grado);
        $grado->addAsignatura($asiganturas);
        $this->_em->persist($asiganturas);
        $this->_em->flush();
        $resultado=$repositorios->getHorasNecesariasTodoGrupos();
        $this->assertEquals(0,$resultado);
        //Cumple su responsabilidad?
        $grupo1=new \Netpublic\CoreBundle\Entity\Grupo();
        $grupo1->setNombre("Primero A");
        $grupo1->setGrado($grado);
        $this->_em->persist($grupo1);
        $grupo2=new \Netpublic\CoreBundle\Entity\Grupo();
        $grupo2->setNombre("Primero B");
        $grupo2->setGrado($grado);
        $this->_em->persist($grupo2);
        $grupo3=new \Netpublic\CoreBundle\Entity\Grupo();
        $grupo3->setNombre("Primero C");
        $grupo3->setGrado($grado);        
        $this->_em->persist($grupo3);
        //adiciones
        $grado->addGrupo($grupo1);
        $grado->addGrupo($grupo2);
        $grado->addGrupo($grupo3);
        $this->_em->flush();
        $resultado=$repositorios->getHorasNecesariasTodoGrupos();
        $this->assertEquals(12,$resultado);
     */   
    }
}

?>
