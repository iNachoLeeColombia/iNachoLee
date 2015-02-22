<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\Anoescolargrado;
use Netpublic\CoreBundle\Form\AnoescolargradoType;

/**
 * Anoescolargrado controller.
 *
 * @Route("/anoescolargrado")
 */
class AnoescolargradoController extends Controller
{

    /**
     * Lists all Anoescolargrado entities.
     *
     * @Route("/", name="anoescolargrado")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NetpublicCoreBundle:Anoescolargrado')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Anoescolargrado entity.
     *
     * @Route("/", name="anoescolargrado_create")
     * @Method("POST")
     * @Template("NetpublicCoreBundle:Anoescolargrado:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Anoescolargrado();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('anoescolargrado_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Anoescolargrado entity.
    *
    * @param Anoescolargrado $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Anoescolargrado $entity)
    {
        $form = $this->createForm(new AnoescolargradoType(), $entity, array(
            'action' => $this->generateUrl('anoescolargrado_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Anoescolargrado entity.
     *
     * @Route("/new", name="anoescolargrado_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Anoescolargrado();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Anoescolargrado entity.
     *
     * @Route("/{id}", name="anoescolargrado_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Anoescolargrado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Anoescolargrado entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Anoescolargrado entity.
     *
     * @Route("/{id}/edit", name="anoescolargrado_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Anoescolargrado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Anoescolargrado entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Anoescolargrado entity.
    *
    * @param Anoescolargrado $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Anoescolargrado $entity)
    {
        $form = $this->createForm(new AnoescolargradoType(), $entity, array(
            'action' => $this->generateUrl('anoescolargrado_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Anoescolargrado entity.
     *
     * @Route("/{id}", name="anoescolargrado_update")
     * @Method("PUT")
     * @Template("NetpublicCoreBundle:Anoescolargrado:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Anoescolargrado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Anoescolargrado entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('anoescolargrado_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Anoescolargrado entity.
     *
     * @Route("/{id}", name="anoescolargrado_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NetpublicCoreBundle:Anoescolargrado')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Anoescolargrado entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('anoescolargrado'));
    }

    /**
     * Creates a form to delete a Anoescolargrado entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('anoescolargrado_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
