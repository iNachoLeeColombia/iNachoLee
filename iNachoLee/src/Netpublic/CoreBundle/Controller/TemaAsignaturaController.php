<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\TemaAsignatura;
use Netpublic\CoreBundle\Form\TemaAsignaturaType;

/**
 * TemaAsignatura controller.
 *
 * @Route("/temaasignatura")
 */
class TemaAsignaturaController extends Controller
{
    /**
     * Lists all TemaAsignatura entities.
     *
     * @Route("/{id_asignatura}", name="temaasignatura")
     * @Template()
     */
    public function indexAction($id_asignatura)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $deleteForm=array();
        //$entities = $em->getRepository('NetpublicCoreBundle:TemaAsignatura')->findl();
        $entities = $this->getDoctrine()->getRepository("NetpublicCoreBundle:TemaAsignatura")->findBy(array(
            'asignatura'=>$id_asignatura
        ));
        foreach ($entities as $e) {
            $deleteForm[] = $this->createDeleteForm($e->getId())->createView();
            
        } 
        return array('entities' => $entities,
            'delete_form'=>$deleteForm,
            'id_asignatura'=>$id_asignatura
            );
    }

    /**
     * Finds and displays a TemaAsignatura entity.
     *
     * @Route("/{id}/show", name="temaasignatura_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:TemaAsignatura')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TemaAsignatura entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new TemaAsignatura entity.
     *
     * @Route("/{id_asignatura}/new", name="temaasignatura_new")
     * @Template()
     */
    public function newAction($id_asignatura)
    {
        $entity = new TemaAsignatura();
        $form   = $this->createForm(new TemaAsignaturaType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'id_asignatura'=>$id_asignatura
        );
    }

    /**
     * Creates a new TemaAsignatura entity.
     *
     * @Route("/{id_asignatura}/create", name="temaasignatura_create")
     * @Method("post")
     * @Template("NetpublicCoreBundle:TemaAsignatura:new.html.twig")
     */
    public function createAction($id_asignatura)
    {
        $entity  = new TemaAsignatura();
        $request = $this->getRequest();
        $form    = $this->createForm(new TemaAsignaturaType(), $entity);
         $form->handleRequest($request);

        if ($form->isValid()) {
            $asignatura=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Asignatura")->find($id_asignatura);
            $entity->setAsignatura($asignatura);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            if($request->isXmlHttpRequest())
                return new \Symfony\Component\HttpFoundation\Response();
            return $this->redirect($this->generateUrl('temaasignatura_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing TemaAsignatura entity.
     *
     * @Route("/{id}/edit", name="temaasignatura_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:TemaAsignatura')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TemaAsignatura entity.');
        }

        $editForm = $this->createForm(new TemaAsignaturaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing TemaAsignatura entity.
     *
     * @Route("/{id}/update", name="temaasignatura_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:TemaAsignatura:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:TemaAsignatura')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TemaAsignatura entity.');
        }

        $editForm   = $this->createForm(new TemaAsignaturaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            if($request->isXmlHttpRequest())
                
            return new \Symfony\Component\HttpFoundation\Response("ok");
            return $this->redirect($this->generateUrl('temaasignatura_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a TemaAsignatura entity.
     *
     * @Route("/{id}/delete", name="temaasignatura_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:TemaAsignatura')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TemaAsignatura entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        return new \Symfony\Component\HttpFoundation\Response("ok");
        return $this->redirect($this->generateUrl('temaasignatura'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
