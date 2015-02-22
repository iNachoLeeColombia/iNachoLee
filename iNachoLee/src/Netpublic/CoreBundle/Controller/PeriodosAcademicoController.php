<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\PeriodosAcademico;
use Netpublic\CoreBundle\Form\PeriodosAcademicoType;

/**
 * PeriodosAcademico controller.
 *
 * @Route("/periodosacademico")
 */
class PeriodosAcademicoController extends Controller
{
    /**
     * Lists all PeriodosAcademico entities.
     *
     * @Route("/", name="periodosacademico")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('NetpublicCoreBundle:PeriodosAcademico')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a PeriodosAcademico entity.
     *
     * @Route("/{id}/show", name="periodosacademico_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:PeriodosAcademico')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PeriodosAcademico entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new PeriodosAcademico entity.
     *
     * @Route("/new", name="periodosacademico_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PeriodosAcademico();
        $form   = $this->createForm(new PeriodosAcademicoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new PeriodosAcademico entity.
     *
     * @Route("/create", name="periodosacademico_create")
     * @Method("post")
     * @Template("NetpublicCoreBundle:PeriodosAcademico:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new PeriodosAcademico();
        $request = $this->getRequest();
        $form    = $this->createForm(new PeriodosAcademicoType(), $entity);
         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('periodosacademico_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing PeriodosAcademico entity.
     *
     * @Route("/{id}/edit", name="periodosacademico_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:PeriodosAcademico')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PeriodosAcademico entity.');
        }

        $editForm = $this->createForm(new PeriodosAcademicoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing PeriodosAcademico entity.
     *
     * @Route("/{id}/update", name="periodosacademico_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:PeriodosAcademico:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:PeriodosAcademico')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PeriodosAcademico entity.');
        }

        $editForm   = $this->createForm(new PeriodosAcademicoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('periodosacademico_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a PeriodosAcademico entity.
     *
     * @Route("/{id}/delete", name="periodosacademico_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:PeriodosAcademico')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PeriodosAcademico entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('periodosacademico'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
