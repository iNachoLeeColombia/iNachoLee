<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\Foto;
use Netpublic\CoreBundle\Form\FotoType;

/**
 * Foto controller.
 *
 * @Route("/foto")
 */
class FotoController extends Controller
{
    /**
     * Lists all Foto entities.
     *
     * @Route("/", name="foto")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('NetpublicCoreBundle:Foto')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Foto entity.
     *
     * @Route("/{id}/show", name="foto_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Foto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Foto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Foto entity.
     *
     * @Route("/new", name="foto_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Foto();
        $form   = $this->createForm(new FotoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Foto entity.
     *
     * @Route("/create", name="foto_create")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Foto:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Foto();
        $request = $this->getRequest();
        $form    = $this->createForm(new FotoType(), $entity);
         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            //$entity->upload();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('foto_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Foto entity.
     *
     * @Route("/{id}/edit", name="foto_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Foto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Foto entity.');
        }

        $editForm = $this->createForm(new FotoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Foto entity.
     *
     * @Route("/{id}/update", name="foto_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Foto:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Foto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Foto entity.');
        }

        $editForm   = $this->createForm(new FotoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('foto_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Foto entity.
     *
     * @Route("/{id}/delete", name="foto_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:Foto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Foto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('foto'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
