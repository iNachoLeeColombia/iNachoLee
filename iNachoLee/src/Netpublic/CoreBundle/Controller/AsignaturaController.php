<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\Asignatura;
use Netpublic\CoreBundle\Form\AsignaturaType;
use Netpublic\CoreBundle\Entity\AlumnoDimension;
use Netpublic\CoreBundle\Entity\CargaAcademica;

/**
 * Asignatura controller.
 *
 * @Route("/asignatura")
 */
class AsignaturaController extends Controller
{
        /**
     * Lists all Asignatura entities.
     *
     * @Route("/{grado}/{tipo}/getareasasignaturasgrado",name="asignatura_getareasasignaturasgrado")
     * @Template()
     */
    public function getareasasignaturasgradoAction($tipo,$grado)
    {
        $areas_asig=array();
        if($tipo!=3)
        $areas_asig=  $this->getDoctrine()
                           ->getRepository("NetpublicCoreBundle:Asignatura")
                           ->findBy(array(
                               'es_area'=>$tipo,
                               'grado'=>$grado
                           ))
                ;
        return array(
            'areas_asignatura'=>$areas_asig
        );
        
    }
    /**
     * Lists all Asignatura entities.
     *
     * @Route("/{tipo}/{grado}",requirements={"tipo" = "\d+","grado" = "\d+"}, name="asignatura")
     * @Template()
     */
    public function indexAction($tipo,$grado)
    {
        $es_ajax=false;
        $em = $this->getDoctrine();
        $request=  $this->getRequest();
         $delete_form =array();
        /*if($tipo==1){//Es una Area     
            $entities = $em->getRepository('NetpublicCoreBundle:Asignatura')->findBy(array(
                "es_area"=>1
            ));
        }
        else{
            $entities = $em->getRepository('NetpublicCoreBundle:Asignatura')->findBy(array(
                "es_area"=>0
            ));
        }*/
        
        $grado= $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grado")->find($grado);
        
       
        $entities=  array();
        if($grado){
           if($tipo==1){
           $entities=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Asignatura")->findBy(array(
               "grado"=>$grado->getId(),
               "es_area"=>TRUE
           ));
           
           }
           else{
           $entities=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Asignatura")->findBy(array(
               "grado"=>$grado->getId(),
               "es_area"=>false
           ));
           }
        }
        foreach ($entities as $e) {
            $delete_form[] = $this->createDeleteForm($e->getId())->createView();
        }
        if($request->isXmlHttpRequest()){
            $es_ajax=true;
        }
       
        //$areas_asignaturas=$grado->getAsignaturas();
        return array(
            'entities' => $entities,
            "tipo" =>$tipo,
            "es_ajax" =>$es_ajax,
            "delete_form" =>$delete_form,
          
            "grado"=>$grado
            
            );
    }

    /**
     * Finds and displays a Asignatura entity.
     *
     * @Route("/{id}/{tipo}/show", name="asignatura_show")
     * @Template()
     */
    public function showAction($id,$tipo)
    {
        $em = $this->getDoctrine()->getEntityManager();
       
        $request=  $this->getRequest();
        $entity = $em->getRepository('NetpublicCoreBundle:Asignatura')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Asignatura entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
       
        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),   
            'tipo' => $tipo
            );
    }
    /**
     * Finds and displays a Asignatura entity.
     *
     * @Route("/{id_grupo}/{id_profesor}/asignaturas", name="asignatura_asignaturas")
     * @Template()
     */
    public function asignaturasAction($id_grupo,$id_profesor)
    {
      $carga_academica=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
            'grupo'=>$id_grupo,
            'es_carga_academica'=>TRUE,
            'profesor'=>$id_profesor
        ));
        
        return array(
            'carga_academica' => $carga_academica

            );
    }
    
      /**
     * Lists all Grupo entities.
     *
     * @Route("/{id_asignatura}/profesores", name="asignatura_profesores")
     * @Template()
     */
    public function profesoresAction($id_asignatura)
    {
        $carga_academica=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
            'asignatura'=>$id_asignatura
        ));
        
        return array(
            'carga_academica' => $carga_academica

            );
    }
    /**
     * Displays a form to create a new Asignatura entity.
     *
     * @Route("/{tipo}/new", name="asignatura_new")
     * @Template()
     */
    public function newAction($tipo)
    {
        $request=  $this->getRequest();
        $em=  $this->getDoctrine()->getManager();
        $grados=$em->getRepository("NetpublicCoreBundle:Grado")->findAll();
        return array(
            'grados'=>$grados
         );
    }

    /**
     * Creates a new Asignatura entity.
     *
     * @Route("/{tipo}/create", name="asignatura_create")
     * @Method("post")
     * @Template()
     */
    public function createAction($tipo)
    {
        
        $entity  = new Asignatura();
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getEntityManager();
            
        if($tipo==1){
            $entity->setEsArea(TRUE);
            $nombre=$request->get('nombre_area');
            $grado_id=$request->get('grado_id');
            $grado=$em->getRepository("NetpublicCoreBundle:Grado")->find($grado_id);
            $duracion=$request->get('duracion');
            $entity->setNombre($nombre);
            $entity->setDuracionMinutos($duracion);
            $entity->setGrado($grado);
            
            
        }
        else{
            $nombre=$request->get('nombre_asg');
            $grado_id=$request->get('grado_id');
            $frecuencia=$request->get('frecuencia'); 
            $area_id=$request->get('area_id'); 
            $area=$em->getRepository("NetpublicCoreBundle:Asignatura")->find($area_id);
            $area->addAsg($entity);
            $em->persist($area);
            $grado=$em->getRepository("NetpublicCoreBundle:Grado")->find($grado_id);
            $entity->setEsArea(false);
            $entity->setNombre($nombre);
            $entity->setGrado($grado);
            $entity->setFrucuenciaSemana($frecuencia);
            $entity->setArea($area);
            
        }
        
        //$form    = $this->createForm(new AsignaturaType($entity->getGrado()), $entity);
        
        // $form->handleRequest($request);
        
        //if ($form->isValid()) {
            $grado->addAsignatura($entity);
            if($entity->getEsArea()==FALSE){
                //Seleccionas alumnos del grado, para agragarle dimensiones por fe y las principales
                $ano_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
				$grupos=$grado->getGrupo();
				foreach($grupos as $grupo){
					$ca=new CargaAcademica();
					$ca->setTieneProfesor(FALSE);					
					$ca->setAsignatura($entity);
					$ca->setGrupo($grupo);
                                        $ca->setEsCargaAcademica(FALSE);				
                                        $ca->setAnoEscolar($ano_activo);
					$em->persist($ca);
				}
            
           
            }
            $em->persist($grado);
            $em->persist($entity);
            $em->flush();
            return new \Symfony\Component\HttpFoundation\Response($entity->getId());
            
            
    }

    /**
     * Displays a form to edit an existing Asignatura entity.
     *
     * @Route("/{id}/{tipo}/edit", name="asignatura_edit")
     * @Template()
     */
    public function editAction($id,$tipo)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $entity = $em->getRepository('NetpublicCoreBundle:Asignatura')->find($id);
        $es_ajax=false;
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Asignatura entity.');
        }

        $editForm = $this->createForm(new AsignaturaType($entity->getGrado()), $entity);
        $deleteForm = $this->createDeleteForm($id);
        if($request->isXmlHttpRequest()){
            $es_ajax=true;
        }
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'tipo'  =>$tipo,
            'es_ajax' =>$es_ajax
        );
    }

    /**
     * Edits an existing Asignatura entity.
     *
     * @Route("/{id}/{tipo}/update", name="asignatura_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Asignatura:edit.html.twig")
     */
    public function updateAction($id,$tipo)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Asignatura')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Asignatura entity.');
        }

        $editForm   = $this->createForm(new AsignaturaType($entity->getGrado()), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            if($request->isXmlHttpRequest()){
                return new \Symfony\Component\HttpFoundation\Response("ok");
            }
            return $this->redirect($this->generateUrl('asignatura_edit', array('id' => $id,'tipo'=>$tipo)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'tipo' =>$tipo
        );
    }

    /**
     * Deletes a Asignatura entity.
     *
     * @Route("/{id}/{tipo}/delete", name="asignatura_delete")
     * @Method("post")
     */
    public function deleteAction($id,$tipo)
    {
        
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();        
         $form->handleRequest($request);
        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:Asignatura')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('.......');
            }
            //Boramos  CargaAcademica relacionad con la asignatura
      if($entity->getEsArea()==FALSE){                    
          $this->borrarAlumnoDesempeno($entity->getId());
          $this->borrarCargaAcademica($entity->getId());
          $this->borrarAlumnoDimension($entity->getId());
          $this->borrarDesempeno($entity->getId());
          $this->borrarDimension($entity->getId());
          $this->borrarTemaAsignatura($entity->getId());
          $this->borrarCondicionAsignatura($entity->getId());
      }
             
//Si es area
    if($entity->getEsArea()){
            $this->borrarAlumnoDimension($entity->getId());
            $asignaturas=  $this
                              ->getDoctrine()
                                  ->getRepository("NetpublicCoreBundle:Asignatura")
                                  ->findBy(array(
                                      "area"=>$entity->getId(),
                                      "es_area"=>FALSE
                                  ));
          foreach ($asignaturas as $a) {
                 $this->borrarAlumnoDesempeno($a->getId());
                 $this->borrarCargaAcademica($a->getId());
                 $this->borrarAlumnoDimension($a->getId());
                 $this->borrarDesempeno($a->getId());
                 $this->borrarDimension($a->getId());
                 $this->borrarTemaAsignatura($a->getId());
                 $this->borrarCondicionAsignatura($a->getId());             
                 $em->remove($a);
          }                   
         
    }

   $em->remove($entity);
   $em->flush();

             return new \Symfony\Component\HttpFoundation\Response("ok");
   }
       
        return $this->redirect($this->generateUrl('asignatura',array('tipo'=>$tipo)));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
 private function borrarCargaAcademica($asignatura_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="SELECT a_d FROM NetpublicCoreBundle:CargaAcademica a_d";
        $dql.=" WHERE a_d.asignatura=:dimension_id";
        $query=$em->createQuery($dql);
        $cargas_academicas=$query
                        ->setParameter("dimension_id", $asignatura_id)
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
        $dql.=" WHERE a_d.asignatura=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $asignatura_id)->execute();                        
    }
private function borrarAlumnoDesempeno($asignatura_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:AlumnoDesempeno a_d";
        $dql.=" WHERE a_d.asignatura=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $asignatura_id)->execute();                        
}
private function borrarDimension($asignatura_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:Dimension a_d";
        $dql.=" WHERE a_d.asignatura=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $asignatura_id)->execute();                        
}
private function borrarAlumnoDimension($asignatura_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:AlumnoDimension a_d";
        $dql.=" WHERE a_d.asignatura=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $asignatura_id)->execute();                        
}
//TemaAsignatura
private function borrarTemaAsignatura($asignatura_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:TemaAsignatura a_d";
        $dql.=" WHERE a_d.asignatura=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $asignatura_id)->execute();                        
}

private function borrarDesempeno($asignatura_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:Desempeno a_d";
        $dql.=" WHERE a_d.asignatura=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $asignatura_id)->execute();                        
}
private function borrarCondicionAsignatura($asignatura_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:CondicionAsignatura a_d";
        $dql.=" WHERE a_d.asignatura=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $asignatura_id)->execute();                        
}

}
