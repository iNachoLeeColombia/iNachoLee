<?php
namespace Netpublic\CoreBundle\Repository;
use Netpublic\CoreBundle\Entity\HorarioClase;
use Netpublic\CoreBundle\Entity\CondicionCargaacademicacolegio;
use Doctrine\ORM\EntityRepository;


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of _HorarioClaseRepository
 *
 * @author linux
 */
class HorarioClaseHelperRepository extends EntityRepository{
    
    public function findFichaLibre($c_a) {                
            $em=  $this->getEntityManager();
            $r=false;
            $hay_ficha_profesor=false;
            $hay_ficha_grupo=false;
            $nro_fichas_libres_horario=  $this->getNroFichasLibresHorario($c_a);
            
            for ($index = 0; $index < $nro_fichas_libres_horario; $index++) {                                            
                    $hay_ficha_grupo=true;
                    $ficha_grupo=  $this->findFichasLibresHorario($c_a);                                
                   
                    $ficha_profesor= $this->findFichaHorarioProfesor(
                        $ficha_grupo->getHoraFila(),
                        $ficha_grupo->getDiaColumna(),
                        $c_a->getProfesor()->getId());

                    if($ficha_profesor->getTipo()==0){            
                        $hay_ficha_profesor=true;
                        //VErificamos que las siguientes Fichas esten 
                        //Activamos nuestros fichas: Horarios, PRofesor
                /*       $dql="UPDATE NetpublicCoreBundle:HorarioGrupo hg set hg.tipo=1,hg.carga_academica=:carga_academica";
                       $dql.=" WHERE hg.id=:id";
                       $em->createQuery($dql)
                          ->setParameter('id',$ficha_grupo->getId())     
                          ->setParameter('carga_academica',$c_a->getId())     
                          ->execute()
                        ;            
                        $dql="UPDATE NetpublicCoreBundle:HorarioClase hg set hg.tipo=1,hg.carga_academica=:carga_academica";
                       $dql.=" WHERE hg.id=:id";
                       $em->createQuery($dql)
                          ->setParameter('id',$ficha_profesor->getId())     
                          ->setParameter('carga_academica',$c_a->getId())     
                          ->execute()
                        ;            */
                        $ficha_grupo->setTipo(1);
                        $ficha_profesor->setTipo(1);
                        $ficha_profesor->setCargaAcademica($c_a);
                        $ficha_grupo->setCargaAcademica($c_a);                   
                        
                        $em->persist($ficha_grupo);
                        $em->persist($ficha_profesor);                        
                        $r=$ficha_grupo;
                        break;
                    }                 
                //Desactivamos la ficha en el HorarioGrupo                 
                 $dql="UPDATE NetpublicCoreBundle:HorarioGrupo hg set hg.tipo=3";
                 $dql.=" WHERE hg.id=:id";
                 $em->createQuery($dql)
                     ->setParameter('id',$ficha_grupo->getId())     
                     ->execute()
            ;            
                 

                
            }
            $dql="UPDATE NetpublicCoreBundle:HorarioGrupo hg set hg.tipo=0";
            $dql.=" WHERE hg.tipo=3 and hg.grupo=:grupo";
            $em->createQuery($dql)
                     ->setParameter('grupo', $c_a->getGrupo()->getId())     
                     ->execute()
            ;
            $f=0;
            if($hay_ficha_grupo){
                $f=1;//Hay Fichas Disponibles en el grupo
            }
            if($hay_ficha_grupo && $hay_ficha_profesor){
                $f=2;//Se logro seleccionar la fivha
            }
            if($hay_ficha_grupo && !$hay_ficha_profesor){
                $f=3;//No hay Ficha en Profesor, aunque si hay para la ficha del grupo
            }
            if(!$hay_ficha_grupo){
                $f=4;//No hay fichas disponibles
            }            
            $c_a->setEstadoAsignacion($f);            
            $em->persist($c_a);
            $em->flush();                                                       
            return $r;
    }
    
    public function findFichaHorarioProfesor($fila,$columna,$profesor_id) {
        $ficha_profesor=  $this->getEntityManager()
                               ->getRepository("NetpublicCoreBundle:HorarioClase")
                               ->findOneBy(array(
                                   "hora_fila"=>$fila,
                                   "dia_columna"=>$columna,
                                   "profesor"=>$profesor_id
                               ))
                ;
        return $ficha_profesor;
    }
    public function getNroFichasLibresHorario($c_a) {
        $em=  $this->getEntityManager();
        $grupo_id=$c_a->getGrupo()->getId();
        $re=$em->createQuery(
                    "SELECT count(h) FROM NetpublicCoreBundle:HorarioGrupo h 
                             WHERE h.tipo=0 and h.grupo=:grupo_id                              
                       ")                
                     ->setParameters(
                             array(                                 
                                 'grupo_id'=>$grupo_id
                                 ))
                    ->getSingleScalarResult();                   
        return $re;
    }
    public function findFichasLibresHorario($c_a) {
        $em=  $this->getEntityManager();        
        $grupo_id=$c_a->getGrupo()->getId();
        $dql="SELECT h FROM NetpublicCoreBundle:HorarioGrupo h ";
        $dql.="WHERE h.tipo=:tipo and h.grupo=:grupo_id";
        $h_c_libre=$em->createQuery($dql)                
                     ->setParameters(
                             array(                                 
                                 'grupo_id'=>$grupo_id,
                                 "tipo"=>0
                                 
                                 ))
                    ->getResult();          
              $r= $h_c_libre[0];   
        return $r;
    }


    public function borrarGenerarFichas($nro_clase_dia,$dias_festivos,$profesores) {
     $em=  $this->getEntityManager();   
        
      $em->createQuery("DELETE NetpublicCoreBundle:HorarioClase")
                ->execute(); 
    $em->createQuery("DELETE NetpublicCoreBundle:HorarioGrupo")
                ->execute(); 
    
     foreach ($profesores as $profesor) {       
        $posicion=0;
        $posicion_columnas=0;        
        for ($index = 0; $index <$nro_clase_dia ; $index++) {
            for ($index1 = -1; $index1 < 7; $index1++) {
                $entity  = new HorarioClase();
                $entity->setDiaColumna($index1);
                $entity->setHoraFila($index);
                $es_libre=0;                
                if(in_array($index1, $dias_festivos)){
                    $es_libre=2;
                }                
                else{
                    $posicion++;                
                    $posicion_columnas=(($nro_clase_dia*($index1))+$index)+1;
                }
                if($index1==-1){
                        $es_libre=-1;
                        $ficha=$this->getValueCondicionColegio($index, $index1);
                        $entity->setValor($ficha->getValor());
                }        
                $entity->setTipo($es_libre);
                $entity->setPosicion($posicion);
                $entity->setPosicionColumna($posicion_columnas);;
                $entity->setProfesor($profesor);                
                $em->persist($entity);        
            }
            
        }
      
     }
     $grupos=  $this->getEntityManager()
                    ->getRepository("NetpublicCoreBundle:Grupo")
                    ->findAll()
                ;
     //Generamos Horarios para grupos
     foreach ($grupos as $grupo) {       
        $posicion=0;
        $posicion_columnas=0;        
        for ($index = 0; $index <$nro_clase_dia ; $index++) {
            for ($index1 = -1; $index1 < 7; $index1++) {
                $entity  = new \Netpublic\CoreBundle\Entity\HorarioGrupo();
                $entity->setDiaColumna($index1);
                $entity->setHoraFila($index);
                $es_libre=0;                
                if(in_array($index1, $dias_festivos)){
                    $es_libre=2;
                }                
                else{
                    $posicion++;                
                    $posicion_columnas=(($nro_clase_dia*($index1))+$index)+1;
                }
                if($index1==-1){
                        $es_libre=-1;
                }        
                $entity->setTipo($es_libre);
                $entity->setPosicion($posicion);
                $entity->setPosicionColumna($posicion_columnas);;
                $entity->setGrupo($grupo);                
                $em->persist($entity);        
            }
            
        }
      
     }     
     $em->flush();
    }


public function setCondicionesProfesor($profesores){
    $em=  $this->getEntityManager();
    foreach ($profesores as $profesor) {
        
     $ficha_condicion_profesor=$em->createQuery(
                    "SELECT h FROM NetpublicCoreBundle:CondicionProfesor h 
                             WHERE h.tipo=1 and h.profesor=:profesor_id
                       ")
                     ->setParameter('profesor_id', $profesor->getId())  
                    ->getResult();          
            foreach ($ficha_condicion_profesor as $ficha) {
                $ficha_modificar= $em->getRepository("NetpublicCoreBundle:HorarioClase")
                                    ->findOneBy(array(
                                        'hora_fila'=>$ficha->getHoraFila(),
                                        'dia_columna'=>$ficha->getDiaColumna(),
                                        'profesor'=>$profesor->getId()
                                    ));
                $ficha_modificar->setTipo(4);
                $em->persist($ficha_modificar);
                
            }
    }    
    
}
public function setCondicionesColegio($grupos){
    $em=  $this->getEntityManager();
    foreach ($grupos as $grupo) {
        
     $ficha_condicion_profesor=$em->createQuery(
                    "SELECT h FROM NetpublicCoreBundle:CondicionCargaacademicacolegio h 
                             WHERE h.tipo=1
                       ")                     
                    ->getResult();          
            foreach ($ficha_condicion_profesor as $ficha) {
                $ficha_modificar= $em->getRepository("NetpublicCoreBundle:HorarioGrupo")
                                    ->findOneBy(array(
                                        'hora_fila'=>$ficha->getHoraFila(),
                                        'dia_columna'=>$ficha->getDiaColumna(),
                                        'grupo'=>$grupo->getId()
                                    ));
                $ficha_modificar->setTipo(4);
                $em->persist($ficha_modificar);
                
            }
    }    
    
}        

//Establecemos las condiciones parael grupo
public function setCondicionesGrupo($grupos){
    $em=  $this->getEntityManager();
    foreach ($grupos as $grupo) {
        
     $ficha_condicion_profesor=$em->createQuery(
                    "SELECT h FROM NetpublicCoreBundle:CondicionGrupo h 
                             WHERE h.tipo=1 AND h.grupo=:grupo
                       ")
                    ->setParameter("grupo", $grupo->getId())   
                    ->getResult();          
            foreach ($ficha_condicion_profesor as $ficha) {
                $ficha_modificar= $em->getRepository("NetpublicCoreBundle:HorarioGrupo")
                                    ->findOneBy(array(
                                        'hora_fila'=>$ficha->getHoraFila(),
                                        'dia_columna'=>$ficha->getDiaColumna(),
                                        'grupo'=>$grupo->getId()
                                    ));
                $ficha_modificar->setTipo(4);                
                $em->persist($ficha_modificar);

                
            }
    }    
    
}        
public function hayCondicionesAsignatura($asignatura_id){
    $em=  $this->getEntityManager();
    $r=false;
    $re=$em->createQuery(
        "SELECT count(h) FROM NetpublicCoreBundle:CondicionAsignatura h 
         WHERE h.tipo=1 and h.asignatura=:asignatura_id                              
     ")                
    ->setParameters(
        array(                                 
        'asignatura_id'=>$asignatura_id
        ))
      ->getSingleScalarResult();                   

    if($re>0)
        $r=true;
    return $r;
}
public function hayCondicionesCargaAcademica($ca_id){
    $em=  $this->getEntityManager();
    $r=false;
    $re=$em->createQuery(
        "SELECT count(h) FROM NetpublicCoreBundle:CondicionContrato h 
         WHERE h.tipo=1 and h.carga_academica=:ca_id                              
     ")                
    ->setParameters(
        array(                                 
        'ca_id'=>$ca_id
        ))
      ->getSingleScalarResult();                   

    if($re>0)
        $r=true;
    return $r;
}

public function setCondicionesAsignatura($asignatura_id,$grupo_id){
    $em=  $this->getEntityManager();            
     $ficha_condicion_profesor=$em->createQuery(
                    "SELECT h FROM NetpublicCoreBundle:CondicionAsignatura h 
                             WHERE h.tipo=1 AND h.asignatura=:asignatura_id
                       ")
                    ->setParameter("asignatura_id",$asignatura_id )   
                    ->getResult();          
            foreach ($ficha_condicion_profesor as $ficha) {
                $ficha_modificar= $em->getRepository("NetpublicCoreBundle:HorarioGrupo")
                                    ->findOneBy(array(
                                        'hora_fila'=>$ficha->getHoraFila(),
                                        'dia_columna'=>$ficha->getDiaColumna(),
                                        'grupo'=>$grupo_id
                                    ));
                $ficha_modificar->setTipo(5);                
                $em->persist($ficha_modificar);                
            }        
    $em->flush();
}        
public function setCondicionesContrato($contrato_id,$grupo_id){
    $em=  $this->getEntityManager();            
     $ficha_condicion_profesor=$em->createQuery(
                    "SELECT h FROM NetpublicCoreBundle:CondicionContrato h 
                             WHERE h.tipo=1 AND h.carga_academica=:contrato_id
                       ")
                    ->setParameter("contrato_id",$contrato_id )   
                    ->getResult();          
            foreach ($ficha_condicion_profesor as $ficha) {
                $ficha_modificar= $em->getRepository("NetpublicCoreBundle:HorarioGrupo")
                                    ->findOneBy(array(
                                        'hora_fila'=>$ficha->getHoraFila(),
                                        'dia_columna'=>$ficha->getDiaColumna(),
                                        'grupo'=>$grupo_id
                                    ));
                $ficha_modificar->setTipo(6);                
                $em->persist($ficha_modificar);                
            }        
    $em->flush();
}        
public function getValueCondicionColegio($hora,$dia) {
    $ficha=  $this
            ->getEntityManager()
            ->getRepository("NetpublicCoreBundle:CondicionCargaacademicacolegio")
            ->findOneBy(array(
                "dia_columna"=>$dia,
                "hora_fila"=>$hora
            ))
            ;
    return $ficha;
}
}

?>
