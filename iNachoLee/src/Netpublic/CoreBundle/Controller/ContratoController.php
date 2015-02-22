<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\Contrato;
use Netpublic\CoreBundle\Form\ContratoType;

/**
 * Contrato controller.
 *
 * @Route("/contrato")
 */
class ContratoController extends Controller
{
    
    /**
     * Displays a form to edit an existing Contrato entity.
     *
     * @Route("/{id_profesor}/profesor", name="contrato_profesor")
     * @Template()
     */
    public function profesorAction($id_profesor)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Contrato")->findBy(array(
            'profesor_contrato'=>$id_profesor
        ));     
        
        
        return array(
            'entities'      => $entities            
        );
    }
    /**
     * Lists all Contrato entities.
     *
     * @Route("/", name="contrato")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $entities = $em->getRepository('NetpublicCoreBundle:Contrato')->findAll();
        $es_ajax=false;
        $delete_form=array();
        if($request->isXmlHttpRequest())
            $es_ajax=true;
        foreach ($entities as $e) {
            $delete_form[] = $this->createDeleteForm($e->getId())->createView();
        }
        return array(
            'entities' => $entities,
            'es_ajax' =>$es_ajax,
            'delete_form'=>$delete_form
            );
    }

    /**
     * Finds and displays a Contrato entity.
     *
     * @Route("/{id}/show", name="contrato_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Contrato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contrato entity.');
        }
        $session=$this->get('request')->getSession();
            $id_profesor=$session->get('id_profesor_profesor');
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),  
            'id_profesor_profesor'=>$id_profesor
            );
    }

    /**
     * Displays a form to create a new Contrato entity.
     *
     * @Route("/new", name="contrato_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Contrato();
        $form   = $this->createForm(new ContratoType(), $entity);
        $request=  $this->getRequest();
        $es_ajax=false;
        if($request->isXmlHttpRequest())
            $es_ajax=true;
        $session=$this->get('request')->getSession();
        $id_profesor=$session->get('id_profesor_profesor');
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'es_ajax' => $es_ajax,
            'id_profesor_profesor'=>$id_profesor
        );
    }

    /**
     * Creates a new Contrato entity.
     *
     * @Route("/create", name="contrato_create")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Contrato:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Contrato();
        $request = $this->getRequest();
        $form    = $this->createForm(new ContratoType(), $entity);
         $form->handleRequest($request);
                 
        $entity->setHorasBuffer($entity->getHorasContratadas());
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $session=$this->get('request')->getSession();
            $id_profesor=$session->get('id_profesor_profesor');
            $profesor=$em->getRepository('NetpublicCoreBundle:Profesor')->find($id_profesor);
            $entity->setProfesorContrato($profesor);
            $em->persist($profesor);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contrato_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Contrato entity.
     *
     * @Route("/{id}/edit", name="contrato_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Contrato')->find($id);
        $request=  $this->getRequest();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contrato entity.');
        }
         $es_ajax=false;
        if($request->isXmlHttpRequest())
            $es_ajax=true;
        $editForm = $this->createForm(new ContratoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        $session=$this->get('request')->getSession();
        $id_profesor=$session->get('id_profesor_profesor');
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'es_ajax'     =>$es_ajax,
            'id_profesor_profesor'=>$id_profesor
        );
    }
   /**
     * Displays a form to edit an existing Contrato entity.
     *
     * @Route("/{id_asignatura}/getcontrato", name="contrato_getcontrato")
     * @Template()
     */
    public function getcontratoAction($id_asignatura)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('NetpublicCoreBundle:Contrato')->findBy(array(
            'asignatura'=>$id_asignatura
        ));
        
        return array(
            'entities'      => $entities
         
        );
    }

    /**
     * Edits an existing Contrato entity.
     *
     * @Route("/{id}/update", name="contrato_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Contrato:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Contrato')->find($id);
        
                    if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contrato entity.');
        }

        $editForm   = $this->createForm(new ContratoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);
        
        if ($editForm->isValid()) {
            $entity->setHorasBuffer($entity->getHorasContratadas());
            
            $em->persist($entity);
            $em->flush();
            return new \Symfony\Component\HttpFoundation\Response("ok");
            //return $this->redirect($this->generateUrl('contrato_edit', array('id' => $id)));
        }
       
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            
        );
    }

    /**
     * Deletes a Contrato entity.
     *
     * @Route("/{id}/delete", name="contrato_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:Contrato')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Contrato entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return new \Symfony\Component\HttpFoundation\Response("ok");
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
