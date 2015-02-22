<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\AspectoEvaluar;
use Netpublic\CoreBundle\Form\AspectoEvaluarType;

/**
 * AspectoEvaluar controller.
 *
 * @Route("/aspectoevaluar")
 */
class AspectoEvaluarController extends Controller
{
    /**
     * Lists all AspectoEvaluar entities.
     *
     * @Route("/", name="aspectoevaluar")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('NetpublicCoreBundle:AspectoEvaluar')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a AspectoEvaluar entity.
     *
     * @Route("/{id}/show", name="aspectoevaluar_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:AspectoEvaluar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AspectoEvaluar entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new AspectoEvaluar entity.
     *
     * @Route("/new", name="aspectoevaluar_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new AspectoEvaluar();
        $form   = $this->createForm(new AspectoEvaluarType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new AspectoEvaluar entity.
     *
     * @Route("/create", name="aspectoevaluar_create")
     * @Method("post")
     * @Template("NetpublicCoreBundle:AspectoEvaluar:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new AspectoEvaluar();
        $request = $this->getRequest();
        $form    = $this->createForm(new AspectoEvaluarType(), $entity);
         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('aspectoevaluar_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing AspectoEvaluar entity.
     *
     * @Route("/{id}/edit", name="aspectoevaluar_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:AspectoEvaluar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AspectoEvaluar entity.');
        }

        $editForm = $this->createForm(new AspectoEvaluarType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing AspectoEvaluar entity.
     *
     * @Route("/{id}/update", name="aspectoevaluar_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:AspectoEvaluar:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:AspectoEvaluar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AspectoEvaluar entity.');
        }

        $editForm   = $this->createForm(new AspectoEvaluarType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('aspectoevaluar_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a AspectoEvaluar entity.
     *
     * @Route("/{id}/delete", name="aspectoevaluar_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:AspectoEvaluar')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AspectoEvaluar entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('aspectoevaluar'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
