<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\CondicionContrato;
use Netpublic\CoreBundle\Form\CondicionContratoType;

/**
 * CondicionContrato controller.
 *
 * @Route("/condicioncontrato")
 */
class CondicionContratoController extends Controller
{
        
     /**
     * Lists all CondicionCargaacademicacolegio entities.
     *
     * @Route("/{tipo}/{id}/cambiarestado", name="condicioncontrato_cambiarestado")
     * @Template()
     */
    public function cambiarestadoAction($tipo,$id)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $celda=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:CondicionContrato")
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
     * @Route("/{tipo}/{columna}/{contrato}/cambiarestadocolumna", name="condicioncontrato_cambiarestadocolumna")
     * @Template()
     */
    public function cambiarestadocolumnaAction($tipo,$columna,$contrato)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $celdas=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:CondicionContrato")
                       ->findBy(array(
                           'dia_columna'=>$columna,
                           'carga_academica'=>$contrato
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
     * @Route("/{tipo}/{fila}/{contrato}/cambiarestadofila", name="condicioncontrato_cambiarestadofila")
     * @Template()
     */
    public function cambiarestadofilaAction($tipo,$fila,$contrato)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="UPDATE NetpublicCoreBundle:CondicionContrato c";
        $dql.=" SET c.tipo=:tipo WHERE";
        $dql.=" (c.carga_academica=:contrato AND c.hora_fila=:fila) AND (c.tipo=1 OR c.tipo=0)";
        $query=$em->createQuery($dql);
        $query=$query->setParameter('tipo', $tipo);
        $query=$query->setParameter("fila", $fila);
        $query=$query->setParameter("contrato", $contrato);
        $celdas=$query->execute();                        
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response("ok");
    }



     /**
     * Lists all CondicionCargaacademicacolegio entities.
     *
     * @Route("/{id_carga_academica}/ver", name="condicioncontrato_ver")
     * @Template()
     */
    public function verAction($id_carga_academica)
    {
        $sede_principal=  $this->getDoctrine()
         ->getRepository("NetpublicCoreBundle:Colegio")
         ->findSedePrincipal()
         ;        
        $nro_clase=$sede_principal->getNroClasesDia();
        
        $clases_hora=array();
        for ($index = 0; $index < $nro_clase; $index++) {
            $clases_hora[]=$h_c_profesor=$this->getDoctrine()
                            ->getRepository("NetpublicCoreBundle:CondicionContrato")
                            ->findBy(array(                            
                            "hora_fila"=>$index,
                             "carga_academica"=>$id_carga_academica
                                ));
        
        }
        return array(            
            'clases_hora'=>$clases_hora,
            'id_ca'=>$id_carga_academica
            );

    
    }

        /**
     * Lists all CondicionContrato entities.
     *
     * @Route("/{id}/generar", name="condicioncontrato_generar")
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
        $dql="SELECT count(c) FROM NetpublicCoreBundle:CondicionContrato c";
        $dql.=" WHERE c.carga_academica=:carga_academica";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("carga_academica",$id);                                
         $nro_celdas_ca=$query->getSingleScalarResult();
        if($nro_celdas_ca==0){
            $hora=6;   
            $dias_festivos=array(5,6);
            for ($index = 0; $index <$nro_clase_dia ; $index++) {
                for ($index1 = -1; $index1 < 7; $index1++) {
                    $entity  = new CondicionContrato();
                    $entity->setDiaColumna($index1);
                    $entity->setHoraFila($index);
                    $entity->setCargaAcademica($this->getDoctrine()
                            ->getRepository("NetpublicCoreBundle:CargaAcademica")
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
     * Lists all CondicionContrato entities.
     *
     * @Route("/", name="condicioncontrato")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NetpublicCoreBundle:CondicionContrato')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a CondicionContrato entity.
     *
     * @Route("/{id}/show", name="condicioncontrato_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CondicionContrato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionContrato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new CondicionContrato entity.
     *
     * @Route("/new", name="condicioncontrato_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CondicionContrato();
        $form   = $this->createForm(new CondicionContratoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new CondicionContrato entity.
     *
     * @Route("/create", name="condicioncontrato_create")
     * @Method("POST")
     * @Template("NetpublicCoreBundle:CondicionContrato:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new CondicionContrato();
        $form = $this->createForm(new CondicionContratoType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('condicioncontrato_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CondicionContrato entity.
     *
     * @Route("/{id}/edit", name="condicioncontrato_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CondicionContrato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionContrato entity.');
        }

        $editForm = $this->createForm(new CondicionContratoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing CondicionContrato entity.
     *
     * @Route("/{id}/update", name="condicioncontrato_update")
     * @Method("POST")
     * @Template("NetpublicCoreBundle:CondicionContrato:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CondicionContrato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionContrato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CondicionContratoType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('condicioncontrato_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a CondicionContrato entity.
     *
     * @Route("/{id}/delete", name="condicioncontrato_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NetpublicCoreBundle:CondicionContrato')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CondicionContrato entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('condicioncontrato'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
