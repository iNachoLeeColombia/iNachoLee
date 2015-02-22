<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\HorarioClase;
use Netpublic\CoreBundle\Form\HorarioClaseType;
use Ps\PdfBundle\Annotation\Pdf;
/**
 * HorarioClase controller.
 *
 * @Route("/horarioclase")
 */
class HorarioClaseController extends Controller
{    
     /**
     * Lists all HorarioClase entities.
     *
     * @Route("/newconfiguracion", name="horarioclase_newconfiguracion")
     * @Template()
     */
    public function newconfiguracionAction()
    {
        $sede_principal=  $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Colegio")
                               ->findSedePrincipal();
        return array(
            'sede_principal'=>$sede_principal
        );
        
    }
     /**
     * Lists all HorarioClase entities.
     *
     * @Route("/updateconfiguracion", name="horarioclase_updateconfiguracion")
     * @Template()
     */
    public function updateconfiguracionAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $sede_principal=  $this->getDoctrine()
                             ->getRepository("NetpublicCoreBundle:Colegio")
                             ->findSedePrincipal();
        //$sede_principal=new \Netpublic\CoreBundle\Entity\Colegio();
        $request=  $this->getRequest();
        $nro_clase=$request->get('nro_clase_dia',0);        
        $sede_principal->setNroClasesDia($nro_clase);        
        $sede_principal->setEsAulafija(1);
        //Actualizamos horas.
        $ids=  json_decode($request->get('ids_nota',array()));
        $values=  json_decode($request->get('values',array()));
        for ($index = 0; $index < count($ids); $index++) {
            $entity= $this->getDoctrine()
                          ->getRepository("NetpublicCoreBundle:CondicionCargaacademicacolegio")
                          ->find($ids[$index])
                    ;            
            $entity->setValor($values[$index]);
            $em->persist($entity);
            
        }
        
        $em->persist($sede_principal);
        $em->flush();
      return $this->redirect($this->generateUrl('horarioclase_newconfiguracion'));
        
    }
    
    /**
     * Lists all HorarioClase entities.
     *
     * @Route("/", name="horarioclase")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $es_ajax=FALSE;
        $entities = $em->getRepository('NetpublicCoreBundle:HorarioClase')->findAll();
        $delete_form=array();
        foreach ($entities as $e) {
            $delete_form[] = $this->createDeleteForm($e->getId())->createView();
        }
        if($request->isXmlHttpRequest()){
            $es_ajax=TRUE;
            
        }
        return array(
            'entities' => $entities,
            'es_ajax'=>$es_ajax,
            'delete_form'=>$delete_form
            );
    }
     /**
     * Lists all HorarioClase entities.
     * 
     * @Route("/imprimir.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|pdf"}, name="horarioclase_imprimir")
     * @Template()
     */
    public function imprimirAction()
    {
           set_time_limit(0);
        ini_set('memory_limit', '-1');
        $request=  $this->getRequest();
        $profesores=  $this->getDoctrine()
                       ->getRepository("NetpublicCoreBundle:Profesor")
                       ->findBy(array(
                           'tipo'=>2
        ));
        $clases_profesores=array();
        foreach ($profesores as $profe) {                                   
            $nro_clase=15;                
            $clases_hora=array();        
            for ($index = 0; $index < $nro_clase; $index++) {
                $clases_hora[]=$h_c_profesor=$this->getDoctrine()
                            ->getRepository("NetpublicCoreBundle:HorarioClase")
                            ->findBy(array(
                            "profesor"=>$profe->getId(),
                            "hora_fila"=>$index    
                                
                                ));        
            }
            $clases_profesores[]=$clases_hora; 
        }
        $format = $request->get('_format');        
        return $this->render(sprintf('NetpublicCoreBundle:HorarioClase:imprimir.%s.twig', $format), array(        
            'clases_profesores'=>$clases_profesores,
            "profesores"=>$profesores
        ));        

    }
     /**
     * Lists all HorarioClase entities.
     *
     * @Route("/borrar", name="horarioclase_borrar")
     * @Template()
     */
    public function borrarAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $em->createQuery("DELETE NetpublicCoreBundle:HorarioClase")
                ->execute(); 
        $em->createQuery("DELETE NetpublicCoreBundle:HorarioGrupo")
                ->execute(); 

         return new \Symfony\Component\HttpFoundation\Response("ok")  ;
    
   
    }
     /**
     * Lists all HorarioClase entities.
     *
     * @Route("/vertiemposlibres", name="horarioclase_vertiemposlibres")
     * @Template()
     */
    public function vertiemposlibresAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $condiciones_colegio=$em->createQuery(
                    "SELECT h FROM NetpublicCoreBundle:CondicionContrato h 
                             WHERE h.tipo=1 AND h.carga_academica=:contrato_id
                       ")
                    ->setParameter("contrato_id",$contrato_id )   
                    ->getResult();          
   

    
   
    }
     /**
     * Lists all HorarioClase entities.
     *
     * @Route("/{grado_id}/verdetallesgrado", name="horarioclase_verdetallesgrado")
     * @Template()
     */
    public function verdetallesgradoAction($grado_id)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $em=  $this->getDoctrine()->getEntityManager();
        $grupos=$em->getRepository("NetpublicCoreBundle:Grupo")->findBy(array(
            'grado'=>$grado_id
        ));
        return array(
            'grupos'=>$grupos
        );
     }
     /**
     * Lists all HorarioClase entities.
     *
     * @Route("/{grupo_id}/generarporpartes", name="horarioclase_generarporpartes")
     * @Template()
     */
    public function generarporpartesAction($grupo_id)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="SELECT ca,p,a,g FROM NetpublicCoreBundle:CargaAcademica ca";
        $dql.=" JOIN ca.profesor p JOIN ca.asignatura a JOIN ca.grupo g";
        $dql.=" where g.id=:grupo_id ";
        
        //$dql.=" WHERE g.id=1";
        $cargas_academicas=  $em
                              ->createQuery($dql)
                              ->setParameter('grupo_id',$grupo_id)
                              ->getResult();
        
        $em->getRepository("NetpublicCoreBundle:HorarioClase")
             ->generarHorarioClaseCargaAcademica($cargas_academicas);
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response("ok");
    }
     /**
     * Lists all HorarioClase entities.
     *
     * @Route("/{grado_id}/generarporpartesgrado", name="horarioclase_generarporpartesgrado")
     * @Template()
     */
    public function generarporpartesgradoAction($grado_id)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $em=  $this->getDoctrine()->getEntityManager();
        $grupos=$em->getRepository("NetpublicCoreBundle:Grupo")->findBy(array(
            "grado"=>$grado_id
        ));
        foreach ($grupos as $grupo) {       
        
        $dql="SELECT ca,p,a,g FROM NetpublicCoreBundle:CargaAcademica ca";
        $dql.=" JOIN ca.profesor p JOIN ca.asignatura a JOIN ca.grupo g";
        $dql.=" where g.id=:grupo_id ";
        
        //$dql.=" WHERE g.id=1";
        $cargas_academicas=  $em
                              ->createQuery($dql)
                              ->setParameter('grupo_id',$grupo->getId())
                              ->getResult();
        
        $em->getRepository("NetpublicCoreBundle:HorarioClase")
             ->generarHorarioClaseCargaAcademica($cargas_academicas);
        }
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response("ok");
    }
     
     /**
     * Lists all HorarioClase entities.
     *
     * @Route("/newgenerarporpartes", name="horarioclase_newgenerarporpartes")
     * @Template()
     */
    public function newgenerarporpartesAction()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $em=  $this->getDoctrine()->getEntityManager();
        $dias_festivos=array(5,6);
                $sede_principal=  $em
         ->getRepository("NetpublicCoreBundle:Colegio")
         ->findSedePrincipal()
         ;        
        $nro_clase=$sede_principal->getNroClasesDia();        
        $em->getRepository("NetpublicCoreBundle:HorarioClase")
             ->preconfiguracionGeneracionPorPartes(
                $nro_clase,
                $dias_festivos            
            );
        
        $grados=$em->getRepository("NetpublicCoreBundle:Grado")->findAll();
        return array(
            'grados'=>$grados
        );
     }
     
     
    
     /**
     * Lists all HorarioClase entities.
     *
     * @Route("/generarall", name="horarioclase_generarall")
     * @Template()
     */
    public function generarallAction()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $em=  $this->getDoctrine()->getEntityManager();
        $dias_festivos=array(5,6);
                $sede_principal=  $this->getDoctrine()
         ->getRepository("NetpublicCoreBundle:Colegio")
         ->findSedePrincipal()
         ;        
        $nro_clase=$sede_principal->getNroClasesDia();        
        /*Numero de Veces que se repite una ficha*/
        //$frecuencia_semana=2;
        /*Dias De separacion entre clases*/                
        $fichas_espacios=$sede_principal->getNroDiasentremismaclase();
        
        
        $this->getDoctrine()
             ->getRepository("NetpublicCoreBundle:HorarioClase")
             ->generarHorariosClase(
                $nro_clase,
                $dias_festivos,            
                $fichas_espacios                
                
            );
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response("ok");
    }
         /**
     * Lists all HorarioClase entities.
     *
     * @Route("/verificar", name="horarioclase_verificar")
     * @Template()
     */
    public function verificarAction()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $em=  $this->getDoctrine()->getEntityManager();
        $dias_festivos=array(5,6);
                $sede_principal=  $this->getDoctrine()
         ->getRepository("NetpublicCoreBundle:Colegio")
         ->findSedePrincipal()
         ;        
        $nro_clase=$sede_principal->getNroClasesDia();        
        /*Numero de Veces que se repite una ficha*/
        //$frecuencia_semana=2;
        /*Dias De separacion entre clases*/                
        $fichas_espacios=$sede_principal->getNroDiasentremismaclase();
        
        
        $this->getDoctrine()
             ->getRepository("NetpublicCoreBundle:HorarioClase")
             ->generarHorariosClase(
                $nro_clase,
                $dias_festivos,            
                $fichas_espacios                
                
            );
        $em->flush();
        $dql="SELECT ca FROM NetpublicCoreBundle:CargaAcademica ca";
        $dql.=" WHERE ca.tiene_profesor=1 AND (ca.estado_asignacion=3 OR ca.estado_asignacion=4)";
        $cargas_academicas= $em->createQuery($dql)->getResult();
        return array(
            'cargas_academicas'=>$cargas_academicas
        );
    }

     /**
     * Lists all HorarioClase entities.
     *
     * @Route("/verall", name="horarioclase_verall")
     * @Template()
     */
    public function verallAction()
    {
           set_time_limit(0);
        ini_set('memory_limit', '-1');
        $em=  $this->getDoctrine()->getEntityManager();
        $grupos=  $this->getDoctrine()
                       ->getRepository("NetpublicCoreBundle:Grupo")     
                       ->findAll();
                    $sede_principal=  $this->getDoctrine()
         ->getRepository("NetpublicCoreBundle:Colegio")
         ->findSedePrincipal()
         ;        
        $nro_clase=$sede_principal->getNroClasesDia();        
            ;
        //Posicion de clases
        $posicion_ficha=array();
        for ($index1 = 0; $index1 < $nro_clase; $index1++) {
            $posicion_ficha[$index1]=$index1;
        }
        
        
    foreach ($grupos as $grupo) {
        $temp="";
        $dias=array();
        for ($index = 0; $index < 7; $index++) {            
            $dql="SELECT h,c_a from NetpublicCoreBundle:HorarioGrupo h";
            $dql.=" JOIN h.carga_academica c_a";
            $dql.=" WHERE c_a.grupo=:grupo";
            $dql.=" AND  h.dia_columna=:columna";
            $dql.=" ORDER BY h.dia_columna DESC";
            $query=$em->createQuery($dql);
            $query=$query->setParameter('grupo',$grupo->getId());
            $query=$query->setParameter('columna',$index);
        $horacio_clase_grupo=$query->getResult();
                $fila_ficha=array();
                $temp.="columa$index<br/>";
                foreach ($horacio_clase_grupo as $h_cg) {            
                    $fila_ficha[]=$h_cg->getHoraFila();                        
                    $nombre_profesor=$h_cg->getCargaAcademica()->getProfesor();    
                    $temp.=$h_cg->getHoraFila()."-".$h_cg->getDiaColumna()."-$nombre_profesor"; 
                    $nombre_asg=$h_cg->getCargaAcademica()->getAsignatura();
                    $fichas_tem[$h_cg->getHoraFila()]=array(
                        "profesor"=>array(
                        'nombre'=>"$nombre_profesor"
                        ),
                        "asignatura"=>array(
                        'nombre'=>"$nombre_asg",
                        'color'=>"#FEFECC"
                        ),
                        "fila"=>$h_cg->getHoraFila()
                    ); 
                }
                
                $fichas_dia=array();
                for ($index2 = 0; $index2 < $nro_clase; $index2++) {                    
                    if(in_array($posicion_ficha[$index2], $fila_ficha)){
                        $fichas_dia[$index2]=$fichas_tem[$index2];
                        
                    }
                    else{
                        $fichas_dia[$index2]=array(
                            "profesor"=>array(
                            'nombre'=>"Aun Sin Asignar"
                            ),
                            "asignatura"=>array(
                            'nombre'=>"Aun Sin Asignar",
                            'color'=>0
                            ),
                            "fila"=>$index2                                                        
                        );
                        
                    }
                }            
            $dias[]=array("Lunes"=>$fichas_dia);
        }
        $horarios[]=array('dias'=>$dias,"nombre"=>"$grupo");
        
    }
        //return new \Symfony\Component\HttpFoundation\Response(json_encode($horarios));
    $dias_semana=array("dia"=>array(        
        "Lunes",
        "Martes",
        "Miercoles",
        "Jueves",
        "Viernes",
        "Sabado",
        "Domingo"
        ));
        return array(
            'horarios'=>$horarios,
            'nro_clase'=>$nro_clase,
            "dias_semana"=>$dias_semana
                
        );
        
        
    }
     /**
     * Lists all HorarioClase entities.
     *
     * @Route("/{id_profesor}/horarioclase", name="horarioclase_horarioclase")
     * @Template()
     */
    public function horarioclaseAction($id_profesor)
    {
        $nro_clase=15;
        $clases_hora=array();
        for ($index = 0; $index < $nro_clase; $index++) {
            $clases_hora[]=$h_c_profesor=$this->getDoctrine()
                            ->getRepository("NetpublicCoreBundle:HorarioClase")
                            ->findBy(array(
                            "profesor"=>$id_profesor,
                            "hora_fila"=>$index    
                                
                                ));
        
        }
        return array(            
            'clases_hora'=>$clases_hora,
            'id_profesor'=>$id_profesor
            );

    }
       /**
     * Lists all HorarioClase entities.
     *
     * @Route("/{id_profesor}/horarioclaseoption", name="horarioclase_horarioclaseoption")
     * @Template()
     */
    public function horarioclaseoptionAction($id_profesor)
    {
        $h_c_profesor=$this->getDoctrine()
         ->getRepository("NetpublicCoreBundle:HorarioClase")
         ->findBy(array(
             "profesor"=>$id_profesor                      ));
        return array(            
            'h_c_profesor'=>$h_c_profesor,
            'id_profesor'=>$id_profesor
            );

    }    
       /**
     * Lists all HorarioClase entities.
     *
     * @Route("/{id_1}/{id_2}/intercambiar", name="horarioclase_intercambiar")
     * @Template()
     */
    public function intercambiarAction($id_1,$id_2)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $h_c_profesor=$this->getDoctrine()
         ->getRepository("NetpublicCoreBundle:HorarioClase")
         ->find($id_1);        
        $h_c_profesor_2=$this->getDoctrine()
         ->getRepository("NetpublicCoreBundle:HorarioClase")
         ->find($id_2);
        $ca_temp=$h_c_profesor->getCargaAcademica();
        $_ca=$h_c_profesor_2->getCargaAcademica();
        if($_ca){
            $h_c_profesor->setTipo(1);
            $h_c_profesor->setCargaAcademica($_ca);
        }
        else{
            $h_c_profesor->setTipo(0);
            $h_c_profesor->setCargaAcademica();
        }
        $em->persist($h_c_profesor);
        if($ca_temp){
            $h_c_profesor_2->setTipo(1);
            $h_c_profesor_2->setCargaAcademica($ca_temp);
        }
        else{
            $h_c_profesor_2->setTipo(0);
            $h_c_profesor_2->setCargaAcademica();
        }
        $em->persist($h_c_profesor_2);
        $em->flush();
        
        return new \Symfony\Component\HttpFoundation\Response("ok");

    }


    /**
     * Finds and displays a HorarioClase entity.
     *
     * @Route("/{id}/show", name="horarioclase_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:HorarioClase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HorarioClase entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new HorarioClase entity.
     *
     * @Route("/new", name="horarioclase_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new HorarioClase();
        $request=  $this->getRequest();
        $es_ajax=false;
        $form   = $this->createForm(new HorarioClaseType(), $entity);
        if($request->isXmlHttpRequest())
            $es_ajax=true;
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'es_ajax' =>$es_ajax
        );
    }

    /**
     * Creates a new HorarioClase entity.
     *
     * @Route("/create", name="horarioclase_create")
     * @Method("post")
     * @Template("NetpublicCoreBundle:HorarioClase:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new HorarioClase();
        $request = $this->getRequest();
        $form    = $this->createForm(new HorarioClaseType(), $entity);
         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            //verificamos que el horario no exista
            $query = $em->createQuery('SELECT count(a) FROM NetpublicCoreBundle:HorarioClase a WHERE a.hora_inicio = :hora_inicio AND a.hora_final=:hora_final AND a.dia_semana=:dia_semana')
                    ->setParameters(array(
                       "hora_inicio"=>$entity->getHoraInicio(),
                       "hora_final"=>$entity->getHoraFinal(),
                       "dia_semana"=>$entity->getDiaSemana()     
                    ));
            $count = $query->getSingleScalarResult();
            if($count==0){
                $aulas=$entity->getAula();
                foreach ($aulas as $aula) {
                    $aula->addHorarioClase($entity);
                }                                
                $em->persist($entity);
                $em->flush();
            }
            if($request->isXmlHttpRequest())
                return new \Symfony\Component\HttpFoundation\Response("ok");
            return $this->redirect($this->generateUrl('horarioclase_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }
    /**
     * Creates a new HorarioClase entity.
     *
     * @Route("/createespecial", name="horarioclase_createespecial")
     * 
     * @Template()
     */
    public function createespecialAction()
    {
      $em=  $this->getDoctrine()->getEntityManager();
      $posicion=0;
      $profesores=  $this->getDoctrine()
                           ->getRepository("NetpublicCoreBundle:Profesor")
                           ->findBy(array(
                               "tipo"=>2
                           ));
     foreach ($profesores as $profesor) { 
       $nro_horario_clase=$em->createQuery(
               "SELECT count(h) FROM NetpublicCoreBundle:HorarioClase h 
                WHERE h.profesor=:profesor_id")                
                     ->setParameters(array(
                      "profesor_id"=>$profesor->getId()))
                     ->getSingleScalarResult();
       if($nro_horario_clase==0){                  
           $posicion=1;
        $hora=6;   
        for ($index = 0; $index < 24; $index++) {
            for ($index1 = 0; $index1 < 7; $index1++) {
                $entity  = new HorarioClase();
                $entity->setDiaColumna($index);
                $entity->setHoraFila($index1);
                $es_libre=0;

                $entity->setHoraFinal($hora+1);
                $entity->setHoraInicio($hora);
                if(((6+($index*7)))==$posicion){//Domingo
                    $es_libre=2;//Es dia festivo
                }
                if(((7+($index*7)))==$posicion){//Domingo
                    $es_libre=2;//Dias Festivos
                }
                $entity->setTipo($es_libre);
                $entity->setPosicion($posicion);
                $entity->setProfesor($profesor);
                $posicion++;
                $em->persist($entity);
        
            }
            $hora++;
            
        }
       }
     }
     $em->flush();
     return new \Symfony\Component\HttpFoundation\Response("ok")   ;
        return array(            
            'form'   => 1
        );
    }


    /**
     * Displays a form to edit an existing HorarioClase entity.
     *
     * @Route("/{id}/edit", name="horarioclase_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:HorarioClase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HorarioClase entity.');
        }

        $editForm = $this->createForm(new HorarioClaseType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing HorarioClase entity.
     *
     * @Route("/{id}/update", name="horarioclase_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:HorarioClase:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $entity = $em->getRepository('NetpublicCoreBundle:HorarioClase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HorarioClase entity.');
        }

        $editForm   = $this->createForm(new HorarioClaseType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        //if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            if($request->isXmlHttpRequest()){
                return new \Symfony\Component\HttpFoundation\Response("ok");
            }
            return $this->redirect($this->generateUrl('horarioclase_edit', array('id' => $id)));
        //}

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a HorarioClase entity.
     *
     * @Route("/{id}/delete", name="horarioclase_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        // $form->handleRequest($request);

        //if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:HorarioClase')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find HorarioClase entity.');
            }

            $em->remove($entity);
            $em->flush();
        //}
        if($request->isXmlHttpRequest()){
            return new \Symfony\Component\HttpFoundation\Response('ok');
        }    
        return $this->redirect($this->generateUrl('horarioclase'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
