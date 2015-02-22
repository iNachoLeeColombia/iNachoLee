<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este archivo pertenece a la aplicación de prueba Cupon.
 * El código fuente de la aplicación incluye un archivo llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace Netpublic\CoreBundle\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 * Comando que envía cada día un email a todos los usuarios que lo
 * permiten con la información de la oferta del día en su ciudad
 *
 */
class EmailOfertaDelDiaCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('iNachoLee:preconfigurar')
            ->setDefinition(array(
                new InputOption('accion', false, InputOption::VALUE_OPTIONAL, 'Genera los Slug de nombre completo para TODOS los usuarios y la linea academica del estudiante')
            ))
            ->setDescription('Genera Slug y Linea de academica');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        

        $output->writeln(sprintf('Realizando preconfiguracion. Espere...' ));
        $contenedor = $this->getContainer();
        $em = $contenedor->get('doctrine')->getManager();
        $em->createQuery("UPDATE NetpublicCoreBundle:Alumno a set a.nombre='' where a.nombre is null")
                            //->setParameter('valor_defecto',"a.nombre")
                            ->execute();
        $em->createQuery("UPDATE NetpublicCoreBundle:Alumno a set a.nombre1='' where a.nombre1 is null")
                            //->setParameter('valor_defecto',"a.nombre")
                            ->execute();
        $em->createQuery("UPDATE NetpublicCoreBundle:Alumno a set a.apellido='' where a.apellido is null")
                            //->setParameter('valor_defecto',"a.nombre")
                            ->execute();
        $em->createQuery("UPDATE NetpublicCoreBundle:Alumno a set a.apellido1='' where a.apellido1 is null")
                            //->setParameter('valor_defecto',"a.nombre")
                            ->execute();        
        
        $em->createQuery('UPDATE NetpublicCoreBundle:Alumno a set a.nombre_completo=TRIM(LOWER(CONCAT(a.nombre,a.nombre1,a.apellido,a.apellido1)))')
                            //->setParameter('valor_defecto',"a.nombre")
                            ->execute();
        $em->createQuery("UPDATE NetpublicCoreBundle:Profesor a set a.nombre='' where a.nombre is null")
                            //->setParameter('valor_defecto',"a.nombre")
                            ->execute();
        $em->createQuery("UPDATE NetpublicCoreBundle:Profesor a set a.nombre1='' where a.nombre1 is null")
                            //->setParameter('valor_defecto',"a.nombre")
                            ->execute();
        $em->createQuery("UPDATE NetpublicCoreBundle:Profesor a set a.apellido='' where a.apellido is null")
                            //->setParameter('valor_defecto',"a.nombre")
                            ->execute();
        $em->createQuery("UPDATE NetpublicCoreBundle:Profesor a set a.apellido1='' where a.apellido1 is null")
                            //->setParameter('valor_defecto',"a.nombre")
                            ->execute();        
        $em->createQuery("UPDATE NetpublicCoreBundle:Profesor a set a.nombre_completo=TRIM(LOWER(CONCAT(a.nombre,a.nombre1,a.apellido,a.apellido1)))")
                            //->setParameter('valor_defecto',"a.nombre")
                            ->execute();
        
        //generamos las lineas academicas
        
        //$alumnos=$em->getRepository("NetpublicCoreBundle:Alumno")->findAll();
        //$ano_escolar=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        /*foreach ($alumnos as $alumno) {
                $segui=new \Netpublic\CoreBundle\Entity\Anoescolargrado();
                $segui->setAlumno($alumno);
                $segui->setAnoescolar($ano_escolar);
                $segui->setGrado($alumno->getGrado());
                $segui->setGrupo($alumno->getGrupo());
                $em->persist($segui);
                
        }*/
        $em->flush();
        $output->writeln(sprintf('listo'));
        
        // Buscar la 'oferta del día' en todas las ciudades de la aplicación
        
    }
}
