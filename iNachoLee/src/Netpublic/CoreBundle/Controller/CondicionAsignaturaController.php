<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\CondicionAsignatura;
use Netpublic\CoreBundle\Form\CondicionAsignaturaType;

/**
 * CondicionAsignatura controller.
 *
 * @Route("/condicionasignatura")
 */
class CondicionAsignaturaController extends Controller
{
         /**
     * Lists all CondicionCargaacademicacolegio entities.
     *
     * @Route("/{tipo}/{id}/cambiarestado", name="condicionasignatura_cambiarestado")
     * @Template()
     */
    public function cambiarestadoAction($tipo,$id)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $celda=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:CondicionAsignatura")
                       ->find($id);        
        $celda->setTipo($tipo);
        $em->persist($celda);
        $em->flush();
        return array(
            'c'=>$celda
        );      
    }
     /**
     * Lists all CondicionCargaacademicacolegio entities.
     *
     * @Route("/{tipo}/{columna}/{asignatura}/cambiarestadocolumna", name="condicionasignatura_cambiarestadocolumna")
     * @Template()
     */
    public function cambiarestadocolumnaAction($tipo,$columna,$asignatura)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $celdas=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:CondicionAsignatura")
                       ->findBy(array(
                           'dia_columna'=>$columna,
                           'asignatura'=>$asignatura
                       ));     
        foreach ($celdas as $celda) {
           $celda->setTipo($tipo);
           $em->persist($celda);                
        }        
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response("ok");
    }
     /**
     * Lists all CondicionCargaacademicacolegio entities.
     *
     * @Route("/{tipo}/{fila}/{asignatura}/cambiarestadofila", name="condicionasignatura_cambiarestadofila")
     * @Template()
     */
    public function cambiarestadofilaAction($tipo,$fila,$asignatura)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="UPDATE NetpublicCoreBundle:CondicionAsignatura c";
        $dql.=" SET c.tipo=:tipo WHERE";
        $dql.=" (c.asignatura=:asignatura AND c.hora_fila=:fila) AND (c.tipo=1 OR c.tipo=0)";
        $query=$em->createQuery($dql);
        $query=$query->setParameter('tipo', $tipo);
        $query=$query->setParameter("fila", $fila);
        $query=$query->setParameter("asignatura", $asignatura);
        $celdas=$query->execute();                        
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response("ok");
    }



     /**
     * Lists all CondicionCargaacademicacolegio entities.
     *
     * @Route("/{id_asignatura}/ver", name="condicionasignatura_ver")
     * @Template()
     */
    public function verAction($id_asignatura)
    {
        $sede_principal=  $this->getDoctrine()
         ->getRepository("NetpublicCoreBundle:Colegio")
         ->findSedePrincipal()
         ;        
        $nro_clase=$sede_principal->getNroClasesDia();
        
        $clases_hora=array();
        for ($index = 0; $index < $nro_clase; $index++) {
            $clases_hora[]=$h_c_profesor=$this->getDoctrine()
                            ->getRepository("NetpublicCoreBundle:CondicionAsignatura")
                            ->findBy(array(                            
                            "hora_fila"=>$index,
                             "asignatura"=>$id_asignatura
                                ));
        
        }
        return array(            
            'clases_hora'=>$clases_hora,
            'id_ca'=>$id_asignatura
            );

    
    }

        /**
     * Lists all CondicionContrato entities.
     *
     * @Route("/{id}/generar", name="condicionasignatura_generar")
     * @Template()
     */
    public function generarAction($id)
    {
        $r="Ya esta";
        $em = $this->getDoctrine()->getEntityManager();
        $sede_principal=  $this->getDoctrine()
         ->getRepository("NetpublicCoreBundle:Colegio")
         ->findSedePrincipal()
         ;        
        $nro_clase_dia=$sede_principal->getNroClasesDia();
        $dql="SELECT count(c) FROM NetpublicCoreBundle:CondicionAsignatura c";
        $dql.=" WHERE c.asignatura=:asignatura";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("asignatura",$id);                                
         $nro_celdas_ca=$query->getSingleScalarResult();
        if($nro_celdas_ca==0){
            $hora=6;   
            $dias_festivos=array(5,6);
            for ($index = 0; $index <$nro_clase_dia ; $index++) {
                for ($index1 = -1; $index1 < 7; $index1++) {
                    $entity  = new CondicionAsignatura();
                    $entity->setDiaColumna($index1);
                    $entity->setHoraFila($index);
                    $entity->setAsignatura($this->getDoctrine()
                            ->getRepository("NetpublicCoreBundle:Asignatura")
                            ->find($id)
                            );
                    $es_libre=0;                
                    if(in_array($index1, $dias_festivos)){
                        $es_libre=2;
                    }
                    if($index1==-1){
                        $es_libre=-1;
                    }
                    $entity->setTipo($es_libre);                                                
                    $em->persist($entity);        
                }           
            }           
          $r="Generado por primera vez"  ;
 
 
        }
     $em->flush();    
     return new \Symfony\Component\HttpFoundation\Response("$r");

    }

    /**
     * Lists all CondicionAsignatura entities.
     *
     * @Route("/", name="condicionasignatura")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NetpublicCoreBundle:CondicionAsignatura')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a CondicionAsignatura entity.
     *
     * @Route("/{id}/show", name="condicionasignatura_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CondicionAsignatura')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionAsignatura entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new CondicionAsignatura entity.
     *
     * @Route("/new", name="condicionasignatura_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CondicionAsignatura();
        $form   = $this->createForm(new CondicionAsignaturaType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new CondicionAsignatura entity.
     *
     * @Route("/create", name="condicionasignatura_create")
     * @Method("POST")
     * @Template("NetpublicCoreBundle:CondicionAsignatura:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new CondicionAsignatura();
        $form = $this->createForm(new CondicionAsignaturaType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('condicionasignatura_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CondicionAsignatura entity.
     *
     * @Route("/{id}/edit", name="condicionasignatura_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CondicionAsignatura')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionAsignatura entity.');
        }

        $editForm = $this->createForm(new CondicionAsignaturaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing CondicionAsignatura entity.
     *
     * @Route("/{id}/update", name="condicionasignatura_update")
     * @Method("POST")
     * @Template("NetpublicCoreBundle:CondicionAsignatura:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CondicionAsignatura')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionAsignatura entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CondicionAsignaturaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('condicionasignatura_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a CondicionAsignatura entity.
     *
     * @Route("/{id}/delete", name="condicionasignatura_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NetpublicCoreBundle:CondicionAsignatura')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CondicionAsignatura entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('condicionasignatura'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
