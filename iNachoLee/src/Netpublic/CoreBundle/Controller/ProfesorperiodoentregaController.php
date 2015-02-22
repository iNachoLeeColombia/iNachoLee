<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\Profesorperiodoentrega;
use Netpublic\CoreBundle\Form\ProfesorperiodoEntregaType;
/**
 * Profesor controller.
 *
 * @Route("/profesorperiodoentrega")
 */

class ProfesorperiodoentregaController extends Controller
{
   
 /**
     * Lists all Profesorperiodoentrega entities.
     *
     * @Route("/editfiltros", name="profesorperiodoentrega_editfiltros")
     * @Template()
     */
    
    public function editfiltrosAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $id_todos=$em->getRepository("NetpublicCoreBundle:Profesorperiodoentrega")->findAll();
        $id=$id_todos[0]->getId();
         $ano_escolar_activo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                      ->findOneBy(array(
                          'tipo'=>0,
                          'es_ano_escolar'=>1
                      ));
        $entity = $em->getRepository('NetpublicCoreBundle:Profesorperiodoentrega')->find($id);
        $profesor=$entity->getProfesor();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Profesorperiodoentrega entity.');
        }

        $editForm = $this->createForm(new ProfesorperiodoEntregaType($ano_escolar_activo->getId(),$profesor->getId()), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'profesor'=>$profesor,
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'es_ajax' => FALSE
        );
   
        return new \Symfony\Component\HttpFoundation\Response($id);
    }
    /**
     * Lists all Profesorperiodoentrega entities.
     *
     * @Route("/{id_profesor}/entregas", name="profesorperiodoentrega")
     * @Template()
     */
    
    public function indexAction($id_profesor)
    {
        $em = $this->getDoctrine()->getEntityManager();
                
                 
            $entities = $em->getRepository('NetpublicCoreBundle:Profesorperiodoentrega')->findBy(array(
                'profesor'=>$id_profesor
            ));
            $deleteForm=array();
            foreach ($entities as $e) {
                $deleteForm[] = $this->createDeleteForm($e->getId())->createView();
            }
        
        return array(
            'entities' => $entities,
            'profesor_id'=>$id_profesor,
            'delete_form' =>$deleteForm 
            );
    }

    /**
     * Finds and displays a Profesorperiodoentrega entity.
     *
     * @Route("/{id}/show", name="profesorperiodoentrega_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Profesorperiodoentrega')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Profesorperiodoentrega entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Profesorperiodoentrega entity.
     *
     * @Route("/{id_profesor}/new", name="profesorperiodoentrega_new")
     * @Template()
     */
    public function newAction($id_profesor)
    {
         $ano_escolar_activo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                      ->findOneBy(array(
                          'tipo'=>0,
                          'es_ano_escolar'=>1
                      ));
        $entity = new Profesorperiodoentrega();
        $form   = $this->createForm(new ProfesorperiodoEntregaType($ano_escolar_activo->getId(),$id_profesor), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'id_profesor'=>$id_profesor
        );
    }

    /**
     * Creates a new Profesorperiodoentrega entity.
     *
     * @Route("/{profesor_id}/create", name="profesorperiodoentrega_create")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Profesorperiodoentrega:new.html.twig")
     */
    public function createAction($profesor_id)
    {
           $ano_escolar_activo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                      ->findOneBy(array(
                          'tipo'=>0,
                          'es_ano_escolar'=>1
                      ));
        $entity  = new Profesorperiodoentrega();
        $request = $this->getRequest();
        $form    = $this->createForm(new ProfesorperiodoEntregaType($ano_escolar_activo->getId(),$profesor_id), $entity);
         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            if($request->isXmlHttpRequest()){
                return new \Symfony\Component\HttpFoundation\Response('ok');
            }
            return $this->redirect($this->generateUrl('profesorperiodoentrega_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Profesorperiodoentrega entity.
     *
     * @Route("/{id}/edit", name="profesorperiodoentrega_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
         $ano_escolar_activo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                      ->findOneBy(array(
                          'tipo'=>0,
                          'es_ano_escolar'=>1
                      ));
        $entity = $em->getRepository('NetpublicCoreBundle:Profesorperiodoentrega')->find($id);
        $profesor=$entity->getProfesor();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Profesorperiodoentrega entity.');
        }

        $editForm = $this->createForm(new ProfesorperiodoEntregaType($ano_escolar_activo->getId(),$profesor->getId()), $entity);
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'profesor'=>$profesor,
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'es_ajax' => FALSE
        );
    }

    /**
     * Edits an existing Profesorperiodoentrega entity.
     *
     * @Route("/{id}/update", name="profesorperiodoentrega_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Profesorperiodoentrega:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
          $ano_escolar_activo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                      ->findOneBy(array(
                          'tipo'=>0,
                          'es_ano_escolar'=>1
                      ));
        $entity = $em->getRepository('NetpublicCoreBundle:Profesorperiodoentrega')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Profesorperiodoentrega entity.');
        }

        $editForm   = $this->createForm(new ProfesorperiodoEntregaType($ano_escolar_activo->getId(),$entity->getProfesor()->getId()), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            if($request->isXmlHttpRequest())
                return new \Symfony\Component\HttpFoundation\Response("ok");
            return $this->redirect($this->generateUrl('profesorperiodoentrega_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Profesorperiodoentrega entity.
     *
     * @Route("/{id}/delete", name="profesorperiodoentrega_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:Profesorperiodoentrega')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Profesorperiodoentrega entity.');
            }

            $em->remove($entity);
            $em->flush();
            if($request->isXmlHttpRequest())
                return new \Symfony\Component\HttpFoundation\Response("ok");
        }

        return $this->redirect($this->generateUrl('Profesorperiodoentrega'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
