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

class COnfigurarMatriculaCommand  extends ContainerAwareCommand{
    //put your code here
        protected function configure()
    {
        $this
            ->setName('iNachoLee:ConfigurarMatricula')
            ->setDefinition(array(
                new InputOption('accion', false, InputOption::VALUE_OPTIONAL, 'Preguntas Temporales')
            ))
            ->setDescription('Generar Matricula para los años antes de 2014');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        ini_set('memory_limit', '-1');    
        set_time_limit(0);        
        $output->writeln(sprintf('Configurando las matriculas de Agrociola. Espere...' ));
        $contenedor = $this->getContainer();
        $em = $contenedor->get('doctrine')->getManager();
        $anos_escolares=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolares();
        
        $grado_id=13;
        $alumnos= $em->getRepository("NetpublicCoreBundle:Alumno")->findBy(array(
            'tipo'=>0
        //    'grado'=>$grado_id
        ));
        $grado=$em->getRepository("NetpublicCoreBundle:Grado")->find($grado_id);
        $output->writeln(sprintf("Nro alumnos $grado".  count($alumnos) ));
        
        $index=0;
        /*foreach ($alumnos as $alumno) {
            if($index>=800 && $index<=1500){
                foreach ($anos_escolares as $ano) {
                $matricula_ano=  $em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findOneBy(array(
                    'ano'=>$ano->getId(),
                    'alumno'=>$alumno->getId()
                ));
                //$output->writeln(sprintf($alumno));

                if ($matricula_ano) {
                    $matricula_ano->setGrupo($alumno->getGrupo());
                    $em->persist($matricula_ano);
                }
                else{
                        $matricula=new \Netpublic\CoreBundle\Entity\MatriculaAlumno();
                        $matricula->setGrupo($alumno->getGrupo());
                        $matricula->setAlumno($alumno);
                        $matricula->setAno($ano);
                        $matricula->setEsMatricula(TRUE);
                        $matricula->setEsPagoMatricula(TRUE);
                        $matricula->setEsPapeles(TRUE);
                        $matricula->setEsMatricula(TRUE);
                        $matricula->setObservaciones("..");                        
                        $em->persist($matricula);            
                        //$output->writeln(sprintf($alumno));
                }
                if(($index%50)==0){
                    $em->flush();
                    $output->writeln(sprintf("50++...".$index));
                }
        
            }
           }
            $index++;
        }       
        */
        $output->writeln(sprintf('listo'));
        $output->writeln(sprintf('Gerenado cargas adacemicas'));
        $grupos=$em->getRepository("NetpublicCoreBundle:Grupo")->findAll();
        $output->writeln(sprintf("Nro grupos".  count($grupos)));
        
        $index2=0;
        foreach ($grupos as $grupo) {
            if($index2>=0 && $index2<=800){
            $asignaturas=$em->getRepository("NetpublicCoreBundle:Asignatura")->findBy(array(
                'grado'=>$grupo->getGrado()->getId(),
                'es_area'=>0
            ));
            foreach ($asignaturas as $asg) {
                foreach ($anos_escolares as $mi_ano) {                    
                    $ca=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findOneBy(array(
                        'grupo'=>$grupo->getId(),
                        'asignatura'=>$asg->getId(),
                        'ano_escolar'=>$mi_ano->getId()
                    ));
                    if($ca){
                        ;
                    }
                    else{
                        $nueva_carga=new \Netpublic\CoreBundle\Entity\CargaAcademica();
                        $nueva_carga->setAnoEscolar($mi_ano);
                        $nueva_carga->setAsignatura($asg);
                        $nueva_carga->setEsCargaAcademica(TRUE);
                        $nueva_carga->setEstadoAsignacion(FALSE);
                        $nueva_carga->setGrupo($grupo);
                        $nueva_carga->setTieneProfesor(FALSE);
                        $em->persist($nueva_carga);
                     
                    }
                
                }
            }
            if(($index2%5)==0){
                $output->writeln(sprintf($index2));
                $em->flush();
            }
            }
            
                $index2++;
        
     }
     $output->writeln(sprintf('listo'));
              
        
    }
}

?>
