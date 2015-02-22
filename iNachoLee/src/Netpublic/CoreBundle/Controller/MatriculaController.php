<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\Matricula;
use Netpublic\CoreBundle\Form\MatriculaType;

/**
 * Matricula controller.
 *
 * @Route("/matricula")
 */
class MatriculaController extends Controller
{
    /**
     * Lists all Matricula entities.
     *
     * @Route("/", name="matricula")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('NetpublicCoreBundle:Matricula')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Matricula entity.
     *
     * @Route("/{id}/show", name="matricula_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Matricula')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Matricula entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Matricula entity.
     *
     * @Route("/new", name="matricula_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Matricula();
        $form   = $this->createForm(new MatriculaType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Matricula entity.
     *
     * @Route("/create", name="matricula_create")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Matricula:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Matricula();
        $request = $this->getRequest();
        $form    = $this->createForm(new MatriculaType(), $entity);
         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('matricula_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Matricula entity.
     *
     * @Route("/{id}/edit", name="matricula_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Matricula')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Matricula entity.');
        }

        $editForm = $this->createForm(new MatriculaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Matricula entity.
     *
     * @Route("/{id}/update", name="matricula_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Matricula:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Matricula')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Matricula entity.');
        }

        $editForm   = $this->createForm(new MatriculaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('matricula_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Matricula entity.
     *
     * @Route("/{id}/delete", name="matricula_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:Matricula')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Matricula entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('matricula'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
