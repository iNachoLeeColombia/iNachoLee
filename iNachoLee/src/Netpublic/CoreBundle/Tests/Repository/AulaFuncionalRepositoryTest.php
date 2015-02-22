<?php
namespace Netpublic\CoreBundle\Tests\Repository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Netpublic\CoreBundle\Entity\Aula;

/**
 * Description of HorarioAulaFuncionalRepositoryTest
 *
 * @author yuri
 */
class AulaFuncionalRepositoryTest extends WebTestCase{
    private $_em;
    public function setUp(){
        $kernel = static::createKernel();
        $kernel->boot();
        $this->_em = $kernel->getContainer()
                    ->get('doctrine.orm.entity_manager');
        
        
    }
    public function testgenerarHorariosAllAulas(){
        //Borramos aulas.               
        /*$repositorios=$this->_em
                ->getRepository("NetpublicCoreBundle:Aula");
        $resultado=$repositorios->generarHorariosAllAulas();
        //Numero de Aulas 1
        $this->assertEquals(126,$resultado);*/
    }
    public function testGetEsHorasDisponiblesAulas(){
       /*$repositorios=$this->_em
                ->getRepository("NetpublicCoreBundle:Aula"); 
       
       $resultado=$repositorios->getEsHorasDisponiblesAulas();
       $this->assertEquals(1,$resultado);
      
       //Cumple responsabilidad, aun cuando no tine aulas
       $aula=$repositorios->find(1);
       $h_clase=$aula->getHorarioClase();
       $h_clase[0]->setHoraInicio(0);
       $h_clase[0]->setHoraFinal(0);
       $h_clase[1]->setHoraInicio(0);
       $h_clase[1]->setHoraFinal(0);
       $this->_em->persist($h_clase[0]);
       $this->_em->persist($h_clase[1]);
       $this->_em->flush();
       $resultado=$repositorios->getEsHorasDisponiblesAulas();
       $this->assertEquals(-1,$resultado);
       $h_clase[0]->setHoraInicio(6);
       $h_clase[0]->setHoraFinal(12);
       $h_clase[1]->setHoraInicio(14);
       $h_clase[1]->setHoraFinal(20);
       $this->_em->persist($h_clase[0]);
       $this->_em->persist($h_clase[1]);
       $this->_em->flush();
       */
    }

}