<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\Grupo;
use Netpublic\CoreBundle\Form\GrupoType;
use Symfony\Component\HttpFoundation\Request;
use Netpublic\CoreBundle\Entity\Alumno;
use Netpublic\CoreBundle\Entity\Dimension;
use Netpublic\CoreBundle\Entity\AlumnoDimension;
use Netpublic\CoreBundle\Form\Type\AlumnodimensionType;
use Netpublic\CoreBundle\Form\AlumnoType;
use Netpublic\CoreBundle\Entity\Usuario;
use Netpublic\CoreBundle\Entity\Rol;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Netpublic\CoreBundle\Form\AlumnoperfilType;
use Netpublic\CoreBundle\lib\CustomController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Netpublic\CoreBundle\Entity\MatriculaAlumno;
use Ps\PdfBundle\Annotation\Pdf;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityRepository;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Gd\Imagine;
use Netpublic\CoreBundle\Util\Util;


/**
 * Grupo controller.
 *
 * @Route("/grupo")
 */
class GrupoController extends Controller
{
        /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/{tipo}/buscar.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|json|pdf"}, name="grupo_buscar")     
     * @Template()
     */
    public function buscarAction($tipo){
        $request = $this->getRequest();        
        $em=  $this->getDoctrine()->getManager();
        $key=  Util::getSlug($request->get("query"),"");
        $query="SELECT g FROM NetpublicCoreBundle:Grupo g";
        $query.=" WHERE ( g!=0 ";
        if($request->get('grado')!='*' && $request->get('grado')!=""){
            $query.=" AND g.grado=:grado_id";        
        }
        
        if($request->get('grupo')!='*' && $request->get('grupo')!=""){
            $query.=" AND g=:grupo_id";        
        }
        $query.=" )"; 
        
        $dql=  $em->createQuery($query);
        if($request->get('key')!='*' && $request->get('key')!=""){
                $dql->setParameter("key",'%'.$key.'%');
        }
        
        if($request->get('grado')!='*' && $request->get('grado')!=""){
            $dql=$dql->setParameter('grado_id',$request->get('grado'));        
        }
        if($request->get('grupo')!='*' && $request->get('grupo')!=""){
            $dql=$dql->setParameter('grupo_id',$request->get('grupo'));      
        }
        $usuarios=$dql->getResult();      
        return array(
          'usuarios'=>$usuarios,
          'tipo'=>$tipo
      );
    }
      /**
     * Lists all Grupo entities.
     *
     * @Route("/{grupo_id}/alumnos", name="grupo_alumnos")
     * @Template()
     */
    public function alumnosAction($grupo_id)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $rs_json=array();
        $alumnos =$em->getRepository("NetpublicCoreBundle:Alumno")->findBy(array(
            'grupo'=>$grupo_id
        ));
        foreach ($alumnos as $alumno) {
            $rs_json[]=array(
                'id'=>$alumno->getId(),
                'nombre'=>$alumno->getNombre()
                 );
        }
        return new Response(json_encode($rs_json));
    }

        /**
     * Lists all Grupo entities.
     * 
     *  
     * @Route("/{grupo_id}/imprimirboletinesgrupo.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|xls|pdf"}, name="grupo_imprimirboletinesgrupo")
     *
     * @Template()
     *  
     */
    public function imprimirboletinesgrupoAction($grupo_id)
    {
         set_time_limit(0);
         ini_set('memory_limit', '-1');    
        $em=  $this->getDoctrine()
                   ->getEntityManager();
        $request=$this->getRequest();
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
        $periodos_escolares=$em
                ->createQuery("SELECT a FROM NetpublicCoreBundle:Dimension a WHERE a.id<=:id and a.tipo=1 and a.padre=:padre")                
                ->setParameters(array(
                    'padre'=>$padre->getId(),
                    'id'=>$periodo_activo->getId()
                ))->getResult(); 
        
        
        $alumnos=$em->getRepository("NetpublicCoreBundle:Alumno")->findBy(array(
            'grupo'=>$grupo_id
        ));      
        
        $asignaturas_a=array();        
        $id_plantilla_alumnos=array();
        $observaciones=array();
        $alumnos_datos=array();
        foreach ($alumnos as $alumno) {            
                $grado=$alumno->getGrado();
                $areas=  $this->getDoctrine()
                       ->getRepository("NetpublicCoreBundle:Asignatura")
                       ->findBy(array(
                           'grado'=>$grado->getId(),
                           'es_area'=>1
                       ));        
         $n_e=$grado->getNivelesEducativo();        
        //Presescoar
        if($n_e==1){            
            $id_plantilla=$colegio->getPlantillaBoletinPreescolar();
        }
        //Bascia Primarai
        elseif($n_e==2){
            $id_plantilla=$colegio->getPlantillaBoletinBasicaPrimaria();            
        }
        //Bascia Secunadaria
        elseif($n_e==3){
            $id_plantilla=$colegio->getPlantillaBoletinBasicaSecundaria();
        }
        //Media
        elseif($n_e==4){
            $id_plantilla=$colegio->getPlantillaBoletinMedia();
        }
        else{
            $id_plantilla=2;
        } 
        
        $observaciones= $this->getDoctrine()
                          ->getRepository("NetpublicCoreBundle:Observacion")
                          ->findBy(array(
                              'alumno'=>$alumno->getId(),
                              'periodo'=>$periodo_activo->getId()
                          ))
                ;
        $grupo_id=$alumno->getGrupo()->getId();
        $nro_alum_grupo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")
                            ->getNroAlumnosGrupo($grupo_id);
        $promedio_grupo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")
        ->getPromedioGrupo($grupo_id,$periodo_activo);
        $promedio_alumno=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")
        ->getPromedioAlumnoGrupo($alumno,$periodo_activo);
        $alumnos_datos[]=array("datos"=>$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")
                            ->getDatosAlumnoImpresion(
                                    $alumno,
                                    $areas,
                                    $periodos_escolares,
                                    $colegio,
                                    $periodo_activo),
                                    "alumno"=>$alumno,
                                    "plantilla"=>$id_plantilla,
                                    "observaciones"=>$observaciones,
                                    "nro_alumnos_grupo"=>$nro_alum_grupo,
                                    "promedio_grupo"=>$promedio_grupo,
                                    "promedio_alumno"=>$promedio_alumno
                );

            
            
           
        }
        $consulta = $em->createQuery("
                                    SELECT u,u_r FROM NetpublicCoreBundle:Usuario u
                                    JOIN u.user_rol u_r
                                    WHERE u_r.role='ROLE_RECTOR'
                                    "); 
        $rectores=$consulta->getResult();
        $format = $request->get('_format');
        
        
        return  $this->render(sprintf("NetpublicCoreBundle:Alumno:imprimirboletines.%s.twig", $format),array(        
          
          'periodo_escolares'=> $periodos_escolares,          
          'colegio'=>$colegio,                              
          "periodo_escolar_activo"=>$periodo_activo,
          "periodos_escolares"=>$periodos_escolares,  
          "ano_escolar_activo"=>$padre,
          "asignaturas_a"=>$asignaturas_a,                  
          'alumnos_datos'=>$alumnos_datos,
          'rectores'=>$rectores
        ));                  

        
    }
    /**
     * Lists all Grupo entities.
     *
     * @Route("/{grado_id}/{tipo}/grupostree", name="grupo_grupostree")
     * @Template()
     */
    public function grupostreeAction($grado_id,$tipo)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $grupos=$em->getRepository("NetpublicCoreBundle:Grupo")->findBy(array(
            'grado'=>$grado_id
        ));
        return array(
            'grupos' => $grupos,
            'tipo'=>$tipo
            );
    }
    /**
     * Lists all Grupo entities.
     *
     * @Route("/{grado_id}/{tipo}/grupostreetipo", name="grupo_grupostreetipo")
     * @Template()
     */
    public function grupostreetipoAction($grado_id,$tipo)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $grupos=$em->getRepository("NetpublicCoreBundle:Grupo")->findBy(array(
            'grado'=>$grado_id
        ));
        return array(
            'grupos' => $grupos,
            );
    }

    /**
     * Lists all Grupo entities.
     *
     * @Route("/", name="grupo")
     * @Template()
     */
    public function indexAction()
    {
        $es_ajax=false;
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $entities = $em->getRepository('NetpublicCoreBundle:Grupo')->findAll();
        $delete_form=array();
        foreach ($entities as $e) {
            $delete_form[] = $this->createDeleteForm($e->getId())->createView();
        }
        if($request->isXmlHttpRequest()){
            $es_ajax=true;
        }
        return array(
            'entities' => $entities,
            "es_ajax" =>$es_ajax,
            "delete_form" =>$delete_form            
            );
    }
     /**
     * Lists all Grupo entities.
     *
     * @Route("/{id_grado}/{nro_item}/getgrupocriteriopromocion", name="grupo_getgrupocriteriopromocion")
     * @Template()
     */
    public function getgrupocriteriopromocionAction($id_grado,$nro_item)
    {
        $es_ajax=false;
        $em = $this->getDoctrine()->getEntityManager();        
        $grupos = $em->getRepository('NetpublicCoreBundle:Grupo')->findBy(
                array(
                    'grado'=>$id_grado
                )
                );
        
        return array(
            'grupos' => $grupos,
            "nro_item" =>$nro_item            
            );
    }
     /**
     * Lists all Grupo entities.
     *
     * @Route("/directoragrupo", name="grupo_directoragrupo")
     * @Template()
     */
    public function directoragrupoAction()
    {
        $es_ajax=false;
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $entities = $em->getRepository('NetpublicCoreBundle:Grupo')->findAll();
        $delete_form=array();
        foreach ($entities as $e) {
            $delete_form[] = $this->createDeleteForm($e->getId())->createView();
        }
        if($request->isXmlHttpRequest()){
            $es_ajax=true;
        }
        return array(
            'entities' => $entities,
            "es_ajax" =>$es_ajax,
            "delete_form" =>$delete_form            
            );
    }
    
        /**
     * Displays a form to edit an existing Grupo entity.
     *
     * @Route("/{id}/editdirectoragrupo", name="grupo_editdirectoragrupo")
     * @Template()
     */
    public function editdirectoragrupoAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $entity = $em->getRepository('NetpublicCoreBundle:Grupo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Grupo entity.');
        }
        $es_ajax=false;
        $editForm = $this->createForm(new GrupoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        $es_ajax=false;
        if($request->isXmlHttpRequest()){
            $es_ajax=true;
        }
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'es_ajax' => $es_ajax
        );
    }

    
    /**
     * Calificar grupos de las institucion
     *
     * @Route("/grupo_getinputfocus", name="grupo_getinputfocus")
     * 
     */
    public function getinputfocusAction(){
        $session=$this->get('request')->getSession();
        return new Response($session->get('nodo_activo_focus'));
    }
    /** Lists all Grupo entities.
     *
     * @Route("/{id_grupo}/profesores", name="grupo_profesores")
     * @Template()
     */
    public function profesoresAction($id_grupo)
    {
        $carga_academica=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
            'grupo'=>$id_grupo,
            'es_carga_academica'=>TRUE
        ));
        
        return array(
            'carga_academica' => $carga_academica

            );
    }   
    /**
     * Calificar grupos de las institucion
     *
     * @Route("/{nodo_activo_focus}/grupo_setinputfocus", name="grupo_setinputfocus")
     * 
     */
    public function setinputfocusAction($nodo_activo_focus){
        $session=$this->get('request')->getSession();
        $session->set('nodo_activo_focus',nodo_activo_focus);
        return new Response("ok");
        
    }
 /**
     * Calificar grupos de las institucion
     *
     * @Route("/calificarr", name="grupo_calificarr")
     * @Template()
     */
    public function calificarrAction(){
        
        //Verificamos que este dentro de la 
        $request=  $this->getRequest();
        $session=$request->getSession();
        
        $grupo_id=$session->get('grupo_id');
        $asignatura_id=$session->get('asignatura_id');                     
        $em=  $this->getDoctrine()->getEntityManager();
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
        
        $dim_periodo_escolar=array(); 
		$colegio=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")
                      ->findOneBy(array(
                          'es_principal'=>1                        
                      ));
        $ano_escolar_activo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                      ->findAnoEscolarActivo();
                
        //Peridos escolares de una año
        //Carga academica
         $dim_periodo_escolar=array();
         //Peridos escolares de una año
        $periodos=array();
        
            
        //Carga academica
        $user = $this->get('security.context')->getToken()->getUser();
        $grupo_asignatura=array();
        $dim_temporal_tem=array();
        $re="";
        $nro_alumnos_adicionados=0;   
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor();            
            $id_profesor=$profesor->getId(); 
              
            $grupo_asignatura=$this->getDoctrine()->getRepository('NetpublicCoreBundle:CargaAcademica')->getAsignaturaGrupo($id_profesor);           
            //foreach ($periodos as $periodo) {
                            $dim_periodo_escolar=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
                            'padre'=>$padre_p->getId(),
                            'profesor'=>$id_profesor,
                        //    'asignatura'=> $asignatura_id,
                            'tipo'=>4    
                        ));
                        $ids_grupos=array();    
                        for ($index = 0; $index < count($grupo_asignatura); $index++) {
                                 $ids_grupos[$index]=$grupo_asignatura[$index]->getGrupo()->getId();
                       
                        }                           
            foreach ($grupo_asignatura as $ga) {
                 $nro_adicione_grupo=  $this->getDoctrine()
                                            ->getRepository("NetpublicCoreBundle:Alumno")
                                            ->getNroAlumnosAdicionados($ga->getGrupo()->getId())    
                         ;
                 $nro_alumnos_adicionados=$nro_alumnos_adicionados+$nro_adicione_grupo;
            }               
                 
        } 
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
        
        return array(        
        
        //'asignatura_filtro'=>$asignatura_id,        
        'dim_periodo_escolar'=>$dim_periodo_escolar,       
        'grupo_asignatura'=>$grupo_asignatura,
        'periodo'=>$periodo,
        "session_grupo_id"=>$grupo_id,
        "session_asignatura_id"=>$asignatura_id,
        "session_periodo_id"=>$periodo_id,
	'colegio'=>$colegio,
        'nota_maxima'=>$nota_maxima,
        'nota_minima'    =>$nota_minima,
        'ano_escolar_activo'=>$ano_escolar_activo,    
        'nro_alumnos_adicionados'=>$nro_alumnos_adicionados,
        'periodo_activo'=>$padre_p    
            
        
        );                  

    }
         /**
     * Edits an existing Grado entity.
     *
     * @Route("/copiarfallas", name="grupo_copiarfallas")     * 
     * @Template()
     */
    public function copiarfallasAction()            
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $grupo_asignatura=  $this->getRequest()->get("data");                
        if($grupo_asignatura!='*'){
            $vector_data=explode(';', $grupo_asignatura);
            $grupo=$vector_data[0];
            $asg_remitente=$vector_data[1];
            $periodo_id=$vector_data[2];
        }
        $user = $this->get('security.context')->getToken()->getUser();        
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor();            
            $profesor_id=$profesor->getId();
        }
        $periodo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);
        $asignaturas_grupo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:CargaAcademica")
                                  ->getAsignaturaCargaAcademica($profesor_id,$grupo);
        $alumnos_remitente=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")->findBy(
            array('grupo'=>$grupo),
            array("apellido"=>'ASC')
        );
        for ($index1 = 0; $index1 < count($asignaturas_grupo); $index1++) {
            
              for ($index = 0; $index < count($alumnos_remitente); $index++) {
                    $e_destino=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Grupo")
                        ->findFallasAlumnoAsignaturaProfesor($alumnos_remitente[$index]->getId(),$periodo, $asignaturas_grupo[$index1]->getAsignatura()->getId());
                    $e_remitente=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Grupo")
                        ->findFallasAlumnoAsignaturaProfesor($alumnos_remitente[$index]->getId(),$periodo, $asg_remitente);
                for ($index3 = 0; $index3 < count($e_destino); $index3++) {
                    $e_destino[$index3]->setNota($e_remitente[$index3]->getNota());
                    $em->persist($e_destino[$index3]);
                }

               }
        }
        $em->flush();
        return new Response("ok");
    }
     /**
     * Edits an existing Grado entity.
     *
     * @Route("/copiarplanilla", name="grupo_copiarplanilla")     * 
     * @Template()
     */
    public function copiarplanillaAction()            
            
    {
        $request=  $this->getRequest();
        $em=  $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.context')->getToken()->getUser();  
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor();            
            $profesor_id=$profesor->getId();
        }

        $periodo_id=$request->get('periodo_id');
        $periodo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);
        $carga_destinos=  json_decode($request->get('carga_ids_destino'));
        $carga_fuente_id=$request->get('carga_id_fuente');
        $carga=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($carga_fuente_id);
        $alumnos=$em->getRepository("NetpublicCoreBundle:Alumno")->findBy(array(
            'grupo'=>$carga->getGrupo()->getId()
        ));
        for ($index2 = 0; $index2 < count($carga_destinos); $index2++) {
            $carga_destino=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($carga_destinos[$index2]);
            for ($index3 = 0; $index3 < count($alumnos); $index3++) {
                $e_remitente=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Grupo")
                            ->findNotaAlumnoAsignaturaProfesor($alumnos[$index3]->getId(),$profesor_id,$periodo,$carga->getAsignatura()->getId());
                $e_destino=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Grupo")
                            ->findNotaAlumnoAsignaturaProfesor($alumnos[$index3]->getId(),$profesor_id,$periodo,$carga_destino->getAsignatura()->getId());
            
                for ($index = 0; $index < count($e_remitente); $index++) {
                   $e_remitente_items=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Grupo")
                            ->findNotaAlumnoAsignaturaProfesor($alumnos[$index3]->getId(),$profesor_id,$e_remitente[$index]->getDimension(),$carga->getAsignatura()->getId());
                   $e_destino_items=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Grupo")
                            ->findNotaAlumnoAsignaturaProfesor($alumnos[$index3]->getId(),$profesor_id,$e_destino[$index]->getDimension(),$carga_destino->getAsignatura()->getId());
                    for ($index1 = 0; $index1 < count($e_remitente_items); $index1++) {
                        //echo "-{$e_remitente_items[$index1]}-{$e_remitente_items[$index1]->getDimension()}\n";
                        //echo "-{$e_destino_items[$index1]}-{$e_destino_items[$index1]->getDimension()}\n"; 
                        $e_destino_items[$index1]->setNota($e_remitente_items[$index1]->getNota());
                        $em->persist($e_destino_items[$index1]);
                    }
                    $e_destino[$index]->setNota($e_remitente[$index]->getNota());
                    $em->persist($e_destino[$index]);
                }
            }
            $em->flush();
        }
         //$em->flush();
        
       return new Response("ok"); 
        
    }
    /**
     * Edits an existing Grado entity.
     *
     * @Route("/calificareditar", name="grupo_calificareditar")
     * @Method("post")
     * @Template()
     */
    public function calificareditarAction()
    {
        $session=$this->get('request')->getSession();
        $em=  $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $colegio=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")
                      ->findOneBy(array(
                          'es_principal'=>1                        
                      ));	
        
        if(($user->getEsAlumno()==FALSE)){
            $profesor_id=$user->getProfesor()->getId();            
         }	
		
        $grupo_id=$session->get('grupo_id');
        $asignatura_id=$session->get('asignatura_id');                     
        $periodo_id=$session->get('perido_id');
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                               ->findAnoEscolarActivo();
        
        $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                                ->findPeriodoEscolarActivo();
        
        $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
        $periodo_activo_s=$session->get("perido_id",$periodo_activo->getId());
        $periodo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_activo_s);
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($ano_escolar_id_s);
        
        if($periodo->getTipo()==4){
            $padre=$periodo->getPadre();
        }
        else{
            $padre=$periodo;
        }
        $tiene_tiempo_aun=$em->getRepository("NetpublicCoreBundle:Profesorperiodoentrega")
                             ->tieneTiempoProfesor($padre->getId(),$profesor_id);
        
        //$alumnos=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findAlumnos($ano_escolar_activo->getId(),$grupo_id);
        //$entities=$em->getRepository("NetpublicCoreBundle:Grupo")->findNotasPeriodoEscolar($alumnos,$periodo_id,$asignatura_id);
        $alumnos=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findAlumnosGrupo($ano_escolar_id_s,$grupo_id);
        if(!count($alumnos)){
            $alumnos=$em->getRepository("NetpublicCoreBundle:Alumno")->findBy(array(
                'grupo'=>$grupo_id
            ));
        }
        $entities=$em->getRepository("NetpublicCoreBundle:Grupo")->findNotasPeriodoEscolar($alumnos,$periodo_id,$asignatura_id);
        
        
        $editForm=array();
        $ids=array();
        for ($index = 0; $index < count($entities); $index++) {
            $editForm__=array();
            foreach ($entities[$index] as $entity) {
                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Grado entity.');
                }   
                $es_hija_periodo=false;
                if($periodo->getId()==$entity->getDimension()->getId()){
                        $es_hija_periodo=TRUE;
                }
                $editForm__[] = $this->createForm(new AlumnodimensionType($entity->getId(),$entity->getDimension()->getTipo(),$es_hija_periodo,$entity->getAlumno()->getId(),$tiene_tiempo_aun), $entity)->createView();
                $ids[]=array('id'=>$entity->getId());
            }
            $editForm[]=$editForm__;
        }        
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
        return array(        
        'alumnos' => $alumnos,               
        'entities'      => $entities,
        'edit_forms'   => $editForm,
        'ids'=>$ids,
        'dimension_final'=>$periodo,
        'nota_maxima'=>$nota_maxima,
        'nota_minima'    =>$nota_minima,
        'ready_only'=>$tiene_tiempo_aun,
        'asignatura_id'=>$asignatura_id,
        'grupo_id'=>$grupo_id,
         'alumnos'=>$alumnos      
            
        
        );                
        
    }


    /**
     * Edits an existing Grado entity.
     *
     * @Route("/calificaradicioneseditar", name="grupo_calificaradicioneseditar")
     * @Method("post")
     * @Template()
     */
    public function calificaradicioneseditarAction()
    {
        $session=$this->get('request')->getSession();
        $em=  $this->getDoctrine()->getEntityManager();
	$user = $this->get('security.context')->getToken()->getUser();
        $colegio=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")
                      ->findOneBy(array(
                          'es_principal'=>1                        
                      ));	
        
        if(($user->getEsAlumno()==FALSE)){
            $profesor_id=$user->getProfesor()->getId();            
         }   
		
		
		
		
		
        $grupo_id=$session->get('grupo_id');
        $asignatura_id=$session->get('asignatura_id');                     
        $periodo_id=$session->get('perido_id');
        $periodo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);      
         $tiene_tiempo_aun=$em->getRepository("NetpublicCoreBundle:Profesorperiodoentrega")
                             ->tieneTiempoProfesor($periodo_id,$profesor_id);
       
        $alumnos_r=array();
        $alumnos=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")->findBy(
            array(                
                'es_adicion'=>1
                ),
            array("apellido"=>'ASC')
        );            
        $entities = array();
        $es_solo_nota_final=0;               
        foreach ($alumnos as $alumno) {
            //vaciamos los ids de asignatuas
            $grado_id=$alumno->getGrado()->getId();
            $asignaturas=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Asignatura")->findBy(array(
                'es_area'=>0,
                'grado'=>$grado_id
            ));
            $ids_asg=array();
            for ($index1 = 0; $index1 < count($asignaturas); $index1++) {
                $ids_asg[$index1]=$asignaturas[$index1]->getId();
            }
            $ca_profe=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:CargaAcademica")->getAsignaturaCargaAcademica($profesor_id,$alumno->getGrupo()->getId());
            foreach ($ca_profe as $ca) {
                $asignatura_id=$ca->getAsignatura()->getId();
                if(in_array($asignatura_id, $ids_asg)){
                      $nota=  $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Grupo")
                               ->findNotaAlumnoAsignaturaProfesor($alumno->getId(),$profesor_id,$periodo, $asignatura_id);
                      $entities[]=$nota;
                      $alumnos_r[]=$alumno;
                }
            }
          }
        
        $editForm=array();
        $ids=array();
        for ($index = 0; $index < count($entities); $index++) {
            $editForm__=array();
            foreach ($entities[$index] as $entity) {
                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Grado entity.');
                }   
                $es_hija_periodo=false;
                if($periodo->getId()==$entity->getDimension()->getId()){
                        $es_hija_periodo=TRUE;
                }
                $editForm__[] = $this->createForm(new AlumnodimensionType($entity->getId(),$entity->getDimension()->getTipo(),$es_hija_periodo,$alumnos_r[$index]->getId(),$tiene_tiempo_aun), $entity)->createView();
                $ids[]=array('id'=>$entity->getId());
            }
            $editForm[]=$editForm__;
        }        
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
        return array(        
        'alumnos' => $alumnos_r,               
        'entities'      => $entities,
        'edit_forms'   => $editForm,
        'ids'=>$ids,
        'dimension_final'=>$periodo,
        'es_solo_nota_final'=>$es_solo_nota_final,
        'nota_maxima'=>$nota_maxima,
        'nota_minima'    =>$nota_minima
        
        );                
        
    }



    /**
     * Edits an existing Grado entity.
     *		
     * @Route("/calificarrupdate", name="grupo_calificarrupdate")
     * @Method("post")
     * @Template()
     */
    public function calificarrupdateAction()
    {
        
        $request = $this->getRequest();
        
        $jsm_values=str_replace('_nota','',  $request->get('values'));
        $jsm=str_replace("'",'', $jsm_values);		
        $values=json_decode($jsm);        
	$jsm=str_replace('"','',  $request->get('ids_nota'));	 
        $jsm=str_replace("'",'', $jsm);		
        $ids=json_decode($jsm);		
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $session=$this->get('request')->getSession();
        $grupo_id=$session->get('grupo_id');
        $asignatura_id=$session->get('asignatura_id');                     
        $periodo_id=$session->get('perido_id');

        if(($user->getEsAlumno()==FALSE)){
            $profesor_id=$user->getProfesor()->getId();  
             $publicacion_periodo=  $this->getDoctrine()
                                  ->getRepository("NetpublicCoreBundle:PublicacionPeriodosProfesores")
                                  ->findOneBy(array(
                                      'profesor'=>$profesor_id,
                                      'periodo_academico'=>$periodo_id
                                  ));
            //$publicacion_periodo=new \Netpublic\CoreBundle\Entity\PublicacionPeriodosProfesores();
            $publicacion_periodo->setFechaUltimoCalificaion(new \DateTime);
            $em->persist($publicacion_periodo);       
         }
         
        
        $sede_principal= $this->getDoctrine()
                              ->getRepository("NetpublicCoreBundle:Colegio")
                              ->findOneBy(array(
                                  "es_principal"=>TRUE
                              ));
        $index=0;
        $cifras_sig=$sede_principal->getNumeroCifrasignificativa();
        foreach ($ids as $id) {                    
            $entity = $em->getRepository('NetpublicCoreBundle:AlumnoDimension')->find($id);
            
            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Grado entity.');
            }
            $mi_nota=number_format($values[$index],1);
            
            if($entity->getNotaBuffered()==-1){
                $entity->setEsIngresadad(TRUE);
                $entity->setFechaUltimoIngreso(new \DateTime);
            }
            else{
            if($entity->getNotaBuffered()!=$mi_nota){
                $entity->setEsModificada(TRUE);
                $entity->setFechaUltimoCambio(new \DateTime);
             }
            
            }
            $entity->setNotaBuffered($mi_nota);
	    $entity->setNota($mi_nota);
            $em->persist($entity);
	    $index++;
            
        }
        $em->flush();
        //Calculamos Promedio, para los estuidantes de ese grupo
        $alumnos=  $em->getRepository('NetpublicCoreBundle:Alumno')->findBy(array(
            'grupo'=>$grupo_id
        ));
        foreach ($alumnos as $alumno) { 
            //$notas=$alumno->getNota();
            $promedio=0;
            $ponderado_total=0;
            
                $query="SELECT a_d FROM NetpublicCoreBundle:AlumnoDimension a_d JOIN a_d.dimension d";
            $query.=" WHERE (d.padre=:periodo_id";
            $query.=" AND a_d.asignatura=:asignatura_id";
            $query.=" AND a_d.alumno=:alumno_id";
			$query.=" AND d.profesor=:profesor_id";
            $query.=" AND d.tipo=4)";            
            $notas=$em->createQuery($query)                
                                 ->setParameters(array(
                                         "periodo_id"=>$periodo_id,
                                         "asignatura_id"=>$asignatura_id,
										  "profesor_id"=>$profesor_id,
                                         "alumno_id"=>$alumno->getId()                                     
                                      ))->getResult(); 
            foreach ($notas as $nota) {
                   
                   $ponderado_dim=$nota->getDimension()->getPonderado(); 
                   $promedio=$promedio+($nota->getNota()*$ponderado_dim);
                   $ponderado_total+=$ponderado_dim;
                }            
            $query="SELECT a_d FROM NetpublicCoreBundle:AlumnoDimension a_d";
            $query.=" WHERE (a_d.dimension=:periodo_id";
            $query.=" AND a_d.asignatura=:asignatura_id";
            $query.=" AND a_d.alumno=:alumno_id";
            $query.=" )";                
            $notas=$em->createQuery($query)                
                                 ->setParameters(array(
                                         "periodo_id"=>$periodo_id,
                                         "asignatura_id"=>$asignatura_id,
                                         "alumno_id"=>$alumno->getId()                                     
                                      ))->getResult();     
            foreach ($notas as $nota) {
                /*if($nota->getDimension()->getId()==$periodo_id &&
                   $nota->getAsignatura()->getId()==$asignatura_id){*/
                    if($ponderado_total>0){  
                        $mi_nota2=number_format($promedio/$ponderado_total,1);
                        $nota->setNota($mi_nota2); 
                        $em->persist($nota); 
                    }
                   
                //}
            }
        }
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response("ok");
    }
    


    /**
     * Edits an existing Grado entity.
     *		
     * @Route("/calificarradicionesupdate", name="grupo_calificarradicionesupdate")
     * @Method("post")
     * @Template()
     */
    public function calificarradicionesupdateAction()
    {
        
        $request = $this->getRequest();
        $jsm_values=str_replace('_nota','',  $request->get('values'));
        $jsm=str_replace("'",'', $jsm_values);		
        $values=json_decode($jsm);        
	$jsm=str_replace('"','',  $request->get('ids_nota'));	 
        $jsm=str_replace("'",'', $jsm);		
        $ids=json_decode($jsm);		
        $em = $this->getDoctrine()->getEntityManager();
        $sede_principal= $this->getDoctrine()
                              ->getRepository("NetpublicCoreBundle:Colegio")
                              ->findOneBy(array(
                                  "es_principal"=>TRUE
                              ));
        $index=0;
        $cifras_sig=$sede_principal->getNumeroCifrasignificativa();
        $alumnos=array();
        foreach ($ids as $id) {                    
            $entity = $em->getRepository('NetpublicCoreBundle:AlumnoDimension')->find($id);
            
            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Grado entity.');
            }
            $mi_nota=number_format($values[$index],1);
            if($entity->getNota()!=$mi_nota){
                $entity->setEsModificada(TRUE);
                $entity->setFechaUltimoCambio(new \DateTime);
                $entity->setNumeroCambios($entity->getNumeroCambios()+1);
            }
            
	    $entity->setNota($mi_nota);
            $alumnos[]=$entity->getAlumno();
            $em->persist($entity);
	    $index++;
            
        }
        $em->flush();
		$user = $this->get('security.context')->getToken()->getUser();
        
        if(($user->getEsAlumno()==FALSE)){
            $profesor_id=$user->getProfesor()->getId();            
         }
         
        //Calculamos Promedio, para los estuidantes de ese grupo
        $session=$this->get('request')->getSession();
        $grupo_id=$session->get('grupo_id');
        $asignatura_id=$session->get('asignatura_id');                     
        $periodo_id=$session->get('perido_id');
        /*$alumnos=  $em->getRepository('NetpublicCoreBundle:Alumno')->findBy(array(
            'grupo'=>$grupo_id,
            'es_adicion'=>1
        ));*/
        foreach ($alumnos as $alumno) { 
            //$notas=$alumno->getNota();
            $grado_id=$alumno->getGrado()->getId();
            $asignaturas=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Asignatura")->findBy(array(
                'es_area'=>0,
                'grado'=>$grado_id
            ));
            $ids_asg=array();
            for ($index1 = 0; $index1 < count($asignaturas); $index1++) {
                $ids_asg[$index1]=$asignaturas[$index1]->getId();
            }
            $ca_profe=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:CargaAcademica")->getAsignaturaCargaAcademica($profesor_id,$alumno->getGrupo()->getId());
            foreach ($ca_profe as $ca) {
                $asignatura_id=$ca->getAsignatura()->getId();
                if(in_array($asignatura_id, $ids_asg)){  
                    $promedio=0;
                    $ponderado_total=0;
            
                     $query="SELECT a_d FROM NetpublicCoreBundle:AlumnoDimension a_d JOIN a_d.dimension d";
                     $query.=" WHERE (d.padre=:periodo_id";
                     $query.=" AND a_d.asignatura=:asignatura_id";
                     $query.=" AND a_d.alumno=:alumno_id";
			$query.=" AND d.profesor=:profesor_id";
                     $query.=" AND d.tipo=4)";            
                     $notas=$em->createQuery($query)                
                                 ->setParameters(array(
                                         "periodo_id"=>$periodo_id,
                                         "asignatura_id"=>$asignatura_id,
										  "profesor_id"=>$profesor_id,
                                         "alumno_id"=>$alumno->getId()                                     
                                      ))->getResult(); 
                     foreach ($notas as $nota) {                   
                            $ponderado_dim=$nota->getDimension()->getPonderado(); 
                            $promedio=$promedio+($nota->getNota()*$ponderado_dim);
                            $ponderado_total+=$ponderado_dim;
                     }            
            $query="SELECT a_d FROM NetpublicCoreBundle:AlumnoDimension a_d";
            $query.=" WHERE (a_d.dimension=:periodo_id";
            $query.=" AND a_d.asignatura=:asignatura_id";
            $query.=" AND a_d.alumno=:alumno_id";
            $query.=" )";                
            $notas=$em->createQuery($query)                
                                 ->setParameters(array(
                                         "periodo_id"=>$periodo_id,
                                         "asignatura_id"=>$asignatura_id,
                                         "alumno_id"=>$alumno->getId()                                     
                                      ))->getResult();     
            foreach ($notas as $nota) {
                /*if($nota->getDimension()->getId()==$periodo_id &&
                   $nota->getAsignatura()->getId()==$asignatura_id){*/
                    if($ponderado_total>0){  
                        $mi_nota2=number_format($promedio/$ponderado_total,1);
                        if($nota->getNota()!=$mi_nota2){
                            $nota->setEsModificada(TRUE);
                            $nota->setFechaUltimoCambio(new \DateTime);
                            $nota->setNumeroCambios($entity->getNumeroCambios()+1);
                        }
                        $nota->setNota($mi_nota2); 
                        $em->persist($nota); 
                    }
                   
                //}
            }
                }
            }
        }
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response("ok");
            return array(
            'entities'      => $entities,
            'edit_form'   => $editForm->createView()
            
        );
    }
    
    
    
    /**
     * Calificar grupos de las institucion
     *
     * @Route("/{id_asignatura}/{id_grupo}/{id_dimension}/calificarf", name="grupo_calificarf")
     * @Template()
     */
    public function calificarfAction(Request $request,$id_asignatura,$id_grupo,$id_dimension){
        
        $session=$this->get('request')->getSession();
        
        if($request->getMethod()=='POST' || $request->isXmlHttpRequest()){
            $id_grupo=$session->get('grupo_id');
            $id_asignatura=$session->get('asignatura_id');
            $periodo_actual=$session->get('periodo_id');
            $id_dimension=$periodo_actual;
        }
        if ($this->container->get('request')->isXmlHttpRequest())
        {        
            //Se obtienen las notas para actualizar, en la peticion REQUEST
            $notasisXml=$request->get('notas');
            $e =$this->getDoctrine()->getRepository('NetpublicCoreBundle:Grupo')->updateNotasJson($notasisXml,$id_asignatura);
        }  
        $user = $this->get('security.context')->getToken()->getUser();
        $session=$this->get('request')->getSession();       
        $em = $this->getDoctrine()->getEntityManager();
        if(!($user->getEsAlumno())){
            $profesor=$user->getProfesor();
            
            $id_profesor=$profesor->getId();
        }   
        $Entities_Form_FormView=$this->getDoctrine()
                                     ->getRepository('NetpublicCoreBundle:Grupo')
                                     ->getEntities_Form_FormView($id_grupo,$id_asignatura,$id_dimension,$this);
        $entities=$Entities_Form_FormView[0];
        $form=$Entities_Form_FormView[1];
        $form_view=$Entities_Form_FormView[2];
        return array(
            'entities' => $entities,
            'form'   => $form,
            'form_view'=>$form_view//,
           //'grupo_asignatura'=>$grupo_asignatura
        );

        
    }

    /**
     * Calificar grupos de las institucion
     *
     * @Route("/{id_asignatura}/{id_grupo}/{id_dimension}/calificar", name="grupo_calificar")
     * @Template()
     */
    public function calificarAction(Request $request,$id_asignatura,$id_grupo,$id_dimension)
    {
        $session=$this->get('request')->getSession();
        if($request->getMethod()=='POST' || $request->isXmlHttpRequest()){
            $id_grupo=$session->get('grupo_id');
            $id_asignatura=$session->get('asignatura_id');
            $periodo_actual=$session->get('periodo_id');
            $id_dimension=$periodo_actual;
        }
        $ano_escolar_activo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                      ->findBy(array(
                          'tipo'=>0,
                          'es_ano_escolar'=>1
                      ));
        $periodos=array();
        if(count($ano_escolar_activo)>0){
             $periodos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                      ->findBy(array(
                          'tipo'=>1,
                          'padre'=>$ano_escolar_activo[0]->getId()
                      ));
        }
        $user = $this->get('security.context')->getToken()->getUser();
        $grupo_asignatura=array();
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor();            
            $id_profesor=$profesor->getId();
            
            $grupo_asignatura=$this->getDoctrine()->getRepository('NetpublicCoreBundle:CargaAcademica')->getAsignaturaGrupo($id_profesor);
           
        }              
        $Entities_Form_FormView=$this->getDoctrine()
                                     ->getRepository('NetpublicCoreBundle:Grupo')
                                     ->getEntities_Form_FormView($id_grupo,$id_asignatura,$id_dimension,$this);
        $entities=$Entities_Form_FormView[0];
        $form=$Entities_Form_FormView[1];
        $form_view=$Entities_Form_FormView[2];
        if($request->getMethod()=='GET'){
            $entities=array();
            $form=array();
            $form_view=array();
            
        }
        return array(
            'entities' => $entities,
            'form'   => $form,
            'form_view'=>$form_view,
            'grupo_asignatura'=>$grupo_asignatura,
            'periodos'=>$periodos
        );
    }

    /**
     * Finds and displays a Grupo entity.
     *
     * @Route("/{id}/show", name="grupo_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Grupo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Grupo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }
    /**
     * Finds and displays a Grupo entity.
     *
     * @Route("/periodosacademicos", name="grupo_periodosacademicos")
     * @Template()
     * @Method("post")
     */
    public function periodosacademicosAction()
    {
        $session=$this->get('request')->getSession();
        $grupo_id=$session->get('grupo_id');
        $asignatura_id=$session->get('asignatura_id');                     
        //$periodo_id=$session->get('perido_id');
        $dim_periodo_escolar=array();
         //Peridos escolares de una año
        $ano_escolar_activo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                      ->findOneBy(array(
                          'tipo'=>0,
                          'es_ano_escolar'=>1
                      ));
        
            $periodos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                      ->findBy(array(
                          'tipo'=>1,
                          'padre'=>$ano_escolar_activo->getId()
                      ));
        
        //Carga academica
        $user = $this->get('security.context')->getToken()->getUser();
        $grupo_asignatura=array();
        $dim_temporal_tem=array();
        $re="";
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor();            
            $id_profesor=$profesor->getId();            
            $grupo_asignatura=$this->getDoctrine()->getRepository('NetpublicCoreBundle:CargaAcademica')->getAsignaturaGrupo($id_profesor);           
            foreach ($periodos as $periodo) {
                            $dim_periodo_escolartem=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
                            'padre'=>$periodo->getId(),
                            'profesor'=>$id_profesor,
                            'asignatura'=> $asignatura_id,
                            'tipo'=>4    
                        ));
                        $dim_temporal_tem=array();    
                        foreach ($dim_periodo_escolartem as $d_p_e) {
                            foreach ($d_p_e->getGrupo() as $grupo) {
                                if($grupo->getId()==$grupo_id){
                                    $dim_temporal_tem[]=$d_p_e;  
                                   
                                }
                            }
                              
                        }        
                        $dim_periodo_escolar[]=$dim_temporal_tem;     
                        
                      
            }         
        } 
       
        return array(
            'dim_periodo_escolar'      => $dim_periodo_escolar,
            'periodos'=>$periodos);
    }    
   /**
     * Finds and displays a Grupo entity.
     *
     * @Route("/update_grupo_asignatura", name="grupo_update_grupo_asignatura")
    *  @Method("post")
     * @Template()
     */
    public function update_grupo_asignaturaAction()
    {
        $request=$this->getRequest();
        $session=$this->get('request')->getSession();
        //$periodo_id=$periodo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
        //              ->findPeriodoEscolarActivo()->getId();
        $grupo_asignatura=$request->get('grupo_asignatura');
        if($grupo_asignatura!='*'){
            $vector_grupo_asignatura=explode(';', $grupo_asignatura);
            $session->set('grupo_id',$vector_grupo_asignatura[0]);
            $session->set('asignatura_id',$vector_grupo_asignatura[1]);
            $session->set('perido_id',$vector_grupo_asignatura[2]);
            $session->set('carga_academica_id',$vector_grupo_asignatura[3]);
            
            
        }
        
        return new Response("ok");
    }
       /**
     * Finds and displays a Grupo entity.
     *
     * @Route("/get_grupo_asignatura_periodo", name="get_grupo_asignatura_periodo")
    *  @Method("post")
     * @Template()
     */
    public function get_grupo_asignatura_periodoAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $session=$this->get('request')->getSession();
        $grupo_id=$session->get('grupo_id');
        $grupo=$em->getRepository("NetpublicCoreBundle:Grupo")->find($grupo_id);
        $asignatura_id=$session->get('asignatura_id');
        $asignatura=$em->getRepository("NetpublicCoreBundle:Asignatura")->find($asignatura_id);       
        $periodo_id=$session->get('perido_id');
        $periodo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);
        
        return new Response("$periodo($grupo-$asignatura)");
    }

 /**
     * Finds and displays a Grupo entity.
     *
     * @Route("/updateperiodo", name="grupo_updateperiodo_grupo")
    *  @Method("post")
     * @Template()
     */
    public function updateperiodoAction()
    {
        $request=$this->getRequest();
        $session=$this->get('request')->getSession();
        $periodo_id=$request->get('periodo');
        
        $session->set('periodo_id',$periodo_id);
       
        return new Response("ok");
    }

        /**
     * Displays a form to create a new Grupo entity.
     *
     * @Route("/{grado_id}/{nro_grupos}/{sede_id}/newvariosgrupo", name="grupo_newvariosgrupo")
     * @Template()
     */
    public function newvariosgrupoAction($grado_id,$nro_grupos,$sede_id)
    {
        $em=  $this->getDoctrine()->getManager();                
        $request=  $this->getRequest();
        $sede=$em->getRepository("NetpublicCoreBundle:Colegio")->find($sede_id);
        $grado=$em->getRepository("NetpublicCoreBundle:Grado")->find($grado_id);
        $label_grado=$grado->getNombreGrupo();
        if($label_grado){
            
        }
        else{
            $nombre_grado=  Util::getSlug($grado->getNombre(),"");
            if($nombre_grado=='gradocero'){
                $label_grado='0';
            }
            if($nombre_grado=='primero'){
                $label_grado='1';
            }
            if($nombre_grado=='segundo'){
                $label_grado='2';
            }
            if($nombre_grado=='tercero'){
                $label_grado='3';
            }
            if($nombre_grado=='cuarto'){
                $label_grado='4';
            }
            if($nombre_grado=='quinto'){
                $label_grado='5';
            }
            if($nombre_grado=='sexto'){
                $label_grado='6';
            }
            if($nombre_grado=='septimo'){
                $label_grado='7';
            }
            if($nombre_grado=='octavo'){
                $label_grado='8';
            }
            if($nombre_grado=='noveno'){
                $label_grado='9';
            }
            if($nombre_grado=='decimo'){
                $label_grado='10';
            }
            if($nombre_grado=='undecimo'){
                $label_grado='11';
            }
        }
        return array(
            'sede'=>$sede,
            'label_grado'=>$label_grado,
            'nro_grupos'=>$nro_grupos
        );
    }

    /**
     * Displays a form to create a new Grupo entity.
     *
     * @Route("/{grado_id}/newgrupo", name="grupo_newgrupo")
     * @Template()
     */
    public function newgrupoAction($grado_id)
    {
        $em=  $this->getDoctrine()->getManager();                
        $request=  $this->getRequest();
        $sedes=$em->getRepository("NetpublicCoreBundle:Colegio")->findAll();
        $grado=$em->getRepository("NetpublicCoreBundle:Grado")->find($grado_id);
        $label_grado=$grado->getNombreGrupo();
        if($label_grado){
            
        }
        else{
            $nombre_grado=  Util::getSlug($grado->getNombre(),"");
            if($nombre_grado=='gradocero'){
                $label_grado='0';
            }
            if($nombre_grado=='primero'){
                $label_grado='1';
            }
            if($nombre_grado=='segundo'){
                $label_grado='2';
            }
            if($nombre_grado=='tercero'){
                $label_grado='3';
            }
            if($nombre_grado=='cuarto'){
                $label_grado='4';
            }
            if($nombre_grado=='quinto'){
                $label_grado='5';
            }
            if($nombre_grado=='sexto'){
                $label_grado='6';
            }
            if($nombre_grado=='septimo'){
                $label_grado='7';
            }
            if($nombre_grado=='octavo'){
                $label_grado='8';
            }
            if($nombre_grado=='noveno'){
                $label_grado='9';
            }
            if($nombre_grado=='decimo'){
                $label_grado='10';
            }
            if($nombre_grado=='undecimo'){
                $label_grado='11';
            }
        }
        return array(
            'sedes'=>$sedes,
            'label_grado'=>$label_grado
        );
    }
    
    
    /**
     * Displays a form to create a new Grupo entity.
     *
     * @Route("/new", name="grupo_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Grupo();
        $em=  $this->getDoctrine()->getManager();                
        $form   = $this->createForm(new GrupoType(), $entity);
        $request=  $this->getRequest();
        $es_ajax=false;
        if($request->isXmlHttpRequest()){
            $es_ajax=true;
        }
        $grados=$em->getRepository("NetpublicCoreBundle:Grado")->findAll();
        $sedes=$em->getRepository("NetpublicCoreBundle:Colegio")->findAll();
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'es_ajax' =>$es_ajax,
            'sedes'=>$sedes,
            'grados'=>$grados
        );
    }

    /**
     * Creates a new Grupo entity.
     *
     * @Route("/create", name="grupo_create")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Grupo:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Grupo();
        $em=  $this->getDoctrine()->getManager();
        $grado_id=  $this->getRequest()->get('grado');
        $nombre= $this->getRequest()->get('nombre');
        $grado=$em->getRepository("NetpublicCoreBundle:Grado")->find($grado_id);
        //$form    = $this->createForm(new GrupoType(), $entity);
        //$form->handleRequest($request);
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        //if ($form->isValid()) {
            //$grado=$entity->getGrado();
            
                $entity->setNombre($nombre);
                $grado->addGrupo($entity);
                $entity->setGrado($grado);
                //Adicionamos carga academica
                $asignaturas=  $this->getDoctrine()
                    ->getRepository("NetpublicCoreBundle:Asignatura")
                    ->findBy(array(
                        "grado"=>$grado->getId(),
                        'es_area'=>false
                    ));
                foreach ($asignaturas as $asig) {
                    $c_a=new \Netpublic\CoreBundle\Entity\CargaAcademica();
                    $c_a->setAsignatura($asig);
                    $c_a->setGrupo($entity);
                    $c_a->setTieneProfesor(false);
                    $c_a->setAnoEscolar($ano_escolar_activo);
                    $c_a->setEsCargaAcademica(TRUE);
                    $em->persist($c_a);
                }
            $em->persist($grado);
            $em->persist($entity);
            
            $em->flush();
            if ($this->container->get('request')->isXmlHttpRequest()){
                return new \Symfony\Component\HttpFoundation\Response("Ok");
            }
            return new Response("ok");
    }

    /**
     * Displays a form to edit an existing Grupo entity.
     *
     * @Route("/{id}/edit", name="grupo_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $entity = $em->getRepository('NetpublicCoreBundle:Grupo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Grupo entity.');
        }
        $es_ajax=false;
        $editForm = $this->createForm(new GrupoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        $es_ajax=false;
        if($request->isXmlHttpRequest()){
            $es_ajax=true;
        }
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'es_ajax' => $es_ajax
        );
    }

    /**
     * Edits an existing Grupo entity.
     *
     * @Route("/{id}/update", name="grupo_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Grupo:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Grupo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Grupo entity.');
        }

        $editForm   = $this->createForm(new GrupoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setNombre($entity->getNombre());
            $em->persist($entity);            
            $em->flush();
            if($request->isXmlHttpRequest())
                return new Response("ok");
            return $this->redirect($this->generateUrl('grupo_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Grupo entity.
     *
     * @Route("/{id}/delete", name="grupo_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:Grupo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Grupo entity.');
            }            
            $this->updateAlumno($entity->getId());
            $this->borrarCargaAcademica($entity->getId());
            $this->borrarCondicionGrupo($entity->getId());
            $this->borrarGrupoPromovido($entity->getId());
            $this->borrarGrupoPromovidoSiguiente($entity->getId());
            $this->borrarHorarioGrupo($entity->getId());
            /*$this->borrarDesempeno($entity);*/
            $em->remove($entity);
            $em->flush();
            if($request->isXmlHttpRequest())
                return new Response("ok");
        }

        return $this->redirect($this->generateUrl('grupo'));
    }
     /**
     * Obtener la lista de asignatura de un grupo
     *
     * @Route("/{id_grupo}/asignaturas", name="grupo_asignaturas")
     * @Method("post")
     * @Template()
     */
    public function asignaturasAction($id_grupo)
    {
        $grupo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Grupo")->find($id_grupo);
        $asignaturas=$grupo->getGrado()->getAsignaturas();
        return array(
            "asignaturas"=>$asignaturas
        );
        
    }   

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
        protected function getDimenGrupo($profesor_id,$asignatura_id,$dimension_id,$grupo_id){
        $notas_grupo=array();
        $nombres_dimensiones=array();
        //Se Cargar los Elementos en hijos de la dimesion
        $hijos_dimension=$this->getDoctrine()
                ->getRepository("NetpublicCoreBundle:Dimension")
                ->findBy(
                        array("padre"=>$dimension_id)
                        );       
        $index=0;
        
        foreach ($hijos_dimension as $dimension) {
          //$dimension_ids[]=$dimension->getNombre();
            $notas_grupo[]=$this->getDoctrine()
                ->getRepository("NetpublicCoreBundle:AlumnoDimension")
                ->findBy(
                        array("profesor"=>$profesor_id,"asignatura"=>$asignatura_id,"grupo"=>$grupo_id,"dimension"=>$dimension->getId())
                        );
            if(count($notas_grupo[$index])>0){
                $nombres_dimensiones[$index]=$notas_grupo[$index][0]->getDimension();                
                   $index++;
            }
            else{
               break;
            }
            
        }
        
        $rnombres_dimensiones[]=$notas_grupo;
        $rnombres_dimensiones[]=$nombres_dimensiones;
        return $rnombres_dimensiones;        
    }
    protected function generarFormCalificarNotas($notas_grupo,$grupo_id){
        $form=array();
        $mi_form_obt=array();
        $mi_form_1=array();
        $nombres_alumnos=$this->getDoctrine()
                                    ->getRepository("NetpublicCoreBundle:Alumno")
                                    ->listarAlumnosGrupo($grupo_id)
                                    ->getResult();        
        for ($index2 = 0; $index2 < count($notas_grupo); $index2++) {
            $form_1=array();
            for ($index1 = 0; $index1 < count($notas_grupo[$index2]); $index1++) {
                //Cargo los alumnos
                if($index2==0){
                    $nombres_alumnos[$index1]=$notas_grupo[$index2][$index1]->getAlumno();
                }
                $mi_form_1[$index1] = $this->createForm(new AlumnoDimensionType($notas_grupo[$index2][$index1]->getId()), $notas_grupo[$index2][$index1]);
                $form_1[$index1] = $mi_form_1[$index1]->createView();
            }
            $form[$index2]=$form_1;
            $mi_form_obt[$index2]=$mi_form_1;
                
        }        
        $n_alumnos_form_vista[]=$form;
        $n_alumnos_form_vista[]=$mi_form_obt;
        $n_alumnos_form_vista[]=$nombres_alumnos;
        return $n_alumnos_form_vista;
    }
    
    private function updateAlumno($grupo_id) {
        $alumnos=  $this->getDoctrine()
                        ->getRepository("NetpublicCoreBundle:Alumno")
                        ->findBy(array(
                            "grupo"=>$grupo_id                
                        ));
        $ano_escolar_activo=  $this->getDoctrine()
                                ->getRepository("NetpublicCoreBundle:Dimension")
                                ->findAnoEscolarActivo();
       foreach ($alumnos as $alumno) {           
           $this->getDoctrine()
                ->getRepository("NetpublicCoreBundle:Alumno")
                ->cancelarMatricula($alumno,$ano_escolar_activo->getId());                                
       }
    }
 private function borrarCargaAcademica($grupo_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="SELECT a_d FROM NetpublicCoreBundle:CargaAcademica a_d";
        $dql.=" WHERE a_d.grupo=:dimension_id";
        $query=$em->createQuery($dql);
        $cargas_academicas=$query
                        ->setParameter("dimension_id", $grupo_id)
                        ->getResult();                        
        foreach ($cargas_academicas as $ca) {            
            $dql="DELETE NetpublicCoreBundle:CondicionContrato a_d";
            $dql.=" WHERE a_d.carga_academica=:dimension_id";
            $query=$em->createQuery($dql);
            $query=$query->setParameter("dimension_id", $ca->getId())->execute();                        
            $dql="DELETE NetpublicCoreBundle:HorarioClase a_d";
            $dql.=" WHERE a_d.carga_academica=:dimension_id";
            $query=$em->createQuery($dql);
            $query=$query->setParameter("dimension_id", $ca->getId())->execute();                        
            $dql="DELETE NetpublicCoreBundle:HorarioGrupo a_d";
            $dql.=" WHERE a_d.carga_academica=:dimension_id";
            $query=$em->createQuery($dql);
            $query=$query->setParameter("dimension_id", $ca->getId())->execute();                        

        }
        $dql="DELETE NetpublicCoreBundle:CargaAcademica a_d";
        $dql.=" WHERE a_d.grupo=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $grupo_id)->execute();                        
    }
        private function borrarGrupoPromovido($grupo_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:Grupopromovido a_d";
        $dql.=" WHERE a_d.grupo_actual=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id",$grupo_id)->execute();                        
    }
 private function borrarGrupoPromovidoSiguiente($grupo_id){
        /*$em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:CargaAcademica a_d";
        $dql.=" WHERE a_d.grupo_siguiente=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id",$grupo_id)->execute();                        */
     
    }
 private function borrarCondicionGrupo($grupo_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:CondicionGrupo a_d";
        $dql.=" WHERE a_d.grupo=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id",$grupo_id)->execute();                        
    }
 private function borrarHorarioGrupo($grupo_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:HorarioGrupo a_d";
        $dql.=" WHERE a_d.grupo=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id",$grupo_id)->execute();                        
    }
    private function borrarDesempeno($grupo) {
        $em=  $this->getDoctrine()->getEntityManager();
        $desempenos=$grupo->getDesempeno();
        foreach ($desempenos as $d) {
            $dql="SELECT a_d FROM NetpublicCoreBundle:ActividadDesempeno a_d";        
            $dql.=" WHERE a_d.desempeno=:dimension_id";
            $query=$em->createQuery($dql);
            $actividades_desempeno=$query->setParameter("dimension_id", $d->getId())->getResult();                        
            foreach ($actividades_desempeno as $a_d) {
                $em->remove($a_d);
            }

            $em->remove($d);            
        }
        $em->flush();                        
    }
    

}
