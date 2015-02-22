<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PreguntaIcfes
 *
 * @author yuri
 */
namespace Netpublic\CoreBundle\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class CopiarCargasCommand  extends ContainerAwareCommand{
    //put your code here
        protected function configure()
    {
        $this
            ->setName('iNachoLee:copiarcargas')
            ->setDefinition(array(
                new InputOption('accion', false, InputOption::VALUE_OPTIONAL, 'Preguntas Temporales')
            ))
            ->setDescription('Genera Slug y Linea de academica');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        

        $output->writeln(sprintf('Copiando cargas. Espere...' ));
        $contenedor = $this->getContainer();
        $em = $contenedor->get('doctrine')->getManager();
        $primer_ano=$em->getRepository("NetpublicCoreBundle:Dimension")->findOneBy(
                array('tipo'=>0),
                array('id'=>"ASC")
                );
        $segundo_ano=$em->getRepository("NetpublicCoreBundle:Dimension")->findOneBy(
                array('tipo'=>0),
                array('id'=>"DESC")
                );
        echo "$primer_ano $segundo_ano";
        $query="SELECT c FROM NetpublicCoreBundle:CargaAcademica c ";
        $query.=" WHERE (";                                    
        $query.=" c.profesor IS NULL";
        $query.=" )";                          
        $cargas=$em->createQuery($query)->getResult(); 
        foreach ($cargas as $c) {
            $em->remove($c);
        }
        $em->flush();
        $query="SELECT c FROM NetpublicCoreBundle:CargaAcademica c ";
        $query.=" WHERE (";                                    
        $query.=" c.profesor IS NOT NULL";
        $query.=" )";                          
        $cargas=$em->createQuery($query)->getResult();        
        foreach ($cargas as $c) {           
            $c->setAnoEscolar($segundo_ano);
            $em->persist($c);
            if($primer_ano){
                $c_a=new \Netpublic\CoreBundle\Entity\CargaAcademica();
                $c_a->setAsignatura($c->getAsignatura());
                $c_a->setProfesor($c->getProfesor());
                $c_a->setGrupo($c->getGrupo());
                $c_a->setTieneProfesor(TRUE);
                $c_a->setAnoEscolar($primer_ano);
                $c_a->setEsCargaAcademica(TRUE);
                $em->persist($c_a);
        
            }
            echo "$c";
        }
       $em->flush();
       $mis_cargas=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findAll();
       foreach ($mis_cargas as $mi) {
           $anos=$em->getRepository("NetpublicCoreBundle:Dimension")->findBy(
                array('tipo'=>0),
                array('id'=>"ASC")
                );
                foreach ($anos as $a) {                    
                    $cargas_v=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
                            'grupo'=>$mi->getGrupo()->getId(),
                            'asignatura'=>$mi->getAsignatura()->getId(),
                            'ano_escolar'=>$a->getId()    
                             ));
                    if(count($cargas_v>=2)){
                        foreach ($cargas_v as $c2) {
                            
                        $desempenos=$c2->getDesempeno();
                        if(count($desempenos)<=0){
                            $em->remove($c2);                        
                        }
                        else{
                            ;
                        }
                        }
                        
                                           }
                }
       }
       $em->flush();
       
    }
}
?>
