<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\MensajeUsuario;
use Netpublic\CoreBundle\Form\MensajeUsuarioType;

/**
 * MensajeUsuario controller.
 *
 * @Route("/mensajeusuario")
 */
class MensajeUsuarioController extends Controller
{
    /**
     * Lists all MensajeUsuario entities.
     *
     * @Route("/", name="mensajeusuario")
     * @Template()
     */
    public function indexAction()
    {
        $deleteForm=array();
        $em = $this->getDoctrine()->getEntityManager();
        $remitente=$this->get('security.context')->getToken()->getUser();
         
          $repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:MensajeUsuario');        
            $query = $repository->createQueryBuilder('a');
            $query=$query->where("a.destinatario=:destinatario");
            $query=$query->setParameter("destinatario", $remitente->getId());
            $query=$query->orderBy('a.fecha_envio', 'DESC');
            $query=$query->getQuery();
        $entities= $query->getResult();
        foreach ($entities as $e) {
            $deleteForm[] = $this->createDeleteForm($e->getId())->createView();
            
        }
        return array(
            'entities' => $entities,
            'delete_form' =>$deleteForm,
            );
    }
    /**
     * Lists all MensajeUsuario entities.
     *
     * @Route("/enviados", name="mensajeusuario_enviados")
     * @Template()
     */
    public function indexenviadosAction()
    {
        $deleteForm=array();
        $em = $this->getDoctrine()->getEntityManager();
        $remitente=$this->get('security.context')->getToken()->getUser();
         
          $repository = $this->getDoctrine()
                        ->getRepository('NetpublicCoreBundle:MensajeUsuario');        
            $query = $repository->createQueryBuilder('a');
            $query=$query->where("a.remitente=:destinatario");
            $query=$query->setParameter("destinatario", $remitente->getId());
            $query=$query->getQuery();
       $entities= $query->getResult();
        foreach ($entities as $e) {
            $deleteForm[] = $this->createDeleteForm($e->getId())->createView();
            
        }
        return array(
            'entities' => $entities,
            'delete_form' =>$deleteForm
            );
    }


    /**
     * Finds and displays a MensajeUsuario entity.
     *
     * @Route("/{id}/show", name="mensajeusuario_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:MensajeUsuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MensajeUsuario entity.');
        }
        $entity->setEsLeido(TRUE);
        $em->persist($entity);
        $em->flush();
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new MensajeUsuario entity.
     *
     * @Route("/new", name="mensajeusuario_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new MensajeUsuario();
        $form   = $this->createForm(new MensajeUsuarioType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new MensajeUsuario entity.
     *
     * @Route("/create", name="mensajeusuario_create")
     * @Method("post")
     * @Template("NetpublicCoreBundle:MensajeUsuario:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new MensajeUsuario();
        $request = $this->getRequest();
        $form    = $this->createForm(new MensajeUsuarioType(), $entity);
         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mensajeusuario_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing MensajeUsuario entity.
     *
     * @Route("/{id}/edit", name="mensajeusuario_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:MensajeUsuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MensajeUsuario entity.');
        }

        $editForm = $this->createForm(new MensajeUsuarioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing MensajeUsuario entity.
     *
     * @Route("/{id}/update", name="mensajeusuario_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:MensajeUsuario:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:MensajeUsuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MensajeUsuario entity.');
        }

        $editForm   = $this->createForm(new MensajeUsuarioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mensajeusuario_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Edits an existing MensajeUsuario entity.
     *
     * @Route("/{id}/leido", name="mensajeusuario_leido")
     * @Method("post")
     * @Template()
     */
    public function leidoAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:MensajeUsuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MensajeUsuario entity.');
        }
        $entity->setEsLeido(TRUE);
        $em->persist($entity);
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response("ok");
        
    }
    /**
     * Deletes a MensajeUsuario entity.
     *
     * @Route("/{id}/delete", name="mensajeusuario_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

         $form->handleRequest($request);
        $resultado="error";
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:MensajeUsuario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MensajeUsuario entity.');
            }

            $em->remove($entity);
            $em->flush();
            $resultado="ok";
        }
        return new \Symfony\Component\HttpFoundation\Response($resultado);
        //return $this->redirect($this->generateUrl('mensajeusuario'));
    }
    /**
     * Deletes a MensajeUsuario entity.
     *
     * @Route("/numeromensaje", name="mensajeusuario_numeromensaje")
     * @Method("post")
     * @Template()
     */
    public function numeromensajeAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $remitente=$this->get('security.context')->getToken()->getUser();
        $query = $em->createQuery('SELECT count(a) FROM NetpublicCoreBundle:MensajeUsuario a JOIN a.mensaje m WHERE a.destinatario=:destinatario AND a.es_leido=0 AND m.tipo=0')
                            ->setParameter(
                            "destinatario",$remitente->getId()  
                            );
        $count_tipo_informativo = $query->getSingleScalarResult();
        $query = $em->createQuery('SELECT count(a) FROM NetpublicCoreBundle:MensajeUsuario a JOIN a.mensaje m WHERE a.destinatario=:destinatario AND a.es_leido=0 AND m.tipo=1')
                            ->setParameter(
                            "destinatario",$remitente->getId()  
                            );
       $count_tipo_error = $query->getSingleScalarResult();
       $query = $em->createQuery('SELECT count(a) FROM NetpublicCoreBundle:MensajeUsuario a JOIN a.mensaje m WHERE a.destinatario=:destinatario AND a.es_leido=0 AND m.tipo=2')
                            ->setParameter(
                            "destinatario",$remitente->getId()  
                            );
       $count_tipo_felicitaciones = $query->getSingleScalarResult();                 
       //Mensaje de envio de Boletines
       $query = $em->createQuery('SELECT count(a) FROM NetpublicCoreBundle:MensajeUsuario a JOIN a.mensaje m WHERE a.destinatario=:destinatario AND a.es_leido=0 AND m.tipo=3')
                            ->setParameter(
                            "destinatario",$remitente->getId()  
                            );
       $count_tipo_boletines = $query->getSingleScalarResult();                 

             $data = array(
                 "mensajes_importantes" => $count_tipo_error,
                 "mensajes_informaciones" => $count_tipo_informativo,
                 "mensajes_felicitaciones" => $count_tipo_felicitaciones,
                 'mensajes_boletines'=>$count_tipo_boletines
                 );
             /*$data[1] = array("mensajes_informaciones" => $count);
             $data[2] = array("mensajes_felicitaciones" => $count);*/
            
         return new \Symfony\Component\HttpFoundation\Response(json_encode($data));
    }
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
