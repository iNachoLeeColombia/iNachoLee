<?php

namespace Netpublic\CoreBundle\Repository;
use Netpublic\CoreBundle\Entity\NivelAcademico;
use Doctrine\ORM\EntityRepository;

/**
 * NivelacademicoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NivelacademicoRepository extends EntityRepository
{
    public function getNivelesEducGrupo($grupo_id,$periodo_id) {
        $query="SELECT n_a,a FROM NetpublicCoreBundle:NivelAcademico n_a JOIN n_a.alumno a";
        $query.=" WHERE (";
        $query.=" a.grupo=:grupo_id";
        $query.=" AND n_a.tipo=8";        
        $query.=" AND n_a.periodo_actual=:periodo_id";  
        
        $query.=" )";                          
        $query.=" ORDER BY n_a.nota DESC";        
        
        $n_ac=  $this->getEntityManager()->createQuery($query)                
                              ->setParameters(array(
                                            "grupo_id"=>$grupo_id,                                                                               
                                            "periodo_id"=>$periodo_id,
                                            
                                    ))->getResult();
                             
                             
        
        return $n_ac;        

        
    }
    public function generarNivelesACademicos(){
        $em=  $this->getEntityManager();
        $alumnos=  $this->getEntityManager()
                        ->getRepository("NetpublicCoreBundle:Alumno")
                        ->findBy(array(
                            "tipo"=>0
                        ));
        //Verificasmos ano escolar
        $entity=  $this->getEntityManager()
                        ->getRepository('NetpublicCoreBundle:Dimension')
                        ->findAnoEscolarActivo();
       $nro_n_a=  $this->getEntityManager()->createQuery(
       "SELECT count(n_a) FROM NetpublicCoreBundle:NivelAcademico n_a 
                WHERE n_a.periodo_actual=:periodo_actual")                
                     ->setParameters(array(
                      "periodo_actual"=>$entity->getId()))
                     ->getSingleScalarResult();
       if($nro_n_a==0){                  
                foreach ($alumnos as $alumno) {
                    $n_a= new NivelAcademico();
                    $n_a->setAlumno($alumno);
                    $n_a->setTipo(0);//Colegio
                    $n_a->setPeriodoActual($entity);
                    $em->persist($n_a);
                    $n_a= new NivelAcademico();
                    $n_a->setAlumno($alumno);
                    $n_a->setTipo(1);//Sede
                    $n_a->setPeriodoActual($entity);
                    $em->persist($n_a);
                    $n_a= new NivelAcademico();
                    $n_a->setAlumno($alumno);
                    $n_a->setTipo(2);//Grados
                    $n_a->setPeriodoActual($entity);
                    $em->persist($n_a);
                    $n_a= new NivelAcademico();
                    $n_a->setAlumno($alumno);
                    $n_a->setTipo(3);//Grupo
                    $n_a->setPeriodoActual($entity);
                    $em->persist($n_a);
                    $n_a= new NivelAcademico();
                    $n_a->setAlumno($alumno);
                    $n_a->setTipo(4);//Filtro
                    $n_a->setPeriodoActual($entity);
                    $em->persist($n_a);

                    
                }
    }
    
    //Vamos a peridos academicos
            //Verificasmos ano escolar
        $p_a=  $this->getEntityManager()
                        ->getRepository('NetpublicCoreBundle:Dimension')
                        ->findPeriodosEscolar($entity);
       foreach ($p_a as $p) {
                    
                
                $nro_n_a=  $this->getEntityManager()->createQuery(
                    "SELECT count(n_a) FROM NetpublicCoreBundle:NivelAcademico n_a 
                        WHERE n_a.periodo_actual=:periodo_actual")                
                     ->setParameters(array(
                      "periodo_actual"=>$p->getId()))
                     ->getSingleScalarResult();
            if($nro_n_a==0){                  
                foreach ($alumnos as $alumno) {
                    $n_a= new NivelAcademico();
                    $n_a->setAlumno($alumno);
                    $n_a->setTipo(0);//Colegio
                    $n_a->setPeriodoActual($p);
                    $em->persist($n_a);
                    $n_a= new NivelAcademico();
                    $n_a->setAlumno($alumno);
                    $n_a->setTipo(1);//Sede
                    $n_a->setPeriodoActual($p);
                    $em->persist($n_a);
                    $n_a= new NivelAcademico();
                    $n_a->setAlumno($alumno);
                    $n_a->setTipo(2);//Grados
                    $n_a->setPeriodoActual($p);
                    $em->persist($n_a);
                    $n_a= new NivelAcademico();
                    $n_a->setAlumno($alumno);
                    $n_a->setTipo(3);//Grupo
                    $n_a->setPeriodoActual($p);
                    $em->persist($n_a);
                    $n_a= new NivelAcademico();
                    $n_a->setAlumno($alumno);
                    $n_a->setTipo(4);//Filtro
                    $n_a->setPeriodoActual($p);
                    $em->persist($n_a);                    
                }
    }
   }
   $em->flush();
  }
public function generarNivelesACademicosAlumno($alumno,$periodo_id){
        $em=  $this->getEntityManager();
        $sql="DELETE NetpublicCoreBundle:NivelAcademico na where na.tipo!=8";
        $em->createQuery($sql)->execute();
        //Verificasmos periodoEscolar
        $nro_n_a=  $this->getEntityManager()->createQuery(
       "SELECT count(n_a) FROM NetpublicCoreBundle:NivelAcademico n_a 
                WHERE n_a.periodo_actual=:periodo_actual and n_a.alumno=:alumno")                
                     ->setParameters(array(
                      "periodo_actual"=>$periodo_id,
                      "alumno"=>$alumno->getId()
               
               ))
                     ->getSingleScalarResult();
       if($nro_n_a==0){                  
                    $n_a= new NivelAcademico();
                    $n_a->setAlumno($alumno);
                    $n_a->setTipo(8);//Colegio
                    $n_a->setPeriodoActual($em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id));
                    $em->persist($n_a);
       }
   $em->flush();
  }

}
