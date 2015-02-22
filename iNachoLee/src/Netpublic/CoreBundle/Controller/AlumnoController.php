<?php

namespace Netpublic\CoreBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\Alumno;
use Netpublic\CoreBundle\Entity\Dimension;
use Netpublic\CoreBundle\Entity\Grupo;
use Netpublic\CoreBundle\Entity\AlumnoDimension;
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
 * Alumno controller.
 *
 * @Route("/alumno")
 */
class AlumnoController extends CustomController
{
     /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/{alumno_id}/vermatricula", name="alumno_vermatricula")     
     * @Template()
     */
    public function vermatriculaAction($alumno_id){
        $em=  $this->getDoctrine()->getManager();
        $matriculas=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findBy(array(
            'alumno'=>$alumno_id
        ));
        $grados=$em->getRepository("NetpublicCoreBundle:Grado")->findAll();
        $alumno=$em->getRepository("NetpublicCoreBundle:Alumno")->find($alumno_id);
        return array(
            "matriculas"=>$matriculas,
            "alumno"=>$alumno,
            "grados"=>$grados
        );
    }
    /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/{tipo}/{ano_id}/veralumnoslista", name="carga_academica_veralumnoslista")     
     * @Template("NetpublicCoreBundle:CargaAcademica:vergrupolista.html.twig")
     */
    public function veralumnoslistaAction($tipo,$ano_id){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $request=  $this->getRequest();
        $em=  $this->getDoctrine()->getEntityManager();
        $periodo=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodoEscolar($ano_id);
        $periodo_id=$periodo->getId();
        
        $key=  Util::getSlug($request->get("query"),"");
        
        $query="SELECT a,ma FROM NetpublicCoreBundle:MatriculaAlumno ma JOIN ma.alumno a LEFT JOIN ma.grupo g";
        $query.=" WHERE ( a!=0 ";
        if($key!='*' && $key!=""){
            $query.=" AND (a.cedula LIKE :key";        
            $query.=" OR a.nombre_completo LIKE :key) ";
            $query.=" AND ma.ano=:ano ";
            
        }
        $query.=" )"; 
        
        $usuarios=  $em->createQuery($query);
        if($key!='*' && $key!=""){
                $usuarios->setParameter("key",'%'.$key.'%');
                $usuarios->setParameter("ano",$ano_id);
                
        }
        $usuarios=$usuarios->setMaxResults(60);
        $m_alumnos=$usuarios->getResult();
        
        $entities=array();
        $a_t=array();
        $alumnos=array();
        foreach ($m_alumnos as $m_alumno) {
            if($m_alumno->getGrupo()){
                $grado=$m_alumno->getGrupo()->getGrado();
            
                $asg=$em->getRepository("NetpublicCoreBundle:Asignatura")->findOneBy(array(
                    'es_area'=>0,
                    'grado'=>$grado->getId()
                ));
                $asg_id=$asg->getId();
            }
            else{
                $asg_id=0;
            }
            $notas=$em->getRepository("NetpublicCoreBundle:Alumno")
                         ->findNotas($m_alumno->getAlumno()->getId(),$periodo_id,$asg_id);
            
            foreach ($notas as $nota) {
                    $a_t[]=$nota;
                   
                }
                $entities[]=$a_t;
                $a_t=array();
            $alumnos[]=$m_alumno->getAlumno();
        }
        
        $grupos=array();
        foreach ($m_alumnos as $ma) {
            $grupos[]=$ma->getGrupo();
        }
        return array(
            'alumnos'=>$alumnos,
            'entities'=>$entities,
            'tipo'=>$tipo,
            'grupos'=>$grupos
        );
        
    }
    /**
     * Lists all Grupo entities.
     * 
     * @Route("/{matricula_id}/{grupo_id}/actualizarmatricula", name="alumno_actualizarmatricula")
     * @Template()
     */
    public function actualizarmatriculaAction($matricula_id,$grupo_id)
    {
        if($grupo_id!='*'){
            $em= $this->getDoctrine()->getManager();
            $matricula=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->find($matricula_id);
            $grupo=$em->getRepository("NetpublicCoreBundle:Grupo")->find($grupo_id);
            //$matricula=new MatriculaAlumno();
            $matricula->setGrupo($grupo);
            $em->persist($matricula);
            $em->flush();
        }
        
    return new Response("ok");
    }
     /**
     * Lists all Grupo entities.
     * 
     * @Route("/{alumno_id}/{grupo_id}/{ano_id}/nuevamatricula", name="alumno_nuevamatricula")
     * @Template()
     */
    public function nuevamatriculaAction($alumno_id,$grupo_id,$ano_id)
    {
        if($grupo_id!='*'){
            $em= $this->getDoctrine()->getManager();
            //$matricula=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->find($matricula_id);
            $alumno=$em->getRepository("NetpublicCoreBundle:Alumno")->find($alumno_id);
            $ano=$em->getRepository("NetpublicCoreBundle:Dimension")->find($ano_id);
            $grupo=$em->getRepository("NetpublicCoreBundle:Grupo")->find($grupo_id);
            $matricula=new MatriculaAlumno();
            $matricula->setGrupo($grupo);
            $matricula->setAlumno($alumno);
            $matricula->setAno($ano);
            $matricula->setEsMatricula(TRUE);
            $matricula->setEsPagoMatricula(TRUE);
            $matricula->setEsPapeles(TRUE);
            $matricula->setEsMatricula(TRUE);
            $matricula->setObservaciones("..");
            $em->persist($matricula);
            
            $em->flush();
        }
        
    return new Response("ok");
    }   
    /**
     * Lists all Grupo entities.
     * 
     * @Route("/{periodo_id}/{asg_id}/{alumno_id}/nota", name="alumno_nota")
     * @Template()
     */
    public function notaAction($periodo_id,$asg_id,$alumno_id)
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $em=  $this->getDoctrine()->getManager();
        $alumnos=$em->getRepository("NetpublicCoreBundle:Alumno")->findBy(array(
            'grupo'=>1),
            array(
            'apellido'=>"ASC"
                )
        );
        $entities=$em->getRepository("NetpublicCoreBundle:Grupo")->findNotasPeriodoEscolar($alumnos,$periodo_id,$asg_id);
        return array(
            'carga_academica'=>2,
            'alumnos'=>$alumnos,
            'entities'=>$entities
        );
        
    }
    /**
     * Lists all Grupo entities.
     * 
     * @Route("/listaricfes", name="alumno_listaricfes")
     * @Template()
     */
    public function listaricfesAction()
    {
        $em = $this->getDoctrine()->getManager(); 
        
        $request=  $this->getRequest();
        $q=$request->get('query');
        $q=str_replace(" ","",$q);
        $q=str_replace("  ","",$q);
        
        $repository = $this->getDoctrine()
                             ->getRepository('NetpublicCoreBundle:Alumno');        
        $query = $repository->createQueryBuilder('p');                     
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
        $query=$query->andWhere("p.tipo=0");
        $query=$query->setMaxResults(40);
        $query=$query->orderBy('p.apellido', 'ASC');     
        $query = $query->getQuery();      
        $entities= $query->getResult();
        
        return array(
           'entities'=>$entities,
       );

    }
 
    /**
     * Lists all Grupo entities.
     * 
     * @Route("/{label}/filtropromover.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|json|pdf"}, name="alumno_filtropromover")
     * @Template()
     */
    public function filtropromoverAction($label)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $query="SELECT a FROM NetpublicCoreBundle:Alumno a";
        
        $query.=" WHERE ( a!=0 ";
        if($label=='Reprueban'){
            $query.=" AND a.situacion_academica_ano_anterior=2";        
        }
        if($label=='Aprueban'){
            $query.="  AND a.situacion_academica_ano_anterior=1";
        }
        if($label=='Recuperan'){
            $query.=" AND a.es_habilitacion=1";        
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
        if($request->get('_format')=='json'){
        }
        return array(
            'alumnos' => $usuarios,
            );
    }

    
      /**
     * Lists all Grupo entities.
     * 
     * @Route("/{grado_id}/alumnosgradotree.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|json|pdf"}, name="alumno_alumnosgradotree")
     * @Template()
     */
    public function alumnosgradotreeAction($grado_id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $alumnos=$em->getRepository("NetpublicCoreBundle:Alumno")->findBy(array(
            'grado'=>$grado_id
        ));
        $alumnos_json=array();
        if($request->get('_format')=='json'){
            foreach ($alumnos as $aj) {
                $alumnos_json[]=$aj->getId();
            }
            return new \Symfony\Component\HttpFoundation\JsonResponse($alumnos_json);
        }
        return array(
            'alumnos' => $alumnos,
            );
    }


     /**
     * Lists all Grupo entities.
     *     * 
     * @Route("/{grupo_id}/alumnostree.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|json|pdf"}, name="alumno_alumnostree")
     * @Template()
     */
    public function alumnostreeAction($grupo_id)
    {
        $em=  $this->getDoctrine()->getManager();
        $request=  $this->getRequest();
        $session=$request->getSession();
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                               ->findAnoEscolarActivo();
        $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
        $alumnos=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findAlumnos($ano_escolar_id_s,$grupo_id);
        if(!count($alumnos)){
            $alumnos=$em->getRepository("NetpublicCoreBundle:Alumno")->findBy(array(
                'grupo'=>$grupo_id
            ));
            
        }
        $alumnos_json=array();
        foreach ($alumnos as $aj) {
                $alumnos_json[]=$aj->getId();
        }
        if($request->get('_format')=='json'){
            
            return new \Symfony\Component\HttpFoundation\JsonResponse($alumnos_json);
        }
        return array(
            'alumnos' => $alumnos
            );
    }

     /**
     * Lists all Alumno entities.
     *
     * @Route("/getalumnos", name="alumno_getalumnos")
     * @Template()
     */
    public function getalumnosAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $alumnos_a=array();
        $alumnos_aa=array();
        $alumnos_resultado=array();
        $session=  $this->getRequest()->getSession();
        $desempeno_sesion=$em->getRepository("NetpublicCoreBundle:Desempeno")->find($session->get("id_desempeno"));
        $grupos=$desempeno_sesion->getGrupo();
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                               ->findAnoEscolarActivo();
        $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
        
        foreach ($grupos as $grupo) {
            $alumnos_a=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findBy(array(
               'grupo'=>$grupo->getId(),
               'ano'=>$ano_escolar_id_s 
                ));
        
        }
        foreach ($alumnos_a as $alumno) {
            $alumnos_resultado[]=array(
                "id"=>$alumno->getAlumno()->getId(),
                "nombre"=>"$alumno"
                 );
        }
        return new Response(json_encode($alumnos_resultado));
                
    }
    /**
     * Lists all Alumno entities.
     *
     * @Route("/updatedesempenos", name="alumno_updatedesempenos")
     * @Template()
     */
    public function updatedesempenosAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();        
        $request=$this->getRequest();
        $user = $this->get('security.context')->getToken()->getUser();
        
        if(($user->getEsAlumno()==FALSE)){
            $profesor_id=$user->getProfesor()->getId();  
        }
        
        $periodo_id=$request->get("periodo_id");
        $periodo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);
        $grupo_id=$request->get("grupo_id");
        $ca_id=$request->get("ca_id");
        $alumno_id=$request->get("alumno_id");
        $alumno=$em->getRepository("NetpublicCoreBundle:Alumno")->find($alumno_id);
        $asignatura_id=$request->get("asignatura_id");
        //Publicamos los Desempeños.
        $desempenos=$em->getRepository("NetpublicCoreBundle:Desempeno")
                       ->findDesempenosAsignaturaProfe(
                               $ca_id,                               
                               $periodo_id,
                               $grupo_id,
                               $profesor_id);
              
        $em->getRepository("NetpublicCoreBundle:Alumno")
           ->publicarDesempenos($alumno,$asignatura_id,$periodo,$desempenos);
        
        $em->flush();
        return new Response("ok");
        
    }

         /**
     * Lists all Alumno entities.
     *
     * @Route("/guardarfallas", name="alumno_guardarfallas")
     * @Template()
     */
    public function guardarfallasAction()
    {
        $request=$this->getRequest();
        $em=  $this->getDoctrine()->getEntityManager();
        $id_falla=json_decode($request->get('ids_notas'));
        $falla=json_decode($request->get('values_notas'));
        for ($index = 0; $index < count($falla); $index++) {
            $mi_falla=$em->getRepository("NetpublicCoreBundle:AlumnoDimension")
                         ->find($id_falla[$index]);
            $mi_falla->setNota($falla[$index]);
            $em->persist($mi_falla);
        }
        $em->flush();
        return new Response($mi_falla->getNota());
        
    }
     /**
     * Lists all Alumno entities.
     *
     * @Route("/cambiarnotarecuperacion", name="alumno_cambiarnotarecuperacion")
     * @Template()
     */
    public function cambiarnotarecuperacionAction()
    {
        $request=  $this->getRequest();
        $em=  $this->getDoctrine()->getEntityManager();
        $nuevo_valor=$request->get('nueva_nota');
        $id_nota_periodo=$request->get('id_nota_periodo');
        $id_nota_recuperacion=$request->get('id_nota_recuperacion');
        $observacion=$request->get('observacion');
        $nota_periodo=$em->getRepository("NetpublicCoreBundle:AlumnoDimension")->find($id_nota_periodo);
        $nota_periodo->setNota($nuevo_valor);
        $nota_recuperacion=$em->getRepository("NetpublicCoreBundle:NotaRecuperacion")->find($id_nota_recuperacion);
        $nota_recuperacion->setNotaRecuperacion($nuevo_valor);
        $nota_recuperacion->setObservacion($observacion);
        $em->persist($nota_periodo);
        $em->persist($nota_recuperacion);
        $em->flush();
        return new Response("ok");
        
    }
         /**
     * Lists all Alumno entities.
     *
     * @Route("/cambiarnotarecuperacionobservacion", name="alumno_cambiarnotarecuperacionobservacion")
     * @Template()
     */
    public function cambiarnotarecuperacionobservacionAction()
    {
        $request=  $this->getRequest();
        $em=  $this->getDoctrine()->getEntityManager();
        $nuevo_valor=$request->get('nueva_nota');
        $id_nota_periodo=$request->get('id_recuperacion');
        $observacion=$request->get('observacion');
        $nota_recuperacion=$em->getRepository("NetpublicCoreBundle:NotaRecuperacion")->find($id_nota_periodo);
        $nota_recuperacion->setNotaRecuperacion($nuevo_valor);
        $nota_recuperacion->setObservacion($observacion);
        $em->persist($nota_recuperacion);
        $em->flush();
        return new Response("ok");
        
    }

     /**
     * Lists all Alumno entities.
     *
     * @Route("/guardarnotas", name="alumno_guardarnotas")
     * @Template()
     */
    public function guardarnotasAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();
        
        $request=$this->getRequest();
        $session=$request->getSession();
        $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                            ->findPeriodoEscolarActivo();
        $periodo_id=$session->get('perido_id',$periodo_activo->getId());
        $grupo_id=$session->get('grupo_id');
        $asignatura_id=$session->get('asignatura_id');
        $periodo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);      
        if($periodo->getTipo()==4){
            $padre_p=$periodo->getPadre();
        }
        else{
            $padre_p=$periodo;
        }
        //echo "$padre_p tipo:{$padre_p->getTipo()}";
   
        $user = $this->get('security.context')->getToken()->getUser();
        if(($user->getEsAlumno()==FALSE)){
            $profesor_id=$user->getProfesor()->getId();  
        }
        $padre_id=$request->get('padre');
        $alumno_id=$request->get('alumno_id');
        $ids_notas=json_decode($request->get('ids_notas'));
        $values_notas=json_decode($request->get('values_notas'));
        
        $publicacion_periodo=  $em->getRepository("NetpublicCoreBundle:PublicacionPeriodosProfesores")
                                  ->findOneBy(array(
                                      'profesor'=>$profesor_id,
                                      'periodo_academico'=>$padre_p->getId()
                                  ));
        $hoy=new \DateTime("now");
        //echo $hoy->format("Y-m-d H:i:s");
        $hoy->setTime($hoy->format('H'),$hoy->format('i')+15,$hoy->format('s')+30);
        
        $publicacion_periodo->setFechaUltimoPublicacion($hoy);
        $alumno=$em->getRepository("NetpublicCoreBundle:Alumno")->find($alumno_id);
        $nota_padre=$em->getRepository("NetpublicCoreBundle:Alumno")
           ->gruardarNotasAlumno($ids_notas,$values_notas,$padre_id);
        $padre_ad=$em->getRepository("NetpublicCoreBundle:AlumnoDimension")->find($padre_id);
        $padre=$padre_ad->getDimension();
        if($padre->getTipo()==4)
        {
            $notas_nivel_2=$this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Grupo")
                               ->findNotaAlumnoAsignaturaProfesor($alumno->getId(),$profesor_id,$padre->getPadre(), $asignatura_id);
            $promedio_ns=0;
            $total_ponderado=0;
            foreach ($notas_nivel_2 as $nota) {
                if($nota->getDimension()->getTipo()==4){
                    $ponderado=$nota->getDimension()->getPonderado();        
                    $promedio_ns=$promedio_ns+$nota->getNota()*$ponderado;
                    $total_ponderado+=$ponderado;
                }
                if($nota->getDimension()->getTipo()==1){
                    $nota->setNota(number_format($promedio_ns/$total_ponderado,1));
                    $em->persist($nota);                
                }
            }
        
        }
        //Publicamos Notas.           
        $asignatura=$em->getRepository("NetpublicCoreBundle:Asignatura")
                       ->find($session->get('asignatura_id'));
        $area_id=$asignatura->getArea()->getId();
        $em->getRepository("NetpublicCoreBundle:Alumno")
           ->publicarNotasAlumno($area_id,$alumno_id,$periodo_id);
        //Publicamos los Desempeños.
        $desempenos=$em->getRepository("NetpublicCoreBundle:Desempeno")
                       ->findDesempenosAsignaturaProfe(
                               $session->get('carga_academica_id'),                               
                               $padre_p->getId(),
                               $grupo_id,
                               $profesor_id);
              
        $em->getRepository("NetpublicCoreBundle:Alumno")
           ->publicarDesempenos($alumno,$session->get('asignatura_id'),$padre_p,$desempenos);
        
        $publicacion_periodo->setTipo(1);
        $em->persist($publicacion_periodo);        
        $em->flush();
        return new Response($nota_padre);
    }
    
     /**
     * Lists all Alumno entities.
     *
     * @Route("/{id_alumno}/geturlfotoperfil", name="alumno_geturlfotoperfil")
     * @Template()
     */
    public function geturlfotoperfilAction($id_alumno)
    {
        $alumno=  $this->getDoctrine()
                ->getRepository("NetpublicCoreBundle:Alumno")
                ->find($id_alumno);
        if($alumno->getUsuario()->getEsFotoperfil()==TRUE)
            $repuesta=1;
        else
            $repuesta=0;
        //$respuesta='<a class="thumbnail" href="#" style="margin-right:10px;"><img style="width:80px;height: 80px;" src="/iNachoLeeYuri/web/uploads/documents/strongavatar.png" /> </a>';      
        //$request=  $this->getRequest();
        //echo $request->getRequestUri();
        return array(
            "alumno_id"=>$id_alumno,
            "repuesta"=>$repuesta
        );
    }
    /**
     * Lists all Alumno entities.
     *
     * @Route("/", name="alumno")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('NetpublicCoreBundle:Alumno')->findAll();

        return array('entities' => $entities);
    }
      /**
     * Lists all Alumno entities.
     *
     * @Route("/{id_alumno}/horarioclase", name="alumno_horarioclase")
     * @Template()
     */
    public function horarioclaseAction($id_alumno)
    {        
        $em=  $this->getDoctrine()->getEntityManager();
        $celdas_h_c=array();
        $horas=array();
        $entity = $em->getRepository('NetpublicCoreBundle:Alumno')->find($id_alumno);
        $posicion=1;
         $contador=1;
        for ($index = 0; $index < 24; $index++) {
           
            for ($index1 = 0; $index1 < 7; $index1++) {
               $celdas_h_c[$posicion]=array(
                                        "es_libre"=>1,
                                         "carga_academica"=>"libre"
                                         );
               if((6+$index)>=25){
                   $horas[]=$contador;
                   
               }
               else{
                $horas[]=6+$index;
               }
               $posicion++;
            }
            if((6+$index)>=25){
            $contador++;
            }
            
        }
        $query="SELECT h_c,c_a FROM NetpublicCoreBundle:HorarioClase h_c JOIN h_c.carga_academica c_a ";
        $query.=" WHERE (";        
        $query.=" c_a.grupo=:grupo_id)";                    
        $query.=" ORDER BY h_c.posicion ASC";        
        $horarios_clase=$em->createQuery($query)                
                     ->setParameters(array(
                                         "grupo_id"=>$entity->getGrupo()->getId()
                                      ))->getResult(); 
        foreach ($horarios_clase as $h_c) {
                 
                 $celdas_h_c[$h_c->getPosicion()]=array(
                     "es_libre"=>0,
                     "carga_academica"=>$h_c->getCargaAcademica()
                     
                     );
        }
        return array(
            'celdas_h_c'=>$celdas_h_c,
            'horas'=>$horas,
            'grupo'=>$entity->getGrupo()
            );
    }
    /**
     * Lists all Alumno entities.
     *
     * @Route("/mejores", name="alumno_mejores")
     * @Template()
     */
    public function mejoresAction()
    {
        set_time_limit(0);
        $em = $this->getDoctrine()->getEntityManager();
        $ano_escolar_activo=  $this->getDoctrine()
                                    ->getRepository("NetpublicCoreBundle:Dimension")
                                    ->findAnoEscolarActivo();
        $periodo_escolar_activo= $this->getDoctrine()
                                    ->getRepository("NetpublicCoreBundle:Dimension")
                                    ->findPeriodoEscolarActivo();

        $entities = $this
                        ->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:Dimension')
                        ->findBy(array(
            "tipo"=>0
        ));
        $sedes = $this
                        ->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:Colegio')
                        ->findAll();
        $grados = $this
                        ->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:Grado')
                        ->findAll();
        $grupos = $this
                        ->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:Grupo')
                        ->findAll();
        $this->getDoctrine()
                ->getRepository("NetpublicCoreBundle:NivelAcademico")
                      ->generarNivelesACademicos(); 
        
        return array(
            'entities' => $entities,
            "grados"=>$grados,
            "grupos"=>$grupos,
            "sedes"=>$sedes,
            'ano_escolar_activo'=>$ano_escolar_activo,
            'periodo_escolar_activo'=>$periodo_escolar_activo
            
            
            );
    }
     /**
     * Lists all Alumno entities.
     *
     * @Route("/{grupo_id}/calcularmejores", name="alumno_calcularmejores")
     * @Template()
     */
    public function calcularmejoresAction($grupo_id)
    {
    ini_set('memory_limit', '-1');    
    set_time_limit(0);
    $em=  $this->getDoctrine()->getEntityManager();
    $request=  $this->getRequest();
    $session=$request->getSession();
    $periodo_id=$session->get('perido_id');        
       
    $alumnos=$em->getRepository("NetpublicCoreBundle:Alumno")->findBy(array(
        'grupo'=>$grupo_id
    ));
   foreach ($alumnos as $alumno) {
       $nota_estudiante=$this->getNotaPromedioAreas($alumno,$periodo_id );
       $nivel_acad_periodo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:NivelAcademico")
                         ->findBy(array(
                             "periodo_actual"=>$periodo_id,
                             "alumno"=>$alumno->getId()
       ));
       foreach ($nivel_acad_periodo as $n_aa) {
            $n_aa->setNota($nota_estudiante);
            $em->persist($n_aa);                     
       }                                
   }
   
   $em->flush();        
        return new \Symfony\Component\HttpFoundation\Response("Ok");
}
     /**
     * Lists all Alumno entities.
     *
     *
     * @Route("/{sede}/{periodo_academico}/{cgg}/getmejores.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|xls|pdf"}, name="alumno_getmejores")
     * @Template()
     */
    public function getmejoresAction($sede,$periodo_academico,$cgg)
    {
       $em = $this->getDoctrine()->getEntityManager();
       $request=  $this->getRequest();
       $nro_item=$request->get('nro_items',45);
       $aquien_aplica="---";
       $entities=array();
       $repository = $this->getDoctrine()
                    ->getRepository('NetpublicCoreBundle:NivelAcademico');        
            $query = $repository->createQueryBuilder('n_a');                     
            $query=$query->join("n_a.alumno","a");  
            $query = $query->andWhere("a.tipo=0"); 
            $query =  $query->orderBy('n_a.nota', 'DESC');
            $query = $query->andWhere("n_a.periodo_actual=:periodo_actual_id")        
                         ->setParameter('periodo_actual_id',$periodo_academico);
            if($sede=='0' && $cgg=='0'){                
                $query = $query->andWhere("n_a.tipo=0");
                $aquien_aplica="Mejores Estudiantes de toda la Institucion Educativa";
            }
            
            if(substr_count ($sede,"sede") && $cgg=='0'){                
                $id_sede=  str_replace("sede","",$sede);
                $sede_=  $this->getDoctrine()
                              ->getRepository("NetpublicCoreBundle:Colegio")
                              ->find($id_sede);    
                if($id_sede)
                $query = $query->andWhere("a.sede=:sede_id")        
                         ->setParameter('sede_id',$id_sede);
                $query = $query->andWhere("n_a.tipo=1");
                $aquien_aplica="Mejores Estudintes de las Sede: $sede_";
            }
            if(substr_count ($sede,"sede") && substr_count ($cgg,"grado")){                
                $id_sede=  str_replace("sede","",$sede);
                $id_grado=  str_replace("grado","",$cgg);
                $sede_=  $this->getDoctrine()
                              ->getRepository("NetpublicCoreBundle:Colegio")
                              ->find($id_sede);    
                $grado_=  $this->getDoctrine()
                              ->getRepository("NetpublicCoreBundle:Grado")
                              ->find($id_grado);    
                
                if($id_sede)
                $query = $query->andWhere("a.sede=:sede_id")        
                         ->setParameter('sede_id',$id_sede);
                $query = $query->andWhere("a.grado=:grado_id")        
                         ->setParameter('grado_id',$id_grado);                
                $query = $query->andWhere("n_a.tipo=2");
                $aquien_aplica="Mejores Estudiantes del Grado:$grado_  en la Sede:$sede_";
            }
            if(substr_count ($sede,"sede") && substr_count ($cgg,"grupo")){                
                $id_sede=  str_replace("sede","",$sede);
                $id_grupo=  str_replace("grupo","",$cgg);
                $sede_=  $this->getDoctrine()
                              ->getRepository("NetpublicCoreBundle:Colegio")
                              ->find($id_sede);    
                $grupo_=  $this->getDoctrine()
                              ->getRepository("NetpublicCoreBundle:Grupo")
                              ->find($id_grupo);    

                if($id_sede)
                $query = $query->andWhere("a.sede=:sede_id")        
                         ->setParameter('sede_id',$id_sede);
                $query = $query->andWhere("a.grupo=:grupo_id")        
                         ->setParameter('grupo_id',$id_grupo);                
                $query = $query->andWhere("n_a.tipo=3");
                $aquien_aplica="Mejores Estudiantes del Grupo:$grupo_ en la sede:$sede_";
            }            
            if($sede=='0' && substr_count ($cgg,"grado")){                
                
                $id_grado=  str_replace("grado","",$cgg);
                $grado_=  $this->getDoctrine()
                              ->getRepository("NetpublicCoreBundle:Grado")
                              ->find($id_grado);    

                $query = $query->andWhere("a.grado=:grado_id")        
                         ->setParameter('grado_id',$id_grado);                
                $query = $query->andWhere("n_a.tipo=0");
                $aquien_aplica="Mejores Estudiantes en el grado: $grado_  De toda la Institucion.";
            }
            
            if($sede=='0' && substr_count ($cgg,"grupo")){                

                $id_grupo=  str_replace("grupo","",$cgg);
                                $grupo_=  $this->getDoctrine()
                              ->getRepository("NetpublicCoreBundle:Grupo")
                              ->find($id_grupo);    

                $query = $query->andWhere("a.grupo=:grupo_id")        
                         ->setParameter('grupo_id',$id_grupo);                
                $query = $query->andWhere("n_a.tipo=0");
                $aquien_aplica="Mejores Estudiantes en el Grupo:$grupo_  De toda la Institucion.";

            }            
            
            $query = $query->getQuery();      
            $entities=$paginador->paginate($query)->getResult();
            $page=$request->get('page',1);
            //= $query->getResult();
            $nro_item=  count($entities);
            $index2=(($page*$nro_item)-$nro_item);
            for ($index =0 ; $index < $nro_item; $index++) {
                $entities[$index]->setPuesto(($index2+1));
                $em->persist($entities[$index]);
                $index2++;
            }
            $em->flush();
        $format = $request->get('_format');        
        if($format=='xls'){
                    $xls_service =  $this->get('xls.service_xls5');
        // create the object see http://phpexcel.codeplex.com documentation
        $xls_service->getProperties()->setCreator("Maarten Balliauw")
                             ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");
     $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
     ->setCellValueByColumnAndRow(0,1,"Puesto");   
     $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
     ->setCellValueByColumnAndRow(1,1,"Nombre y Apellidos");   
     $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
     ->setCellValueByColumnAndRow(2,1,"Promedio De notas");   
     $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
     ->setCellValueByColumnAndRow(3,1,"Grado");   
     $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
     ->setCellValueByColumnAndRow(4,1,"Grupo");   

                     for ($index1 = 0; $index1 < count($entities); $index1++) {                                              
                         
     $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
     ->setCellValueByColumnAndRow(0,$index1+3,$entities[$index1]->getPuesto());   
     $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
     ->setCellValueByColumnAndRow(1,$index1+3,"".$entities[$index1]->getAlumno());   
     $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
     ->setCellValueByColumnAndRow(2,$index1+3,$entities[$index1]->getNota());   
     $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
     ->setCellValueByColumnAndRow(3,$index1+3,"".$entities[$index1]->getAlumno()->getGrado());   
     $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
     ->setCellValueByColumnAndRow(4,$index1+3,"".$entities[$index1]->getAlumno()->getGrupo());   

                     }
                        
        //create the response
        $response = $xls_service->getResponse();
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=mejoresAlumnos.xls');        
        return $response;       
        

            
        }         
        return $this->render(sprintf('NetpublicCoreBundle:Alumno:getmejores.%s.twig', $format), array(
            'entities' => $entities,
            'sede'=>$sede,
            'periodo_academico'=>$periodo_academico,
            'cgg'=>$cgg,
            'aquien_aplica'=>$aquien_aplica
        ));
    }


    /**
     * Finds and displays a Alumno entity.
     *
     * @Route("/{id}/show", name="alumno_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $es_ajax=false;
        if($request->isXmlHttpRequest()){
            $es_ajax=true;
        }
        $entity = $em->getRepository('NetpublicCoreBundle:Alumno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alumno entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'es_ajax' =>$es_ajax
            );
    }

     /**
     * Finds and displays a Alumno entity.
     *
     * @Route("/{alumno_id}/asignaturasperdidas", name="alumno_asignaturasperdidas")
     * @Template()
     */
    public function asignaturasperdidasAction($alumno_id)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $session=  $this->getRequest()->getSession();
        $ano_escolar=$em->getRepository("NetpublicCoreBundle:Dimension")
                        ->findAnoEscolarActivo();
        $periodo_escolares=$em->getRepository("NetpublicCoreBundle:Dimension")
                              ->findPeriodosEscolar($ano_escolar);
        $alumno=$em->getRepository("NetpublicCoreBundle:Alumno")->find($alumno_id);
        $areas=$em->getRepository("NetpublicCoreBundle:Asignatura")->findAreas($alumno->getGrado()->getId());
        
        $periodo_academico_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodoEscolarActivo();
        $colegio=$em->getRepository("NetpublicCoreBundle:Colegio")->findSedePrincipal();
        $nota_minima=$colegio->getNotaMinima();
        $asg_perdidas=$em->getRepository("NetpublicCoreBundle:Alumno")->findAsgPerdidas( $alumno_id,$periodo_escolares,$nota_minima,$areas);
        return array(
            'asg_perdidas'=>$asg_perdidas
        );
    }
    /**
     * Finds and displays a Alumno entity.
     *
     * @Route("/{id}/perfiladmin", name="alumno_perfiladmin")
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
        $entity = $em->getRepository('NetpublicCoreBundle:Alumno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alumno entity.');
        }
         $es_alumno=FALSE;
        $user = $this->get('security.context')->getToken()->getUser();
        $grupo_asignatura=array();
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor(); 
            $session=$this->get('request')->getSession();
            $session->set('id_alumno_profesor',$entity->getId());
            $es_alumno=FALSE;
        }
        else{
            $es_alumno=TRUE;
        }
        $deleteForm = $this->createDeleteForm($id);
        //Año escolar
        $anos_escolares=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
            "tipo"=>0
        ));
        $periodos_escolares=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
            "tipo"=>1            
        ));
        $ano_escolar_activo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        $nro_recuperaciones=$em->getRepository("NetpublicCoreBundle:NotaRecuperacion")->findNroRecuperacionesAlumno(
                $ano_escolar_activo->getId(),
                $entity->getId());
       
        $asignaturas=array();
        if($entity->getTipo()==0 and $entity->getGrado()!=null)
            $asignaturas= $entity->getGrado()->getAsignaturas();
        
        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'es_ajax' =>$es_ajax,
            'periodos_escolares'=>$periodos_escolares,
            "ano_escolares"=>$anos_escolares,
            "asignaturas"=>$asignaturas,
            "es_alumno"=>$es_alumno,
            'ano_escolar_activo'=>$ano_escolar_activo,
            'nro_recuperaciones'=>$nro_recuperaciones
            );
    }

    /**
     * Finds and displays a Alumno entity.
     *
     * @Route("/{ano_id}/{alumno_id}/getasg", name="alumno_getasg")
     * @Template()
     */
    public function getasgAction($ano_id,$alumno_id)
    {
        $em=  $this->getDoctrine()->getManager();
        $m_a=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findOneBy(array(
            'alumno'=>$alumno_id,
            'ano'=>$ano_id
        ));
        $grado_id=$m_a->getGrupo()->getGrado()->getId();
        $Asignaturas_areaas=$em->getRepository("NetpublicCoreBundle:Asignatura")->findBy(array(
            'grado'=>$grado_id
        ));
        return array(
            'asignaturas'=>$Asignaturas_areaas
        );
    }
    /**
     * Finds and displays a Alumno entity.
     *
     * @Route("/{id}/notas", name="alumno_notas")
     * @Template()
     */
    public function notasAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        
        $es_ajax=false;
        if($request->isXmlHttpRequest()){
            $es_ajax=true;
        }
        $entity = $em->getRepository('NetpublicCoreBundle:Alumno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alumno entity.');
        }
         $es_alumno=FALSE;
        $user = $this->get('security.context')->getToken()->getUser();
        $grupo_asignatura=array();
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor(); 
            $session=$this->get('request')->getSession();
            $session->set('id_alumno_profesor',$entity->getId());
            $es_alumno=FALSE;
        }
        else{
            $es_alumno=TRUE;
        }
        $deleteForm = $this->createDeleteForm($id);
        //Año escolar
        $anos_escolares=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
            "tipo"=>0
        ));
        $periodos_escolares=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
            "tipo"=>1            
        ));
        $asignaturas= $entity->getGrado()->getAsignaturas();
        
        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'es_ajax' =>$es_ajax,
            'periodos_escolares'=>$periodos_escolares,
            "ano_escolares"=>$anos_escolares,
            "asignaturas"=>$asignaturas,
            "es_alumno"=>$es_alumno
            );
    }
    /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/new", name="alumno_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Alumno();
        $form   = $this->createForm(new AlumnoType(), $entity);
        $request=  $this->getRequest();
        $es_ajax=false;
        if($request->isXmlHttpRequest()){
            $es_ajax=true;
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'es_ajax' =>$es_ajax
        );
    }
        /**
     * Displays a form to edit an existing Alumno entity.
     *
     * @Route("/newalumnounonolote", name="alumno_newalumnounonolote")
     * @Template()
     */
    public function newalumnounonoloteAction()
    {
          $session=  $this->getRequest()->getSession();
          $session->set('destino','');
          $session->set('hay_archivo_servidor',0);        
            

      
       return array(
           "ids"=>1
       );
    }    
   /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/{tipo}/nombreseparado", name="alumno_nombreseparado")
     * @Template()
     */
    public function nombreseparadoAction($tipo)
    {
        $session=  $this->getRequest()->getSession();
        $session->set('es_nombre_completo', $tipo);
    }
   /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/newexcell", name="alumno_newexcell")
     * @Template()
     */
    public function newexcellAction()
    {
        $sedes=  $this->getDoctrine()
                    ->getRepository("NetpublicCoreBundle:Colegio")
                    ->findAll();
      $grados=  $this->getDoctrine()
                    ->getRepository("NetpublicCoreBundle:Grado")
                    ->findAll();            
      $request=  $this->getRequest();
      
      $session=$this->getRequest()->getSession();   
       return array(
           "sedes"=>$sedes,
           "grados"=>$grados,
            'tipo_usuario'=>$session->set('tipo_usuario',"*"),
            'columna_nombre'=>$session->get('columna_nombre','*'),
            'fila_nombre'=>$session->get('fila_nombre','*'),
            'hoja'=>$session->get('hoja'),
            'columna_ti'=>$session->get('columna_ti','*'),  
            'es_nombre_completo'=>$session->get('es_nombre_completo','*'),
           "hay_archivo_servidor"=>$session->get('hay_archivo_servidor','*'),
        'columna_primer_nombre'=>$session->get('columna_primer_nombre','*'),
        'columna_segundo_nombre'=>$session->get('columna_segundo_nombre','*'),
        'columna_primer_apellido'=>$session->get('columna_primer_apellido','*'),
        'columna_segundo_apellido'=>$session->get('columna_segundo_apellido','*')

       );
    }
     /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/newexcellsimat", name="alumno_newexcellsimat")
     * @Template()
     */
    public function newexcellsimatAction()
    {
        $sedes=  $this->getDoctrine()
                    ->getRepository("NetpublicCoreBundle:Colegio")
                    ->findAll();
      $grados=  $this->getDoctrine()
                    ->getRepository("NetpublicCoreBundle:Grado")
                    ->findAll();            
      $session=$this->getRequest()->getSession();    
      $request=  $this->getRequest();
       return array(
           "sedes"=>$sedes,
           "grados"=>$grados,
            'tipo_usuario'=>$session->set('tipo_usuario',"*"),
            'columna_nombre'=>$session->get('columna_nombre','*'),
            'fila_nombre'=>$session->get('fila_nombre','*'),
            'hoja'=>$request->get('hoja'),
            'columna_ti'=>$session->get('columna_ti','*'),  
            'es_nombre_completo'=>$session->get('es_nombre_completo','*'),
           "hay_archivo_servidor"=>$session->get('hay_archivo_servidor')
       );
    }
   /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/newbackupexcell", name="alumno_newbackupexcell")
     * @Template()
     */
    public function newbackupexcellAction()
    {
        return array(
            'b'=>1
        );
        
    }
   
   /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/createbackupexcell", name="alumno_createbackupexcell")
     * @Template()
     */
    public function  createbackupexcellAction()
    {
    // obtenemos los datos del archivo
    ini_set('memory_limit', '-1');    
    set_time_limit(0);
    $em=  $this->getDoctrine()->getEntityManager();
    $ano_escolar_activo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                                              ->findOneBy(array(
                                              'tipo'=>0,
                                              'es_ano_escolar'=>1
                                        ));
    $usuarios=array();
    $hoja=0;    
    // guardamos el archivo a la carpeta files       
        $prefijo = substr(md5(uniqid(rand())),0,6);                         
        $destino=__DIR__.'/../../../../../web/'.'uploads/temporal/mimamastrong_'.$prefijo.'.xls';
        copy($_FILES['archivo_excell']['tmp_name'],$destino);   
        $inputFileName = $destino;
        $objReader = $this->get('xls.load_xls5')->load($inputFileName);
        $flag=true;
                $fila=1;             
                 while($flag){
                      $grado_id= $objReader->getSheet($hoja)->getCell("C".$fila);   
                      $nombre= $objReader->getSheet($hoja)->getCell("P".$fila);   
                      $nombre1= $objReader->getSheet($hoja)->getCell("Q".$fila);   
                      $apellido= $objReader->getSheet($hoja)->getCell("R".$fila);   
                      $apellido1= $objReader->getSheet($hoja)->getCell("S".$fila);                         
                      $cedula= $objReader->getSheet($hoja)->getCell("U".$fila);   
                      $tipo= $objReader->getSheet($hoja)->getCell("V".$fila);                                               
                      $sede_id= $objReader->getSheet($hoja)->getCell("O".$fila);                                               
                      if($nombre==""){
                          $flag=false;
                      }
                      else{
                          $grado=  $this->getDoctrine()
                                        ->getRepository("NetpublicCoreBundle:Grado")
                                        ->find($grado_id);
                          $sede=  $this->getDoctrine()
                                        ->getRepository("NetpublicCoreBundle:Colegio")
                                        ->find($sede_id);
                      
                          $alumno=new \Netpublic\CoreBundle\Entity\Alumno();                          
                          $alumno->setApellido($apellido);                          
                          $alumno->setApellido1($apellido1);
                          $alumno->setNombre($nombre);
                          if($nombre1=="NULL")
                              $nombre1=" ";
                          $alumno->setNombre1($nombre1);
                          $alumno->setCedula($cedula);
                          $alumno->setTipoDocumento($tipo);                     
                          $alumno->setSede($sede);
                          $alumno->setGrado($grado);
                          $alumno->setTipo(0);     
                          $em->persist($alumno);                                                    
                          $em->flush();
                          $usuario=$this->registrarEstudiante($alumno, $ano_escolar_activo);                                                         
                          $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:NivelAcademico")
                                ->generarNivelesACademicosAlumno($alumno);
                          $usuarios[]=$usuario;      
                          
                      }
                     $fila++;
                 }                          
                $em->flush();

        
        
    return new Response("ok");
    }
            
   /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/createexcell", name="alumno_createexcell")
     * @Template()
     */
    public function createexcellAction()
    {
    // obtenemos los datos del archivo
    set_time_limit(0);
   ini_set('memory_limit', '-1');    
    $em=  $this->getDoctrine()->getEntityManager();
    $session=  $this->getRequest()->getSession();
    $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                               ->findAnoEscolarActivo();
    $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
    $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($ano_escolar_id_s);
        
    $peridos_academicos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                                                ->findBy(array(
                                                    "padre"=>$ano_escolar_activo->getId(),
                                                    "tipo"=>1
                                                ));                

    $request=  $this->getRequest();
    $posicion=array(
         "A",
         "B",
         "C",
         "D",
         "E",
         "F",
         "G",
          "H",
          "I",
          "J",
          "L",
          "M"                     
    );
    $usuarios=array();
    $grado_id=$request->get('grado');
    $hoja=$request->get('hoja');
    $grado=$this ->getDoctrine()->getRepository("NetpublicCoreBundle:Grado")
                                                    ->find($grado_id);
   // $asignaturas=$grado->getAsignaturas();
    $grupo_id=$request->get('grupo');
    $grupo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Grupo")
            ->find($grupo_id);
    $tipo_usuario=$request->get('tipo_usuario');
    $sede_id=$request->get('sede');
    $sede=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")
                                                    ->find($sede_id);
    $es_nombre_completo=$request->get('es_nombre_completo');    
    $columna_nombre=$request->get('columna_nombre');
    $fila_nombre=$request->get('fila_nombre');
    $columna_ti=$request->get("columna_ti");    
    
    $columna_primer_nombre=$request->get('primer_nombre');
    $columna_segundo_nombre=$request->get('segundo_nombre');
    $columna_primer_apellido=$request->get('primer_apellido');
    $columna_segundo_apellido=$request->get('segundo_apellido');
    
    //Guardamos en Sesoion
    $session->set('tipo_usuario',$tipo_usuario);
    $session->set('es_nombre_completo',$es_nombre_completo);
    $session->set('columna_nombre',$columna_nombre);
    $session->set('fila_nombre',$fila_nombre);
    $session->set('columna_ti',$columna_ti);
    $session->set('columna_primer_nombre',$columna_primer_nombre);
    $session->set('columna_segundo_nombre',$columna_segundo_nombre);
    $session->set('columna_primer_apellido',$columna_primer_apellido);
    $session->set('columna_segundo_apellido',$columna_segundo_apellido);
    $session->set('hoja', $request->get('hoja'));
      
    
    $btn_registrar_matricular= $request->get('btn_registrar_matricular');
    

        // guardamos el archivo a la carpeta files       
        if($session->get('hay_archivo_servidor')==0){
            $prefijo = substr(md5(uniqid(rand())),0,6);                         
            $destino=__DIR__.'/../../../../web/'.'uploads/temporal/mimamastrong_'.$prefijo.'.xls';
            copy($_FILES['archivo_excell']['tmp_name'],$destino);   
            $session->set('hay_archivo_servidor',1);
            $session->set('destino',$destino);
        }
        $inputFileName = $session->get('destino');
        $objReader = $this->get('phpexcel')->createPHPExcelObject($inputFileName);

        $flag=true;
                $fila=$fila_nombre;
                
                if($es_nombre_completo==1){
                    
                    while($flag){                    
                            $nombre_completo= $objReader->getSheet($hoja)->getCell($posicion[$columna_nombre].$fila);   
                            $nombre_completo=  trim($nombre_completo);
                            $nombre_completo=  str_replace("  "," ", $nombre_completo);
                            $nombre_completo=  str_replace("   "," ", $nombre_completo);
                            $nombre_completo=  str_replace("    "," ", $nombre_completo);
                            $cedula= $objReader->getSheet($hoja)->getCell($posicion[$columna_ti].$fila)->getCalculatedValue();   
                            if($cedula=="")
                                $cedula="000";
                            if($nombre_completo==""){
                                $flag=false;
                            }
                            else{
                              $array_nombre=  explode(" ",$nombre_completo);
                                $alumno=new \Netpublic\CoreBundle\Entity\Alumno();
                                $alumno->setCedula($cedula);
                                $alumno->setTipo($tipo_usuario);
                                $alumno->setEsNuevo(1);
                                $alumno->setTipoDocumento(2);
                                if(count($array_nombre)==5){                            
                                    $primer_nombre=$array_nombre[2];
                                    $segundo_nombre=$array_nombre[3].$array_nombre[4];
                                    $primer_apellido=$array_nombre[0];
                                    $sengundo_apellido=$array_nombre[1];
                    
                                    $alumno->setApellido($primer_apellido);
                                    $alumno->setApellido1($sengundo_apellido);
                                    $alumno->setNombre($primer_nombre);
                                    $alumno->setNombre1($segundo_nombre);                                                                                   
                                }
                                elseif (count($array_nombre)==4){                            
                                    $primer_nombre=$array_nombre[2];
                                    $segundo_nombre=$array_nombre[3];
                                    $primer_apellido=$array_nombre[0];
                                    $sengundo_apellido=$array_nombre[1];                                    
                                    $alumno->setApellido($primer_apellido);
                                    $alumno->setApellido1($sengundo_apellido);
                                    $alumno->setNombre($primer_nombre);
                                    $alumno->setNombre1($segundo_nombre);                                                                                   
                                }
                                elseif (count($array_nombre)==3){
                                    $primer_nombre=$array_nombre[2];                            
                                    $primer_apellido=$array_nombre[0];
                                    $sengundo_apellido=$array_nombre[1];
                                    $alumno->setApellido($primer_apellido);
                                    $alumno->setApellido1($sengundo_apellido);
                                    $alumno->setNombre($primer_nombre);                                                        
                                }
                                elseif (count($array_nombre)==2){
                                    $primer_nombre=$array_nombre[1];                            
                                    $primer_apellido=$array_nombre[0];                                    
                                    $alumno->setApellido($primer_apellido);                                    
                                    $alumno->setNombre($primer_nombre);                                                        
                                }                                
                                elseif (count($array_nombre)==1){
                                    $primer_nombre=$array_nombre[0];                                                                                                    
                                    $alumno->setNombre($primer_nombre);                                                        
                                }
                                else{
                                    $alumno->setNombre("No leido");
                                    $alumno->setCedula("-111111");
                                }
                               $alumno->setSede($sede);
                               $alumno->setGrado($grado);
                               $alumno->setGrupo($grupo);
                               $em->persist($alumno);
                               $em->flush();      
                               $usuarios[]= $this->registrarEstudiante($alumno, $ano_escolar_activo);     
                                if($btn_registrar_matricular==2){                                
                                    $cargas=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
                                       'ano_escolar'=>$ano_escolar_id_s,
                                       'grupo'=>$grupo_id
                                   ));
                                   foreach ($cargas as $ca) {
                                       $padre=$ca->getPadreEvaluacion();
                                       if($padre){
                                           if($alumno->getCedula()!='-111111')
                                                $em->getRepository("NetpublicCoreBundle:Alumno")->crearDimensionesPadreGc($padre,$ca,$alumno);
                                       }
                                   }

                                      $reg_matricula=new MatriculaAlumno();
                                      $reg_matricula->setAlumno($alumno);
                                      //Selecciones Ano Escolar activo

                                      //$ano_escolar_activo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->find($id_ano_escolar);
                                      $reg_matricula->setAno($ano_escolar_activo);
                                      $reg_matricula->setEsMatricula(TRUE);
                                      $reg_matricula->setGrupo($grupo);
                                      $reg_matricula->setEsPagoMatricula(TRUE);
                                      $reg_matricula->setEsPapeles(TRUE);
                                      $reg_matricula->setEsUltimaMatricula(TRUE);
                                      $reg_matricula->setObservaciones("Escriba observaciones del proceso de matricula");
                                      $em->persist($reg_matricula);
                                }
                                             
             
                            }
                    $fila++;
                    $em->flush();
        
                }
             }
             if($es_nombre_completo==2){              
                 while($flag){
                      $nombre= $objReader->getSheet($hoja)->getCell($columna_primer_nombre.$fila);   
                      $nombre1= $objReader->getSheet($hoja)->getCell($columna_segundo_nombre.$fila);   
                      $apellido= $objReader->getSheet($hoja)->getCell($columna_primer_apellido.$fila);   
                      $apellido1= $objReader->getSheet($hoja)->getCell($columna_segundo_apellido.$fila);                         
                      $cedula= $objReader->getSheet($hoja)->getCell($posicion[$columna_ti].$fila);   
                      
                      if($nombre==""){
                          $flag=false;
                      }
                      else{
                          $alumno=new \Netpublic\CoreBundle\Entity\Alumno();
                          $alumno->setApellido($apellido);
                          $alumno->setApellido1($apellido1);
                          $alumno->setNombre($nombre);
                          $alumno->setNombre1($nombre1);
                          $alumno->setCedula($cedula);
                          $alumno->setTipoDocumento(2);                     
                          $alumno->setSede($sede);
                          $alumno->setGrado($grado);
                          $alumno->setTipo($tipo_usuario);
                          $em->persist($alumno);
                          $em->flush();
                          $usuario=$this->registrarEstudiante($alumno, $ano_escolar_activo);                           
                           
                          if($btn_registrar_matricular==2){
                              //$this->matricularEstudiante($alumno, $grupo,$peridos_academicos);
                          
            $cargas=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
               'ano_escolar'=>$ano_escolar_id_s,
               'grupo'=>$grupo_id
           ));
           foreach ($cargas as $ca) {
               $padre=$ca->getPadreEvaluacion();
               if($padre)
                    $em->getRepository("NetpublicCoreBundle:Alumno")->crearDimensionesPadreGc($padre,$ca,$alumno);
           }
           
              $reg_matricula=new MatriculaAlumno();
              $reg_matricula->setAlumno($alumno);
              //Selecciones Ano Escolar activo
              
              //$ano_escolar_activo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->find($id_ano_escolar);
              $reg_matricula->setAno($ano_escolar_activo);
              $reg_matricula->setEsMatricula(TRUE);
              $reg_matricula->setGrupo($grupo);
              $reg_matricula->setEsPagoMatricula(TRUE);
              $reg_matricula->setEsPapeles(TRUE);
              $reg_matricula->setEsUltimaMatricula(TRUE);
              $reg_matricula->setObservaciones("Escriba observaciones del proceso de matricula");
              $em->persist($reg_matricula);
             
                 }
                          $usuarios[]=$usuario;      
                          
                         
                          
                      }
                     $fila++;
                     $em->flush();

                 }
             }
             

    return array(
        "usuarios"=>$usuarios,
        "grado_id"=>$grado_id,
        "grupo_id"=>$grupo_id,
        'tipo_usuario'=>$tipo_usuario,
        'sede_id'=>$sede_id,
        'es_nombre_completo'=>$es_nombre_completo,
        'columna_nombre'=>$columna_nombre,
        'fila_nombre'=>$fila_nombre,
        'columna_ti'=>$columna_ti,
        'hay_archivo_servidor'=>$session->get('hay_archivo_servidor')
       );
    }
    
     /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/{id_alumno}/verrecuperaciones", name="alumno_verrecuperaciones")
     * @Template()
     */
    public function verrecuperacionesAction($id_alumno)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $ano_escolar=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        $ano_escolar_id=$ano_escolar->getId();
        $recuperaciones=$em->getRepository("NetpublicCoreBundle:NotaRecuperacion")->findRecuperacionesAlumno($ano_escolar_id,$id_alumno);
        return array(
            'recuperaciones'=>$recuperaciones
        );        
    }       
       /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/{id_alumno}/misnotas", name="alumno_misnotas")
     * @Template()
     */
    public function misnotasAction($id_alumno)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities=array();
        $request=  $this->getRequest();
        $periodo_escolar=$request->get('periodo_escolar');
        $ano_escolar=$request->get('ano_escolar');
        $asignatura_escolar=$request->get('asignatura_escolar');
        $es_hacer=FALSE;
        $es_area=FALSE;
        $asignatura_area=array();
        if($ano_escolar!='*' AND $periodo_escolar!='*' AND $asignatura_escolar!='*')   {
            //Para Asignatura
            $asignatura=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Asignatura")->find($asignatura_escolar);
            
            $es_hacer=true;
            if($asignatura->getEsArea()==FALSE){
                $area=$asignatura->getArea();
             $query="SELECT a_d FROM NetpublicCoreBundle:AlumnoDimension a_d JOIN a_d.dimension d JOIN a_d.asignatura a";
                $query.=" WHERE (";        
                $query.=" a_d.dimension=:periodo_escolar";            
                $query.=" AND a_d.alumno=:alumno_id";
                $query.=" AND a.id=:asignatura_id";
                $query.=") OR";          
                $query.="(d.padre=:periodo_escolar";
                $query.=" AND a.id=:asignatura_id";
                $query.=" AND a_d.alumno=:alumno_id";
                $query.=" AND d.tipo=4)"; 
                $query.=" ORDER BY d.tipo DESC";
                $es_area=FALSE;
                $entities=$em->createQuery($query)                
                                 ->setParameters(array(
                                         "periodo_escolar"=>$periodo_escolar,
                                         "asignatura_id"=>$asignatura_escolar,
                                         "alumno_id"=>$id_alumno,                                         
                                      ))->getResult(); 
            
           }
          
            else{
                $area=$asignatura;  
                $asignatura_area=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Asignatura")->findBy(array(
                    'area'=>$asignatura_escolar
                ));
                $query="SELECT a_d FROM NetpublicCoreBundle:AlumnoDimension a_d JOIN a_d.dimension d JOIN a_d.asignatura a";
                $query.=" WHERE (";        
                $query.=" a_d.dimension=:periodo_escolar";            
                $query.=" AND a_d.alumno=:alumno_id";
                //$query.=" AND a.id=:asignatura_id";
                $query.=") OR";          
                $query.="(d.padre=:periodo_escolar";
                //$query.=" AND a.id=:asignatura_id";
                $query.=" AND a_d.alumno=:alumno_id";
                $query.=" AND d.tipo=4)"; 
                $query.=" ORDER BY d.tipo DESC";
                $es_area=TRUE;
                $entities=$em->createQuery($query)                
                                 ->setParameters(array(
                                         "periodo_escolar"=>$periodo_escolar,
                                        // "asignatura_id"=>$asignatura_escolar,
                                         "alumno_id"=>$id_alumno,                                         
                                      ))->getResult(); 
            
                
            }
                
            
        }
        return array(
            'entities' => $entities,
            'area'=>$area,
            'es_hacer'=>$es_hacer,
            'periodo_final'=>$periodo_escolar,
            'es_area'=>$es_area,
            'asignatura_area'=>$asignatura_area
           
        );
    }
    
   /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/createexcellsimat", name="alumno_createexcellsimat")
     * @Template()
     */
    public function createexcellsimatAction()
    {
    // obtenemos los datos del archivo
    set_time_limit(0);
   ini_set('memory_limit', '-1');    
    $em=  $this->getDoctrine()->getEntityManager();
    $ano_escolar_activo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                                              ->findOneBy(array(
                                              'tipo'=>0,
                                              'es_ano_escolar'=>1
                                        ));
    $peridos_academicos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                                                ->findBy(array(
                                                    "padre"=>$ano_escolar_activo->getId(),
                                                    "tipo"=>1
                                                ));                

    $request=  $this->getRequest();
    $posicion=array(
         "A",
         "B",
         "C",
         "D",
         "E",
         "F",
         "G",
          "H",
          "I",
          "J",
          "L",
          "M"                     
    );
    $usuarios=array();
    
    $hoja=0;
   
    $tipo_usuario=$request->get('tipo_usuario');
    $sede_id=$request->get('sede');
    
    $es_nombre_completo=$request->get('es_nombre_completo');    
    $columna_nombre=$request->get('columna_nombre');
    $fila_nombre=$request->get('fila_nombre');
    $columna_ti=$request->get("columna_ti");  
    $fila_inicio=$request->get("fila_inicio"); 
    $fila_final=$request->get("fila_final");  
    $grupo=$request->get("grupo");  
    
    //Guardamos en Sesoion
    $session=  $this->getRequest()->getSession();
    $session->set('tipo_usuario',$tipo_usuario);
    $session->set('es_nombre_completo',$es_nombre_completo);
    $session->set('columna_nombre',$columna_nombre);
    $session->set('fila_nombre',$fila_nombre);
    $session->set('columna_ti',$columna_ti);
    $session->set('fila_inicio',$fila_inicio);
    $session->set('fila_final',$fila_final);
    $btn_registrar_matricular= $request->get('btn_registrar_matricular');
    

        // guardamos el archivo a la carpeta files       
        if($session->get('hay_archivo_servidor')==0){
            $prefijo = substr(md5(uniqid(rand())),0,6);                         
            $destino=__DIR__.'/../../../../../web/'.'uploads/temporal/strong'.$prefijo.'.xls';
            copy($_FILES['archivo_excell']['tmp_name'],$destino);   
            $session->set('hay_archivo_servidor',1);
            $session->set('destino',$destino);
        }
        $inputFileName = $session->get('destino');
        $objReader = $this->get('xls.load_xls5')->load($inputFileName);
        $flag=true;
                $fila=$fila_nombre;
                
                if($es_nombre_completo==1){
                    
                    for ($index = $fila_inicio; $index <= $fila_final; $index++) {
                        
                            $nombre_completo= $objReader->getSheet($hoja)->getCell($columna_nombre.$fila);   
                            $nombre_completo=  trim($nombre_completo);
                            $nombre_completo=  str_replace("  "," ", $nombre_completo);
                            $nombre_completo=  str_replace("   "," ", $nombre_completo);

                            $tipo_documento= $objReader->getSheet($hoja)->getCell($tipo_documento.$fila);   
                            $tipo_documento=  trim($tipo_documento);
                            $tipo_documento=  str_replace("  "," ",$tipo_documento);
                            $tipo_documento=  str_replace("   "," ",$tipo_documento);
                            if($tipo_documento=="RC"){
                                $tipo_documento=5;
                            }
                            if($tipo_documento=="CC"){
                                $tipo_documento=1;
                            }
                            if($tipo_documento=="CCB"){
                                $tipo_documento=9;
                            }
                            if($tipo_documento=="NES"){
                                $tipo_documento=6;
                            }
                            if($tipo_documento=="NUIP"){
                                $tipo_documento=7;
                            }
                            if($tipo_documento=="TI"){
                                $tipo_documento=2;
                            }

                            $cedula= $objReader->getSheet($hoja)->getCell($columna_ti.$fila)->getCalculatedValue();                            
                            $cedula=  trim($cedula);
                            $cedula=  str_replace("  "," ", $cedula);
                            $cedula=  str_replace("   "," ", $cedula);
                            if($cedula=="")
                                $cedula="000";
                            $fecha= $objReader->getSheet($hoja)->getCell($columna_ti.$fila)->getCalculatedValue();                            
                            $fecha=  trim($fecha);
                            $fecha=  str_replace("  "," ", $fecha);
                            $fecha=  str_replace("   "," ", $fecha);
                            $fecha= date("fecha");
                            
                            $genero= $objReader->getSheet($hoja)->getCell($columna_ti.$fila)->getCalculatedValue();                            
                            $genero=  trim($genero);
                            $genero=  str_replace("  "," ", $genero);
                            $genero=  str_replace("   "," ", $genero);
                            if($genero=="F"){
                                $genero=2;
                            }
                            if($genero=="M"){
                                $genero=1;
                            }
                            if($nombre_completo==""){
                                $flag=false;
                            }
                            else{
                              $array_nombre=  explode(" ",$nombre_completo);
                                
                                if(count($array_nombre)==5){                            
                                    $primer_nombre=$array_nombre[2];
                                    $segundo_nombre=$array_nombre[3].$array_nombre[4];
                                    $primer_apellido=$array_nombre[0];
                                    $sengundo_apellido=$array_nombre[1];
                    
                                    $alumno->setApellido($primer_apellido);
                                    $alumno->setApellido1($sengundo_apellido);
                                    $alumno->setNombre($primer_nombre);
                                    $alumno->setNombre1($segundo_nombre);                                                                                   
                                }
                                if(count($array_nombre)==4){                            
                                    $primer_nombre=$array_nombre[2];
                                    $segundo_nombre=$array_nombre[3];
                                    $primer_apellido=$array_nombre[0];
                                    $sengundo_apellido=$array_nombre[1];                                    
                                    $alumno->setApellido($primer_apellido);
                                    $alumno->setApellido1($sengundo_apellido);
                                    $alumno->setNombre($primer_nombre);
                                    $alumno->setNombre1($segundo_nombre);                                                                                   
                                }
                                if(count($array_nombre)==3){
                                    $primer_nombre=$array_nombre[2];                            
                                    $primer_apellido=$array_nombre[0];
                                    $sengundo_apellido=$array_nombre[1];
                                    $alumno->setApellido($primer_apellido);
                                    $alumno->setApellido1($sengundo_apellido);
                                    $alumno->setNombre($primer_nombre);                                                        
                                }
                                if(count($array_nombre)==2){
                                    $primer_nombre=$array_nombre[1];                            
                                    $primer_apellido=$array_nombre[0];                                    
                                    $alumno->setApellido($primer_apellido);                                    
                                    $alumno->setNombre($primer_nombre);                                                        
                                }                                
                                if(count($array_nombre)==1){
                                    $primer_nombre=$array_nombre[0];                                                                                                    
                                    $alumno->setNombre($primer_nombre);                                                        
                                }  
                                $alumno=new \Netpublic\CoreBundle\Entity\Alumno();
                                $alumno->setCedula($cedula);
                                $alumno->setTipo($tipo_usuario);
                                $alumno->setEsNuevo(1);
                                $alumno->setGenero($genero);
                                
                               $sede=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")
                                                    ->find($sede_id); 
                               $alumno->setSede($sede);                               
                               $alumno->setTipoDocumento($tipo_documento);
                               
                               $em->persist($alumno);
                               $em->flush();      
                               $usuarios[]= $this->registrarEstudiante($alumno, $ano_escolar_activo);     
                                if($btn_registrar_matricular==2){
                                    $this->getDoctrine()
                                    ->getRepository("NetpublicCoreBundle:MatriculaAlumno")        
                                    ->setUltimAnoMatricula($ano_escolar_activo->getId(),$alumno->getId());

                                      $this->matricularEstudiante($alumno, $grupo,$peridos_academicos);
                               }
                          $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:NivelAcademico")
                                ->generarNivelesACademicosAlumno($alumno);
                          
             
                            }
                    $fila++;
                }
             }

                $em->flush();

        
        
    $grado_id=$request->get('grado');
    $grado=$this ->getDoctrine()->getRepository("NetpublicCoreBundle:Grado")
                                                    ->find($grado_id);
   // $asignaturas=$grado->getAsignaturas();
    $grupo_id=$request->get('grupo');
    $grupo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Grupo")
            ->find($grupo_id);
    $tipo_usuario=$request->get('tipo_usuario');
    $sede_id=$request->get('sede');
    $sede=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")
                                                    ->find($sede_id);
    $es_nombre_completo=$request->get('es_nombre_completo');    
    $columna_nombre=$request->get('columna_nombre');
    $fila_nombre=$request->get('fila_nombre');
    $columna_ti=$request->get("columna_ti");   
    
    

    return array(
        "usuarios"=>$usuarios,
         "grado_id"=>$grado_id,
        "grupo_id"=>$grupo_id,
        'tipo_usuario'=>$tipo_usuario,
        'sede_id'=>$sede_id,
        'es_nombre_completo'=>$es_nombre_completo,
        'columna_nombre'=>$columna_nombre,
        'fila_nombre'=>$fila_nombre,
        'columna_ti'=>$columna_ti,
        'hay_archivo_servidor'=>$session->get('hay_archivo_servidor')        
       );
    }
     /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/{id_alumno_observador}/editarobservacion", name="alumno_editarobservacion")
     * @Template()
     */
    public function editarobservacionAction($id_alumno_observador)
    {
        return array(
            "id_alumno_desempeno"=>$id_alumno_observador
        );
        
    }

    /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/{id_alumno_desempeno}/editardescriptor", name="alumno_editardescriptor")
     * @Template()
     */
    public function editardescriptorAction($id_alumno_desempeno)
    {
        return array(
            "id_alumno_desempeno"=>$id_alumno_desempeno
        );
        
    }
        /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/{id_alumno_desempeno}/updateobservacion", name="alumno_updateobservacion")
     * @Template()
     */
    public function updateobservadorAction($id_alumno_desempeno)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $a_d=$em->getRepository("NetpublicCoreBundle:Observacion")->find($id_alumno_desempeno);
        $a_d->setContenido($this->getRequest()->get('desenpeno'));
        $em->persist($a_d);
        $em->flush();
        return new Response($this->getRequest()->get('desenpeno'));
     }

    /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/{id_alumno_desempeno}/updatedescriptor", name="alumno_updatedescriptor")
     * @Template()
     */
    public function updatedescriptorAction($id_alumno_desempeno)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $a_d=$em->getRepository("NetpublicCoreBundle:AlumnoDesempeno")->find($id_alumno_desempeno);
        $a_d->setTieneDescriptorAdicional(1);
        //Proceso eliminar
        $em->persist($a_d);
        $desc_a=new \Netpublic\CoreBundle\Entity\DescriptorAdicional();
        $desc_a->setAlumnoDesempeno($a_d);
        $desc_a->setObservacion($this->getRequest()->get('desenpeno'));
        $em->persist($desc_a);
        $em->flush();
        return new Response($this->getRequest()->get('desenpeno'));
     }
    /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/{id_alumno_desempeno}/deletedescriptor", name="alumno_deletedescriptor")
     * @Template()
     */
    public function deletedescriptorAction($id_alumno_desempeno)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $a_d=$em->getRepository("NetpublicCoreBundle:AlumnoDesempeno")->find($id_alumno_desempeno);
        $ds_a=$a_d->getDescriptorAdicional();
        foreach ($ds_a as $d) {
            $em->remove($d);
        }
        $em->remove($a_d);
        $em->flush();
        return new Response("ok");
     }
    
    
    /**
    
     /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/{id_alumno}/misdescriptores", name="alumno_misdescriptores")
     * @Template()
     */
    public function misdescriptoresAction($id_alumno)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities=array();
        $request=  $this->getRequest();
        $periodo_escolar=$request->get('periodo_escolar');
        $ano_escolar=$request->get('ano_escolar');
        $asignatura_escolar=$request->get('asignatura_escolar');
        $es_hacer=FALSE;
        $es_area=FALSE;
        //$area=$asignatura->getArea();            
        $query="SELECT a_d,d FROM NetpublicCoreBundle:AlumnoDesempeno a_d JOIN a_d.dimension d ";
        $query.=" WHERE (";        
        //$query.=" a_d.dimension=:periodo_escolar";            
        $query.=" a_d.alumno=:alumno_id";
        //$query.=" AND a.id=:asignatura_id";
        $query.=") ";          
        //$query.="(d.padre=:periodo_escolar";
        //$query.=" AND a.id=:asignatura_id";
        //$query.=" AND a_d.alumno=:alumno_id";
        //$query.=" AND d.tipo=4)"; 
        //$query.=" ORDER BY d.tipo DESC";
       // $es_area=FALSE;
        $entities=$em->createQuery($query)                
                                 ->setParameters(array(
                  //                       "periodo_escolar"=>$periodo_escolar,
                  //                       "asignatura_id"=>$asignatura_escolar,
                                         "alumno_id"=>$id_alumno,                                         
                                      ))->getResult(); 
            
           return array(
            'entities' => $entities                       
        );
    }
       
        /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/getperiodosdimension", name="alumno_getperiodosdimension")
     * @Template()
     */
    public function getperiodosdimensionAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $ano_escolar=$request->get('ano_escolar');
        $alumno_id=$request->get('id_alumno');
        $asignatura_escolar=$request->get('asignatura_escolar');
        
        $alumno=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")->find($alumno_id);
        $m_a=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findOneBy(array(
            'alumno'=>$alumno_id,
            "ano"=>$ano_escolar
        ));
        $grupo_id=$m_a->getGrupo()->getId();
        $periodos_academicos=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
            'padre'=>$ano_escolar,
            'tipo'=>1
        ));
      $query="SELECT d FROM NetpublicCoreBundle:Dimension d";
            $query.=" WHERE";
                $query.=" (d.padre=".$periodos_academicos[0]->getId();   
                $query.=" AND d.asignatura=".$asignatura_escolar;
                $query.=" AND d.tipo=4)";                
                
                for ($index = 1; $index < count($periodos_academicos); $index++) {                                    
                    $query.=" OR ";
                    $query.=" (d.padre=".$periodos_academicos[$index]->getId();                    
                    $query.=" AND d.asignatura=".$asignatura_escolar;
                    $query.=" AND d.tipo=4)";                    
                }

            $entities=$em->createQuery($query)                
                                 ->getResult(); 
       return array(
           'periodos_academicos'=>$periodos_academicos,
           'entities'=>$entities,
           'asignatura_escolar'=>$asignatura_escolar,
           'grupo_id'=>$grupo_id
       );
    }
    /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/{tipo}/newcustom", name="alumno_newcustom")
     * @Template()
     */
    public function newcustomAction($tipo)
    {
        
       
       switch ($tipo) {
           case 1:{//Padres        
                    $padre=new Alumno();
                    $padre_type=new AlumnoType();
                    $form_padre=  $this->createFormCustomBuilder("padre",$padre)
                           ->add('nombre')
                             ->add('nombre1',null,array('label'=>'Segundo Nombre.','required'=>FALSE))
                            ->add('apellido',null,array('label'=>'Primer Apellido.'))                                                
                            ->add('apellido1',null,array('label'=>'Segundo Apellido.')) 
                           ->add('tipo_documento','choice',array(
                                'choices'=>array(
                                                    '0'=>'   ',
                                                    '1'=>'Cedula Ciudadania',
                                                    '2'=>'Tarjeta de Identidad',
                                                    '3'=>"Cédula de Extranjería ó Identificación de Extranjería",
                                                    '5'=>"Registro Civil de Nacimiento",
                                                    "6"=>"Número de Identificación Personal (NIP)",
                                                    '7'=>"Número Único de Identificación Personal (NUIP)",
                                                    '8'=>"Número de Identificación establecido por la Secretaría de  Educación",
                                                    "9"=>"Certificado Cabildo"
                             )))
                           ->add('cedula') 
                           ->add('direccion_residencia')
                           ->add('telefono')
                           ->add('ocupacion')
                           ->add('empresa')
                           ->add('empresa')
                           ->add('email')
                           
                           ->getForm();
        
                    $madre=new Alumno();               
                    $form_madre=  $this->createFormCustomBuilder("madre",$madre)
                            ->add('nombre')
                            ->add('nombre1',null,array('label'=>'Segundo Nombre.','required'=>FALSE))
                            ->add('apellido',null,array('label'=>'Primer Apellido.'))                                                
                            ->add('apellido1',null,array('label'=>'Segundo Apellido.'))                                                
                                    ->add('tipo_documento','choice',array(
                                'choices'=>array(
                                                    '0'=>'   ',
                                                    '1'=>'Cedula Ciudadania',
                                                    '2'=>'Tarjeta de Identidad',
                                                    '3'=>"Cédula de Extranjería ó Identificación de Extranjería",
                                                    '5'=>"Registro Civil de Nacimiento",
                                                    "6"=>"Número de Identificación Personal (NIP)",
                                                    '7'=>"Número Único de Identificación Personal (NUIP)",
                                                    '8'=>"Número de Identificación establecido por la Secretaría de  Educación",
                                                    "9"=>"Certificado Cabildo"
                             ))) 
                           ->add('cedula') 
                           ->add('direccion_residencia')
                           ->add('telefono')
                           ->add('ocupacion')
                           ->add('empresa')                           
                           ->add('email') 
                            ->getForm()
                            ;                            
                    return array(
                        'entity_padre' => $padre,
                        'entity_madre' => $madre,
                        'edit_madre_form'   => $form_madre->createView(),
                        'edit_padre_form' => $form_padre->createView(),
                        'tipo'    => $tipo
                    );
                    break;
           }
           case 0:{
                        $acudiente=new Alumno();
                        
                        $form_acudiente=  $this->createFormCustomBuilder("acudiente",$acudiente)
                           ->add('nombre')    
                           ->add('nombre1',null,array('label'=>'Segundo Nombre.','required'=>FALSE))
            ->add('apellido',null,array('label'=>'Primer Apellido.'))                                                
            ->add('apellido1',null,array('label'=>'Segundo Apellido.'))                                                     
                           ->add('parentesco')
                           ->add('tipo_documento','choice',array(
                                'choices'=>array(
                                                    '0'=>'   ',
                                                    '1'=>'Cedula Ciudadania',
                                                    '2'=>'Tarjeta de Identidad',
                                                    '3'=>"Cédula de Extranjería ó Identificación de Extranjería",
                                                    '5'=>"Registro Civil de Nacimiento",
                                                    "6"=>"Número de Identificación Personal (NIP)",
                                                    '7'=>"Número Único de Identificación Personal (NUIP)",
                                                    '8'=>"Número de Identificación establecido por la Secretaría de  Educación",
                                                    "9"=>"Certificado Cabildo"
                             )))
                           ->add('cedula') 
                             ->add('foto_academica','file',array('required'=>FALSE))
                                ->add('foto_firma','file',array('required'=>FALSE))        
                           ->add('departamento', 'entity', array(
                                        'class' => 'NetpublicCoreBundle:ValorVariable',
                                        'multiple'=>FALSE,
                                        'query_builder' => function(EntityRepository $er) {
                                                        return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
                            ))  
                           ->add('municipio', 'entity', array(
                                    'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=14')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))     
                           ->add('direccion_residencia')     
                           ->add('telefono')
                           ->add('ocupacion')
                           ->add('empresa')
                           ->add('email')     
                           ->getForm();                    
                         return array(
                        'entity_acudiente' => $acudiente,                                            
                        'edit_acudiente_form' =>$form_acudiente->createView(),
                        'tipo' =>$tipo    
                         );
                         break;
           }
           default:{
               break;
           }
       }
        
    }
 //ss
     /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/{tipo}/newcustompadres", name="alumno_newcustompadres")
     * @Template()
     */
    public function newcustompadresAction($tipo)
    {
        
       
           
                    $padre=new Alumno();
                    $padre_type=new AlumnoType();
                    $form_padre=  $this->createFormCustomBuilder("padre",$padre)
                           ->add('nombre')
                             ->add('nombre1',null,array('label'=>'Segundo Nombre.','required'=>FALSE))
                            ->add('apellido',null,array('label'=>'Primer Apellido.'))                                                
                            ->add('apellido1',null,array('label'=>'Segundo Apellido.')) 
                           ->add('tipo_documento','choice',array(
                                'choices'=>array(
                                                    '0'=>'   ',
                                                    '1'=>'Cedula Ciudadania',
                                                    '2'=>'Tarjeta de Identidad',
                                                    '3'=>"Cédula de Extranjería ó Identificación de Extranjería",
                                                    '5'=>"Registro Civil de Nacimiento",
                                                    "6"=>"Número de Identificación Personal (NIP)",
                                                    '7'=>"Número Único de Identificación Personal (NUIP)",
                                                    '8'=>"Número de Identificación establecido por la Secretaría de  Educación",
                                                    "9"=>"Certificado Cabildo"
                             )))
                           ->add('cedula') 
                           ->add('direccion_residencia')
                           ->add('telefono')
                           ->add('ocupacion')
                           ->add('empresa')
                           ->add('empresa')
                           ->add('email')
                           
                           ->getForm();
        
                    $madre=new Alumno();               
                    $form_madre=  $this->createFormCustomBuilder("madre",$madre)
                            ->add('nombre')
                            ->add('nombre1',null,array('label'=>'Segundo Nombre.','required'=>FALSE))
                            ->add('apellido',null,array('label'=>'Primer Apellido.'))                                                
                            ->add('apellido1',null,array('label'=>'Segundo Apellido.'))                                                
                                    ->add('tipo_documento','choice',array(
                                'choices'=>array(
                                                    '0'=>'   ',
                                                    '1'=>'Cedula Ciudadania',
                                                    '2'=>'Tarjeta de Identidad',
                                                    '3'=>"Cédula de Extranjería ó Identificación de Extranjería",
                                                    '5'=>"Registro Civil de Nacimiento",
                                                    "6"=>"Número de Identificación Personal (NIP)",
                                                    '7'=>"Número Único de Identificación Personal (NUIP)",
                                                    '8'=>"Número de Identificación establecido por la Secretaría de  Educación",
                                                    "9"=>"Certificado Cabildo"
                             ))) 
                           ->add('cedula') 
                           ->add('direccion_residencia')
                           ->add('telefono')
                           ->add('ocupacion')
                           ->add('empresa')                           
                           ->add('email') 
                            ->getForm()
                            ;                            
                    return array(
                        'entity_padre' => $padre,
                        'entity_madre' => $madre,
                        'edit_madre_form'   => $form_madre->createView(),
                        'edit_padre_form' => $form_padre->createView(),
                        'tipo'    => $tipo
                    );
                    break;
          
        
    }   
    
    
    
 /**
     * Cambiar contrasena
     *
     * @Route("/updatematricula", name="usuario_updatematricula")
     * @Method("post")
     * @Template("")
     */    
    public function updatematriculaAction(){
        
       $request = $this->getRequest();
       $estado_pago=$request->get('estado_pago');
       $es_papeles=$request->get('es_papeles');
       $observaciones=$request->get('observaciones');
       $id_matricula=$request->get('id_matricula');
       $id_alumno=$request->get('id_alumno');
       $entity=$this->getDoctrine()->getRepository("NetpublicCoreBundle:MatriculaAlumno")->find($id_matricula);
       $alumno=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")->find($id_alumno);
       $entity->setEsPagoMatricula($estado_pago);
       $entity->setObservaciones($observaciones);
       $entity->setEsPapeles($es_papeles);
       $em=$this->getDoctrine()->getEntityManager();
       $em->persist($entity);
       $em->flush();
        return array(
            'alumno' => $alumno,
            'matricula'   => $entity
        );
        

    }    
    
    /**
     * Creates a new Alumno entity.
     *
     * @Route("/create", name="alumno_create")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Alumno:new.html.twig")
     */
    public function createAction(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);  
        $em = $this->getDoctrine()->getEntityManager();            
        $entity  = new Alumno();
        $request = $this->getRequest();
        $form    = $this->createForm(new AlumnoType(), $entity);
        $data=$request->get('ntp_inacholeebundle_alumnotype');
        $id_ano_escolar=$data['ano_escolar'];
        
         $form->handleRequest($request);
        
        if ($form->isValid()) {
            $query = $em->createQuery('SELECT count(a) FROM NetpublicCoreBundle:Usuario a WHERE a.username LIKE :cedula')
                            ->setParameters(array(
                            "cedula"=>$entity->getNombre().'%'                         
                           
                                )
                            );
            $count = $query->getSingleScalarResult();
			$nombre=$entity->getNombre();
			
			if($count>0){
				$nombre=$entity->getNombre().$count;
			}
					  
            //Generamos claves temporalares a los alumno registrados como nuevo
             $usuario=new Usuario();
             
             $usuario->setUsername($nombre);
             $usuario->setSalt(md5(time()));
             $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
             $password = $encoder->encodePassword($entity->getCedula(), $usuario->getSalt());
             $usuario->setPassword($password);
             $usuario->setEsAlumno(TRUE); 
             $usuario->setAlumno($entity);
             $entity->setUsuario($usuario);
             //$rol=new Rol();
             //$rol->setRole("ROLE_ESTUDIANTE");
             $rol=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Rol")->findOneBy(array("role"=>"ROLE_ESTUDIANTE"));
             $usuario->addRol($rol); 
//Generamos registros para hacer seguimientos al proceso de matricula.
              $reg_matricula=new MatriculaAlumno();
              $reg_matricula->setAlumno($entity);
              //Selecciones Ano Escolar activo
              $em->persist($rol);
              $em->persist($usuario);
              $ano_escolar_activo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
              $reg_matricula->setAno($ano_escolar_activo);
              $reg_matricula->setGrupo($entity->getGrupo());
              $reg_matricula->setEsMatricula(TRUE);
              $reg_matricula->setEsPagoMatricula(TRUE);
              $reg_matricula->setEsPapeles(TRUE);
              $reg_matricula->setEsUltimaMatricula(TRUE);
              $reg_matricula->setObservaciones("Escriba observaciones del proceso de matricula");
              $periodos_academicos=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodosEscolar($ano_escolar_activo);
              foreach ($periodos_academicos as $periodo) {
                $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:NivelAcademico")
                                ->generarNivelesACademicosAlumno($entity,$periodo);
              
              }
             $em->persist($reg_matricula);                        
             $em->persist($entity);                       
             $em->flush();
             $file=$form['foto_academica']->getData();
             if($file){
                $nombre_archivo= 'alumno'.$entity->getId();  
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
            $nombre_archivo= 'alumno'.$entity->getId();  
                                    $imagine = new \Imagine\Gd\Imagine();
                                    $image = $imagine->open($file1);
                                    $thumbnail_mini = $image->thumbnail(new Box(50, 50));
                                    $thumbnail_mini->save(__DIR__.'/../../../../../web/'.'uploads/documents/firma'.$nombre_archivo.'.jpg');
                                    $usuario->setEsFotoperfil(TRUE);
                                    
           }
           $em->flush();
           return new Response("ok");
      }
            if($request->isXmlHttpRequest())
                return new \Symfony\Component\HttpFoundation\Response("ok");
            return $this->redirect($this->generateUrl('alumno_show', array('id' => $entity->getId())));
            
        
            return new \Symfony\Component\HttpFoundation\Response("ok");
                
    }
    
   /**
     * Creates a new Alumno entity.
     *
     * @Route("/creates", name="alumno_creates")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Alumno:new.html.twig")
     */
    public function createsAction(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);  
        
        $em = $this->getDoctrine()->getEntityManager();            
        $session=  $this->getRequest()->getSession();
        $entity  = new Alumno();
        $request = $this->getRequest();
        $form    = $this->createForm(new AlumnoType(), $entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                               ->findAnoEscolarActivo();
            $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
            $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($ano_escolar_id_s);
        
             //Generamos claves temporalares a los alumno registrados como nuevo
            $usuario=new Usuario();
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery('SELECT count(a) FROM NetpublicCoreBundle:Usuario a WHERE a.username LIKE :cedula')
                            ->setParameters(array(
                            "cedula"=>$entity->getNombre().'%'                         
                           
                                )
                            );
            $count = $query->getSingleScalarResult();
			$nombre=$entity->getNombre();
			
			if($count>0){
				$nombre=$entity->getNombre().$count;
			}

             $usuario->setUsername($nombre);
             $usuario->setSalt(md5(time()));
             $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
             $password = $encoder->encodePassword($entity->getCedula(), $usuario->getSalt());
             $usuario->setPassword($password);
             $usuario->setEsAlumno(TRUE); 
             $usuario->setAlumno($entity);
             $entity->setUsuario($usuario);
             //$rol=new Rol();
             //$rol->setRole("ROLE_ESTUDIANTE");
             if($entity->getTipo()==0)
                $rol=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Rol")->findOneBy(array("role"=>"ROLE_ESTUDIANTE"));
             if($entity->getTipo()==1)
                $rol=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Rol")->findOneBy(array("role"=>"ROLE_ACUDIENTE"));
             
             $usuario->addRol($rol); 
//Generamos registros para hacer seguimientos al proceso de matricula.
              $reg_matricula=new MatriculaAlumno();
              $reg_matricula->setAlumno($entity);
              //Selecciones Ano Escolar activo
              
              //$ano_escolar_activo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->find($id_ano_escolar);
              $reg_matricula->setAno($ano_escolar_activo);
              $reg_matricula->setEsMatricula(TRUE);
              $reg_matricula->setGrupo($entity->getGrupo());
              $reg_matricula->setEsPagoMatricula(TRUE);
              $reg_matricula->setEsPapeles(TRUE);
              $reg_matricula->setEsUltimaMatricula(TRUE);
              $reg_matricula->setObservaciones("Escriba observaciones del proceso de matricula");
              $em->persist($reg_matricula);
              $em->persist($entity);
              $em->persist($rol);
              $em->persist($usuario);            
              $em->flush();
            $file=$form['foto_academica']->getData();
                               if($file){
                                    $nombre_archivo= 'alumno'.$entity->getId(); 
                                    $entity->getUsuario()->setEsFotoperfil(1);
                                    $entity->getFotoAcademica()->move(__DIR__.'/../../../../web/'.'uploads/documents',
                                    $entity->getFotoAcademica()->getClientOriginalName());                
                                    $imagen=$this->get('image.handling');
                                    $imagen->open(__DIR__.'/../../../../web/'.'uploads/documents/'.$entity->getFotoAcademica()->getClientOriginalName())
                                            ->resize(140,150)
                                            ->save(__DIR__.'/../../../../web/'.'uploads/documents/strong'.$nombre_archivo.'.png','png');
                                    $imagen->open(__DIR__.'/../../../../web/'.'uploads/documents/'.$entity->getFotoAcademica()->getClientOriginalName())
                                            ->resize(40,43)
                                            ->save(__DIR__.'/../../../../web/'.'uploads/documents/mini'.$nombre_archivo.'.png','png');
                                
                                       $usuario->setEsFotoperfil(TRUE);
            
                               }
                                
                                
                               
            
            
           $em->persist($usuario);
           $em->flush();
           $periodos_academicos=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodosEscolar($ano_escolar_activo);
              foreach ($periodos_academicos as $periodo) {                  
                      $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:NivelAcademico")
                                ->generarNivelesACademicosAlumno($entity,$periodo);
              
              }
            $em->persist($reg_matricula);                        
           //Matriculamos al estudiante.
           $cargas=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
               'ano_escolar'=>$ano_escolar_id_s,
               'grupo'=>$entity->getGrupo()
           ));
           foreach ($cargas as $ca) {
               $padre=$ca->getPadreEvaluacion();
               if($padre){
                       $em->getRepository("NetpublicCoreBundle:Alumno")->crearDimensionesPadreGc($padre,$ca,$entity);
               }
           }
           $em->flush();
            if($request->isXmlHttpRequest())
                return new \Symfony\Component\HttpFoundation\Response("ok");
            return $this->redirect($this->generateUrl('alumno_show', array('id' => $entity->getId())));
            
     
    }  
    }
    /**
     * Creates a new Alumno entity.
     *
     * @Route("/{tipo}/createcustom", name="alumno_createcustom")
     * @Method("post")
     * @Template()
     */
    public function createcustomAction($tipo)
    {
        ini_set('memory_limit', '-1');
   set_time_limit(0);  
   
        $session=$this->get('request')->getSession();
        
        $em = $this->getDoctrine()->getEntityManager();            
        $padre  = new Alumno();
        $request = $this->getRequest();
        //$form    = $this->createForm(new AlumnoType(), $entity);
        if($tipo==1){
            $form_padre=  $this->createFormCustomBuilder("padre",$padre)
                            ->add('nombre')
                    ->add('nombre1',null,array('label'=>'Segundo Nombre.','required'=>FALSE))
            ->add('apellido',null,array('label'=>'Primer Apellido.'))                                                
            ->add('apellido1',null,array('label'=>'Segundo Apellido.'))                                                
                           ->add('tipo_documento','choice',array(
                'choices'=>array(
                    '0'=>'   ',
                    '1'=>'Cedula Ciudadania',
                    '2'=>'Tarjeta de Identidad',
                    '3'=>"Cédula de Extranjería ó Identificación de Extranjería",
                    '5'=>"Registro Civil de Nacimiento",
                    "6"=>"Número de Identificación Personal (NIP)",
                    '7'=>"Número Único de Identificación Personal (NUIP)",
                    '8'=>"Número de Identificación establecido por la Secretaría de  Educación",
                    "9"=>"Certificado Cabildo"
                )
            ))
                           ->add('cedula') 
                           ->add('direccion_residencia')
                           ->add('telefono')
                           ->add('ocupacion')
                           ->add('empresa')
                           ->add('empresa')
                           ->add('email') 
                    ->add('foto_academica','file',array('required'=>FALSE))
                           ->getForm();
        
            $madre=new Alumno();               
            $form_madre=  $this->createFormCustomBuilder("madre",$madre)
                            ->add('nombre')
                    ->add('nombre1',null,array('label'=>'Segundo Nombre.','required'=>FALSE))
            ->add('apellido',null,array('label'=>'Primer Apellido.'))                                                
            ->add('apellido1',null,array('label'=>'Segundo Apellido.'))                                                
                           ->add('tipo_documento','choice',array(
                'choices'=>array(
                    '0'=>'   ',
                    '1'=>'Cedula Ciudadania',
                    '2'=>'Tarjeta de Identidad',
                    '3'=>"Cédula de Extranjería ó Identificación de Extranjería",
                    '5'=>"Registro Civil de Nacimiento",
                    "6"=>"Número de Identificación Personal (NIP)",
                    '7'=>"Número Único de Identificación Personal (NUIP)",
                    '8'=>"Número de Identificación establecido por la Secretaría de  Educación",
                    "9"=>"Certificado Cabildo"
                )
            )) 
                           ->add('cedula') 
                           ->add('direccion_residencia')
                           ->add('telefono')
                           ->add('ocupacion')
                           ->add('empresa')
                           ->add('empresa')
                           ->add('email')                           
                           ->getForm();
            $form_padre->handleRequest($request);
            $form_madre->handleRequest($request);
            if($form_madre->isValid()){
                $em->persist($madre);
                $em->flush();                
                $session->set('id_madre',$madre->getId());
                $resultado="OK_MADRE";
            }                
            if ($form_padre->isValid()) {
    
            $em->persist($padre);
            $em->flush();            
            $session->set('id_padre',$padre->getId());
            return new \Symfony\Component\HttpFoundation\Response("OK_PADRE".$resultado);
            //return $this->redirect($this->generateUrl('alumno_show', array('id' => $entity->getId())));            
        }
        }
        if($tipo==0){
                        $acudiente=new Alumno();
                        
                        $form_acudiente=  $this->createFormCustomBuilder("acudiente",$acudiente)
                           ->add('nombre')    
                           ->add('nombre1',null,array('label'=>'Segundo Nombre.','required'=>FALSE))
                            ->add('apellido',null,array('label'=>'Primer Apellido.'))                                                
                           ->add('apellido1',null,array('label'=>'Segundo Apellido.'))                                                     
                           ->add('parentesco')
                           ->add('tipo_documento','choice',array(
                                'choices'=>array(
                                                    '0'=>'   ',
                                                    '1'=>'Cedula Ciudadania',
                                                    '2'=>'Tarjeta de Identidad',
                                                    '3'=>"Cédula de Extranjería ó Identificación de Extranjería",
                                                    '5'=>"Registro Civil de Nacimiento",
                                                    "6"=>"Número de Identificación Personal (NIP)",
                                                    '7'=>"Número Único de Identificación Personal (NUIP)",
                                                    '8'=>"Número de Identificación establecido por la Secretaría de  Educación",
                                                    "9"=>"Certificado Cabildo"
                             )))
                           ->add('cedula') 
                            ->add('foto_academica','file',array('required'=>FALSE))
                            ->add('foto_firma','file',array('required'=>FALSE))         
                           ->add('departamento', 'entity', array(
                                        'class' => 'NetpublicCoreBundle:ValorVariable',
                                        'multiple'=>FALSE,
                                        'query_builder' => function(EntityRepository $er) {
                                                        return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
                            ))  
                           ->add('municipio', 'entity', array(
                                    'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=14')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))     
                           ->add('direccion_residencia')     
                           ->add('telefono')
                           ->add('ocupacion')
                           ->add('empresa')
                           ->add('email')     
                           ->getForm();                    
                           $form_acudiente->handleRequest($request);
                           if ($form_acudiente->isValid()) {
                               $em->persist($acudiente); 
                                 $em->flush(); 
                               $file=$form_acudiente['foto_academica']->getData();
                               if($file){
                                    $nombre_archivo= 'alumno'.$acudiente->getId();  
                                    //$file->move(__DIR__.'/../../../../web/'.'uploads/documents',$nombre_archivo.'jpg');
                                    $imagine = new \Imagine\Gd\Imagine();
                                    $image = $imagine->open($file);
                                    $thumbnail_mini = $image->thumbnail(new Box(50, 50));
                                    $thumbnail_mini->save(__DIR__.'/../../../../../web/'.'uploads/documents/mini'.$nombre_archivo.'.jpg');
                                    $thumbnail_strong = $image->thumbnail(new Box(135,300));
                                    $thumbnail_strong->save(__DIR__.'/../../../../../web/'.'uploads/documents/strong'.$nombre_archivo.'.jpg');
                                    
                                }
                                $file1=$form_acudiente['foto_firma']->getData();
                                if($file1){                                    
                                    $nombre_archivo= 'alumno'.$acudiente->getId();  
                                    //$file->move(__DIR__.'/../../../../web/'.'uploads/documents',$nombre_archivo.jpg);
                                    $imagine = new \Imagine\Gd\Imagine();
                                    $image = $imagine->open($file1);
                                    $thumbnail_mini = $image->thumbnail(new Box(50, 100));
                                    $thumbnail_mini->save(__DIR__.'/../../../../../web/'.'uploads/documents/firma'.$nombre_archivo.'.jpg');
                                    
                                }  
                               $session->set('id_acudiente',$acudiente->getId());
                               $resultado="OK_ACUDIENTE";
			       return $this->redirect($this->generateUrl('alumno_newcustompadres', array('tipo' => 1)));
                           }
        }
            
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response($resultado);
        
    }

    /**
     * Displays a form to edit an existing Alumno entity.
     *
     * @Route("/{id}/edit", name="alumno_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Alumno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alumno entity.');
        }

        $editForm = $this->createForm(new AlumnoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Displays a form to edit an existing Alumno entity.
     *
     * @Route("/{cedula}/getalumnocedula", name="alumno_getalumnocedula")
     * @Template()
     */
    public function getalumnocedulaAction($cedula)
    {
        $em = $this->getDoctrine()->getEntityManager();

       $query = $em->createQuery('SELECT count(a) FROM NetpublicCoreBundle:Alumno a WHERE a.cedula=:cedula')
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
     * @Route("/{id}/perfilacudiente", name="alumno_perfilacudiente")
     * @Template()
     */
    public function perfilacudienteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Alumno')->find($id);
        $hijos_colegio=$entity->getAlumnoAcudiente();
        
        return array(
            'entities'      => $hijos_colegio,
            'entity' => $entity
        );
    }
       /**
     * Displays a form to edit an existing Alumno entity.
     *
     * @Route("/{id}/perfilacudientefiltro", name="alumno_perfilacudientefiltro")
     * @Template()
     */
    public function perfilacudientefiltroAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Alumno')->find($id);
        $hijos_colegio=$entity->getAlumnoAcudiente();
        
        return array(
            'entities'      => $hijos_colegio,
            'entity'=>$entity
        );
    }    
    /**
     * Displays a form to edit an existing Alumno entity.
     *
     * @Route("/{id}/editperfil", name="alumno_editperfil")
     * @Template()
     */
    public function editperfilAction($id)
    {   
        

        $entity = $this->getDoctrine()->getRepository('NetpublicCoreBundle:Alumno')->find($id);
        $editForm = $this->createFormBuilder($entity)
             ->add('sede')
             ->add('nombre')
             ->add('nombre1')    
             ->add('apellido')
             ->add('apellido1')                    
             ->add('movil')
             //->add('grupo',null,array('required'=>FALSE))
             ->add('grado')
             ->add('tipo_documento','choice',array(
                'choices'=>array(
                    '0'=>'   ',
                    '1'=>'Cedula Ciudadania',
                    '2'=>'Tarjeta de Identidad',
                    '3'=>"Cédula de Extranjería ó Identificación de Extranjería",
                    '5'=>"Registro Civil de Nacimiento",
                    "6"=>"Número de Identificación Personal (NIP)",
                    '7'=>"Número Único de Identificación Personal (NUIP)",
                    '8'=>"Número de Identificación establecido por la Secretaría de  Educación",
                    "9"=>"Certificado Cabildo"
                )
            )) 
            ->add('cedula')    
            ->add('departamento')           
            ->add('acudiente', 'entity', array(
                    'required'=>FALSE,
                     'class' => 'NetpublicCoreBundle:Alumno',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.tipo=1')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))   
                
             ->add('departamento', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))               
              ->add('municipio', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=14')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                    
            ->add('fecha_nacimiento')                        
            ->add('depto_nacimiento', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))      
            ->add('municipio_nacimiento', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                                 
            //->add('genero')
             ->add('genero','choice',array(
                'choices'=>array(
                    '0'=>'   ',
                    '1'=>'Masculino',
                    '2'=>'Femenino'         
                )
            ))
            //->add('jornada') 
            ->add('jornada','choice',array(
                'choices'=>array(
                    '0'=>'   ',
                    '1'=>'Completa',
                    '2'=>'Mañana',
                    '3'=>'Tarde',
                    '4'=>'Nocturna',
                    '5'=>'Fin de semana'                    
                )
            ))                                   
                                             
            ->add('foto_academica','file',array('required'=>FALSE))
            ->add('direccion_residencia')
            ->add('telefono')            
            ->add('tipo_sangre','choice',array(
                'choices'=>array(
                    '0'=>'O+',
                    '1'=>'O-',
                    '2'=>'A-',
                    '3'=>'A+',
                    '4'=>'B-',
                    '5'=>'B+',                    
                    '4'=>'C-',
                    '5'=>'C+'                                        
                )
            ))                                   
                                     
            //->add('depto_ubicacion')                                                
            //->add('municipio_ueditperfilbicacion')
             ->add('depto_ubicacion', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))      
            ->add('municipio_ubicacion', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                    
            //->add('zona')
            ->add('zona','choice',array(
                'choices'=>array(
                    '1'=>'Urbana',
                    '2'=>'Rural'
                )
            ))                                      
            ->add('localidad_vereda')
            ->add('barrio')                
            //->add('estrato_socioeconomico')    
             ->add('estrato_socioeconomico','choice',array(
                'choices'=>array(
                    '0'=>'Estrato 0',
                    '1'=>'Estrato 1',
                    '2'=>'Estrato 2',
                    '3'=>'Estrato 3',
                    '4'=>'Estrato 4',
                    '5'=>'Estrato 5',
                    '6'=>'Estrato 6'  
                )
            ))                                                                                      
     
            //->add('sisben')
            ->add('sisben','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '1'=>'1',
                    '2'=>'2',
                    '3'=>'3',
                    '4'=>'4',
                    '5'=>'5',
                    '9'=>'No Aplica'  
                )
            ))                                         
            ->add('eps')
            ->add('ars')
            //->add('poblacion_vitima_conflito')     
            ->add('poblacion_vitima_conflito','choice',array(
                'choices'=>array(
                    '1'=>'En situación de desplazamiento',
                    '2'=>'Desvinculados de grupos armados',
                    '3'=>'Hijos de adultos desmovilizados',
                    '9'=>'No Aplica '
                   
                )
            ))                                                                                      
                                   
            //->add('ultimo_depto_expulsor')                                                            
            ->add('tipo_municipio_expulsor')
            ->add('ultimo_depto_expulsor', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))      
                                                 
            //->add('es_sector_privado')
             ->add('es_sector_privado','choice',array(
                'choices'=>array(
                    '1'=>'Si',
                    '2'=>'No'                                      
                )
            ))                                   
           // ->add('es_otro_municipio')
            ->add('es_otro_municipio','choice',array(
                'choices'=>array(
                    '1'=>'Si',
                    '2'=>'No'                                      
                )
            ))                                                 
            //->add('tipo_discapacidad') 
             ->add('tipo_discapacidad','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '1'=>'Sordera Profunda',
                    '2'=>'Hipoacusia o Baja audición',
                    '3'=>'Baja visión diagnosticada',
                    '4'=>'Ceguera',
                    '5'=>'Parálisis cerebral',
                    '6'=>'Lesión neuromuscular' ,
                    '7'=>'Autismo',
                    '8'=>'Deficiencia cognitiva (Retardo Mental)',
                    '9'=>'Síndrome de Down',
                    '10'=>'Múltiple  ',                    
                    '99'=>'No aplica'
                )
            ))                                   
                                              
            //->add('capacidad_excepcionales')   
               ->add('capacidad_excepcionales','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '1'=>'Superdotado',
                    '2'=>'Con talento científico',
                    '3'=>'Con talento tecnológico',
                    '4'=>'Con talento subjetivo',
                    '5'=>'No Aplica'
                    
                )
            ))                                   
                                     
            ->add('etnia')
            /* ->add('etnia', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=8')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              )) */                                   
            ->add('resguardo')
            /*->add('resguardo', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=9')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              )) */                                    
            ->add('parentesco')
            ->add('empresa')                
            ->add('telefono_empresa')                                                
            ->add('ocupacion')
            ->add('email')
            ->add('colegio_estudio_ultimo_ano')
            ->add('direccion_colegio_proveniente')                
            ->add('ano')                                
            ->add('motivo_retiro')
            ->add('grado_proveniente')  
            ->add('es_recuperacion','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '0'=>'No Recupero',
                    '1'=>'Recupero',
                )
            ))                                                                       
            //->add('situacion_academica_ano_anterior')                                
               ->add('situacion_academica_ano_anterior','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '0'=>'No Estudio',
                    '1'=>'Aprobo',
                    '2'=>'Reprobo',
                    '8'=>'No Culmino los Estudios',

                    
                )
            ))                                   
                                                                                     
            //->add('condicion_finalizar_ano_anterior')
               ->add('condicion_finalizar_ano_anterior','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '3'=>'Deserto',
                    '5'=>'Transladado a Otra Institución',
                    '9'=>'No Aplica'

                )
            ))
                                                                                     
            //->add('repitente')       
               ->add('repitente','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '1'=>'No Repintente',
                    '2'=>'Repitente'
                )
            ))                                   
                                                                                   
               ->add('es_nuevo','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '1'=>'No es Nuevo',
                    '2'=>'Nuevo'
                )
            ))                                 
                                                                                     
               ->add('es_habilitacion','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '1'=>'No Habilito',
                    '2'=>'Habilito'
                )
            ))                                   
                                                                                     
               ->add('posicion_academica')                                   
                                                                                   

        
            ->getForm();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alumno entity.');
        }

        //$editForm = $this->createForm(new AlumnoperfilType(), $entity);
        $em=  $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($id);
        $ano_escolar_activo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        $nro_recuperaciones=$em->getRepository("NetpublicCoreBundle:NotaRecuperacion")->findNroRecuperacionesAlumno(
                $ano_escolar_activo->getId(),
                $entity->getId());
       
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'ano_escolar_activo'=>$ano_escolar_activo,
            'nro_recuperaciones'=>$nro_recuperaciones
        );
    }
    /**
     * Displays a form to edit an existing Alumno entity.
     *
     * @Route("/{id}/editperfila", name="alumno_editperfila")
     * @Template()
     */
    public function editperfilaAction($id)
    {                

        $entity = $this->getDoctrine()->getRepository('NetpublicCoreBundle:Alumno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alumno entity.');
        }

        $editForm = $this->createForm(new AlumnoperfilType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Alumno entity.
     *
     * @Route("/{id}/update", name="alumno_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Alumno:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $entity = $em->getRepository('NetpublicCoreBundle:Alumno')->find($id);
        //Datos que noe estan el FORM
       
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alumno entity.');
        }

        $editForm   = $this->createForm(new AlumnoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
           
                    
            $em->persist($entity);              
            $em->flush();
        }
        return $this->redirect($this->generateUrl('alumno_edit', array('id' => $id)));
        

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
 
    /**
     * Edits an existing Alumno entity.
     *
     * @Route("/{id}/updateperfil", name="alumno_updateperfil")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Alumno:editperfil.html.twig")
     */
    public function updateperfilAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Alumno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alumno entity.');
        }
        $editForm = $this->createFormBuilder($entity)
             ->add('sede')
             ->add('nombre')
             ->add('nombre1')    
             ->add('apellido')
             ->add('apellido1')                    
             ->add('movil')
             //->add('grupo',null,array('required'=>FALSE))
             ->add('grado')
             ->add('tipo_documento','choice',array(
                'choices'=>array(
                    '0'=>'   ',
                    '1'=>'Cedula Ciudadania',
                    '2'=>'Tarjeta de Identidad',
                    '3'=>"Cédula de Extranjería ó Identificación de Extranjería",
                    '5'=>"Registro Civil de Nacimiento",
                    "6"=>"Número de Identificación Personal (NIP)",
                    '7'=>"Número Único de Identificación Personal (NUIP)",
                    '8'=>"Número de Identificación establecido por la Secretaría de  Educación",
                    "9"=>"Certificado Cabildo"
                )
            )) 
            ->add('cedula')    
            ->add('departamento')           
            ->add('acudiente', 'entity', array(
                     'required'=>FALSE,
                     'class' => 'NetpublicCoreBundle:Alumno',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.tipo=1')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))   
                
             ->add('departamento', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))               
              ->add('municipio', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=14')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                    
            ->add('fecha_nacimiento')                        
            ->add('depto_nacimiento', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))      
            ->add('municipio_nacimiento', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                                 
            //->add('genero')
             ->add('genero','choice',array(
                'choices'=>array(
                    '0'=>'   ',
                    '1'=>'Masculino',
                    '2'=>'Femenino'         
                )
            ))
            //->add('jornada') 
            ->add('jornada','choice',array(
                'choices'=>array(
                    '0'=>'   ',
                    '1'=>'Completa',
                    '2'=>'Mañana',
                    '3'=>'Tarde',
                    '4'=>'Nocturna',
                    '5'=>'Fin de semana'                    
                )
            ))                                   
                                             
            ->add('foto_academica','file',array('required'=>FALSE))
           ->add('direccion_residencia')
            ->add('telefono')            
            ->add('tipo_sangre','choice',array(
                'choices'=>array(
                    '0'=>'O+',
                    '1'=>'O-',
                    '2'=>'A-',
                    '3'=>'A+',
                    '4'=>'B-',
                    '5'=>'B+',                    
                    '4'=>'C-',
                    '5'=>'C+'                                        
                )
            ))                                   
                                     
            //->add('depto_ubicacion')                                                
            //->add('municipio_ubicacion')
             ->add('depto_ubicacion', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))      
            ->add('municipio_ubicacion', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))                                    
            //->add('zona')
            ->add('zona','choice',array(
                'choices'=>array(
                    '1'=>'Urbana',
                    '2'=>'Rural'
                )
            ))                                      
            ->add('localidad_vereda')
            ->add('barrio')                
            //->add('estrato_socioeconomico')    
             ->add('estrato_socioeconomico','choice',array(
                'choices'=>array(
                    '0'=>'Estrato 0',
                    '1'=>'Estrato 1',
                    '2'=>'Estrato 2',
                    '3'=>'Estrato 3',
                    '4'=>'Estrato 4',
                    '5'=>'Estrato 5',
                    '6'=>'Estrato 6'  
                )
            ))                                                                                      
     
            //->add('sisben')
            ->add('sisben','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '1'=>'1',
                    '2'=>'2',
                    '3'=>'3',
                    '4'=>'4',
                    '5'=>'5',
                    '9'=>'No Aplica'  
                )
            ))                                         
            ->add('eps')
            ->add('ars')
            //->add('poblacion_vitima_conflito')     
            ->add('poblacion_vitima_conflito','choice',array(
                'choices'=>array(
                    '1'=>'En situación de desplazamiento',
                    '2'=>'Desvinculados de grupos armados',
                    '3'=>'Hijos de adultos desmovilizados',
                    '9'=>'No Aplica '
                   
                )
            ))                                                                                      
                                   
            //->add('ultimo_depto_expulsor')                                                            
            ->add('tipo_municipio_expulsor')
            ->add('ultimo_depto_expulsor', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=13')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              ))      
                                                 
            //->add('es_sector_privado')
             ->add('es_sector_privado','choice',array(
                'choices'=>array(
                    '1'=>'Si',
                    '2'=>'No'                                      
                )
            ))                                   
           // ->add('es_otro_municipio')
            ->add('es_otro_municipio','choice',array(
                'choices'=>array(
                    '1'=>'Si',
                    '2'=>'No'                                      
                )
            ))                                                 
            //->add('tipo_discapacidad') 
             ->add('tipo_discapacidad','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '1'=>'Sordera Profunda',
                    '2'=>'Hipoacusia o Baja audición',
                    '3'=>'Baja visión diagnosticada',
                    '4'=>'Ceguera',
                    '5'=>'Parálisis cerebral',
                    '6'=>'Lesión neuromuscular' ,
                    '7'=>'Autismo',
                    '8'=>'Deficiencia cognitiva (Retardo Mental)',
                    '9'=>'Síndrome de Down',
                    '10'=>'Múltiple  ',                    
                    '99'=>'No aplica'
                )
            ))                                   
                                              
            //->add('capacidad_excepcionales')   
               ->add('capacidad_excepcionales','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '1'=>'Superdotado',
                    '2'=>'Con talento científico',
                    '3'=>'Con talento tecnológico',
                    '4'=>'Con talento subjetivo',
                    '5'=>'No Aplica'
                    
                )
            ))                                   
                                     
            ->add('etnia')
            /* ->add('etnia', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=8')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              )) */                                   
            ->add('resguardo')
            /*->add('resguardo', 'entity', array(
                     'class' => 'NetpublicCoreBundle:ValorVariable',
                     'multiple'=>FALSE,
                     'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('u')
                                                      ->where('u.variable=9')  
                                                      ->orderBy('u.id', 'ASC');
                                        },
              )) */                                    
            ->add('parentesco')
            ->add('empresa')                
            ->add('telefono_empresa')                                                
            ->add('ocupacion')
            ->add('email')
            ->add('colegio_estudio_ultimo_ano')
            ->add('direccion_colegio_proveniente')                
            ->add('ano')                                
            ->add('motivo_retiro')
            ->add('grado_proveniente')  
                        ->add('es_recuperacion','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '0'=>'No Recupero',
                    '1'=>'Recupero',
                )
            ))                                                                       
                                                
            //->add('situacion_academica_ano_anterior')                                
               ->add('situacion_academica_ano_anterior','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '0'=>'No Estudio',
                    '1'=>'Aprobo',
                    '2'=>'Reprobo',
                    '8'=>'No Culmino los Estudios',

                    
                )
            ))                                   
                                                                                     
            //->add('condicion_finalizar_ano_anterior')
               ->add('condicion_finalizar_ano_anterior','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '3'=>'Deserto',
                    '5'=>'Transladado a Otra Institución',
                    '9'=>'No Aplica'

                )
            ))
                                                                                     
            //->add('repitente')       
               ->add('repitente','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '1'=>'No Repintente',
                    '2'=>'Repitente'
                )
            ))                                   
                                                                                   
               ->add('es_nuevo','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '1'=>'No es Nuevo',
                    '2'=>'Nuevo'
                )
            ))                                 
                                                                                     
               ->add('es_habilitacion','choice',array(
                'choices'=>array(
                    '0'=>'    ',
                    '1'=>'No Habilito',
                    '2'=>'Habilito'
                )
            ))                                   
                                                                                     
               ->add('posicion_academica')                                   
                                                                                   

        
            ->getForm();
       // $editForm   = $this->createForm(new AlumnoperfilType(), $entity);
        //$deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);
        if ($editForm->isValid()) 
            {
                               $file=$editForm['foto_academica']->getData();
                               if($file){
                                    $nombre_archivo= 'alumno'.$entity->getId(); 
                                    $entity->getUsuario()->setEsFotoperfil(1);
                                    $entity->getFotoAcademica()->move(__DIR__.'/../../../../web/'.'uploads/documents',
                                    $entity->getFotoAcademica()->getClientOriginalName());                
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
            //return $this->redirect($this->generateUrl('alumno_perfiladmin', array('id' => $id)));
             return $this->redirect($this->generateUrl('alumno_editperfil', array('id' => $id)));
            
            
        }

    }
    /**
     * Edits an existing Alumno entity.
     *
     * @Route("/{id}/updateperfila", name="alumno_updateperfila")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Alumno:editperfil.html.twig")
     */
    public function updateperfilaAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Alumno')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alumno entity.');
        }

        $editForm   = $this->createForm(new AlumnoperfilType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);
        //$editForm->remove('sede');
        //$editForm->remove('grupo');
        if ($editForm->isValid()) 
            {
           //Actualizamos datos no incluidos en el FORM 
         //  $entity->setSede($sede);
           //$file=$editForm['foto_academica']->getData();
           //if($file)
           // $file->move(__DIR__.'/../../../../web/'.'uploads/documents','mm.jpg');
            //echo $file->guessExtension();
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('alumno_editperfila', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }  
    
    /**
     * Buscar Usuarios an existing Usuario entity.
     *
     * @Route("/filtronota", name="alumno_filtronota")     
     * @Template()
     */
    public function filtronotaAction(){
        $request = $this->getRequest();
  

        //Id_alumno
        $alumno_id=$request->get('alumno_id');        
        $periodo_id=$request->get('periodo_id');
        $asignatura=$request->get('asignatura_id');
        $ano_escolar_id=$request->get('ano_escolar_id');
        $repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:AlumnoDimension');        
        $query = $repository->createQueryBuilder('ad');                    
        $query= $query->andWhere("ad.alumno=:alumno_id");                      
        $query= $query->join("ad.dimension", 'd');
        $query= $query->join("ad.alumno","a");
        $query= $query->andWhere("d.padre=:padre_id");                      
        $query= $query->andWhere("d.tipo=4");                      
        $query= $query->andWhere("ad.asignatura=:asignatura_id");                      
        $query= $query->setParameters(array(
            "alumno_id"=> $alumno_id,
            "padre_id"=>$periodo_id,
            "asignatura_id"=>$asignatura
            ));
        $query= $query->getQuery();                       
        $notas = $query->getResult();
        
//Periodo  final
            
        $query = $repository->createQueryBuilder('ad');                            
        $query= $query->join("ad.dimension", 'd');
        $query= $query->join("ad.alumno","a");
        $query= $query->andWhere("d.padre=:padre_id");                      
        $query= $query->andWhere("d.tipo=1");                      
        $query= $query->andWhere("ad.alumno=:alumno_id");   
        $query= $query->andWhere("ad.asignatura=:asignatura_id");                      
        $query= $query->setParameters(array(
            "alumno_id"=> $alumno_id,
            "padre_id"=>$ano_escolar_id,
            "asignatura_id"=>$asignatura
            ));
        $query= $query->getQuery();                       
        $notas_definitica = $query->getResult();
//Asistencia
        $query = $repository->createQueryBuilder('ad');                            
        $query= $query->join("ad.dimension", 'd');
        $query= $query->join("ad.alumno","a");
        $query= $query->andWhere("d.padre=:padre_id");                      
        $query= $query->andWhere("d.tipo=3");                      
        $query= $query->andWhere("ad.alumno=:alumno_id");   
        $query= $query->andWhere("ad.asignatura=:asignatura_id");                      
        $query= $query->setParameters(array(
            "alumno_id"=> $alumno_id,
            "padre_id"=>$periodo_id,
            "asignatura_id"=>$asignatura
            ));
        $query= $query->getQuery();                       
        $asistencia = $query->getResult();
//Descriptor
        $_repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:AlumnoDesempeno');  
        $query = $_repository->createQueryBuilder('ad');                            
        $query= $query->join("ad.desempeno", 'd');
        $query= $query->join("ad.alumno","a");
        $query= $query->andWhere("ad.dimension=:padre_id");                              
        $query= $query->andWhere("ad.alumno=:alumno_id");   
        $query= $query->andWhere("ad.asignatura=:asignatura_id");                      
        $query= $query->setParameters(array(
            "alumno_id"=> $alumno_id,
            "padre_id"=>$periodo_id,
            "asignatura_id"=>$asignatura
            ));
        $query= $query->getQuery();                       
        $nota_desempeno = $query->getResult();
        if(count($nota_desempeno)>0){
             $descripion_desempeno_resultado="no tiene";
             $observacion_perdida_desempeno_resultado="no tiene";
             $observacion_sobresaliente_desempeno_resultado="no tiene";
             $nota_desempeno_escalar=$nota_desempeno[0]->getIndexDesempeno();
             $desempeno=$nota_desempeno[0]->getDesempeno();
             //Yuri$colegio=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")->find(1);
        //Deficiente 
        $nota_desempeno_escalar=2;     
        if( $nota_desempeno_escalar>$colegio->getValorMinimoDeficiente() && $nota_desempeno_escalar < $colegio->getValorMaximoDeficiente()){
            $descripion_desempeno_resultado=$desempeno->getDescripcionDeficiente();
            $observacion_perdida_desempeno_resultado=$desempeno->getObservacionPerdida();
        }
        //Insuficiente
        else if($colegio->getValorMinimoInsuficiente()< $nota_desempeno_escalar && $colegio->getValorMaximoInsuficiente()> $nota_desempeno_escalar){
            $descripion_desempeno_resultado=$desempeno->getDescripcionInsuficiente();
        }
        else if($colegio->getValorMinimoAceptable()< $nota_desempeno_escalar && $colegio->getValorMaximoAceptable()> $nota_desempeno_escalar){
            $descripion_desempeno_resultado=$desempeno->getDescripcionAceptable();
        }
        else if($colegio->getValorMinimoSobresaliente()> $nota_desempeno_escalar && $colegio->getValorMaximoSobresaliente()> $nota_desempeno_escalar){
            $descripion_desempeno_resultado=$desempeno->getDescripcionSobresaliente();
        }
        else if($colegio->getValorMinimoExcelente()<$nota_desempeno_escalar && $colegio->getValorMaximoExcelente()> $nota_desempeno_escalar){
            $observacion_sobresaliente_desempeno_resultado=$desempeno->getObservacionSobresaliente();
            $descripion_desempeno_resultado=$desempeno->getDescripcionExcelente();
        }
        
        }
        return array(
            "notas"=>$notas,
            "nota_definitiva"=>$notas_definitica,
            "asistencias"=>$asistencia,
            'nota_desempeno'=>$nota_desempeno_escalar,
            "descripion_desempeno_resultado"=>$descripion_desempeno_resultado,
            "observacion_sobresaliente_desempeno_resultado"=>$observacion_sobresaliente_desempeno_resultado,
            "observacion_perdida_desempeno_resultado"=>$observacion_perdida_desempeno_resultado
            
        );
    }
    /**
     * Deletes a Alumno entity.
     *
     * @Route("/{id}/delete", name="alumno_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();
         $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:Alumno')->find($id);
            $notas_alumnos=$em->getRepository('NetpublicCoreBundle:AlumnoDimension')->findBy(array("alumno"=>$id));  
            foreach ($notas_alumnos as $nota) {
                $em->remove($nota);
            }
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Alumno entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('alumno'));
    }
    /**
     * renovar matricula a Alumno entity.
     *
     * @Route("/matricular", name="alumno_matricular")
     * @Method("post")
     */
    public function matricularAction(){
        $request = $this->getRequest();
        $em=$this->getDoctrine()->getEntityManager();
        $id_usuarios=$request->get('usuarios');
        
        for ($index = 0; $index < count($id_usuarios); $index++) {        
            $id=$id_usuarios[$index]['id'];
            $alumno=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")->find($id);
            $next_grado=$alumno->getGrado()->getGradoSiguiente();
            $alumno->setGrado($next_grado);                        
            $em->persist($alumno);
            
        }
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response('ok');
    }
    /**
     * renovar matricula a Alumno entity.
     *
     * @Route("/newmatricular", name="alumno_newmatricular")
     * @Method("post")
     * @Template()
     */
    public function newmatricularAction(){
        $grados=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grado")->findAll();
        return array(
          'grados'=>$grados  
        );
        
    } 
        /**
     * renovar matricula a Alumno entity.
     * 
     * 
     * @Route("/{grupo_destino_id}/{alumno_id}/transferiralumno", name="alumno_transferiralumno")
     * 
     */
    public function transferiralumnoAction($grupo_destino_id,$alumno_id){
        $em=  $this->getDoctrine()->getManager();
        $session=  $this->getRequest()->getSession();
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                               ->findAnoEscolarActivo();
        $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
        $grupo_destino=$em->getRepository("NetpublicCoreBundle:Grupo")->find($grupo_destino_id);
        $matricula=$this->getDoctrine()->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findOneBy(array(
                     'ano'=>$ano_escolar_id_s,
                     'alumno'=>$alumno_id
                 ));
        $matricula->setGrupo($grupo_destino);
        $em->persist($matricula);
        $em->flush();
        return new Response("{$matricula->getAlumno()}");
    }
    /**
     * renovar matricula a Alumno entity.
     * 
     * 
     * @Route("/{grupo_id}/{alumno_id}/matricularalumnonuevo.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|xls|pdf"}, name="alumno_matricularalumnonuevo")
     * 
     */
    public function matricularalumnonuevoAction($grupo_id,$alumno_id){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $em=$this->getDoctrine()->getManager();
        $session=  $this->getRequest()->getSession();
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                               ->findAnoEscolarActivo();        
        $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
        $ano_escolar=$em->getRepository("NetpublicCoreBundle:Dimension")->find($ano_escolar_id_s);
        
        
        
        $peridos_academicos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findPeriodosEscolar($ano_escolar);;                
        
        $grupo_matricular=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Grupo")->find($grupo_id);
        $alumno=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")->find($alumno_id);
        $resultado="No se realizo matricula";
        $matriculas=$this->getDoctrine()->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findOneBy(array(
                     'ano'=>$ano_escolar->getId(),
                     'alumno'=>$alumno_id
                 ));
        if($matriculas){
            $matriculas->setEsMatricula(TRUE); 
            $matriculas->setGrupo($grupo_matricular);         
            
        }
        else{
            $matriculas=new MatriculaAlumno();            
            $matriculas->setAlumno($alumno);
            $matriculas->setAno($ano_escolar);
            $matriculas->setGrupo($grupo_matricular);
            $matriculas->setEsMatricula(TRUE);
            $matriculas->setEsPagoMatricula(TRUE);
            $matriculas->setEsPapeles(TRUE);
            $matriculas->setObservaciones("  ");
            $em->persist($matriculas);
        }
        $alumno->setGrado($grupo_matricular->getGrado());
        $em->persist($alumno);
         $em->flush();
       //Establecemos grupo
       /*$em->getRepository("NetpublicCoreBundle:Alumno")->asignarGrupo(
                    $alumno,$grupo_matricular->getId(),$peridos_academicos,$ano_escolar->getId());*/
        $cas=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
            'ano_escolar'=>$ano_escolar_id_s,
            'grupo'=>$grupo_id
        ));
        foreach ($cas as $ca) {
            //echo "{$ca->getPadreEvaluacion()}<br/>";
            if($ca->getPadreEvaluacion()){
                echo "<br/>------------------{$ca->getGrupo()}----{$ca->getAsignatura()}----------------------<br/>";
                
                $em->getRepository("NetpublicCoreBundle:Alumno")->crearDimensionesPadreGc($ca->getPadreEvaluacion(),$ca,$alumno);
                $resultado="";
                
            }
        }
        return new Response("$alumno $resultado");
       
       
    }
     /**
     * renovar matricula a Alumno entity.
     * @Route("/{alumno_id}/{ano_id}/cancelarmatricula.html", name="alumno_cancelarmatricula")
     * @Template()
     * 
     */
    public function cancelarmatriculaAction($alumno_id,$ano_id){
        $em=$this->getDoctrine()->getEntityManager();               
        $session=  $this->getRequest()->getSession();
        $alumno=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")->find($alumno_id);        
        $ano_escolar=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->find($ano_id);        
        
        $periodos_escolar=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findPeriodosEscolar($ano_escolar);                
        
        $matriculas=$this->getDoctrine()->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findOneBy(array(
                     'ano'=>$ano_escolar->getId(),
                     'alumno'=>$alumno_id
                 ));
        if($matriculas){
            $matriculas->setEsMatricula(FALSE);
            $matriculas->setGrupo();            
        }
        else{
            $matriculas=new MatriculaAlumno();
            $matriculas->setAlumno($alumno);
            $matriculas->setAno($ano_escolar);            
            $matriculas->setEsMatricula(FALSE);
            $matriculas->setEsPagoMatricula(TRUE);
            $matriculas->setEsPapeles(TRUE);
            $matriculas->setObservaciones("  ");
            $em->persist($matriculas);
        }
        $query="SELECT a_d FROM NetpublicCoreBundle:AlumnoDimension a_d JOIN a_d.dimension d";
            $query.=" WHERE (d.padre=:periodo_id";            
            $query.=" AND a_d.alumno=:alumno_id";
            $query.=" )";
            $entities=$em->createQuery($query)                
                                 ->setParameters(array(
                                         "periodo_id"=>$ano_escolar->getId(),                                         
                                         "alumno_id"=>$alumno_id,                                         
                                      ))->getResult(); 
            //Preparamos para remover
            foreach ($entities as $e) {
                $recuperaciones=$e->getNotaRecuperacion();
                foreach ($recuperaciones as $re) {
                    $em->remove($re);
                }
                $em->remove($e);
            }

        //Dimension Periodo academicos
         foreach ($periodos_escolar as $p_e_) {
            $query="SELECT a_d FROM NetpublicCoreBundle:AlumnoDimension a_d";
            $query.=" WHERE (a_d.dimension=:periodo_id";            
            $query.=" AND a_d.alumno=:alumno_id";
            $query.=" )";
            $entities_p[]=$em->createQuery($query)                
                                 ->setParameters(array(
                                         "periodo_id"=>$p_e_->getId(),                                         
                                         "alumno_id"=>$alumno_id,                                         
                                      ))->getResult(); 
            foreach ($entities_p as $e_p_array) {
                foreach ($e_p_array as $e_p) {
                    $em->remove($e_p);
                    
                }
                          
            }
        }        
        //Dimension de Actividades de los periodos
        foreach ($periodos_escolar as $p_e) {
                
            //mension de Actividades de los periodos
            $query="SELECT a_d FROM NetpublicCoreBundle:AlumnoDimension a_d JOIN a_d.dimension d";
            $query.=" WHERE (d.padre=:periodo_id";            
            $query.=" AND a_d.alumno=:alumno_id";
            $query.=" )";
            $entities_a=$em->createQuery($query)                
                                 ->setParameters(array(
                                         "periodo_id"=>$p_e->getId(),                                         
                                         "alumno_id"=>$alumno_id,                                         
                                      ))->getResult(); 
            
            foreach ($entities_a as $e_p) { 
                $query="SELECT a_d,d FROM NetpublicCoreBundle:AlumnoDimension a_d JOIN a_d.dimension d";
                $query.=" WHERE (d.padre=:periodo_id";            
                $query.=" AND a_d.alumno=:alumno_id";
                $query.=" )";
                $entities_items=$em->createQuery($query)                
                                 ->setParameters(array(
                                         "periodo_id"=>$e_p->getDimension()->getId(),                                         
                                         "alumno_id"=>$alumno_id,                                         
                                      ))->getResult(); 
                      foreach ($entities_items as $e) {
                          $em->remove($e);
                      }
            
                 $em->remove($e_p);
                          
            }
        }
        
        $alumno->setGrupo();
        $em->flush();
        return new Response("$alumno");
    }
    
    
     
   
    /**
     * renovar matricula a Alumno entity.
     *                                          
     * @Route("/{ano_escolar_id}/{grupo_id}/matricularalumnoantiguo.{_format}", defaults={"_format"="html"},requirements={"_format"="html|xls|pdf"},name="alumno_matricularalumnoantiguo")
     * @Template()
     * 
     */
    
    public function matricularalumnoantiguoAction($grupo_id,$ano_escolar_id){
              
              
        $resultado="";
        $flag=1;
        $request = $this->getRequest();
        $em=$this->getDoctrine()->getEntityManager();
        $id_ano_escolar=$ano_escolar_id;
        $grupos_matricular=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Grupo")->find($grupo_id);
        $asignaturas=$grupos_matricular->getGrado()->getAsignaturas();                  
        $session=$this->get('request')->getSession();                    
        $alumnos_id=$session->get('alumnos_id',array());
        $alumnos=array();
        for ($index = 0; $index < count($alumnos_id); $index++) {
            $usuario=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Usuario")->find($alumnos_id[$index]);
            if($usuario->getEsAlumno())
                $alumnos[]=$usuario->getAlumno();
        }  
        foreach ($alumnos as $alumno) {
            //$matriculas=$alumno->getMatriculaAlumno();
              $matriculas_anteriores= $this->getDoctrine()->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findBy(array(
                  'alumno'=>$alumno->getId()
              )); 
              foreach ($matriculas_anteriores as $m_a) {
                  $m_a->setEsUltimaMatricula(FALSE);
                  $em->persist($m_a);
              }
              $re_matricula=new MatriculaAlumno();
              $re_matricula->setAlumno($alumno);                          
              $ano_escolar_activo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->find($id_ano_escolar);
              $re_matricula->setAno($ano_escolar_activo);
              $re_matricula->setEsMatricula(FALSE);
              $re_matricula->setEsPagoMatricula(TRUE);
              $re_matricula->setEsPapeles(TRUE);
              $re_matricula->setEsUltimaMatricula(TRUE);
              $re_matricula->setObservaciones("Escriba observaciones del proceso de matricula");
              $em->persist($re_matricula);
              
            //foreach ($matriculas as $matricula) {
               // if($matricula->getAno()->getId()==$id_ano_escolar){
                            //Verificamos que el Nuevo alumno se pueda matricular
                            //$re_matricula=  $matricula;
                            $es_pago_matricula=$re_matricula->getEsPagoMatricula();
                            if($es_pago_matricula==FALSE){
                                $resultado.=" Este Alumno no ha pagado derechos de Matricula. ";
                                $flag=-1;
                            }            
                            $presento_papeles=$re_matricula->getEsPapeles();
                            if($presento_papeles==FALSE){
                                $resultado.=" Este Alumno no ha presentado CERTIFICADOS y Demas. ";
                                $flag=-1;
                            }
                            $esta_matriculado=$re_matricula->getEsMatricula();
                            if($esta_matriculado){
                                $resultado.=" Este Alumno ya esta matriculado. ";
                                $flag=-1;
                            }
                            if($flag==1){
                                    
                                    $re_matricula->setEsMatricula(TRUE);
                                    $re_matricula->setEsPapeles(TRUE);
                                    $re_matricula->setEsPagoMatricula(TRUE);
                                    $em->persist($re_matricula);
                                    $alumno=$re_matricula->getAlumno();
                                    $ano_escolar=$re_matricula->getAno();
                                    $peridos_academicos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                                                ->findBy(array(
                                                    "padre"=>$ano_escolar->getId(),
                                                    "tipo"=>1
                                                ));                
                                    //Establecemos grupo
                                    if($alumno->getSituacionAcademicaAnoAnterior()==1){
                                        $alumno->setGrupo($grupos_matricular);
                                        $alumno->setGrado($grupos_matricular->getGrado());
                                        $alumno->setRepitente(FALSE);
                                    }
                                    if($alumno->getSituacionAcademicaAnoAnterior()==2){
                                        $alumno->setRepitente(TRUE);
                                    }
                                    //Establecemos para notas
                                    foreach ($asignaturas as $asg) {
                                         //areas
                                        if($asg->getEsArea()){
                                            foreach ($peridos_academicos as $p_a) {
                                            $areas_peridos_academicos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                                                ->findBy(array(
                                                    "padre"=>$p_a->getId(),
                                                    "tipo"=>2
                                                ));
                                            foreach ($areas_peridos_academicos as $areas_p_a) {
                                                
                                                      $a_d=new AlumnoDimension();
                                                      $a_d->setAlumno($alumno);
                                                      $a_d->setAsignatura($asg);                    
                                                      $a_d->setDimension($areas_p_a);                                        
                                                      $a_d->setNota(-1);
                                                      $a_d->setNotaBuffered(-1);
                                                      $em->persist($a_d);   
                                                }
                                            }
                                        }
                                        if($asg->getEsArea()==FALSE){
                                            //Ano escolar
                                                /*
                                                $a_d=new AlumnoDimension();
                                                $a_d->setAlumno($alumno);
                                                $a_d->setAsignatura($asg);                    
                                                $a_d->setDimension($ano_escolar);                                        
                                                $a_d->setNota(0.0);
                                                $em->persist($a_d);*/
                                                //Periodos Academicos De Ano Escolar.                    
                                                foreach ($peridos_academicos as $p_a) {
                                                        $a_d=new AlumnoDimension();
                                                        $a_d->setAlumno($alumno);
                                                        $a_d->setAsignatura($asg);                    
                                                        $a_d->setDimension($p_a);                                        
                                                        $a_d->setNota(-1);
                                                        $a_d->setNotaBuffered(-1);
                                                        $em->persist($a_d);
                                                        //ASistencia de los periodos
                                                        $asistencia_peridos_academicos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                                                                    ->findBy(array(
                                                                    "padre"=>$p_a->getId(),
                                                                    "tipo"=>3
                                                        ));
                                                foreach ($asistencia_peridos_academicos as $a_p_a) {
                                                        $a_d=new AlumnoDimension();
                                                        $a_d->setAlumno($alumno);
                                                        $a_d->setAsignatura($asg);                    
                                                        $a_d->setDimension($a_p_a);                                        
                                                        $a_d->setNota(-1);
                                                        $a_d->setNotaBuffered(-1);
                                                        $em->persist($a_d);      
                                                }
                                                //Actividades de Periodo
                                                $actividades_peridos_academicos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                                                        ->findBy(array(
                                                            "padre"=>$p_a->getId(),
                                                            "tipo"=>4,
                                                            "asignatura"=>$asg->getId()
                                                ));
                                                foreach ($actividades_peridos_academicos as $a_p_a) {
                                                    foreach ($a_p_a->getGrupo() as $g) {
                                                        if($g->getId()==$grupo_id){
                                                        $a_d=new AlumnoDimension();
                                                        $a_d->setAlumno($alumno);
                                                        $a_d->setAsignatura($asg);                    
                                                        $a_d->setDimension($a_p_a);                                        
                                                        $a_d->setNota(-1);
                                                        $a_d->setNotaBuffered(-1);
                                                        $em->persist($a_d);      
                                                        }   
                                                        
                                                    }  
                                                                
                                                                                    
                                                }                        
                                            }
                                    }
                                        }
                           $resultado="Alumno MATRICULADO Exitosamente.".$ano_escolar_id."d".$grupo_id;             
                        }
        
        
                //}
            //}
        }
        $em->flush();
        $format = $request->get('_format');        
        return new \Symfony\Component\HttpFoundation\Response($resultado);
        return $this->render(sprintf('NetpublicCoreBundle:Alumno:matricularalumnoantiguo.%s.twig', $format), array(        
        'alumnos' => $alumnos,
        'id_ano_escolar'=>$id_ano_escolar    
        
        ));
       
              

    }
    
            /**
     * Finds and displays a Alumno entity.
     * 
     * @Route("/cambiarfechaentraga.html", name="alumno_cambiarfechaentraga")
     * @Template()
     * 
     */
    public function cambiarfechaentragaAction()
    {
        $request=$this->getRequest();
        $session=$this->get('request')->getSession();     
        $em=  $this->getDoctrine()->getEntityManager();        
        $fecha_inicio=$request->get('fecha_inicio');
        $fecha_final=$request->get('fecha_final');
        $fi=new \DateTime($fecha_inicio);
        //$fi=$fi->format("Y-m-d H:i:s");
        $ff=new \DateTime($fecha_final);
        //$ff=$ff->format("Y-m-d H:i:s");       
        
        $periodo_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                                    ->findPeriodoEscolarActivo();
        $periodo_id=$session->get("perido_id",$periodo_escolar_activo->getId());
        $periodo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);
        $alumnos_id=$session->get('alumnos_id',array());   
        $profesores=array();
        for ($index = 0; $index < count($alumnos_id); $index++) {
            $usuario=$em->getRepository("NetpublicCoreBundle:Usuario")->find($alumnos_id[$index]);
            if(!$usuario->getEsAlumno()){
                $profesor=$usuario->getProfesor();
                $profesores[]=$profesor;
                $fecha_entrega_profesor=$em->getRepository("NetpublicCoreBundle:Profesorperiodoentrega")
                                           ->findOneBy(array(
                                                'profesor'=>$profesor->getId(),
                                                'periodo'=>$periodo_id
                ));
                $fecha_entrega_profesor->setFechaInicio($fi);
                $fecha_entrega_profesor->setFechaFinal($ff);
                $em->persist($fecha_entrega_profesor);
            }
        }
        $em->flush();
        return array(
            "profesores"=>$profesores,
            "periodo"=>$periodo,
            'fecha_inicio'=>$fi,
            'fecha_final'=>$ff
            );
    }
    /**
     * Finds and displays a Alumno entity.
     * 
     * @Route("/moveralumononuevogrupo.html", name="alumno_moveralumononuevogrupo")
     * @Template()
     * 
     */
    public function moveralumononuevogrupoAction()
    {
        $request=$this->getRequest();
        $session=$this->get('request')->getSession();     
        $em=  $this->getDoctrine()->getEntityManager();        
        
        $ano_escolar=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        $ano_escolaractivo_id=$ano_escolar->getId();
        $peridos_academicos=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodosEscolar($ano_escolar);
        $alumnos_id=$session->get('alumnos_id',array());   
        $alumnos=array();
        $grupos=array();
        for ($index = 0; $index < count($alumnos_id); $index++) {
            $usuario=$em->getRepository("NetpublicCoreBundle:Usuario")->find($alumnos_id[$index]);
            if($usuario->getEsAlumno()){
                $alumno=$usuario->getAlumno();
                $alumnos[]=$alumno;
                $grupos[]=$alumno->getGrupo();
                $em->getRepository("NetpublicCoreBundle:Alumno")->
                cancelarMatricula($alumno,$ano_escolaractivo_id);
                
              $em->flush();  
          $em->getRepository("NetpublicCoreBundle:Alumno")->asignarGrupo(
            $alumno,
            $request->get('grupo_id'),
            $peridos_academicos,
            $ano_escolaractivo_id      
            );
                 
                
            }
        }
        $em->flush();
        return array(
            'alumnos'=>$alumnos,
            'grupos'=>$grupos
        );
   }
    /**
     * Finds and displays a Alumno entity.
     * 
     * @Route("/{alumno_id}/borraruno.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|xls|pdf"}, name="alumno_borraruno")
     * @Template()
     * 
     */
    public function borrarunoAction($alumno_id)
    {
        $request=$this->getRequest();
        $session=$this->get('request')->getSession();                    
        $alumnos_id=$session->get('alumnos_id',array());
        $em=  $this->getDoctrine()->getEntityManager();
        $alumno=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")->find($alumno_id);
        //Notas de los Alumnos
        foreach ($alumno->getNota() as $notas) {
                    $em->remove($notas);
                    foreach ($notas->getNotaRecuperacion() as $value) {
                    $em->remove($value);
                    }
        }
        //$nota_desempeno
        foreach ($alumno->getNotaDesempeno() as $notas) {
                    $em->remove($notas);
        }
        //$matricula_alumno
        foreach ($alumno->getMatriculaAlumno() as $notas) {
                    $em->remove($notas);
        }
        //$alumno_acudiente
        foreach ($alumno->getMatriculaAlumno() as $notas) {
                    $em->remove($notas);
        }
        //$observacion
        foreach ($alumno->getObservacion() as $value) {
                    $em->remove($value);
        }
        //recuperaciones
        //$nivel_academico
        foreach ($alumno->getNivelAcademico() as $value) {
                    $em->remove($value);
                }
                foreach ($alumno->getSolicitud() as $value) {
                    $em->remove($value);
                }
                //
        $usuario_=$alumno->getUsuario();
        foreach ($alumno->getAlumnoCursado() as $value) {
                    $em->remove($value);
        }
        
        $em->remove($usuario_);
        $em->remove($alumno);
        $re="Borrado se realizo Exitosamente.";               
        $em->flush();
      return new Response($re);
    }
   
    /**
     * Finds and displays a Alumno entity.
     * 
     * @Route("/borrarvarios.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|xls|pdf"}, name="alumno_borrarvarios")
     * @Template()
     * 
     */
    public function borrarvariosAction()
    {
        $request=$this->getRequest();
        $session=$this->get('request')->getSession();                    
        $alumnos_id=$session->get('alumnos_id',array());
        $alumnos=array();
        $es_archivo=array();
        $em=  $this->getDoctrine()->getEntityManager();
        for ($index = 0; $index < count($alumnos_id); $index++) {
            $usuario=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Usuario")->find($alumnos_id[$index]);
            if($usuario->getEsAlumno()){
                $alumno=$usuario->getAlumno();
                $mi_alumno[]=$alumno;
                $mi_alumno_temporal[]=$alumno;
                //Notas de los Alumnos
                foreach ($alumno->getNota() as $notas) {
                    $em->remove($notas);
                }
                //$nota_desempeno
                foreach ($alumno->getNotaDesempeno() as $notas) {
                    $em->remove($notas);
                }
                //$matricula_alumno
                foreach ($alumno->getMatriculaAlumno() as $notas) {
                    $em->remove($notas);
                }
                //$alumno_acudiente
                foreach ($alumno->getMatriculaAlumno() as $notas) {
                    $em->remove($notas);
                }
                
                //$observacion
                foreach ($alumno->getObservacion() as $value) {
                    $em->remove($value);
                }
                //$nivel_academico
                foreach ($alumno->getNivelAcademico() as $value) {
                    $em->remove($value);
                }
                foreach ($alumno->getSolicitud() as $value) {
                    $em->remove($value);
                }
                //
                $usuario_=$alumno->getUsuario();
                $em->remove($usuario_);
                $em->remove($alumno);
 $re="Borrado se realizo Exitosamente.";               
            }
            
 else {
     
     $profesor=$usuario->getProfesor();
     $tipo=$profesor->getTipo();
     if($tipo!=2){
        $em->remove($profesor); 
        $em->remove($usuario);
        $re="Auxiliar o Rector, Borrado se realizo Exitosamente..";
     }
     else{
         $re="<span style='color:red;font-size:19px;'>Lo sentimos, no esta permitido Borrar profesores.Cambiale De Perfil y luego puedes eliminalo";
     }
     
     
 }
        }
        $em->flush();
        return new Response($re);
    }
    /**
     * Finds and displays a Alumno entity.
     * 
     * @Route("/{alumno_id}/imprimirconstanciaestudio.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|xls|pdf"}, name="alumno_imprimirconstanciaestudio")
     * @Template()
     * 
     */
    public function imprimirconstanciaestudioAction($alumno_id)
    {
       set_time_limit(0);
       ini_set('memory_limit', '-1');    
       $session=  $this->getRequest()->getSession();  
       $em=  $this->getDoctrine()->getEntityManager();
       $alumno=  $this->getDoctrine()
                       ->getRepository("NetpublicCoreBundle:Alumno")
                       ->find($alumno_id);
       $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
       $anos_escolares=array();
   
       $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($ano_escolar_id_s);
        $a_m=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findOneBy(array(
            'ano'=>$ano_escolar_activo->getId(),
            'alumno'=>$alumno_id
            ));
        $grupo=$a_m->getGrupo();
        if($grupo){
            ;
        }
        else{
            $grupo=$alumno->getGrupo();
        }
        if($grupo){
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
        $periodos_escolares=$em->createQuery("SELECT a FROM NetpublicCoreBundle:Dimension a WHERE a.nivel<=:nivel and a.tipo=1 and a.padre=:padre ORDER BY a.nivel ASC")                
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
                                            $grupo->getId()
                                            );
        
        
        
        
        
        $observaciones=  $this->getDoctrine()
                          ->getRepository("NetpublicCoreBundle:Observacion")
                          ->findBy(array(
                              'alumno'=>$alumno_id,
                              'periodo'=>$periodo_activo->getId()
                          ))
                ;
        
        
        $promedio_grupo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")
        ->getPromedioGrupo($grupo->getId(),$periodo_activo);
        
        $nro_alum_grupo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")
                            ->getNroAlumnosGrupo($grupo->getId());
        $promedio_alumno=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")
        ->getPromedioAlumnoGrupo($alumno,$periodo_activo);
       }
       else{
           return new Response("Este alumno no esta matriculado");
       }
       $src_img_escudo='/iNachoLeeYuri/web/uploads/documents/escudo_colegio'.$colegio->getId().'.png';
       $src_img_firma_rector='/iNachoLeeYuri/web/uploads/documents/foto_firma_rector.jpg';
        $plantilla=$em->getRepository("NetpublicCoreBundle:Plantillabc3")->findOneBy(array(
           'referecnia'=>2,
           'tipo'=>0
       ));
       $cuerpo_notas= \Netpublic\CoreBundle\Util\Plantillas::getPlantilla(1);       
       $contenido=  str_replace("{{tabla_notas_boletin_defecto}}", $cuerpo_notas, $plantilla->getContenido());
       
       $cuerpo_constancia= \Netpublic\CoreBundle\Util\Plantillas::getPlantilla(2);  
       $contenido=  str_replace("{{tabla_constacia_defecto}}", $cuerpo_constancia, $contenido);
       
       $foto_alumno= \Netpublic\CoreBundle\Util\Plantillas::getFotoAlumno();  
       $contenido=  str_replace("{{foto_alumno}}", $foto_alumno, $contenido);
       
       $foto_alumno= \Netpublic\CoreBundle\Util\Plantillas::getFotoAlumno("circle");  
       $contenido=  str_replace("{{foto_alumno_circulo}}", $foto_alumno, $contenido);
       
       $foto_alumno= \Netpublic\CoreBundle\Util\Plantillas::getFotoAlumno("redondo");  
       $contenido=  str_replace("{{foto_alumno_cuadrado}}", $foto_alumno, $contenido);
       
       $twig = new \Twig_Environment(new \Twig_Loader_String());
       $rendered = $twig->render(
                           "<div style='page-break-after: always;page-break-inside: avoid;'>$contenido</div>",
                     array( 
                    'datos'=>$datos,
                    'periodos_escolares'=>$periodos_escolares,
                    'colegio'=>$colegio,
                    'alumno'=>$alumno,
                    'ano_escolar_activo'=>$padre,
                    'periodo_escolar_activo'=>$periodo_escolar_activo,
                    'observaciones'=>$observaciones,                    
                    'nro_alumnos_grupo'=>$nro_alum_grupo,
                    'promedio_grupo'=>$promedio_grupo,
                    'promedio_estudiante'=>$promedio_alumno["promedio_estudiante"],
                    'puesto'=>$promedio_alumno["puesto"],
                    'anos_escolares'=>$anos_escolares,
                    'src_img_escudo'=>$src_img_escudo,
                    'src_img_firma_rector'=>$src_img_firma_rector     
                    
        )
        );
       return new Response($rendered);
    }    
    /**
     * Finds and displays a Alumno entity.
     * 
     * @Route("/{alumno_id}/imprimircarnet.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|xls|pdf"}, name="alumno_imprimircarnet")
     * @Template()
     * 
     */
    public function imprimircarnetAction($alumno_id)
    {
        $request=  $this->getRequest();
        $alumno=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")->find($alumno_id);           
        $colegio=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")->find(1);        
        $format = $request->get('_format');        
        return $this->render(sprintf('NetpublicCoreBundle:Alumno:imprimircarnet.%s.twig', $format), array(
        'colegio' => $colegio,
        'alumno' => $alumno,
        ));                  
        
    }
    
    /**
     * Finds and displays a Alumno entity.
     * 
     * @Route("/{profesor_id}/{asignatura_id}/{periodo_id}/imprimirplanillanotas.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|xls|pdf"}, name="alumno_imprimirplanillanotas")
     * @Template()
     * 
     */
    public function imprimirplanillanotasAction($profesor_id,$asignatura_id,$periodo_id)
    {
        $request=$this->getRequest();
        //
        
        $periodo_escolar=$periodo_id;   
        /*$dim_periodo_escolar=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
            'padre'=>$periodo_escolar,
            'profesor'=>$profesor_id            
        ));*/
        $em=$this->getDoctrine()->getEntityManager();
        /*$dim_periodo_escolar=$em->createQuery("SELECT a FROM NetpublicCoreBundle:Dimension a WHERE (a.padre=:padre_id AND a.profesor=:profesor_id) OR a.id=:id_periodo OR (a.padre=:padre_id AND a.tipo=3)  ORDER BY a.tipo DESC")                
                                 ->setParameters(array(
                                         "padre_id"=>$periodo_escolar,
                                          "profesor_id"=>$profesor_id,
                                          "id_periodo"=>$periodo_escolar
                                     ))
                                            ->getResult(); */                   
        
        $session=$this->get('request')->getSession();                    
        $alumnos_id=$session->get('alumnos_id',array());
        // new \Symfony\Component\HttpFoundation\Response($alumnos_id[0]);
        $alumnos=array();
        for ($index = 0; $index < count($alumnos_id); $index++) {
            $usuario=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Usuario")->find($alumnos_id[$index]);
            if($usuario->getEsAlumno())
                $mi_alumno=$usuario->getAlumno();
            $alumnos[]=$mi_alumno;
        }            
        $colegio=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")->find(1);        
        $format = $request->get('_format');  
        $entities_=  array();;
       //{
                  if($format=='xls'){       
                    $xls_service =  $this->get('xls.service_xls5');
        // create the object see http://phpexcel.codeplex.com documentation
                    $xls_service->getProperties()->setCreator("Maarten Balliauw")
                             ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");
                 //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 8, 'Some value');  
                 $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                    ->setCellValueByColumnAndRow(0, 1,"   ");   
                 /*for ($index1 = 0; $index1 < count($dim_periodo_escolar); $index1++) {
                     $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                    ->setCellValueByColumnAndRow($index1+1, 1,$dim_periodo_escolar[$index1]->getNombre());

                 }*/
                  }
                 for ($index2 = 0; $index2 < count($alumnos); $index2++) {
                      if($format=='xls')
                      $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                    ->setCellValueByColumnAndRow(0, $index2+2,"{$alumnos[$index2]}");
            $query="SELECT a_d FROM NetpublicCoreBundle:AlumnoDimension a_d JOIN a_d.dimension d JOIN a_d.asignatura a";
            $query.=" WHERE (d.padre=:periodo_id";
            $query.=" AND a.id=:asignatura_id";
            $query.=" AND a_d.alumno=:alumno_id";
            $query.=" AND d.tipo=4)";
            $query.=" OR (";
            $query.=" a_d.dimension=:periodo_id";
            $query.=" AND a.id=:asignatura_id";
            $query.=" AND a_d.alumno=:alumno_id";
            $query.=" AND d.tipo=:tipo_periodo)";            
            $query.=" OR (";
            $query.=" d.padre=:periodo_id";
            $query.=" AND a.id=:asignatura_id";
            $query.=" AND a_d.alumno=:alumno_id";
            $query.=" AND d.tipo=3)"; 
            $query.=" ORDER BY d.tipo DESC";
            $entities=$em->createQuery($query)                
                                 ->setParameters(array(
                                         "periodo_id"=>$periodo_escolar,
                                         "asignatura_id"=>$asignatura_id,
                                         "alumno_id"=>$alumnos[$index2]->getId(),
                                         "tipo_periodo"=>1
                                      ))->getResult(); 
            $entities_[]=$entities;
             if($format=='xls'){
                      for ($index3 = 0; $index3 < count($entities); $index3++) {
                          if($index2==0){
                              $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                    ->setCellValueByColumnAndRow($index3+1, 1,$entities[$index3]->getDimension()->getNombre());

                          }
                          $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                    ->setCellValueByColumnAndRow($index3+1,$index2+2,$entities[$index3]->getNota());
                      }
                 }
        
                 }
                 
                
                   if($format=='xls'){  
                        $response = $xls_service->getResponse();
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=stdream2.xls');        
        return $response;   
                   }


        //}
        return $this->render(sprintf('NetpublicCoreBundle:Alumno:imprimirplanillanotas.%s.twig', $format), array(        
        'alumnos' => $alumnos,        
        'asignatura_filtro'=>$asignatura_id,        
        //'dim_periodo_escolar'=>$dim_periodo_escolar,
        "entities_"=>$entities_    
        ));                  
        
    }    
    /**
     * Finds and displays a Alumno entity.
     * 
     * @Route("/{periodo_id}/{profesor_id}/{asignatura_id}/imprimirplanillablanco.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|xls|pdf"}, name="alumno_imprimirplanillablanco")
     * @Template()
     * 
     */
    public function imprimirplanillablancoAction($periodo_id,$profesor_id,$asignatura_id)
    {
       $request=$this->getRequest();
        //
        
        $periodo_escolar=$periodo_id;   
        /*$dim_periodo_escolar=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
            'padre'=>$periodo_escolar,
            'profesor'=>$profesor_id            
        ));*/
        $em=$this->getDoctrine()->getEntityManager();
        /*$dim_periodo_escolar=$em->createQuery("SELECT a FROM NetpublicCoreBundle:Dimension a WHERE (a.padre=:padre_id AND a.profesor=:profesor_id) OR a.id=:id_periodo OR (a.padre=:padre_id AND a.tipo=3)  ORDER BY a.tipo DESC")                
                                 ->setParameters(array(
                                         "padre_id"=>$periodo_escolar,
                                          "profesor_id"=>$profesor_id,
                                          "id_periodo"=>$periodo_escolar
                                     ))
                                            ->getResult(); */                   
        
        $session=$this->get('request')->getSession();                    
        $alumnos_id=$session->get('alumnos_id',array());
        // new \Symfony\Component\HttpFoundation\Response($alumnos_id[0]);
        $alumnos=array();
        for ($index = 0; $index < count($alumnos_id); $index++) {
            $usuario=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Usuario")->find($alumnos_id[$index]);
            if($usuario->getEsAlumno())
                $mi_alumno=$usuario->getAlumno();
            $alumnos[]=$mi_alumno;
        }            
        $colegio=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")->find(1);        
        $format = $request->get('_format');  
        $entities_=  array();;
       //{
                  if($format=='xls'){       
                    $xls_service =  $this->get('xls.service_xls5');
        // create the object see http://phpexcel.codeplex.com documentation
                    $xls_service->getProperties()->setCreator("Maarten Balliauw")
                             ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");
                 //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 8, 'Some value');  
                 $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                    ->setCellValueByColumnAndRow(0, 1,"   ");   
                 /*for ($index1 = 0; $index1 < count($dim_periodo_escolar); $index1++) {
                     $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                    ->setCellValueByColumnAndRow($index1+1, 1,$dim_periodo_escolar[$index1]->getNombre());

                 }*/
                  }
                 for ($index2 = 0; $index2 < count($alumnos); $index2++) {
                      if($format=='xls')
                      $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                    ->setCellValueByColumnAndRow(0, $index2+2,"{$alumnos[$index2]}");
            $query="SELECT a_d FROM NetpublicCoreBundle:AlumnoDimension a_d JOIN a_d.dimension d JOIN a_d.asignatura a";
            $query.=" WHERE (d.padre=:periodo_id";
            $query.=" AND a.id=:asignatura_id";
            $query.=" AND a_d.alumno=:alumno_id";
            $query.=" AND d.tipo=4)";
            $query.=" OR (";
            $query.=" a_d.dimension=:periodo_id";
            $query.=" AND a.id=:asignatura_id";
            $query.=" AND a_d.alumno=:alumno_id";
            $query.=" AND d.tipo=:tipo_periodo)";            
            $query.=" OR (";
            $query.=" d.padre=:periodo_id";
            $query.=" AND a.id=:asignatura_id";
            $query.=" AND a_d.alumno=:alumno_id";
            $query.=" AND d.tipo=3)"; 
            $query.=" ORDER BY d.tipo DESC";
            $entities=$em->createQuery($query)                
                                 ->setParameters(array(
                                         "periodo_id"=>$periodo_escolar,
                                         "asignatura_id"=>$asignatura_id,
                                         "alumno_id"=>$alumnos[$index2]->getId(),
                                         "tipo_periodo"=>1
                                      ))->getResult(); 
            $entities_[]=$entities;
             if($format=='xls'){
                      for ($index3 = 0; $index3 < count($entities); $index3++) {
                          if($index2==0){
                              $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                    ->setCellValueByColumnAndRow($index3+1, 1,$entities[$index3]->getDimension()->getNombre());

                          }
                          $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                    ->setCellValueByColumnAndRow($index3+1,$index2+2,"   ");
                      }
                 }
        
                 }
                 
                
                   if($format=='xls'){  
                        $response = $xls_service->getResponse();
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=stdream2.xls');        
        return $response;   
                   }


        //}
        return $this->render(sprintf('NetpublicCoreBundle:Alumno:imprimirplanillablanco.%s.twig', $format), array(        
        'alumnos' => $alumnos,        
        'asignatura_filtro'=>$asignatura_id,        
        //'dim_periodo_escolar'=>$dim_periodo_escolar,
        "entities_"=>$entities_    
        ));                  
                      
        
    }
    /**
     * Finds and displays a Alumno entity.
     * 
     * @Route("/{id_plantilla}/{tipo}/guardarplanilla", name="alumno_guardarplanilla")
     * @Template()
     * 
     */
    public function guardarplanillaAction($id_plantilla,$tipo)
    {
        $em=  $this->getDoctrine()->getManager();
        set_time_limit(0);
        ini_set('memory_limit', '-1');    
         
        $contenido=  $this->getRequest()->get('contenido');
        $contenido=  str_replace('\"', "'", $contenido);
        
        $plantilla=$em->getRepository("NetpublicCoreBundle:Plantillabc3")->findOneBy(array(
           'referecnia'=>$id_plantilla,
           'tipo'=>$tipo
       ));
       //$contenido=  str_replace('{{tabla_notas_boletin_defecto}}',$cuerpo_notas, $contenido); 
       $plantilla->setContenido($contenido);
       $em->persist($plantilla);
       $em->flush();
       return new Response("ok");
    }
     /**
     * Finds and displays a Alumno entity.
     * 
     * @Route("/{id_plantilla}/{tipo}/getcontenidoplantilla", name="alumno_getcontenidoplantilla")
     * @Template()
     * 
     */
    public function getcontenidoplantillaAction($id_plantilla,$tipo)
    {
       $em=  $this->getDoctrine()->getManager();                   
       $plantilla=$em->getRepository("NetpublicCoreBundle:Plantillabc3")->findOneBy(array(
           'referecnia'=>$id_plantilla,
           'tipo'=>$tipo
       ));
       if($plantilla){
           $rendered=$plantilla->getContenido();
       }
       else{
           $plantilla_nueva=new \Netpublic\CoreBundle\Entity\Plantillabc3();
           $plantilla_nueva->setReferecnia($id_plantilla);
           $plantilla_nueva->setTipo($tipo);
           $plantilla_nueva->setContenidoEstatico("sdadas");
           $plantilla_nueva->setContenido("Ingrese contenido, use los labels");
           $em->persist($plantilla_nueva);
           $em->flush();
           $rendered=$plantilla_nueva->getContenido();
       }
       return array(
           'cuerpo'=>$rendered
       );
        
    }        

    /**
     * Finds and displays a Alumno entity.
     * 
     * @Route("/{referencia}/{tipo}/mostrareditor", name="alumno_mostrareditor")
     * @Template()
     * 
     */
    public function mostrareditorAction($referencia,$tipo)
    {
        return array(
           'plantilla_id'=>$referencia,
            'tipo'=>$tipo
       );
        
    }
     /**
     * Finds and displays a Alumno entity.
     * 
     * @Route("/{alumno_id}/{id_plantilla}/{tipo}/imprimirboletin.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|xls|pdf"}, name="alumno_imprimirboletin")
     * @Template()
     * 
     */
    public function imprimirboletinAction($alumno_id,$id_plantilla,$tipo)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');    
        $session=  $this->getRequest()->getSession(); 
       $em=  $this->getDoctrine()->getEntityManager();
       $alumno=  $this->getDoctrine()
                       ->getRepository("NetpublicCoreBundle:Alumno")
                       ->find($alumno_id);
       $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
       $anos_escolares=array();
        $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($ano_escolar_id_s);
        $grupo=$alumno->getGrupo();
        $a_m=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findOneBy(array(
            'ano'=>$ano_escolar_activo->getId(),
            'alumno'=>$alumno_id
            ));
        $grupo=$a_m->getGrupo();
        if($grupo){
            ;
        }
        else{
            $grupo=$alumno->getGrupo();
        }
        
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

                $promedio_grupo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")
                ->getPromedioGrupo($grupo_id,$periodo_activo);
                $promedio_grupo=  number_format($promedio_grupo,1);

                $nro_alum_grupo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")
                                    ->getNroAlumnosGrupo($grupo_id);
                $promedio_alumno=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")
                ->getPromedioAlumnoGrupo($alumno,$periodo_activo);
               // $promedio_alumno=  number_format($promedio_alumno['promedio_estudiante'],2);      
               $plantilla=$em->getRepository("NetpublicCoreBundle:Plantillabc3")->findOneBy(array(
                   'referecnia'=>$id_plantilla,
                   'tipo'=>$tipo
               ));
               $contenido=$plantilla->getContenido();

               $cuerpo_notas= \Netpublic\CoreBundle\Util\Plantillas::getPlantilla(1,0);       
               $contenido=  str_replace("{{tabla_notas_boletin_defecto}}", $cuerpo_notas, $contenido);

               $cuerpo_notas= \Netpublic\CoreBundle\Util\Plantillas::getPlantilla(1,1);//Plantila con logros       
               $contenido=  str_replace("{{tabla_notas_logros_caritasfelices_boletin_defecto}}", $cuerpo_notas, $contenido);

               $cuerpo_notas= \Netpublic\CoreBundle\Util\Plantillas::getPlantilla(1,2);//Plantila con logros       
               $contenido=  str_replace("{{tabla_notas_logros_resumen_boletin}}", $cuerpo_notas, $contenido);


               $foto_alumno= \Netpublic\CoreBundle\Util\Plantillas::getFotoAlumno();  
               $contenido=  str_replace("{{foto_alumno}}", $foto_alumno, $contenido);

               $foto_alumno= \Netpublic\CoreBundle\Util\Plantillas::getFotoAlumno("circle");  
               $contenido=  str_replace("{{foto_alumno_circulo}}", $foto_alumno, $contenido);

               $foto_alumno= \Netpublic\CoreBundle\Util\Plantillas::getFotoAlumno("redondo");  
               $contenido=  str_replace("{{foto_alumno_cuadrado}}", $foto_alumno, $contenido);
               //$contenido=html_entity_decode($contenido);
               $twig = new \Twig_Environment(new \Twig_Loader_String());
               $rendered = $twig->render(
                               "<div class='no-imprimir' style='float: right;'><a href='#' onclick='sincronizarNotasPuestos($grupo_id);'> <i class='icon-refresh'></i> Actualizar Puesto para $grupo</a> </div>". 
                               "<div style='clear:both;'></div>".
                               "<div style='page-break-after:always;'>$contenido</div>",
                             array( 
                            'datos'=>$datos,
                            'periodos_escolares'=>$periodos_escolares,
                            'colegio'=>$colegio,
                            'alumno'=>$alumno,
                            'ano_escolar_activo'=>$padre,
                            'periodo_escolar_activo'=>$periodo_escolar_activo,
                            'observaciones'=>$observaciones,
                            'nro_alumnos_grupo'=>$nro_alum_grupo,
                            'promedio_grupo'=>$promedio_grupo,
                            'promedio_estudiante'=>number_format($promedio_alumno['promedio_estudiante'],1),
                            'puesto'=>$promedio_alumno["puesto"],
                            'anos_escolares'=>$anos_escolares

                )
                );
        }
        else{
            $rendered="<div style='page-break-after:always;'><span style='color:red;'>Lo siento el alumno $alumno no esta en ningun grupo en el año $ano_escolar_activo, por favor verifique en el  GESTOR DE MATRICULAS</span></div>";
        }
               return new Response($rendered);
         
    }        
    
     /**
     * Finds and displays a Alumno entity.
     * 
     * @Route("/{alumno_id}/imprimircertificadoestudio.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|xls|pdf"}, name="alumno_imprimircertificadoestudio")
     * @Template()
     * 
     */
    public function imprimircertificadoestudioAction($alumno_id)
    {
       set_time_limit(0);
       ini_set('memory_limit', '-1');    
       $session=  $this->getRequest()->getSession();
       $em=$this->getDoctrine()->getEntityManager();
        $alumno=$em->getRepository("NetpublicCoreBundle:Alumno")->find($alumno_id);
         $colegio=  $this->getDoctrine()
                       ->getRepository("NetpublicCoreBundle:Colegio")
                       ->findOneBy(array(
                           'es_principal'=>1
                       ));
         $periodo_activo=  $this->getDoctrine()
                          ->getRepository("NetpublicCoreBundle:Dimension")
                          ->findOneBy(array(
                              "es_ano_escolar"=>1,
                              "tipo"=>1
                          ));
       
       
        
        $padre=  $em
                      ->getRepository("NetpublicCoreBundle:Dimension")
                      ->findAnoEscolarActivo();
       $ano_escolar_id_s=$session->get("ano_escolar_id",$padre->getId());
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($ano_escolar_id_s);
        $a_m=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findOneBy(array(
            'ano'=>$ano_escolar_activo->getId(),
            'alumno'=>$alumno_id
            ));
        $grupo=$a_m->getGrupo();
        if($grupo){
            ;
        }
        else{
            $grupo=$alumno->getGrupo();
        }
               
       $promedio_area=0;
       $periodos_escolares=$em
                        ->createQuery("SELECT a FROM NetpublicCoreBundle:Dimension a WHERE a.nivel<=:nivel and a.tipo=1 and a.padre=:padre ORDER BY a.nivel ASC")                
                        ->setParameters(array(
                            'padre'=>$padre->getId(),
                            'nivel'=>$periodo_activo->getNivel()
                        ))->getResult(); 

        $areas=  $this->getDoctrine()
                      ->getRepository("NetpublicCoreBundle:Asignatura")
                      ->findBy(array(
                          'es_area'=>1,
                          "grado"=>$grupo->getGrado()->getId()
                      ));
                $areas_json=array();
        foreach ($areas as $area) {
                    $nro_periodos=0;
                    $acumulado_area=0;
                    foreach ($periodos_escolares as $periodo) {                        
                        $nro_periodos++;
                        $nota_area=$this->getDoctrine()
                                    ->getRepository("NetpublicCoreBundle:Alumno")
                                    ->getNotasAreasAlumnoPeriodo(
                                            $alumno->getId(),
                                            $area->getId(),
                                            $periodo->getId());
                        foreach ($nota_area as $nota) {
                            $acumulado_area=$acumulado_area+$nota->getNota();
                            //echo "({$periodo->getPadre()} .. {$nota->getDimension()->getPadre()->getPadre()} )";
                        }
                        
                    }
                    if($nro_periodos>0)
                        $promedio_area=$acumulado_area/$nro_periodos;                    
                    //echo "El promedios $area:".$promedio_area;                
                $promedio_area=number_format($promedio_area, 1);
                //echo "Promedio $promedio_area";
                $desempeno="<span style='color:red;'>Nota no valida</span>";
                if($promedio_area > $colegio->getValorMinimoSobresaliente() &&
                   $promedio_area <= $colegio->getValorMaximoSobresaliente()){
                        $desempeno="SUPERIOR";
                }
                if ($promedio_area > $colegio->getValorMinimoAceptable() &&
                        $promedio_area<=$colegio->getValorMaximoAceptable()){
                        $desempeno="ALTO";
                }
                if ($promedio_area > $colegio->getValorMinimoInsuficiente() &&
                        $promedio_area <=$colegio->getValorMaximoInsuficiente()){
                     $desempeno="BÁSICO";
                }
              
                if ($promedio_area >= $colegio->getValorMinimoDeficiente() && 
                   $promedio_area <=$colegio->getValorMaximoDeficiente()){
                   $desempeno="BAJO";
                }
                $areas_json[]=array(
                        'nombre'=>"$area",
                        'nota'=>$promedio_area,
                        "desempeno"=>$desempeno,
                        'ih'=>$area->getDuracionMinutos()/60
                    );
        }
                //Informacion del alumno
                 $alumnos_json=array(
                    "alumno"=>$alumno,
                    "areas" =>$areas_json
                        );             
        $colegio->setNumeroCertificados($colegio->getNumeroCertificados()+1);
        $em->persist($colegio);
        $em->flush();
        $src_img_escudo='/uploads/documents/escudo_colegio'.$colegio->getId().'.png';
       //$ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
       $anos_escolares=array();
       
        
       if($grupo){
        $grado=$alumno->getGrado();
        $grupo_id=$grupo->getId();
        
        $areas=  $this->getDoctrine()
                       ->getRepository("NetpublicCoreBundle:Asignatura")
                       ->findBy(array(
                           'grado'=>$grado->getId(),
                           'es_area'=>1
                       ));
        
        
        $periodos_escolares=$em
                ->createQuery("SELECT a FROM NetpublicCoreBundle:Dimension a WHERE a.id<=:id and a.tipo=1 and a.padre=:padre")                
                ->setParameters(array(
                    'padre'=>$padre->getId(),
                    'id'=>$periodo_activo->getId()
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
        
        
        $promedio_grupo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")
        ->getPromedioGrupo($grupo_id,$periodo_activo);
        
        $nro_alum_grupo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")
                            ->getNroAlumnosGrupo($grupo_id);
        $promedio_alumno=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")
        ->getPromedioAlumnoGrupo($alumno,$periodo_activo);
       }
       else{
           return new Response("Este alumno no esta matriculado");
       }
       $src_img_escudo='/iNachoLeeYuri/web/uploads/documents/escudo_colegio'.$colegio->getId().'.png';
       $src_img_firma_rector='/iNachoLeeYuri/web/uploads/documents/foto_firma_rector.jpg';
       $plantilla=$em->getRepository("NetpublicCoreBundle:Plantillabc3")->findOneBy(array(
           'referecnia'=>3,
           'tipo'=>0
       ));
       $cuerpo_notas= \Netpublic\CoreBundle\Util\Plantillas::getPlantilla(1);       
       $contenido=  str_replace("{{tabla_notas_boletin_defecto}}", $cuerpo_notas, $plantilla->getContenido());

       $foto_alumno= \Netpublic\CoreBundle\Util\Plantillas::getPlantilla(3);  
       $contenido=  str_replace("{{tabla_certificado_defecto}}", $foto_alumno, $contenido);
       
       
       $foto_alumno= \Netpublic\CoreBundle\Util\Plantillas::getFotoAlumno();  
       $contenido=  str_replace("{{foto_alumno}}", $foto_alumno, $contenido);
       
       $foto_alumno= \Netpublic\CoreBundle\Util\Plantillas::getFotoAlumno("circle");  
       $contenido=  str_replace("{{foto_alumno_circulo}}", $foto_alumno, $contenido);
       
       $foto_alumno= \Netpublic\CoreBundle\Util\Plantillas::getFotoAlumno("redondo");  
       $contenido=  str_replace("{{foto_alumno_cuadrado}}", $foto_alumno, $contenido);    
       
       $twig = new \Twig_Environment(new \Twig_Loader_String());
       $rendered = $twig->render(
                           "<div style='page-break-after:always;'>$contenido</div>",
                     array(        
          'alumno' => $alumno,
          "colegio"=> $colegio,
          "datos_alumno"=>$alumnos_json,
                    'datos'=>$datos,
                    'periodos_escolares'=>$periodos_escolares,
                    'ano_escolar_activo'=>$padre,
                    'periodo_escolar_activo'=>$periodo_activo,
                    'observaciones'=>$observaciones,
                    'nro_alumnos_grupo'=>$nro_alum_grupo,
                    'promedio_grupo'=>$promedio_grupo,
                    'promedio_estudiante'=>$promedio_alumno["promedio_estudiante"],
                    'puesto'=>$promedio_alumno["puesto"],
                    'anos_escolares'=>$anos_escolares,
                    'src_img_escudo'=>$src_img_escudo,
                    'src_img_firma_rector'=>$src_img_firma_rector     
                    
                         
        ));                  
        return new Response($rendered);
    } 
     /**
     * Finds and displays a Alumno entity.
     * 
     * @Route("/{ano_escolar}/{periodo_escolar}/imprimirmejorespuntajes.{_format}",defaults={"_format"="pdf"}, requirements={"_format"="html|xls|pdf"}, name="alumno_imprimirmejorespuntajes")
     *  
     * @Template()
     * 
     */
    public function imprimirmejorespuntajesAction($ano_escolar,$periodo_escolar)
    {
        $request=$this->getRequest();
        $session=$this->get('request')->getSession();                    
        
        $em=$this->getDoctrine()->getEntityManager();
        $dim_periodo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
               'tipo'=>5
            ));

       foreach ($dim_periodo as $d_p) {
        $em->createQuery("DELETE NetpublicCoreBundle:AlumnoDimension u WHERE u.dimension=:id_dimension")
                ->setParameters(array(
                    'id_dimension'=>$d_p->getId()
                    
                ))->execute();             
       }
       $perido_id= $periodo_escolar;//$request->get('periodo_escolar');
       $ano_escolar= $ano_escolar;//$request->get('ano_escolar');
       if($perido_id==-1){           
                $ano_escolar_periodo=$ano_escolar; 
       }
       else{
           
                $ano_escolar_periodo=$perido_id; 
       }
        
        $alumnos_id=$session->get('alumnos_id',array());
        
        $alumnos=array();
        
        for ($index = 0; $index < count($alumnos_id); $index++) {
            $usuario=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Usuario")->find($alumnos_id[$index]);
            if($usuario->getEsAlumno())
                $alumnos[]=$usuario->getAlumno();
        }  
        //$alumnos=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")->findAll();
       
        foreach ($alumnos as $alumno) {
            
            //$notas=$alumno->getNota();
            $asignaturas=$alumno->getGrado()->getAsignaturas();
            $promedio_area=0;
            $numeros_materias_area=0; 
            foreach ($asignaturas as $asignatura) {
                if($asignatura->getEsArea()){                                                               
                       $numeros_materias_area++;                    
                       //foreach ($periodo_escolares as $p_e) {
                        //if($nota_->getDimension()->getTipo()==2 && $nota_->getDimension()->getPadre()->getId()==$p_e->getId() && $nota_->getAsignatura()->getId()==$asignatura->getId()){                                   
                            $query="SELECT a_d FROM NetpublicCoreBundle:AlumnoDimension a_d JOIN a_d.dimension d";
                            $query.=" WHERE (d.padre=:periodo_id";
                            $query.=" AND a_d.asignatura=:asignatura_id";
                            $query.=" AND a_d.alumno=:alumno_id";
                            $query.=" AND d.tipo=2)";            
                            $notas=$em->createQuery($query)                
                                 ->setParameters(array(
                                         "periodo_id"=>$ano_escolar_periodo,
                                         "asignatura_id"=>$asignatura->getId(),
                                         "alumno_id"=>$alumno->getId()                                     
                                      ))->getResult();     
                            foreach ($notas as $nota_) {
                                   $nota_tem=$nota_->getNota(); 
                                   $promedio_area+=$nota_tem;
                                   if($nota_tem>0){                                    
                                   
                                   }
                                   
                                 
                        //}
                   }
       
                   //}

           
                }   
            }
            if($numeros_materias_area>0)
                        $promedio_area=$promedio_area/$numeros_materias_area;
           $notas_promedio=new AlumnoDimension();
           $notas_promedio->setAlumno($alumno);
           //$notas_promedio->setAsignatura($asignatura);
           $dimension=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findOneBy(array(
                   'padre'=>$ano_escolar_periodo,
                       'tipo'=>5
                   ));             
                        $notas_promedio->setDimension($dimension);
                   
               
           $notas_promedio->setNota(number_format($promedio_area,1)); 
           $em->persist($notas_promedio); 
           
            
        }
       $em->flush();
        $repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:AlumnoDimension');
        $query = $repository->createQueryBuilder('a'); 
        $query = $query->join("a.dimension","d");
        $query = $query->join("a.alumno","m");
        $query =  $query->where('d.tipo=5');
        $query =  $query->andWhere('d.padre=:dimension_padre_id');    
        $query =  $query->setParameter('dimension_padre_id',$ano_escolar_periodo);                
        $query =  $query->orderBy('a.nota', 'DESC');
        $query =  $query->getQuery();        
        $resultado = $query->getResult();
        $posicion=1;
        foreach ($resultado as $a_d) {
            $alumno_=$a_d->getAlumno();
            $alumno_->setPosicionAcademica($posicion);
            $em->persist($alumno_);
            $posicion++;
        }
        $em->flush();
        $format = $request->get('_format');        
        return $this->render(sprintf('NetpublicCoreBundle:Alumno:imprimirmejorespuntajes.%s.twig', $format), array(        
         'notas_promedios'=>$resultado
        ));        
        
    } 
         /**
     * Finds and displays a Alumno entity.
     * 
     * @Route("/imprimirlibrofinal.{_format}",defaults={"_format"="xls"}, requirements={"_format"="html|xls|pdf"}, name="alumno_imprimirlibrofinal")
     * @Template()
     * 
     */
    public function imprimirlibrofinalAction(){          
    ini_set('memory_limit', '-1');    
    set_time_limit(0);

        $em=$this->getDoctrine()->getEntityManager();
         $ano_escolar_activo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                      ->findBy(array(
                          'tipo'=>0,
                          'es_ano_escolar'=>1
                      ));
        $periodo_escolares=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
            'padre'=>$ano_escolar_activo[0]->getId(),
            'tipo'=>1//Periodos academicos
        )); 
        $xls_service =  $this->get('xls.service_xls5');
        // create the object see http://phpexcel.codeplex.com documentation
        $xls_service->getProperties()->setCreator("Maarten Balliauw")
                             ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");
        
             
        $alumnos=array();        
        $grados=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Grado")
                ->findByAll();
        $index_g_g=0;
        $styleReprobo = array(            
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => 'E61040')                
                )
        );        
$styleArea = array(            
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '00FFFF')                
                )
        );        
$styleFinalArea = array(            
            'font' => array(
                'bold' => true,
                'size'=>16,
                'color' => array('rgb' => '00FF00')                
                )
        );        
        foreach ($grados as $grado) {
            $grupos=$grado->getGrupo();
            foreach ($grupos as $grupo) {
                $alumnos=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")->findBy(array(
                'grupo'=>$grupo->getId()
                ));            
                    $index_numeros_alumnos=2;
                    foreach ($alumnos as $alumno) {
                        $xls_service->setActiveSheetIndex($index_g_g)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                                        ->setCellValueByColumnAndRow(0, $index_numeros_alumnos,"$alumno");   
                            //$notas=$alumno->getNota();
                            $grado_id=$alumno->getGrado()->getId();
                            $query="SELECT a FROM NetpublicCoreBundle:Asignatura a ";
                            $query.=" WHERE (a.grado=:grado_id";
                            $query.=" AND a.es_area=TRUE)";        
                             $areas=$em->createQuery($query)                
                                    ->setParameters(array(
                                            "grado_id"=>$grado_id                        
                                    ))->getResult(); 

                            $index=1;
                            $index_columna=2;
                            foreach($areas as $area){
                                   $query="SELECT a FROM NetpublicCoreBundle:Asignatura a ";
                                    $query.=" WHERE ";
                                    $query.=" a.area=:area_id";        
                                    $asg_areas=$em->createQuery($query)                
                                           ->setParameters(array(
                                            "area_id"=>$area->getId()                        
                                            ))->getResult(); 

                                $numeros_promedios=0;
                                $promedio_periodos_escolares=0;                              
                            foreach ($periodo_escolares as $p_e) {
                                  //Calculas para las asignaturas de la ereas
                                 foreach ($asg_areas as $a_a) {                                                                           
                                        $query="SELECT a_d,d FROM NetpublicCoreBundle:AlumnoDimension a_d JOIN a_d.dimension d";
                                        $query.=" WHERE (d.id=:periodo_id";
                                        $query.=" AND a_d.asignatura=:asignatura_id";
                                        $query.=" AND a_d.alumno=:alumno_id";
                                        $query.=" AND d.tipo=1)";                          
                                        $notas=$em->createQuery($query)                
                                            ->setParameters(array(
                                                "periodo_id"=>$p_e->getId(),
                                                "asignatura_id"=>$a_a->getId(),
                                                "alumno_id"=>$alumno->getId()                                     
                                        ))->getResult(); 
                                    if($index_numeros_alumnos==2)
                                    $xls_service->setActiveSheetIndex($index_g_g)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                                        ->setCellValueByColumnAndRow($index_columna,1, "$p_e-$a_a");   
                                        
                                        foreach ($notas as $n) {
                            $xls_service->setActiveSheetIndex($index_g_g)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                                        ->setCellValueByColumnAndRow($index_columna,$index_numeros_alumnos, "$n");
                                        $index_columna++;     
                            
                                        }                           
                        
                                    }
                                           //Areas
                                        
                                   $query="SELECT a_d FROM NetpublicCoreBundle:AlumnoDimension a_d JOIN a_d.dimension d";
                                    $query.=" WHERE (d.padre=:periodo_id";
                                    $query.=" AND a_d.asignatura=:asignatura_id";
                                    $query.=" AND a_d.alumno=:alumno_id";
                                    $query.=" AND d.tipo=2)";                          
                                    $notas=$em->createQuery($query)                
                                    ->setParameters(array(
                                            "periodo_id"=>$p_e->getId(),
                                            "asignatura_id"=>$area->getId(),
                                            "alumno_id"=>$alumno->getId()                                     
                                    ))->getResult(); 
                                    if($index_numeros_alumnos==2){
                                    $xls_service->setActiveSheetIndex($index_g_g)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                                        ->setCellValueByColumnAndRow($index_columna,1, "$p_e-$area");   
                                    $xls_service->getActiveSheet()
                                                   ->getStyleByColumnAndRow($index_columna,1)
                                                    ->applyFromArray($styleArea);


                                    }
                                    foreach($notas as $nota_){
                                         $nota_tem=$nota_->getNota();
                                         $xls_service->setActiveSheetIndex($index_g_g)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                                        ->setCellValueByColumnAndRow($index_columna,$index_numeros_alumnos, "mm$nota_tem");
                                         $xls_service->getActiveSheet()
                                                   ->getStyleByColumnAndRow($index_columna,$index_numeros_alumnos)
                                                    ->applyFromArray($styleArea);

                                           

                                            $index++;           
                                            $numeros_promedios++;         
                                            $promedio_periodos_escolares+=$nota_tem;
                                            $index_columna++;     
                                        // }
                                        }     

                                
                                   
                                    //$index_columna++;     
                            }
                      if($index_numeros_alumnos==2)
                               $xls_service->setActiveSheetIndex($index_g_g)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                                    ->setCellValueByColumnAndRow($index_columna,1, "Nota Final");   

                            
                        if ($numeros_promedios>0)                                                                            
                        $promedio_periodos_escolares=  number_format($promedio_periodos_escolares/$numeros_promedios,1); 
                            $xls_service->setActiveSheetIndex($index_g_g)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                                  ->setCellValueByColumnAndRow($index_columna,$index_numeros_alumnos, $promedio_periodos_escolares); 
                            $xls_service->getActiveSheet()
                                                   ->getStyleByColumnAndRow($index_columna,$index_numeros_alumnos)
                                                    ->applyFromArray($styleFinalArea);


                             $index_columna++;       
        }  


         if($alumno->getSituacionAcademicaAnoAnterior()==0){
             $estado="MATRICULADO";
         }
         if($alumno->getSituacionAcademicaAnoAnterior()==1){
             $estado="APROBO";
         }
         if($alumno->getSituacionAcademicaAnoAnterior()==2){             
             $estado="REPROBO";
             for ($index1 = $index_columna; $index1 >1; $index1--) {
                     $xls_service->getActiveSheet()
                                 ->getStyleByColumnAndRow($index1,$index_numeros_alumnos)
                                 ->applyFromArray($styleReprobo);
             }
         }
         if($alumno->getSituacionAcademicaAnoAnterior()==8){
             $estado="NO CULMINO LOS ESTUDIOS";
         }     
         $xls_service->setActiveSheetIndex($index_g_g)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                          ->setCellValueByColumnAndRow($index_columna,$index_numeros_alumnos,$estado); 
        if($alumno->getEsHabilitacion()==1){
             $estado="HABILITO";
         }
         if($alumno->getEsHabilitacion()==0){
             $estado="        ";
         }     
         if($alumno->getEsHabilitacion()==2){
             $estado="        ";
         }     
         $index_columna++;
         $xls_service->setActiveSheetIndex($index_g_g)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                          ->setCellValueByColumnAndRow($index_columna,$index_numeros_alumnos,$estado); 
         $index_numeros_alumnos++;   
        }
 $index_g_g++;   
$xls_service->getActiveSheet()->setTitle("$grupo"); 
$xls_service->createSheet();  
$xls_service->setActiveSheetIndex($index_g_g);


    }

}
       $xls_service->setActiveSheetIndex(0);
        //create the response
        $response = $xls_service->getResponse();
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=libroFinal.xls');        
        return $response;       
        
        
        
        
        
        
        
        
        
    }
    /**
     * Finds and displays a Alumno entity.
     * 
     * @Route("/{alumno_id}/{grupo_siguiente_id}/promover",name="alumno_promover")
     * @Template()
     * 
     */
    public function promoverAction($alumno_id,$grupo_siguiente_id){
        $resultado="No se pudo determinar";
        $em=  $this->getDoctrine()->getManager();
        $session=  $this->getRequest()->getSession();
        $ano_escolar=$em->getRepository("NetpublicCoreBundle:Dimension")
                        ->findAnoEscolarActivo();
        $periodo_escolares=$em->getRepository("NetpublicCoreBundle:Dimension")
                              ->findPeriodosEscolar($ano_escolar);
        
        $colegio=  $em->getRepository("NetpublicCoreBundle:Colegio")
                        ->findSedePrincipal();
        $nota_minima=$colegio->getNotaMinima();
        $colegio->setAnoAnterior($ano_escolar);
        $em->persist($colegio);
        $alumno=$em->getRepository("NetpublicCoreBundle:Alumno")->find($alumno_id);
        
        $grado_id=$alumno->getGrado()->getId();
        $areas=$em->getRepository("NetpublicCoreBundle:Asignatura")->findAreas($grado_id);
        $nro_areas=$em->getRepository("NetpublicCoreBundle:Alumno")
                      ->getAreasPerdidas($alumno_id,$periodo_escolares,$nota_minima,$areas);
        
        $condiciones_habilitar=$em->getRepository("NetpublicCoreBundle:CriterioPromocion")
                                  ->findCriteriosHabilitar();
        $condiciones_perder=$em->getRepository("NetpublicCoreBundle:CriterioPromocion")
                                  ->findCriteriosPerder();
        //Si el alumno recupero, tenemos que borrar notas de recuperacion.
        $recuperaciones_viejas= $em->createQuery("SELECT a FROM NetpublicCoreBundle:NotaRecuperacion a JOIN a.nota n WHERE a.ano_escolar=:ano AND n.alumno=:alumno ")
                            ->setParameter('ano',$ano_escolar->getId())
                            ->setParameter('alumno',$alumno_id)
                            ->getResult();
                    foreach ($recuperaciones_viejas as $r) {
                        $em->remove($r);
                    }
                    $em->flush();
        //Resolvemos Protocolos de la criterios
          $grupo_siguiente=$em->getRepository("NetpublicCoreBundle:Grupo")->find($grupo_siguiente_id);
          $alumno->setGrupoPromovido($grupo_siguiente);
        if($nro_areas==0){
            $resultado="Gano Año escolar";
            $alumno->setSituacionAcademicaAnoAnterior(1);
            $alumno->setEsHabilitacion(0);
            $alumno->setRepitente(0);
           
            
        }
        else{
        //Para habilitar
            if($condiciones_habilitar){
                $simbolo_habilitar=$condiciones_habilitar->getSimbolo();
                $valor_habilito=$condiciones_habilitar->getValor();
                if ($simbolo_habilitar=='>=') {
                    if($nro_areas>=$valor_habilito){
                        $alumno->setSituacionAcademicaAnoAnterior(0);
                        $alumno->setEsHabilitacion(1);
                        $periodo_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodoEscolarActivo();
                        $ultimo_periodo=$session->get('perido',$periodo_escolar_activo->getId());
                        $asg_perdidas=$em->getRepository("NetpublicCoreBundle:Alumno")->findAsgPerdidas(
                        $alumno_id,$periodo_escolares,$nota_minima,$areas);
                        $resultado="recupero ";
                        foreach ($asg_perdidas as $asg) {
                            $nota_ultimo_periodo=  $em->getRepository("NetpublicCoreBundle:AlumnoDimension")->findOneBy(array(
                            'alumno'=>$alumno_id,
                            'asignatura'=>$asg['asg']->getId(),
                            'dimension'=>$ultimo_periodo,

                            ));
                            $recuperacion=new \Netpublic\CoreBundle\Entity\NotaRecuperacion();
                            $recuperacion->setAnoEscolar($ano_escolar);
                            $recuperacion->setNota($nota_ultimo_periodo);
                            $recuperacion->setNotaRecuperacion(0.0);
                            $recuperacion->setObservacion("Por escribe las aqui las actividades realizadas para la recuperación del estudiante");
                            $em->persist($recuperacion);
                        }
                    }
                }
            if ($simbolo_habilitar=='>') {
                if($nro_areas>$valor_habilito){
                     $alumno->setEsHabilitacion(1);
                     $alumno->setSituacionAcademicaAnoAnterior(0);
                     $periodo_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodoEscolarActivo();
                     $ultimo_periodo=$session->get('perido',$periodo_escolar_activo->getId());
                     $asg_perdidas=$em->getRepository("NetpublicCoreBundle:Alumno")->findAsgPerdidas(
                                $alumno_id,$periodo_escolares,$nota_minima,$areas);
                     $resultado="recupero ";
                     foreach ($asg_perdidas as $asg) {
                            $nota_ultimo_periodo=  $em->getRepository("NetpublicCoreBundle:AlumnoDimension")->findOneBy(array(
                            'alumno'=>$alumno_id,
                            'asignatura'=>$asg['asg']->getId(),
                            'dimension'=>$ultimo_periodo,

                            ));
                            $recuperacion=new \Netpublic\CoreBundle\Entity\NotaRecuperacion();
                            $recuperacion->setAnoEscolar($ano_escolar);
                            $recuperacion->setNota($nota_ultimo_periodo);
                            $recuperacion->setNotaRecuperacion(0.0);
                            $recuperacion->setObservacion("Por escribe las aqui las actividades realizadas para la recuperación del estudiante");
                            $em->persist($recuperacion);
                     }
                }
           }
        if ($simbolo_habilitar=='<') {
            if($nro_areas<$valor_habilito){
                $alumno->setEsHabilitacion(1);
                $alumno->setSituacionAcademicaAnoAnterior(0);
                $periodo_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodoEscolarActivo();
                $ultimo_periodo=$session->get('perido',$periodo_escolar_activo->getId());
                $asg_perdidas=$em->getRepository("NetpublicCoreBundle:Alumno")->findAsgPerdidas(
                        $alumno_id,$periodo_escolares,$nota_minima,$areas);
                $resultado="recupero ";
                foreach ($asg_perdidas as $asg) {
                    $nota_ultimo_periodo=  $em->getRepository("NetpublicCoreBundle:AlumnoDimension")->findOneBy(array(
                    'alumno'=>$alumno_id,
                    'asignatura'=>$asg['asg']->getId(),
                    'dimension'=>$ultimo_periodo,
                        
                    ));
                    $recuperacion=new \Netpublic\CoreBundle\Entity\NotaRecuperacion();
                    $recuperacion->setAnoEscolar($ano_escolar);
                    $recuperacion->setNota($nota_ultimo_periodo);
                    $recuperacion->setNotaRecuperacion(0.0);
                    $recuperacion->setObservacion("Por escribe las aqui las actividades realizadas para la recuperación del estudiante");
                    $em->persist($recuperacion);
                    //echo $nota_p->getAsignatura().':'.$nota_p."--";
                }   
            }
        }
        if ($simbolo_habilitar=='<=') {
            if($nro_areas<=$valor_habilito){
                $alumno->setEsHabilitacion(1);
                $alumno->setSituacionAcademicaAnoAnterior(0);
                $periodo_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodoEscolarActivo();
                $ultimo_periodo=$session->get('perido',$periodo_escolar_activo->getId());
                $asg_perdidas=$em->getRepository("NetpublicCoreBundle:Alumno")->findAsgPerdidas(
                        $alumno_id,$periodo_escolares,$nota_minima,$areas);
                $resultado="recupero ";
                foreach ($asg_perdidas as $asg) {
                    $nota_ultimo_periodo=  $em->getRepository("NetpublicCoreBundle:AlumnoDimension")->findOneBy(array(
                    'alumno'=>$alumno_id,
                    'asignatura'=>$asg['asg']->getId(),
                    'dimension'=>$ultimo_periodo,
                        
                    ));
                    $recuperacion=new \Netpublic\CoreBundle\Entity\NotaRecuperacion();
                    $recuperacion->setAnoEscolar($ano_escolar);
                    $recuperacion->setNota($nota_ultimo_periodo);
                    $recuperacion->setNotaRecuperacion(0.0);
                    $recuperacion->setObservacion("Por escribe las aqui las actividades realizadas para la recuperación del estudiante");
                    $em->persist($recuperacion);
                    //echo $nota_p->getAsignatura().':'.$nota_p."--";
                }
             }
        }   
        if ($simbolo_habilitar=='=') {
            if($nro_areas==$valor_habilito){
                $alumno->setEsHabilitacion(1);
                $alumno->setSituacionAcademicaAnoAnterior(0);
                $periodo_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodoEscolarActivo();
                $ultimo_periodo=$session->get('perido',$periodo_escolar_activo->getId());
                $asg_perdidas=$em->getRepository("NetpublicCoreBundle:Alumno")->findAsgPerdidas(
                        $alumno_id,$periodo_escolares,$nota_minima,$areas);
                $resultado="recupero";
                foreach ($asg_perdidas as $asg) {
                    $nota_ultimo_periodo=  $em->getRepository("NetpublicCoreBundle:AlumnoDimension")->findOneBy(array(
                    'alumno'=>$alumno_id,
                    'asignatura'=>$asg['asg']->getId(),
                    'dimension'=>$ultimo_periodo,
                        
                    ));
                    $recuperacion=new \Netpublic\CoreBundle\Entity\NotaRecuperacion();
                    $recuperacion->setAnoEscolar($ano_escolar);
                    $recuperacion->setNota($nota_ultimo_periodo);
                    $recuperacion->setNotaRecuperacion(0.0);
                    $recuperacion->setObservacion("Por escribe las aqui las actividades realizadas para la recuperación del estudiante");
                    $em->persist($recuperacion);
                    //echo $nota_p->getAsignatura().':'.$nota_p."--";
                }      

            }
        }
        }
// Perder
      if($condiciones_perder){
        $simbolo_perder=$condiciones_perder->getSimbolo();
        $valor_perder=$condiciones_perder->getValor();
        if ($simbolo_perder=='>=') {
            if($nro_areas>=$valor_perder){
                $resultado=" perdio año";
                $alumno->setRepitente(1);
                $alumno->setSituacionAcademicaAnoAnterior(2);
                $alumno->setEsHabilitacion(0);
            }
        }
        if ($simbolo_perder=='>') {
            if($nro_areas>$valor_perder){
                $alumno->setRepitente(1);
                 $alumno->setSituacionAcademicaAnoAnterior(2);
                 $alumno->setEsHabilitacion(0);
            }
        }
        if ($simbolo_perder=='<') {
            if($nro_areas<$valor_perder){
                $alumno->setRepitente(1);                
                 $alumno->setSituacionAcademicaAnoAnterior(2);
                 $alumno->setEsHabilitacion(0);
            }
        }
        if ($simbolo_perder=='<=') {
            if($nro_areas<=$valor_perder){
                $alumno->setRepitente(1);
                 $alumno->setSituacionAcademicaAnoAnterior(2);
                $alumno->setEsHabilitacion(0);
            }
        }
        if ($simbolo_perder=='=') {
            if($nro_areas==$valor_perder){
                $alumno->setRepitente(1);
                $alumno->setSituacionAcademicaAnoAnterior(2);
               $alumno->setEsHabilitacion(0);
            }
        }
   
        }
            }
   $em->persist($alumno);
   $ano_escolar_promover=$em->getRepository("NetpublicCoreBundle:Dimension")->find(15320);
   $matriculas=$this->getDoctrine()->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findOneBy(array(
                     'ano'=>$ano_escolar_promover->getId(),
                     'alumno'=>$alumno_id
                 ));
        if($matriculas){
            $matriculas->setEsMatricula(TRUE); 
            //$matriculas->setGrupo($grupo_siguiente);            
            
        }
        else{
            $matriculas=new MatriculaAlumno();            
            $matriculas->setAlumno($alumno);
            $matriculas->setAno($ano_escolar_promover);
            //$matriculas->setGrupo($grupo_siguiente);
            $matriculas->setEsMatricula(TRUE);
            $matriculas->setEsPagoMatricula(TRUE);
            $matriculas->setEsPapeles(TRUE);
            $matriculas->setObservaciones("  ");
            $em->persist($matriculas);
        }
   $em->flush();
   return new \Symfony\Component\HttpFoundation\Response(strtolower($alumno)." $nro_areas  $resultado");
}
       
     /**
     * Finds and displays a Alumno entity.
     * 
     * @Route("/{alumno_id}/{ano_matricula_id}/matricularpromovido",name="alumno_matricularpromovidos")
     * @Template()
     * 
     */
    public function matricularpromovidosAction($alumno_id,$ano_matricula_id)    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $re="No se realizo ninguna operación.";
        $em=$this->getDoctrine()->getEntityManager();
        $colegio=$em->getRepository("NetpublicCoreBundle:Colegio")->findSedePrincipal();
        $nota_minima=$colegio->getNotaMinima();
        $ano_escolar=$em->getRepository("NetpublicCoreBundle:Dimension")->find($ano_matricula_id);
        $colegio->setAnoSiguiente($ano_escolar);
        $ano_anterior=$colegio->getAnoAnterior();
        $em->persist($colegio);
        $alumno=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")->find($alumno_id);
        $periodos_academicos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findPeriodosEscolar($ano_escolar);;                
        $matricula=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findMatricula($ano_matricula_id,$alumno_id) ;
        //Verificamos que el Nuevo aalumno se pueda matricular
        if($matricula){
            $re="ya esta matriculado ";
            
        }
        else{
            $mi_matricula=new MatriculaAlumno();
            $mi_matricula->setAlumno($alumno);
            $mi_matricula->setAno($ano_escolar);
            $mi_matricula->setEsMatricula(TRUE);
            $mi_matricula->setEsPagoMatricula(TRUE);
            $mi_matricula->setObservaciones("generado en promover");
            $em->persist($mi_matricula);
            $this->getDoctrine()->getRepository("NetpublicCoreBundle:MatriculaAlumno")        
                                ->setUltimAnoMatricula($ano_matricula_id,$alumno_id);
            $grupo=$alumno->getGrupoPromovido();
            if($alumno->getSituacionAcademicaAnoAnterior()==1){//Gano el año el pelao
                $segui=new \Netpublic\CoreBundle\Entity\Anoescolargrado();
                $segui->setAlumno($alumno);
                $segui->setAnoescolar($ano_escolar);
                $segui->setGrado($grupo->getGrado());
                $segui->setGrupo($grupo);
                $em->persist($segui);
                //Establecemos grupo
                $em->getRepository("NetpublicCoreBundle:Alumno")->asignarGrupo(
                                        $alumno,
                                        $grupo->getId(),
                                        $periodos_academicos,
                                        $ano_escolar->getId()
                );
                $alumno->setGrado($grupo->getGrado());
                $em->persist($alumno);
                $re="Matriculado Correctamente!! ";
            }
                
            if($alumno->getSituacionAcademicaAnoAnterior()==2){//perdio el año escolar
                $segui=new \Netpublic\CoreBundle\Entity\Anoescolargrado();
                $segui->setAlumno($alumno);
                $segui->setAnoescolar($ano_escolar);
                $segui->setGrado($alumno->getGrado());
                $segui->setGrupo($alumno->getGrupo());
                $em->persist($segui);
                //Establecemos grupo
                $em->getRepository("NetpublicCoreBundle:Alumno")->asignarGrupo(
                                        $alumno,
                                        $alumno->getGrupo()->getId(),
                                        $periodos_academicos,
                                        $ano_escolar->getId()
                );
                $em->persist($alumno);
                $re="Matriculado Correctamente, en el mismo curso!! ";
            }
            //Si recupera el año escolar
             if($alumno->getEsHabilitacion()==1 && $alumno->getSituacionAcademicaAnoAnterior()!=1 && $alumno->getSituacionAcademicaAnoAnterior()!=2){//Gano el año el pelao
                $notas_recuperacion=$em->getRepository("NetpublicCoreBundle:NotaRecuperacion")->findRecuperacionesAlumno($ano_anterior->getId(),$alumno_id);
                $nro_recuperaciones_perdidas=0;
                foreach ($notas_recuperacion as $n_r) {
                    if($n_r->getNotaRecuperacion()<=$nota_minima){
                        $nro_recuperaciones_perdidas++;
                    }
                }
                    
                if($nro_recuperaciones_perdidas==0){
                    $re="Gano recuperación. Matriculado Exitosamente en $grupo ";
                        //Establecemos grupo
                        $segui=new \Netpublic\CoreBundle\Entity\Anoescolargrado();
                        $segui->setAlumno($alumno);
                        $segui->setAnoescolar($ano_escolar);
                        $segui->setGrado($grupo->getGrado());
                        $segui->setGrupo($grupo);
                        $em->persist($segui);                

                    $em->getRepository("NetpublicCoreBundle:Alumno")->asignarGrupo(
                                        $alumno,
                                        $grupo->getId(),
                                        $periodos_academicos,
                                        $ano_escolar->getId()
                );
                }
                else{//Perdio recuperacion
                  $re="Perdio recuperación. Matriculado Exitosamente en {$alumno->getGrupo()} ";
                                //Establecemos grupo
                          $segui=new \Netpublic\CoreBundle\Entity\Anoescolargrado();
                          $segui->setAlumno($alumno);
                          $segui->setAnoescolar($ano_escolar);
                          $segui->setGrado($alumno->getGrupo()->getGrado());
                          $segui->setGrupo($alumno->getGrupo());
                          $em->persist($segui);                

                  $em->getRepository("NetpublicCoreBundle:Alumno")->asignarGrupo(
                                        $alumno,
                                        $alumno->getGrupo()->getId(),
                                        $periodos_academicos,
                                        $ano_escolar->getId()
                );  
                }
                
                $alumno->setGrado($grupo->getGrado());
                $em->persist($alumno);
                
            }
        }
        $em->flush();
        return new Response($alumno." ".$re);
       
    }       
    /**
     * Finds and displays a Alumno entity.
     * 
     * @Route("/imprimircarnetsesion",name="alumno_imprimircarnetsesion")
     * @Template()
     * 
     */
    public function imprimircarnetsesionAction()    {          
        $session=$this->get('request')->getSession();       
        $alumnos_id=json_decode($this->get('request')->get('alumnos'));
        $session->set('alumnos_id',$alumnos_id);
         return new \Symfony\Component\HttpFoundation\Response('ok');
        
    }    
    /**
     * Finds and displays a Alumno entity.
     * 
     * @Route("/{tipo}/newhtmlpdfxls",name="alumno_newhtmlpdfxls")
     * @Template()
     * 
     */
    public function newhtmlpdfxlsAction($tipo)
    {
        $perido_id= -1;
        $profesor_id= -1;
        $asignatura_id= -1;
        $ano_escolar=-1;
        $grupo=-1;
        $request=  $this->getRequest();
        if($tipo==2){
            $perido_id= $request->get('periodo_escolar');
            $profesor_id= $request->get('profesor_filtro');
            $asignatura_id= $request->get('asignatura_filtro');
            
        }
        if($tipo==3){
            $perido_id= $request->get('periodo_escolar');
            $profesor_id= $request->get('profesor_filtro');
            $asignatura_id= $request->get('asignatura_filtro');
            
        }
        if($tipo==4){//Boletines
            $perido_id= $request->get('periodo_escolar');                        
        }
        if($tipo==7){//Mejores puntajes
            if($request->get('periodo_escolar')!='*')
                $perido_id= $request->get('periodo_escolar'); 
            if($request->get('ano_escolar')!='*')
                $ano_escolar= $request->get('ano_escolar');
        }
        if($tipo==10){//certificado de matricula
            $ano_escolar= $request->get('ano_escolar_id');
            $grupo=$request->get('grupo_id');
            
            
        }
        if($tipo==11){//certificado de matricula
            $ano_escolar= $request->get('ano_escolar_id');
            $grupo=$request->get('grupo_id');
            
            
        }        
        if($tipo==12){//certificado de matricula
            $ano_escolar= $request->get('ano_escolar_id');
        }        
        if($tipo==14){//certificado de matricula
            $grupo= $request->get('grupo_id');
        }        
        if($tipo==15){//certificado de matricula
            $grupo= $request->get('fecha_inicio');
            $ano_escolar=$request->get('fecha_final');
        }        

        return array(
            'tipo'=>$tipo,
            'perido_id'=>$perido_id,
            'profesor_id'=>$profesor_id,
            'asigatura_id'=>$asignatura_id,
            'ano_escolar'=>$ano_escolar,
            'grupo'=>$grupo
        );
        
    }    
    /**
     * Finds and displays a Alumno entity.
     * 
     * @Route("/{id_area}/{id_grupo}/temporal",name="alumno_temporal")
     * @Template()
     * 
     */
    public function temporalAction($id_area,$id_grupo)
    {
        $em = $this->getDoctrine()->getEntityManager();    
            
           $asg=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Asignatura")
                                                ->find($id_area);                
                    
           $alumnos=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")
                                                ->findBy(array(
                                                    "grupo"=>$id_grupo
                                                ));                
                         
  
           $peridos_academicos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                                                ->findBy(array(
                                                    "padre"=>2,
                                                    "tipo"=>1
                                                ));                
           foreach ($alumnos as $alumno) {
                                            
                        
           foreach ($peridos_academicos as $p_a) {
                  $areas_peridos_academicos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                                          ->findBy(array(
                                          "padre"=>$p_a->getId(),
                                          "tipo"=>2
                                        ));
                    foreach ($areas_peridos_academicos as $areas_p_a) {
                                               
                           $a_d=new AlumnoDimension();
                           $a_d->setAlumno($alumno);
                           $a_d->setAsignatura($asg);                    
                           $a_d->setDimension($areas_p_a);                                        
                           $a_d->setNota(-1);
                           $a_d->setNotaBuffered(-1);
                           $em->persist($a_d);   
                     }
            }
            }
            $em->flush();
            return new Response("2");
    }
    

    
    
    
    
    
    
    
    
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    private function registrarEstudiante(Alumno $alumno,  Dimension $ano_escolar_activo){
        $em=  $this->getDoctrine()->getEntityManager();
       $query = $em->createQuery('SELECT count(a) FROM NetpublicCoreBundle:Usuario a WHERE a.username LIKE :cedula')
                        ->setParameters(array(
                           "cedula"=>'%'.$alumno->getNombre().'%'                                                    
                                )
                );
       $count = $query->getSingleScalarResult();
       $nombre=$alumno->getNombre();
       if($count>0){
	     $nombre=$nombre.$count;
       }
      //Generamos claves temporalares a los alumno registrados como nuevo
      $usuario=new Usuario();             
      $usuario->setUsername($nombre);
      $usuario->setSalt(md5(time()));
      $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
      $password = $encoder->encodePassword($alumno->getCedula(), $usuario->getSalt());
      $usuario->setPassword($password);
      $usuario->setEsAlumno(TRUE); 
      $usuario->setAlumno($alumno);
      $alumno->setUsuario($usuario);
      $rol=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Rol")->findOneBy(array("role"=>"ROLE_ESTUDIANTE"));
      $usuario->addRol($rol); 
      $em->persist($usuario);
      
      return $usuario;    
        
    }
    private function matricularEstudiante(Alumno $alumno, Grupo $grupo,$peridos_academicos){
           $em=  $this->getDoctrine()->getEntityManager();           
           $alumno->setGrupo($grupo);
           $alumno->setEsNuevo(TRUE);
           $asignaturas= $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Asignatura")
                               ->findBy(array(
                                   "grado"=>$alumno->getGrado()->getId()
                               ));
           foreach ($asignaturas as $asg) {
                 //areas
              if($asg->getEsArea()){
                  foreach ($peridos_academicos as $p_a) {
                       $this->setNotasAreas($p_a, $asg, $alumno);
                  }
              }
              if($asg->getEsArea()==FALSE){
                 foreach ($peridos_academicos as $p_a) {
                    $a_d=new AlumnoDimension();
                    $a_d->setAlumno($alumno);
                    $a_d->setAsignatura($asg);                    
                    $a_d->setDimension($p_a);                                        
                    $a_d->setNota(-1);
                    $a_d->setNotaBuffered(-1);
                    $em->persist($a_d);
                    $this->setAsistencias($asg, $p_a, $alumno);                  
                  $this->setActividadesPeriodo($asg, $p_a, $grupo->getId(),$alumno);
                      
                 }
             }
           }                                                                                                         
    }
    

    
    
    
    
    
    
    
    private function setNotasAreas(Dimension $p_a,  \Netpublic\CoreBundle\Entity\Asignatura $asg,  Alumno $alumno){
        $em=  $this->getDoctrine()->getEntityManager();
       $areas_peridos_academicos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                          ->findBy(array(
                            "padre"=>$p_a->getId(),
                            "tipo"=>2
       ));
       foreach ($areas_peridos_academicos as $areas_p_a) {                                              
             $a_d=new AlumnoDimension();
             $a_d->setAlumno($alumno);
             $a_d->setAsignatura($asg);                    
             $a_d->setDimension($areas_p_a);                                        
             $a_d->setNota(-1);
             $a_d->setNotaBuffered(-1);
             $em->persist($a_d);   
      }

    }


















    private function setAsistencias(\Netpublic\CoreBundle\Entity\Asignatura $asg,Dimension $p_a, Alumno $alumno){
        $em=  $this->getDoctrine()->getEntityManager();
     //ASistencia de los periodos
     $asistencia_peridos_academicos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
               ->findBy(array(
               "padre"=>$p_a->getId(),
               "tipo"=>3
     ));
     foreach ($asistencia_peridos_academicos as $a_p_a) {
         $a_d=new AlumnoDimension();
         $a_d->setAlumno($alumno);
         $a_d->setAsignatura($asg);                    
         $a_d->setDimension($a_p_a);                                        
         $a_d->setNota(-1);
         $em->persist($a_d);      
     }        
     
}






































    private function setActividadesPeriodo(\Netpublic\CoreBundle\Entity\Asignatura $asg, Dimension $p_a,$grupo_id,  Alumno $alumno){
        $em=  $this->getDoctrine()->getEntityManager();
          //Actividades de Periodo
         $actividades_peridos_academicos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                ->findBy(array(
                 "padre"=>$p_a->getId(),
                 "tipo"=>4,
                 "asignatura"=>$asg->getId()
                  ));
         foreach ($actividades_peridos_academicos as $a_p_a) {
              foreach ($a_p_a->getGrupo() as $g) {
                   if($g->getId()==$grupo_id){
                        $a_d=new AlumnoDimension();
                        $a_d->setAlumno($alumno);
                        $a_d->setAsignatura($asg);                    
                        $a_d->setDimension($a_p_a);                                        
                        $a_d->setNota(-1);
                        $a_d->setNotaBuffered(-1);
                        $em->persist($a_d);      
                    }   
                                    
               }  
                                                                                                                               
         }                                
    }
    
        
  

    private function generarNotasPadre(Dimension $hijo,  Alumno $alumno){
        $asignatura=$hijo->getAsignatura();
        $em=$this->getDoctrine()->getEntityManager();
        do{
            $padre=$hijo->getPadre();
            $nota=new AlumnoDimension();
            $nota->setAlumno($alumno);
            $nota->setAsignatura($asignatura);
            $nota->setDimension($padre);
            $nota->setNota(-1);
            $nota->setNotaBuffered(-1);
            $em->persist($nota);
            $hijo=$padre;            
        }while (!$padre->getEsAnoEscolar());
            
        
        
    }
}
