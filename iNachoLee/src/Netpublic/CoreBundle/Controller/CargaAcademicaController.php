<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\CargaAcademica;
use Netpublic\CoreBundle\Form\CargaAcademicaType;
use Netpublic\CoreBundle\Form\CargaAcademicafType;
use Netpublic\CoreBundle\Form\CargaAcademicaAutomaticaType;
use Symfony\Component\HttpFoundation\Response;
use Netpublic\CoreBundle\Entity\HorarioAula;
use Netpublic\CoreBundle\Entity\Profesor;
use Netpublic\CoreBundle\Entity\HorarioProfesor;
use Netpublic\CoreBundle\Entity\Dimension;


/**
 * CargaAcademica controller.
 *
 * @Route("/cargaacademica")
 */
class CargaAcademicaController extends Controller
{
     /**
     * Buscar Usuarios an existing Usuario entity.
     * @Route("/todascargas",name="carga_academica_todascargas")     
     * @Template()
     */
    public function todascargasAction(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $request=  $this->getRequest();
        $em=  $this->getDoctrine()->getManager();
        $session=$request->getSession();
        $ano_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_activo->getId());
        
        $cargas=  $em->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
            'ano_escolar'=>$ano_escolar_id_s
        ));
        $carga_json=array();
        foreach ($cargas as $ca) {
            $carga_json[]=$ca->getId();                                   
        }
        return new \Symfony\Component\HttpFoundation\JsonResponse($carga_json);
         
    }

    /**
     * Buscar Usuarios an existing Usuario entity.
     * @Route("/{grado_id}/mostrarcargagrado.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|json|pdf"},name="carga_academica_mostrarcargagrado")     
     * @Template()
     */
    public function mostrarcargagradoAction($grado_id){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $request=  $this->getRequest();
        $em=  $this->getDoctrine()->getManager();
        $session=$request->getSession();
        $ano_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_activo->getId());
        
        $grupos=  $em->getRepository("NetpublicCoreBundle:Grupo")->findBy(array(
            'grado'=>$grado_id
        ));
        $carga_academicas=array();
        $carga_json=array();
        foreach ($grupos as $grupo) {
             $carga_academicas=  $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:CargaAcademica")
                               ->findBy(array(
                                   "grupo"=>$grupo->getId(),
                                   'ano_escolar'=>$ano_escolar_id_s
                               ));
                               foreach ($carga_academicas as $ca) {
                                   $carga_json[]=$ca->getId();                                   
                               }
        }
       $format = $request->get('_format');
        if($format=="json"){
            return new \Symfony\Component\HttpFoundation\JsonResponse($carga_json);
        }
        return array(
            'carga_academica' => array()
         );
         
    }

     /**
     * Buscar Usuarios an existing Usuario entity.
     * @Route("/{grupo_id}/mostrargrupo.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|json|pdf"},name="carga_academica_mostrargrupo")     
     * @Template()
     */
    public function mostrargrupoAction($grupo_id){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $request=  $this->getRequest();
        $session=$request->getSession();
        $em=  $this->getDoctrine()->getManager();
        $ano_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_activo->getId());
        $carga_academica=  $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:CargaAcademica")
                               ->findBy(array(
                                   "grupo"=>$grupo_id,
                                   'ano_escolar'=>$ano_escolar_id_s
                               ));
        
        $format = $request->get('_format');
        if($format=="json"){
            $carga_json=array();
            foreach ($carga_academica as $carga) {
                $carga_json[]=$carga->getId();
            }
            return new \Symfony\Component\HttpFoundation\JsonResponse($carga_json);
        }
        return array(
            'carga_academica' => $carga_academica
         );
         
    }
     /**
     * Buscar Usuarios an existing Usuario entity.
     * @Route("/{grupo_id}/mostrargrupotipo.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|json|pdf"},name="carga_academica_mostrargrupotipo")     
     * @Template()
     */
    public function mostrargrupotipoAction($grupo_id){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $request=  $this->getRequest();
        $carga_academica=  $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:CargaAcademica")
                               ->findBy(array(
                                   "grupo"=>$grupo_id
                               ));
        
        $format = $request->get('_format');
        if($format=="json"){
            $carga_json=array();
            foreach ($carga_academica as $carga) {
                $carga_json[]=$carga->getId();
            }
            return new \Symfony\Component\HttpFoundation\JsonResponse($carga_json);
        }
        return array(
            'carga_academica' => $carga_academica
         );
         
    }

     /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/{ca_id}/{id_componente}/mostrardetallescomponentes", name="carga_academica_mostrardetallescomponentes")     
     * @Template()
     */
    public function mostrardetallescomponentesAction($ca_id,$id_componente){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $em=  $this->getDoctrine()->getEntityManager();
        $session=  $this->getRequest()->getSession();
        $ca=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($ca_id);
        $asignatura_id=$ca->getAsignatura()->getId();        
        $grupo_id_ca=$ca->getGrupo()->getId();
        
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        $ano_escolar_session_id=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
        $alumnos=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findAlumnos($ano_escolar_session_id,$grupo_id_ca);
        $entities=$em->getRepository("NetpublicCoreBundle:Grupo")->findNotasPeriodoEscolar($alumnos,$id_componente,$asignatura_id);
        return array(
            'carga_academica'=>$ca,
            'alumnos'=>$alumnos,
            'entities'=>$entities
        );
        
    }


    /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/{id_ca}/mostrardetallesprofesorasignatura", name="carga_academica_mostrardetallesprofesorasignatura")     
     * @Template()
     */
    public function mostrardetallesprofesorasignaturaAction($id_ca){
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        $session=$this->get('request')->getSession();
        $em=  $this->getDoctrine()->getEntityManager();
        $periodo=$session->get('perido_id');        
        $carga_academica=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($id_ca);
        $profesor_id=$carga_academica->getProfesor()->getId();
        $asignatura_id=$carga_academica->getAsignatura()->getId();
        $grupo_id=$carga_academica->getGrupo()->getId();
        $componentes=  $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Dimension")
                               ->findComponentes($periodo,$profesor_id,$asignatura_id,$grupo_id);
                               return array(
                                   'componentes'=>$componentes,
                                   'id_ca'=>$id_ca
                               );
                               
      
    }
     /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/{tipo}/{grupo_id}/{ano_id}/vergrupolista", name="carga_academica_vergrupolista")     
     * @Template()
     */
    public function vergrupolistaAction($tipo,$grupo_id,$ano_id){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $em=  $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $ano_escolar_id_s=$ano_id;
        $periodo=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodoEscolar($ano_id);
        $periodo_id=$periodo->getId();
        if($grupo_id=='0'){
            $grupo=$em->getRepository("NetpublicCoreBundle:Grupo")->findOneBy(array(
                'grado'=>$request->get('grado_id')
            ));
            
            $ca=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findOneBy(array(
            'grupo'=>$grupo->getId(),
            'ano_escolar'=>$ano_escolar_id_s
            ));        
        }
        else{
            $ca=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findOneBy(array(
            'grupo'=>$grupo_id,
            'ano_escolar'=>$ano_escolar_id_s
            ));
        }
        $alumnos=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findAlumnosGrupo($ano_escolar_id_s,$grupo_id);
        $asignatura_id=$ca->getAsignatura()->getId();  
        
        $entities=$em->getRepository("NetpublicCoreBundle:Grupo")->findNotasPeriodoEscolar($alumnos,$periodo_id,$asignatura_id);
        //grupos de registro
        $grupos=array();
        foreach ($alumnos as $a) {
            $ma=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findOneBy(array(
                'ano'=>$ano_escolar_id_s,
                'alumno'=>$a->getId()
            ));
            $grupos[]=$ma->getGrupo();
        }
        return array(
            'carga_academica'=>$ca,
            'alumnos'=>$alumnos,
            'entities'=>$entities,
            'tipo'=>$tipo,
            'grupos'=>$grupos,
            'ano_escolar_id'=>$ano_escolar_id_s
        );
        
        
    }
    /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/{tipo}/{grado_id}/{ano_id}/vergradolista", name="carga_academica_vergradolista")     
     * @Template("NetpublicCoreBundle:CargaAcademica:vergrupolista.html.twig")
     */
    public function vergradolistaAction($grado_id,$tipo,$ano_id){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $em=  $this->getDoctrine()->getEntityManager();
        $ano_escolar_id_s=$ano_id;
        
        $periodo=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodoEscolar($ano_id);
        $periodo_id=$periodo->getId();
        $grupo=$em->getRepository("NetpublicCoreBundle:Grupo")->findOneBy(array(
            'grado'=>$grado_id
        ));
        $ca=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findOneBy(array(
            'grupo'=>$grupo->getId(),
            'ano_escolar'=>$ano_escolar_id_s
        ));
        if($ca){
            $asignatura_id=$ca->getAsignatura()->getId();        
        }
        else {
           $ca=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findOneBy(array(
            'grupo'=>$grupo->getId(),
            )); 
           $asignatura_id=$ca->getAsignatura()->getId(); 
        }      
        $alumnos=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findAlumnosGrado($ano_escolar_id_s,$grado_id);
        if(!count($alumnos)){
            $alumnos=$em->getRepository("NetpublicCoreBundle:Alumno")->findBy(array(
                'grupo'=>$grupo->getId()
            ));
            echo "adasdas";
        }
        $entities=$em->getRepository("NetpublicCoreBundle:Grupo")->findNotasPeriodoEscolar($alumnos,$periodo_id,$asignatura_id);
        $grupos=array();
        foreach ($alumnos as $a) {
            $ma=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findOneBy(array(
                'ano'=>$ano_escolar_id_s,
                'alumno'=>$a->getId()
            ));
            $grupos[]=$ma->getGrupo();
        }
        
        return array(
            'carga_academica'=>$ca,
            'alumnos'=>$alumnos,
            'entities'=>$entities,
            'tipo'=>$tipo,
            'grupos'=>$grupos,
            'ano_escolar_id'=>$ano_escolar_id_s
        );
        
        
    }


     /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/{ca_id}/verdetallescargaunprofesor", name="carga_academica_verdetallescargaunprofesor")     
     * @Template()
     */
    public function verdetallescargaunprofesorAction($ca_id){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $em=  $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $session=$request->getSession();
        $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodoEscolarActivo();
        $periodo_id=$session->get('perido_id',$periodo_activo->getId());
        
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        $ano_escolar_session_id=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
        
        $ca=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($ca_id);
        $asignatura_id=$ca->getAsignatura()->getId();        
        $grupo_id_ca=$ca->getGrupo()->getId();
        $alumnos=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findAlumnos($ano_escolar_session_id,$grupo_id_ca);
        
        $entities=$em->getRepository("NetpublicCoreBundle:Grupo")->findNotasPeriodoEscolar($alumnos,$periodo_id,$asignatura_id);
        
        return array(
            'carga_academica'=>$ca,
            'alumnos'=>$alumnos,
            'entities'=>$entities
        );
        
    }
     /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/{profesor_id}/vercargaunprofesor", name="carga_academica_vercargaunprofesor")     
     * @Template()
     */
    public function vercargaunprofesorAction($profesor_id){
       $carga_academica=  $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:CargaAcademica")
                               ->findBy(array(
                                   "profesor"=>$profesor_id
                               ));
                               return array(
                                   'carga_academica'=>$carga_academica
                               );
      
    }


     /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/{profesor_id}/mostrardetallesprofesor", name="carga_academica_mostrardetallesprofesor")     
     * @Template()
     */
    public function mostrardetallesprofesorAction($profesor_id){
        ini_set('memory_limit', '-1');
        set_time_limit(0);

       $carga_academica=  $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:CargaAcademica")
                               ->findBy(array(
                                   "profesor"=>$profesor_id
                               ));
                               return array(
                                   'carga_academica'=>$carga_academica
                               );
      
    }
        /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/buscarcomponentes", name="carga_academica_buscarcomponentes")     
     * @Template()
     */
    public function buscarcomponentesAction(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        $request = $this->getRequest();        
        $sede=$request->get("sede");    
        $grado=$request->get('grado');
        $grupo=$request->get('grupo');
        $q=$request->get('query');
       
            $repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:Profesor');        
            $query = $repository->createQueryBuilder('p');                     
            if($sede!='*'){
                $query = $query->andWhere("p.sede=:sede_id")        
                         ->setParameter('sede_id',$sede);
            }
            
            if($grado!='*'){
                $query=$query->join("p.carga_academica","c");
                $query=$query->join("c.grupo","g");            
                $query = $query->andWhere("g.grado=:grado_id")        
                         ->setParameter('grado_id',$grado);
                if($grupo!='*'){
                    $query = $query->andWhere("c.grupo=:grupo_id")        
                         ->setParameter('grupo_id',$grupo);
                
                }
            }
              if($q!='*'){
                 if(is_numeric($q)){   
                    $query =  $query->andWhere("p.cedula LIKE :filtro");            
                    $query =  $query->setParameter('filtro','%'.$q.'%');
                 }
                 else{
                     $query =  $query->andWhere("p.nombre LIKE :filtro");            
                     $query =  $query->setParameter('filtro','%'.$q.'%');
                 
                 }
            }
            $query=$query->andWhere("p.tipo=2");
       

            //$query=$query->setMaxResults(60);
        $query=$query->orderBy('p.apellido', 'ASC');     
        $query = $query->getQuery();      
        $profesores= $query->getResult();
    $ano_escolar_activo=  $this->getDoctrine()
            ->getRepository("NetpublicCoreBundle:Dimension")
            ->findAnoEscolarActivo();
    $nro_usuarios=count($profesores);
    
        return array(
            "profesores"=>$profesores,             
            'nro_usuarios'=>$nro_usuarios,
            'ano_escolar_activo'=>$ano_escolar_activo,
            'grado'=>$grado,
            'grupo'=>$grupo
        );
    }


    /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/buscarplanillas", name="carga_academica_buscarplanillas")     
     * @Template()
     */
    public function buscarplanillasAction(){
        $request = $this->getRequest();        
        $sede=$request->get("sede");    
        $grado=$request->get('grado');
        $grupo=$request->get('grupo');
        $asignatura=$request->get('asignatura');
        $q=$request->get('query');
       
            $repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:CargaAcademica');        
            $query = $repository->createQueryBuilder('c');                     
            $query=$query->join("c.profesor","p");
                     
            if($sede!='*'){
                $query = $query->andWhere("p.sede=:sede_id")        
                         ->setParameter('sede_id',$sede);
            }
            if($grado!='*'){
                $query=$query->join("c.grupo","g");        
                $query = $query->andWhere("g.grado=:grado_id")        
                         ->setParameter('grado_id',$grado);
            }
            if($grupo!='*'){
                $query = $query->andWhere("c.grupo=:grupo_id")                     
                         ->setParameter('grupo_id',$grupo);    
            }
            if($asignatura!='*'){
                $query = $query->andWhere("c.asignatura=:asignatura_id")                     
                         ->setParameter('asignatura_id',$asignatura);    
            }
              if($q!='*'){
                 if(is_numeric($q)){   
                    $query =  $query->andWhere("p.cedula LIKE :filtro");            
                    $query =  $query->setParameter('filtro','%'.$q.'%');
                 }
                 else{
                     $query =  $query->andWhere("p.nombre LIKE :filtro");            
                     $query =  $query->setParameter('filtro','%'.$q.'%');
                 
                 }
            }
       

            //$query=$query->setMaxResults(60);
        $query=$query->orderBy('p.apellido', 'ASC');     
        $query = $query->getQuery();      
        $cargas_academicas= $query->getResult();
    $ano_escolar_activo=  $this->getDoctrine()
            ->getRepository("NetpublicCoreBundle:Dimension")
            ->findAnoEscolarActivo();
    $nro_usuarios=count($cargas_academicas);
    
        return array(
            "cargas_academicas"=>$cargas_academicas,
            'nro_usuarios'=>$nro_usuarios,
            'ano_escolar_activo'=>$ano_escolar_activo
        );
    }

        /**
     * Lists all CargaAcademica entities.
     *
     * @Route("/{tipo}/{grupo}/{id_profesor}/mostrar", name="cargaacademica_mostrar")
     * @Template()
     */
    public function mostrarAction($tipo,$grupo,$id_profesor)
    {
        
        if($tipo){
            $libres=true;
         $carga_academica=  $this->getDoctrine()
         ->getRepository("NetpublicCoreBundle:CargaAcademica")
         ->findBy(array(
             "tiene_profesor"=>$libres,
             'grupo'=>$grupo,
              'profesor'=>$id_profesor
         ));

        }
        else{
            $libres=false;
        $carga_academica=  $this->getDoctrine()
         ->getRepository("NetpublicCoreBundle:CargaAcademica")
         ->findBy(array(
             "tiene_profesor"=>$libres,
             'grupo'=>$grupo
            
         ));
        }
        return array(
            "carga_academica"=>$carga_academica,            
            "tipo"=>$tipo
        );
        

        
    }
     /**
     * Lists all CargaAcademica entities.
     *
     * @Route("/eliminarca", name="cargaacademica_eliminarca")
     * @Template()
     */
    //Asignar carga Academica
    public function eliminarcaAction()
    {
         set_time_limit(0);
         ini_set('memory_limit', '-1');    
         $em=  $this->getDoctrine()->getEntityManager();
         $request=  $this->getRequest();
	 $ids=  json_decode($request->get('ids'));
         $ids_value=  json_decode($request->get('ids_values'));
         for ($index = 0; $index < count($ids_value); $index++) {
             if($ids_value[$index]==1){
                $ca=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($ids[$index]);
                
                foreach ($ca->getCondicionContrato() as $contrato) {
                    $ca->removeCondicionContrato($contrato);
                }
                foreach ($ca->getDesempeno() as $d) {
                    $ca->removeDesempeno($d);
                }
                foreach ($ca->getHorarioClase() as $hc) {
                    $ca->removeHorarioClase($hc);
                }
                foreach ($ca->getHorarioGrupo() as $hg) {
                    $ca->removeHorarioGrupo($hg);
                }
                $em->remove($ca);
             }
         }
         $em->flush();
         return new Response("ok");
    }

    /**
     * Lists all CargaAcademica entities.
     *
     * @Route("/{ano_escolar_id}/asignarano", name="cargaacademica_asignarano")
     * @Template()
     */
    //Asignar carga Academica
    public function asignaranoAction($ano_escolar_id)
    {
         set_time_limit(0);
         ini_set('memory_limit', '-1');    
         $em=  $this->getDoctrine()->getEntityManager();
         $request=  $this->getRequest();
	 $ids=  json_decode($request->get('ids'));
         $ids_value=  json_decode($request->get('ids_values'));
         $anoEscolar=$em->getRepository("NetpublicCoreBundle:Dimension")->find($ano_escolar_id);
         for ($index = 0; $index < count($ids_value); $index++) {
             if($ids_value[$index]==1){
                 $ca=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($ids[$index]);
                $ca->setAnoEscolar($anoEscolar);
                $em->persist($ca);
             }
         }
         $em->flush();
         return new Response("ok");
    }
     /**
     * Lists all CargaAcademica entities.
     *
     * @Route("/{id_profesor}/moverlibrenolibre", name="cargaacademica_moverlibrenolibre")
     * @Template()
     */
    //Asignar carga Academica
    public function moverlibrenolibreAction($id_profesor)
    {
         set_time_limit(0);
         ini_set('memory_limit', '-1');    
         $em=  $this->getDoctrine()->getEntityManager();
         $request=  $this->getRequest();
	 $ano_escolar_activo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
							     ->findAnoEscolarActivo();
        $ids=  json_decode($request->get('ids'));
        $ids_value=  json_decode($request->get('ids_values'));
        $profesor=  $this->getDoctrine()
                         ->getRepository("NetpublicCoreBundle:Profesor")
                         ->find($id_profesor);
        for ($index = 0; $index < count($ids_value); $index++) {
            echo "mama:$index";
              if($ids_value[$index]==1){
                $ca=  $this->getDoctrine()
                        ->getRepository("NetpublicCoreBundle:CargaAcademica")
                        ->find($ids[$index]);
                $ca->setTieneProfesor(1);
                $ca->setProfesor($profesor);
                $ca->setProfesorDueno($profesor);
                $profesor_dueno=$ca->getProfesorDueno();
                if($profesor_dueno){                 
                    $notas_pasar=$em->getRepository("NetpublicCoreBundle:AlumnoDimension")
                    ->getNotasProfesor($profesor_dueno->getId(),$ano_escolar_activo->getId());
                     foreach ($notas_pasar as $nota) {
                         echo "$nota<br/>";
                         $dimension=$nota->getDimension();
                         //if($dimension->getTipo()==4){
                            $dimension->setProfesor($profesor);
                            $em->persist($nota);
                         //}
                     }
                     $em->flush();
                }
                $ca->setEsCargaAcademica(TRUE);								
                $em->persist($ca);
                   
              }
                
         }
         
        return new Response("ok");
        
    }
     /**
     * Lists all CargaAcademica entities.
     *
     * @Route("/{id_profesor}/moverprofesor", name="cargaacademica_moverprofesor")
     * @Template()
     */
    public function moverprofesorAction($id_profesor)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $ids=  json_decode($request->get('ids'));
        $ids_value=  json_decode($request->get('ids_values'));
        $profesor=  $this->getDoctrine()
                         ->getRepository("NetpublicCoreBundle:Profesor")
                         ->find($id_profesor);
        for ($index = 0; $index < count($ids_value); $index++) {
            if($ids_value[$index]==1){
                $ca=  $this->getDoctrine()
                        ->getRepository("NetpublicCoreBundle:CargaAcademica")
                        ->find($ids[$index]);
                $ca->setTieneProfesor(1);
                $ca->setProfesor($profesor);
                
                $ca->setEsCargaAcademica(TRUE);								
                $em->persist($ca);
                $asgi=$ca->getAsignatura();
                $asignaturas_areas[]=$asgi;
                $asignaturas_areas[]=$asgi->getArea();
            }
        }
        $em->flush();
        
        return new Response("ok");
        
    }

    /**
     * Lists all CargaAcademica entities.
     *
     * @Route("/{id_profesor}/movernolibrelibre", name="cargaacademica_movernolibrelibre")
     * @Template()
     */
    //retirarCarga
    public function movernolibrelibreAction($id_profesor)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $ids=  json_decode($request->get('ids'));
        $ids_value=  json_decode($request->get('ids_values'));
        for ($index = 0; $index < count($ids_value); $index++) {
            if($ids_value[$index]==1){
                $ca=  $this->getDoctrine()
                        ->getRepository("NetpublicCoreBundle:CargaAcademica")
                        ->find($ids[$index]);
                $profesorDueno=$ca->getProfesor();
                $ca->setTieneProfesor(0);
                $ca->setProfesor();
                $ca->setProfesorDueno($profesorDueno);
                $ca->setEsCargaAcademica(FALSE);
                $h_c_ca=  $this->getDoctrine()
                          ->getRepository("NetpublicCoreBundle:HorarioClase")
                          ->findBy(array(
                              'carga_academica'=>$ca->getId(),
                              'profesor'=>$id_profesor
                          ));
                  foreach ($h_c_ca as $v) {
                      $v->setTipo(0);
                      $em->persist($v);
                  }
                $em->persist($ca);
            }
        }
        $em->flush();
        
        return new Response("ok");
        
    }


    /**
     * Lists all CargaAcademica entities.
     *
     * @Route("/", name="cargaacademica")
     * @Template()
     */
    public function indexAction()
    {
        $em=  $this->getDoctrine()->getManager();
        $request=  $this->getRequest();
        $session=$request->getSession();
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        $periodos=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodosEscolar($ano_escolar_activo);
        $periodo_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodoEscolarActivo($ano_escolar_activo);
        $ano_escolar_session_id=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
        $periodo_session=$session->get("perido_id",$periodo_escolar_activo->getId());
        
        return array(
            'ano_session'=>$ano_escolar_session_id,
            'periodo_session'=>$periodo_session,
            'periodos_escolares'=>$periodos
            );
    }
    /**
     * Lists all CargaAcademica entities.
     *
     * @Route("/listar/asignaturas", name="cargaacademica_listarasignaturas")
     * @Template()
     */
    public function listarasignaturasAction()
    {        
        $grados=$this->getDoctrine()
                     ->getRepository("NetpublicCoreBundle:Grado")
                     ->findAll();
        
        
        $asignaturas=$this->getDoctrine()
                     ->getRepository("NetpublicCoreBundle:Asignatura")
                     ->findBy(array(
                         'es_area'=>0
                     ));
        return array(            
            'asignaturas'=>$asignaturas,
            'grados'=>$grados
            );
    }

    
    /**
     * Lists all CargaAcademica entities.
     *
     * @Route("/listar/profesores", name="cargaacademica_listarprofesores")
     * @Template()
     */
    public function listarprofesoresAction()
    {   
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="SELECT p FROM NetpublicCoreBundle:Profesor p";
        $dql.=" WHERE p.tipo=2";
        $query=$em->createQuery($dql);        
        $profesores= $paginador->paginate($query)->getResult();
        
        return array(            
            'profesores'=>$profesores,
            );
    }

    /**
     * Lists all CargaAcademica entities.
     *
     * @Route("/listar", name="cargaacademica_listar")
     * @Template()
     */
    public function listarAction()
    {
        $em=  $this->getDoctrine()->getManager();
        $grados=  $this
                       ->getDoctrine()
                       ->getRepository("NetpublicCoreBundle:Grado")
                       ->findAll();
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        $ano_escolares=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolares();
        $profesores=$this->getDoctrine()
                     ->getRepository("NetpublicCoreBundle:Profesor")
                     ->findBy(array(
                         'tipo'=>2
                     ),array("apellido"=>'ASC')
                             );
        return array(
            'grados'=>$grados,            
            'profesores'=>$profesores,
            'ano_escolares'=>$ano_escolares,
            'ano_escolar_activo'=>$ano_escolar_activo
            );
    }
    
        /**
     * Lists all CargaAcademica entities.
     *
     * @Route("/{tipo_clase}/{grupo_id}/{ano_escolar_id}/{grado_id}/filtro", name="cargaacademica_filtro")
     * @Template()
     */
    public function filtroAction($tipo_clase,$grupo_id,$ano_escolar_id,$grado_id)
    {
        $em=  $this->getDoctrine()->getManager();
        $grados=  $this->getDoctrine()->getEntityManager()
                                ->getRepository("NetpublicCoreBundle:Grado")
                                ->findBy(array(
                                    'id'=>$grado_id
                                ));
        $grupos=$em->getRepository("NetpublicCoreBundle:Grupo")->findBy(array(
            'grado'=>$grado_id
        ));
        $repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:CargaAcademica');        
            $query = $repository->createQueryBuilder('c');                                
            if($grado_id!='*'){                
                 $query=$query->join("c.grupo","g");
                 $query = $query->andWhere("g.grado=:grado_id")        
                         ->setParameter('grado_id',$grado_id);
            }
            if($tipo_clase!='*'){
                $query = $query->andWhere("c.tiene_profesor=:tiene_profesor")        
                         ->setParameter('tiene_profesor',$tipo_clase);
            }
            if($grupo_id!='*'){
                $query = $query->andWhere("c.grupo=:grupo_id")        
                         ->setParameter('grupo_id',$grupo_id);
                $grupos=$em->getRepository("NetpublicCoreBundle:Grupo")->findBy(array(
                        'id'=>$grupo_id
                        ));
            }
            if($ano_escolar_id!='*'){
                $query = $query->andWhere("c.ano_escolar=:ano_escolar_id")                     
                         ->setParameter('ano_escolar_id',$ano_escolar_id);
                $query=$query->orWhere("c.ano_escolar is null");
            }
            $em=$this->getDoctrine()->getManager();
            
        $query = $query->getQuery();      
        $carga_academica= $query->getResult();
        $profesores=$this->getDoctrine()
                     ->getRepository("NetpublicCoreBundle:Profesor")
                     ->findBy(array(
                         'tipo'=>2
                     ));

        return array(
            'grados'=>$grados,
            'cargas_academicas'=>$carga_academica,
            'profesores'=>$profesores,
            'grupos'=>$grupos
        );
        
    }

    /**
     * Lists all CargaAcademica entities.
     *
     * @Route("/{grupo}/{id_profesor}/asignar", name="cargaacademica_asignar")
     * @Template()
     */
    public function asignarAction($grupo,$id_profesor)
    {
      $this->getDoctrine()->getEntityManager()
        ->getRepository("NetpublicCoreBundle:HorarioClase")
         ->generarHorariosClase();     
              ;
       
        $grados=  $this->getDoctrine()
         ->getRepository("NetpublicCoreBundle:Grado")
         ->findAll();
        
        $carga_academica_libres=  $this->getDoctrine()
         ->getRepository("NetpublicCoreBundle:CargaAcademica")
         ->findBy(array(
             "tiene_profesor"=>false,
             'grupo'=>$grupo,
             
         ));
        $carga_academica_no_libres=  $this->getDoctrine()
         ->getRepository("NetpublicCoreBundle:CargaAcademica")
         ->findBy(array(
             "tiene_profesor"=>true,
             'grupo'=>$grupo,
             'profesor'=>$id_profesor
         ));
        $h_c_profesor=$this->getDoctrine()
         ->getRepository("NetpublicCoreBundle:HorarioClase")
         ->findBy(array(
             "profesor"=>$id_profesor                      ));
        return array(            
           'carga_academica_libres'=>$carga_academica_libres,
            'carga_academica_no_libres'=>$carga_academica_no_libres,            
            'grados'=>$grados,
            'h_c_profesor'=>$h_c_profesor,
            'id_profesor'=>$id_profesor
            );
    }
    
    
    /**
     * Actualiza las cargas y notifica de incongruencias
     *
     * @Route("/{id_profesor}/{id_carga_academica}/updateprofesor", name="cargaacademica_updateprofesor")
     * @Template()    
    */
    public function updateprofesorAction($id_profesor,$id_carga_academica){
        $em=$this->getDoctrine()->getEntityManager();
        $profesor=$this->getDoctrine()
                    ->getRepository("NetpublicCoreBundle:Profesor")
                    ->find($id_profesor);
        $ca=$this->getDoctrine()
                    ->getRepository("NetpublicCoreBundle:CargaAcademica")
                    ->find($id_carga_academica);
        
       
        $ca->setTieneProfesor(TRUE);
        $ca->setEsCargaAcademica(TRUE);
        $ca->setProfesor($profesor);
        
        $em->persist($ca);
        $em->flush();
        return new Response("Bueno vamos a modificar");
        
    }

    /**
     * Finds and displays a CargaAcademica entity.
     *
     * @Route("/{id}/show", name="cargaacademica_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CargaAcademica')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CargaAcademica entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new CargaAcademica entity.
     *
     * @Route("/new", name="cargaacademica_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CargaAcademica();
        $form   = $this->createForm(new CargaAcademicafType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }
    
    /**
     * Creates a new CargaAcademica entity.
     *
     * @Route("/create", name="cargaacademica_create")
     * @Method("post")
     * @Template("NetpublicCoreBundle:CargaAcademica:new.html.twig")
     */
    public function createAction()
    {  
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $hororario=$request->get('horarios_academico');
       $entity  = new CargaAcademica();        
        
        $form    = $this->createForm(new CargaAcademicafType(), $entity);
         $form->handleRequest($request);

        if ($form->isValid()) {
            //Verificamos si existe CargaAcademica a mostrar en Calificar Notas.
            $query = $em->createQuery('SELECT count(a) FROM NetpublicCoreBundle:CargaAcademica a WHERE a.asignatura=:asignatura_id AND a.grupo=:grupo_id AND a.profesor=:profesor_id')
                            ->setParameters(array(
                            "asignatura_id"=>$entity->getAsignatura()->getId(),
                            "grupo_id"=>$entity->getGrupo()->getId(),
                            "profesor_id"=>$entity->getProfesor()->getId()    
                                )
                            );
            $count = $query->getSingleScalarResult();
            if($count==0){
                $entity->setEsCargaAcademica(TRUE);
            }
            else{
                $query = $em->createQuery('UPDATE NetpublicCoreBundle:CargaAcademica a SET a.es_carga_academica=0 WHERE a.asignatura=:asignatura_id AND a.grupo=:grupo_id AND a.profesor=:profesor_id')
                            ->setParameters(array(
                            "asignatura_id"=>$entity->getAsignatura()->getId(),
                            "grupo_id"=>$entity->getGrupo()->getId(),
                            "profesor_id"=>$entity->getProfesor()->getId()    
                                )
                            )->execute();
                
               $entity->setEsCargaAcademica(TRUE);
            }
            //Restamos diferencia de contrato.
            $profesor=$entity->getProfesor();
            $asignatura=$entity->getAsignatura();
            //Calclams las hras cpadas.
            $query = $em->createQuery('SELECT count(a) FROM NetpublicCoreBundle:CargaAcademica a WHERE a.asignatura=:asignatura_id AND a.profesor=:profesor_id')
                            ->setParameters(array(
                            "asignatura_id"=>$entity->getAsignatura()->getId(),                            
                            "profesor_id"=>$entity->getProfesor()->getId()    
                                )
                            );
            $count = $query->getSingleScalarResult();            
            
            $em->flush();
            return $this->redirect($this->generateUrl('cargaacademica_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing CargaAcademica entity.
     *
     * @Route("/{id}/edit", name="cargaacademica_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CargaAcademica')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CargaAcademica entity.');
        }
        $edit_form_type=new CargaAcademicaType();
        $edit_form_type->setName("cargaacademica".$id);
        $editForm = $this->createForm($edit_form_type, $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing CargaAcademica entity.
     *
     * @Route("/{id}/update", name="cargaacademica_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:CargaAcademica:edit.html.twig")
     */
    public function updateAction($id)
    {
        
        return array(
            'ss'=>1
        );
    }
    /**
     * Edits an existing CargaAcademica entity.
     *
     * @Route("/{id}/updateunouno", name="cargaacademica_updateunouno")
     * @Method("post")
     * @Template("NetpublicCoreBundle:CargaAcademica:edit.html.twig")
     */
    public function updateunounoAction($id)
    {
        $resultado_text="No Se realizo ningun cambio";
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $nueva_enity=new CargaAcademica();
        $em->persist($nueva_enity);
        $em->flush();
        $id=$nueva_enity->getId();
        //        
        $entity = $em->getRepository('NetpublicCoreBundle:CargaAcademica')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CargaAcademica entity.');
        }
        $edit_form_type=new CargaAcademicafType();        
        $editForm   = $this->createForm($edit_form_type, $entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            //Agregamos los horarios 
            $horarios=$request->get('horarios_academico');
            if($horarios[1]['horario']!=-1){
                $ht=$this->getDoctrine()->getRepository("NetpublicCoreBundle:HorarioAula")->find($horarios[1]['horario']);
                $ht->setEsDisponible(FALSE);
                $em->persist($ht);
                $entity->setHorarioAula($ht);
            }
            for ($index = 2; $index < count($horarios); $index++) {
                if($horarios[$index]['horario']!=-1){
                    $horarios_agregar=new CargaAcademica();
                    $horarios_agregar->setAsignatura($entity->getAsignatura());
                    $horarios_agregar->setAula($entity->getAula());
                    $horarios_agregar->setGrupo($entity->getGrupo());
                    $ht=$this->getDoctrine()->getRepository("NetpublicCoreBundle:HorarioAula")->find($horarios[$index]['horario']);
                    $ht->setEsDisponible(FALSE);
                    $em->persist($ht);
                    $horarios_agregar->setHorarioAula($ht);
                    $horarios_agregar->setProfesor($entity->getProfesor());
                    $em->persist($horarios_agregar);
                }
            }
            if($horarios[1]['horario']!=-1){
                $em->persist($entity);
                $em->flush();
            }
           
            $resultado_text="Listo, cmabiso";
            if ($this->container->get('request')->isXmlHttpRequest()){
                return new \Symfony\Component\HttpFoundation\Response($resultado_text);
            }
            return $this->redirect($this->generateUrl('cargaacademica_edit', array('id' => $id)));
        }
        
    }

    /**
     * Deletes a CargaAcademica entity.
     *
     * @Route("/{id}/delete", name="cargaacademica_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:CargaAcademica')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CargaAcademica entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cargaacademica'));
    }
   

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    private function aasort (&$array, $key) {
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;
}
}
