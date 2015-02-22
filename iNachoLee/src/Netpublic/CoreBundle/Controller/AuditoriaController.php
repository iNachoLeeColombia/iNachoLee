<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\Auditoria;
use Netpublic\CoreBundle\Form\AuditoriaType;
use Netpublic\CoreBundle\Entity\ProfesorSolicitud;

/**
 * Auditoria controller.
 *
 * @Route("/auditoria")
 */
class AuditoriaController extends Controller
{
      /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/revisionboletines", name="auditoria_revisionboletines")     
     * @Template()
     */
    public function revisionboletinesAction(){
        
        $em=  $this->getDoctrine();
        $user = $this->get('security.context')->getToken()->getUser();
        $grupos_director=array();
        $auditoria_activa=null;
        if($em->getRepository("NetpublicCoreBundle:Auditoria")->hayPublicacionesAuditoriasActivas(2)){
            $auditoria_activa=$em->getRepository("NetpublicCoreBundle:Auditoria")->getPublicacionAuditoriaActiva(2);
            
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor();            
            $profesor_id=$profesor->getId();
            $grupos_director=$em->getRepository("NetpublicCoreBundle:Grupo")->findBy(array(
                'director_grupo'=>$profesor_id
            ));
            
        }
        }
       
        return array(
            'id'=>1,
            'grupos_director'=>$grupos_director,
            'auditoria_activa'=>$auditoria_activa
        );
    }
     /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/listaactivas", name="auditoria_listaactivas")     
     * @Template()
     */
    public function listaactivasAction(){
        $hoy=new \DateTime("now");
        $hoy=$hoy->format("Y-m-d H:i:s");
        $resultado=array("auditorias"=>array());
        $em=  $this->getDoctrine()->getEntityManager();
        $query="SELECT a FROM NetpublicCoreBundle:Auditoria a ";
        $query.="WHERE ";    
        if ($this->get('security.context')->isGranted('ROLE_PROFESORES')) {
            $query.=" a.tipo=1 OR a.tipo=2";
            $query.=" AND a.fecha_inicio<=:fecha_actual"; 
            $query.=" AND a.fecha_final>=:fecha_actual"; 
            $query = $em->createQuery($query)
                            ->setParameters(array(
                           "fecha_actual"=>$hoy,
                            ));
            $auditorias = $query->getResult();
            $resultado=array(
             "auditorias"=>$auditorias
            );
        
            
        }    
        if ($this->get('security.context')->isGranted('ROLE_ESTUDIANTE')) {
            $query.=" a.tipo=3";
            $query.=" AND a.fecha_inicio<=:fecha_actual"; 
            $query.=" AND a.fecha_final>=:fecha_actual"; 
            $query = $em->createQuery($query)
                            ->setParameters(array(
                           "fecha_actual"=>$hoy,
                            ));
            $auditorias = $query->getResult();
            $user = $this->get('security.context')->getToken()->getUser();
        
          $resultado=array(
             "auditorias"=>$auditorias,
             "alumno_id"=>$user->getAlumno()->getId() 
           );

        }    

         return $resultado;
       
        
    }
   /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/{solicitud_id}/procesarsolicitudes", name="auditoria_procesarsolicitudes")     
     * @Template()
     */
    public function procesarsolicitudesAction($solicitud_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $solicitud=$em->getRepository("NetpublicCoreBundle:ProfesorSolicitud")->find($solicitud_id);
        $alumno=$solicitud->getAlumno();
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        $periodos_academicos=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodosEscolar($ano_escolar_activo);
        $tipo=$solicitud->getTipo();
        if($tipo!=2){
             $grupo_matricular=$solicitud->getGrupo();
             $asignaturas_areas=$grupo_matricular->getGrado()->getAsignaturas();             
       
        } 
        if($tipo==0){//Asignar Grupo
                   //Establecemos grupo
            $matricula=$em->getRepository("NetpublicCoreBundle:Alumno")
                          ->findMatricula($alumno,$ano_escolar_activo);
            if($matricula->getEsmatricula()==FALSE){
                    $em->getRepository("NetpublicCoreBundle:Alumno")
                      ->matricularAlumnoNuevo(
                                            $alumno,
                                            $grupo_matricular,
                                            $asignaturas_areas,
                                            $periodos_academicos,
                                            -1    
                                    );
                    $matricula->setEsMatricula(TRUE);
                    $alumno->setEsAdicion(1);
                    $em->persist($alumno);
                    $em->persist($matricula);
                    $solicitud->setEsRealizada(1);
                    $em->persist($solicitud);        
            }

        }
        if($tipo==1){//Cambiar  Grupo
            //Cancelamos la Matricula del Estudiante
             $em->getRepository("NetpublicCoreBundle:Alumno")->cancelarMatricula(
                     $alumno,$ano_escolar_activo->getId());   
             $matricula=$em->getRepository("NetpublicCoreBundle:Alumno")
                          ->findMatricula($alumno,$ano_escolar_activo);
            if($matricula->getEsmatricula()==FALSE){
                    $em->getRepository("NetpublicCoreBundle:Alumno")
                      ->matricularAlumnoNuevo(
                                            $alumno,
                                            $grupo_matricular,
                                            $asignaturas_areas,
                                            $periodos_academicos,
                                            -1    
                                    );
                    $matricula->setEsMatricula(TRUE);
                    $em->persist($matricula);
                    $solicitud->setEsRealizada(1);
                    $em->persist($solicitud);        
            }

        }
        if($tipo==2){//Cambiar  Grupo
            //Cancelamos la Matricula del Estudiante
             $em->getRepository("NetpublicCoreBundle:Alumno")->cancelarMatricula(
                     $alumno,$ano_escolar_activo->getId());   
                    $solicitud->setEsRealizada(1);
                    $em->persist($solicitud);        
           
        }

        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response("ok");
    }    
    /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/versolicitudes", name="auditoria_versolicitudes")     
     * @Template()
     */
    public function versolicitudesAction(){
        $em=  $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();            
        $sede='*';    
        $grado='*';
        $grupo='*';
        $item=20;
        $q='*';
        $condicion_ie='*';
            $repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:ProfesorSolicitud');        
            $query = $repository->createQueryBuilder('ps');                     
            $query=$query->join("ps.alumno","a");         
            if($q!='*'){
                 if(is_numeric($q)){   
                    $query =  $query->andWhere("a.cedula LIKE :filtro");            
                    $query =  $query->setParameter('filtro','%'.$q.'%');
                 }
                 else{
                     $query =  $query->andWhere("a.nombre LIKE :filtro");            
                     $query =  $query->setParameter('filtro','%'.$q.'%');
                 
                 }
            }
            if($sede!='*'){
                $query = $query->andWhere("a.sede=:sede_id")        
                         ->setParameter('sede_id',$sede);
            }
            $query = $query->andWhere("a.tipo=:tipo")        
                         ->setParameter('tipo',0);
            
            if($grado!='*'){
                $query = $query->andWhere("a.grado=:grado_id")        
                         ->setParameter('grado_id',$grado);
            }
            if($grupo!='*'){
                $query = $query->andWhere("a.grupo=:grupo_id")                     
                         ->setParameter('grupo_id',$grupo);    
            }
        //$query=$query->setMaxResults(60);
        $query=$query->orderBy('ps.es_realizada', 'ASC');     
        $query = $query->getQuery();      
        $solicitudesProfesores= $query->getResult();
        $grados=  $this->getDoctrine()
                       ->getEntityManager()
                       ->getRepository("NetpublicCoreBundle:Grado")
                       ->findAll();
        $sedes=$em->getRepository("NetpublicCoreBundle:Colegio")
                        ->findAll();

    $nro_usuarios=count($solicitudesProfesores);
     $auditoria_activa=null;
       if($em->getRepository("NetpublicCoreBundle:Auditoria")->hayPublicacionesAuditoriasActivas(1)){
           $auditoria_activa=$em
                   ->getRepository("NetpublicCoreBundle:Auditoria")
                   ->getPublicacionAuditoriaActiva(1);
       }
        return array(
            "solicitudes"=>$solicitudesProfesores,             
            'nro_usuarios'=>$nro_usuarios,
            "sedes"=>$sedes,            
            'grados'=>$grados,
            'auditoria_activa'=>$auditoria_activa
        );
    }
     /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/solicitudadicionar", name="auditoria_solicitudadicionar")     
     * @Template()
     */
    public function solicitudadicionarAction(){
        $em=  $this->getDoctrine()->getEntityManager();
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor();
        
         }
        $request=  $this->getRequest();
        $primer_nombre=$request->get("primer_nombre");
        $segundo_nombre=$request->get("segundo_nombre");
        $primer_apellido=$request->get("primer_apellido");
        $segundo_apellido=$request->get("segundo_apellido");
        $tipo_documento=$request->get("tipo_documento");
        $documento=$request->get("cedula");
        $grupo=$request->get("grupo");
        $grado=$request->get("grado");
        
        if($em->getRepository("NetpublicCoreBundle:Auditoria")->hayPublicacionesAuditoriasActivas(1)){
                      //Realizamos el registro del alumno
                $alumno=new \Netpublic\CoreBundle\Entity\Alumno();
                $alumno->setNombre($primer_nombre);
                $alumno->setNombre1($segundo_nombre);
                $alumno->setApellido($primer_apellido);
                $alumno->setApellido1($segundo_apellido);
                $alumno->setTipoDocumento($tipo_documento);
                $alumno->setTieneNovedad(TRUE);
                $alumno->setTipo(0);
                $alumno->setCedula($documento);
                 $grupo_=$em->getRepository("NetpublicCoreBundle:Grupo")->find($grupo);
                  $alumno->setGrado($em->getRepository("NetpublicCoreBundle:Grado")->find($grado));
                //$alumno->setGrupo($grupo_);
                $alumno->setSede($profesor->getSede());
                $em->getRepository("NetpublicCoreBundle:Alumno")->registrarEstudiante($alumno,$ano_escolar_activo);
                 $em->persist($alumno);
                $em->flush();
                $solicitud=new \Netpublic\CoreBundle\Entity\ProfesorSolicitud();
                $auditoria=$em->getRepository("NetpublicCoreBundle:Auditoria")->getPublicacionAuditoriaActiva(1);
                $solicitud->setAlumno($alumno);
                     $solicitud->setAuditoria($auditoria);
                     $solicitud->setGrupo($grupo_);
                     $solicitud->setTipo(0);
                     $solicitud->setEsRealizada(0);
                     $solicitud->setProfesor($profesor);        
                     $em->persist($solicitud);
                     $em->flush();       
        }
        return new \Symfony\Component\HttpFoundation\Response("ok");
    }
      /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/{alumno_id}/solicitudretirar", name="auditoria_solicitudretirar")     
     * @Template()
     */
    public function solicitudretirarAction($alumno_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $alumno=$em->getRepository("NetpublicCoreBundle:Alumno")->find($alumno_id);
        
        if($em->getRepository("NetpublicCoreBundle:Auditoria")->hayPublicacionesAuditoriasActivas(1)){
        
        $solicitud=new \Netpublic\CoreBundle\Entity\ProfesorSolicitud();
        $alumno->setTieneNovedad(TRUE);        
        $solicitud->setAlumno($alumno);
        $solicitud->setAuditoria($em->getRepository("NetpublicCoreBundle:Auditoria")->getPublicacionAuditoriaActiva(1));
        $solicitud->setTipo(2);
        $solicitud->setEsRealizada(0);
        $user = $this->get('security.context')->getToken()->getUser();
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor();
            $solicitud->setProfesor($profesor);
        
         }
        $em->persist($solicitud);
        $em->persist($alumno);
        $em->flush();
        }
         $grados=  $this->getDoctrine()
                       ->getEntityManager()
                       ->getRepository("NetpublicCoreBundle:Grado")
                       ->findAll();
   
        return array(
          "alumno"=>$alumno,
          "grados"=>$grados      
        );
        
    }
      /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/{alumno_id}/solicitudretirarlapizagil", name="auditoria_solicitudretirarlapizagil")     
     * @Template()
     */
    public function solicitudretirarlapizagilAction($alumno_id){
    
        
        $em=  $this->getDoctrine()->getEntityManager();
        
        $alumno=$em->getRepository("NetpublicCoreBundle:AlumnoDimension")->find($alumno_id)->getAlumno();
        if($em->getRepository("NetpublicCoreBundle:Auditoria")->hayPublicacionesAuditoriasActivas(1)){
        
        $nro_soli=$em->getRepository("NetpublicCoreBundle:Auditoria")
                ->getNroReportesAlunmno($alumno->getId(),2);
        if($nro_soli==0){
        $solicitud=new \Netpublic\CoreBundle\Entity\ProfesorSolicitud();
        $alumno=$em->getRepository("NetpublicCoreBundle:AlumnoDimension")->find($alumno_id)->getAlumno();
        $alumno->setTieneNovedad(TRUE);
        $solicitud->setGrupo($alumno->getGrupo());
        $alumno->setGrupo();
        $solicitud->setAlumno($alumno);
        $solicitud->setAuditoria($em->getRepository("NetpublicCoreBundle:Auditoria")->getPublicacionAuditoriaActiva(1));
        $solicitud->setTipo(2);
        $solicitud->setEsRealizada(0);
        $user = $this->get('security.context')->getToken()->getUser();
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor();
            $solicitud->setProfesor($profesor);
        
         }
        $em->persist($solicitud);
        $em->persist($alumno);
        }
        }
        $em->flush();
        
        return new \Symfony\Component\HttpFoundation\Response("$nro_soli");
    }

    /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/solicitudretirarmultiple", name="auditoria_solicitudretirarmultiple")     
     * @Template()
     */
    public function solicitudretirarmultipleAction(){
        ini_set('memory_limit', '-1');    
        set_time_limit(0);

        $alumnos_id=json_decode($this->get('request')->get('alumnos'));
        $em=  $this->getDoctrine()->getEntityManager();       
        if($em->getRepository("NetpublicCoreBundle:Auditoria")->hayPublicacionesAuditoriasActivas(1)){
        
        for ($index = 0; $index < count($alumnos_id); $index++) {
            $alumno=$em->getRepository("NetpublicCoreBundle:Alumno")->find($alumnos_id[$index]);
            $alumno->setTieneNovedad(TRUE);         
            $solicitud=new \Netpublic\CoreBundle\Entity\ProfesorSolicitud();
            $solicitud->setAlumno($alumno);
            $solicitud->setAuditoria($em->getRepository("NetpublicCoreBundle:Auditoria")->getPublicacionAuditoriaActiva(1));
            $solicitud->setTipo(2);
            $solicitud->setEsRealizada(0);
            $user = $this->get('security.context')->getToken()->getUser();
            if(($user->getEsAlumno()==FALSE)){
                $profesor=$user->getProfesor();
                $solicitud->setProfesor($profesor);
        
            }
            $em->persist($solicitud);
            $em->persist($alumno);
        
        }
        }
        $em->flush();
       
        return new \Symfony\Component\HttpFoundation\Response("ok");
        
        
    }
    
   
     /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/{alumno_id}/{grupo}/solicitudcambiar", name="auditoria_solicitudcambiar")     
     * @Template()
     */
    public function solicitudcambiarAction($alumno_id,$grupo){
        $em=  $this->getDoctrine()->getEntityManager();
        $alumno=$em->getRepository("NetpublicCoreBundle:Alumno")->find($alumno_id);
       
        if($em->getRepository("NetpublicCoreBundle:Auditoria")->hayPublicacionesAuditoriasActivas(1)){
       
        $solicitud=new \Netpublic\CoreBundle\Entity\ProfesorSolicitud();
        $alumno->setTieneNovedad(TRUE);        
        $solicitud->setAlumno($alumno);
        $solicitud->setAuditoria($em->getRepository("NetpublicCoreBundle:Auditoria")->getPublicacionAuditoriaActiva(1));
        $solicitud->setGrupo($em->getRepository("NetpublicCoreBundle:Grupo")->find($grupo));
        $solicitud->setTipo(1);
        $solicitud->setEsRealizada(0);
        $user = $this->get('security.context')->getToken()->getUser();
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor();
            $solicitud->setProfesor($profesor);
        
         }
        $em->persist($solicitud);
        $em->persist($alumno);
        }
        $em->flush();
         $grados=  $this->getDoctrine()
                       ->getEntityManager()
                       ->getRepository("NetpublicCoreBundle:Grado")
                       ->findAll();
   
        return array(
          "alumno"=>$alumno,
          "grados"=>$grados      
        );
        
    
        
    }
         /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/{grupo}/solicitudcambiarmultiple", name="auditoria_solicitudcambiarmultiple")     
     * @Template()
     */
    public function solicitudcambiarmultipleAction($grupo){
                ini_set('memory_limit', '-1');    
        set_time_limit(0);
        if($em->getRepository("NetpublicCoreBundle:Auditoria")->hayPublicacionesAuditoriasActivas(1)){
       
        $alumnos_id=json_decode($this->get('request')->get('alumnos'));
        $em=  $this->getDoctrine()->getEntityManager();       
        for ($index = 0; $index < count($alumnos_id); $index++) {
            $alumno=$em->getRepository("NetpublicCoreBundle:Alumno")->find($alumnos_id[$index]);
            $alumno->setTieneNovedad(TRUE);         
            $solicitud=new \Netpublic\CoreBundle\Entity\ProfesorSolicitud();
            $solicitud->setAlumno($alumno);
            $solicitud->setAuditoria($em->getRepository("NetpublicCoreBundle:Auditoria")->getPublicacionAuditoriaActiva(1));
            $solicitud->setGrupo($em->getRepository("NetpublicCoreBundle:Grupo")->find($grupo));
            $solicitud->setTipo(1);
            $solicitud->setEsRealizada(0);
            $user = $this->get('security.context')->getToken()->getUser();
            if(($user->getEsAlumno()==FALSE)){
                $profesor=$user->getProfesor();
                $solicitud->setProfesor($profesor);
        
            }
            $em->persist($solicitud);
            $em->persist($alumno);
        
        }
        }
        $em->flush();
       
        return new \Symfony\Component\HttpFoundation\Response("ok");
        
        
    }
    
     /**
      * 
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/buscar", name="auditoria_buscar")     
     * @Template()
     */
    public function buscarAction(){
        $request = $this->getRequest();        
        $usuarios=array();
        $sede=$request->get("sede");    
        $grado=$request->get('grado');
        $grupo=$request->get('grupo');
        $item=$request->get('item');
        $q=$request->get('query');
        $condicion_ie=$request->get('condicion_ie');
            $repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:Alumno');        
            $query = $repository->createQueryBuilder('a');                     
                     
            if($q!='*'){
                 if(is_numeric($q)){   
                    $query =  $query->andWhere("a.cedula LIKE :filtro");            
                    $query =  $query->setParameter('filtro','%'.$q.'%');
                 }
                 else{
                     $query =  $query->andWhere("a.nombre LIKE :filtro");            
                     $query =  $query->setParameter('filtro','%'.$q.'%');
                 
                 }
            }
            if($sede!='*'){
                $query = $query->andWhere("a.sede=:sede_id")        
                         ->setParameter('sede_id',$sede);
            }
            $query = $query->andWhere("a.tipo=:tipo")        
                         ->setParameter('tipo',0);
            
            if($grado!='*'){
                $query = $query->andWhere("a.grado=:grado_id")        
                         ->setParameter('grado_id',$grado);
            }
            if($grupo!='*'){
                $query = $query->andWhere("a.grupo=:grupo_id")                     
                         ->setParameter('grupo_id',$grupo);    
            }
        //$query=$query->setMaxResults(60);
        //$query=$query->orderBy('ps.es_realizada', 'ASC');     
        $query = $query->getQuery();      
        $alumnos= $paginador->paginate($query)->getResult();
        $grados=  $this->getDoctrine()
                       ->getEntityManager()
                       ->getRepository("NetpublicCoreBundle:Grado")
                       ->findAll();
   
    $nro_usuarios=count($alumnos);
    
        return array(
            "alumnos"=>$alumnos,             
            'nro_usuarios'=>$nro_usuarios,
            'grados'=>$grados
        );
    }

     /**
      * 
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/buscarlistarsolicitudes", name="auditoria_buscarlistarsolicitudes")     
     * @Template()
     */
    public function buscarlistarsolicitudesAction(){
        $request = $this->getRequest();            
        $sede=$request->get("sede");    
        $grado=$request->get('grado');
        $grupo=$request->get('grupo');
        $item=$request->get('item');
        $q=$request->get('query');
        $condicion_ie=$request->get('condicion_ie');
        $repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:ProfesorSolicitud');        
            $query = $repository->createQueryBuilder('ps');                     
            $query=$query->join("ps.alumno","a");         
            if($q!='*'){
                 if(is_numeric($q)){   
                    $query =  $query->andWhere("a.cedula LIKE :filtro");            
                    $query =  $query->setParameter('filtro','%'.$q.'%');
                 }
                 else{
                     $query =  $query->andWhere("a.nombre LIKE :filtro");            
                     $query =  $query->setParameter('filtro','%'.$q.'%');
                 
                 }
            }
            if($sede!='*'){
                $query = $query->andWhere("a.sede=:sede_id")        
                         ->setParameter('sede_id',$sede);
            }
            $query = $query->andWhere("a.tipo=:tipo")        
                         ->setParameter('tipo',0);
            
            if($grado!='*'){
                $query = $query->andWhere("a.grado=:grado_id")        
                         ->setParameter('grado_id',$grado);
            }
            if($grupo!='*'){
                $query = $query->andWhere("a.grupo=:grupo_id")                     
                         ->setParameter('grupo_id',$grupo);    
            }
        //$query=$query->setMaxResults(60);
        $query=$query->orderBy('ps.es_realizada', 'ASC');     
        $query = $query->getQuery();      
        $solicitudesProfesores= $paginador->paginate($query)->getResult();
        $grados=  $this->getDoctrine()
                       ->getEntityManager()
                       ->getRepository("NetpublicCoreBundle:Grado")
                       ->findAll();
   
    $nro_usuarios=count($solicitudesProfesores);
    
        return array(
            "solicitudesProfesores"=>$solicitudesProfesores,             
            'nro_usuarios'=>$nro_usuarios,
            'grados'=>$grados
        );
    }

    /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/procesarsolicitudesmultiple", name="auditoria_procesarsolicitudesmultiple")     
     * @Template()
     */
    public function procesarsolicitudesmultipleAction(){
                ini_set('memory_limit', '-1');    
        set_time_limit(0);

        
        $solicitudes_id=json_decode($this->get('request')->get('solicitudes'));
        $em=  $this->getDoctrine()->getEntityManager(); 
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        $periodos_academicos=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodosEscolar($ano_escolar_activo);
        $solicitudes=array();
        for ($index = 0; $index < count($solicitudes_id); $index++) {
            $solicitud=$em->getRepository("NetpublicCoreBundle:ProfesorSolicitud")->find($solicitudes_id[$index]);
            $solicitudes[$index]=$solicitud;
            $alumno=$solicitud->getAlumno();
           $tipo=$solicitud->getTipo();
            if($tipo!=2){
                 $grupo_matricular=$solicitud->getGrupo();
                $asignaturas_areas=$grupo_matricular->getGrado()->getAsignaturas();             
       
            } 
            if($tipo==0){//Asignar Grupo
                   //Establecemos grupo
                    $matricula=$em->getRepository("NetpublicCoreBundle:Alumno")
                          ->findMatricula($alumno,$ano_escolar_activo);
                     if($matricula->getEsmatricula()==FALSE){
                        $em->getRepository("NetpublicCoreBundle:Alumno")
                            ->matricularAlumnoNuevo(
                                            $alumno,
                                            $grupo_matricular,
                                            $asignaturas_areas,
                                            $periodos_academicos,
                                            -1    
                                    );
                        $matricula->setEsMatricula(TRUE);
                        $alumno->setEsAdicion(1);
                        $em->persist($alumno);
                        $em->persist($matricula);
                        $solicitud->setEsRealizada(1);
                        $em->persist($solicitud);        
                    }
            }
            if($tipo==1){//Cambiar  Grupo
            //Cancelamos la Matricula del Estudiante
            $em->getRepository("NetpublicCoreBundle:Alumno")->cancelarMatricula(
                     $alumno,$ano_escolar_activo->getId());   
            $matricula=$em->getRepository("NetpublicCoreBundle:Alumno")
                          ->findMatricula($alumno,$ano_escolar_activo);
                if($matricula->getEsmatricula()==FALSE){
                    $em->getRepository("NetpublicCoreBundle:Alumno")
                      ->matricularAlumnoNuevo(
                                            $alumno,
                                            $grupo_matricular,
                                            $asignaturas_areas,
                                            $periodos_academicos,
                                            -1    
                                    );
                    $matricula->setEsMatricula(TRUE);
                    $em->persist($matricula);
                    $solicitud->setEsRealizada(1);
                    $em->persist($solicitud);        
                }

         }
        if($tipo==2){//Cambiar  Grupo
            //Cancelamos la Matricula del Estudiante
             $em->getRepository("NetpublicCoreBundle:Alumno")->cancelarMatricula(
                     $alumno,$ano_escolar_activo->getId());   
                    $solicitud->setEsRealizada(1);
                    $em->persist($solicitud);        
           
        }

        }
        $em->flush();       
        return array(
            "solicitudes"=>$solicitudes
        );
    }
    
    
    /**
     * Lists all Auditoria entities.
     *
     * @Route("/reportar", name="auditoria_reportar")
     * @Template()
     */
    public function reportarAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $sedes=$em->getRepository("NetpublicCoreBundle:Colegio")->findAll();
        $grados=$em->getRepository("NetpublicCoreBundle:Grado")->findAll();
        $auditoria_activa=null;
       if($em->getRepository("NetpublicCoreBundle:Auditoria")->hayPublicacionesAuditoriasActivas(1)){
           $auditoria_activa=$em
                   ->getRepository("NetpublicCoreBundle:Auditoria")
                   ->getPublicacionAuditoriaActiva(1);
       } 
        return array(
            "sedes"=>$sedes,
            "grados"=>$grados,
            "auditoria_activa"=>$auditoria_activa    
        );
    }
    /**
     * Lists all Auditoria entities.
     *
     * @Route("/", name="auditoria")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NetpublicCoreBundle:Auditoria')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Auditoria entity.
     *
     * @Route("/{id}/show", name="auditoria_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Auditoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Auditoria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Auditoria entity.
     *
     * @Route("/new", name="auditoria_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Auditoria();
        $form   = $this->createForm(new AuditoriaType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Auditoria entity.
     *
     * @Route("/create", name="auditoria_create")
     * @Method("POST")
     * @Template("NetpublicCoreBundle:Auditoria:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Auditoria();
        $form = $this->createForm(new AuditoriaType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('auditoria_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Auditoria entity.
     *
     * @Route("/{id}/edit", name="auditoria_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Auditoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Auditoria entity.');
        }

        $editForm = $this->createForm(new AuditoriaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Auditoria entity.
     *
     * @Route("/{id}/update", name="auditoria_update")
     * @Method("POST")
     * @Template("NetpublicCoreBundle:Auditoria:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Auditoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Auditoria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new AuditoriaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('auditoria_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Auditoria entity.
     *
     * @Route("/{id}/delete", name="auditoria_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NetpublicCoreBundle:Auditoria')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Auditoria entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('auditoria'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
