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

class PreguntaIcfesCommand  extends ContainerAwareCommand{
    //put your code here
        protected function configure()
    {
        $this
            ->setName('iNachoLee:pIcfes')
            ->setDefinition(array(
                new InputOption('accion', false, InputOption::VALUE_OPTIONAL, 'Preguntas Temporales')
            ))
            ->setDescription('Genera Slug y Linea de academica');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        

        $output->writeln(sprintf('Ingresando preguntas. Espere...' ));
        $contenedor = $this->getContainer();
        $em = $contenedor->get('doctrine')->getManager();
        $alumnos=$em->getRepository("NetpublicCoreBundle:Alumno")->findBy(array(
            'grupo'=>2
        ));
        foreach ($alumnos as $alumno) {
            for ($index = 1; $index < 21; $index++) {
                $pregunta=new \Netpublic\RedsaberBundle\Entity\Pregunta();
                $pregunta->setAlumno($alumno);
                $pregunta->setIndice($index);
                //Creo los bubles
                $buble=new \Netpublic\RedsaberBundle\Entity\Buble();
                $buble->setEstado(1);
                $buble->setLabel("A");
                $buble->setPregunta($pregunta);
                $em->persist($buble);
                $buble=new \Netpublic\RedsaberBundle\Entity\Buble();
                $buble->setEstado(0);
                $buble->setLabel("B");
                $buble->setPregunta($pregunta);
                $em->persist($buble);
                $buble=new \Netpublic\RedsaberBundle\Entity\Buble();
                $buble->setEstado(0);
                $buble->setLabel("C");
                $buble->setPregunta($pregunta);
                $em->persist($buble);
                $buble=new \Netpublic\RedsaberBundle\Entity\Buble();
                $buble->setEstado(0);
                $buble->setLabel("D");
                $buble->setPregunta($pregunta);
                $em->persist($buble);
                $em->persist($pregunta);
        }
        $em->flush();
        $output->writeln(sprintf('listo'));
        }
    }
}

?>
