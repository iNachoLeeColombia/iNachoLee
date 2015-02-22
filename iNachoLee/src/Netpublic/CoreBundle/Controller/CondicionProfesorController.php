<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\CondicionProfesor;
use Netpublic\CoreBundle\Form\CondicionProfesorType;

/**
 * CondicionProfesor controller.
 *
 * @Route("/condicionprofesor")
 */
class CondicionProfesorController extends Controller
{
         /**
     * Lists all CondicionCargaacademicacolegio entities.
     *
     * @Route("/{tipo}/{id}/cambiarestado", name="condicionprofesor_cambiarestado")
     * @Template()
     */
    public function cambiarestadoAction($tipo,$id)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $celda=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:CondicionProfesor")
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
     * @Route("/{tipo}/{columna}/{profesor}/cambiarestadocolumna", name="condicionprofesor_cambiarestadocolumna")
     * @Template()
     */
    public function cambiarestadocolumnaAction($tipo,$columna,$profesor)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $celdas=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:CondicionProfesor")
                       ->findBy(array(
                           'dia_columna'=>$columna,
                           'profesor'=>$profesor
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
     * @Route("/{tipo}/{fila}/{profesor}/cambiarestadofila", name="condicionprofesor_cambiarestadofila")
     * @Template()
     */
    public function cambiarestadofilaAction($tipo,$fila,$profesor)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="UPDATE NetpublicCoreBundle:CondicionProfesor c";
        $dql.=" SET c.tipo=:tipo WHERE";
        $dql.=" (c.profesor=:profesor AND c.hora_fila=:fila) AND (c.tipo=1 OR c.tipo=0)";
        $query=$em->createQuery($dql);
        $query=$query->setParameter('tipo', $tipo);
        $query=$query->setParameter("fila", $fila);
        $query=$query->setParameter("profesor", $profesor);
        $celdas=$query->execute();                        
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response("ok");
    }



     /**
     * Lists all CondicionCargaacademicacolegio entities.
     *
     * @Route("/{id_profesor}/ver", name="condicionprofesor_ver")
     * @Template()
     */
    public function verAction($id_profesor)
    {
        $sede_principal=  $this->getDoctrine()
         ->getRepository("NetpublicCoreBundle:Colegio")
         ->findSedePrincipal()
         ;        
        $nro_clase=$sede_principal->getNroClasesDia();
        
        $clases_hora=array();
        for ($index = 0; $index < $nro_clase; $index++) {
            $clases_hora[]=$h_c_profesor=$this->getDoctrine()
                            ->getRepository("NetpublicCoreBundle:CondicionProfesor")
                            ->findBy(array(                            
                            "hora_fila"=>$index,
                             "profesor"=>$id_profesor
                                ));
        
        }
        return array(            
            'clases_hora'=>$clases_hora,
            'id_ca'=>$id_profesor
            );

    
    }

        /**
     * Lists all CondicionContrato entities.
     *
     * @Route("/{id}/generar", name="condicionprofesor_generar")
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
        $dql="SELECT count(c) FROM NetpublicCoreBundle:CondicionProfesor c";
        $dql.=" WHERE c.profesor=:profesor";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("profesor",$id);                                
         $nro_celdas_ca=$query->getSingleScalarResult();
        if($nro_celdas_ca==0){
            $hora=6;   
            $dias_festivos=array(5,6);
            for ($index = 0; $index <$nro_clase_dia ; $index++) {
                for ($index1 = -1; $index1 < 7; $index1++) {
                    $entity  = new CondicionProfesor();
                    $entity->setDiaColumna($index1);
                    $entity->setHoraFila($index);
                    $entity->setProfesor($this->getDoctrine()
                            ->getRepository("NetpublicCoreBundle:Profesor")
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
     * Lists all CondicionProfesor entities.
     *
     * @Route("/", name="condicionprofesor")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NetpublicCoreBundle:CondicionProfesor')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a CondicionProfesor entity.
     *
     * @Route("/{id}/show", name="condicionprofesor_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CondicionProfesor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionProfesor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new CondicionProfesor entity.
     *
     * @Route("/new", name="condicionprofesor_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CondicionProfesor();
        $form   = $this->createForm(new CondicionProfesorType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new CondicionProfesor entity.
     *
     * @Route("/create", name="condicionprofesor_create")
     * @Method("POST")
     * @Template("NetpublicCoreBundle:CondicionProfesor:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new CondicionProfesor();
        $form = $this->createForm(new CondicionProfesorType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('condicionprofesor_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CondicionProfesor entity.
     *
     * @Route("/{id}/edit", name="condicionprofesor_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CondicionProfesor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionProfesor entity.');
        }

        $editForm = $this->createForm(new CondicionProfesorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing CondicionProfesor entity.
     *
     * @Route("/{id}/update", name="condicionprofesor_update")
     * @Method("POST")
     * @Template("NetpublicCoreBundle:CondicionProfesor:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CondicionProfesor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionProfesor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CondicionProfesorType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('condicionprofesor_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a CondicionProfesor entity.
     *
     * @Route("/{id}/delete", name="condicionprofesor_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NetpublicCoreBundle:CondicionProfesor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CondicionProfesor entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('condicionprofesor'));
    }

    private function createDeleteForm($id)
    {
        
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
