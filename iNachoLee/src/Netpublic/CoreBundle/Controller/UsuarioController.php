<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\Usuario;
use Netpublic\CoreBundle\Form\UsuarioType;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

use Netpublic\CoreBundle\Util\Util;
/**
 * Usuario controller.
 *
 * @Route("/usuario")
 */
class UsuarioController extends Controller
{
      /**
     * Lists all Usuario entities.
     *
     * @Route("/buscartemp.json", name="usuario_buscartemp")
     * 
     */
    public function buscartempAction()
    {
        $request=  $this->getRequest();
        $query=$request->get('query');
        if($query=='u'){
        $data=array(
            array("num"=>"Uno","letra"=>"yuri"),
            array('num'=>"Dos","letra"=>"yuri"),
            array("num"=>"Tres","letra"=>"yuri"),
            array('num'=>"Cuatro","letra"=>"yuri"),
        );
        }
        else if($query=='m'){
                   $data=array(
            array("num"=>"Mi mama","letra"=>"yuri"),
            array('num'=>"Mi papa","letra"=>"yuri"),
            array("num"=>"Mi tia","letra"=>"yuri"),
            array('num'=>"Mi Colosa","letra"=>"yuri"),
        );
 
        }
        else{
            $data=array(
            array("num"=>"Cinco","letra"=>"yuri"),
            array('num'=>"Seis","letra"=>"yuri"),
            array("num"=>"Siete","letra"=>"yuri"),
            array('num'=>"Ocho","letra"=>"yuri"),
        );
        
        }
        return new \Symfony\Component\HttpFoundation\JsonResponse($data);
    }
    
    /**
     * Lists all Usuario entities.
     *
     * @Route("/", name="usuario")
     * @Template()
     */
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $em=  $this->getDoctrine()->getEntityManager();
        $colegio=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")
                        ->findSedePrincipal();
        date_default_timezone_set("America/Bogota");
        $session=$this->get('request')->getSession();
       $r=-1;
       if($user->getEsAlumno()){
            $alumno=$user->getAlumno();
            $visibilidad=$em->getRepository("NetpublicRedsaberBundle:AlumnoExamen")->findOneBy(array(
                   'alumno'=>$alumno->getId(),
                    'visible'=>1
            ));
            if($visibilidad){
                $r=$visibilidad->getExamen()->getId();
                $user = $this->get('security.context')->getToken()->getUser();
                if($user){
                    if(($user->getEsAlumno())){
                        $alumno=$user->getAlumno();
                        $a_e=$em->getRepository("NetpublicRedsaberBundle:AlumnoExamen")->findOneBy(array(
                           'alumno'=>$alumno->getId(),
                            'examen'=>$r
                        ));
                       $fecha_final=$a_e->getFechaFinal();
                       if($fecha_final){
                            $fecha_Actual=date("Y-m-j H:i");                       
                            $minutos=(strtotime($fecha_final->format("Y-m-j H:i"))-  strtotime($fecha_Actual))/60;
                            $hora=  intval($minutos/60);
                            $minutos_hora=$minutos-($hora*60);
                       /*echo $a_e->getId();
                       echo "Fecha ahora: $fecha_Actual<br/>";
                       echo "Fecha final: ".$fecha_final->format("Y m j h:i")."<br/>";
                       echo "Todos Minutos: $minutos hora : $hora $minutos_hora<br/>";*/
                            $session->set("hora",$hora);
                            $session->set("minutos",$minutos_hora);
                       }
                    }
               }
            }
       }
    
        $session->set('examen_id', $r);
        
       $periodo_activo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                     ->findPeriodoEscolarActivo();
       if($periodo_activo){
        $periodo_s=$session->get("perido_id",$periodo_activo->getId());
        $periodo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_s);
        $periodo_id='*';
       if($periodo)
           $periodo_id=$periodo->getId();
            $session->set('perido_id',$periodo_id);
        if(($user->getEsAlumno()==FALSE && $user->getProfesor()->getTipo()==2)){
            $profesor=$user->getProfesor();            
            $profesor_id=$profesor->getId();
            $publicacion_periodo=  $this->getDoctrine()
                                  ->getRepository("NetpublicCoreBundle:PublicacionPeriodosProfesores")
                                  ->findOneBy(array(
                                      'profesor'=>$profesor_id,
                                      'periodo_academico'=>$periodo_id
                                  ));
            //$publicacion_periodo=new \Netpublic\CoreBundle\Entity\PublicacionPeriodosProfesores();
            if($publicacion_periodo){
                $publicacion_periodo->setFechaUltimoIngreso(new \DateTime);
                $em->persist($publicacion_periodo);
            }
            
            $em->flush();
       
       }
       }
       
       return array('colegio'=>$colegio);
        
    }

    /**
     * Finds and displays a Usuario entity.
     *
     * @Route("/{id}/show", name="usuario_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Usuario entity.
     *
     * @Route("/new", name="usuario_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Usuario();
        $form   = $this->createForm(new UsuarioType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Usuario entity.
     *
     * @Route("/create", name="usuario_create")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Usuario:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Usuario();
        $request = $this->getRequest();
        $form    = $this->createForm(new UsuarioType(), $entity);
         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            
             
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('usuario_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     * @Route("/{id}/edit", name="usuario_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $editForm = $this->createForm(new UsuarioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Cambiar contrasena
     *
     * @Route("/updatecontrasena", name="usuario_updatecontrasena")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Usuario:edit.html.twig")
     */    
    public function updatecontrasenaAction(){
        $request = $this->getRequest();
        $user = $this->get('security.context')->getToken()->getUser();
        
        if ($this->get('security.context')->isGranted('ROLE_PROFESORES')  ||                
                $this->get('security.context')->isGranted('ROLE_RECTOR') ||
                $this->get('security.context')->isGranted('ROLE_AUXILIAR')) {
                    $id=$user->getId();
        }
        if ($this->get('security.context')->isGranted('ROLE_ESTUDIANTE')) {                              
                    $id=$user->getId();
        }        
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Usuario')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }
        
        $nueva_contrasena=$request->get('nueva_contrasena');
        $entity->setSalt(md5(time()));
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword($nueva_contrasena, $entity->getSalt());
        $entity->setPassword($password);
        $entity->setEsCambioContrasena(TRUE);
        $em->persist($entity);        
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response("$nueva_contrasena");

    }
   /**
     * Cambiar contrasena
     *
     * @Route("/{id}/updatecontrasenaperfiladmin", name="usuario_updatecontrasenaperfiladmin")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Usuario:edit.html.twig")
     */    
    public function updatecontrasenaperfiladminAction($id){
        
         $request = $this->getRequest();   
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Usuario')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }
        
        $nueva_contrasena=$request->get('nueva_contrasena');
        $entity->setSalt(md5(time()));
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword($nueva_contrasena, $entity->getSalt());
        $entity->setPassword($password);
        $entity->setEsCambioContrasena(TRUE);
        $em->persist($entity);        
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response("$nueva_contrasena");

    }    
     /**
     * Cambiar contrasena
     *
     * @Route("/editcontrasena", name="usuario_editcontrasena")
     * @Method("post")
     * @Template()
     */    
    public function editcontrasenaAction(){
        $user = $this->get('security.context')->getToken()->getUser();
                     
        if($user->getEsAlumno()){
            $usuario=$user->getProfesor();                        
        }
        else{
            $usuario=$user->getAlumno();                        
        }
        return array('usuario'=>$usuario);

    }
     /**
     * Cambiar contrasena
     *
     * @Route("/{id}/editcontrasenaperfiladmin", name="usuario_editcontrasenaperfiladmin")
     * @Method("post")
     * @Template()
     */    
    public function editcontrasenaperfiladminAction($id){
        //$em = $this->getDoctrine()->getEntityManager();
        //$user = $em->getRepository('NetpublicCoreBundle:Usuario')->find($id);
        
        return array('id'=>$id);

    }
    
      /**
     * Lists all Usuario entities.
     *
     * @Route("/indexbuscar", name="usuario_indexbuscar")
     * @Template()
     */
    public function indexbuscarAction()
    {
        //Sedes
        $sedes=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")->findAll();
        $anos_escolares=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
            'tipo'=>0
        ));
        $grados= $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grado")->findAll();
        $request=  $this->getRequest();
        $mostrar_button_seleccionar=$request->get('mostrar_button_seleccionar',0);
        $ano_escolar_activo=  $this->getDoctrine()
                                    ->getRepository("NetpublicCoreBundle:Dimension")
                                    ->findAnoEscolarActivo();
        $periodo_escolar_activo= $this->getDoctrine()
                                    ->getRepository("NetpublicCoreBundle:Dimension")
                                    ->findPeriodoEscolarActivo();

        return array(            
            "sedes" => $sedes,
            'anos_escolares'=>$anos_escolares,
            'grados' =>$grados,
            'mostrar_button_seleccionar'=>$mostrar_button_seleccionar,
            'ano_escolar_activo'=>$ano_escolar_activo,
            'periodo_escolar_activo'=>$periodo_escolar_activo
            );
    }

    /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/buscar.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|json|pdf"}, name="usuario_buscar")     
     * @Template()
     */
    public function buscarAction(){
        $request = $this->getRequest();        
        $em=  $this->getDoctrine()->getManager();
        $key=  Util::getSlug($request->get("query"),"");
        if($key=='m'){
            return $this->redirect($this->generateUrl('usuario'));
        }
        
        $query="SELECT a FROM NetpublicCoreBundle:Alumno a";
        $query.=" WHERE ( a!=0 ";
        if($key!='*' && $key!=""){
            $query.=" AND (a.cedula LIKE :key";        
            $query.=" OR a.nombre_completo LIKE :key) ";
        }
        if($request->get('sede')!='*' && $request->get('sede')!=""){
            $query.="  AND a.sede=:sede_id";
        }
        if($request->get('grado')!='*' && $request->get('grado')!=""){
            $query.=" AND a.grado=:grado_id";        
        }
        if($request->get('grupo')==0 && $request->get('grupo')!='*' && $request->get('grupo')!='') {
            $query.=" AND a.grupo is NULL" ;        
        }
        if($request->get('grupo')!='*' && $request->get('grupo')!="" && $request->get('grupo')!=0 ){
            $query.=" AND a.grupo=:grupo_id" ;        
        }
        $query.=" )"; 
        
        $usuarios=  $em->createQuery($query);
        if($key!='*' && $key!=""){
                $usuarios->setParameter("key",'%'.$key.'%');
        }
        if($request->get('sede')!='*' && $request->get('sede')!=""){
            $usuarios=$usuarios->setParameter('sede_id',$request->get('sede'));
        }
        if($request->get('grado')!='*' && $request->get('grado')!=""){
            $usuarios=$usuarios->setParameter('grado_id',$request->get('grado'));        
        }
        if($request->get('grupo')!='*' && $request->get('grupo')!="" && $request->get('grupo')!=0 ){
            $usuarios=$usuarios->setParameter('grupo_id',$request->get('grupo'));      
        }
        $usuarios=$usuarios->setMaxResults(60);
        $usuarios=$usuarios->getResult();
        //profesores
        $query="SELECT p FROM NetpublicCoreBundle:Profesor p";
        $query.=" WHERE ( p!=0 ";
        if($key!='*' && $key!=""){
            $query.=" AND (p.cedula LIKE :key";        
            $query.=" OR p.nombre_completo LIKE :key) ";
        }
        if($request->get('sede')!='*' && $request->get('sede')!=""){
            $query.="  AND p.sede=:sede_id";
        }
        
        $query.=" )"; 
        
        $profesores=  $em->createQuery($query);
        if($key!='*' && $key!=""){
                $profesores->setParameter("key",'%'.$key.'%');
        }
        if($request->get('sede')!='*' && $request->get('sede')!=""){
            $profesores=$profesores->setParameter('sede_id',$request->get('sede'));
        }
        
        $profesores=$profesores->setMaxResults(60);
        $profesores=$profesores->getResult();
        
        
      if($request->get('_format')=='json'){ 
        $baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
        $usuarios_json=array();
        $entorno=$request->getScheme() . '://' . $request->getHttpHost().$request->getScriptName()."/";

        foreach ($usuarios as $usuario) { 
            
            $usuario_alumno=$usuario->getUsuario();
            if($usuario_alumno){
                if($usuario_alumno->getEsfotoPerfil()){
                    $src=$baseurl."/"."uploads/documents/minialumno{$usuario->getId()}.jpg";
        
                }
                else{
                    $src=$baseurl."/"."uploads/documents/miniavatar.png";
                }
                $usuarios_json[]=array(
                                    "nombre"=>"$usuario",
                                    "src_img"=>$src,
                                    "cedula"=>$usuario->getCedula(),
                                    "grado"=>"{$usuario->getGrado()}",
                                    "grupo"=>"{$usuario->getGrupo()}",
                                    "nombre_usuario"=>$usuario_alumno->getUsername(),        
                                    "tipo_usuario"=>"alumno",
                                    "href"=>$entorno."alumno/".$usuario->getId()."/perfiladmin"        
                                  );
            }
        }
        foreach ($profesores as $usuario) { 
            
            $usuario_profesor=$usuario->getUsuario();
            if($usuario_profesor){
                if($usuario_profesor->getEsfotoPerfil()){
                    $src=$baseurl."/"."uploads/documents/miniprofesor{$usuario->getId()}.jpg";
        
                }
                else{
                    $src=$baseurl."/"."uploads/documents/miniavatar.png";
                }
                $usuarios_json[]=array(
                                    "nombre"=>"$usuario",
                                    "src_img"=>$src,
                                    "cedula"=>$usuario->getCedula(),
                                    "grado"=>"no",
                                    "grupo"=>"no",
                                    "nombre_usuario"=>$usuario_profesor->getUsername(),
                                    "tipo_usuario"=>"Profesor",
                                    "href"=>$entorno."profesor/".$usuario->getId()."/perfiladmin"        
                                  );
            }
        }
        return new \Symfony\Component\HttpFoundation\JsonResponse($usuarios_json);
      }
    
    return array(
        'usuarios'=>$usuarios
    );
    }
    /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/{key}/buscarkey", name="usuario_buscarkey")     
     * @Template()
     */
    public function buscarkeyAction($key){  
        $em = $this->getDoctrine()->getEntityManager();
        $alumnos=  array();
        $profesores=  array();
             $usuarios=array();
                $username=  str_replace("@","",$key);
                //Rector
                if($username=="rector"){                    
                    $consulta = $em->createQuery("
                                    SELECT u,u_r FROM NetpublicCoreBundle:Usuario u
                                    JOIN u.user_rol u_r
                                    WHERE u_r.role='ROLE_RECTOR'
                                    ");                    
                    $usuarios=$consulta->getResult();                     
                }
                //Cordinadores academicos.
                elseif ($username=="coordinadores_academico") {
                       $consulta = $em->createQuery("
                                    SELECT u,u_r FROM NetpublicCoreBundle:Usuario u
                                    JOIN u.user_rol u_r
                                    WHERE u_r.role='ROLE_COORACADEMICO'
                                    ");                    
                       $usuarios=$consulta->getResult();                     
                }
                //Cordinadores Convivencia.
                elseif ($username=="coordinadores_convivencia") {
                                            $consulta = $em->createQuery("
                                    SELECT u,u_r FROM NetpublicCoreBundle:Usuario u
                                    JOIN u.user_rol u_r
                                    WHERE u_r.role='ROLE_COORDCONVIVENCIA'
                                    ");                    
                            $usuarios=$consulta->getResult();                     
                }
                //Auxiliar Administrativa.
                elseif ($username=="auxiliar_administrativa") {
                    $consulta = $em->createQuery("
                                    SELECT u,u_r FROM NetpublicCoreBundle:Usuario u
                                    JOIN u.user_rol u_r
                                    WHERE u_r.role='ROLE_AUXILIAR'
                                    ");                    
                            $usuarios=$consulta->getResult();                     
                }                
                //Todos los acudientes.
                elseif ($username=="acudientes_todos") {
                   $consulta = $em->createQuery("
                                    SELECT u FROM NetpublicCoreBundle:Usuario u
                                    JOIN u.alumno a
                                    WHERE a.tipo=1
                                    ");                    
                            $usuarios=$consulta->getResult();                     
                }                
                //Todos los Profesores.
                elseif ($username=="profesores_todos") {
                    
                   $consulta = $em->createQuery("
                                    SELECT u,p FROM NetpublicCoreBundle:Usuario u
                                    JOIN u.profesor p
                                    WHERE p.tipo=2
                                    ");                    
                            $usuarios=$consulta->getResult();                     
                }                
                //Todos los alumnos.
                elseif ($username=="alumnos_todos") {
                   $consulta = $em->createQuery("
                                    SELECT u FROM NetpublicCoreBundle:Usuario u
                                    JOIN u.alumno a
                                    WHERE a.tipo=0
                                    ");                    
                            $usuarios=$consulta->getResult();                                             
                }                
                //Alumnos de Una sede.
                elseif (substr_count ($username,"alumnos_sede_")) {
                    $slug_sede=  str_replace("alumnos_sede_","",$username);
                    $sede=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")->findOneBy(array(
                        'slug'=>$slug_sede
                    ));                                        
                               $consulta = $em->createQuery("
                                    SELECT u FROM NetpublicCoreBundle:Usuario u
                                    JOIN u.alumno a
                                    WHERE a.sede=:id_sede
                                    ");           
                    $consulta->setParameter("id_sede", $sede->getId());
                            $usuarios=$consulta->getResult();                     
                }                
                //Alumnos de un Grado.
                elseif (substr_count ($username,"alumnos_grado_")) {
                    $slug_grado = str_replace("alumnos_grado_", "", $username);
                    $grado = $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grado")->findOneBy(array(
                        'slug' => $slug_grado
                            ));
                    $consulta = $em->createQuery("
                                    SELECT u FROM NetpublicCoreBundle:Usuario u
                                    JOIN u.alumno a
                                    WHERE a.grado=:id_grado
                                    ");
                    $consulta->setParameter("id_grado", $grado->getId());
                            $usuarios=$consulta->getResult();                     
                    
                }                
                //Alumnos de un grupo.
                elseif (substr_count ($username,"alumnos_grupo_")) {                    
                    $slug_grupo = str_replace("alumnos_grupo_", "", $username);
                    $grupo = $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grupo")->findOneBy(array(
                        'slug' => $slug_grupo
                            ));
                    $consulta = $em->createQuery("
                                    SELECT u FROM NetpublicCoreBundle:Usuario u
                                    JOIN u.alumno a
                                    WHERE a.grupo=:id_grupo
                                    ");
                    $consulta->setParameter("id_grupo", $grupo->getId());
                            $usuarios=$consulta->getResult();                     
                } 
                //Profesores de una Sede
                elseif (substr_count ($username,"profesores_sede_")) {                    
                     $slug_sede=  str_replace("profesores_sede_","",$username);
                    $sede=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")->findOneBy(array(
                        'slug'=>$slug_sede
                    ));                                        
                               $consulta = $em->createQuery("
                                    SELECT u FROM NetpublicCoreBundle:Usuario u
                                    JOIN u.profesor a
                                    WHERE a.sede=:id_sede
                                    ");           
                    $consulta->setParameter("id_sede", $sede->getId());
                            $usuarios=$consulta->getResult();                                             
                        
                } 
                //Profesores que dictan clase en el grado.
                elseif (substr_count ($username,"profesores_grado_")) {                    
                        $slug_grado = str_replace("profesores_grado_", "", $username);
                        $grado = $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grado")->findOneBy(array(
                        'slug' => $slug_grado
                            ));                    
                        $asignaturas=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Asignatura")->findBy(array(
                        'grado' => $grado->getId(),
                        'es_area'=>FALSE
                            )); 
                        $usuarios=array();
                        $usuarios_ids=array();
                        foreach ($asignaturas as $materia) {
                                $c_as=$this->getDoctrine()->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
                                    'asignatura' => $materia->getId()                                 
                                ));                                
                                foreach ($c_as as $c_a) {
                                    $profe=$c_a->getProfesor()->getUsuario();                                                                            
                                    if(!in_array($profe->getId(), $usuarios_ids)){
                                        $usuarios_ids[]=$profe->getId();
                                        $usuarios[]=$profe;
                                    }                                    
                                }
                                                       
                        }                        
                } 
                //Profesores que dictan clase en una grupo
                elseif (substr_count ($username,"profesores_grupo_")) {                    
                        $slug_grupo = str_replace("profesores_grupo_", "", $username);
                        $grupo = $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grupo")->findOneBy(array(
                        'slug' => $slug_grupo
                            ));                    
                        $usuarios=array();
                        $usuarios_ids=array();
                                $c_as=$this->getDoctrine()->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
                                    'grupo' => $grupo->getId()                                 
                                ));                                
                                foreach ($c_as as $c_a) {
                                    $profe=$c_a->getProfesor()->getUsuario();                                                                            
                                    if(!in_array($profe->getId(), $usuarios_ids)){
                                        $usuarios_ids[]=$profe->getId();
                                        $usuarios[]=$profe;
                                    }                                    
                                }
                        
                        
                }                 
                //Acudientes por Sede
                elseif (substr_count ($username,"acudientes_sede_")) {                    
                    $slug_sede = str_replace("acudientes_sede_", "", $username);
                    $sede = $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")->findOneBy(array(
                        'slug' => $slug_sede
                            ));
                    $consulta = $em->createQuery("
                                    SELECT a FROM NetpublicCoreBundle:Alumno a                                    
                                    WHERE a.sede=:id_sede
                                    ");
                    $consulta->setParameter("id_sede", $sede->getId());
                            $usuarios=$consulta->getResult();                     
                } 
                //Acudientes de grados
                elseif (substr_count ($username,"acudientes_grado_")) {                    
                    $slug_grado = str_replace("acudientes_grado_", "", $username);
                    $grado = $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grado")->findOneBy(array(
                        'slug' => $slug_grado
                            ));
                    $consulta = $em->createQuery("
                                    SELECT a FROM NetpublicCoreBundle:Alumno a                                    
                                    WHERE a.grado=:id_grado
                                    ");
                    $consulta->setParameter("id_grado", $grado->getId());
                            $usuarios=$consulta->getResult();                                                                                         
                } 
                //Acudientes de un grupo
                elseif (substr_count ($username,"acudientes_grupo_")) {
                    $slug_grupo = str_replace("acudientes_grupo_", "", $username);
                    $grupo = $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grupo")->findOneBy(array(
                        'slug' => $slug_grupo
                            ));
                    $consulta = $em->createQuery("
                                    SELECT a FROM NetpublicCoreBundle:Alumno a                                    
                                    WHERE a.grupo=:id_grupo
                                    ");
                    $consulta->setParameter("id_grupo", $grupo->getId());
                            $usuarios=$paginador->paginate($consulta)->getResult();                                         
                }

                else{
                    if(is_numeric($username)){
                        $repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:Alumno');        
                        $query = $repository->createQueryBuilder('a');                             
                        $query =  $query->where("a.cedula LIKE :filtro");
                        $query =  $query->setParameter('filtro','%'.$key.'%');         
                        $query = $query->getQuery();      
                        $alumnos= $query->setMaxResults(10)->getResult();            
                        $repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:Profesor');        
                         $query = $repository->createQueryBuilder('a');                                    
                        $query =  $query->where("a.cedula LIKE :filtro");            
                        $query =  $query->setParameter('filtro','%'.$key.'%');         
                        $query = $query->getQuery();      
                        $profesores= $query->setMaxResults(5)->getResult();
                        foreach ($alumnos as $alumno) {
                            $usuarios[]=$alumno->getUsuario();
                        }
                       foreach ($profesores as $mi_profe) {
                        $usuarios[]=$mi_profe->getUsuario();
                    }

                    }
                    else {
                    $repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:Alumno');        
                    $query = $repository->createQueryBuilder('a'); 
                    $query=   $query->join('a.usuario','u');
                    $query =  $query->where("a.nombre LIKE :filtro");
                    $query =  $query->setParameter('filtro','%'.$key.'%');
                    $query =  $query->orWhere("u.username LIKE :filtro1");
                    $query =  $query->setParameter('filtro1','%'.$username.'%');         
                    
                    $query = $query->getQuery();      
                    $alumnos= $query->setMaxResults(10)->getResult();            
                    $repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:Profesor');        
                     $query = $repository->createQueryBuilder('a');
                     $query=   $query->join('a.usuario','u');
                    $query =  $query->where("a.nombre LIKE :filtro");            
                    $query =  $query->setParameter('filtro','%'.$key.'%'); 
                    $query =  $query->orWhere("u.username LIKE :filtro1");
                    $query =  $query->setParameter('filtro1','%'.$username.'%');         
                    
                    $query = $query->getQuery();      
                    $profesores= $query->setMaxResults(5)->getResult();
                    foreach ($alumnos as $alumno) {
                        $usuarios[]=$alumno->getUsuario();
                    }
                    foreach ($profesores as $mi_profe) {
                        $usuarios[]=$mi_profe->getUsuario();
                    }
                        
                    }
                }
      
        $nro_usuarios=  count($usuarios);
        $ano_escolar_activo=  $this->getDoctrine()
                                   ->getRepository("NetpublicCoreBundle:Dimension")
                                  ->findAnoEscolarActivo();
             return array(
            'nro_usuarios'=>$nro_usuarios,
            'ano_escolar_activo'=>$ano_escolar_activo,
            "usuarios"=>$usuarios,                      
              
        );
    }   
    
        /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/{key}/buscardestino", name="usuario_buscardestino")     
     * @Template()
     */
    public function buscardestinoAction($key){  
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $alumnos=  array();
        $profesores=  array();
        
        //$es_archivo=  array();
            $repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:Alumno');        
            $query = $repository->createQueryBuilder('a');                             
            $query =  $query->where("a.cedula LIKE :filtro");
            //Si es un profesor, peude enviar masivamente a sus grupos 
            //En los cuales dicta clase.
            $contexto= $this->get('security.context');
            
            //$query = $query->andWhere()
            $query =  $query->setParameter('filtro','%'.$key.'%');         
            $query =  $query->orWhere("a.nombre LIKE :filtro");            
            $query =  $query->setParameter('filtro','%'.$key.'%');  
            $query = $query->getQuery();      
            //$paginador = $this->get('ideup.simple_paginator');
            //Configuracion Del PAginador.
            // Ahora cada página muestra 20 entidades
            //$paginador->setItemsPerPage(15);
            // Ahora sólo se muestran 5 números de página en el paginador
            //$paginador->setMaxPagerItems(5);

            $alumnos= $query->setMaxResults(5)->getResult();
            
        
             $repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:Profesor');        
            $query = $repository->createQueryBuilder('a');                                    
            $query =  $query->where("a.cedula LIKE :filtro");            
            $query =  $query->setParameter('filtro','%'.$key.'%');         
            $query =  $query->orWhere("a.nombre LIKE :filtro");            
            $query =  $query->setParameter('filtro','%'.$key.'%'); 
            $query = $query->getQuery();      
            //$paginador = $this->get('ideup.simple_paginator');
            //Configuracion Del PAginador.
            // Ahora cada página muestra 20 entidades
            //$paginador->setItemsPerPage(15);
            // Ahora sólo se muestran 5 números de página en el paginador
            //$paginador->setMaxPagerItems(5);
            $profesores= $query->setMaxResults(5)->getResult();
                        
      
    $valores=array();
    //Rector Y coordinador
    
    $valores[]=array('text'=>"@rector");
    $valores[]=array('text'=>"@coordinadores_academico");
    $valores[]=array('text'=>"@coordinadores_convivencia");
    $valores[]=array('text'=>"@auxiliar_administrativa");    
    if(!$user->getEsAlumno() and is_integer($key)==FALSE){
                if($contexto->isGranted('ROLE_PROFESORES')){
                    $profesor_id=$user->getProfesor()->getId();
                    $grupos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
                        "profesor" =>$profesor_id,
                        "es_carga_academica"=>1
                    ));
                    foreach ($grupos as $g){
                         $valores[]=array('text'=>"$g");
                    }
                }
                if($contexto->isGranted('ROLE_RECTOR') || $contexto->isGranted('ROLE_AUXILIAR') ){                    
                    $grupos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(               
                        "es_carga_academica"=>1
                    ));
                    //Todos los Acudientes
                    $text=  Util::getSlug("@acudientes_todos",'_');
                    $valores[]=array('text'=>'@'.$text);    
                    //Todos los profesores
                    $valores[]=array('text'=>"@profesores_todos");    
                    //Todos los alumnos.                    
                    $valores[]=array('text'=>"@alumnos_todos");
                    //Alumnos-Sedes
                    $sedes=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")->findAll();
                    foreach ($sedes as $s){
                        $text=  Util::getSlug("alumnos_sede_"."$s",'_');
                         $valores[]=array('text'=>'@'.$text);
                    }
                    //Alumno-Grados
                    $grados=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grado")->findAll();
                    foreach ($grados as $gr){
                        $text=  Util::getSlug("alumnos_grado_"."$gr",'_');
                         $valores[]=array('text'=>'@'.$text);
                    }
                    //Alumno-Grupos
                    $grupos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grupo")->findAll();
                    foreach ($grupos as $grup){
                        $text=  Util::getSlug("alumnos_grupo_"."$grup",'_');
                         $valores[]=array('text'=>'@'.$text);
                    }                    
                    //Profesores-Sede
                    $grados=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")->findAll();
                    foreach ($grados as $gr){
                        $text=  Util::getSlug("@profesores_sede_"."$gr",'_');
                         $valores[]=array('text'=>'@'.$text);
                    }                    
                    //Profesores-Grados
                    $grados=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grado")->findAll();
                    foreach ($grados as $gr){
                        $text=  Util::getSlug("@profesores_grado_"."$gr",'_');
                         $valores[]=array('text'=>'@'.$text);
                    }
                    //Profesores-Grupo
                    $grupos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grupo")->findAll();
                    foreach ($grupos as $grup){
                        $text=  Util::getSlug("@profesores_grupo_"."$grup",'_');
                         $valores[]=array('text'=>'@'.$text);
                    }                    
                    //Acudientes-Sede
                    $grados=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")->findAll();
                    foreach ($grados as $gr){
                        $text=  Util::getSlug("@acudientes_sede_"."$gr",'_');
                         $valores[]=array('text'=>'@'.$text);
                    }                                        
                    //Acudientes-Grados
                    $grados=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grado")->findAll();
                    foreach ($grados as $gr){
                        $text=  Util::getSlug("@acudientes_grado_"."$gr",'_');
                         $valores[]=array('text'=>'@'.$text);
                    }
                    //Acudientes-Grupos
                    $grupos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grupo")->findAll();
                    foreach ($grupos as $grup){
                        $text=  Util::getSlug("@acudientes_grupo_"."$grup",'_');
                         $valores[]=array('text'=>'@'.$text);
                    }                    
                    
                }
                
            }
            
    foreach ($alumnos as $alumno) {
        if(is_numeric($key))
            $mix='<img src=\'/iNachoLeeYuri/web/uploads/documents/minialumno'.$alumno->getId().'.jpg\' />'.'@'.$alumno->getCedula();
        else
            $mix='<img src=\'/iNachoLeeYuri/web/uploads/documents/minialumno'.$alumno->getId().'.jpg\' />'.'@'.$alumno->getUsuario();
       $valores[]=array(    
           'text'=>$mix    
               );
   }
   foreach ($profesores as $profe) {      
       if(is_numeric($key))
         $key='<img src=\'/iNachoLeeYuri/web/uploads/documents/miniprofesor'.$profe->getId().'.jpg\' />'.'@'.$profe->getCedula();
       else
         $key='<img src=\'/iNachoLeeYuri/web/uploads/documents/miniprofesor'.$profe->getId().'.jpg\' />'.'@'.$profe->getUsuario();
         $valores[]=array(
             'text'=>$key
             );
   }
      $usuarios= array("results"=>$valores);
     //Hay problemas parece ser con la funcion Json de php 
     $respuesta= str_replace('\\','',json_encode($usuarios));
     $response =new \Symfony\Component\HttpFoundation\Response($respuesta);  
    return $response;
    
      
         
    } 
    /**
     * Edits an existing Usuario entity.
     *
     * @Route("/{id}/update", name="usuario_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Usuario:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Usuario')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $editForm   = $this->createForm(new UsuarioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setSalt(md5(time()));
             $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
             $password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
             $entity->setPassword($password);
             if($entity->getEsAlumno())
                $entity->setEsAlumno(TRUE);
             else
                 $entity->setEsAlumno(FALSE);                      
             /*$roles=$entity->getUserRol();
             foreach ($roles as $rol) {
                 $entity->addRol($rol);
                 $em->persist($rol);
             } */            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('usuario_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Usuario entity.
     *
     * @Route("/{id}/delete", name="usuario_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:Usuario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Usuario entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('usuario'));
    }
    /**
     * Lists all Usuario entities.
     *
     * @Route("/filtro", name="usuario_filtro")
     * @Template()
     */
    public function filtroAction()
    { 
        $request = $this->getRequest();
        $mi=json_decode(stripslashes($request->get('asp')), true);
        $mi;
        $query_r=$request->get('query');                
        $repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:Usuario');

        $query = $repository->createQueryBuilder('u');
                        //->andWhere('u.es_alumno=:es_alumno')
                       // ->setParameter('es_alumno',1)
        //Busqueda por letra o nomre
        $query =  $query->join("u.alumno", 'a') ;     
        /*if(is_string($query_r)){
            if(substr_count($query_r,'grupo')>0 || substr_count($query_r,'Grupo')>0 || substr_count($query_r,'grado')>0 || substr_count($query_r,'Grado')>0)
                    ;
            else{                            ;
             $query =  $query->where("a.nombre LIKE :filtro");            
             $query =  $query->setParameter('filtro','%'.$query_r.'%');             
            }
            
        }*/
        
        
        // Busqueda por NOmbre
        /*if(substr_count($query_r,'grado')>0 || substr_count($query_r,'Grado')>0){ 
            //busqueda por grado
        }*/
        // Busquedad por Cedula
        /*if(is_numeric($query_r)){    
                $query =  $query->where("a.cedula LIKE :cedula");            
                $query =  $query->setParameter('cedula','%'.$query_r.'%');      
                /*$query =  $query->andWhere('a.cedula=:cedula');    
                $query =  $query->setParameter('cedula',$query_r);
        }
        */
        //Busqueda por grupo
        /* if(substr_count($query_r,'grupo')>0 || substr_count($query_r,'Grupo')>0){            
            $query_r=str_replace("grupo ","",$query_r);
            $query_r=str_replace("Grupo ","",$query_r);
            $query_r=str_replace("grupo","",$query_r);
            $query_r=str_replace("Grupo","",$query_r);
            $query_r=str_replace(" ","_",$query_r);
            $query_r=strtolower($query_r);
            $grupo_id=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grupo")
                                        ->findBy(array("nombre"=>$query_r));
            if(count($grupo_id)>0){
                $query =  $query->andWhere('a.grupo=:grupo_id');    
                $query =  $query->setParameter('grupo_id',$grupo_id[0]->getId());
                echo $grupo_id[0]->getId();
            }
            else{
                $query =  $query->andWhere('a.grupo=:grupo_id');    
                $query =  $query->setParameter('grupo_id',0);
                echo "mama";
            }
          }
          */
                       // $query =  $query->orderBy('u.id', 'ASC');
                       // $query =  $query->join("u.alumno", 'a') ;  
        
        $query = $query->getQuery();        
        $alumnos = $query->getResult();
        $query = $repository->createQueryBuilder('u')                    
                        ->Where('u.es_alumno=:es_alumno')
                        ->setParameter('es_alumno',1)                        
                        ->join("u.alumno", 'a')     
                        ->orderBy('a.fecha_envio', 'ASC');
            //            ->getQuery();
        $query_grupo=$request->get("grupo");
        if($query_grupo!='*'){
            $query=$query->andWhere("a.grupo=:grupo_id")
                         ->setParameter('grupo_id', $query_grupo); 
        }
        $query_grado=$request->get("grado");
        if($query_grado!='*'){
            $query=$query->andWhere("a.grado=:grado_id")
                         ->setParameter('grado_id', $query_grado); 
        }
        $query=$query->getQuery();
        $alumnos = $query->getResult();
        $query = $repository->createQueryBuilder('u')                    
                        //->andWhere('u.es_alumno=:es_alumno')
                       // ->setParameter('es_alumno',1)
                        ->orderBy('u.id', 'ASC')
                        ->join("u.profesor", 'a')                        
                        ->getQuery();
        
        $profesores = $query->getResult();
        
        return array(
            "alumnos"=>$alumnos,            
            "profesores"=>$profesores
            
        );
    }    

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
