<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\CriterioPromocion;
use Netpublic\CoreBundle\Form\CriterioPromocionType;

/**
 * CriterioPromocion controller.
 *
 * @Route("/criteriopromocion")
 */
class CriterioPromocionController extends Controller
{
      /**
     * Lists all CriterioPromocion entities.
     *
     * @Route("/{id_padre}/{id_hijo}/{simbolo}/unir", name="criteriopromocion_unir")
     * @Template()
     */
    public function unirAction($id_padre,$id_hijo,$simbolo)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $padre=  $this->getDoctrine()
                      ->getRepository("NetpublicCoreBundle:CriterioPromocion")
                      ->find($id_padre);
        $hijo=  $this->getDoctrine()
                      ->getRepository("NetpublicCoreBundle:CriterioPromocion")
                      ->find($id_hijo);
        $hijo->setCriterioPromocion($padre);
        $padre->setCriterioPromocion($padre);
        $hijo->setSimbolo($simbolo);
        $em->persist($hijo);
        $em->persist($padre);
        $em->flush();
      return new \Symfony\Component\HttpFoundation\Response("Ok");
    
    }
    /**
     * Lists all CriterioPromocion entities.
     *
     * @Route("/", name="criteriopromocion")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm=array();
        $entities= $em->getRepository('NetpublicCoreBundle:CriterioPromocion')->findAll();
        

        foreach ($entities as $entity) {                    ;
            $deleteForm[] = $this->createDeleteForm($entity->getId())->createView();
        }        

        return array(
            'entities' => $entities,            
            'delete_form' => $deleteForm
        );
    }

    /**
     * Finds and displays a CriterioPromocion entity.
     *
     * @Route("/{id}/show", name="criteriopromocion_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CriterioPromocion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CriterioPromocion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new CriterioPromocion entity.
     *
     * @Route("/new", name="criteriopromocion_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CriterioPromocion();
        $form   = $this->createForm(new CriterioPromocionType(), $entity);
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new CriterioPromocion entity.
     *
     * @Route("/create", name="criteriopromocion_create")
     * @Method("POST")
     * @Template("NetpublicCoreBundle:CriterioPromocion:new.html.twig")
     */
    public function createAction()
    {
        $request=  $this->getRequest();
        $entity  = new CriterioPromocion();
        $form = $this->createForm(new CriterioPromocionType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('criteriopromocion'));
        }
        

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CriterioPromocion entity.
     *
     * @Route("/{id}/edit", name="criteriopromocion_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CriterioPromocion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CriterioPromocion entity.');
        }
        
        //$editForm = $this->createForm(new CriterioPromocionType(), $entity);
        //$deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
           // 'delete_form' => $deleteForm->createView(),
        );
    }
    /**
    * Creates a form to edit a Anoescolargrado entity.
    *
    * @param Anoescolargrado $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CriterioPromocion $entity)
    {
        $form = $this->createForm(new CriterioPromocionType(), $entity, array(
            'action' => $this->generateUrl('criteriopromocion_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    

    /**
     * Edits an existing CriterioPromocion entity.
     *
     * @Route("/{id}/update", name="criteriopromocion_update")
     * @Method("POST")
     * @Template("NetpublicCoreBundle:CriterioPromocion:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CriterioPromocion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CriterioPromocion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CriterioPromocionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

       //     return $this->redirect($this->generateUrl('criteriopromocion_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a CriterioPromocion entity.
     *
     * @Route("/{id}/delete", name="criteriopromocion_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:CriterioPromocion')->find($id);            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CriterioPromocion entity.');
            }
            
            $em->remove($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('colegio_gestionarpromover'));
       
        }

        return $this->redirect($this->generateUrl('criteriopromocion'));
    }

     private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('criteriopromocion_delete', array('id' => $id)))
            ->setMethod('POST')
                
            ->add('submit', 'submit', array('label' => 'Eliminar'))
            ->getForm()
        ;
    }

}
