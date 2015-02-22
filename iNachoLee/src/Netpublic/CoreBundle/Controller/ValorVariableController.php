<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\ValorVariable;
use Netpublic\CoreBundle\Form\ValorVariableType;

/**
 * ValorVariable controller.
 *
 * @Route("/valorvariable")
 */
class ValorVariableController extends Controller
{
    /**
     * Lists all ValorVariable entities.
     *
     * @Route("/", name="valorvariable")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('NetpublicCoreBundle:ValorVariable')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a ValorVariable entity.
     *
     * @Route("/{id}/show", name="valorvariable_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:ValorVariable')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ValorVariable entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new ValorVariable entity.
     *
     * @Route("/new", name="valorvariable_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ValorVariable();
        $form   = $this->createForm(new ValorVariableType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new ValorVariable entity.
     *
     * @Route("/create", name="valorvariable_create")
     * @Method("post")
     * @Template("NetpublicCoreBundle:ValorVariable:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new ValorVariable();
        $request = $this->getRequest();
        $form    = $this->createForm(new ValorVariableType(), $entity);
         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('valorvariable_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing ValorVariable entity.
     *
     * @Route("/{id}/edit", name="valorvariable_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:ValorVariable')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ValorVariable entity.');
        }

        $editForm = $this->createForm(new ValorVariableType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing ValorVariable entity.
     *
     * @Route("/{id}/update", name="valorvariable_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:ValorVariable:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:ValorVariable')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ValorVariable entity.');
        }

        $editForm   = $this->createForm(new ValorVariableType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('valorvariable_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ValorVariable entity.
     *
     * @Route("/{id}/delete", name="valorvariable_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:ValorVariable')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ValorVariable entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('valorvariable'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
