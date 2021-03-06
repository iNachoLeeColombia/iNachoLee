<?php

namespace Netpublic\CoreBundle\Repository;
use Netpublic\CoreBundle\Entity\CargaAcademica;
use Netpublic\CoreBundle\Entity\HorarioAula;
use Netpublic\CoreBundle\Entity\Aula;
use Doctrine\ORM\EntityRepository;

/**
 * CargaAcademicaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CargaAcademicaRepository extends EntityRepository
{
    public function getAsignaturaGrupo($id_profesor,$id_ano_escolar){
        return $this->findBy(array(
            'profesor'=>$id_profesor,            
            'ano_escolar'=>$id_ano_escolar
            ));
    }
    public function getCarga($grupo_id,$ano_id) {
        return $this->findBy(array(
            'grupo'=>$grupo_id,
            'es_carga_academica'=>TRUE,
            'ano_escolar'=>$ano_id
            ));
    }
    public function getAsignaturaCargaAcademica($id_profesor,$grupo_id){
        return $this->findBy(array(
            'profesor'=>$id_profesor,
            "grupo"=>$grupo_id,
            'es_carga_academica'=>TRUE
            ),
                array("id"=>"ASC")
                );
    }
    public function verificarCargaAcademica(){
        $this->inicializarContratos();
        $es_viable_hc=0;
        //Calculamos todas la horas semanales
        
        $hs_todos_grupos=  $this->getEntityManager()->getRepository("NetpublicCoreBundle:Grado")
                                               ->getHorasNecesariasTodoGrupos();
        //Calculas Hora De disposicion de todas la Clases
        $hs_todas_aulas=  $this->getEntityManager()->getRepository("NetpublicCoreBundle:Aula")
                                              ->getEsHorasDisponiblesAulas();
        //Calculamos el numero de horas de profesores contratadas
        $hs_todos_profe= $this->getEntityManager()->getRepository("NetpublicCoreBundle:Profesor")
                                             ->getEsHoraContratadasTodosProfesores();
        //Verificamos que se cumplan la condicion
        if(($hs_todas_aulas!=-1) && ($hs_todos_profe!=-1)){
            $es_viable_hc=1;
        }
        $this->inicializarContratos();
        return array(
            "hs_todos_grupos"=>$hs_todos_grupos,
            "hs_todas_aulas"=>$hs_todas_aulas,
            "hs_todos_profe"=>$hs_todos_profe,
            "es_viable_hc"=>$es_viable_hc
        );
        
    }
    
    public function asignarCargaAcademica($asignaturas,$grupo,$dia_inicio_jornada,$dia_final_jornada){
        
        $em=$this->getEntityManager();
        $dia_inicio=$dia_inicio_jornada;
        $dia_final=$dia_final_jornada;   
        
        $resp=0;
        foreach ($asignaturas as $asignatura) {
            if($asignatura->getEsArea()==FALSE){
                $ca=new CargaAcademica();
                $ca->setAsignatura($asignatura);                                                          
                $mi_hororario_aula=$this->getAulaCargaAcademica($asignatura,$dia_inicio,$dia_final); 
                $mi_hororario_aula->setEsDisponible(FALSE);
                $mi_hororario_aula->setAsignatura($asignatura);
                $ca->setAula($mi_hororario_aula->getAula());
                $ca->setEsCargaAcademica(TRUE);
                $ca->setGrupo($grupo);
                $ca->setProfesor($this->getProfesorCargaAcademica($asignatura));
                $mi_hororario_aula->setCargaAcademica($ca);
                $em->persist($mi_hororario_aula);
                $em->persist($ca);
                $dia_inicio=$dia_inicio+2;
                $resp++;
            for ($index = 0; $index < $asignatura->getFrucuenciaSemana()-1; $index++) {                            
                $ca=new CargaAcademica();
                $ca->setAsignatura($asignatura);                                                          
                $mi_hororario_aula=$this->getAulaCargaAcademica($asignatura,$dia_inicio,$dia_final); 
                $mi_hororario_aula->setEsDisponible(FALSE);
                $mi_hororario_aula->setAsignatura($asignatura);
                $ca->setAula($mi_hororario_aula->getAula());
                $ca->setEsCargaAcademica(FALSE);
                $ca->setGrupo($grupo);
                $ca->setProfesor($this->getProfesorCargaAcademica($asignatura));
                $mi_hororario_aula->setCargaAcademica($ca);
                $em->persist($mi_hororario_aula);
                $em->persist($ca);
                $dia_inicio=$dia_inicio+2;
                $resp++;
            }
            }
            $dia_inicio=$dia_inicio_jornada;
          }
          $em->flush();
          
        return $resp;  
          
    }
    public function findNroPerdidos($ca,$periodo,$nota_minima,$ano_atras=1){
        $em=  $this->getEntityManager();
        $nro=0;
        if($ca->getAnoEscolar()){
            $query="SELECT count(a_d) FROM NetpublicCoreBundle:AlumnoDimension a_d JOIN a_d.alumno a JOIN a_d.asignatura asg  JOIN a_d.dimension d";
            $query.=" WHERE";
            $query.=" (";
            $query.=" d.id=:periodo_id";
            $query.=" AND asg.id=:asignatura_id";
            $query.=" AND a_d.nota<:nota";
            $query.=" AND d.tipo=1 ";        
            $query.=" AND a.id IN ( ";
            $query.=" SELECT al FROM NetpublicCoreBundle:MatriculaAlumno ma JOIN ma.alumno al JOIN ma.grupo g";
            $query.=" WHERE ";
            $query.=" (";
            $query.=" ma.grupo=:grupo_id";
            $query.=" AND ma.ano=:ano_id";
            $query.=" )))"; 
        
            $entities=$em->createQuery($query)                
                     ->setParameters(array(
                        "periodo_id"=>$periodo->getId(),
                        "asignatura_id"=>$ca->getAsignatura()->getId(),
                        "nota"=>$nota_minima,
                        'ano_id'=>$ca->getAnoEscolar()->getId(), 
                        "grupo_id"=>$ca->getGrupo()->getId()));
            $nro=$entities->getSingleScalarResult(); 
        
        }
        else{
            $query="SELECT count(a_d) FROM NetpublicCoreBundle:AlumnoDimension a_d JOIN a_d.alumno a JOIN a_d.asignatura asg  JOIN a_d.dimension d";
            $query.=" WHERE";
            $query.=" (";
            $query.=" d.id=:periodo_id";
            $query.=" AND asg.id=:asignatura_id";
            $query.=" AND a_d.nota<:nota";
            $query.=" AND d.tipo=1 ";  
            $query.=" AND a.grupo=:grupo_id ";  
            $query.=" )"; 
        
            $entities=$em->createQuery($query)                
                     ->setParameters(array(
                        "periodo_id"=>$periodo->getId(),
                        "asignatura_id"=>$ca->getAsignatura()->getId(),
                        "nota"=>$nota_minima,
                        "grupo_id"=>$ca->getGrupo()->getId()));
            $nro=$entities->getSingleScalarResult(); 
        
        }
        
        return $nro;  

    }
    public function findPerdidos($ca,$periodo,$valor_minimo_deficiente,$valor_maximo_deficiente,$ano_atras=1){
        $em=  $this->getEntityManager();
        //if($ca->getAnoEscolar()){
        $query="SELECT a_d,a FROM NetpublicCoreBundle:AlumnoDimension a_d JOIN a_d.alumno a JOIN a_d.asignatura asg  JOIN a_d.dimension d";
        $query.=" WHERE";
        $query.=" (";
        $query.=" d.id=:periodo_id";
        $query.=" AND asg.id=:asignatura_id";
        $query.=" AND a_d.nota<:v_max";
        $query.=" AND a_d.nota>=:v_min";
        $query.=" AND d.tipo=1 ";        
        $query.=" AND a.id IN ( ";
        $query.=" SELECT al FROM NetpublicCoreBundle:MatriculaAlumno ma JOIN ma.alumno al JOIN ma.grupo g";
        $query.=" WHERE ";
        $query.=" (";
        $query.=" ma.grupo=:grupo_id";
        //$query.=" AND ma.ano=:ano_id";
        $query.=" )))"; 
        
        $entities=$em->createQuery($query)                
                     ->setParameters(array(
                        "periodo_id"=>$periodo->getId(),
                        "asignatura_id"=>$ca->getAsignatura()->getId(),
                        "v_max"=>$valor_maximo_deficiente,
                        "v_min"=>$valor_minimo_deficiente,
          //              "ano_id"=>$ca->getAnoEscolar()->getid(), 
                        "grupo_id"=>$ca->getGrupo()->getId()))->setMaxResults(20)->getResult();
        
        //}
        return $entities; 

    }
    public function findGanan($ca,$periodo,$valor_minimo_sobresaliente,$valor_maximo_sobresaliente,$ano_atras=1){
        $em=  $this->getEntityManager();
        //if($ca->getAnoEscolar()){
        $query="SELECT a_d,a FROM NetpublicCoreBundle:AlumnoDimension a_d JOIN a_d.alumno a JOIN a_d.asignatura asg  JOIN a_d.dimension d";
        $query.=" WHERE";
        $query.=" (";
        $query.=" d.id=:periodo_id";
        $query.=" AND asg.id=:asignatura_id";
        $query.=" AND a_d.nota<=:v_max";
        $query.=" AND a_d.nota>:v_min";
        $query.=" AND d.tipo=1 ";        
        $query.=" AND a.id IN ( ";
        $query.=" SELECT al FROM NetpublicCoreBundle:MatriculaAlumno ma JOIN ma.alumno al JOIN ma.grupo g";
        $query.=" WHERE ";
        $query.=" (";
        $query.=" ma.grupo=:grupo_id";
        //$query.=" AND ma.ano=:ano_id";
        $query.=" )))"; 
        
        $entities=$em->createQuery($query)                
                     ->setParameters(array(
                        "periodo_id"=>$periodo->getId(),
                        "asignatura_id"=>$ca->getAsignatura()->getId(),
                        "v_max"=>$valor_maximo_sobresaliente,
                        "v_min"=>$valor_minimo_sobresaliente,
        //                'ano_id'=>$ca->getAnoEscolar()->getId(), 
                        "grupo_id"=>$ca->getGrupo()->getId()
                    ))->setMaxResults(10)->getResult(); 
       
        //}
        return $entities;  

    }
    
    public function findNroGanados($ca,$periodo,$nota_minima,$ano_atras=1){
        $em=  $this->getEntityManager();

        //if($ca->getAnoEscolar()){
                $query="SELECT count(a_d) FROM NetpublicCoreBundle:AlumnoDimension a_d JOIN a_d.alumno a JOIN a_d.asignatura asg  JOIN a_d.dimension d";
                $query.=" WHERE";
                $query.=" (";
                $query.=" d.id=:periodo_id";
                $query.=" AND asg.id=:asignatura_id";
                $query.=" AND a_d.nota>=:nota";
                $query.=" AND d.tipo=1 ";        
                $query.=" AND a.id IN ( ";
                $query.=" SELECT al FROM NetpublicCoreBundle:MatriculaAlumno ma JOIN ma.alumno al JOIN ma.grupo g";
                $query.=" WHERE ";
                $query.=" (";
                $query.=" ma.grupo=:grupo_id";
            //    $query.=" AND ma.ano=:ano_id";
                $query.=" )))"; 

                $entities=$em->createQuery($query)                
                             ->setParameters(array(
                                "periodo_id"=>$periodo->getId(),
                                "asignatura_id"=>$ca->getAsignatura()->getId(),
                                "nota"=>$nota_minima,
                                "grupo_id"=>$ca->getGrupo()->getId(),
          //                       'ano_id'=>$ca->getAnoEscolar()->getId()
                            ));
        //}
        $nro=$entities->getSingleScalarResult(); 
        return $nro ; 
        

        
    }

    private function getAulaCargaAcademica($asignatura,$dia_inicio,$dia_final){
        $em=$this->getEntityManager();
        $aulas=$em->getRepository("NetpublicCoreBundle:Aula")->findAll();
        //for ($index1 =$dia_inicio; $index1 < $dia_final-1; $index1++) {         
            
        foreach ($aulas as $aula) {    
            $asignatura_aulas=$aula->getContratoAula();
            foreach ($asignatura_aulas as $a_a) {
                $asignatura_aulas_ids[]=$a_a->getId();
            }
            if(in_array($asignatura->getId(), $asignatura_aulas_ids)){
                //for ($index = $index1; $index < $dia_final; $index++) {
                $disponibilidad_aula=$aula->getHorarioClase();
                foreach ($disponibilidad_aula as $horario) {
                  $nro_horarios_aulas=$em->createQuery("SELECT count(a) FROM NetpublicCoreBundle:HorarioAula a WHERE a.aula=:aula AND a.es_disponible =1 AND a.dia=:dia  AND a.hora_inicio >= :hora_inicio AND a.hora_inicio <= :hora_final  AND a.hora_final<=:hora_final AND a.hora_final>=:hora_inicio")                
                                 ->setParameters(array(
                                         "aula"=>$aula->getId(),
                                         "dia"=>$horario->getDiaSemana(),
                                         "hora_inicio" =>$horario->getHoraInicio(),
                                         "hora_final" => $horario->getHoraFinal()))
                                  ->getSingleScalarResult();
                        
                   if($nro_horarios_aulas>0){                    
                        $mi_hor_aula=$em->createQuery("SELECT a FROM NetpublicCoreBundle:HorarioAula a WHERE a.aula=:aula AND a.es_disponible =1 AND a.dia=:dia  AND a.hora_inicio >= :hora_inicio AND a.hora_inicio <= :hora_final  AND a.hora_final<=:hora_final AND a.hora_final>=:hora_inicio")                
                                 ->setParameters(array(
                                         "aula"=>$aula->getId(),
                                         "dia"=>$horario->getDiaSemana(),
                                         "hora_inicio" =>$horario->getHoraInicio(),
                                         "hora_final" => $horario->getHoraFinal()
                        ))->getResult();                  
                        if($mi_hor_aula[0])
                        {
                            return $mi_hor_aula[0];
                        }                           
                    }
                  }
            }
        }     
    }
    private function getProfesorCargaAcademica(\Netpublic\CoreBundle\Entity\Asignatura $asignatura){
                $em=  $this->getEntityManager();
                
                    $horas_asignatura=($asignatura->getDuracionMinutos()/60);                                
                    $contratos=$em->createQuery("SELECT a FROM NetpublicCoreBundle:Contrato a WHERE a.horas_contratadas >= :horas_contratadas AND a.asignatura=:asignatura")                
                    ->setParameters(array(                    
                        "horas_contratadas"=>$horas_asignatura,
                        "asignatura"=>$asignatura->getId()))
                    ->getResult();   
                    $profesor=$contratos[0]->getProfesorContrato();                
                    $contratos[0]->setHorasContratadas($contratos[0]->getHorasContratadas()-$horas_asignatura);
                    $em->persist($contratos[0]);
                    $em->flush();
                
                return $profesor;
    }
    private function inicializarContratos(){
        $em=  $this->getEntityManager();
        $h_a_a=  $em->getRepository("NetpublicCoreBundle:Contrato")->findAll();
        foreach ($h_a_a as $h_a) {              
            $h_a->setHorasContratadas($h_a->getHorasBuffer());
            $em->persist($h_a);
        }        
        $em->flush();
    }
    private function clearCargaAcademica(){        
        $em=  $this->getEntityManager();        
        $em->createQuery("DELETE NetpublicCoreBundle:CargaAcademica u")->execute();        
        
    }
    private function clearHorarioAula(){                
        $em=  $this->getEntityManager();        
        $em->createQuery("DELETE NetpublicCoreBundle:HorarioAula u")->execute();        
    }

    public function deleteCarga($ca,$ano_activo){
        $em=  $this->getEntityManager();
        
        if($ca->getAnoEscolar())
            $ano_escolar=$ca->getAnoEscolar();
        else
            $ano_escolar=$ano_activo;
        $periodos=$periodos_escolares= $em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodosEscolar($ano_escolar);
        foreach ($periodos as $periodo) {
            //Asignaturas
            $query="SELECT a_d,a FROM NetpublicCoreBundle:AlumnoDimension a_d JOIN a_d.alumno a JOIN a_d.asignatura asg  JOIN a_d.dimension d";
            $query.=" WHERE";
            $query.=" (";
            $query.=" (d.padre=:periodo_id";
            $query.=" OR d.id=:periodo_id) ";
            $query.=" AND asg.id=:asg_id";
            $query.=" AND a.id IN ( ";
            $query.=" SELECT al FROM NetpublicCoreBundle:MatriculaAlumno ma JOIN ma.alumno al JOIN ma.grupo g";
            $query.=" WHERE ";
            $query.=" (";
            $query.=" ma.grupo=:grupo_id";
            $query.=" AND ma.ano=:ano_id";
            $query.=" )))";         
            $entities=$em->createQuery($query)                
                         ->setParameters(array(
                            "grupo_id"=>$ca->getGrupo()->getId(),
                            "periodo_id"=>$periodo->getId(),
                            "asg_id"=>$ca->getAsignatura()->getId(),
                             'ano_id'=>$ano_escolar->getId()
                             ));
            $entities_=$entities->getResult(); 
            foreach ($entities_ as $e) {
                $dimension=$e->getDimension();
                $dimension->setPadre();
                $dimension->setPadregc();
                $em->persist($dimension);
                $em->remove($e);
                $em->remove($dimension);
                echo $e;
            }
            //Areas
            $query="SELECT a_d,a FROM NetpublicCoreBundle:AlumnoDimension a_d JOIN a_d.alumno a JOIN a_d.asignatura asg  JOIN a_d.dimension d";
            $query.=" WHERE";
            $query.=" (";
            $query.=" (d.padre=:periodo_id";
            $query.=" OR d.id=:periodo_id) ";
            $query.=" AND asg.id=:asg_id";
            $query.=" AND a.id IN ( ";
            $query.=" SELECT al FROM NetpublicCoreBundle:MatriculaAlumno ma JOIN ma.alumno al JOIN ma.grupo g";
            $query.=" WHERE ";
            $query.=" (";
            $query.=" ma.grupo=:grupo_id";
            $query.=" AND ma.ano=:ano_id";
            $query.=" )))";         
            $entities=$em->createQuery($query)                
                         ->setParameters(array(
                            "grupo_id"=>$ca->getGrupo()->getId(),
                            "periodo_id"=>$periodo->getId(),
                            "asg_id"=>$ca->getAsignatura()->getArea()->getId(),
                             'ano_id'=>$ano_escolar->getId()
                             ));
            $entities2=$entities->getResult(); 
            foreach ($entities2 as $e) {
                $dimension=$e->getDimension();
                $dimension->setPadre();
                $dimension->setPadregc();
                $em->persist($dimension);
                $em->remove($e);
                $em->remove($dimension);
              
            }
        }
        $em->flush();
        return 1;  

    }
    
    
}