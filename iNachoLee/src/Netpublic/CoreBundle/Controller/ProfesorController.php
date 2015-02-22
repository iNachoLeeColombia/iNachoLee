<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\Profesor;
use Netpublic\CoreBundle\Form\ProfesorType;
use Netpublic\CoreBundle\Entity\Usuario;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Gd\Imagine;
use Doctrine\ORM\EntityRepository;
use Netpublic\CoreBundle\Util\Util;

/**
 * Profesor controller.
 *
 * @Route("/profesor")
 */
class ProfesorController extends Controller
{
         /**
     * Finds and displays a Alumno entity.
     * 
     * @Route("/{alumno_id}/{asignatura_id}/previsualizarboletin", name="alumno_previsualizarboletin")
     * @Template()
     * 
     */
    public function previsualizarboletinAction($alumno_id,$asignatura_id)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');    
         
       $em=  $this->getDoctrine()->getEntityManager();
       $alumno=  $this->getDoctrine()
                       ->getRepository("NetpublicCoreBundle:Alumno")
                       ->find($alumno_id);
       $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
       $anos_escolares=array();
       
       
        
        $a_m=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findOneBy(array(
            'ano'=>$ano_escolar_activo->getId(),
            'alumno'=>$alumno_id
        ));
        $grupo=$a_m->getGrupo();
        if($grupo){                
                $grupo_id=$grupo->getId();
                $grado=$grupo->getGrado();
                $areas=  $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Asignatura")
                               ->findBy(array(
                                   'grado'=>$grado->getId(),
                                   'es_area'=>1
                               ));

                $periodo_activo=  $this->getDoctrine()
                                  ->getRepository("NetpublicCoreBundle:Dimension")
                                  ->findOneBy(array(
                                      "es_ano_escolar"=>1,
                                      "tipo"=>1
                                  ));
                $colegio=  $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Colegio")
                               ->findOneBy(array(
                                   'es_principal'=>1
                               ));

                $padre=  $em
                              ->getRepository("NetpublicCoreBundle:Dimension")
                              ->findAnoEscolarActivo();

                $periodo_escolar_activo=  $this->getDoctrine()
                                               ->getRepository("NetpublicCoreBundle:Dimension")
                                               ->findOneBy(array(
                                                   'es_ano_escolar'=>1,
                                                   'tipo'=>1,

                                               ));
                $periodos_escolares=$em
                        ->createQuery("SELECT a FROM NetpublicCoreBundle:Dimension a WHERE a.nivel<=:nivel and a.tipo=1 and a.padre=:padre ORDER BY a.nivel ASC")                
                        ->setParameters(array(
                            'padre'=>$padre->getId(),
                            'nivel'=>$periodo_escolar_activo->getNivel()
                        ))->getResult(); 

                $datos=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")
                                    ->getDatosAlumnoImpresion(
                                            $alumno,
                                            $areas,
                                            $periodos_escolares,
                                            $colegio,
                                            $periodo_activo,
                                            $grupo_id
                                            );
                $observaciones=  $this->getDoctrine()
                                  ->getRepository("NetpublicCoreBundle:Observacion")
                                  ->findBy(array(
                                      'alumno'=>$alumno_id,
                                      'periodo'=>$periodo_activo->getId()
                                  ))
                        ;

                return  array( 
                            'datos'=>$datos,
                            'periodos_escolares'=>$periodos_escolares,
                            'alumno'=>$alumno,
                            'ano_escolar_activo'=>$padre,
                            'periodo_escolar_activo'=>$periodo_escolar_activo,
                            'observaciones'=>$observaciones,
                            'anos_escolares'=>$anos_escolares,
                            'asignatura_id'=>$asignatura_id

                
                );
        }
        else{
            $rendered="<div style='page-break-after:always;'><span style='color:red;'>Lo siento el alumno $alumno no esta en ningun grupo en el año $ano_escolar_activo, por favor verifique en el  GESTOR DE MATRICULAS</span></div>";
        }
               return new Response($rendered);
         
    }        

     /**
     * Lists all Profesor entities.
     *
     * @Route("/planillasmesa", name="profesor_planillasmesa")
     * @Template()
     */
    public function planillasmesaAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $session=$request->getSession();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                               ->findAnoEscolarActivo();
        
        $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                                ->findPeriodoEscolarActivo();
        
        $profesor_sesion=$user->getProfesor();
        $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
        $periodo_activo_s=$session->get("perido_id",$periodo_activo->getId());
        
        $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_activo_s);
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($ano_escolar_id_s);
        $periodos_academicos=$em->getRepository("NetpublicCoreBundle:Dimension")
                                ->findPeriodosEscolar($ano_escolar_activo);
                        
        $page=$request->query->get('page',1);
        $query="SELECT ca FROM NetpublicCoreBundle:CargaAcademica ca";
        $query.=" JOIN ca.profesor p";
        $query.=" JOIN ca.asignatura asg";
        $query.=" WHERE ( ";
        $query.=" ca.profesor=:profesor_id";
        $query.=" AND ca.ano_escolar=:ano_escolar_id";
        //-$query.=" AND ca.es_carga_academica= true";            
        $query.=" )"; 
        $query.="ORDER BY ca.id ASC";
        $dql=$em->createQuery($query)                                  
                                 ->setParameters(array(
                                        "ano_escolar_id"=>$ano_escolar_id_s,
                                        "profesor_id"=>$profesor_sesion->getId()
                                         )); 
        $paginator  = $this->get('knp_paginator');
        $ca_activa = $paginator->paginate($dql,$page,1);                      
        
        if(count($ca_activa)>0)
        if(!$request->query->has("page")){
            $ca_id=$session->get('carga_academica_id',$ca_activa[0]->getId());
            $ca_activa=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
                'id'=>$ca_id
            ));
        }
        $carga_profesor=$em->getRepository("NetpublicCoreBundle:CargaAcademica")
                           ->getAsignaturaGrupo($profesor_sesion->getId(),$ano_escolar_id_s);
        $colegio=$em->getRepository("NetpublicCoreBundle:Colegio")
                    ->findSedePrincipal();
        $valoracion=$colegio->getTipoValoracion();
        if($valoracion==1){            
            $nota_maxima=10;
            $nota_minima=1;
        }
        if($valoracion==0){            
            $nota_maxima=5;
            $nota_minima=1;
        }
        
        if($valoracion==2){            
            $nota_maxima=5;
            $nota_minima=0;
        }
        if($valoracion==3){            
            $nota_maxima=10;
            $nota_minima=0;
        }
        $data=array();
        
        $numero_carga=  count($carga_profesor);
        $nota_perder=$colegio->getNotaMinima();
        
        $valor_minimo_sobresaliente=$colegio->getValorMinimoSobresaliente();
        $valor_maximo_sobresaliente=$colegio->getValorMaximoSobresaliente();    
        
        $valor_minimo_deficiente=$colegio->getValorMinimoDeficiente();
        $valor_maximo_deficiente=$colegio->getValorMaximoDeficiente();
        
        $data_grafico=array();
        $alumnos_pierden=array();
        $data_grafico=array(
                "pierden"=>0,
                "ganan"=>0
            );
        
        $alumnos_ganan=array();
        $porcentaje_ca_activa_Periodo=array();
        foreach ($ca_activa as $ca) {
            
            $pierden=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findNroPerdidos($ca,$periodo_activo,$nota_perder);
            $ganan=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findNroGanados($ca,$periodo_activo,$nota_perder);
            $alumnos_pierden=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findPerdidos($ca,$periodo_activo,$valor_minimo_deficiente,$valor_maximo_deficiente);
            $alumnos_ganan=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findGanan($ca,$periodo_activo,$valor_minimo_sobresaliente,$valor_maximo_sobresaliente);
            $data_grafico=array(
                "pierden"=>$pierden,
                "ganan"=>$ganan
            );
            $grupo_id=$ca->getGrupo()->getId();
            $asignatura_id=$ca->getAsignatura()->getId();
            
            foreach ($periodos_academicos as $pe) {                
                $nroAsgIngresados=$em->getRepository("NetpublicCoreBundle:Profesor")
                                 ->getNroNotasIngresadasAsignatura($asignatura_id,$grupo_id,$pe->getId());
                $nroAsgTotal=$em->getRepository("NetpublicCoreBundle:Profesor")
                            ->getNroNotasTotalAsignatura($asignatura_id,$grupo_id,$pe->getId());
                $porcentaje=0;
                if($nroAsgTotal>0){
                    $porcentaje=  number_format(($nroAsgIngresados/$nroAsgTotal)*100,0);
                }
                $porcentaje_ca_activa_Periodo[]=array(
                    'porcetaje'=>$porcentaje
                        );
            
            }
        }
        foreach ($carga_profesor as $carga) {
            $grupo_id=$carga->getGrupo()->getId();
            $asignatura_id=$carga->getAsignatura()->getId();
            $nro_alumnos=$em->getRepository("NetpublicCoreBundle:Alumno")->getNroAlumnosGrupo($grupo_id);
            $porcentajePeriodo=array();
            foreach ($periodos_academicos as $periodo) {
                
                $nroAsgIngresados=$em->getRepository("NetpublicCoreBundle:Profesor")
                                 ->getNroNotasIngresadasAsignatura($asignatura_id,$grupo_id,$periodo->getId());
                $nroAsgTotal=$em->getRepository("NetpublicCoreBundle:Profesor")
                            ->getNroNotasTotalAsignatura($asignatura_id,$grupo_id,$periodo->getId());
            
                $porcentaje=0;
                if($nroAsgTotal>0){
                    $porcentaje=  number_format(($nroAsgIngresados/$nroAsgTotal)*100,0);
                }
                $porcentajePeriodo[]=array(
                    'porcetaje'=>$porcentaje
                        );
            }
            $alumno=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findOneBy(array(
                'grupo'=>$carga->getGrupo()->getId(),
                'ano'=>$ano_escolar_id_s
            ));
            if($alumno)
                $mi_alumno_id=$alumno->getId();
            else
                $mi_alumno_id=-1;
            $data[]=array(
                'nro_alumnos'=>$nro_alumnos,
                'avanceTodosPeriodos'=>$porcentajePeriodo,
                'alumno_id'=>$mi_alumno_id    
                );
        }
        return array(
            "ano_escolar_activo"=>$ano_escolar_activo,
            'periodos_academicos'=>$periodos_academicos,
            'profesor'=>$profesor_sesion,
            'carga_profesor'=>$carga_profesor,
            'colegio'=>$colegio,
            'nota_minima'=>$nota_minima,
            'nota_maxima'=>$nota_maxima,
            'periodo_activo'=>$periodo_activo,
            'data'=>$data,
            "carga_activa"=>$ca_activa,
            "nro_cargas"=>$numero_carga,
            "data_grafico"=>$data_grafico,
            "alumnos_ganan"=>$alumnos_ganan,
            "alumnos_pierden"=>$alumnos_pierden,
            "porcentaje_ca_activa_Periodo"=>$porcentaje_ca_activa_Periodo
        ); 
    }
    /**
     * Lists all Profesor entities.
     *
     * @Route("/", name="profesor")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $es_ajax=false;
        $delete_form=array();
        $entities = $em->getRepository('NetpublicCoreBundle:Profesor')->findAll();
        foreach ($entities as $e) {
            $delete_form[] = $this->createDeleteForm($e->getId())->createView();
        }
        if($request->isXmlHttpRequest()){
            $es_ajax=true;
        }
        return array(
            'entities' => $entities,
            'es_ajax' =>$es_ajax,
            'delete_form'=>$delete_form
            );
    }
     /**
     * Displays a form to edit an existing Alumno entity.
     *
     * @Route("/{cedula}/getprofesorcedula", name="profesor_getprofesorcedula")
     * @Template()
     */
    public function getalumnocedulaAction($cedula)
    {
        $em = $this->getDoctrine()->getEntityManager();

       $query = $em->createQuery('SELECT count(a) FROM NetpublicCoreBundle:Profesor a WHERE a.cedula=:cedula')
                            ->setParameters(array(
                            "cedula"=>$cedula                            
                            
                                )
                            );
            $count = $query->getSingleScalarResult();
       return new \Symfony\Component\HttpFoundation\Response($count);
    }    
        /**
     * Displays a form to edit an existing Alumno entity.
     *
     * @Route("/{id_periodo}/{id_profesor}/publicarnotas", name="profesor_publicarnotas")
     * 
     */
    public function publicarnotasAction($id_periodo,$id_profesor)
            
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $desempenos__periodo_profesor=$em->createQuery("SELECT u FROM NetpublicCoreBundle:Desempeno u WHERE u.profesor=:profesor_id AND  u.periodo=:periodo_id")
                ->setParameters(array(
                    'periodo_id'=>$id_periodo,                   
		    'profesor_id'=>$id_profesor
                ))->getResult();   
        $ids=array();
        $session=$this->get('request')->getSession();        
        $periodo_id=$session->get('perido_id');	
        foreach ($desempenos__periodo_profesor as $d_s) {
            $ids[]=$d_s->getId();
        }
        $tem=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumnodesempeno")
                ->ponderarNotasProfesor($periodo_id,
                        $id_profesor,
                        $ids) 
                ;
        return new \Symfony\Component\HttpFoundation\Response('oj');
        
    }
        /**
     * Displays a form to edit an existing Alumno entity.
     *
     * @Route("/informeavancerectroceso20", name="profesor_informeavancerectroceso20")
     * @Template()
     */
    public function informeavancerectroceso20Action()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);  
        $em = $this->getDoctrine()->getEntityManager();                
        $request=  $this->getRequest();
        $repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:Profesor');        
        $query = $repository->createQueryBuilder('p');                     
        $query = $query->andWhere("p.tipo=2");
        $query=$query->setMaxResults(60);
        $query=$query->orderBy('p.apellido', 'ASC');     
        $query = $query->getQuery();
        $profesores=$query->getResult();
        $ano_escolar_activo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                                                  ->findAnoEscolarActivo(); 
        $session=$request->getSession();
        $periodo_id=$session->get('perido_id');
        
        $profesor_bueno=array();
        $profesor_malo=array();
        foreach ($profesores as $profesor) {         
            $nroNotasProfesor=$em->getRepository("NetpublicCoreBundle:Profesor")
                                 ->getNroNotasTotal($profesor->getId(),$periodo_id);
            $nroNotasProfesorI=$em->getRepository("NetpublicCoreBundle:Profesor")
                                ->getNroNotasTotalIngresadas($profesor->getId(),$periodo_id);
            if($nroNotasProfesor==0)
                 $nroNotasProfesor=1;
            $porcentaje=  number_format(($nroNotasProfesorI/$nroNotasProfesor)*100,0);
            $nr_msol=49;
            if($porcentaje<=$nr_msol){
                $profesor_malo[]=array(
                            'profesor'=>$profesor,
                            'avance'=>$porcentaje
                        );
            }
            else{
                $profesor_bueno[]=array(
                    "profesor"=>$profesor,
                    "avance"=>$porcentaje
                );
            }
            

        }
        return array(
           'profesores_buenos'=>$profesor_bueno,
           'profesores_malos'=>$profesor_malo,
         );

    }

    
    
    
    /**
     * Displays a form to edit an existing Alumno entity.
     *
     * @Route("/listaflujosprofe", name="profesor_listaflujosprofe")
     * @Template()
     */
    public function listaflujosprofeAction()
            
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);  
        $em = $this->getDoctrine()->getEntityManager();  
        $session=  $this->getRequest()->getSession();
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                               ->findAnoEscolarActivo();
        $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
        
        $request=  $this->getRequest();
        $sede=$request->get("sede");
        $maximo=$request->get("maximo");
        $minimo=$request->get("minimo");
        $q=$request->get('query');
        $repository = $this->getDoctrine()
                             ->getRepository('NetpublicCoreBundle:Profesor');        
        $query = $repository->createQueryBuilder('p');                     
        if($sede!='*'){
                $query = $query->andWhere("p.sede=:sede_id")        
                         ->setParameter('sede_id',$sede);
        }
        if($q!='*'){
            if(is_numeric($q)){   
                $query =  $query->andWhere("p.cedula LIKE :filtro");            
                $query =  $query->setParameter('filtro','%'.$q.'%');
                
             }
             else{
                $query =  $query->andWhere("p.nombre_completo LIKE :filtro");            
                $query =  $query->setParameter('filtro','%'.$q.'%');
             }
         }
        $query=$query->andWhere("p.tipo=2");
        $query=$query->setMaxResults(40);
        $query=$query->orderBy('p.apellido', 'ASC');     
        $query = $query->getQuery();      
        $entities= $query->getResult();
        $porcentaje_so=$request->get('porcentaje'); 
        $session=$request->getSession();
        $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                                ->findPeriodoEscolarActivo();
        
        $periodo_id=$session->get("perido_id",$periodo_activo->getId());
        
        $porcentajes=array();
        $modificaciones=array();
        $estado_publicaciones=array();
        $minuevoProfesor=array();
        foreach ($entities as $profesor) {
            $publicacion_periodo=  $this->getDoctrine()
                                  ->getRepository("NetpublicCoreBundle:PublicacionPeriodosProfesores")
                                  ->findOneBy(array(
                                      'profesor'=>$profesor->getId(),
                                      'periodo_academico'=>$periodo_id
                                  ));
            $fecha=$publicacion_periodo->getFechaUltimoPublicacion(); 
            //$nroNotasProfesor=$em->getRepository("NetpublicCoreBundle:Profesor")
            //                     ->getNroNotasTotal($profesor->getId(),$periodo_id);
            //$nroNotasProfesorI=$em->getRepository("NetpublicCoreBundle:Profesor")
            //                     ->getNroNotasTotalIngresadas($profesor->getId(),$periodo_id);
            $nroM_P=$em->getRepository("NetpublicCoreBundle:Profesor")
                                 ->getNroNotasModificadasProfesor(
                                    $profesor->getId(),
                                    $periodo_id,
                                    $fecha);   
                $nroNotasProfesor=1;
               $porcentaje= $em->getRepository("NetpublicCoreBundle:Profesor")
                               ->getPorcentajeProfesor($profesor->getId(),$periodo_id,$ano_escolar_id_s);
               if($porcentaje<=$maximo && $porcentaje>=$minimo){
                        $porcentajes[]= $porcentaje;
                        $modificaciones[]=$nroM_P;
                        $estado_publicaciones[]=$publicacion_periodo;
                        $minuevoProfesor[]=$profesor;
               }
        }
        return array(
           'entities'=>$minuevoProfesor,
           'porcentajes'=>$porcentajes,
           'modificaciones'=>$modificaciones,
           'publicacion_periodo'=>$estado_publicaciones,
           'id_periodo'=>$periodo_id
           
       );

    }
    /**
     * Displays a form to edit an existing Alumno entity.
     *
     * @Route("/listaflujos", name="profesor_listaflujos")
     * @Template()
     */
    public function listaflujosAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();
            $ano_escolar_activo=  $this
                      ->getDoctrine()
                      ->getRepository("NetpublicCoreBundle:Dimension")
                      ->findAnoEscolarActivo();
            $periodo_escolar_activo=$this
                      ->getDoctrine()
                      ->getRepository("NetpublicCoreBundle:Dimension")
                      ->findPeriodoEscolarActivo();
    
    $session=  $this->getRequest()->getSession();
    $periodo_id=$session->get('perido_id');       
    $ano_escolares=  $this
        ->getDoctrine()
                ->getRepository("NetpublicCoreBundle:Dimension")
                ->findBy(array(
                    'tipo'=>0));
    $periodos_escolares=  $this->
            getDoctrine()
            ->getRepository("NetpublicCoreBundle:Dimension")
            ->findPeriodosEscolar($ano_escolar_activo);
    $grados=$em->getRepository('NetpublicCoreBundle:Grado')->findAll();
    
    $sedes=$em->getRepository('NetpublicCoreBundle:Colegio')->findAll();
    $sede_principal=$em->getRepository("NetpublicCoreBundle:Colegio")->findSedePrincipal();
    $data1=$em->getRepository("NetpublicCoreBundle:Profesor")->getNroNotasSede($sede_principal->getId(),$periodo_id);
    $data2=$em->getRepository("NetpublicCoreBundle:Profesor")->getNroNotasIngresadasSede($sede_principal->getId(),$periodo_id);
    if($data1==0)
        $data1=1;
    $data_sede_principal=array(
        "nombre"=>"$sede_principal",
        "avance"=>number_format(($data2/$data1)*100,0)    
    );
    foreach ($sedes as $sede) {
        $data1=$em->getRepository("NetpublicCoreBundle:Profesor")->getNroNotasSede($sede->getId(),$periodo_id);
        $data2=$em->getRepository("NetpublicCoreBundle:Profesor")->getNroNotasIngresadasSede($sede->getId(),$periodo_id);
       if($data1==0){
           $data1=1;
       }
        $data_grafico_sedes[]=  array(
            'porcentaje'=>number_format(($data2/$data1)*100,0),
            'nombre'=>"$sede"
            );
        
    }
    $data_grafico=array(
        'sede_principal'=>$data_sede_principal,
        'sedes'=>$data_grafico_sedes
    );
   return array(
           'grados'=>$grados,        
           'ano_escolares'=>$ano_escolares,
           'ano_escolar_activo'        =>$ano_escolar_activo,
           'periodo_escolar_activo'=>$periodo_escolar_activo,
           'data_graficos'=> $data_grafico, 
           'sedes'=>$sedes,        
           'periodo_escolares'=>$periodos_escolares        
       );
    }    

     /**
     * 
     *
     * @Route("/{profesor}/seguimientonotas", name="profesor_seguimientonotas")
     * @Template()
     */
    public function seguimientonotasAction($profesor)  {
       $id_profesor=$profesor;
       
       $session=  $this->getRequest()->getSession(); 
       $periodo_id=$session->get('perido_id');
        
       $porcentajes=array();
       $modificados=array();
       $em=  $this->getDoctrine()->getEntityManager();
       $publicacion_periodo=  $this->getDoctrine()
                                  ->getRepository("NetpublicCoreBundle:PublicacionPeriodosProfesores")
                                  ->findOneBy(array(
                                      'profesor'=>$id_profesor,
                                      'periodo_academico'=>$periodo_id
                                  ));
     $fecha=$publicacion_periodo->getFechaUltimoPublicacion(); 
     $nroM_P=$em->getRepository("NetpublicCoreBundle:Profesor")
             ->getNroNotasModificadasProfesor(
                     $profesor,
                     $periodo_id,
                     $fecha);   
   
  
       $carga_academica=  $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:CargaAcademica")
                               ->findBy(array(
                                   "profesor"=>$id_profesor
                               ));
      foreach ($carga_academica as $ca) {
            $asignatura_id=$ca->getAsignatura()->getId();
            $grupo_id=$ca->getGrupo()->getId();
            $nroAsgIngresados=$em->getRepository("NetpublicCoreBundle:Profesor")
                                 ->getNroNotasIngresadasAsignatura($asignatura_id,$grupo_id,$periodo_id);
            $nroAsgTotal=$em->getRepository("NetpublicCoreBundle:Profesor")
                            ->getNroNotasTotalAsignatura($asignatura_id,$grupo_id,$periodo_id);
            $nroAsgModificados=$em->getRepository("NetpublicCoreBundle:Profesor")
                                 ->getNroNotasModificadasAsignatura($asignatura_id,
                                         $grupo_id,$periodo_id,$fecha);
            
            if($nroAsgTotal==0)
                $nroAsgTotal=1;
            $porcentajes[]=  number_format(($nroAsgIngresados/$nroAsgTotal)*100,0);
            $modificados[]=$nroAsgModificados;
       

                           
      }
       
      //print_r($porcentajes);
       return array(
           'modificaciones'=>$nroM_P,
           'carga_academica'=>$carga_academica,
           "porcentajes"=>$porcentajes,       
           'id_profesor'=>$id_profesor,
           'modificados'=>$modificados,
           'publicacion_periodo'=>$publicacion_periodo

       );
    }    
    
   /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/newexcell", name="profesor_newexcell")
     * @Template()
     */
    public function newexcellAction()
    {
        $sedes=  $this->getDoctrine()
                    ->getRepository("NetpublicCoreBundle:Colegio")
                    ->findAll();
       return array(
           "sedes"=>$sedes

       );
    }
       /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/createexcell", name="profesor_createexcell")
     * @Template()
     */
    public function createexcellAction()
    {
   // obtenemos los datos del archivo
    ini_set('memory_limit', '-1');
    set_time_limit(0);
    $em=  $this->getDoctrine()->getEntityManager();
    $ano_escolar_activo=  $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Dimension")
                              ->findAnoEscolarActivo();
              
               $perios_escolares=$this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Dimension")
                             ->findPeriodosEscolar($ano_escolar_activo);
    $request=  $this->getRequest();
    $posicion=array("A","B","C","D","E","F","G","H","I","J","L","M");
    $usuarios=array();        
    $sede_id=$request->get('sede');
    $sede=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")
                                                    ->find($sede_id);
    $es_nombre_completo=$request->get('es_nombre_completo');    
    $columna_nombre=$request->get('columna_nombre');
    $fila_nombre=$request->get('fila_nombre');
    $columna_ti=$request->get("columna_ti");  
    $columna_nombre1=$request->get('columna_nombre1');
    $columna_nombre2=$request->get('columna_nombre2');
    $columna_apellido1=$request->get('columna_apellido1');
    $columna_apellido2=$request->get('columna_apellido1');
    
        // guardamos el archivo a la carpeta files       
    $prefijo = substr(md5(uniqid(rand())),0,6);                         
    $destino=__DIR__.'/../../../../web/'.'uploads/temporal/mimamastrong_'.$prefijo.'.xls';
    copy($_FILES['archivo_excell']['tmp_name'],$destino);   
     $inputFileName = $destino;
     $objReader = $this->get('phpexcel')->createPHPExcelObject($inputFileName);
    $flag=true;
     $fila=$fila_nombre;  
     $hoja=0;
     if($es_nombre_completo==1){                    
                    while($flag){  
                            $nombre_completo= $objReader->getSheet($hoja)->getCell($columna_nombre.$fila);  
                            
                            $nombre_completo=  trim($nombre_completo);
                            $nombre_completo=  str_replace("  "," ", $nombre_completo);
                            $nombre_completo=  str_replace("   "," ", $nombre_completo);
                            $cedula= $objReader->getSheet($hoja)->getCell($columna_ti.$fila)->getCalculatedValue(); 
                            if($cedula=="")
                                $cedula='00';
                            if($nombre_completo==""){
                                $flag=false;
                            }
                            else{
                               
                                $array_nombre=  explode(" ",$nombre_completo);
                                $profesor=new \Netpublic\CoreBundle\Entity\Profesor();
                                $profesor->setCedula($cedula);
                                $profesor->setTipo(2);                                
                                $profesor->setTipoDocumento(2);
                                if(count($array_nombre)==5){                            
                                    $primer_nombre=$array_nombre[2];
                                    $segundo_nombre=$array_nombre[3].$array_nombre[4];
                                    if($segundo_nombre=="NULL")
                                        $segundo_nombre=" ";
                                    $primer_apellido=$array_nombre[0];
                                    $sengundo_apellido=$array_nombre[1];                    
                                    $profesor->setApellido($primer_apellido);
                                    $profesor->setApellido1($sengundo_apellido);
                                    $profesor->setNombre($primer_nombre);
                                    $profesor->setNombre1($segundo_nombre);              
                                }
                                
                                elseif(count($array_nombre)==4){                            
                                    $primer_nombre=$array_nombre[2];
                                    $segundo_nombre=$array_nombre[3];
                                    if($segundo_nombre=="NULL")
                                        $segundo_nombre=" ";
                                    
                                    $primer_apellido=$array_nombre[0];
                                    $sengundo_apellido=$array_nombre[1];                    
                                    $profesor->setApellido($primer_apellido);
                                    $profesor->setApellido1($sengundo_apellido);
                                    $profesor->setNombre($primer_nombre);
                                    $profesor->setNombre1($segundo_nombre);              
                                }
                                elseif(count($array_nombre)==3){
                                    $primer_nombre=$array_nombre[2];                            
                                    $primer_apellido=$array_nombre[0];
                                    $sengundo_apellido=$array_nombre[1];
                                    $profesor->setApellido($primer_apellido);
                                    $profesor->setApellido1($sengundo_apellido);
                                    $profesor->setNombre($primer_nombre);   
                   

                                }
                                elseif(count($array_nombre)==2){
                                    $primer_nombre=$array_nombre[1];                            
                                    $primer_apellido=$array_nombre[0];                                    
                                    $profesor->setApellido($primer_apellido);                                    
                                    $profesor->setNombre($primer_nombre);   
                   

                                }
                                elseif(count($array_nombre)==1){
                                    $primer_nombre=$array_nombre[0];                                                                                                                                        
                                    $profesor->setNombre($primer_nombre);   
                   

                                }
                                else{
                                    $profesor->setNombre("No existe");
                                    $profesor->setCedula("-111111");
                                }
                    $mi_rol=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Rol")->find(2);
                    $query = $em->createQuery('SELECT count(a) FROM NetpublicCoreBundle:Usuario a WHERE a.username LIKE :nombre')
                            ->setParameters(array(
                            "nombre"=>'%'.Util::getSlug($profesor->getNombre(), "").'%'                           
                            
                                )
                            );
            $count = $query->getSingleScalarResult();
            	$nombre=$profesor->getNombre();
			if($count>0){
				$nombre=$profesor->getNombre().$count;
			}
			
            $usuario=new Usuario(); 
            //$primer_nombre=explode(" ",);
            $usuario->setUsername($nombre);
            $usuario->setSalt(md5(time()));
            $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
            $password = $encoder->encodePassword($profesor->getCedula(), $usuario->getSalt());
            $usuario->setPassword($password);
            $usuario->setEsAlumno(FALSE);
            $usuario->setProfesor($profesor);
            $usuario->addRol($mi_rol);       
            $profesor->setUsuario($usuario);  
            //Para realizar seguiemientos
                     foreach ($perios_escolares as $p_e) {    

                    $this->getDoctrine()->getRepository("NetpublicCoreBundle:Profesor")
                        ->generarFechasEntregasProfesor($profesor,$p_e);

                     } 

            $em->persist($profesor);
            $em->persist($usuario);
            $usuarios[]=$usuario;
              }
                    $fila++;
                    $em->flush();
     
                }
     }
     if($es_nombre_completo==2){              
        while($flag){
                      $nombre= $objReader->getSheet($hoja)->getCell($columna_nombre1.$fila);   
                      $nombre1= $objReader->getSheet($hoja)->getCell($columna_nombre2.$fila);   
                      $apellido= $objReader->getSheet($hoja)->getCell($columna_apellido1.$fila);   
                      $apellido1= $objReader->getSheet($hoja)->getCell($columna_apellido2.$fila);                         
                      $cedula= $objReader->getSheet($hoja)->getCell($columna_ti.$fila);   
                      
                      if($nombre==""){
                          $flag=false;
                      }
                      else{
                          $profesor=new \Netpublic\CoreBundle\Entity\Profesor();
                          $profesor->setApellido($apellido);
                          $profesor->setApellido1($apellido1);
                          $profesor->setNombre($nombre);
                          if($nombre1=="NULL")
                              $nombre1=" ";
                          $profesor->setNombre1($nombre1);
                          $profesor->setCedula($cedula);
                          $profesor->setTipoDocumento(2);                     
                          $profesor->setSede($sede);                        
                          $profesor->setTipo(2);     
                                               $mi_rol=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Rol")->find(2);
                      $query = $em->createQuery('SELECT count(a) FROM NetpublicCoreBundle:Usuario a WHERE a.username LIKE :nombre')
                            ->setParameters(array(
                            "nombre"=>$profesor->getNombre().'%'                           
                            
                                )
                            );
            $count = $query->getSingleScalarResult();
			$nombre=$profesor->getNombre();
			if($count>0){
				$nombre=$profesor->getNombre().$count;
			}
			

                          $usuario=new Usuario(); 
                        //$primer_nombre=explode(" ",);
                          $usuario->setUsername($nombre);
                          $usuario->setSalt(md5(time()));
                          $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
                          $password = $encoder->encodePassword($profesor->getCedula(), $usuario->getSalt());
                          $usuario->setPassword($password);
                          $usuario->setEsAlumno(FALSE);
                          $usuario->setProfesor($profesor);
                          $usuario->addRol($mi_rol);       
                          $profesor->setUsuario($usuario);  
                          $em->persist($profesor);
                          //seguimeitnos
                     foreach ($perios_escolares as $p_e) {    
                          $this->getDoctrine()->getRepository("NetpublicCoreBundle:Profesor")
                                ->generarFechasEntregasProfesor($profesor,$p_e);
                     } 
                     $em->persist($usuario);                                                                               
                     $em->flush();
                     $usuarios[]=$usuario;                                                                                    
                      }
                     $fila++;
                 }
                 
              
     }  
     return array(
        'usuarios'=>$usuarios
     );   
    }

    
     /**
     * Lists all Profesor entities.
     *
     * @Route("/newnotasoffline", name="profesor_newnotasoffline")
     * @Template()
     */
    public function newnotasofflineAction()
    {
         $session=$this->get('request')->getSession();
        $em=  $this->getDoctrine()->getEntityManager();
        //echo $session->get('asignatura_id');
	$user = $this->get('security.context')->getToken()->getUser();
        $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                            ->findPeriodoEscolarActivo();
        
        $periodo_id=$session->get('perido_id',$periodo_activo->getId());
        $periodo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);      
        if($periodo->getTipo()==4){
            $padre_p=$periodo->getPadre();
        }
        else{
            $padre_p=$periodo;
        }
        
        if(($user->getEsAlumno()==FALSE)){
            $profesor_id=$user->getProfesor()->getId();            
         }	
		
       
         $tiene_tiempo_aun=$em->getRepository("NetpublicCoreBundle:Profesorperiodoentrega")
                             ->tieneTiempoProfesor($padre_p->getId(),$profesor_id);
       
              
        $delete_form=array();
      
        return array(                      
            'delete_form'=>$delete_form,
            'es_ready_only'=>$tiene_tiempo_aun
            );
    }
         /**
     * Lists all Profesor entities.
     *
     * @Route("/createnotasoffline", name="profesor_createnotasoffline")
     * @Template()
     */
    public function createnotasofflineAction()
    {
    // obtenemos los datos del archivo    
     
    set_time_limit(0);
    ini_set('memory_limit', '-1'); 
    
    
    $em=  $this->getDoctrine()->getEntityManager();
    $colegio=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")
                    ->findOneBy(array(
                        "es_principal"=>1
                    ));
    $session=  $this->getRequest()->getSession();
    $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                            ->findPeriodoEscolarActivo();
    $periodo_id=$session->get('perido_id',$periodo_activo->getId());
        
    $valoracion=$colegio->getTipoValoracion();
    if($valoracion==1){            
            $nota_maxima=10;
            $nota_minima=1;
        }
        if($valoracion==0){            
            $nota_maxima=5;
            $nota_minima=1;
        }
        
        if($valoracion==2){            
            $nota_maxima=5;
            $nota_minima=0;
        }
        if($valoracion==3){            
            $nota_maxima=10;
            $nota_minima=0;
        }
    $archivo = $_FILES["notas_offline"]['name'];
    if ($archivo != "") {
        // guardamos el archivo a la carpeta files       
        $prefijo = substr(md5(uniqid(rand())),0,6);
        
        //$destino='/home/yuri/Proyectos/iNachoLee/dev/web/uploads/documents/strong'.$prefijo.'.xls';
                        
        $destino=__DIR__.'/../../../../web/'.'uploads/temporal/strongweb'.$prefijo.'.xls';
        
        if (copy($_FILES['notas_offline']['tmp_name'],$destino)) {
                
                $inputFileName = $destino;
                $objReader = $this->get('phpexcel')->createPHPExcelObject($inputFileName);
                $objReader->setActiveSheetIndex(0);
                   
                $carga_id_hoja_cero= $objReader->getActiveSheet()->getCell('A2')->getCalculatedValue();
                
                $ca=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($carga_id_hoja_cero);
               
                $length= $objReader->getActiveSheet()->getCell('B2')->getCalculatedValue();
                $periodo_id= $objReader->getActiveSheet()->getCell('C2')->getCalculatedValue()+0;
                $periodo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);      
                $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
                $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
        
                $profesor_id=$ca->getProfesor()->getId();
                $carga_academica=$this
                      ->getDoctrine()
                      ->getRepository("NetpublicCoreBundle:CargaAcademica")
                      ->getAsignaturaGrupo($profesor_id,$ano_escolar_id_s);
                $hoja=0;
                $fila_inicio=11;                
                $off_set2=$length;
                $nro_errores=0;
                foreach ($carga_academica as $mi_carga) {
                     $objReader->setActiveSheetIndex($hoja);
                   
                    $carga_id= $objReader->getActiveSheet()->getCell('A2')->getCalculatedValue();
                    $ca=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($carga_id);
                    
                    $desempenos=$em->getRepository("NetpublicCoreBundle:Desempeno")
                       ->findDesempenosAsignaturaProfe($mi_carga->getAsignatura()->getId(),$periodo_id,$ca->getGrupo()->getId(),$profesor_id);
       
                    
                    $length= $objReader->getActiveSheet()->getCell('B2')->getCalculatedValue();
                    if($ca->getAnoEscolar())
                        $a_ms=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findBy(array(
                                'ano'=>$ca->getAnoEscolar()->getId(),
                                'grupo'=>$ca->getGrupo()->getId()
                    ));
                    else
                    $a_ms=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findBy(array(
                        'ano'=>$ano_escolar_id_s,
                        'grupo'=>$ca->getGrupo()->getId()
                    ));
            
                    $alumnos=array();
                    foreach ($a_ms as $a) {
                        $alumnos[]=$a->getAlumno();
                    }
                    if(!count($alumnos))
                        $alumnos=$em->getRepository("NetpublicCoreBundle:Alumno")->findBy(array(
                             "grupo"=>$ca->getGrupo()->getId()
                               ), array("apellido"=>'ASC'));
                       $fila_inicio=11;
                       
                       foreach ($alumnos as $alumno) {                           
                           $off_set1=2*$length-1;
                           $off_set2=$length;
                           for ($index = 0; $index < ($length-1); $index++) {                               
                                $valor=$objReader->getActiveSheet()
                                 ->getCellByColumnAndRow($off_set2,$fila_inicio)
                                 ->getCalculatedValue()+0; 
                                $id=$objReader->getActiveSheet()
                                 ->getCellByColumnAndRow($off_set1,$fila_inicio)
                                 ->getCalculatedValue()+0; 
                                 $off_set1--;
                                 $off_set2--;
                                // echo $id."<br/>";
             $query="SELECT a_d,d FROM NetpublicCoreBundle:AlumnoDimension a_d JOIN a_d.dimension d";
              $query.=" WHERE (";
              $query.=" a_d=:id)";                            
              $nota=$em->createQuery($query)                
                          ->setParameters(array(
                             "id"=>$id                                                        
                       ))->getOneOrNullResult(); 
                     //Vamos a establecer restrinciones
                                if($nota){ 
                                 if(($valor>$nota_maxima && $nota->getDimension()->getTipo()!=3) || ($valor<$nota_minima && $nota->getDimension()->getTipo()!=3)){
                                         $nota->setEsError(TRUE);
                                         $nro_errores++;
                                 }
                                else {
                                     $nota->setEsError(FALSE);
                                }
                                $valor=  number_format($valor,2);
           if($periodo_id==$nota->getDimension()->getPadre()->getId()){                     
            if($nota->getNotaBuffered()==-1){
                $nota->setEsIngresadad(TRUE);
                $nota->setFechaUltimoIngreso(new \DateTime);
            }
            else{
            if($nota->getNotaBuffered()!=$valor){
                $nota->setEsModificada(TRUE);
                $nota->setFechaUltimoCambio(new \DateTime);
             }
            
            }
            $nota->setNotaBuffered($valor);
	    $nota->setNota($valor);
           }
                                $nota->setNota($valor);

                                echo "$valor";
                                $em->persist($nota);
                                 
                           }
                           }
                           //Publicamos Notas
                           $area_id=$ca->getAsignatura()->getArea()->getId();
                                $em->getRepository("NetpublicCoreBundle:Alumno")
                                   ->publicarNotasAlumno($area_id,$alumno->getId(),$periodo_id);
                           //Publicamos Desempeños.
                           $em->getRepository("NetpublicCoreBundle:Alumno")
                           ->publicarDesempenos($alumno,$ca->getAsignatura()->getId(),$periodo,$desempenos);
             
                           
                       $fila_inicio++;    
       
                           }
                          $hoja++;
$em->flush();
                  }                    
                           
        
                
             
        //return new \Symfony\Component\HttpFoundation\Response("ok");
                return $this->redirect($this->generateUrl('profesor_showcalificarexcel',array(
                    "cargaacademica_id"=>$carga_id_hoja_cero,
                    "periodo_id"=>$periodo_id,
                    "nro_errores"=>$nro_errores
                    )));
        } else {
            $status = "Error al subir el archivo";
        }
    } else {
        $status = "Error al subir archivo";
    }      
    return array(
           "usuarios"=>1
       );
        
    }
    /**
     * Displays a form to edit an existing Alumno entity.
     * @Route("/{cargaacademica_id}/{periodo_id}/{nro_errores}/showcalificarexcel", name="profesor_showcalificarexcel") 
     * @Template()
     * 
     */    
    public function showcalificarexcelAction($cargaacademica_id,$periodo_id,$nro_errores){
    set_time_limit(0);
    ini_set('memory_limit', '-1');           
        $session=  $this->getRequest()->getSession();
        $em=  $this->getDoctrine()->getEntityManager();
        $carga_academica=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($cargaacademica_id);          
        $periodo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                               ->findAnoEscolarActivo();
        
        $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($ano_escolar_id_s);
        if($carga_academica->getAnoEscolar())
        $a_ms=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findBy(array(
            'ano'=>$carga_academica->getAnoEscolar()->getId(),
            'grupo'=>$carga_academica->getGrupo()->getId()
            ));
        else
        $a_ms=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findBy(array(
            'ano'=>$ano_escolar_id_s,
            'grupo'=>$carga_academica->getGrupo()->getId()
            ));
            
        $alumnos=array();
        foreach ($a_ms as $a) {
                $alumnos[]=$a->getAlumno();
        }
        if(!count($alumnos))
            $alumnos=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")->findBy(
                array('grupo'=>$carga_academica->getGrupo()->getId()),
                array("apellido"=>'ASC')
            );  
        
        $items_todos_alumnos=array();
        $componentes_=array();
        $entities=array();
        $nota_periodo=array();
        foreach ($alumnos as $alumno) {
            $items=array();
            $nota_periodo[]=$em->getRepository("NetpublicCoreBundle:Grupo")->getNotaPeriodo(
                $alumno->getId(),$periodo, $carga_academica->getAsignatura()->getId());
        
            $componentes=$em->getRepository("NetpublicCoreBundle:Grupo")
                           ->getNotasHijos($alumno->getId(),
                                   $carga_academica->getProfesor()->getId(),
                                   $periodo,
                                   $carga_academica->getAsignatura()->getId(),1);
                       for ($index = 0; $index < count($componentes); $index++) {                              
                             $items[]=$em->getRepository("NetpublicCoreBundle:Grupo")
                           ->getNotasHijos($alumno->getId(),
                                   $carga_academica->getProfesor()->getId(),
                                   $componentes[$index]->getDimension(),
                                   $carga_academica->getAsignatura()->getId());
                                                       
                       }  
                    $componentes_[]=$componentes;   
                      $items_todos_alumnos[]=$items;     
            
        }
        $carga_academica_profesor=$this->getDoctrine()
                      ->getRepository("NetpublicCoreBundle:CargaAcademica")
                      ->getAsignaturaGrupo($ano_escolar_id_s,$carga_academica->getProfesor()->getId());
        if(!count($carga_academica_profesor)){
            $carga_academica_profesor=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
                'profesor'=>$carga_academica->getProfesor()->getId()
            ));
        }
        return array(
            'items_todos_alumnos'=>$items_todos_alumnos,
            'alumnos'=>$alumnos,
            'nro_errores'=>$nro_errores,
            'carga_academica'=>$carga_academica_profesor,
            'periodo'=>$periodo,
            'carga_academica_actual'=>$carga_academica,
            'componentes_todos'=>$componentes_,
            'nota_periodo'=>$nota_periodo
        );
                
    }
     /**
     * Displays a form to edit an existing Alumno entity.
     * @Route("/{carga_academica}/{periodo}/getnroerrores", name="profesor_getnroerrores") 
     * @Template()
     * 
     */    
    public function getnroerroresAction($carga_academica,$periodo){
        set_time_limit(0);
    ini_set('memory_limit', '-1');           
    
        $em=  $this->getDoctrine()->getEntityManager();
        $periodo_=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo);
        $carga_academica_=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($carga_academica);
        $nro=  $em->getRepository("NetpublicCoreBundle:Grupo")
                    ->findNroErrores($carga_academica_,$periodo_);
        $alumno=$em->getRepository("NetpublicCoreBundle:Alumno")->findOneBy(array(
            'grupo'=>$carga_academica_->getGrupo()->getId()
        ));
        $nro_=0;
        $componentes=$em->getRepository("NetpublicCoreBundle:Grupo")
                    ->findNotaAlumnoAsignaturaProfesor(
                            $carga_academica_->getGrupo()->getId(),
                            $carga_academica_->getProfesor()->getId(),
                            $periodo_,
                            $carga_academica_->getAsignatura()->getId());
                    foreach ($componentes as $c) {
                        $nro_comp=  $em->getRepository("NetpublicCoreBundle:Grupo")
                        ->findNroErrores($carga_academica_,$c->getDimension());
                       
                        $nro_=$nro_+$nro_comp;        
                    }
            $nro=$nro+$nro_; 
            $error="";
            if($nro>0){
                $error="<span style='font-size:8px;color:white;background-color:red;font-weight:900;'>$nro Detalles</span>";
            }
            return new \Symfony\Component\HttpFoundation\Response($error);
    }
     /**
     * Displays a form to edit an existing Alumno entity.
     * @Route("/{tipo}/{carga_id}/getunaplanilla.{_format}",defaults={"_format"="xls"}, requirements={"_format"="html|xls|pdf"}, name="profesor_getunaplanilla") 
     * @Template()
     * 
     */    
    public function getunaplanillaAction($tipo,$carga_id){
        set_time_limit(0);
        ini_set('memory_limit', '-1');           
	$session=$this->get('request')->getSession();
        
        $user = $this->get('security.context')->getToken()->getUser();
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor();
         }   
		
	
        $carga_academica=$this
                      ->getDoctrine()
                      ->getRepository("NetpublicCoreBundle:CargaAcademica")
                      ->findBy(array(
                          'id'=>$carga_id
                      ));
        
        $colegio=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")
                      ->findOneBy(array(
                          'es_principal'=>1                        
                      ));	
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

        $xls_service =  $phpExcelObject;
        // create the object see http://phpexcel.codeplex.com documentation
        $xls_service->getProperties()->setCreator("iNachoLee")
                             ->setLastModifiedBy("iNachoLee")
                             ->setTitle("Planilla Con Notas")
                             ->setSubject("Planillas Con Notas")
                             ->setDescription("Esta planilla sirve par calificar notas offlne.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");
        //Guardamos metadatos.
        $hoja=0;  
        $xls_service->setActiveSheetIndex($hoja);         
        $periodo_id=$session->get('perido_id');
        $periodo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);      
        $response=$this->pintarTodasPlanillas($xls_service,$carga_academica,$colegio,$periodo,$profesor,$tipo);
             
        return $response;       
       
     
    }
     /**
     * Displays a form to edit an existing Alumno entity.
     * @Route("/{tipo}/{profesor_id}/getvariasplanillaadmin.{_format}",defaults={"_format"="xls"}, requirements={"_format"="html|xls|pdf"}, name="profesor_getvariasplanillaadmin") 
     * @Template()
     * 
     */    
    public function getvariasplanillaadminAction($tipo,$profesor_id){
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $em=  $this->getDoctrine()->getEntityManager();
        $session=  $this->getRequest()->getSession();
        $profesor=$em->getRepository("NetpublicCoreBundle:Profesor")->find($profesor_id);
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
        $carga_academica=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->getAsignaturaGrupo(
                $profesor_id,$ano_escolar_id_s);
        if(!count($carga_academica)){
           $carga_academica=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
                'profesor'=>$profesor_id
            ));
        }   
        $colegio=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")
                      ->findOneBy(array(
                          'es_principal'=>1                        
                      ));
        
        $xls_service =  $this->get('phpexcel')->createPHPExcelObject();
        // create the object see http://phpexcel.codeplex.com documentation
        $xls_service->getProperties()->setCreator("iNachoLee")
                             ->setLastModifiedBy("iNachoLee")
                             ->setTitle("Planilla Con Notas")
                             ->setSubject("Planillas Con Notas")
                             ->setDescription("Esta planilla sirve par calificar notas offlne.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");
        //Guardamos metadatos.
        $hoja=0;  
        $xls_service->setActiveSheetIndex($hoja);         
        $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                            ->findPeriodoEscolarActivo();
        $periodo_id=$session->get('perido_id',$periodo_activo->getId());
        $periodo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);      
        $response=$this->pintarTodasPlanillas($xls_service,$carga_academica,$colegio,$periodo,$profesor,$tipo);
        
        return $response;       
       
        
        
        
     
    }
    
     /**
     * Displays a form to edit an existing Alumno entity.
     * @Route("/{tipo}/{carga_academica_id}/getunaplanillaadmin.{_format}",defaults={"_format"="xls"}, requirements={"_format"="html|xls|pdf"}, name="profesor_getunaplanillaadmin") 
     * @Template()
     * 
     */    
    public function getunaplanillaadminAction($tipo,$carga_academica_id){
        $carga_academica=$this
                      ->getDoctrine()
                      ->getRepository("NetpublicCoreBundle:CargaAcademica")
                      ->findBy(array(
                          'id'=>$carga_academica_id
                      ));
        
        $session=  $this->getRequest()->getSession();
	$user = $this->get('security.context')->getToken()->getUser();
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor();
        } 
        $colegio=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")
                      ->findOneBy(array(
                          'es_principal'=>1                        
                      ));	
        
        $xls_service =  $this->get('phpexcel')->createPHPExcelObject();
        // create the object see http://phpexcel.codeplex.com documentation
        $xls_service->getProperties()->setCreator("iNachoLee")
                             ->setLastModifiedBy("iNachoLee")
                             ->setTitle("Planilla Con Notas")
                             ->setSubject("Planillas Con Notas")
                             ->setDescription("Esta planilla sirve par calificar notas offlne.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");
        //Guardamos metadatos.
        $hoja=0;  
        $xls_service->setActiveSheetIndex($hoja);         
        $periodo_id=$session->get('perido_id');
        
        $periodo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);      
        $response=$this->pintarTodasPlanillas($xls_service,$carga_academica,$colegio,$periodo,$profesor,$tipo);
      
        return $response;       
       
     
    }
    

    /**
     * Displays a form to edit an existing Alumno entity.
     * @Route("/{tipo}/getplanillaconnotas.{_format}",defaults={"_format"="xls"}, requirements={"_format"="html|xls|pdf"}, name="profesor_getplanillaconnotas") 
     * @Template()
     * 
     */    
    public function getplanillaconnotasAction($tipo){
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $em=$this->getDoctrine()->getEntityManager();
        $session=  $this->getRequest()->getSession();
	$user = $this->get('security.context')->getToken()->getUser();
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor();
            $profesor_id=$profesor->getId();            
         } 
         $colegio=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")
                      ->findOneBy(array(
                          'es_principal'=>1                        
                      ));	
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
        $carga_academica=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->getAsignaturaGrupo(
                $profesor_id,$ano_escolar_id_s);
        if(!count($carga_academica)){
            $carga_academica=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
                'profesor'=>$profesor_id
            ));
        }
        
	$xls_service =  $this->get('phpexcel')->createPHPExcelObject();
        // create the object see http://phpexcel.codeplex.com documentation
        $xls_service->getProperties()->setCreator("iNachoLee")
                             ->setLastModifiedBy("iNachoLee")
                             ->setTitle("Planilla Con Notas")
                             ->setSubject("Planillas Con Notas")
                             ->setDescription("Esta planilla sirve par calificar notas offlne.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");
        //Guardamos metadatos.
        $hoja=0;  
        $xls_service->setActiveSheetIndex($hoja);
        $periodo_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodoEscolarActivo();
        
        $periodo_id=$session->get('perido_id',$periodo_escolar_activo->getId());
        $periodo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);
        $carga_academica=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
            'profesor'=>$profesor_id
        ));
        
        $response=$this->pintarTodasPlanillas($xls_service,$carga_academica,$colegio,$periodo,$profesor,$tipo);
        return $response;
    }
    /**
     * Displays a form to edit an existing Alumno entity.
     * @Route("/{grupo_id}/getplanillagrupo.{_format}",defaults={"_format"="xls"}, requirements={"_format"="html|xls|pdf"}, name="profesor_getplanillagrupo") 
     * @Template()
     * 
     */    
    public function getplanillagrupoAction($grupo_id){
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $em=$this->getDoctrine()->getManager();
        $session=  $this->getRequest()->getSession();
	$user = $this->get('security.context')->getToken()->getUser();
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor();
            $profesor_id=$profesor->getId();            
         }
        $colegio=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")
                      ->findOneBy(array(
                          'es_principal'=>1                        
                      ));	
        
        $ano_escolar_activo=  $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Dimension")
                              ->findAnoEscolarActivo();
              
        $periodos_escolares=$this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Dimension")
                             ->findPeriodosEscolar($ano_escolar_activo);
           
        $xls_service =  $this->get('phpexcel')->createPHPExcelObject();    
        $writer = $this->get('phpexcel')->createWriter($xls_service, 'Excel5');
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
                
        $cargas=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
            'grupo'=>$grupo_id
        ));
        $alumnos=$em->getRepository("NetpublicCoreBundle:Alumno")->findBy(array(
            'grupo'=>$grupo_id
        ));
        $em->getRepository("NetpublicCoreBundle:Colegio")->iniciarLibroExcell($xls_service,$colegio,"Solo es un ejem");
        $hoja=0;
        $xls_service->setActiveSheetIndex($hoja);
        foreach ($cargas as $ca) {
            $encabezado=array();
            $encabezado[]="#";
            $encabezado[]="Alumno";
            $encabezado[]="Sede";
            
            foreach ($periodos_escolares as $periodo) {
                $encabezado[]="$periodo";
            }
            $encabezado[]="DEFINITIVA";
            $encabezado[]="DESEMPENO";
            
            $fila_inicial=10;            
            $em->getRepository("NetpublicCoreBundle:Colegio")->pintarEncabezado(0,$fila_inicial,$encabezado);
            $fila_inicial++;
            foreach ($alumnos as $alumno) {
                $em->getRepository("NetpublicCoreBundle:Colegio")->pintarFilaNotasPeriodosAlumnoExcell(
                    $alumno,$ano_escolar_activo,5,$ca->getAsignatura()->getId(),$fila_inicial,0,1,$colegio);
                $fila_inicial++;
            }
            $em->getRepository("NetpublicCoreBundle:Colegio")->setNombrePlanilla("{$ca->getAsignatura()}{$ca->getGrupo()}");
            $hoja++;   
            $xls_service->createSheet();
            $xls_service->setActiveSheetIndex($hoja);
        }
        $xls_service->setActiveSheetIndex(0);
        $nombre_archivo=  Util::getSlug("{ResumenPorAsignaturas-{$ca->getGrupo()}");
        $response= $em->getRepository("NetpublicCoreBundle:Colegio")->exportarLibro($writer,$response,$nombre_archivo);
        return $response;
    }
    /**
     * Displays a form to edit an existing Alumno entity.
     * @Route("/{grado_id}/getplanillagradoadmin.{_format}",defaults={"_format"="xls"}, requirements={"_format"="html|xls|pdf"}, name="profesor_getplanillagradoadmin") 
     * @Template()
     * 
     */    
    public function getplanillagradoadminAction($grado_id){
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $em=$this->getDoctrine()->getManager();
        $colegio=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")
                      ->findOneBy(array(
                          'es_principal'=>1                        
                      ));	
        
        $ano_escolar_activo=  $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Dimension")
                              ->findAnoEscolarActivo();
              
        $periodos_escolares=$this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Dimension")
                             ->findPeriodosEscolar($ano_escolar_activo);
           
        $xls_service =  $this->get('phpexcel')->createPHPExcelObject();    
        $writer = $this->get('phpexcel')->createWriter($xls_service, 'Excel5');
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        $grupos=$em->getRepository("NetpublicCoreBundle:Grupo")->findBy(array(
            'grado'=>$grado_id
        ));
        foreach ($grupos as $g) {
            $mi_cargas=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
            'grupo'=>$g->getId()
            ));
            foreach ($mi_cargas as $c) {
                $cargas[]=$c;
            }
        
        }
        $em->getRepository("NetpublicCoreBundle:Colegio")->iniciarLibroExcell($xls_service,$colegio,"Solo es un ejem");
        $hoja=0;
        $xls_service->setActiveSheetIndex($hoja);
        foreach ($cargas as $ca) {
            $encabezado=array();
            $encabezado[]="#";
            $encabezado[]="Alumno";
            $encabezado[]="Sede";
            foreach ($periodos_escolares as $periodo) {
                $encabezado[]="$periodo";
            }
            $encabezado[]="DEFINITIVA";
            $encabezado[]="DESEMPENO";
            
            $fila_inicial=10;            
            $em->getRepository("NetpublicCoreBundle:Colegio")->pintarEncabezado(0,$fila_inicial,$encabezado);
            $fila_inicial++;
            foreach ($grupos as $grupo) {
                $alumnos=$em->getRepository("NetpublicCoreBundle:Alumno")->findBy(array(
                'grupo'=>$grupo->getId()
                ));            
                foreach ($alumnos as $alumno) {
                    $em->getRepository("NetpublicCoreBundle:Colegio")->pintarFilaNotasPeriodosAlumnoExcell(
                        $alumno,$ano_escolar_activo,5,$ca->getAsignatura()->getId(),$fila_inicial,0,1,$colegio);
                    $fila_inicial++;
                }
            }
            
            $em->getRepository("NetpublicCoreBundle:Colegio")->setNombrePlanilla("{$ca->getAsignatura()}{$ca->getGrupo()}");
            $hoja++;   
            $xls_service->createSheet();
            $xls_service->setActiveSheetIndex($hoja);
        }
        $xls_service->setActiveSheetIndex(0);
        $nombre_archivo=  Util::getSlug("{ResumenPorAsignaturas-{$ca->getGrupo()}");
        $response= $em->getRepository("NetpublicCoreBundle:Colegio")->exportarLibro($writer,$response,$nombre_archivo);
        return $response;
    }

    
    
    
    
    
    
    /**
     * Displays a form to edit an existing Alumno entity.
     * @Route("/{grupo_id}/getplanillaresumen.{_format}",defaults={"_format"="xls"}, requirements={"_format"="html|xls|pdf"}, name="profesor_getplanillaresumen") 
     * @Template()
     * 
     */    
    public function getplanillaresumenAction($grupo_id){
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $em=$this->getDoctrine()->getManager();
        $colegio=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")
                      ->findOneBy(array(
                          'es_principal'=>1                        
                      ));	
        
        $ano_escolar_activo=  $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Dimension")
                              ->findAnoEscolarActivo();
              
        $periodos_escolares=$this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Dimension")
                             ->findPeriodosEscolar($ano_escolar_activo);
        $grupo=$em->getRepository("NetpublicCoreBundle:Grupo")->find($grupo_id);   
        $xls_service =  $this->get('phpexcel')->createPHPExcelObject();    
        $writer = $this->get('phpexcel')->createWriter($xls_service, 'Excel5');
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
                
        $cargas=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
            'grupo'=>$grupo_id
        ));
        $alumnos=$em->getRepository("NetpublicCoreBundle:Alumno")->findBy(array(
            'grupo'=>$grupo_id
        ));
        $areas=$em->getRepository("NetpublicCoreBundle:Asignatura")->findBy(array(
                'es_area'=>1,
                'grado'=>$grupo->getGrado()->getid()
            ));
            
        $em->getRepository("NetpublicCoreBundle:Colegio")->iniciarLibroExcell($xls_service,$colegio,"Resumen AnoEscolar $ano_escolar_activo");
        $hoja=0;
        $xls_service->setActiveSheetIndex($hoja);
        //foreach ($cargas as $ca) {
            $encabezado=array();
            $encabezado[]="#";
            $encabezado[]="Alumno";
            $encabezado[]="Sede";
            
            foreach ($areas as $area) {
                $encabezado[]="$area";
            }
            $encabezado[]="ESTADO A FIN DE AÑO";
            $encabezado[]="NOTA DE RECUPERACION";
            
            $fila_inicial=10;            
            $em->getRepository("NetpublicCoreBundle:Colegio")->pintarEncabezado(0,$fila_inicial,$encabezado);
            $fila_inicial++;
            foreach ($alumnos as $alumno) {
                $alumno_m=$em->getRepository("NetpublicCoreBundle:Alumno")->promover($alumno,$periodos_escolares,$colegio->getNotaMinima(),$areas,$ano_escolar_activo);
                $em->getRepository("NetpublicCoreBundle:Colegio")->pintarFilaAcumuladoPeriodosAlumnoExcell(
                    $alumno_m,$ano_escolar_activo,5,$areas,$fila_inicial,0,1,$colegio);
                $fila_inicial++;
            }
            $em->flush();
            $em->getRepository("NetpublicCoreBundle:Colegio")->setNombrePlanilla("ResumenFinal$grupo");
            $hoja++;   
            $xls_service->createSheet();
            $xls_service->setActiveSheetIndex($hoja);
        //}
        $xls_service->setActiveSheetIndex(0);
        $nombre_archivo=  Util::getSlug("ResumenAnoEscolar$ano_escolar_activo $grupo");
       $response= $em->getRepository("NetpublicCoreBundle:Colegio")->exportarLibro($writer,$response,$nombre_archivo);
       return $response;
    }

    /**
     * Displays a form to edit an existing Alumno entity.
     * @Route("/{grado_id}/getplanillagradoresumen.{_format}",defaults={"_format"="xls"}, requirements={"_format"="html|xls|pdf"}, name="profesor_getplanillagradoresumen") 
     * @Template()
     * 
     */    
    public function getplanillagradoresumenAction($grado_id){
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $em=$this->getDoctrine()->getManager();
        $colegio=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")
                      ->findOneBy(array(
                          'es_principal'=>1                        
                      ));	
        
        $ano_escolar_activo=  $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Dimension")
                              ->findAnoEscolarActivo();
              
        $periodos_escolares=$this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Dimension")
                             ->findPeriodosEscolar($ano_escolar_activo);
        $grado=$em->getRepository("NetpublicCoreBundle:Grupo")->find($grado_id);
        $grupos=$em->getRepository("NetpublicCoreBundle:Grupo")->findBy(array(
            'grado'=>$grado_id
        ));
        foreach ($grupos as $g) {
            $mi_cargas=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
            'grupo'=>$g->getId()
            ));
            foreach ($mi_cargas as $c) {
                $cargas[]=$c;
            }
        
        }
        $xls_service =  $this->get('phpexcel')->createPHPExcelObject();    
        $writer = $this->get('phpexcel')->createWriter($xls_service, 'Excel5');
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
                
        $em->getRepository("NetpublicCoreBundle:Colegio")->iniciarLibroExcell($xls_service,$colegio,"Resumen AnoEscolar $ano_escolar_activo");
        $hoja=0;
        $xls_service->setActiveSheetIndex($hoja);
        $areas=$em->getRepository("NetpublicCoreBundle:Asignatura")->findBy(array(
                'es_area'=>1,
                'grado'=>$grado_id
            ));
            
        //foreach ($cargas as $ca) {
            $encabezado=array();
            $encabezado[]="#";
            $encabezado[]="Alumno";
            $encabezado[]="Sede";
            
            foreach ($areas as $area) {
                $encabezado[]="$area";
            }
            $encabezado[]="ESTADO A FIN DE AÑO";
            $encabezado[]="NOTA DE RECUPERACION";
            
            $fila_inicial=10;            
            $em->getRepository("NetpublicCoreBundle:Colegio")->pintarEncabezado(0,$fila_inicial,$encabezado);
            $fila_inicial++;
            foreach ($grupos as $grupo) {
                $alumnos=$em->getRepository("NetpublicCoreBundle:Alumno")->findBy(array(
                'grupo'=>$grupo->getId()
                ));            
            foreach ($alumnos as $alumno) {
            $alumno_m=$em->getRepository("NetpublicCoreBundle:Alumno")->promover($alumno,$periodos_escolares,$colegio->getNotaMinima(),$areas,$ano_escolar_activo);
                $em->getRepository("NetpublicCoreBundle:Colegio")->pintarFilaAcumuladoPeriodosAlumnoExcell(
                    $alumno_m,$ano_escolar_activo,5,$areas,$fila_inicial,0,1,$colegio);
                $fila_inicial++;
            }
            }
            $em->flush();
            $em->getRepository("NetpublicCoreBundle:Colegio")->setNombrePlanilla("ResumenFinalAno$grado");
            $hoja++;   
            $xls_service->createSheet();
            $xls_service->setActiveSheetIndex($hoja);
        //}
        $xls_service->setActiveSheetIndex(0);
        $nombre_archivo=  Util::getSlug("ResumenAnoEscolar$ano_escolar_activo-{$grado}");
       $response= $em->getRepository("NetpublicCoreBundle:Colegio")->exportarLibro($writer,$response,$nombre_archivo);
       return $response;
    }

    
    
    
    /**
     * Lists all Profesor entities.
     *
     * @Route("/indexdesempeno", name="profesor_indexdesempeno")
     * @Template()
     */
    public function indexdesempenoAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        date_default_timezone_set("America/Bogota");       
        $session=$this->get('request')->getSession();
        $user = $this->get('security.context')->getToken()->getUser();  
        $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodoEscolarActivo();
        $periodo_id=$session->get('perido_id',$periodo_activo->getId());
	if(!($user->getEsAlumno()))
            $profesor=$user->getProfesor();
        $hoy=new \DateTime("now");
        $hoy=$hoy->format("Y-m-d H:i:s");
        $query="SELECT count(a) FROM NetpublicCoreBundle:Profesorperiodoentrega a ";
        $query.="WHERE  a.profesor=:profesor_id";
        $query.=" AND a.periodo=:periodo_id"; 
        $query.=" AND a.fecha_inicio<=:fecha_actual"; 
        $query.=" AND a.fecha_final>=:fecha_actual"; 
        $query = $em->createQuery($query)
                            ->setParameters(array(
                           "periodo_id"=>$periodo_id,
                           "fecha_actual"=>$hoy,
                            "profesor_id"=>$profesor->getId()    
                            ));
         $count = $query->getSingleScalarResult();
         
         $es_tiempo_calificar=$count;
        //Buscamos descriptores para el periodo y la asignatura en sesion
        $desempeno=$this->getDoctrine()
                       ->getRepository('NetpublicCoreBundle:Desempeno')
                       ->findBy(array('profesor'=>$profesor->getId(),'periodo'=>$periodo_id));
              
        return array('desempeno' => $desempeno,
            'es_tiempo_calificar'=>$es_tiempo_calificar);
    }    
    /**
     * Muestra la pagina de Descriptores,Actividades y Periodos
     *
     * @Route("/periodo_descriptores_actividades", name="profesor_periodo_descriptores_actividades")
     * @Template()
     */
    public function periodo_descriptores_actividadesAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $entities = $em->getRepository('NetpublicCoreBundle:Profesor')->findAll();

        return array('entities' => $entities);
    } 
     /**
     * Muestra la pagina de Descriptores,Actividades y Periodos
     *
     * @Route("/grupocargaacademica", name="profesor_grupocargaacademica")
     * @Template()
     */
    public function grupocargaacademicaAction()
    {
         
    
     $user = $this->get('security.context')->getToken()->getUser();
        
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor();            
            $id_profesor=$profesor->getId();
            
            $entities=$this->getDoctrine()
                            ->getRepository('NetpublicCoreBundle:CargaAcademica')
                            ->findBy(array(
                                'profesor'=>$id_profesor
                            ));
           
        } 
        $entities__=array();
        $ids_grupo=array();
        foreach ($entities as $entity) {
            if (!in_array($entity->getGrupo()->getId(),$ids_grupo)){
                $ids_grupo[]=$entity->getGrupo()->getId();
                $entities__[]=$entity;
            }
            
        }
    //     $contratos=$profesor->getContrato();
        return array('entities' => $entities__);
    } 
     /**
     * Muestra la pagina de Descriptores,Actividades y Periodos
     *
     * @Route("/asignaturacargaacademica", name="profesor_asignaturacargaacademica")
     * @Template()
     */
    public function asignaturacargaacademicaAction()
    {
         
    
     $user = $this->get('security.context')->getToken()->getUser();       
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor();            
            $id_profesor=$profesor->getId();
            
            $entities=$this->getDoctrine()->getRepository('NetpublicCoreBundle:CargaAcademica')->getAsignaturaGrupo($id_profesor);
           
        } 
        $contratos=$profesor->getContrato();
        return array('entities' => $entities,'contratos'=>$contratos);
    }        
  
    /**
     * Lists all Profesor entities.
     *
     * @Route("/perfil", name="profesor_perfil")
     * @Template()
     */
    public function perfilAction()
    {
        //Variable de SESION
/*        $user = $this->get('security.context')->getToken()->getUser();
        if(!($user->getEsAlumno())){
            $profesor=$user->getProfesor();
            echo "Estas como".$profesor->getNombre();
            
            $profesor_id=$profesor->getId();
        }
        
        $session = $this->get('request')->getSession();
        $session->set("profesor_id",$profesor_id);
        $repository=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension");
        $dim_grupo_padre=$repository->findBy(array('es_ano_escolar'=>1));
        $carga_academica=$this->getDoctrine()
                ->getRepository("NetpublicCoreBundle:CargaAcademica")
                ->findBy(array("profesor"=>$profesor_id));
        $grupo=$carga_academica[0]->getGrupo();
        $asignatura=$carga_academica[0]->getAsignatura();
        
        return array(
            "dimension_defecto"=>$dim_grupo_padre[0],
            "grupo_defecto"=>$grupo,
            "asignatura_defecto"=>$asignatura
            );*/
        return new \Symfony\Component\HttpFoundation\Response("OK");
    }

    /**
     * Finds and displays a Profesor entity.
     *
     * @Route("/{id}/show", name="profesor_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Profesor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Profesor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }
    /**
     * Finds and displays a Profesor entity.
     *
     * @Route("/{id_profesor}/showhorario", name="profesor_showhorario")
     * @Template()
     */
    public function showhorarioAction($id_profesor)
    {
        $em = $this->getDoctrine()->getEntityManager();

         $carga_academica=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
            'profesor'=>$id_profesor,
            //'es_carga_academica'=>TRUE
        ));
        
        return array(
            'carga_academica' => $carga_academica

            );
    }

    /**
     * Displays a form to create a new Profesor entity.
     *
     * @Route("/new", name="profesor_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Profesor();
        $form   = $this->createForm(new ProfesorType(), $entity);
        $es_ajax=false;
        $request=  $this->getRequest();
        if($request->isXmlHttpRequest())
            $es_ajax=true;
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
           
        );
    }

    /**
     * Creates a new Profesor entity.
     *
     * @Route("/create", name="profesor_create")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Profesor:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Profesor();
        $request = $this->getRequest();
        $es_ajax=false;
        if($request->isXmlHttpRequest()){
            $es_ajax=true;
        }
        $form    = $this->createForm(new ProfesorType(), $entity);
         $form->handleRequest($request);
        
        if ($form->isValid()) {            
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery('SELECT count(a) FROM NetpublicCoreBundle:Usuario a WHERE a.username LIKE :nombre')
                            ->setParameters(array(
                            "nombre"=>$entity->getNombre().'%'                           
                            
                                )
                            );
            $count = $query->getSingleScalarResult();
			$nombre=$entity->getNombre();
			if($count>0){
				$nombre=$entity->getNombre().$count;
			}
			
            $usuario=new Usuario(); 
            //$primer_nombre=explode(" ",);
            $usuario->setUsername($nombre);
            $usuario->setSalt(md5(time()));
            $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
            $password = $encoder->encodePassword($entity->getCedula(), $usuario->getSalt());
            $usuario->setPassword($password);
            $usuario->setEsAlumno(FALSE);
            $usuario->setProfesor($entity);
            $entity->setUsuario($usuario);            
            if($entity->getTipo()==1){
                //Rector
                $mi_rol=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Rol")->find(3);
            }
            if($entity->getTipo()==3){
                //Secretaria Auxiliar
                $mi_rol=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Rol")->find(4);
            }
            if($entity->getTipo()==2){                
                //Profesor
              
                     
                $mi_rol=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Rol")->find(2);
            }
            if($entity->getTipo()==4){
                //Coordinador Academico
                $mi_rol=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Rol")->find(3);
            }
            if($entity->getTipo()==5){
                //Coordinador De Convivencia
                $mi_rol=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Rol")->find(3);
            }
            $usuario->addRol($mi_rol);           
            $em->persist($usuario);             
            $em->persist($entity);             
            $em->flush();
            $file=$form['foto_academica']->getData();
            if($file){
                                $nombre_archivo= 'profesor'.$entity->getId();  
                                    //$file->move(__DIR__.'/../../../../web/'.'uploads/documents',$nombre_archivo);
                                    $imagine = new \Imagine\Gd\Imagine();
                                    $image = $imagine->open($file);
                                    $thumbnail_mini = $image->thumbnail(new Box(50, 50));
                                    $thumbnail_mini->save(__DIR__.'/../../../../../web/'.'uploads/documents/mini'.$nombre_archivo.'.jpg');
                                    $thumbnail_strong = $image->thumbnail(new Box(135, 300));
                                    $thumbnail_strong->save(__DIR__.'/../../../../../web/'.'uploads/documents/strong'.$nombre_archivo.'.jpg');
                                    $usuario->setEsFotoperfil(TRUE);
               
            }
            $file1=$form['foto_firma']->getData();
            if($file1){
            $nombre_archivo= 'firma_profe'.$entity->getId().'.'.$file1->guessExtension();  
            $file1->move(__DIR__.'/../../../../../web/'.'uploads/documents',$nombre_archivo);
            }
            $em->persist($mi_rol);            
            if($entity->getTipo()==2){
             
           $ano_escolar_activo=  $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Dimension")
                              ->findAnoEscolarActivo();
              
               $perios_escolares=$this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Dimension")
                             ->findPeriodosEscolar($ano_escolar_activo);
                     foreach ($perios_escolares as $p_e) {    

                          $this->getDoctrine()->getRepository("NetpublicCoreBundle:Profesor")
                        ->generarFechasEntregasProfesor($entity,$p_e);

                     } 
            }     
            $em->flush();
            if ($this->container->get('request')->isXmlHttpRequest()){
                return new \Symfony\Component\HttpFoundation\Response("ok");
            }
            return $this->redirect($this->generateUrl('profesor_show', array('id' => $entity->getId())));
            
        }
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'es_ajax' =>$es_ajax
        );
    }

    /**
     * Displays a form to edit an existing Profesor entity.
     *
     * @Route("/{id}/edit", name="profesor_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $es_ajax=false;
        $entity = $em->getRepository('NetpublicCoreBundle:Profesor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Profesor entity.');
        }
        if($request->isXmlHttpRequest()){
            $es_ajax=true;
        }

        //$editForm = $this->createForm(new ProfesorType(), $entity);
        $editForm = $this->createFormBuilder($entity)
            ->add('nombre',null,array('label'=>'Primer Nombre.'))
            ->add('nombre1',null,array('label'=>'Segundo Nombre.'))
            ->add('apellido',null,array('label'=>'Primer Apellido.'))                                                
            ->add('apellido1',null,array('label'=>'Segundo Apellido.'))                    
            
             ->add('tipo_documento','choice',array(
                 'empty_value' => '             ',
                'choices'=>array(                    
                    '1'=>'Cedula Ciudadania',
                    '2'=>'Tarjeta de Identidad',
                    '3'=>"Cédula de Extranjería ó Identificación de Extranjería",
                    '5'=>"Registro Civil de Nacimiento",
                    "6"=>"Número de Identificación Personal (NIP)",
                    '7'=>"Número Único de Identificación Personal (NUIP)",
                    '8'=>"Número de Identificación establecido por la Secretaría de  Educación",
                    "9"=>"Certificado Cabildo"
                )))

            ->add('cedula','text',  array(
                'attr'=>  array('onblur'=> 'getAlumnoCedulaProfesor();')
            )) 
           ->add('sede')   
      
            ->add('genero','choice',array(
                'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    
                    '1'=>'Masculino',
                    '2'=>'Femenino'
                )))                
            ->add('clase')        
            ->add('fecha_nacimiento')        
             ->add('departamento', 'entity', array(
                 'required'=>FALSE,
                                  'empty_value' => '             ',
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))       
             ->add('municipio', 'entity', array(
                 'required'=>FALSE,
                                  'empty_value' => '             ',
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=14')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))           
            //->add('estado_civil')        
            ->add('estado_civil','choice',array(
                'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(                    
                    '1'=>'Soltero',
                    '2'=>'Casado',
                    '3'=>"Union Libre"
                )))                
            ->add('numero_hijos')                        
            ->add('fecha_retiro') 
            ->add('fecha_vinculacion') 
            ->add('libreta_militar')                 
            ->add('distrito')        
        

->add('nivel_educativo_aprobado','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'Sin titulo',
                    '2'=>'Bachiller pedagógico',
                    '3'=>'Normalista superior',
                    '4'=>"Otro bachiller",
                    '5'=>"Técnico o tecnólogo en educación",
                    "6"=>"Técnico o tecnólogo en otras áreas",
                    '7'=>"Profesional o licenciado en educación",
                    '8'=>"Profesional en otras áreas, no licenciado",
                    "9"=>"Postgrado en educación",
                    "10"=>"Postgrado en otras áreas"
                )))   
->add('ubicacion','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'1 Establecimiento educativo',
                    '2'=>'2 En Comisión',
                    '3'=>'3 Otros'

                )))    
->add('cargo','choice',array(
    'required'=>FALSE,
    'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'1 Docente',
                    '2'=>'2 Directivo Docente'                  

                )))                  
->add('zona','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'1 Zona urbana',
                    '2'=>'2 Zona rural',
                    '3'=>'3 No aplica'

                )))    
->add('fuente_recursos','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'1 SGP',
                    '2'=>'2 Recursos propios (de la Entidad Territorial)'
   
                )))    
->add('tipo_vinculacion','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'1 Con nombramiento en propiedad',
                    '2'=>'2 Con nombramiento provisional en una vacante definitiva',
                    '3'=>'3 Con nombramiento provisional en una vacante temporal',
                    '4'=>"4 Con nombramiento en período de prueba"
                   
                )))                 
->add('nombre_cargo','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'1  Docente de aula',
                    '2'=>'2 Docente con funciones de apoyo para alumnos con necesidades educativas especiales',
                    '3'=>'3 Docente con funciones de orientador',
                    '4'=>"4  Coordinador",
                    '5'=>"5  Director rural",
                    "6"=>"6  Rector",
                    '7'=>"7  Director de núcleo",
                    '8'=>"8  Supervisor de educación"
                   
                )))   
->add('doc_dir_comision','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'1 Para ocupar un cargo de libre nombramiento y remoción',
                    '2'=>'2 De estudios remunerada',
                    '3'=>'3 De estudios no remunerada',
                    '4'=>"4 De Servicios",
                    '4'=>"5 No Aplica"
                                     
                )))  
->add('fecha_status_amenazado')                                                                                                
->add('amenazados','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '0'=>'No',
                    '1'=>'Si'
                 
                )))   

            
            
#            ->add('fecha_status_amenazado')                        
            ->add('estado_civil')        
            ->add('numero_hijos')                                        
            ->add('fecha_retiro')        
            ->add('libreta_militar')                        
            ->add('distrito')        

->add('grado_escalafon','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'SE Sin escalafón',
                    '2'=>'BC Bachiller',
                    '3'=>'PT Profesional técnico o tecnológico en educación',
                    '4'=>"PU Profesional universitario",
                    '5'=>"Técnico o tecnólogo en educación",
                    "6"=>"IA Instructor II-A",
                    '7'=>"IB Instructor III-B",
                    '8'=>"IC Instructor IV-C",
                    "9"=>"A",
                    "10"=>"B",
                    '11'=>'01',
                    '12'=>'02',
                    '13'=>'03',
                    '14'=>"04",
                    '15'=>"05",
                    "16"=>"06",
                    '17'=>"07",
                    '18'=>"08",
                    "19"=>"09",
                    "20"=>"10",
                    '21'=>'11',
                    '22'=>'12',
                    '23'=>'13',
                    '24'=>"14",
                    '25'=>"1A",
                    "26"=>"1B",
                    '27'=>"1C",
                    '28'=>"1D",
                    "29"=>"29",
                    '30'=>"2A",
                    "31"=>"2B",
                    '32'=>"2C",
                    '33'=>"2D",
                    "34"=>"3AM Maestria",                  
                    '35'=>"3BM Maestria",
                    "36"=>"3CM Maestria",
                    '37'=>"3DM Maestria",
                    '38'=>"3AD Doctorado",
                    "39"=>"3BD Doctorado",
                    '40'=>"3CD Doctorado",
                    "41"=>"3DD Doctorado",
                  
                    
                )))                 
->add('sobresueldo_recibido','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'No Aplica / Sin Sobresueldo',
                    '2'=>'Sobresueldo 5%',
                    '3'=>'Sobresueldo 10%',
                    '4'=>"Sobresueldo 15%",
                    '5'=>"Sobresueldo 20%",
                    "6"=>"Sobresueldo 25%",
                    '7'=>"Sobresueldo 30%",
                    '8'=>"Sobresueldo 35%",
                    "9"=>"Sobresueldo 40%",
                    "10"=>"Sobresueldo 18%"                 
                    
                )))                 

->add('nivel_ensenanza','choice',array(
    'required'=>FALSE,
                'empty_value' => '0',
                'choices'=>array(
                    '1'=>'Preescolar',
                    '2'=>'Básica Primaria',
                    '3'=>'Básica Secundaria y Media',
                    '4'=>"Ciclo Complementario (Normales)",
                    '5'=>"No Aplica"                
                )))                 

->add('etnoeducador','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'Raizal',
                    '2'=>'Afrocolombiano',
                    '3'=>'Indigena',
                    '4'=>"No Aplica"                     
                )))                 
->add('area_ensenanza_nombrado','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'Preescolar',
                    '2'=>'Primaria',
                    '3'=>'Ciencias Naturales y Educación Ambiental',
                    '4'=>"Ciencias Sociales",
                    '5'=>"Educ. Artistica - Artes plásticas",
                    "6"=>"Educ. Artistica - Música",
                    '7'=>"Educ. Artistica - Artes Escenica",
                    '8'=>"Educ. Artistica - Danzas",
                    "9"=>"Educ. Física, Recreación y Deporte",
                    "10"=>"Educ. Etica y en Valores",
                    '11'=>'Educ. Religiosa',
                    '12'=>'Humanidades y Lengua Castellana',
                    '13'=>'Idioma Extranjero Francés',
                    '14'=>"Idioma Extranjero Inglés",
                    '15'=>"Matemáticas",
                    "16"=>"Tecnología e Informática",
                    '17'=>"Ciencias Naturales Química",
                    '18'=>"Ciencias Naturales Física",
                    "19"=>"Filosofía",
                    "20"=>"Ciencias Económicas y Políticas",
                    '21'=>'Areas de Apoyo Para educación Especial',
                    '22'=>'No aplica'
                )))                                       
 ->add('area_ensenanza_tecnica','choice',array(
     'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'Finanzas - Administración y Seguros',
                    '2'=>'Ventas y Servicios',
                    '3'=>'Ciencias Naturales y Aplicadas',
                    '4'=>"Salud",
                    '5'=>"Ciencias Sociales, Educación, Servicios Gubernamentales y Religión",
                    "6"=>"Cultura, Arte, Esparcimiento y Deporte",
                    '7'=>"Explotación Primaria y Extractiva",
                    '8'=>"Operadores del Equipo y Transporte Instalación y Mantenimiento",
                    "9"=>"Procesamiento, Fabricación y Ensamble",
                    "10"=>"Otras",
                    '11'=>'No aplica'
                )))                                       
           
            
            ->add('descripcion_otra_area')        

             ->add('foto_academica','file',array('required'=>FALSE))    
            ->getForm();                                    
        

                ;
        //$deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
          //  'delete_form' => $deleteForm->createView(),
            'es_ajax' => $es_ajax
        );
    }
   /**
     * Displays a form to edit an existing Profesor entity.
     *
     * @Route("/{id}/editperfiladminfiltro", name="profesor_editperfiladminfiltro")
     * @Template()
     */
    public function editperfiladminfiltroAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $es_ajax=false;
        $entity = $em->getRepository('NetpublicCoreBundle:Profesor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Profesor entity.');
        }
        if($request->isXmlHttpRequest()){
            $es_ajax=true;
        }

        $editForm = $this->createForm(new ProfesorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'es_ajax' => $es_ajax
        );
    }

    /**
     * Edits an existing Profesor entity.
     *
     * @Route("/{id}/update", name="profesor_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Profesor:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Profesor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Profesor entity.');
        }
        //VAlidando informacion que no esta en el formulario
        //$tipo_usuario=$entity->getTipo();
        //$usuario=$entity->getUsuario();
             $editForm = $this->createFormBuilder($entity)
            ->add('nombre',null,array('label'=>'Primer Nombre.'))
            ->add('nombre1',null,array('label'=>'Segundo Nombre.'))
            ->add('apellido',null,array('label'=>'Primer Apellido.'))                                                
            ->add('apellido1',null,array('label'=>'Segundo Apellido.'))                    
             ->add('tipo_documento','choice',array(
                 'empty_value' => '             ',
                'choices'=>array(                    
                    '1'=>'Cedula Ciudadania',
                    '2'=>'Tarjeta de Identidad',
                    '3'=>"Cédula de Extranjería ó Identificación de Extranjería",
                    '5'=>"Registro Civil de Nacimiento",
                    "6"=>"Número de Identificación Personal (NIP)",
                    '7'=>"Número Único de Identificación Personal (NUIP)",
                    '8'=>"Número de Identificación establecido por la Secretaría de  Educación",
                    "9"=>"Certificado Cabildo"
                )))

            ->add('cedula','text',  array(
                'attr'=>  array('onblur'=> 'getAlumnoCedulaProfesor();')
            )) 
           ->add('sede')   
      
            ->add('genero','choice',array(
                'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    
                    '1'=>'Masculino',
                    '2'=>'Femenino'
                )))                
            ->add('clase')        
            ->add('fecha_nacimiento')        
             ->add('departamento', 'entity', array(
                 'required'=>FALSE,
                                  'empty_value' => '             ',
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))       
             ->add('municipio', 'entity', array(
                 'required'=>FALSE,
                                  'empty_value' => '             ',
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=14')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))           
            //->add('estado_civil')        
            ->add('estado_civil','choice',array(
                'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(                    
                    '1'=>'Soltero',
                    '2'=>'Casado',
                    '3'=>"Union Libre"
                )))                
            ->add('numero_hijos')                        
            ->add('fecha_retiro') 
            ->add('fecha_vinculacion') 
            ->add('libreta_militar')                 
            ->add('distrito')        
        

->add('nivel_educativo_aprobado','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'Sin titulo',
                    '2'=>'Bachiller pedagógico',
                    '3'=>'Normalista superior',
                    '4'=>"Otro bachiller",
                    '5'=>"Técnico o tecnólogo en educación",
                    "6"=>"Técnico o tecnólogo en otras áreas",
                    '7'=>"Profesional o licenciado en educación",
                    '8'=>"Profesional en otras áreas, no licenciado",
                    "9"=>"Postgrado en educación",
                    "10"=>"Postgrado en otras áreas"
                )))   
->add('ubicacion','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'1 Establecimiento educativo',
                    '2'=>'2 En Comisión',
                    '3'=>'3 Otros'

                )))    
->add('cargo','choice',array(
    'required'=>FALSE,
    'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'1 Docente',
                    '2'=>'2 Directivo Docente'                  

                )))                  
->add('zona','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'1 Zona urbana',
                    '2'=>'2 Zona rural',
                    '3'=>'3 No aplica'

                )))    
->add('fuente_recursos','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'1 SGP',
                    '2'=>'2 Recursos propios (de la Entidad Territorial)'
   
                )))    
->add('tipo_vinculacion','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'1 Con nombramiento en propiedad',
                    '2'=>'2 Con nombramiento provisional en una vacante definitiva',
                    '3'=>'3 Con nombramiento provisional en una vacante temporal',
                    '4'=>"4 Con nombramiento en período de prueba"
                   
                )))                 
->add('nombre_cargo','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'1  Docente de aula',
                    '2'=>'2 Docente con funciones de apoyo para alumnos con necesidades educativas especiales',
                    '3'=>'3 Docente con funciones de orientador',
                    '4'=>"4  Coordinador",
                    '5'=>"5  Director rural",
                    "6"=>"6  Rector",
                    '7'=>"7  Director de núcleo",
                    '8'=>"8  Supervisor de educación"
                   
                )))   
->add('doc_dir_comision','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'1 Para ocupar un cargo de libre nombramiento y remoción',
                    '2'=>'2 De estudios remunerada',
                    '3'=>'3 De estudios no remunerada',
                    '4'=>"4 De Servicios",
                    '4'=>"5 No Aplica"
                                     
                )))   
->add('fecha_status_amenazado')                                                
->add('amenazados','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '0'=>'No',
                    '1'=>'Si'
                 
                )))   

            
            
#            ->add('fecha_status_amenazado')                        
            ->add('estado_civil')        
            ->add('numero_hijos')                                        
            ->add('fecha_retiro')        
            ->add('libreta_militar')                        
            ->add('distrito')        

->add('grado_escalafon','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'SE Sin escalafón',
                    '2'=>'BC Bachiller',
                    '3'=>'PT Profesional técnico o tecnológico en educación',
                    '4'=>"PU Profesional universitario",
                    '5'=>"Técnico o tecnólogo en educación",
                    "6"=>"IA Instructor II-A",
                    '7'=>"IB Instructor III-B",
                    '8'=>"IC Instructor IV-C",
                    "9"=>"A",
                    "10"=>"B",
                    '11'=>'01',
                    '12'=>'02',
                    '13'=>'03',
                    '14'=>"04",
                    '15'=>"05",
                    "16"=>"06",
                    '17'=>"07",
                    '18'=>"08",
                    "19"=>"09",
                    "20"=>"10",
                    '21'=>'11',
                    '22'=>'12',
                    '23'=>'13',
                    '24'=>"14",
                    '25'=>"1A",
                    "26"=>"1B",
                    '27'=>"1C",
                    '28'=>"1D",
                    "29"=>"29",
                    '30'=>"2A",
                    "31"=>"2B",
                    '32'=>"2C",
                    '33'=>"2D",
                    "34"=>"3AM Maestria",                  
                    '35'=>"3BM Maestria",
                    "36"=>"3CM Maestria",
                    '37'=>"3DM Maestria",
                    '38'=>"3AD Doctorado",
                    "39"=>"3BD Doctorado",
                    '40'=>"3CD Doctorado",
                    "41"=>"3DD Doctorado",
                  
                    
                )))                 
->add('sobresueldo_recibido','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'No Aplica / Sin Sobresueldo',
                    '2'=>'Sobresueldo 5%',
                    '3'=>'Sobresueldo 10%',
                    '4'=>"Sobresueldo 15%",
                    '5'=>"Sobresueldo 20%",
                    "6"=>"Sobresueldo 25%",
                    '7'=>"Sobresueldo 30%",
                    '8'=>"Sobresueldo 35%",
                    "9"=>"Sobresueldo 40%",
                    "10"=>"Sobresueldo 18%"                 
                    
                )))                 

->add('nivel_ensenanza','choice',array(
    'required'=>FALSE,
                'empty_value' => '0',
                'choices'=>array(
                    '1'=>'Preescolar',
                    '2'=>'Básica Primaria',
                    '3'=>'Básica Secundaria y Media',
                    '4'=>"Ciclo Complementario (Normales)",
                    '5'=>"No Aplica"                
                )))                 

->add('etnoeducador','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'Raizal',
                    '2'=>'Afrocolombiano',
                    '3'=>'Indigena',
                    '4'=>"No Aplica"                     
                )))                 
->add('area_ensenanza_nombrado','choice',array(
    'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'Preescolar',
                    '2'=>'Primaria',
                    '3'=>'Ciencias Naturales y Educación Ambiental',
                    '4'=>"Ciencias Sociales",
                    '5'=>"Educ. Artistica - Artes plásticas",
                    "6"=>"Educ. Artistica - Música",
                    '7'=>"Educ. Artistica - Artes Escenica",
                    '8'=>"Educ. Artistica - Danzas",
                    "9"=>"Educ. Física, Recreación y Deporte",
                    "10"=>"Educ. Etica y en Valores",
                    '11'=>'Educ. Religiosa',
                    '12'=>'Humanidades y Lengua Castellana',
                    '13'=>'Idioma Extranjero Francés',
                    '14'=>"Idioma Extranjero Inglés",
                    '15'=>"Matemáticas",
                    "16"=>"Tecnología e Informática",
                    '17'=>"Ciencias Naturales Química",
                    '18'=>"Ciencias Naturales Física",
                    "19"=>"Filosofía",
                    "20"=>"Ciencias Económicas y Políticas",
                    '21'=>'Areas de Apoyo Para educación Especial',
                    '22'=>'No aplica'
                )))                                       
 ->add('area_ensenanza_tecnica','choice',array(
     'required'=>FALSE,
                'empty_value' => '             ',
                'choices'=>array(
                    '1'=>'Finanzas - Administración y Seguros',
                    '2'=>'Ventas y Servicios',
                    '3'=>'Ciencias Naturales y Aplicadas',
                    '4'=>"Salud",
                    '5'=>"Ciencias Sociales, Educación, Servicios Gubernamentales y Religión",
                    "6"=>"Cultura, Arte, Esparcimiento y Deporte",
                    '7'=>"Explotación Primaria y Extractiva",
                    '8'=>"Operadores del Equipo y Transporte Instalación y Mantenimiento",
                    "9"=>"Procesamiento, Fabricación y Ensamble",
                    "10"=>"Otras",
                    '11'=>'No aplica'
                )))                                       
           
            
            ->add('descripcion_otra_area')        

             ->add('foto_academica','file',array('required'=>FALSE))    
                                                ->getForm()
        ;

        //$deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
          //  $entity->setTipo($tipo_usuario);
               
            
            $file=$editForm['foto_academica']->getData();
            if($file){
               
                     $nombre_archivo= 'profesor'.$id;  
                      //$file->move(__DIR__.'/../../../../web/'.'uploads/documents',$nombre_archivo);
                     //$imagine = new \Imagine\Gd\Imagine();
                     //$image = $imagine->open($file);
                     //$thumbnail_mini = $image->thumbnail(new Box(50, 50));
                     //$thumbnail_mini->save(__DIR__.'/../../../../../web/'.'uploads/documents/mini'.$nombre_archivo.'.jpg');
                     //$thumbnail_strong = $image->thumbnail(new Box(135, 300));
                     //$thumbnail_strong->save(__DIR__.'/../../../../../web/'.'uploads/documents/strong'.$nombre_archivo.'.jpg');
                     $usuario=$entity->getUsuario();
                     $usuario->setEsFotoperfil(TRUE);
                     $em->persist($usuario);
                     
                     
                     
                     //$nombre_archivo= 'escudo_colegio'.$entity->getId();  
                     $entity->getFotoAcademica()->move(__DIR__.'/../../../../web/'.'uploads/documents',
                     $entity->getFotoAcademica()->getClientOriginalName());
                
                //$file->move(__DIR__.'/../../../../../web/'.'uploads/documents',$nombre_archivo);
                $imagen=$this->get('image.handling');
                $imagen->open(__DIR__.'/../../../../web/'.'uploads/documents/'.$entity->getFotoAcademica()->getClientOriginalName())
                         ->resize(140,150)
                         ->save(__DIR__.'/../../../../web/'.'uploads/documents/strong'.$nombre_archivo.'.png','png');
                $imagen->open(__DIR__.'/../../../../web/'.'uploads/documents/'.$entity->getFotoAcademica()->getClientOriginalName())
                                            ->resize(40,43)
                                            ->save(__DIR__.'/../../../../web/'.'uploads/documents/mini'.$nombre_archivo.'.png','png');
                                    
               
            }
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('profesor_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView() 
        );
    }
    /**
     * Edits an existing Profesor entity.
     *
     * @Route("/{id}/updateperfiladminfiltro", name="profesor_updateperfiladminfiltro")
     * @Method("post")
     * @Template()
     */
    public function updateperfiladminfiltroAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Profesor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Profesor entity.');
        }

        $editForm   = $this->createForm(new ProfesorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
           
            $file=$editForm['foto_academica']->getData();
            if($file){
                                $nombre_archivo= 'profesor'.$id;  
                                    //$file->move(__DIR__.'/../../../../web/'.'uploads/documents',$nombre_archivo);
                                    $imagine = new \Imagine\Gd\Imagine();
                                    $image = $imagine->open($file);
                                    $thumbnail_mini = $image->thumbnail(new Box(50, 50));
                                    $thumbnail_mini->save(__DIR__.'/../../../../../web/'.'uploads/documents/mini'.$nombre_archivo.'.jpg');
                                    $thumbnail_strong = $image->thumbnail(new Box(135, 300));
                                    $thumbnail_strong->save(__DIR__.'/../../../../../web/'.'uploads/documents/strong'.$nombre_archivo.'.jpg');
                                    $usuario=$entity->getUsuario();
                                    $usuario->setEsFotoperfil(TRUE);
                                    $em->persist($usuario);
                                    
               
            }
	 if($entity->getTipo()==1){
                //Rector
                $mi_rol=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Rol")->find(3);
            }
            if($entity->getTipo()==3){
                //Secretaria Auxiliar
                $mi_rol=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Rol")->find(4);
            }
            if($entity->getTipo()==2){
                //Profesor
                $mi_rol=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Rol")->find(2);
            }
			 if($entity->getTipo()==4){
                //Rector
                $mi_rol=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Rol")->find(3);
            }
			 if($entity->getTipo()==5){
                //Rector
                $mi_rol=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Rol")->find(3);
            }
			 if($entity->getTipo()==6){
                //Rector
                $mi_rol=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Rol")->find(3);
            }
	
            $usuario=$entity->getUsuario();
	    $roles_usuario=$usuario->getUserRol();	
	    $es_aplicable_rol=true;
	    foreach($roles_usuario as $rl){
		if($rl->getId()==$mi_rol->getId())
		    $es_aplicable_rol=false;
	    }	
            if($es_aplicable_rol)		
            	$usuario->addRol($mi_rol);
	    $em->persist($usuario);  	
             $em->persist($entity);
		
            
            $em->flush();
            return $this->redirect($this->generateUrl('profesor_editperfiladminfiltro', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Profesor entity.
     *
     * @Route("/{id}/delete", name="profesor_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();
        
         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:Profesor')->find($id);
            $usuario= $em->getRepository('NetpublicCoreBundle:Usuario')->findBy(array(
                "profesor"=>$id,
                "es_alumno" =>0
            ));
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Profesor entity.');
            }
            $em->remove($usuario[0]);
            $em->remove($entity);
            $em->flush();
            if($request->isXmlHttpRequest()){
                return new \Symfony\Component\HttpFoundation\Response("ok");
            }
        }

        return $this->redirect($this->generateUrl('profesor'));
    }
    /**
     * Obtenemos la disponibilidad Del Profesor en una Materia
     *
     * @Route("/{id_asignatura}/{id_profesor}/cargaacademica", name="profesor_cargaacademica")
     * 
     */
    public function cargaacademicaAction($id_asignatura,$id_profesor)
    {
        $request=  $this->getRequest();
        /*$horas_disp_profe_asignatura=$this->getDoctrine()
                                              ->getRepository("NetpublicCoreBundle:Profesor")
                                              ->getHoraDisponilesContratadas($id_profesor,$id_asignatura);
         * 
         */
        //Hras acpadas
         $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery('SELECT count(a) FROM NetpublicCoreBundle:CargaAcademica a WHERE a.asignatura=:asignatura_id AND a.profesor=:profesor_id')
                            ->setParameters(array(
                            "asignatura_id"=>$id_asignatura,                            
                            "profesor_id"=>$id_profesor    
                                )
                            );
            $count = $query->getSingleScalarResult();
        //Cntrat de prfesr en la asgnatra
        $contrato=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Contrato")->findOneBy(array(
                        'profesor_contrato'=>$id_profesor  ,
                        'asignatura'=>$id_asignatura
            ));
        $horas_disp_profe_asignatura=$contrato->getHorasBuffer()-($count+1);
        if($request->isXmlHttpRequest()){
            
            return new \Symfony\Component\HttpFoundation\Response($horas_disp_profe_asignatura);
        }                   
    }
        /**
     * Finds and displays a Alumno entity.
     *
     * @Route("/{id}/perfiladmin", name="profesor_perfiladmin")
     * @Template()
     */
    public function perfiladminAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $es_ajax=false;
        if($request->isXmlHttpRequest()){
            $es_ajax=true;
        }
        $entity = $em->getRepository('NetpublicCoreBundle:Profesor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alumno entity.');
        }
        $user = $this->get('security.context')->getToken()->getUser();
        $grupos_dir = $em->getRepository('NetpublicCoreBundle:Grupo')->findBy(array(
		"director_grupo"=>$id
		));
        if(($user->getEsAlumno()==FALSE)){            
            $session=$this->get('request')->getSession();
            $session->set('id_profesor_profesor',$entity->getId());
            
        }
        $deleteForm = $this->createDeleteForm($id);
        
        $carga_academicas=$entity->getCargaAcademica();
//Tiempo de entrega de peridos
        
        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
	    'grupos_dir' => $grupos_dir, 	
            'es_ajax' =>$es_ajax,            
            'carga_academicas'=>$carga_academicas,
            'id_profesor'=>$id
            
            );
    }

    private function pintarFilaAlumnoExcell($libro,$alumno_id,$periodo,$profesor_id,$asignatura_id,$fila,$columna_superior,$tipo){
        //$grupo_id=$alumno->getGrupo()->getId();
        $em=  $this->getDoctrine()->getEntityManager();
        $formula1_no_validad=0;
        $formula2_no_validad=1;
        $componentes=$em->getRepository("NetpublicCoreBundle:Grupo")->getNotasHijos($alumno_id,$profesor_id,$periodo, $asignatura_id);
        $formula_periodo_academico="";
        $ponderado_comp=0;
        $columna_periodo_academico=$columna_superior;
        $columnas_comp[]=array();
        //if(count($componentes)>0){
            //echo "Hola";
            $index2=0;
            foreach ($componentes as $componente) {
                $dim_comp=$componente->getDimension();
                $columna_superior--;
                if($dim_comp){
                if($dim_comp->getTipo()==4){                   
                    if($columna_superior>0){
                    $formula_periodo_academico=$formula_periodo_academico.$dim_comp->getPonderado().'*'.Util::getColumnaLetra($columna_superior).$fila.'+';
                    $ponderado_comp+=$dim_comp->getPonderado();
                    $columnas_comp[$index2]=$columna_superior;
                    Util::setBackgroundColor($libro,
                                  Util::getColorEstadares($index2),
                                  Util::getColumnaLetra($columna_superior).($fila)); 
                    $nroHijos=$em->getRepository("NetpublicCoreBundle:Dimension")
                                 ->getNroHijos($componente,$dim_comp->getProfesor(),$dim_comp->getAsignatura());
                   if($nroHijos==0){
                       $this->pintarExcell($libro, $columna_superior, $fila,$componente->getNota(),$tipo);
                
                   } 
                    $index2++;
                    }
                    
                    else{
                        $formula1_no_validad=1;
                    }
                }
                else{//Asistencia
                    if($columna_superior>0){
                    
                     Util::setBackgroundColor($libro,
                                  Util::getColorCompObligatorios(0),
                                  Util::getColumnaLetra($columna_superior).($fila));            
            
                    $this->pintarExcell($libro, $columna_superior, $fila,"$componente",$tipo);
                    }
                }
                }
            }
            if($columna_superior>0){
                    
             Util::setBackgroundColor($libro,
                                  Util::getColorCompObligatorios(1),
                                  Util::getColumnaLetra($columna_periodo_academico).($fila));            
            }
            $this->pintarExcell($libro, $columna_periodo_academico, $fila,'=('.$formula_periodo_academico.'0)/'.$ponderado_comp);
            
        $index=0;
        foreach ($componentes as $comp) {
            $dimension=$comp->getDimension();
            $items=$em->getRepository("NetpublicCoreBundle:Grupo")->getNotasHijos($alumno_id,$profesor_id,$dimension, $asignatura_id);
            if(count($items)>0  && $dimension->getTipo()==4){                
                $formula_componente="";
                $ponderado_total_item=0;
                foreach ($items as $item) {
                    if($columna_superior>0){
                    
                    $item_dim=$item->getDimension();
                    $columna_superior--;
                    $this->pintarExcell($libro, $columna_superior, $fila, "$item",$tipo);
                    Util::setBackgroundColor($libro,
                                  Util::getColorEstadares($index),
                                  Util::getColumnaLetra($columna_superior).($fila));            
            
                    $ponderado_total_item+=$item_dim->getPonderado();
                    $formula_componente=$formula_componente.$item_dim->getPonderado().'*'.Util::getColumnaLetra($columna_superior).$fila.'+';
                    }
                    else{
                        $formula2_no_validad=1;
                    }
                }            
                if($ponderado_total_item==0)
                    $ponderado_total_item=1;
              
                $this->pintarExcell($libro, $columnas_comp[$index], $fila,'=('.$formula_componente.'0)/'.$ponderado_total_item);               
                 $index++;
           }
          
        }
    }
//Pinta en cada hoja las notas de las asg
    private function pintarFilaNotasPeriodosAlumnoExcell($libro,$alumno_id,$periodo,$profesor_id,$asignatura_id,$fila,$columna_superior,$tipo){
        //$grupo_id=$alumno->getGrupo()->getId();
        $em=  $this->getDoctrine()->getEntityManager();
        
        $componentes=$em->getRepository("NetpublicCoreBundle:Grupo")->getNotaAlumnoPeriodos($alumno_id,$profesor_id,$periodo, $asignatura_id);
        $formula_periodo_academico="";
        $ponderado_comp=0;
        $columna_periodo_academico=$columna_superior;
        $columnas_comp[]=array();
        //if(count($componentes)>0){
            //echo "Hola";
            $index2=0;
            foreach ($componentes as $componente) {
                $dim_comp=$componente->getDimension();
                $columna_superior--;
                if($dim_comp){
                                                       
                    $formula_periodo_academico=$formula_periodo_academico.$dim_comp->getPonderado().'*'.Util::getColumnaLetra($columna_superior).$fila.'+';
                    $ponderado_comp+=$dim_comp->getPonderado();
                    $columnas_comp[$index2]=$columna_superior;
                    Util::setBackgroundColor($libro,
                                  Util::getColorEstadares($index2),
                                  Util::getColumnaLetra($columna_superior).($fila)); 
                                        $this->pintarExcell($libro, $columna_superior, $fila,$componente->getNota(),$tipo);
                    $index2++;
                }
            }
    }

//endPintar    
    private function pintarFilaIDAlumnoExcell($libro,$alumno_id,$periodo,$profesor_id,$asignatura_id,$fila,$columna_superior){
        //$grupo_id=$alumno->getGrupo()->getId();
        $em=  $this->getDoctrine()->getEntityManager();
        $nota_periodo=$em->getRepository("NetpublicCoreBundle:Grupo")->getNotaPeriodo(
                $alumno_id,$periodo, $asignatura_id);
        
        $componentes=$em->getRepository("NetpublicCoreBundle:Grupo")->getNotasHijos($alumno_id,$profesor_id,$periodo, $asignatura_id);
        $columna_periodo_academico=$columna_superior;
            foreach ($componentes as $componente) {
                $columna_superior--; 
                $this->pintarExcell($libro, $columna_superior, $fila,$componente->getId());
                Util::setColor($libro,'FFFFFF', Util::getColumnaLetra($columna_superior).($fila));
                      
                
            }
            if($nota_periodo)
              $this->pintarExcell($libro, $columna_periodo_academico, $fila,$nota_periodo->getId());
            else
              $this->pintarExcell($libro, $columna_periodo_academico, $fila,"error");  
              Util::setColor($libro,'FFFFFF', Util::getColumnaLetra($columna_periodo_academico).($fila));
        foreach ($componentes as $comp) {
            $dimension=$comp->getDimension();
            $items=$em->getRepository("NetpublicCoreBundle:Grupo")->getNotasHijos($alumno_id,$profesor_id,$dimension, $asignatura_id);
                
                foreach ($items as $item) {
                    $columna_superior--;
                    $this->pintarExcell($libro, $columna_superior, $fila, $item->getId());
                    Util::setColor($libro,'FFFFFF', Util::getColumnaLetra($columna_superior).($fila));
                }            
            
        }
    }
    
        private function pintarLineaNombresExcell($libro,$alumno_id,$periodo,$profesor_id,$asignatura_id,$fila,$columna_superior,$tipo=1){
        //$grupo_id=$alumno->getGrupo()->getId();
        $em=  $this->getDoctrine()->getEntityManager();
        
        $componentes=$em->getRepository("NetpublicCoreBundle:Grupo")->getNotasHijos($alumno_id,$profesor_id,$periodo, $asignatura_id);
        $columna_periodo_academico=$columna_superior;
            foreach ($componentes as $componente) {
                $dim_comp=$componente->getDimension();
                $columna_superior--; 
                $this->pintarExcell($libro, $columna_superior, $fila,"$dim_comp",$tipo);
            }
            $this->pintarExcell($libro, $columna_periodo_academico, $fila,"$periodo");
        foreach ($componentes as $comp) {
            $dimension=$comp->getDimension();
            $items=$em->getRepository("NetpublicCoreBundle:Grupo")->getNotasHijos($alumno_id,$profesor_id,$dimension, $asignatura_id);
            foreach ($items as $item) {
                    $item_dim=$item->getDimension();
                    $columna_superior--;
                    $this->pintarExcell($libro, $columna_superior, $fila,"$item_dim",$tipo); 
            }            
                              
       }
       return 0;   
   }
        private function getColumnaSuperior($alumno_id,$periodo,$profesor_id,$asignatura_id){
        //$grupo_id=$alumno->getGrupo()->getId();
        $em=  $this->getDoctrine()->getEntityManager();
        
        $componentes=$em->getRepository("NetpublicCoreBundle:Grupo")->getNotasHijos($alumno_id,$profesor_id,$periodo, $asignatura_id);
        $resultado=  count($componentes);
        foreach ($componentes as $comp) {
            $dimension=$comp->getDimension();
            $items=$em->getRepository("NetpublicCoreBundle:Grupo")->getNotasHijos($alumno_id,$profesor_id,$dimension, $asignatura_id);
            $resultado+=count($items);                    
       }
       return $resultado;   
   }
    

    private function pintarExcell($libro,$columna,$fila,$valor,$tipo=1){
        if($columna>0 && $fila>0){
        if($tipo==1)
           $libro->getActiveSheet()                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                       ->setCellValueByColumnAndRow($columna,$fila,$valor);
        if($tipo==0)
           $libro->getActiveSheet()                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                       ->setCellValueByColumnAndRow($columna,$fila,"  ");
        }
    }
    private function pintarTodasPlanillas($libro,$carga_academica,$colegio,$periodo,$profesor,$tipo) {
        $xls_service=$libro;
        $hoja=0;
        $xls_service->setActiveSheetIndex($hoja);         
        
        foreach ($carga_academica as $ca) { 
                 $this->pintarPlanilla($xls_service,$ca,$colegio,$periodo,$tipo);
                 $hoja++;   
                 $xls_service->createSheet();
                 $xls_service->setActiveSheetIndex($hoja);
                
        }
        $xls_service->setActiveSheetIndex(0);    
            
        $nombre_archivo=  "planillaParaCalificarEnCasa_".Util::getSlug("$profesor","_").'_'.Util::getSlug("$periodo","_");
        $writer = $this->get('phpexcel')->createWriter($xls_service, 'Excel5');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
       
        
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', "attachment;filename=$nombre_archivo.xls");
        return $response;
    }
    private function pintarPlanilla($libro,\Netpublic\CoreBundle\Entity\CargaAcademica $ca,$colegio,$periodo,$tipo) {
         $em=  $this->getDoctrine()->getEntityManager();   
         $xls_service=$libro;        
            $profesor_id=$ca->getProfesor()->getId();
            $asignatura_id=$ca->getAsignatura()->getId();            
            $fila_inicio=10;        
            $xls_service->getActiveSheet()                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                          ->setCellValueByColumnAndRow(0, $fila_inicio,"#");
            $xls_service->getActiveSheet()                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                          ->setCellValueByColumnAndRow(1, $fila_inicio,"Nombre Completo");
            $xls_service->getActiveSheet()
                          ->getColumnDimension('A')->setWidth(5);
            $xls_service->getActiveSheet()
                          ->getColumnDimension('B')->setWidth(40);
            $xls_service->getActiveSheet()      
                 ->getStyle("B6:B9")->getFont()->setSize(8);
            Util::setColor($xls_service, "FFFFFF",'B1:B3');
            Util::setColor($xls_service, "FFFFFF",'A1:A3');
            Util::setColor($xls_service, "FFFFFF",'C1:C3');
            
            $xls_service->getActiveSheet()                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                          ->setCellValueByColumnAndRow(0,1,"id_cargaacademica");
            $xls_service->getActiveSheet()                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                          ->setCellValueByColumnAndRow(0,2,"{$ca->getId()}");
            $xls_service->getActiveSheet()                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                          ->setCellValueByColumnAndRow(1,1,"length_principal");
            $xls_service->getActiveSheet()      
                 ->getStyle("D3")->getFont()->setSize(20);
            $xls_service->getActiveSheet()      
                 ->getStyle("E4:E6")->getFont()->setSize(10);
            
            $xls_service->getActiveSheet()                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                          ->setCellValueByColumnAndRow(3,3,"$colegio");
            $xls_service->getActiveSheet()
            ->getRowDimension(3)->setRowHeight(30);
            $xls_service->getActiveSheet()                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                          ->setCellValueByColumnAndRow(4,4,"Aprobada Medianta resolución. ".$colegio->getNumeroLincFunc());
            $xls_service->getActiveSheet()                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                          ->setCellValueByColumnAndRow(4,5,"NIT: ".$colegio->getFax()." DANE: ".$colegio->getCodigoDane());
            $xls_service->getActiveSheet()                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                          ->setCellValueByColumnAndRow(4,6,"PLANILLA DEL PROCESO DE DESARROLLO INTELECTUAL DEL ESTUDIANTE ".$periodo->getPadre());
            $xls_service->getActiveSheet()                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                          ->setCellValueByColumnAndRow(1,6,"AÑO ESCOLAR/PERIODO ACADEMICO: ".$periodo->getPadre()."/".$periodo);
$xls_service->getActiveSheet()                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                          ->setCellValueByColumnAndRow(1,7,"GRADO/GRUPO: ".$ca->getGrupo()->getGrado()."/".$ca->getGrupo());
$xls_service->getActiveSheet()                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                          ->setCellValueByColumnAndRow(1,8,"ASIGNATURA/PROFESOR: ".$ca->getAsignatura()."/".$ca->getProfesor());
                        
                $alumnos=array();
                $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
                if($ca->getAnoEscolar()){
                    $m_as=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findBy(array(
                        'grupo'=>$ca->getGrupo()->getId(),
                        'ano'=>$ca->getAnoEscolar()->getId()
                    ));
                    foreach ($m_as as $m_a) {
                        $alumnos[]=$m_a->getAlumno();
                    }
                }
                else{
                $alumnos=$em->getRepository("NetpublicCoreBundle:Alumno")->findBy(array(
                        'grupo'=>$ca->getGrupo()->getId()
                    ));
                }
            $xls_service->getActiveSheet()                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                          ->setCellValueByColumnAndRow(2,1,"id_periodo");
            $xls_service->getActiveSheet()                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                          ->setCellValueByColumnAndRow(2,2,"{$periodo->getId()}");
            
                  
          if(count($alumnos)>0){  
          $l=$columna_superior=$this->getColumnaSuperior($alumnos[0]->getId(),$periodo,$profesor_id,$asignatura_id)+2; 
          if(!($columna_superior>0)){
              $l=0;;
              $columna_superior=0;
          }
            $xls_service->getActiveSheet($l)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                          ->setCellValueByColumnAndRow(1,2,"$l");
          
                $this->pintarLineaNombresExcell($xls_service,$alumnos[0]->getId(),$periodo,$profesor_id,$asignatura_id,$fila_inicio,$columna_superior);        
          }
                $nro_alumnos=1; 
                foreach ($alumnos as $alumno) {
                       $fila_inicio++;
                       $this->pintarExcell($xls_service, 0, $fila_inicio,$nro_alumnos);
                       $this->pintarExcell($xls_service, 1, $fila_inicio,"$alumno");                       
                     $this->pintarFilaAlumnoExcell($xls_service,$alumno->getId(),$periodo,$profesor_id,$asignatura_id,$fila_inicio,$columna_superior,$tipo);
                     $this->pintarFilaIDAlumnoExcell($xls_service,$alumno->getId(),$periodo,$profesor_id,$asignatura_id,$fila_inicio,2*$columna_superior-1);
                     $nro_alumnos++;
                 }         
                 $xls_service->getActiveSheet()->setTitle(substr("{$ca->getAsignatura()}-{$ca->getGrupo()})",0,28));
       

        
    }
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
