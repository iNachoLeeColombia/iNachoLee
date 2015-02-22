<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\Variable;
use Netpublic\CoreBundle\Form\VariableType;

/**
 * Variable controller.
 *
 * @Route("/variable")
 */
class VariableController extends Controller
{
    /**
     * Lists all Variable entities.
     *
     * @Route("/", name="variable")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('NetpublicCoreBundle:Variable')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Variable entity.
     *
     * @Route("/{id}/show", name="variable_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Variable')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Variable entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Variable entity.
     *
     * @Route("/new", name="variable_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Variable();
        $form   = $this->createForm(new VariableType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Variable entity.
     *
     * @Route("/create", name="variable_create")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Variable:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Variable();
        $request = $this->getRequest();
        $form    = $this->createForm(new VariableType(), $entity);
         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('variable_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Variable entity.
     *
     * @Route("/{id}/edit", name="variable_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Variable')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Variable entity.');
        }

        $editForm = $this->createForm(new VariableType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Variable entity.
     *
     * @Route("/{id}/update", name="variable_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Variable:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Variable')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Variable entity.');
        }

        $editForm   = $this->createForm(new VariableType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('variable_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Variable entity.
     *
     * @Route("/{id}/delete", name="variable_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:Variable')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Variable entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('variable'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
