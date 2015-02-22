<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\Mensaje;
use Netpublic\CoreBundle\Form\MensajeType;
use \DateTime;

/**
 * Mensaje controller.
 *
 * @Route("/mensaje")
 */
class MensajeController extends Controller
{
    /**
     * Lists all Mensaje entities.
     *
     * @Route("/", name="mensaje")
     * @Template()
     */
    public function indexAction()
    {
        $request=  $this->getRequest();
        $es_ajax=false;
        $em = $this->getDoctrine()->getEntityManager();

        //$entities = $em->getRepository('NetpublicCoreBundle:Mensaje')->findAll();
        $repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:Mensaje');        
            $query = $repository->createQueryBuilder('a');
        if($request->isXmlHttpRequest()){
            $es_ajax=true;
        }
        $entities= $query->getResult();
        return array(
            'entities' => $entities,
            'es_ajax' =>$es_ajax,
            );
    }

    /**
     * Finds and displays a Mensaje entity.
     *
     * @Route("/{id}/show", name="mensaje_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Mensaje')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mensaje entity.');
        }
        $user = $this->get('security.context')->getToken()->getUser();
        $puedes_mostrar_enlace_descarga=false;
        if($this->getDoctrine()->getRepository("NetpublicCoreBundle:MensajeUsuario")
                ->esDestinatarioMesanje($entity,$user)
                 and $entity->getTipo()==3){
            $puedes_mostrar_enlace_descarga=true;
        }
        $deleteForm = $this->createDeleteForm($id);
        $request=  $this->getRequest();
        $es_ajax=false;
        if ($request->isXmlHttpRequest()){
            $es_ajax=true;                
        }
        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),   
            'es_ajax'=>$es_ajax,
            'puedes_mostrar_enlace_descarga'=>$puedes_mostrar_enlace_descarga,
            'destinatario'=>$user
            );
    }

    /**
     * Displays a form to create a new Mensaje entity.
     *
     * @Route("/new", name="mensaje_new")
     * @Template()
     */
    public function newAction()
    {
        $tipo=0;
        $entity = new Mensaje();
        $user = $this->get('security.context')->getToken()->getUser();
        if($user->getEsAlumno()==FALSE){
            $p=$user->getProfesor();
            //Secretaria y Rector
            if($p->getTipo()==1 || $p->getTipo()==3){
                $tipo=1;
            }
        }
        
        $form   = $this->createForm(new MensajeType($tipo), $entity);
        //Sede
        //$sede=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grupo")->findAll();
        //Grados
        $grados=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grado")->findAll();
        
        //Grupos
        $grupos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grupo")->findAll();
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'grupos' =>$grupos,
            "grados" =>$grados
        );
    }

    /**
     * Creates a new Mensaje entity.
     *
     * @Route("/create", name="mensaje_create")
     * @Method("post")
     * @Template()
     */
    public function createAction()
    {
        $entity  = new Mensaje();
        $request = $this->getRequest();
        $tipo=0;
        $entity = new Mensaje();
        $user = $this->get('security.context')->getToken()->getUser();
        if($user->getEsAlumno()==FALSE){
            $p=$user->getProfesor();
            //Secretaria y Rector
            if($p->getTipo()==1 || $p->getTipo()==3){
                $tipo=1;
            }
        }

        $form    = $this->createForm(new MensajeType($tipo), $entity);
         $form->handleRequest($request);

        if ($form->isValid()) {
            //Establecemos fecha de envio            
            $em = $this->getDoctrine()->getEntityManager();
            $file=$form['doc_adjunto']->getData();
            //Personalizacion cuando es boletin
           if($file){
              $nombre_archivo= date("Ymdhis").'.'.$file->guessExtension();
                 $file->move(__DIR__.'/../../../../../web/'.'uploads/documents',$nombre_archivo);
             $entity->setEsDocumentoAdjunto(TRUE);//uploads/documents/
            $entity->setUrlDocAdjunto($nombre_archivo);
           }
            //echo $file->guessExtension();
            $em->persist($entity);            
            $remitente=$this->get('security.context')->getToken()->getUser();
            
            $destinos=str_replace("'","",$entity->getDestino());                        
            $destinos=str_replace('"',"",$destinos);  
                      
            $destinos=str_replace('<a href=# onclick=eliminar_desitario(this)>X</a>',"",$destinos);
            
            $r_usuarios=  explode(";", $destinos);
            echo $destinos;
            //return new \Symfony\Component\HttpFoundation\Response("od");
            //return new \Symfony\Component\HttpFoundation\Response($destinos);
            $logins=array();
            for ($index1 = 0; $index1 < count($r_usuarios)-1; $index1++) {
                $identificador=  explode("@", $r_usuarios[$index1]);                
                $logins[]=$identificador[1];
                
            }
                      
            //$ids=json_decode(stripslashes($request->get('ids')), true); 
            $fecha_ahora=new DateTime('now');
            for ($index = 0; $index < count($logins); $index++) {
                //
                $username=$logins[$index];
                //Rector
                if($username=="rector"){                    
                    $consulta = $em->createQuery("
                                    SELECT u,u_r FROM NetpublicCoreBundle:Usuario u
                                    JOIN u.user_rol u_r
                                    WHERE u_r.role='ROLE_RECTOR'
                                    ");                    
                    $usuarios = $consulta->getResult();
                    foreach ($usuarios as $usuario) {                                           
                        $mensaje_usuario=new \Netpublic\CoreBundle\Entity\MensajeUsuario();
                        $mensaje_usuario->setDestinatario($usuario);
                        $mensaje_usuario->setRemitente($remitente);
                        $mensaje_usuario->setEsLeido(FALSE);
                        $mensaje_usuario->setFechaEnvio($fecha_ahora);
                        $mensaje_usuario->setMensaje($entity);
                        $em->persist($mensaje_usuario);

                    }
                    
                    
                }
                //Cordinadores academicos.
                elseif ($username=="coordinadores_academico") {
                       $consulta = $em->createQuery("
                                    SELECT u,u_r FROM NetpublicCoreBundle:Usuario u
                                    JOIN u.user_rol u_r
                                    WHERE u_r.role='ROLE_COORACADEMICO'
                                    ");                    
                       $usuarios = $consulta->getResult();
                       foreach ($usuarios as $usuario) {                                          
                        $mensaje_usuario=new \Netpublic\CoreBundle\Entity\MensajeUsuario();   
                        $mensaje_usuario->setDestinatario($usuario);
                        $mensaje_usuario->setRemitente($remitente);
                        $mensaje_usuario->setEsLeido(FALSE);
                        $mensaje_usuario->setFechaEnvio($fecha_ahora);
                        $mensaje_usuario->setMensaje($entity);
                        $em->persist($mensaje_usuario);
                    }
                }
                //Cordinadores Convivencia.
                elseif ($username=="coordinadores_convivencia") {
                                            $consulta = $em->createQuery("
                                    SELECT u,u_r FROM NetpublicCoreBundle:Usuario u
                                    JOIN u.user_rol u_r
                                    WHERE u_r.role='ROLE_COORDCONVIVENCIA'
                                    ");                    
                    $usuarios = $consulta->getResult();
                    foreach ($usuarios as $usuario) {                                           
                        $mensaje_usuario=new \Netpublic\CoreBundle\Entity\MensajeUsuario();
                        $mensaje_usuario->setDestinatario($usuario);
                        $mensaje_usuario->setRemitente($remitente);
                        $mensaje_usuario->setEsLeido(FALSE);
                        $mensaje_usuario->setFechaEnvio($fecha_ahora);
                        $mensaje_usuario->setMensaje($entity);
                        $em->persist($mensaje_usuario);
                    }

                }
                //Auxiliar Administrativa.
                elseif ($username=="auxiliar_administrativa") {
                    $consulta = $em->createQuery("
                                    SELECT u,u_r FROM NetpublicCoreBundle:Usuario u
                                    JOIN u.user_rol u_r
                                    WHERE u_r.role='ROLE_AUXILIAR'
                                    ");                    
                    $usuarios = $consulta->getResult();
                    foreach ($usuarios as $usuario) {                                           
                        $mensaje_usuario=new \Netpublic\CoreBundle\Entity\MensajeUsuario();
                        $mensaje_usuario->setDestinatario($usuario);
                        $mensaje_usuario->setRemitente($remitente);
                        $mensaje_usuario->setEsLeido(FALSE);
                        $mensaje_usuario->setFechaEnvio($fecha_ahora);
                        $mensaje_usuario->setMensaje($entity);
                        $em->persist($mensaje_usuario);
                    }

                }                
                //Todos los acudientes.
                elseif ($username=="acudientes_todos") {
                   $consulta = $em->createQuery("
                                    SELECT u FROM NetpublicCoreBundle:Usuario u
                                    JOIN u.alumno a
                                    WHERE a.tipo=1
                                    ");                    
                    $usuarios = $consulta->getResult();
                    foreach ($usuarios as $usuario) {                                           
                        $mensaje_usuario=new \Netpublic\CoreBundle\Entity\MensajeUsuario();
                        $mensaje_usuario->setDestinatario($usuario);
                        $mensaje_usuario->setRemitente($remitente);
                        $mensaje_usuario->setEsLeido(FALSE);
                        $mensaje_usuario->setFechaEnvio($fecha_ahora);
                        $mensaje_usuario->setMensaje($entity);
                        $em->persist($mensaje_usuario);
                    }
    
                }                
                //Todos los Profesores.
                elseif ($username=="profesores_todos") {
                    
                   $consulta = $em->createQuery("
                                    SELECT u,p FROM NetpublicCoreBundle:Usuario u
                                    JOIN u.profesor p
                                    WHERE p.tipo=2
                                    ");                    
                    $usuarios = $consulta->getResult();
                    foreach ($usuarios as $usuario) {                                           
                        $mensaje_usuario=new \Netpublic\CoreBundle\Entity\MensajeUsuario();
                        $mensaje_usuario->setDestinatario($usuario);
                        $mensaje_usuario->setRemitente($remitente);
                        $mensaje_usuario->setEsLeido(FALSE);
                        $mensaje_usuario->setFechaEnvio($fecha_ahora);
                        $mensaje_usuario->setMensaje($entity);
                        $em->persist($mensaje_usuario);
                    }
                }                
                //Todos los alumnos.
                elseif ($username=="alumnos_todos") {
                   $consulta = $em->createQuery("
                                    SELECT u FROM NetpublicCoreBundle:Usuario u
                                    JOIN u.alumno a
                                    WHERE a.tipo=0
                                    ");                    
                    $usuarios = $consulta->getResult();
                    foreach ($usuarios as $usuario) {                                           
                        $mensaje_usuario=new \Netpublic\CoreBundle\Entity\MensajeUsuario();
                        $mensaje_usuario->setDestinatario($usuario);
                        $mensaje_usuario->setRemitente($remitente);
                        $mensaje_usuario->setEsLeido(FALSE);
                        $mensaje_usuario->setFechaEnvio($fecha_ahora);
                        $mensaje_usuario->setMensaje($entity);
                        $em->persist($mensaje_usuario);
                    }
                        
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
                    $usuarios = $consulta->getResult();
                    foreach ($usuarios as $usuario) {                                           
                        $mensaje_usuario=new \Netpublic\CoreBundle\Entity\MensajeUsuario();
                        $mensaje_usuario->setDestinatario($usuario);
                        $mensaje_usuario->setRemitente($remitente);
                        $mensaje_usuario->setEsLeido(FALSE);
                        $mensaje_usuario->setFechaEnvio($fecha_ahora);
                        $mensaje_usuario->setMensaje($entity);
                        $em->persist($mensaje_usuario);
                    }

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
                    $usuarios = $consulta->getResult();
                    foreach ($usuarios as $usuario) {
                        $mensaje_usuario = new \Netpublic\CoreBundle\Entity\MensajeUsuario();
                        $mensaje_usuario->setDestinatario($usuario);
                        $mensaje_usuario->setRemitente($remitente);
                        $mensaje_usuario->setEsLeido(FALSE);
                        $mensaje_usuario->setFechaEnvio($fecha_ahora);
                        $mensaje_usuario->setMensaje($entity);
                        $em->persist($mensaje_usuario);
                    }

                    
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
                    $usuarios = $consulta->getResult();
                    foreach ($usuarios as $usuario) {
                        $mensaje_usuario = new \Netpublic\CoreBundle\Entity\MensajeUsuario();
                        $mensaje_usuario->setDestinatario($usuario);
                        $mensaje_usuario->setRemitente($remitente);
                        $mensaje_usuario->setEsLeido(FALSE);
                        $mensaje_usuario->setFechaEnvio($fecha_ahora);
                        $mensaje_usuario->setMensaje($entity);
                        $em->persist($mensaje_usuario);
                    }                       
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
                    $usuarios = $consulta->getResult();
                    foreach ($usuarios as $usuario) {                                           
                        $mensaje_usuario=new \Netpublic\CoreBundle\Entity\MensajeUsuario();
                        $mensaje_usuario->setDestinatario($usuario);
                        $mensaje_usuario->setRemitente($remitente);
                        $mensaje_usuario->setEsLeido(FALSE);
                        $mensaje_usuario->setFechaEnvio($fecha_ahora);
                        $mensaje_usuario->setMensaje($entity);
                        $em->persist($mensaje_usuario);
                    }

                        
                        
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
                        foreach ($usuarios as $usuario) {                                           
                        $mensaje_usuario=new \Netpublic\CoreBundle\Entity\MensajeUsuario();
                        $mensaje_usuario->setDestinatario($usuario);
                        $mensaje_usuario->setRemitente($remitente);
                        $mensaje_usuario->setEsLeido(FALSE);
                        $mensaje_usuario->setFechaEnvio($fecha_ahora);
                        $mensaje_usuario->setMensaje($entity);
                        $em->persist($mensaje_usuario);
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
                        
                        foreach ($usuarios as $usuario) {                                           
                        $mensaje_usuario=new \Netpublic\CoreBundle\Entity\MensajeUsuario();
                        $mensaje_usuario->setDestinatario($usuario);
                        $mensaje_usuario->setRemitente($remitente);
                        $mensaje_usuario->setEsLeido(FALSE);
                        $mensaje_usuario->setFechaEnvio($fecha_ahora);
                        $mensaje_usuario->setMensaje($entity);
                        $em->persist($mensaje_usuario);
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
                                    WHERE a.sede=:id_sede and a.tipo=0
                                    ");
                    $consulta->setParameter("id_sede", $sede->getId());
                    $usuarios = $consulta->getResult();
                    foreach ($usuarios as $usuario) {
                        $acudiente=$usuario->getAcudiente();
                        if($acudiente){
                            $usuario_=$acudiente->getUsuario();
                            $mensaje_usuario = new \Netpublic\CoreBundle\Entity\MensajeUsuario();
                            $mensaje_usuario->setDestinatario($usuario_);
                            echo $usuario_;
                            $mensaje_usuario->setRemitente($remitente);
                            $mensaje_usuario->setEsLeido(FALSE);
                            $mensaje_usuario->setFechaEnvio($fecha_ahora);
                            $mensaje_usuario->setMensaje($entity);
                            $em->persist($mensaje_usuario);
                        }
                    }

                        //$nombre_grupo=  str_replace("acudientes_grado_",'',$username);
                        //return new \Symfony\Component\HttpFoundation\Response("Vamos a enviar mensaje a ".$nombre_grupo);
                } 
                //Acudientes de grados
                elseif (substr_count ($username,"acudientes_grado_")) {                    
                    $slug_grado = str_replace("acudientes_grado_", "", $username);
                    $grado = $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grado")->findOneBy(array(
                        'slug' => $slug_grado
                            ));
                    $consulta = $em->createQuery("
                                    SELECT a FROM NetpublicCoreBundle:Alumno a                                    
                                    WHERE a.grado=:id_grado and a.tipo=0
                                    ");
                    $consulta->setParameter("id_grado", $grado->getId());
                    $usuarios = $consulta->getResult();
                    foreach ($usuarios as $usuario) {
                        $acudiente=$usuario->getAcudiente();
                        if($acudiente){
                            $usuario_=$acudiente->getUsuario();
                            $mensaje_usuario = new \Netpublic\CoreBundle\Entity\MensajeUsuario();
                            $mensaje_usuario->setDestinatario($usuario_);                            
                            $mensaje_usuario->setRemitente($remitente);
                            $mensaje_usuario->setEsLeido(FALSE);
                            $mensaje_usuario->setFechaEnvio($fecha_ahora);
                            $mensaje_usuario->setMensaje($entity);
                            $em->persist($mensaje_usuario);
                        }
                    }
                    
                        
                        
                } 
                //Acudientes de un grupo
                elseif (substr_count ($username,"acudientes_grupo_")) {
                    $slug_grupo = str_replace("acudientes_grupo_", "", $username);
                    $grupo = $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grupo")->findOneBy(array(
                        'slug' => $slug_grupo
                            ));
                    $consulta = $em->createQuery("
                                    SELECT a FROM NetpublicCoreBundle:Alumno a                                    
                                    WHERE a.grupo=:id_grupo and a.tipo=0
                                    ");
                    $consulta->setParameter("id_grupo", $grupo->getId());
                    $usuarios = $consulta->getResult();
                    foreach ($usuarios as $usuario) {
                        $acudiente=$usuario->getAcudiente();
                        if($acudiente){
                            $usuario_=$acudiente->getUsuario();
                            $mensaje_usuario = new \Netpublic\CoreBundle\Entity\MensajeUsuario();
                            $mensaje_usuario->setDestinatario($usuario_);
                            echo $usuario_;
                            $mensaje_usuario->setRemitente($remitente);
                            $mensaje_usuario->setEsLeido(FALSE);
                            $mensaje_usuario->setFechaEnvio($fecha_ahora);
                            $mensaje_usuario->setMensaje($entity);
                            $em->persist($mensaje_usuario);
                        }
                    }
                    
                }

                else{
                    if(is_numeric($username)){
                        $alumno=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")->findOneBy(array(
                        "cedula"=>$username
                        ));
                        if($alumno){
                            $usuario=$alumno->getUsuario();
                        }
                        else{
                            
                            $profesor=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Profesor")->findOneBy(array(
                                "cedula"=>$username
                            ));
                            $usuario=$profesor->getUsuario();
                            
                        }
                    }
                    else {                        
                        $usuario=$this->getDoctrine()
                                ->getRepository("NetpublicCoreBundle:Usuario")
                                ->findOneBy(array(
                        "username"=>$username
                        ));        
                    }
                    $mensaje_usuario = new \Netpublic\CoreBundle\Entity\MensajeUsuario();
                    $mensaje_usuario->setDestinatario($usuario);
                    $mensaje_usuario->setRemitente($remitente);
                    $mensaje_usuario->setEsLeido(FALSE);
                    $mensaje_usuario->setFechaEnvio($fecha_ahora);
                    $mensaje_usuario->setMensaje($entity);
                    $em->persist($mensaje_usuario);

                }
                 
                
            }            
            $em->flush();
            //return new \Symfony\Component\HttpFoundation\Response("kkkkkkk");
            //$this->redirect($this->generateUrl('mensaje_show', array('id' => $entity->getId())));
            return new \Symfony\Component\HttpFoundation\RedirectResponse(
                    $this->generateUrl('mensaje_show', array('id' => $entity->getId()))
            
                    );
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Mensaje entity.
     *
     * @Route("/{id}/edit", name="mensaje_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Mensaje')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mensaje entity.');
        }

        $editForm = $this->createForm(new MensajeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Mensaje entity.
     *
     * @Route("/{id}/update", name="mensaje_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Mensaje:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Mensaje')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mensaje entity.');
        }

        $editForm   = $this->createForm(new MensajeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mensaje_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Mensaje entity.
     *
     * @Route("/{id}/delete", name="mensaje_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:Mensaje')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Mensaje entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('mensaje'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
