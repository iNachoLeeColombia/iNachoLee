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
use Netpublic\CoreBundle\Entity\AlumnoDimension;
use Netpublic\CoreBundle\Entity\Usuario;
use Netpublic\CoreBundle\Entity\Rol;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Netpublic\CoreBundle\Entity\Dimension;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Netpublic\CoreBundle\Entity\HorarioClase;
use Netpublic\CoreBundle\Entity\Variable;
use Netpublic\CoreBundle\Entity\ValorVariable;
use Netpublic\CoreBundle\Entity\Grado;
use Netpublic\CoreBundle\Entity\Grupo;
use Netpublic\CoreBundle\Entity\Asignatura;
use Netpublic\CoreBundle\Entity\Aula;
use Netpublic\CoreBundle\Entity\Profesor;
use Netpublic\CoreBundle\Entity\Contrato;
use Netpublic\CoreBundle\Entity\Alumno;
use Netpublic\CoreBundle\Entity\MatriculaAlumno;
use Netpublic\CoreBundle\Entity\Desempeno;
use Netpublic\CoreBundle\Entity\AspectoEvaluar;
use Doctrine\Common\Persistence\ObjectManager;


/**
 * Comando que envía cada día un email a todos los usuarios que lo
 * permiten con la información de la oferta del día en su ciudad
 *
 */
use Netpublic\CoreBundle\Entity\Plantillabc3;
use Netpublic\CoreBundle\Util\Plantillas;
use Netpublic\CoreBundle\Entity\TagPlantilla;
class PreinstalacionCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('iNachoLee:preinstalacion')
            ->setDefinition(array(
                new InputOption('accion', false, InputOption::VALUE_OPTIONAL, 'Genera datos basicos: Plantillas de BC3')
            ))
            ->setDescription('preConfigura la instalacion de iNachoLee');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        

        $output->writeln(sprintf('Realizando preconfiguracion. Espere...' ));
        $output->writeln(sprintf('Estableciendo año escolar a las Cargas Academicas. Espere...' ));
        
        $contenedor = $this->getContainer();
        $em = $contenedor->get('doctrine')->getManager();
        $anos_escolares=$em->getRepository("NetpublicCoreBundle:Dimension")->findBy(
                array('tipo'=>0),
                array('id'=>"DESC")
                );
        $primer_ano=TRUE;
        /*foreach ($anos_escolares as $ano) {
            $output->writeln(sprintf("Estableciendo año escolar a $ano Cargas Academicas. Espere..." ));
            $cargas_academicas=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findAll();

            if($primer_ano){
                foreach ($cargas_academicas as $mi_carga) {
                    $mi_carga->setAnoEscolar($ano);
                    $em->persist($mi_carga);
                }
                $primer_ano=FALSE;
            }
            else{
                foreach ($cargas_academicas as $mi_carga1) {
                    $ca=new \Netpublic\CoreBundle\Entity\CargaAcademica();
                    $ca->setAnoEscolar($ano);
                    $ca->setAsignatura($mi_carga1->getAsignatura());
                    $ca->setGrupo($mi_carga1->getGrupo());
                    $ca->setEstadoAsignacion(FALSE);
                    $em->persist($ca);
                }
            }
       }*/
       $labels=$em->getRepository("NetpublicCoreBundle:TagPlantilla")->findAll();
        foreach ($labels as $l) {
            $em->remove($l);
        }
        $em->flush();
        //Datos de session.
        $hay_usuarios=$em->getRepository("NetpublicCoreBundle:Usuario")->findAll();
        if($hay_usuarios){
            ;
        }
        else{
            //Ingresamos Valores por defecto
            //Sector
            $gestor=$em;
            $output->writeln(sprintf('Cargando usuarios. Espere...' ));
            $sector=new Variable();
            $sector->setNombre("Sector");
            $gestor->persist($sector);
            $vm_0=new ValorVariable();
            $vm_0->setDescripcion("Oficial");
            $vm_0->setValor(1);
            $vm_0->setVariable($sector);
            $gestor->persist($vm_0);
            $vm_1=new ValorVariable();
            $vm_1->setDescripcion("No Oficial");
            $vm_1->setValor(2);
            $vm_1->setVariable($sector);
            $gestor->persist($vm_1);

            //Genero        
            $sexo=new Variable();
            $sexo->setNombre("Sexo");
            $gestor->persist($sexo);
            $vm=new ValorVariable();
            $vm->setDescripcion("M");
            $vm->setValor(1);
            $vm->setVariable($sexo);
            $gestor->persist($vm);
            $vm1=new ValorVariable();
            $vm1->setDescripcion("F");
            $vm1->setValor(2);
            $vm1->setVariable($sexo);
            $gestor->persist($vm1);
            //Jornadas

            $jornandas=new Variable();
            $jornandas->setNombre("Jornada");
            $gestor->persist($jornandas);
            $vm_2=new ValorVariable();
            $vm_2->setDescripcion("Completa");
            $vm_2->setValor(1);
            $vm_2->setVariable($jornandas);
            $gestor->persist($vm_2);
            $vm_3=new ValorVariable();
            $vm_3->setDescripcion("Mañana");
            $vm_3->setValor(2);
            $vm_3->setVariable($jornandas);
            $gestor->persist($vm_3);
            $vm_4=new ValorVariable();
            $vm_4->setDescripcion("Tarde");
            $vm_4->setValor(3);
            $vm_4->setVariable($jornandas);
            $gestor->persist($vm_4);
            $vm_5=new ValorVariable();
            $vm_5->setDescripcion("Nocturna");
            $vm_5->setValor(4);
            $vm_5->setVariable($jornandas);
            $gestor->persist($vm_5);
            $vm_6=new ValorVariable();
            $vm_6->setDescripcion("Fin De Semana");
            $vm_6->setValor(4);
            $vm_6->setVariable($jornandas);
            $gestor->persist($vm_5);

            //Propiedad Juridica
            $prop_juridica=new Variable();
            $prop_juridica->setNombre("Propiedad Juridica");
            $gestor->persist($prop_juridica);
            $vm_7=new ValorVariable();
            $vm_7->setDescripcion("Propiedad Juridica 1");
            $vm_7->setValor(1);
            $vm_7->setVariable($prop_juridica);
            $gestor->persist($vm_7);
            $vm_8=new ValorVariable();
            $vm_8->setDescripcion("Propiedad Juridica2");
            $vm_8->setValor(2);
            $vm_8->setVariable($prop_juridica);
            $gestor->persist($vm_8);

            //Nucleo
            $nucleo=new Variable();
            $nucleo->setNombre("Nucleo");
            $gestor->persist($nucleo);
            $vm_9=new ValorVariable();
            $vm_9->setDescripcion("Nucleo 1");
            $vm_9->setValor(1);
            $vm_9->setVariable($nucleo);
            $gestor->persist($vm_9);
            $vm_10=new ValorVariable();
            $vm_10->setDescripcion("Nucleo 2");
            $vm_10->setValor(2);
            $vm_10->setVariable($nucleo);
            $gestor->persist($vm_10);  

            //Discapacidadesnid=6
            $discapacidades=new Variable();
            $discapacidades->setNombre("Discapacidades");
            $gestor->persist($discapacidades);
            $vm_11=new ValorVariable();
            $vm_11->setDescripcion("Discapacidades I");
            $vm_11->setValor(1);
            $vm_11->setVariable($discapacidades);
            $gestor->persist($vm_11);
            $vm_12=new ValorVariable();
            $vm_12->setDescripcion("Discapacidades II");
            $vm_12->setValor(2);
            $vm_12->setVariable($discapacidades);
            $gestor->persist($vm_12);          
            //Capacidades Excepcionales 7
            $cap_exep=new Variable();
            $cap_exep->setNombre("Capacidades Excepcionales");
            $gestor->persist($cap_exep);
            $vm_13=new ValorVariable();
            $vm_13->setDescripcion("Capacidad Excepcional I");
            $vm_13->setValor(1);
            $vm_13->setVariable($cap_exep);
            $gestor->persist($vm_13);
            $vm_14=new ValorVariable();
            $vm_14->setDescripcion("Capacidad Excepcional II");
            $vm_14->setValor(2);
            $vm_14->setVariable($cap_exep);
            $gestor->persist($vm_14);                  
            //Etnias 8
            $etnias=new Variable();
            $etnias->setNombre("Etnias");
            $gestor->persist($etnias);
            $vm_15=new ValorVariable();
            $vm_15->setDescripcion("Etnias I");
            $vm_15->setValor(1);
            $vm_15->setVariable($etnias);
            $gestor->persist($vm_15);
            $vm_16=new ValorVariable();
            $vm_16->setDescripcion("Etnias II");
            $vm_16->setValor(2);
            $vm_16->setVariable($etnias);
            $gestor->persist($vm_16);
            //Resguardo 9
            $resguardo=new Variable();
            $resguardo->setNombre("Resguardo");
            $gestor->persist($resguardo);
            $vm_17=new ValorVariable();
            $vm_17->setDescripcion("Resguardo I");
            $vm_17->setValor(1);
            $vm_17->setVariable($resguardo);
            $gestor->persist($vm_17);
            $vm_18=new ValorVariable();
            $vm_18->setDescripcion("Resguardo II");
            $vm_18->setValor(2);
            $vm_18->setVariable($resguardo);
            $gestor->persist($vm_18);                  
            //Novedad Insti 10
            $nov_inst=new Variable();
            $nov_inst->setNombre("Novedad Institucional");
            $gestor->persist($nov_inst);
            $vm_19=new ValorVariable();
            $vm_19->setDescripcion("N I I");
            $vm_19->setValor(1);
            $vm_19->setVariable($nov_inst);
            $gestor->persist($vm_19);
            $vm_20=new ValorVariable();
            $vm_20->setDescripcion("NV II");
            $vm_20->setValor(2);
            $vm_20->setVariable($nov_inst);
            $gestor->persist($vm_20);                  
            //Metodologia
            $metodologia=new Variable();
            $metodologia->setNombre("Metodologia");
            $gestor->persist($metodologia);
            $vm_21=new ValorVariable();
            $vm_21->setDescripcion("Metodologia I");
            $vm_21->setValor(1);
            $vm_21->setVariable($metodologia);
            $gestor->persist($vm_21);
            $vm_22=new ValorVariable();
            $vm_22->setDescripcion("Metodologia II");
            $vm_22->setValor(2);
            $vm_22->setVariable($metodologia);
            $gestor->persist($vm_22);                  
            //Zona
            $zona=new Variable();
            $zona->setNombre("Zona");
            $gestor->persist($zona);
            $vm_23=new ValorVariable();
            $vm_23->setDescripcion("Zona I");
            $vm_23->setValor(1);
            $vm_23->setVariable($zona);
            $gestor->persist($vm_23);
            $vm_24=new ValorVariable();
            $vm_24->setDescripcion(" Zona II");
            $vm_24->setValor(2);
            $vm_24->setVariable($zona);
            $gestor->persist($vm_24);                          
            //Depto
            $depto=new Variable();
            $depto->setNombre("Departamento");
            $gestor->persist($depto);
            $vm_25=new ValorVariable();
            $vm_25->setDescripcion("Depto I");
            $vm_25->setValor(1);
            $vm_25->setVariable($depto);
            $gestor->persist($vm_25);
            $vm_26=new ValorVariable();
            $vm_26->setDescripcion("Depto II");
            $vm_26->setValor(2);
            $vm_26->setVariable($depto);
            $gestor->persist($vm_26);
            //municipio
            $municipio=new Variable();
            $municipio->setNombre("Municipio");
            $gestor->persist($municipio);
            $vm_27=new ValorVariable();
            $vm_27->setDescripcion("Municipio I");
            $vm_27->setValor(1);
            $vm_27->setVariable($municipio);
            $gestor->persist($vm_27);
            $vm_28=new ValorVariable();
            $vm_28->setDescripcion("Municipio II");
            $vm_28->setValor(2);
            $vm_28->setVariable($municipio);
            $gestor->persist($vm_28);        
            //municipio
            $municipio=new Variable();
            $municipio->setNombre("Municipio");
            $gestor->persist($municipio);
            $vm_27=new ValorVariable();
            $vm_27->setDescripcion("Municipio I");
            $vm_27->setValor(1);
            $vm_27->setVariable($municipio);
            $gestor->persist($vm_27);
            $vm_28=new ValorVariable();
            $vm_28->setDescripcion("Municipio II");
            $vm_28->setValor(2);
            $vm_28->setVariable($municipio);
            $gestor->persist($vm_28);                
            //Regimen de Costos
            $regimen=new Variable();
            $regimen->setNombre("Regimem");
            $gestor->persist($regimen);
            $vm_29=new ValorVariable();
            $vm_29->setDescripcion("Regimen I");
            $vm_29->setValor(1);
            $vm_29->setVariable($regimen);
            $gestor->persist($vm_29);
            $vm_36=new ValorVariable();
            $vm_36->setDescripcion("Regimen II");
            $vm_36->setValor(2);
            $vm_36->setVariable($regimen);
            $gestor->persist($vm_36);                        
            //Rango promedio
            $rango_promedio=new Variable();
            $rango_promedio->setNombre("Rango Promedio");
            $gestor->persist($rango_promedio);
            $vm_30=new ValorVariable();
            $vm_30->setDescripcion("Rango Promedio I");
            $vm_30->setValor(1);
            $vm_30->setVariable($rango_promedio);
            $gestor->persist($vm_30);
            $vm_31=new ValorVariable();
            $vm_31->setDescripcion("Rango Promedio II");
            $vm_31->setValor(2);
            $vm_31->setVariable($rango_promedio);
            $gestor->persist($vm_31);                                
             //Idioma
            $idioma=new Variable();
            $idioma->setNombre("Idioma");
            $gestor->persist($idioma);
            $vm_32=new ValorVariable();
            $vm_32->setDescripcion("Ingles");
            $vm_32->setValor(1);
            $vm_32->setVariable($idioma);
            $gestor->persist($vm_32);
            $vm_33=new ValorVariable();
            $vm_33->setDescripcion("Español");
            $vm_33->setValor(2);
            $vm_33->setVariable($idioma);
            $gestor->persist($vm_33);                        
            //Nucleo Privado
            $nucleo_privado=new Variable();
            $nucleo_privado->setNombre("Nucleo Privado");
            $gestor->persist($nucleo_privado);
            $vm_34=new ValorVariable();
            $vm_34->setDescripcion("Nucleo Privado I");
            $vm_34->setValor(1);
            $vm_34->setVariable($nucleo_privado);
            $gestor->persist($vm_34);
            $vm_35=new ValorVariable();
            $vm_35->setDescripcion("Nucleo Privado II");
            $vm_35->setValor(2);
            $vm_35->setVariable($nucleo_privado);
            $gestor->persist($vm_35); 
            $gestor->flush();
            //Niveles educativos
            $niveles_educativo=new Variable();
            $niveles_educativo->setNombre("Niveles Educativo");
            $gestor->persist($niveles_educativo);
            $vm_36=new ValorVariable();
            $vm_36->setDescripcion("Prescolar");
            $vm_36->setValor(1);
            $vm_36->setVariable($niveles_educativo);
            $gestor->persist($vm_36);

            $vm_37=new ValorVariable();
            $vm_37->setDescripcion("Básica Primaria");
            $vm_37->setValor(2);
            $vm_37->setVariable($niveles_educativo);
            $gestor->persist($vm_37); 
            $gestor->flush();

            $vm_38=new ValorVariable();
            $vm_38->setDescripcion("Básica Secundaria");
            $vm_38->setValor(3);
            $vm_38->setVariable($niveles_educativo);
            $gestor->persist($vm_38); 
            $gestor->flush();

            $vm_39=new ValorVariable();
            $vm_39->setDescripcion("Media");
            $vm_39->setValor(4);
            $vm_39->setVariable($niveles_educativo);
            $gestor->persist($vm_39); 
            $gestor->flush();

            //Tipo de evaluacion

            //Aspectos a evaluar, de acuerdo al colegio.
            $aspecto_evaluar=new AspectoEvaluar();
            $aspecto_evaluar->setNombre('Cognitivo');
            $gestor->persist($aspecto_evaluar);

            $aspecto_evaluar1=new AspectoEvaluar();
            $aspecto_evaluar1->setNombre('Procedimental');
            $gestor->persist($aspecto_evaluar1);

            $aspecto_evaluar2=new AspectoEvaluar();
            $aspecto_evaluar2->setNombre('Actitudinal');
            $gestor->persist($aspecto_evaluar2);

            $aspecto_evaluar3=new AspectoEvaluar();
            $aspecto_evaluar3->setNombre('Autoevaluación');
            $gestor->persist($aspecto_evaluar3);
           $profesor=new Profesor();
           $profesor->setTipo(1);
            $profesor->setNombre("iNachoLee");   
            $profesor->setCedula('118123975');        
            $profesor->setTipoDocumento(2);
            $rol=new Rol();
            $rol->setRole("ROLE_PROFESORES");        
            $rol1=new Rol();
            $rol1->setRole("ROLE_ESTUDIANTE");
            $rol2=new Rol();
            $rol2->setRole("ROLE_RECTOR");        
            $rol3=new Rol();
            $rol3->setRole("ROLE_AUXILIAR");
            $rol4=new Rol();
            $rol4->setRole("ROLE_ACUDIENTE");        

            //Tipo de alumno Estudiante
            $usuario1=new Usuario();        ;
            $usuario1->setUsername("rector");
            $usuario1->setSalt(md5(time()));
            $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
            $password = $encoder->encodePassword("12345", $usuario1->getSalt());
            $usuario1->setPassword($password);
            $usuario1->setEsAlumno(FALSE);
            $usuario1->setProfesor($profesor);
            $usuario1->addRol($rol2); 
            $profesor->setUsuario($usuario1);
            
            //Grados
            $primero=new Grado();
            $primero->setNombre("GradoCero");
            $primero->setNombreGrupo(000);
            $primero->setNivelesEducativo(1);
            $em->persist($primero);
            
            
            $primero=new Grado();
            $primero->setNombre("Primero");
            $primero->setNombreGrupo(100);
            $primero->setNivelesEducativo(1);
            $em->persist($primero);
            
            $primero=new Grado();
            $primero->setNombre("Segundo");
            $primero->setNombreGrupo(200);
            $primero->setNivelesEducativo(1);
            $em->persist($primero);
            
            $primero=new Grado();
            $primero->setNombre("Tercero");
            $primero->setNombreGrupo(300);
            $primero->setNivelesEducativo(1);
            $em->persist($primero);
            
            $primero=new Grado();
            $primero->setNombre("Cuarto");
            $primero->setNombreGrupo(400);
            $primero->setNivelesEducativo(1);
            $em->persist($primero);
            
            $primero=new Grado();
            $primero->setNombre("Quinto");
            $primero->setNombreGrupo(500);
            $primero->setNivelesEducativo(1);
            $em->persist($primero);
            
            $primero=new Grado();
            $primero->setNombre("Sexto");
            $primero->setNombreGrupo(600);
            $primero->setNivelesEducativo(1);
            $em->persist($primero);
            
            $primero=new Grado();
            $primero->setNombre("Septimo");
            $primero->setNombreGrupo(700);
            $primero->setNivelesEducativo(1);
            $em->persist($primero);
            
            $primero=new Grado();
            $primero->setNombre("Octavo");
            $primero->setNombreGrupo(800);
            $primero->setNivelesEducativo(1);
            $em->persist($primero);
            
            $primero=new Grado();
            $primero->setNombre("Noveno");
            $primero->setNombreGrupo(900);
            $primero->setNivelesEducativo(1);
            $em->persist($primero);
            
            $primero=new Grado();
            $primero->setNombre("Decimo");
            $primero->setNombreGrupo(1000);
            $primero->setNivelesEducativo(1);
            $em->persist($primero);
            
            $primero=new Grado();
            $primero->setNombre("UnDecimo");
            $primero->setNombreGrupo(1100);
            $primero->setNivelesEducativo(1);
            $em->persist($primero);
            
            $primero=new Grado();
            $primero->setNombre("Egresados");
            $primero->setNombreGrupo(1200);
            $primero->setNivelesEducativo(1);
            $em->persist($primero);
            
            
            
            $gestor->persist($usuario1);        
            $gestor->persist($profesor);
            $gestor->persist($rol1);
            $gestor->persist($rol);
            $gestor->persist($rol2);
            $gestor->persist($rol3);
            $gestor->persist($rol4);

            
            
            
        }
        $em->flush();
        $output->writeln(sprintf('listo...'));
        
        // Buscar la 'oferta del día' en todas las ciudades de la aplicación
        
    }
}
