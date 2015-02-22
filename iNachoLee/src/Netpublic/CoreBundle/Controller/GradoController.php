<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\Grado;
use Netpublic\CoreBundle\Entity\Asignatura;
use Netpublic\CoreBundle\Form\GradoType;

/**
 * Grado controller.
 *
 * @Route("/grado")
 */
class GradoController extends Controller {

        /**
     * Lists all Grado entities.
     *
     * @Route("/{tipo}/gradostree",name="grado_gradostree")
     * @Template()
     */
    public function gradostreeAction($tipo) {
        $grados = $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grado")->findAll();
         return array(
            "grados" => $grados,
             "tipo"=>$tipo
        );
    }


    /**
     * Lists all Grado entities.
     *
     * @Route("/{id_grado}/asignaturas", name="grado_asignaturas")
     * @Template()
     */
    public function asignaturasAction($id_grado) {
        $asignaturas = array();
        if ($id_grado != '*') {
            $asignaturas = $this->getDoctrine()->getRepository("NetpublicCoreBundle:Asignatura")->findBy(array(
                "grado" => $id_grado,
                "es_area" => FALSE
                    ));
        }
        return array(
            "asignaturas" => $asignaturas
        );
    }

    /**
     * Lists all Grado entities.
     *
     * @Route("/{id_grado}/getareasgrado", name="grado_getareasgrado")
     * @Template()
     */
    public function getareasgradoAction($id_grado) {
        $grado = array();
        if ($id_grado != '*') {
            $asignaturas = $this->getDoctrine()->getRepository("NetpublicCoreBundle:Asignatura")->findBy(array(
                "grado" => $id_grado,
                "es_area" => TRUE
                    ));
        }
        return array(
            "asignaturas" => $asignaturas
        );
    }

    /**
     * Lists all Grado entities.
     *
     * @Route("/grados.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|json"}, name="grado_grados")
     * @Template()
     */
    public function gradosAction() {
        $request=  $this->getRequest();
        $delete_form=array();
        $format = $request->get('_format');       
        $grados = $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grado")->findAll();
        $grados_array=array();
        foreach ($grados as $entity) {
            $delete_form[] = $this->createDeleteForm($entity->getId())->createView();
            $grados_array[]=$entity->getId();
            
        }
        return $this->render(sprintf('NetpublicCoreBundle:Grado:grados.%s.twig', $format),
         array(
            "grados" => $grados,
            "delete_form"=>$delete_form,
            "grados_array"=>$grados_array 
                
        ));
    }

    /**
     * Lists all Grado entities.
     *
     * @Route("/{id_grado}/grupos", name="grado_grupos")
     * @Template()
     */
    public function gruposAction($id_grado) {
        $grupos=array();
        if($id_grado!='*') {
            $grado = $this->getDoctrine()->getRepository("NetpublicCoreBundle:Grado")->find($id_grado);
            $grupos = $grado->getGrupo();
        }
        return array(
            "grupos" => $grupos
        );
    }

    /**
     * Lists all Grado entities.
     *
     * @Route("/", name="grado")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $es_ajax = FALSE;
        $delete_form = array();
        $entities = $em->getRepository('NetpublicCoreBundle:Grado')->findAll();
        foreach ($entities as $e) {
            $delete_form[] = $this->createDeleteForm($e->getId())->createView();
        }
        if ($request->isXmlHttpRequest()) {
            $es_ajax = TRUE;
        }
        return array(
            'entities' => $entities,
            'es_ajax' => $es_ajax,
            'delete_form' => $delete_form
        );
    }

    /**
     * Finds and displays a Grado entity.
     *
     * @Route("/{id}/show", name="grado_show")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Grado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Grado entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),);
    }

    /**
     * Displays a form to create a new Grado entity.
     *
     * @Route("/new", name="grado_new")
     * @Template()
     */
    public function newAction() {
        $request = $this->getRequest();
        $es_ajax = false;
        $entity = new Grado();
        $form = $this->createForm(new GradoType(), $entity);
        if ($request->isXmlHttpRequest()) {
            $es_ajax = TRUE;
        }
        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'es_ajax' => $es_ajax
        );
    }

    /**
     * Creates a new Grado entity.
     *
     * @Route("/create", name="grado_create")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Grado:new.html.twig")
     */
    public function createAction() {
        $entity = new Grado();

        $request = $this->getRequest();
        $form = $this->createForm(new GradoType(), $entity);
         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $grado_copia = $form["grado"]->getData();
            if ($grado_copia!="") {
                $d = "";
                $areas_copiar = $em->getRepository('NetpublicCoreBundle:Asignatura')->findBy(array(
                    'es_area' => 1,
                    "grado" => $grado_copia->getId()
                        ));
                echo $grado_copia->getId().".-..";
                foreach ($areas_copiar as $a_c) {
                    $area = new Asignatura();
                    $area->setEsArea(1);
                    $area->setNombre($a_c->getNombre());
                    $area->setDuracionMinutos($a_c->getDuracionMinutos());
                    $area->setGrado($entity);

                    $em->persist($area);
                    $asignaturas_copiar = $em->getRepository('NetpublicCoreBundle:Asignatura')->findBy(array(
                        'es_area' => 0,
                        "grado" => $grado_copia->getId(),
                        "area" => $a_c->getId()
                            ));
                    $d.="area";
                    foreach ($asignaturas_copiar as $asig_copiar) {
                        $asignatura = new Asignatura();
                        $asignatura->setEsArea(0);
                        $asignatura->setNombre($asig_copiar->getNombre());
                        $asignatura->setDuracionMinutos($asig_copiar->getDuracionMinutos());
                        $asignatura->setArea($area);
                        $asignatura->setGrado($entity);
                        $em->persist($asignatura);
                        $d.="asingtura";
                    }
                }

                //return new \Symfony\Component\HttpFoundation\Response("$d".$grado_copia);
            }
            $em->persist($entity);
            $em->flush();
            if ($this->container->get('request')->isXmlHttpRequest()) {
                return new \Symfony\Component\HttpFoundation\Response("Ok");
            }
            return $this->redirect($this->generateUrl('grado_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Grado entity.
     *
     * @Route("/{id}/edit", name="grado_edit")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $es_ajax = FALSE;
        $entity = $em->getRepository('NetpublicCoreBundle:Grado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Grado entity.');
        }

        $editForm = $this->createForm(new GradoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        if ($request->isXmlHttpRequest()) {
            $es_ajax = TRUE;
        }
        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'es_ajax' => $es_ajax
        );
    }

    /**
     * Edits an existing Grado entity.
     *
     * @Route("/{id}/update", name="grado_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Grado:edit.html.twig")
     */
    public function updateAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Grado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Grado entity.');
        }

        $editForm = $this->createForm(new GradoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $grado_copia = $editForm["grado"]->getData();
            if ($grado_copia != "") {
                $d = "";
                $asignaturas_viejas = $em->getRepository('NetpublicCoreBundle:Asignatura')->findBy(array(                    
                    "grado" => $entity->getId()
                        ));
                //Actualizamos las dimensiones de esas asignaturas
                $areas_copiar = $em->getRepository('NetpublicCoreBundle:Asignatura')->findBy(array(
                    'es_area' => 1,
                    "grado" => $grado_copia->getId()
                        ));
                $asignaturas_copiar = array();
                foreach ($areas_copiar as $a_c) {
                    $area = new Asignatura();
                    $area->setEsArea(1);
                    $area->setNombre($a_c->getNombre());
                    $area->setDuracionMinutos($a_c->getDuracionMinutos());
                    $area->setGrado($entity);
                    $em->persist($area);
                    $em->flush();
                    $id_area_nueva = $area->getId();
                    $id_area_copiar = $a_c->getId();
//Actualizamos las dimensiones de esas asignaturas                   
                    $em->createQuery("update NetpublicCoreBundle:Dimension a set a.asignatura=$id_area_nueva where a.asignatura=$id_area_copiar")
                            ->execute();
//Actualizamos desempenoes                    
                    $em->createQuery("update NetpublicCoreBundle:Desempeno a set a.asignatura=$id_area_nueva where a.asignatura=$id_area_copiar")
                            ->execute();
//Actualizamos desempenoes                    
                    $em->createQuery("update NetpublicCoreBundle:AlumnoDimension a set  a.asignatura=$id_area_nueva where a.asignatura=$id_area_copiar")
                            ->execute();
//Actualizamos desempenoes                    
                    $em->createQuery("update NetpublicCoreBundle:CargaAcademica a  set a.asignatura=$id_area_nueva where a.asignatura=$id_area_copiar")
                            ->execute();
//Actualizamos desempenoes                    
                    $em->createQuery("update NetpublicCoreBundle:AlumnoDesempeno a set  a.asignatura=$id_area_nueva where a.asignatura=$id_area_copiar")
                            ->execute();
//Actualizamos desempenoes                    
                    $em->createQuery("update NetpublicCoreBundle:TemaAsignatura a set  a.asignatura=$id_area_nueva where a.asignatura=$id_area_copiar")
                            ->execute();

                    $asignaturas_copiar = $em->getRepository('NetpublicCoreBundle:Asignatura')->findBy(array(
                        'es_area' => 0,
                        "grado" => $grado_copia->getId(),
                        "area" => $a_c->getId()
                            ));
                    $d.="area";
                    foreach ($asignaturas_copiar as $asig_copiar) {
                        $asignatura = new Asignatura();
                        $asignatura->setEsArea(0);
                        $asignatura->setNombre($asig_copiar->getNombre());
                        $asignatura->setDuracionMinutos($asig_copiar->getDuracionMinutos());
                        $asignatura->setArea($area);
                        $asignatura->setGrado($entity);
                        //$asig_copiar->setArea();
                        $em->persist($asignatura);
                        //$em->persist($asig_copiar);
                        $em->flush();
                        $id_asg_nueva = $asignatura->getId();
                        $id_asg_copia = $asig_copiar->getId();
//Actualizamos Dimensiones                        
                        $em->createQuery("update NetpublicCoreBundle:Dimension a set  a.asignatura=$id_asg_nueva where a.asignatura=$id_asg_copia")
                                ->execute();
//Actualizamos Desempenos, en la asignaturas                        
                        $em->createQuery("update NetpublicCoreBundle:Desempeno a set  a.asignatura=$id_asg_nueva where a.asignatura=$id_asg_copia")
                                ->execute();
//Actualizamos Desempenos, en la asignaturas                        
                        $em->createQuery("update NetpublicCoreBundle:AlumnoDimension a set  a.asignatura=$id_asg_nueva where a.asignatura=$id_asg_copia")
                                ->execute();
//Actualizamos Desempenos, en la asignaturas                        
                        $em->createQuery("update NetpublicCoreBundle:CargaAcademica a set  a.asignatura=$id_asg_nueva where a.asignatura=$id_asg_copia")
                                ->execute();
//Actualizamos Desempenos, en la asignaturas                        
                        $em->createQuery("update NetpublicCoreBundle:AlumnoDesempeno a set  a.asignatura=$id_asg_nueva where a.asignatura=$id_asg_copia")
                                ->execute();
//Actualizamos Desempenos, en la asignaturas                        
                        $em->createQuery("update NetpublicCoreBundle:TemaAsignatura a set  a.asignatura=$id_asg_nueva where a.asignatura=$id_asg_copia")
                                ->execute();
                        $d.="asingtura";
                    }
                }

                foreach ($asignaturas_viejas as $ar_cp) {
                    if($ar_cp->getEsArea()==0){
                        $ar_cp->setArea();                    
                        $em->persist($ar_cp);
                    }   
                }
                $em->flush();
                foreach ($asignaturas_viejas as $ar_cp) {
                    $em->remove($ar_cp);
                }
                
            }
            $entity->setNombre($entity->getNombre());
            $em->persist($entity);
            $em->flush();
            if ($request->isXmlHttpRequest()) {
                return new \Symfony\Component\HttpFoundation\Response("ok");
            }
            return $this->redirect($this->generateUrl('grado_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Grado entity.
     *
     * @Route("/{id}/delete", name="grado_delete")
     * @Method("post")
     */
    public function deleteAction($id) {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:Grado')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Grado entity.');
            }
            $this->updateGrado($entity->getId());
            $this->borrarCondicionGrado($id);
            $this->borrarGradoPromovido($id);
            $this->borrarGradoPromovidoSiguiente($id);
            $this->borrarGrupoPromovido($id);            
            $this->updateGrupo($id);
            $this->borrarAsignaturas($id);
            $em->remove($entity);
            $em->flush();
            if ($request->isXmlHttpRequest()) {
                return new \Symfony\Component\HttpFoundation\Response("ok");
            }
            $this->redirect($this->generateUrl('grado'));
        }

        return new \Symfony\Component\HttpFoundation\Response("-1");
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }
    private function updateGrado($grado_id) {
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="SELECT a_d FROM NetpublicCoreBundle:Alumno a_d";        
        $dql.=" WHERE a_d.grado=:dimension_id";
        $query=$em->createQuery($dql);
        $alumnos=$query->setParameter("dimension_id", $grado_id)->getResult();                        
        foreach ($alumnos as $a) {
            $a->setGrado();
            $em->persist($a);            
        }
        $em->flush();        
    }       
    private function updateGrupo($grado_id) {
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="SELECT a_d FROM NetpublicCoreBundle:Grupo a_d";        
        $dql.=" WHERE a_d.grado=:dimension_id";
        $query=$em->createQuery($dql);
        $grupos=$query->setParameter("dimension_id", $grado_id)->getResult();                        
        foreach ($grupos as $a) {
            $a->setGrado();
            $em->persist($a);            
        }
        $em->flush();        
    }       
    
    private function borrarGradoPromovido($grado_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:Gradopromovido a_d";
        $dql.=" WHERE a_d.grado_actual=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id",$grado_id)->execute();                        
    }
    private function borrarGradoPromovidoSiguiente($grado_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:Gradopromovido a_d";
        $dql.=" WHERE a_d.grado_siguiente=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $grado_id)->execute();                        
    }
private function borrarGrupoPromovido($grado_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:Grupopromovido a_d";
        $dql.=" WHERE a_d.grado=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $grado_id)->execute();                        
}
private function borrarCondicionGrado($grado_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:CondicionGrado a_d";
        $dql.=" WHERE a_d.grado=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $grado_id)->execute();                        
}
private function borrarAsignaturas($grado_id) {
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="SELECT a_d FROM NetpublicCoreBundle:Asignatura a_d";        
        $dql.=" WHERE a_d.grado=:dimension_id and a_d.es_area=1";
        $query=$em->createQuery($dql);
        $areas=$query->setParameter("dimension_id", $grado_id)->getResult();                        
        foreach ($areas as $area) {
          $this->borrarAlumnoDimension($area->getId());
          $asignaturas=  $this
                              ->getDoctrine()
                                  ->getRepository("NetpublicCoreBundle:Asignatura")
                                  ->findBy(array(
                                      "area"=>$area->getId(),
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
          $em->remove($area);            
        }

    
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
