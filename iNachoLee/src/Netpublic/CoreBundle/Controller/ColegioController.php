<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\Colegio;
use Netpublic\CoreBundle\Form\ColegioType;
use Netpublic\CoreBundle\Entity\Alumno;
use Netpublic\CoreBundle\Entity\CriterioPromocion;
use Netpublic\CoreBundle\Util\Util;

/**
 * Colegio controller.
 *
 * @Route("/colegio")
 */
class ColegioController extends Controller
{
     /**
     * Lists all Colegio entities.
     *
     * @Route("/actualizarinl", name="colegio_actualizarinl")
     * @Template()
     */
    public function actualizarinlAction()
    {
        $url="/home/vhost/host1/iNachoLee/iNachoLee/app/console ";
        $url_git="/home/vhost/host1/iNachoLee/";
        //Bajamos via git la ultima actualizacion
        echo exec("git -C /home/vhost/host1/iNachoLee pull https://github.com/iNachoLeeColombia/iNachoLee.git master  2>&1");
        //Generamos las entities
        //echo exec("$url generate:doctrine:entities NetpublicCoreBundle");
        //Actualizamos el modelo de datos.
        //echo exec("$url doctrine:schema:update --force");
        //Borramos cache
        //echo exec("$url cache:clear --env=prod");
        return new \Symfony\Component\HttpFoundation\Response(1);
    }

    
     /**
     * Lists all Colegio entities.
     *
     * @Route("/realizarbackup", name="colegio_realizarbackup")
     * @Template()
     */
    public function realizarbackupAction()
    {
        $user=$this->container->getParameter('database_user');
        $contrasena=$this->container->getParameter('database_password');
        $fecha = date("Y-m-j_h:i");
        $base_dato=$this->container->getParameter('database_name');
        $host=$this->getRequest()->getHost();
        echo exec("/usr/bin/mysqldump -u $user -p$contrasena $base_dato>/home/vhost/host1/iNachoLee/iNachoLee/web/$base_dato$fecha.sql 2>&1");
        $url="<a class='btn btn-info' href='http://$host/$base_dato$fecha.sql'> <i class='icon icon-check-sign'></i> Descargar</a>";
        return new \Symfony\Component\HttpFoundation\Response($url);
    }
    /**
     * Lists all Colegio entities.
     *
     * @Route("/actualizarversion", name="colegio_actualizarversion")
     * @Template()
     */
    public function actualizarversionAction()
    {
        $outPut = shell_exec("echo bermu4523 | sudo -S /usr/bin/ap-hotspot start 2>&1 ");
        echo "<pre>$outPut</pre>";
        
        //echo exec("/usr/bin/nmcli  --nocheck d disconnect iface wlan0 2>&1" );
        //echo exec("sudo /usr/bin/ap-hotspot stop 2>&1");
        //echo exec("sudo /usr/bin/ap-hotspot/ap-hotspot start 2>&1");
        
        return new \Symfony\Component\HttpFoundation\Response("ok");
        
    }

    /**
     * Lists all Colegio entities.
     *
     * @Route("/newilmovil", name="colegio_newilmovil")
     * @Template()
     */
    public function newilmovilAction()
    {
        $em=  $this->getDoctrine()->getManager();
        $sede_principal=$em->getRepository("NetpublicCoreBundle:Colegio")->findSedePrincipal();
        return array(
            'sede_principal'=>$sede_principal
        );
        
        
    }

    /**
     * Lists all Colegio entities.
     *
     * @Route("/losentimos", name="colegio_losentimos")
     * @Template()
     */
    public function losentimosAction()
    {
        $em=  $this->getDoctrine()->getManager();
        $sede_principal=$em->getRepository("NetpublicCoreBundle:Colegio")->findSedePrincipal();
        echo $em->getRepository("NetpublicCoreBundle:Colegio")->getNroAlumnosPerdidosSede(1,2.9,11361);
        return array(
            'sede_principal'=>$sede_principal
        );
        
        
    }
 
    /**
     * Lists all Colegio entities.
     *
     * @Route("/actualizarnombrecorto", name="colegio_actualizarnombrecorto")
     * @Template("NetpublicCoreBundle:Grupo:newgrupo.html.twig")
     */
    public function actualizarnombrecortoAction()
    {
        $request=  $this->getRequest();
        $em=  $this->getDoctrine()->getManager();
        $sede_id=$request->get('sede_id');
        $nombre_corto=$request->get('nombre_corto');
        $grado_id=$request->get('grado_id');
        $grado=$em->getRepository("NetpublicCoreBundle:Grado")->find($grado_id);
        $sede=$em->getRepository("NetpublicCoreBundle:Colegio")->find($sede_id);
        $sedes=$em->getRepository("NetpublicCoreBundle:Colegio")->findAll();
        //$sede=new Colegio();
        $sede->setNombreCorto($nombre_corto);
        $label_grado=$grado->getNombreGrupo();
        if($label_grado){
            $grado->setNombreGrupo($label_grado);
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
        
        $em->persist($sede);
        $em->flush();
        return array(
          "sedes"=>$sedes,
          'label_grado'=>$label_grado  
        );
    } 
    /**
     * Lists all Colegio entities.
     *
     * @Route("/anoperiodoactivo", name="colegio_anoperiodoactivo")
     * @Template()
     */
    public function anoperiodoactivoAction()
    {
        $em=  $this->getDoctrine()->getManager();
        $session=  $this->getRequest()->getSession();
        $periodo_activo=null;
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        $periodo_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodoEscolarActivo();
        if($ano_escolar_activo){
        $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
        $periodo_activo_s=$session->get("perido_id",$periodo_escolar_activo->getId());
        
        $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_activo_s);
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($ano_escolar_id_s);
        }
        
        return array(
            'ano_escolar_activo'=>$ano_escolar_activo,
            'periodo_escolar_activo'=>$periodo_activo
        );
        
        
    }
    /**
     * Lists all Colegio entities.
     *
     * @Route("/mostraralumnosgestormatricula", name="colegio_mostraralumnosgestormatricula")
     * @Template()
     */
    public function mostraralumnosgestormatriculaAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $sede=$request->get("sede_id",'*');    
        $grado=$request->get('grado_id','*');
        $grupo=$request->get('grupo_id','*');
        $repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:Alumno');        
        $query = $repository->createQueryBuilder('a');                     
        //$query=$query->join("u.alumno","a");
        if($grupo!='*'){
            $query = $query->andWhere("a.grupo=:grupo_id")        
                         ->setParameter('grupo_id',$grupo);
        }
        if($grado!='*'){
            $query = $query->andWhere("a.grado=:grado_id")        
                         ->setParameter('grado_id',$grado);
        }
        if($sede!='*'){
            $query = $query->andWhere("a.sede=:sede_id")        
                         ->setParameter('sede_id',$sede);
        }

        $query=$query->orderBy('a.apellido', 'ASC');
        $query=$query->setMaxResults(160);
        $query = $query->getQuery();      
        $alumnos= $query->getResult();
        $anos_escolares=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolares();
        $grados=$em->getRepository("NetpublicCoreBundle:Grado")->findAll();
        $grupos=$em->getRepository("NetpublicCoreBundle:Grupo")->findAll();
        
        /*foreach ($alumnos as $alumno) {
            foreach ($anos_escolares as $ano) {
                $matricula_ano=  $em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findBy(array(
                    'ano'=>$ano->getId(),
                    'alumno'=>$alumno->getId()
                ));
                if ($matricula_ano) {
                    ;
                }
                else{
                        $matricula=new \Netpublic\CoreBundle\Entity\MatriculaAlumno();
                        $matricula->setGrupo($alumno->getGrupo());
                        $matricula->setAlumno($alumno);
                        $matricula->setAno($ano);
                        $matricula->setEsMatricula(TRUE);
                        $matricula->setEsPagoMatricula(TRUE);
                        $matricula->setEsPapeles(TRUE);
                        $matricula->setEsMatricula(TRUE);
                        $matricula->setObservaciones("..");
                        $em->persist($matricula);            
                        

                }
                
            }
        }
        */
        $em->flush();
        return array(
            'alumnos'=>$alumnos,
            'anos_escolares'=>$anos_escolares,
            'grados'=>$grados,
            'grupos'=>$grupos
        );
        
    }

    
    /**
     * Lists all Colegio entities.
     *
     * @Route("/newgestormatricula", name="colegio_newgestormatricula")
     * @Template()
     */
    public function newgestormatriculaAction()
    {
        $em=  $this->getDoctrine()->getManager();
        $sedes=$em->getRepository("NetpublicCoreBundle:Colegio")->findAll();
        $grados=$em->getRepository("NetpublicCoreBundle:Grado")->findAll();
        $anos_escolares=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolares();
        
        return array(
          'sedes'=>$sedes,
          "grados"=>$grados,
          'anos_escolares'=>$anos_escolares,  
        );
    }

    /**
     * Lists all Colegio entities.
     *
     * @Route("/mostrarlabels", name="colegio_mostrarlabels")
     * @Template()
     */
    public function mostrarlabelsAction()
    {
        return array(
          'id'=>1  
        );
    }

    /**
     * Lists all Colegio entities.
     *
     * @Route("/updatetag", name="colegio_updatetag")
     * @Template()
     */
    public function updatetagAction()
    {
        $em=  $this->getDoctrine()->getManager();
        $request=  $this->getRequest();
        $label=$request->get('label');
        $referencia=$request->get('referencia_plantilla');
        $nueva_tag=$request->get('nueva_tag');
        $tag=$em->getRepository("NetpublicCoreBundle:TagPlantilla")->findOneBy(array(
           'referencia'=>$referencia,
           'label'=>$label 
       ));
        $tag->setTag($nueva_tag);
        $em->persist($tag);
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response($tag->getTag());
       
    }

    /**
     * Lists all Colegio entities.
     *
     * @Route("/{label}/{referencia}/gettag", name="colegio_gettag")
     * @Template()
     */
    public function gettagAction($label,$referencia)
    {
        $em=  $this->getDoctrine()->getManager();
        $tag=$em->getRepository("NetpublicCoreBundle:TagPlantilla")->findOneBy(array(
           'referencia'=>$referencia,
           'label'=>$label 
       ));
        return new \Symfony\Component\HttpFoundation\Response($tag->getTag());
       
    }
    /**
     * Lists all Colegio entities.
     *
     * @Route("/{referencia_plantilla}/getbodyestatico", name="colegio_getbodyestatico")
     * @Template()
     */
    public function getbodyestaticoAction($referencia_plantilla)
    {
       $em=  $this->getDoctrine()->getManager();
       $plantilla=$em->getRepository("NetpublicCoreBundle:Plantillabc3")->findOneBy(array(
            "referecnia"=>$referencia_plantilla
        ));
       return new \Symfony\Component\HttpFoundation\Response($plantilla->getContenidoEstatico());
        
         
    }
    
    /**
     * Lists all Colegio entities.
     *
     * @Route("/{referencia_plantilla}/uptatealltag", name="colegio_uptatealltag")
     * @Template()
     */
    public function uptatealltagAction($referencia_plantilla)
    {
       $em=  $this->getDoctrine()->getManager();
       $labels=$em->getRepository("NetpublicCoreBundle:TagPlantilla")->findBy(array(
            "referencia"=>$referencia_plantilla
        ));
       $labels_json=array();
        foreach ($labels as $label) {
            $labels_json[]=array(
                'id'=>$label->getLabel(),
                'tag'=>$label->getTag()
                    );
        }
        return new \Symfony\Component\HttpFoundation\JsonResponse($labels_json);
        
         
    }
    /**
     * Lists all Colegio entities.
     *
     * @Route("/{tipo_plantilla}/{referencia_plantilla}/actualizarcontenido", name="colegio_actualizarcontenido")
     * @Template()
     */
    public function actualizarcontenidoAction($tipo_plantilla,$referencia_plantilla)
    {
        $em=  $this->getDoctrine()->getManager();
        $request=  $this->getRequest();
        $plantilla=$em->getRepository("NetpublicCoreBundle:Plantillabc3")->findOneBy(array(
           'referecnia'=>$referencia_plantilla,
           'tipo'=>$tipo_plantilla 
        ));
        $a=str_replace("\\","",$request->get("contenido"));
        
        $a=str_replace("body_estatico_".$referencia_plantilla,$plantilla->getContenidoEstatico(),$a);
        $b = html_entity_decode($a);
        $plantilla->setContenido($b);
        $em->persist($plantilla);
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response("sssasa".$request->get("contenido"));
    }
    /**
     * Lists all Colegio entities.
     *
     * @Route("/guardarnotaminima", name="colegio_guardarnotaminima")
     * @Template()
     */
    public function guardarnotaminimaAction()
    {
        $em=  $this->getDoctrine()->getManager();
        $colegio=$em->getRepository("NetpublicCoreBundle:Colegio")->findSedePrincipal();
        $colegio->setNotaMinima($this->getRequest('nota_minima'));
        $em->persist($colegio);
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response("ok");
    }

     /**
     * Lists all Colegio entities.
     *
     * @Route("/newgestorgrupo", name="colegio_newgestorgrupo")
     * @Template()
     */
    public function newgestorgrupoAction()
    {
        $em=  $this->getDoctrine()->getManager();
        $session=  $this->getRequest()->getSession();
        $grados=$em->getRepository("NetpublicCoreBundle:Grado")->findAll();
        $anos_escolares=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolares();
        
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($ano_escolar_id_s);
        
        $ano_fuente=$session->get('ano_fuente',$ano_escolar_activo);
        $ano_destino=$session->get('ano_destino',$ano_escolar_activo);
        return array(
            "grados"=>$grados,
            'anos_escolares'=>$anos_escolares,
            'ano_escolar_activo'=>$ano_escolar_activo,
            'ano_fuente'=>$ano_fuente,
            'ano_destino'=>$ano_destino
        );
    }
     /**
     * Lists all Colegio entities.
     *
     * @Route("/informeboletines", name="colegio_informeboletines")
     * @Template()
     */
    public function informeboletinesAction()
    {
      
        return array(
            'plantilla_defecto'=>5
        );
        
    }
     /**
     * Lists all Colegio entities.
     *
     * @Route("/informepromover.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|json|pdf"} ,name="colegio_informepromover")
     * @Template()
     */
    public function informepromoverAction()
    {
        $request=  $this->getRequest();
        $em=  $this->getDoctrine()->getManager();
        $query="SELECT count(a) FROM NetpublicCoreBundle:Alumno a";
        $query.=" WHERE ( a!=0 ";
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
        $query.=" AND a.situacion_academica_ano_anterior=1" ;        
        
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
        $nro_estudiantes_ganaron_año=$usuarios->getSingleScalarResult();
        
        $query="SELECT count(a) FROM NetpublicCoreBundle:Alumno a";
        $query.=" WHERE ( a!=0 ";
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
        $query.=" AND a.situacion_academica_ano_anterior=2" ;        
        
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
        $nro_estudiantes_perdiron_año=$usuarios->getSingleScalarResult();
        $query="SELECT count(a) FROM NetpublicCoreBundle:Alumno a";
        $query.=" WHERE ( a!=0 ";
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
        $query.=" AND a.es_habilitacion=1" ;        
        
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
        $nro_alumnos_recuperan=$usuarios->getSingleScalarResult();
        
        $query="SELECT count(a) FROM NetpublicCoreBundle:Alumno a";
        $query.=" WHERE ( a!=0 ";
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
        
        $nro_total_alumnos=$usuarios->getSingleScalarResult();
        
        $sedes=$em->getRepository("NetpublicCoreBundle:Colegio")->findAll();
        $grados=$em->getRepository("NetpublicCoreBundle:Grado")->findAll();
        
        if($request->get('_format')=='json'){ 
            $re=array(
            'nro_alumnos_perdieron'=>$nro_estudiantes_perdiron_año,
            'nro_alumnos_ganaron'=>$nro_estudiantes_ganaron_año,
            'nro_alumnos_recuperan'=>$nro_alumnos_recuperan,
            'nro_total_alumnos'=>$nro_total_alumnos);
            return new \Symfony\Component\HttpFoundation\JsonResponse($re);
        }
        return array(
            'nro_alumnos_perdieron'=>$nro_estudiantes_perdiron_año,
            'nro_alumnos_ganaron'=>$nro_estudiantes_ganaron_año,
            'nro_alumnos_recuperan'=>$nro_alumnos_recuperan,
            'nro_total_alumnos'=>$nro_total_alumnos,
            'sedes'=>$sedes,
            'grados'=>$grados
        );
        
    }
     /**
     * Lists all Colegio entities.
     *
     * @Route("/newmatricularpromovidos", name="colegio_newmatricularpromovidos")
     * @Template()
     */
    public function newmatricularpromovidosAction()
    {
        $anos_escolares=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolares();
        return array(
            'anos_escolares'=>$anos_escolares,
            'plantilla_defecto'=>5
        );
        
    }
   
    /**
     * Lists all Colegio entities.
     *
     * @Route("/informeconsolidadoasgperdidasbuscar", name="colegio_informeconsolidadoasgperdidasbuscar")
     * @Template()
     */
    public function informeconsolidadoasgperdidasbuscarAction()
    {
        ini_set('memory_limit', '-1');    
        set_time_limit(0);      
        $request=  $this->getRequest();
        $em=  $this->getDoctrine()->getEntityManager();
        $sede=$request->get("sede",'*');    
        $grado_id=$request->get('grado','*');
        $grupo=$request->get('grupo','*');
        $repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:Grado');        
        $query = $repository->createQueryBuilder('g');                     
        //$query=$query->join("u.alumno","a");
        if($grado_id!='*'){
            $query = $query->andWhere("g.id=:grado_id")        
                         ->setParameter('grado_id',$grado_id);
            
        
        }
        $query=$query->orderBy('g.id', 'ASC');     
        $query = $query->getQuery();      
        $grados= $query->getResult();
        $contador_asg_no_perdidas=0;                     
        $contador_asg_perdidas_uno=0;
        $contador_asg_no_perdidas_dos=0;
        $contador_asg_no_perdidas_tres=0;
        $contador_asg_no_perdidas_cuatro=0;
        $contador_asg_no_perdidas_mayor_cuatro=0;
         $sede_principal=  $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Colegio")
                               ->findOneBy(array(
                                   'es_principal'=>true
                               )) ;         
        $nota_minima=$sede_principal->getNotaMinima();
        $periodo_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                                    ->findPeriodoEscolarActivo();
        if($grupo=='*'){
            $grupos=  $em->getRepository("NetpublicCoreBundle:Grupo")->findAll();
        }
        else{
            $grupos=$em->getRepository("NetpublicCoreBundle:Grupo")->findBy(array(
               "id" =>$grupo
            ));
        }
        $datos_asignaturas_perdidas=array();
        $mi_labels=array();
        foreach ($grupos as $grupo) { 
                $contador_asg_no_perdidas=0;                     
                $contador_asg_perdidas_uno=0;
                $contador_asg_no_perdidas_dos=0;
                $contador_asg_no_perdidas_tres=0;
                $contador_asg_no_perdidas_cuatro=0;
                $contador_asg_no_perdidas_mayor_cuatro=0;
                $alumnos=  $em->getRepository("NetpublicCoreBundle:Alumno")->findBy(array(
                    "grupo"=>$grupo->getId()
                ));
                $id_periodo_escolar=$periodo_escolar_activo->getId();
                foreach ($alumnos as $alumno) {            
                    $nro_asignatura_perdidas=$em->getRepository("NetpublicCoreBundle:Alumno")                    
                                    ->getNroAsignaturasPerdidas($alumno->getId(),$id_periodo_escolar,$nota_minima,$sede);            
                    if($nro_asignatura_perdidas==0){
                        $contador_asg_no_perdidas++;
                    }
                    elseif($nro_asignatura_perdidas==1){
                        $contador_asg_perdidas_uno++;
                    }
                    elseif($nro_asignatura_perdidas==2){
                        $contador_asg_no_perdidas_dos++;
                    }
                    elseif($nro_asignatura_perdidas==3){
                        $contador_asg_no_perdidas_tres++;
                    }
                    elseif($nro_asignatura_perdidas==4){
                        $contador_asg_no_perdidas_cuatro++;
                    }
                    else{
                        $contador_asg_no_perdidas_mayor_cuatro++;
                    }
                }
                $datos_asignaturas_perdidas1=array(
                $contador_asg_no_perdidas,
                $contador_asg_perdidas_uno,
                $contador_asg_no_perdidas_dos,
                $contador_asg_no_perdidas_tres,
                $contador_asg_no_perdidas_cuatro,
                $contador_asg_no_perdidas_mayor_cuatro
                );
                
                     $labels=array();
                $labels_=array();
            $labels_[]="$contador_asg_no_perdidas Ganaron Todas";
            $labels_[]="$contador_asg_perdidas_uno Perdieron Una";
            $labels_[]="$contador_asg_no_perdidas_dos Perdieron Dos";
            $labels_[]="$contador_asg_no_perdidas_tres Perdieron Tres";
            $labels_[]="$contador_asg_no_perdidas_cuatro Perdieron Cuatro";
            $labels_[]="$contador_asg_no_perdidas_mayor_cuatro Perdieron mas de Cuatro";
          
            $datos_asignaturas_perdidas_=$datos_asignaturas_perdidas1;
            rsort($datos_asignaturas_perdidas_,SORT_NUMERIC);
            $datos_asignaturas_perdidas__=$datos_asignaturas_perdidas_;
            for ($index = 0; $index < count($datos_asignaturas_perdidas1); $index++) {
                $index_1=  array_search($datos_asignaturas_perdidas1[$index],$datos_asignaturas_perdidas_) +0;                                
                $labels[$index_1]=$labels_[$index];
                $datos_asignaturas_perdidas_[$index_1]=-1;
                
            }
            $mi_labels[]=$labels;
            $datos_asignaturas_perdidas[]=$datos_asignaturas_perdidas__;
            
        }
            
            
       $format = $request->get('_format'); 
       $datos[]=$datos_asignaturas_perdidas;
       $datos[]=$mi_labels;
       return array(
           "datos_asg"=>$datos,
           'grados'=>$grados,
           'grupos'=>$grupos
               
               );
      
        
        
        
        
        
    }
    
     /**
     * Lists all Colegio entities.
     *
     * @Route("/informeconsolidadoasgperdidas", name="colegio_informeconsolidadoasgperdidas")
     * @Template()
     */
    public function informeconsolidadoasgperdidasAction()
    {
        ini_set('memory_limit', '-1');    
        set_time_limit(0);
        $request=  $this->getRequest();                
        $session=$request->getSession(); 
        $em=  $this->getDoctrine()->getManager();  
        $grados=$em->getRepository("NetpublicCoreBundle:Grado")->findAll();
        $sedes=$em->getRepository("NetpublicCoreBundle:Colegio")->findAll();
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodoEscolarActivo();
        
        $periodo_id=$session->get('perido_id',$periodo_activo->getId());
        $periodo_sesion=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);
        $sede=$request->get("sede",'*');    
        $grupo=$request->get('grupo','*');
        $notas_perdidas_al=$em->getRepository("NetpublicCoreBundle:Colegio")
                              ->getNroAsgPerdidasGrado(1,2.9,$periodo_id,1);
                      
        return array(
            "grados"=>$grados,
            "ano_escolar_activo"=>$ano_escolar_activo,
            "periodo_activo"=>$periodo_sesion,
            "sedes"=>$sedes,
            );
    }

    
    
    
    
    /**
     * Lists all Colegio entities.
     *
     * @Route("/{valor}/{grado_id}/{asg_id}/showalumnosdesempenos", name="colegio_showalumnosdesempenos")
     * @Template()
     */
    public function showalumnosdesempenosAction($valor,$grado_id,$asg_id)
    {
        $em=  $this->getDoctrine()->getManager();
        $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodoEscolarActivo();
        $colegio=$em->getRepository("NetpublicCoreBundle:Colegio")->findSedePrincipal();
        $maximo_superior=$colegio->getValorMaximoSobresaliente();
        $maximo_bajo=$colegio->getValorMaximoDeficiente();
        $maximo_basico=$colegio->getValorMaximoInsuficiente();
        $maximo_alto=$colegio->getValorMaximoAceptable();
        if($valor=='4'){
            $minimo=$maximo_alto;
            $maximo=$maximo_superior;
        }
        if($valor=='3'){
            $minimo=$maximo_basico;
            $maximo=$maximo_alto;
        }
        
        if($valor=='2'){
           $minimo=$maximo_bajo;
           $maximo=$maximo_basico;
        }
        
        if($valor=='1'){
            $minimo=-1;
            $maximo=$maximo_bajo;
        }
        
        $a_d=$em->getRepository("NetpublicCoreBundle:Colegio")
                ->findAlumnosAreasDesmpeno($minimo,$maximo,$grado_id,$asg_id,$periodo_activo->getId());
        
        return array("alumnos_notas"=>$a_d);
    }
    
     /**
     * Lists all Colegio entities.
     *
     * @Route("/{sede_id}/informeconsolidadoeficiencia", name="colegio_informeconsolidadoeficiencia")
     * @Template()
     */
    public function informeconsolidadoeficienciaAction($sede_id)
    {
        ini_set('memory_limit', '-1');    
        set_time_limit(0);
        
        $request=  $this->getRequest();
        
        $em=  $this->getDoctrine()->getEntityManager();
        $session=$request->getSession();
        $grados=$em->getRepository("NetpublicCoreBundle:Grado")->findAll();
        $colegio=$em->getRepository("NetpublicCoreBundle:Colegio")->findSedePrincipal();
        $maximo_superior=$colegio->getValorMaximoSobresaliente();
        $maximo_bajo=$colegio->getValorMaximoDeficiente();
        $maximo_basico=$colegio->getValorMaximoInsuficiente();
        $maximo_alto=$colegio->getValorMaximoAceptable();
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodoEscolarActivo();
        
        $periodo_id=$session->get('perido_id',$periodo_activo->getId());
        $periodo_sesion=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);
        $asignaturas=array();
        $asignaturas_obg=array();
        foreach ($grados as $grado) {
            $areas=$em->getRepository("NetpublicCoreBundle:Asignatura")->findBy(array(
                "grado"=>$grado->getId(),
                "es_area"=>TRUE
            ));
            foreach ($areas as $area) {
                if(!in_array($area->getNombre(), $asignaturas)){
                    $asignaturas[]=$area->getNombre();
                    
               }
            }
        }
        foreach ($grados as $grado) {
            $asg_json2=array();
            foreach ($asignaturas as $asg) {
                $asig4=$em->getRepository("NetpublicCoreBundle:Colegio")->finAreaNombreGrado($grado->getId(),$asg,$sede_id);
                if($asig4)
                    $asig2=$asig4->getId();
                else
                    $asig2=0;
                
                $asg_json=array();
                $asg_json[0]=array(
                   "grado"=>"$grado",
                   "asg"=>$asig2,
                   "nro"=>$em->getRepository("NetpublicCoreBundle:Colegio")
                  ->getNroAlumnosDesempenoAsg($asig2,$grado->getId(),$maximo_alto,$maximo_superior,$periodo_id,$sede_id));
                $asg_json[1]=array(
                   "grado"=>"$grado",
                   "asg"=>$asig2,
                   "nro"=>$em->getRepository("NetpublicCoreBundle:Colegio")
                  ->getNroAlumnosDesempenoAsg($asig2,$grado->getId(),$maximo_basico,$maximo_alto,$periodo_id,$sede_id));
               $asg_json[2]=array(
                   "grado"=>"$grado",
                   "asg"=>$asig2,
                   "nro"=>$em->getRepository("NetpublicCoreBundle:Colegio")
                  ->getNroAlumnosDesempenoAsg($asig2,$grado->getId(),$maximo_bajo,$maximo_basico,$periodo_id,$sede_id));
               $asg_json[3]=array(
                   "grado"=>"$grado",
                   "asg"=>$asig2,
                   "nro"=>$em->getRepository("NetpublicCoreBundle:Colegio")
                  ->getNroAlumnosDesempenoAsg($asig2,$grado->getId(),-1,$maximo_bajo,$periodo_id,$sede_id));
                                            
               $asg_json2[]=$asg_json;
               
            }
            $grado_asg_json[]=$asg_json2;
        }
        $descriptores=array("Super","Alto","Básico","Bajo");
        $sedes=$em->getRepository("NetpublicCoreBundle:Colegio")->findAll();
         return array(
             "sedes"=>$sedes,
            "ano_escolar_activo"=>$ano_escolar_activo,
            "periodo_activo"=>$periodo_sesion,
            "asignaturas"=>$asignaturas, 
            "asignaturas_obg"=>$asignaturas_obg, 
            "descriptores"=>$descriptores,
             "grados"=>$grados,
             "data"=>$grado_asg_json
            );
    }
    
    
     /**
     * Lists all Colegio entities.
     *
     * @Route("/informes", name="colegio_informes")
     * @Template()
     */
    public function informesAction()
    {
        return array(
            "id"=>1
        );
    }
     /**
     * Lists all Colegio entities.
     *
     * @Route("/listaplanillas", name="colegio_listaplanillas")
     * @Template()
     */
    public function listaplanillasAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $grados=$em->getRepository("NetpublicCoreBundle:Grado")->findAll();
        
        return array(
            "grados"=>$grados
        );
    }
     /**
     * Lists all Colegio entities.
     *
     * @Route("/getplanillagrupo", name="colegio_getplanillagrupo")
     * @Template()
     */
    public function getplanillagrupoAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $grados=$em->getRepository("NetpublicCoreBundle:Grado")->findAll();
        
        return array(
            "grados"=>$grados
        );
    }
     /**
     * Lists all Colegio entities.
     *
     * @Route("/newplanillaprofesores", name="colegio_newplanillaprofesores")
     * @Template()
     */
    public function newplanillaprofesoresAction()
    {
        $session=  $this->getRequest()->getSession();
        $em=  $this->getDoctrine()->getEntityManager();
        $profesores=$em->getRepository("NetpublicCoreBundle:Profesor")->findBy(
                array('tipo'=>2),
                array('apellido'=>"ASC")
                );
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                               ->findAnoEscolarActivo();
        
        $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($ano_escolar_id_s);
        $cas=array();
        foreach ($profesores as $p) {
            $cas[]=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
                   'profesor'=>$p->getId(),
                   'ano_escolar'=>$ano_escolar_activo->getId()
               ));
                     
        }
        if(!count($cas[0])){
            $cas=array();
            foreach ($profesores as $p) {
                $cas[]=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
                   'profesor'=>$p->getId()
                ));
            }
        }
        return array(
            "profesores"=>$profesores,
            "cargas"=>$cas
        );
    }

     /**
     * Lists all Colegio entities.
     *
     * @Route("/listacomponentes", name="colegio_listacomponentes")
     * @Template()
     */
    public function listacomponentesAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $padres=$em->getRepository("NetpublicCoreBundle:Dimension")->findBy(
                array('tipogc'=>7),
                array('tipogc'=>"DESC")
         );     
        
        return array(
           'padres'=>$padres            
        );
    }
  
         /**
     * Lists all Colegio entities.
     *
     * @Route("/menuconfiguracion", name="colegio_menuconfiguracion")
     * @Template()
     */
    public function menuconfiguracionAction()
    {
        return array(
            "id"=>1
        );
    }
     /**
     * Lists all Colegio entities.
     *
     * @Route("/{tipo}/newconsolidado", name="colegio_newconsolidado")
     * @Template()
     */
    public function newconsolidadoAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();    
        $grados=  $em->getRepository("NetpublicCoreBundle:Grado")->findAll();
        $sedes=  $em->getRepository("NetpublicCoreBundle:Colegio")->findAll();
        $grupos=  $em->getRepository("NetpublicCoreBundle:Grupo")->findAll();
        return array(
          "grados"  =>$grados,
          "sedes"  =>$sedes,
          "grupos"  =>$grupos
        );
    } 
         /**
     * Lists all Colegio entities.
     *
     * @Route("/showanoperiodo", name="colegio_showanoperiodo")
     * @Template()
     */
    public function showanoperiodoAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();    
        $grados=  $em->getRepository("NetpublicCoreBundle:Grado")->findAll();
        $sedes=  $em->getRepository("NetpublicCoreBundle:Colegio")->findAll();
        $grupos=  $em->getRepository("NetpublicCoreBundle:Grupo")->findAll();
        return array(
          "grados"  =>$grados,
          "sedes"  =>$sedes,
          "grupos"  =>$grupos
        );
    } 

      /**
     * Lists all Colegio entities.
     *
     * @Route("/{tipo}/newconsolidadoajax", name="colegio_newconsolidadoajax")
     * @Template()
     */
    public function newconsolidadoajaxAction()
    {
        $request=  $this->getRequest();        
        $em=  $this->getDoctrine()->getEntityManager();    
        $grados=  $em->getRepository("NetpublicCoreBundle:Grado")->findAll();        
        return array(
          "grados"  =>$grados,
          "sede"=>"*"
        );
    } 
      /**
     * Lists all Colegio entities.
     * 
     * @Route("/{sede}/actualizarsedeconsoldato", name="colegio_actualizarsedeconsoldato")
     * @Template()
     */
    public function actualizarsedeconsoldatoAction($sede)
    {
        $request=  $this->getRequest();                
        $session=$request->getSession();        
        $session->set('sede',$sede);
        return new \Symfony\Component\HttpFoundation\Response("ok");
    } 
       /**
     * Lists all Colegio entities.
     * 
     * @Route("/{sede}/actualizargrupoconsoldato", name="colegio_actualizargrupoconsoldato")
     * @Template()
     */
    public function actualizargrupoconsoldatoAction($sede)
    {
        $request=  $this->getRequest();                
        $session=$request->getSession();        
        $session->set('grupo',$sede);
        return new \Symfony\Component\HttpFoundation\Response("ok");
    } 
        /**
     * Lists all Colegio entities.
     * 
     * @Route("/{tipo}/mejoresalumnosgrupos.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|xls|pdf|json"}, name="colegio_mejoresalumnosgrupos")
     * @Template()
     */
    public function mejoresalumnosgruposAction()
    {
         ini_set('memory_limit', '-1');    
    set_time_limit(0);
        $em=  $this->getDoctrine()->getEntityManager();                
        $request=  $this->getRequest();
        $colegio=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")
                       ->findOneBy(array(
                           'es_principal'=>1
                       ));
        
        $nro_cifras=$colegio->getNumeroCifrasignificativa(); 
        $grupos=  $em->getRepository("NetpublicCoreBundle:Grupo")
                     ->findAll();
         $periodo_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                                    ->findPeriodoEscolarActivo();

         $x=array();
         $puestos=array();
         $nombres=array();
         $promedios=array();
         $grupos_ajax=array();
         $valores_x=array();
         $loop1=0;
         foreach ($grupos as $grupo) {                                         
            $alumnos_mejores_grupo_=  $em->getRepository("NetpublicCoreBundle:Alumno")->
                 getAlumnosMejoresPuestos($grupo->getId(),$periodo_escolar_activo->getId());
            foreach ($alumnos_mejores_grupo_ as $n_alumno) {
                $puesto=$n_alumno->getPuesto();
                $alumno=$n_alumno->getAlumno();
                if($puesto==null)
                    $puesto=-1;
                $puestos[]=$puesto;
                $nombres[]="$alumno";
                $promedio= number_format($em->getRepository("NetpublicCoreBundle:Alumno")->
                    getPromedioAlumnoGrupo($alumno,$grupo->getId(),$periodo_escolar_activo->getId()),1);
                $promedios[]=$promedio;
                $grupos_ajax[]="$grupo";
                $valores_x[]=$loop1;
                $loop1++;
            }
            
            
            
            
         }   
       $format = $request->get('_format'); 
       return $this->render(sprintf('NetpublicCoreBundle:Colegio:mejoresalumnosgrupos.%s.twig', $format),array(
            "x"=>array($puestos,$nombres,$promedios,$grupos_ajax,$valores_x)));
        
    }         

    /**
     * Lists all Colegio entities.
     * 
     * @Route("/{tipo}/promediogrupos.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|xls|pdf|json"}, name="colegio_promediogrupos")
     * @Template()
     */
    public function promediogruposAction()
    {
         ini_set('memory_limit', '-1');    
    set_time_limit(0);
        $em=  $this->getDoctrine()->getEntityManager();                
        $request=  $this->getRequest();
        $colegio=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")
                       ->findOneBy(array(
                           'es_principal'=>1
                       ));
        
        $nro_cifras=$colegio->getNumeroCifrasignificativa(); 
        $grado=1;
        $grupos=  $em->getRepository("NetpublicCoreBundle:Grupo")
                     ->findAll();
         $periodo_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                                    ->findPeriodoEscolarActivo();
         $promedio_grupo=array();
         $x=array();
         $labels=array();
         $contador_grupo=1;
         foreach ($grupos as $grupo) { 
       
            $promedio_grupo_=  number_format($em->getRepository("NetpublicCoreBundle:Alumno")->
                 getPromedioGrupo($grupo->getId(),$periodo_escolar_activo->getId()),1);
            $x[]=$contador_grupo;
            $contador_grupo=$contador_grupo+8;
            $promedio_grupo[]=$promedio_grupo_;            
            $labels["$promedio_grupo_"]="$grupo";
            
            
         }   
          $format = $request->get('_format'); 
       return $this->render(sprintf('NetpublicCoreBundle:Colegio:promediogrupos.%s.twig', $format),array(
            "x"=>array($promedio_grupo,$labels,$x)));
        
    }         
    
    
    /**
     * Lists all Colegio entities.
     * 
     * @Route("/{tipo}/librofinal.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|xls|pdf|json"}, name="colegio_librofinal")
     * @Template()
     */
    public function librofinalAction()
    {
        ini_set('memory_limit', '-1');    
    set_time_limit(0);
        $em=  $this->getDoctrine()->getEntityManager();                
        $request=  $this->getRequest();
        $sede=1;
        $grado='*';
        $grupo=1;
         $contador_alumnos_habilitarion=$em->getRepository("NetpublicCoreBundle:Alumno")->
                getNroAlumnosHabilitaron($sede,$grado,$grupo);
        $contador_alumnos_aprobaron=$em->getRepository("NetpublicCoreBundle:Alumno")->
                getNroAlumnosAproboReproboRetiro($sede,$grado,$grupo,1);
        $contador_alumnos_reprobaron=$em->getRepository("NetpublicCoreBundle:Alumno")->
                getNroAlumnosAproboReproboRetiro($sede,$grado,$grupo,2);
        $contador_alumnos_retiraron=$em->getRepository("NetpublicCoreBundle:Alumno")->
                getNroAlumnosAproboReproboRetiro($sede,$grado,$grupo,8);
            $datos_asignaturas_perdidas=array(
            $contador_alumnos_aprobaron,
            $contador_alumnos_reprobaron,
            $contador_alumnos_retiraron,
            $contador_alumnos_habilitarion            
                );
            $labels=array();
            $labels_[]="$contador_alumnos_aprobaron Alumnos Aprobaron";
            $labels_[]="$contador_alumnos_reprobaron Alumnos Reprobaron";
            $labels_[]="$contador_alumnos_retiraron Alumnos Retiraron";
            $labels_[]="$contador_alumnos_habilitarion Alumnos Habilitaron";
            
          
            $datos_asignaturas_perdidas_=$datos_asignaturas_perdidas;
            rsort($datos_asignaturas_perdidas_,SORT_NUMERIC);
            $datos_asignaturas_perdidas__=$datos_asignaturas_perdidas_;
            for ($index = 0; $index < count($datos_asignaturas_perdidas); $index++) {
                $index_1=  array_search($datos_asignaturas_perdidas[$index],$datos_asignaturas_perdidas_) +0;                                
                $labels[$index_1]=$labels_[$index];
                $datos_asignaturas_perdidas_[$index_1]=-1;
                
            }
            
       $format = $request->get('_format'); 
       return $this->render(sprintf('NetpublicCoreBundle:Colegio:librofinal.%s.twig', $format),array(
            "datos_asg"=>array($datos_asignaturas_perdidas__,$labels)));
        
    }
     /**
     * Lists all Colegio entities.
     * 
     * @Route("/consolidadoasignaturas.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|xls|pdf|json"}, name="colegio_consolidadoasignaturas")
     * @Template()
     */
    public function consolidadoasignaturasAction()
    {
        
        
    }
     /**
     * Lists all Colegio entities.
     * 
     * @Route("/consolidado.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|xls|pdf|json"}, name="colegio_consolidado")
     * @Template()
     */
    public function consolidadoAction()
    {
        ini_set('memory_limit', '-1');    
        set_time_limit(0);           
        
        $em=  $this->getDoctrine()->getEntityManager();    
        $grados=  $em->getRepository("NetpublicCoreBundle:Grado")->findAll();  
        $request=  $this->getRequest();
        $session=$request->getSession(); 
        $grupo=$request->get('grupo','*');
        $colegio=$em->getRepository("NetpublicCoreBundle:Colegio")->findSedePrincipal();
        $maximo_superior=$colegio->getValorMaximoSobresaliente();
        $maximo_bajo=$colegio->getValorMaximoDeficiente();
        $maximo_basico=$colegio->getValorMaximoInsuficiente();
        $maximo_alto=$colegio->getValorMaximoAceptable();
        $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodoEscolarActivo();
        $periodo_id=$session->get('perido_id',$periodo_activo->getId());     
        $sede_id=$session->get('sede','*');
        foreach ($grados as $grado) {
            $areas=$em->getRepository("NetpublicCoreBundle:Asignatura")->findBy(array(
                "grado"=>$grado->getId(),
                "es_area"=>TRUE
            ));
            $area_info=array();
            foreach ($areas as $area) {                
        $numero_alumnos_total=$em->getRepository("NetpublicCoreBundle:Colegio")
                                 ->getNroAlumnosDesempeno($periodo_id,$area->getId(),-1,$maximo_superior,$sede_id,$grado,$grupo)   ;                                                                                                            
                $numero_alumnos_bajo=$em->getRepository("NetpublicCoreBundle:Colegio")
                                 ->getNroAlumnosDesempeno($periodo_id,$area->getId(),-1,$maximo_bajo,$sede_id,$grado,$grupo)   ;                          
                $numero_alumnos_basico=$em->getRepository("NetpublicCoreBundle:Colegio")
                                 ->getNroAlumnosDesempeno($periodo_id,$area->getId(),$maximo_bajo,$maximo_basico,$sede_id,$grupo)   ;                          
                $numero_alumnos_alto=$em->getRepository("NetpublicCoreBundle:Colegio")
                                 ->getNroAlumnosDesempeno($periodo_id,$area->getId(),$maximo_basico,$maximo_alto,$sede_id,$grado,$grupo)   ;                          
                $numero_alumnos_superior=$em->getRepository("NetpublicCoreBundle:Colegio")
                                 ->getNroAlumnosDesempeno($periodo_id,$area->getId(),$maximo_alto,$maximo_superior,$sede_id,$grado,$grupo)   ;                          
                $area_info[]=array("$area",array(
                    $numero_alumnos_total,
                    $numero_alumnos_superior,
                    $numero_alumnos_alto,
                    $numero_alumnos_basico,
                    $numero_alumnos_bajo
                    ));                              
            }
            $grados_areas_info[]=array("$grado",$area_info,$grado->getId());            
            
        }
        $format = $request->get('_format'); 
        if($format=='xls'){
                    $desempenos=array("Alumnos","Superior","Alto","Basico","Bajo");
                    $xls_service =  $this->get('xls.service_xls5');
                    // create the object see http://phpexcel.codeplex.com documentation
                     $xls_service->getProperties()->setCreator("Maarten Balliauw")
                             ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("Consolidado De Eficiente")
                             ->setSubject("No")
                             ->setDescription("Muestra los grados y Numero de estudiantes con sus desempenos ")
                             ->setKeywords("Eficiencia")
                             ->setCategory("Test result file");
                     for ($index1 = 0; $index1 < count($grados_areas_info); $index1++) {                                                                      
                                $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
     ->setCellValueByColumnAndRow($index1+1,1,$grados_areas_info[$index1][0]);   
                              $fila=2;  
                              for ($index = 0; $index < count($grados_areas_info[$index1][1]); $index++) {
                                $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
     ->setCellValueByColumnAndRow($index1+1,$fila,$grados_areas_info[$index1][1][$index][0]);  
                                   $fila_valores=$fila+1;
                                    for ($index2 = 0; $index2 < count($grados_areas_info[$index1][1][$index][1]); $index2++) {
                                        $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                                         ->setCellValueByColumnAndRow($index1+1,$fila_valores,$grados_areas_info[$index1][1][$index][1][$index2]);  
                                        $xls_service->setActiveSheetIndex(0)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                                         ->setCellValueByColumnAndRow(0,$fila_valores,$desempenos[$index2]);  
                                        $fila_valores++;
                                    }
                                    $fila=$fila_valores;
                                    
                             }
    
                     }
                        
        //create the response
        $response = $xls_service->getResponse();
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=mejoresAlumnos.xls');        
        return $response;       
        

            
        }      
        $x=$grados_areas_info;
        return $this->render(sprintf('NetpublicCoreBundle:Colegio:consolidado.%s.twig', $format),        
              array(
            "x"=>$x,
             "periodo"=>$periodo_activo,     
            "sede"=>$sede_id
        ));
        
    }
     /**
     * Lists all Colegio entities.
     *
     * @Route("/configuracioncolegio", name="colegio_configuracioncolegio")
     * @Template()
     */
    public function configuracioncolegioAction()
    {
        $ano_escolar_activo=null;
        $periodo_escolar_activo=null;
        $periodo_escolares=array();
        $anos_escolares=array();
        $ano_escolar_activo=  $this->
                getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                ->findOneBy(array(
                    'tipo'=>0,
                    'es_ano_escolar'=>TRUE
                ));
        if($ano_escolar_activo)
        $periodo_escolares=  $this->getDoctrine()
                           ->getRepository("NetpublicCoreBundle:Dimension")
                           ->findBy(array(
                               'padre'=>$ano_escolar_activo->getId(),
                               'tipo'=>1
                           ));
        $anos_escolares= $this->
                getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                ->findBy(array(
                    'tipo'=>0                    
                    ));
        $colegio=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")
                       ->findOneBy(array(
                           'es_principal'=>1
                       ));
        $session=$this->get('request')->getSession();
        //Actualizar plantillas        
        
        $periodo_escolar_activo=$this->
                 getDoctrine()
                ->getRepository("NetpublicCoreBundle:Dimension")
                ->findOneBy(array(
                    'tipo'=>1,
                    'es_ano_escolar'=>TRUE
                ));
       $valor_defecto=$colegio->getValorDefecto();
       if($periodo_escolar_activo)
        $session->set('perido_id',$periodo_escolar_activo->getId());        
       

        return array(
            'ano_escolar_activo'=>$ano_escolar_activo,
            'periodo_escolar_activo'=>$periodo_escolar_activo,
            "periodo_escolares"=>$periodo_escolares,
            'anos_escolares'=>$anos_escolares,
            'valor_defecto'=>$valor_defecto,
            
        );
    }
    /**
     * Lists all Colegio entities.
     *
     * @Route("/", name="colegio")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('NetpublicCoreBundle:Colegio')->findAll();

        return array('entities' => $entities);
    }
        /**
     * Lists all Colegio entities.
     *
     * @Route("/criteriospromocion", name="colegio_criteriospromocion")
     * @Template()
     */
    public function criteriospromocionAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $grados = $em
                      ->getRepository('NetpublicCoreBundle:Grado')
                      ->findBy(array(),array('id'=>'DESC'));
        $nro_item=array();
        foreach ($grados as $v) {
            $nro_item[]=  count($v->getGrupo());
            $query = $em->createQuery('SELECT count(g) FROM NetpublicCoreBundle:Gradopromovido g WHERE g.grado_actual=:grado_actual')
                            ->setParameters(array(
                            "grado_actual"=>$v->getId()                                                        
                                )
                            );
            $count = $query->getSingleScalarResult();
            if($count==0){
                $ca=new \Netpublic\CoreBundle\Entity\Gradopromovido();
                $ca->setGradoActual($v);
                $em->persist($ca);
            }
            
        }
        //Para los grupos
         $grupos = $em
                      ->getRepository('NetpublicCoreBundle:Grupo')
                      ->findBy(array(),array('id'=>'DESC'));

        foreach ($grupos as $v) {            
            $query = $em->createQuery('SELECT count(g) FROM NetpublicCoreBundle:Grupopromovido g WHERE g.grupo_actual=:grupo_actual')
                            ->setParameters(array(
                            "grupo_actual"=>$v->getId()                                                        
                                )
                            );
            $count = $query->getSingleScalarResult();
            if($count==0){
                $c_g=new \Netpublic\CoreBundle\Entity\Grupopromovido();
                $c_g->setGrado($v->getGrado());
                $c_g->setGrupoActual($v);
                $em->persist($c_g);
            }
            
        }

       $em->flush();
       $grados_promocion=  $this->getDoctrine()
                                ->getRepository("NetpublicCoreBundle:Gradopromovido")
                                ->findAll();
       
       
       $criterios_perder=  $em->createQuery('SELECT g FROM NetpublicCoreBundle:CriterioPromocion g WHERE g.tipo=0')
                              ->getResult();
       $criterios_perder_asig=  $em->createQuery('SELECT g FROM NetpublicCoreBundle:CriterioPromocion g WHERE g.tipo=2')
                              ->getResult();
            
       $criterios_habilitar=  $this->getDoctrine()
                                ->getRepository("NetpublicCoreBundle:CriterioPromocion")
                                ->findBy(array(
                                    'tipo'=>1
                                ));
       $criterios_habilitar_asig=  $em->createQuery('SELECT g FROM NetpublicCoreBundle:CriterioPromocion g WHERE g.tipo=3')
                              ->getResult();
       $grupos_promocion=  $em->createQuery('SELECT g FROM NetpublicCoreBundle:Grupopromovido g')
                              ->getResult();
       
      $ano_escolar_activo=  $this->
                getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                ->findOneBy(array(
                    'tipo'=>0,
                    'es_ano_escolar'=>TRUE
                ));
        $anos_escolares= $this->
                getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                ->findBy(array(
                    'tipo'=>0                    
                    ));



       
        return array(
            'grados_promocion' => $grados_promocion,
            'nro_item'=>$nro_item,
            'grados'=>$grados,
            'criterios_perder'=>$criterios_perder,
            'criterios_habilitar'=>$criterios_habilitar,
            'criterios_perder_asig'=>$criterios_perder_asig,
            'criterios_habilitar_asig'=>$criterios_habilitar_asig,
            'grupos_promocion'=>$grupos_promocion,
            'grupos'=>$grupos,
            'ano_escolar_activo'=>$ano_escolar_activo,
            'anos_escolares'=>$anos_escolares
            );
    }    
    
    
     /**
     * Displays a form to create a new Colegio entity.
     *
     * @Route("/gestionarpromover", name="colegio_gestionarpromover")
     * @Template()
     */
    public function gestionarpromoverAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $colegio=  $em->getRepository("NetpublicCoreBundle:Colegio")
                        ->findSedePrincipal();
        
        $nota_minima=$colegio->getNotaMinima();        
        return array(
            'nota_minima'=>$nota_minima
        );


    }
      /**
     * Displays a form to create a new Colegio entity.
     *
     * @Route("/gestionarpromovergrados", name="colegio_gestionarpromovergrados")
     * @Template()
     */
    public function gestionarpromovergradosAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $colegio=  $em->getRepository("NetpublicCoreBundle:Colegio")
                        ->findSedePrincipal();
        $grados=$em->getRepository("NetpublicCoreBundle:Grado")->findAll();
        
        $nota_minima=$colegio->getNotaMinima();        
        return array(
            'nota_minima'=>$nota_minima,
            'grados'=>$grados
        );
    }
   
     /**
     * Displays a form to create a new Colegio entity.
     *
     * @Route("/newinfoacademica", name="colegio_newinfoacademica")
     * @Template()
     */
    public function newinfoacademicaAction()
    {
        $entity = new Colegio();
        $form   = $this->createForm(new ColegioType(), $entity);
         $grados= $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grado")->findAll();
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            "grados"=>$grados
        );
    }
     /**
     * Displays a form to create a new Colegio entity.
     *
     * @Route("/{id_sede}/grados", name="colegio_grados")
     * @Template()
     */
    public function gradosAction($id_sede)
    {
        $sede=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")->find($id_sede);
        $grados_sede=$sede->getGrado();
        return array(
            'sede'=>$sede,
            'grados_sede' => $grados_sede
            
        );
    }


    /**
     * Finds and displays a Colegio entity.
     *
     * @Route("/{id}/show", name="colegio_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Colegio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Colegio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Colegio entity.
     *
     * @Route("/new", name="colegio_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Colegio();
        $form   = $this->createForm(new ColegioType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }
       /**
     * Displays a form to create a new Colegio entity.
     *
     * @Route("/newsede", name="colegio_newsede")
     * @Template()
     */
    public function newsedeAction()
    {
        $em=$this->getDoctrine()->getEntityManager();
        $session = $this->get('request')->getSession();
        $codigo_dane=$session->get('codigo_dane');
        $entity=array();
        for ($index1 =0 ; $index1 < $session->get('s_nro_sedes'); $index1++) {            
              $entity[] = new Colegio();
              $entity[$index1]->setNombre("   ");
              $entity[$index1]->setCodigoDane($codigo_dane."-".($index1+1));
              $p_form[]=new ColegioType();
              $p_form[$index1]->setName("colegio".$index1);
              $form[]   = $this->createForm($p_form[$index1], $entity[$index1]);
              $form_view[]=$form[$index1]->createView();
        }           
        if(!count($entity)){
            return $this->redirect($this->generateUrl('usuario'));
            
        }
        return array(
            'entity' => $entity,
            'form'   => $form_view,
            'nro_sedes' =>$session->get('s_nro_sedes')
        );
    }

    /**
     * Creates a new Colegio entity.
     *
     * @Route("/create", name="colegio_create")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Colegio:newsede.html.twig")
     */
    public function createAction()
    {
        $session = $this->get('request')->getSession();
        $entity  = new Colegio();
        $request = $this->getRequest();
        
        $form    = $this->createForm(new ColegioType(), $entity);
        $entity->setNotaMinima(3.8);
         $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            
            $em->persist($entity);
            $em->flush();
            //$file=$form['escudo_colegio']->getData();
            //if($file){
            //    $nombre_archivo= 'escudo_colegio'.$entity->getId().'.'.$file->guessExtension();  
            //    $file->move(__DIR__.'/../../../../web/'.'uploads/documents',$nombre_archivo);
               
            //}
            $session->set('s_nro_sedes',$entity->getNumeroSedes());
            $session->set('codigo_dane',$entity->getCodigoDane());
            return $this->redirect($this->generateUrl('colegio_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }
    
    /**
     * Creates a new Colegio entity.
     *
     * @Route("/createsede", name="colegio_createsede")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Colegio:newsede.html.twig")
     */
    public function createsedeAction()
    {
         $em = $this->getDoctrine()->getEntityManager();
          $session = $this->get('request')->getSession();
        for ($index1 =0 ; $index1 < $session->get('s_nro_sedes'); $index1++) {
                     $entity = new Colegio();            
                     $request = $this->getRequest();
                     $p_form[]=new ColegioType();
                     $p_form[$index1]->setName("colegio".$index1);
                     $form[$index1]    = $this->createForm($p_form[$index1], $entity);
                     $form[$index1]->handleRequest($request);
                     $form_view[]=$form[$index1]->createView();

                     if ($form[$index1]->isValid()) {
                            $em->persist($entity);                                 
                            //return $this->redirect($this->generateUrl('colegio_show', array('id' => $entity[]->getId())));
            
                    }
            
        }
       $em->flush();
       

        return array(
            'entity' => $entity,
            'form'   => $form_view
        );
    }


    /**
     * Displays a form to edit an existing Colegio entity.
     *
     * @Route("/{id}/edit", name="colegio_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Colegio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Colegio entity.');
        }

        $editForm = $this->createForm(new ColegioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
        /**
     * Edits an existing Colegio entity.
     *
     * @Route("/updateconfiguracion", name="colegio_updateconfiguracion")
     * @Method("post")
     * @Template()
     */
    public function updateconfiguracionAction()
    {
        $request=  $this->getRequest();
        $session=$request->getSession();
        $em=  $this->getDoctrine()->getEntityManager();
            if ($this->get('security.context')->isGranted('ROLE_RECTOR')){

                if($request->get('ano_escolar_activo')!='*'){
                            $query = $em->createQuery('UPDATE NetpublicCoreBundle:Dimension d set d.es_ano_escolar=0 WHERE d.tipo=0')
                                    ->execute();
                            $query = $em->createQuery('UPDATE NetpublicCoreBundle:Dimension d set d.es_ano_escolar=1 WHERE d.id=:id_ano_escolar_activo')
                                    ->setParameter('id_ano_escolar_activo', $request->get('ano_escolar_activo'))
                                    ->execute();
                }
               if($request->get('periodo_escolar_activo')!='*'){
                    $query = $em->createQuery('UPDATE NetpublicCoreBundle:Dimension d set d.es_ano_escolar=0 WHERE d.tipo=1')
                                    ->execute();
                    $query = $em->createQuery('UPDATE NetpublicCoreBundle:Dimension d set d.es_ano_escolar=1 WHERE d.id=:periodo_escolar_activo')
                                    ->setParameter('periodo_escolar_activo', $request->get('periodo_escolar_activo'))
                                    ->execute();
                }
            }
        
        $session->set("ano_escolar_id",$request->get('ano_escolar_activo'));
        $session->set("perido_id",$request->get('periodo_escolar_activo'));
        
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($request->get('ano_escolar_activo'));
        $periodo_escolares=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodosEscolar($ano_escolar_activo);
        $periodo_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($request->get('periodo_escolar_activo'));
        
        $anos_escolares= $this->
                getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                ->findBy(array(
                    'tipo'=>0                    
                    ));
       return array(
            'ano_escolar_activo'=>$ano_escolar_activo,
            "periodo_escolares"=>$periodo_escolares,
            'anos_escolares'=>$anos_escolares,
            'periodo_escolar_activo'=>$periodo_escolar_activo,
            );

        
    }
    /**
     * Edits an existing Colegio entity.
     *
     * @Route("/{grupo_id}/verdetallesgrupopuestos", name="colegio_verdetallesgrupopuestos")
     * 
     * @Template()
     */
    public function verdetallesgrupopuestosAction($grupo_id)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $session=$request->getSession();
        $periodo_id=$session->get('perido_id');  
        $nivels_academic=$em->getRepository("NetpublicCoreBundle:NivelAcademico")
                            ->getNivelesEducGrupo($grupo_id,$periodo_id);
                    return array(
                        'nivel_academico'=>$nivels_academic
                    );
    }
        /**
     * Displays a form to create a new Colegio entity.
     *
     * @Route("/{grado_actual_actual}/{grado_next_id}/grupos", name="colegio_grupos")
     * @Template()
     */
    public function gruposAction($grado_actual_actual,$grado_next_id)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $grupos_actuales=$em->getRepository("NetpublicCoreBundle:Grupo")
                             ->findGrupos($grado_actual_actual);        
        $grupos=$em->getRepository("NetpublicCoreBundle:Grupo")->findGrupos($grado_next_id);
        return array(
            'grupos'=>$grupos,
            'grupos_actuales'=>$grupos_actuales,
            'grado_actual'=>$grado_actual_actual
        );
    }
    
 
    /**
     * Edits an existing Colegio entity.
     *
     * @Route("/{grado_id}/verdetallesgradopuestos", name="colegio_verdetallesgradopuestos")
     * 
     * @Template()
     */
    public function verdetallesgradopuestosAction($grado_id)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $session=$request->getSession();
        $periodo_id=$session->get('perido_id');   
        $grado=$em->getRepository("NetpublicCoreBundle:Grado")->find($grado_id);
        $data=array();
        $grupos=$grado->getGrupo();
        
        $data_grupo=array();
        foreach ($grupos as $grupo) {                
                $data1=$em->getRepository("NetpublicCoreBundle:Profesor")
                ->getNroNotasModificadasGrupo($grupo->getId(),$periodo_id);
                
                $data_grupo[]=array(
                    'nombre'=>"$grupo",
                    'id'=>$grupo->getId(),
                    'cambios'=>$data1
                );
                     
        }
        return array(
            //'grupo'=>$grupo,
            'data'=>$data_grupo
        );
        
        
    }
    /**
     * Edits an existing Colegio entity.
     *
     * @Route("/newsincronicarnotaspuestos", name="colegio_newsincronicarnotaspuestos")
     * 
     * @Template()
     */
    public function newsincronicarnotaspuestosAction()
    {
         
       
        $em=  $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $session=$request->getSession();
        
        $ano_escolar_activo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                      ->findAnoEscolarActivo();
             $periodo_activo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                      ->findPeriodoEscolarActivo();
            $periodo_id=$session->get('perido_id',$periodo_activo->getId());
       
         $periodo= $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                      ->find($periodo_id);
       
        $grados=$em->getRepository("NetpublicCoreBundle:Grado")
                ->findAll();
        $data=array();
        foreach ($grados as $grado) {
            $grupos=$grado->getGrupo();
            $nro_cambios=0;
            $data_grupo=array();
            foreach ($grupos as $grupo) {                
                $data1=$em->getRepository("NetpublicCoreBundle:Profesor")
                ->getNroNotasModificadasGrupo($grupo->getId(),$periodo_id);
                $nro_cambios+=$data1;
                     
            }
               $data_grado=array(
                'nombre'=>"$grado",
                'id'=>$grado->getId(),
                'cambios'=>$nro_cambios,
                'grupos'=>$data_grupo   
             );
         
            $data[]=$data_grado;
        }       
        
        return array(
            //'grupo'=>$grupo,
            'data'=>$data,
            'ano_escolar_activo'=>$ano_escolar_activo,
            'periodo'=>$periodo
        );
        
    }
    /**
     * Edits an existing Colegio entity.
     *
     * @Route("/{grupo_id}/sincronicarnotaspuestos", name="colegio_sincronicarnotaspuestos")
     * 
     * @Template()
     */
    public function sincronicarnotaspuestosAction($grupo_id)
    {
    ini_set('memory_limit', '-1');    
    set_time_limit(0);
    $em=  $this->getDoctrine()->getEntityManager();
    $request=  $this->getRequest();
    $session=$request->getSession();
    $periodo_id=$session->get('perido_id');        
    $grupos_carga_academica=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
        'tiene_profesor'=>1,
        'grupo'=>$grupo_id
    ));
    $em->getRepository("NetpublicCoreBundle:Alumnodesempeno")->ponderarNotasSinDespemnos($periodo_id,$grupos_carga_academica);   
    $alumnos=$em->getRepository("NetpublicCoreBundle:Alumno")->findBy(array(
        'grupo'=>$grupo_id
    ));
   foreach ($alumnos as $alumno) {
       $nota_estudiante=$em->getRepository("NetpublicCoreBundle:Alumno")->getNotaPromedioAreas($alumno,$periodo_id );
       $em->getRepository("NetpublicCoreBundle:NivelAcademico")
               ->generarNivelesACademicosAlumno($alumno,$periodo_id);
       $nivel_acad_periodo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:NivelAcademico")
                         ->findBy(array(
                             "periodo_actual"=>$periodo_id,
                             "alumno"=>$alumno->getId(),
                             'tipo'=>8
                             
       ));       
       foreach ($nivel_acad_periodo as $n_aa) {
            $n_aa->setNota($nota_estudiante);
            $em->persist($n_aa);                     
       }                                
   }
   $nls_a=$em->getRepository("NetpublicCoreBundle:Nivelacademico")->getNivelesEducGrupo($grupo_id,$periodo_id);
   $puesto=1;
   foreach ($nls_a as $nl) {
       $nl->setPuesto($puesto);
       $em->persist($nl);
       $puesto++;
   }
   $em->flush();        
   return array(
       'nvls_acad'=>$nls_a
   );
    }
    
    
    /**
     * Edits an existing Colegio entity.
     *
     * @Route("/{id}/update", name="colegio_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Colegio:edit.html.twig")
     */
    public function updateAction($id)
    {
        $session = $this->get('request')->getSession();

        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Colegio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Colegio entity.');
        }

        $editForm   = $this->createForm(new ColegioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setNombre($entity->getNombre());
            $em->persist($entity);
            
            $file=$editForm['escudo_colegio']->getData();
            if($file){
                $nombre_archivo= 'escudo_colegio'.$entity->getId();  
                $entity->getEscudoColegio()->move(__DIR__.'/../../../../web/'.'uploads/documents',
        $entity->getEscudoColegio()->getClientOriginalName());
                
                //$file->move(__DIR__.'/../../../../../web/'.'uploads/documents',$nombre_archivo);
                $imagen=$this->get('image.handling');
                $imagen->open(__DIR__.'/../../../../web/'.'uploads/documents/'.$entity->getEscudoColegio()->getClientOriginalName())
                       ->resize(100,120)
                        ->save(__DIR__.'/../../../../web/'.'uploads/documents/'.$nombre_archivo.'.png','png');
                //$imagine = new \Imagine\Gd\Imagine();
                //$image = $imagine->open($file);
                //$thumbnail_mini = $image->thumbnail(new Box(50, 75));
                //$thumbnail_mini->save(__DIR__.'/../../../../../web/'.'uploads/documents/'.$nombre_archivo.'.png');
                                   
            }
            $session->set('s_nro_sedes',$entity->getNumeroSedes());
            $session->set('codigo_dane',$entity->getCodigoDane());
            $em->flush();
            return $this->redirect($this->generateUrl('colegio_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Colegio entity.
     *
     * @Route("/{id}/delete", name="colegio_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:Colegio')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Colegio entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('colegio'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    private function promoverPorNroAreasPerdidas(Alumno $alumno, \Netpublic\CoreBundle\Entity\Grado $grado_promvido ,CriterioPromocion $condicion_academica,$areas,$periodo_escolares,$nota_minima){
                $em=  $this->getDoctrine()->getEntityManager();
                //Por perdidas de numero de areas          
               $simbolo_perdida=$condicion_academica->getSimbolo();               
               $valor_perdida=$condicion_academica->getValor();
               $nro_areas_perdida=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")
                                               ->getAreasPerdidas($alumno->getId(),$periodo_escolares,$nota_minima,$areas);
               //Buen estudiantes
               if($nro_areas_perdida==0){
                       $alumno->setRepitente(0);
                       $alumno->setSituacionAcademicaAnoAnterior(1);                                   
                       $alumno->setGrado($grado_promvido);
               }              
               if($simbolo_perdida=='>='){
                   if($nro_areas_perdida>=$valor_perdida){
                         $alumno->setRepitente(1);
                         $alumno->setSituacionAcademicaAnoAnterior(2);                                   

                   }                                                  
               }
               if($simbolo_perdida=='>'){
                   echo $nro_areas_perdida."--".$valor_perdida;
                  if($nro_areas_perdida>$valor_perdida){
                         $alumno->setRepitente(1);
                         $alumno->setSituacionAcademicaAnoAnterior(2);                                   

                  }                                                                                                    
               }
               if($simbolo_perdida=='<='){
                 if($nro_areas_perdida<=$valor_perdida){
                         $alumno->setRepitente(1);
                         $alumno->setSituacionAcademicaAnoAnterior(2);                                   

                 }                                                                                                    
               }
               if($simbolo_perdida=='<'){
                 if($nro_areas_perdida<valor_perdida){
                         $alumno->setRepitente(1);
                         $alumno->setSituacionAcademicaAnoAnterior(2);                                   

                 }                                                                                                  
              }                                          

          $em->persist($alumno);
        
    }
    
    private function promoverPorNroAreasHabilitacion(Alumno $alumno,  CriterioPromocion $condicion_academica,$areas,$periodo_escolares,$nota_minima){
                $em=  $this->getDoctrine()->getEntityManager();
                //Por perdidas de numero de areas          
               $simbolo_perdida=$condicion_academica->getSimbolo();
               $valor_perdida=$condicion_academica->getValor();
               $nro_areas_perdida=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")
                                               ->getAreasPerdidas($alumno->getId(),$periodo_escolares,$nota_minima,$areas);

               
               //return new \Symfony\Component\HttpFoundation\Response($nro_areas_perdida);
               if($simbolo_perdida=='>='){
                   if($nro_areas_perdida>=$valor_perdida){
                       $alumno->setEsHabilitacion(true);                                                          
                   }                                                  
               }
               if($simbolo_perdida=='>'){
                  if($nro_areas_perdida>$valor_perdida){
                       $alumno->setEsHabilitacion(true);                                                          

                  }                                                             
                        
               }
               if($simbolo_perdida=='<='){
                 if($nro_areas_perdida<=$valor_perdida){
                       $alumno->setEsHabilitacion(true);                                                          

                 }
               }
               if($simbolo_perdida=='<'){
                 if($nro_areas_perdida<valor_perdida){
                       $alumno->setEsHabilitacion(true);                                                          

                 }                                                                                                  
              }                                          

          $em->persist($alumno);
        
    }
    //cUANDO SE PERDE POR ASIGNATURAS
    public function promoverPorAsignaturasPerdidas(Alumno $alumno,$condicion_academica,$periodo_escolares,$nota_minima){           
                $em=$this->getDoctrine()->getEntityManager();
                $numero_asig_areas_perder=0;
                $ctriterio_perdida=$condicion_academica;
                $todos_criterios_perdida=  $this
                                               ->getDoctrine()
                                               ->getRepository("NetpublicCoreBundle:CriterioPromocion")
                                               ->findBy(array(
                                                   'criterio_promocion'=>$ctriterio_perdida->getId()
                                               ))            
                ;                
//Si la condicion acaddemica Todas las asignaturas|areas
                if($ctriterio_perdida->getSimbolo()=='and'){                 
                    foreach ($todos_criterios_perdida as $c_p) {
                         $re=$this
                           ->getDoctrine()
                           ->getRepository("NetpublicCoreBundle:Alumno")
                           ->esPerdioAsignaturaArea($c_p->getAreaAsignatura(),
                                       $alumno,$periodo_escolares,$nota_minima);
                         if($re){                             
                             $numero_asig_areas_perder++;
                         }
                        }
                        if(count($todos_criterios_perdida)==$numero_asig_areas_perder){
                             $alumno->setRepitente(1);
                             $alumno->setSituacionAcademicaAnoAnterior(2);                                   

                             $em->persist($alumno);
                        }                                                

                }
//Si la condicion academica Una de las lista Areas|Asignaturas                                               
                if($ctriterio_perdida->getSimbolo()=='or'){                 
                    foreach ($todos_criterios_perdida as $c_p) {
                         $re=$this
                           ->getDoctrine()
                           ->getRepository("NetpublicCoreBundle:Alumno")
                           ->esPerdioAsignaturaArea($c_p->getAreaAsignatura(),
                                       $alumno,$periodo_escolares,$nota_minima);
                         if($re){                             
                              $alumno->setRepitente(1);
                              $alumno->setSituacionAcademicaAnoAnterior(2);                                   


                              $em->persist($alumno);
                              break;
                         }
                    }
                }
    }                                
    
//Condicion para cuando se Habilita y por perdida de asignatura
        public function promoverPorAsignaturasHabilitadas(Alumno $alumno,$condicion_academica,$periodo_escolares,$nota_minima){           
                $em=$this->getDoctrine()->getEntityManager();
                $numero_asig_areas_perder=0;
                $ctriterio_perdida=$condicion_academica;
                $todos_criterios_perdida=  $this
                                               ->getDoctrine()
                                               ->getRepository("NetpublicCoreBundle:CriterioPromocion")
                                               ->findBy(array(
                                                   'criterio_promocion'=>$ctriterio_perdida->getId()
                                               ))            
                ;                
//Si la condicion acaddemica Todas las asignaturas|areas
                
                if($ctriterio_perdida->getSimbolo()=='and'){                                 
                    foreach ($todos_criterios_perdida as $c_p) {
                         $re=$this
                           ->getDoctrine()
                           ->getRepository("NetpublicCoreBundle:Alumno")
                           ->esPerdioAsignaturaArea($c_p->getAreaAsignatura(),
                                       $alumno,$periodo_escolares,$nota_minima);
                         if($re){                             
                             $numero_asig_areas_perder++;
                         }
                        }
                        if(count($todos_criterios_perdida)==$numero_asig_areas_perder){
                            $alumno->setEsHabilitacion(true);                                                                                                                  
                        }                                                
                        
                }
//Si la condicion academica Una de las lista Areas|Asignaturas                                               
                if($ctriterio_perdida->getSimbolo()=='or'){                 
                    foreach ($todos_criterios_perdida as $c_p) {
                         $re=$this
                           ->getDoctrine()
                           ->getRepository("NetpublicCoreBundle:Alumno")
                           ->esPerdioAsignaturaArea($c_p->getAreaAsignatura(),
                                       $alumno,$periodo_escolares,$nota_minima);
                         if($re){                             
                            $alumno->setEsHabilitacion(true);                                                          
                            break;
                         }
                    }
                }
                $em->persist($alumno);

    }                                

    
 }
