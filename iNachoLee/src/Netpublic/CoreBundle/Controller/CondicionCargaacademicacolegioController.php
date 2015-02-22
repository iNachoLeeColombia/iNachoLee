<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\CondicionCargaacademicacolegio;
use Netpublic\CoreBundle\Form\CondicionCargaacademicacolegioType;
/**
 * CondicionCargaacademicacolegio controller.
 *
 * @Route("/condicioncargaacademicacolegio")
 */
class CondicionCargaacademicacolegioController extends Controller
{
     /**
     * Lists all CondicionCargaacademicacolegio entities.
     *
     * @Route("/{nro_clase}/ver", name="condicioncargaacademicacolegio_ver")
     * @Template()
     */
    public function verAction($nro_clase)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $clases_hora=array();
        for ($index = 0; $index < $nro_clase; $index++) {
            $clases_hora[]=$h_c_profesor=$this->getDoctrine()
                            ->getRepository("NetpublicCoreBundle:CondicionCargaacademicacolegio")
                            ->findBy(array(                            
                            "hora_fila"=>$index                                    
                                ));
        
        }
        return array(            
            'clases_hora'=>$clases_hora
        
            );

    
    }
    
     /**
     * Lists all CondicionCargaacademicacolegio entities.
     *
     * @Route("/{tipo}/{id}/cambiarestado", name="condicioncargaacademicacolegio_cambiarestado")
     * @Template()
     */
    public function cambiarestadoAction($tipo,$id)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $celda=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:CondicionCargaAcademicacolegio")
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
     * @Route("/{tipo}/{columna}/cambiarestadocolumna", name="condicioncargaacademicacolegio_cambiarestadocolumna")
     * @Template()
     */
    public function cambiarestadocolumnaAction($tipo,$columna)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $celdas=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:CondicionCargaAcademicacolegio")
                       ->findBy(array(
                           'dia_columna'=>$columna
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
     * @Route("/{tipo}/{fila}/cambiarestadofila", name="condicioncargaacademicacolegio_cambiarestadofila")
     * @Template()
     */
    public function cambiarestadofilaAction($tipo,$fila)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="UPDATE NetpublicCoreBundle:CondicionCargaAcademicacolegio c";
        $dql.=" SET c.tipo=:tipo WHERE";
        $dql.=" (c.hora_fila=:fila AND c.tipo=0) OR (c.hora_fila=:fila AND c.tipo=1)";
        $query=$em->createQuery($dql);
        $query=$query->setParameter('tipo', $tipo);
        $query=$query->setParameter("fila", $fila);
        $celdas=$query->execute();                        
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response("ok");
    }



     /**
     * Lists all CondicionCargaacademicacolegio entities.
     *
     * @Route("/{nro_clase_dia}/generarhorario", name="condicioncargaacademicacolegio_generarhorario")
     * @Template()
     */
    public function generarhorarioAction($nro_clase_dia)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $query=$em->createQuery("DELETE from NetpublicCoreBundle:CondicionCargaacademicacolegio");
        $query->execute();
        $hora=6;   
        $dias_festivos=array(5,6);
        for ($index = 0; $index <$nro_clase_dia ; $index++) {
            for ($index1 = -1; $index1 < 7; $index1++) {
                $entity  = new CondicionCargaacademicacolegio();
                $entity->setDiaColumna($index1);
                $entity->setHoraFila($index);
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
     $em->flush();    
     return new \Symfony\Component\HttpFoundation\Response("ok");
    }

    /**
     * Lists all CondicionCargaacademicacolegio entities.
     *
     * @Route("/", name="condicioncargaacademicacolegio")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NetpublicCoreBundle:CondicionCargaacademicacolegio')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a CondicionCargaacademicacolegio entity.
     *
     * @Route("/{id}/show", name="condicioncargaacademicacolegio_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CondicionCargaacademicacolegio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionCargaacademicacolegio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new CondicionCargaacademicacolegio entity.
     *
     * @Route("/new", name="condicioncargaacademicacolegio_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CondicionCargaacademicacolegio();
        $form   = $this->createForm(new CondicionCargaacademicacolegioType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new CondicionCargaacademicacolegio entity.
     *
     * @Route("/create", name="condicioncargaacademicacolegio_create")
     * @Method("POST")
     * @Template("NetpublicCoreBundle:CondicionCargaacademicacolegio:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new CondicionCargaacademicacolegio();
        $form = $this->createForm(new CondicionCargaacademicacolegioType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('condicioncargaacademicacolegio_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CondicionCargaacademicacolegio entity.
     *
     * @Route("/{id}/edit", name="condicioncargaacademicacolegio_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CondicionCargaacademicacolegio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionCargaacademicacolegio entity.');
        }

        $editForm = $this->createForm(new CondicionCargaacademicacolegioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing CondicionCargaacademicacolegio entity.
     *
     * @Route("/{id}/update", name="condicioncargaacademicacolegio_update")
     * @Method("POST")
     * @Template("NetpublicCoreBundle:CondicionCargaacademicacolegio:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CondicionCargaacademicacolegio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionCargaacademicacolegio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CondicionCargaacademicacolegioType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('condicioncargaacademicacolegio_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a CondicionCargaacademicacolegio entity.
     *
     * @Route("/{id}/delete", name="condicioncargaacademicacolegio_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NetpublicCoreBundle:CondicionCargaacademicacolegio')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CondicionCargaacademicacolegio entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('condicioncargaacademicacolegio'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
