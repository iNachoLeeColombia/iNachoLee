<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\Observacion;
use Netpublic\CoreBundle\Form\ObservacionType;
use \DateTime;

/**
 * Observacion controller.
 *
 * @Route("/observacion")
 */
class ObservacionController extends Controller
{
    /**
     * Lists all Observacion entities.
     *
     * @Route("/{id_alumno}/customindex", name="observacion_customindex")
     * @Template()
     */
    public function customindexAction($id_alumno)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('NetpublicCoreBundle:Observacion')->findBy(array(
            'alumno'=>$id_alumno
        ));

        return array(
            'entities' => $entities,
            'alumno_id'=>$id_alumno
         );
    }

    /**
     * Finds and displays a Observacion entity.
     *
     * @Route("/{id}/show", name="observacion_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Observacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Observacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Observacion entity.
     *
     * @Route("/{id_alumno}/new", name="observacion_new")
     * @Template()
     */
    public function newAction($id_alumno)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = new Observacion();
        $ano_escolar_activo=  $this->getDoctrine()
                            ->getRepository("NetpublicCoreBundle:Dimension")
                            ->findAnoEscolarActivo();                
        $form   = $this->createForm(new ObservacionType($ano_escolar_activo->getId()), $entity);
            $alumno = $em->getRepository('NetpublicCoreBundle:Alumno')->find($id_alumno);
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'alumno'=>$alumno
        );
    }

    /**
     * Creates a new Observacion entity.
     *
     * @Route("/{id_alumno}/create", name="observacion_create")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Observacion:new.html.twig")
     */
    public function createAction($id_alumno)
    {
        $entity  = new Observacion();
        $request = $this->getRequest();
           $ano_escolar_activo=  $this->getDoctrine()
                            ->getRepository("NetpublicCoreBundle:Dimension")
                            ->findAnoEscolarActivo();                
        $form    = $this->createForm(
                new ObservacionType($ano_escolar_activo->getId())
                , $entity);
         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();                        
            $alumno = $em->getRepository('NetpublicCoreBundle:Alumno')->find($id_alumno);
            $entity->setAlumno($alumno);
            //Enviamos notificación a Acudiente
            $acudiente=$alumno->getAcudiente();
            
            $user = $this->get('security.context')->getToken()->getUser();   
           
                            $m=new \Netpublic\CoreBundle\Entity\Mensaje();
                            $m->setAsunto("Observación Del OBSERVADOR");
                            $m->setCuerpoHtml($entity->getContenido());
                            $m->setDestino("Dios");
                            $m->setTipo(1);
                            $em->persist($m);
                            if($acudiente){
                            $mensaje=new \Netpublic\CoreBundle\Entity\MensajeUsuario();
                            $mensaje->setMensaje($m);
                            $mensaje->setEsLeido(FALSE);
                            $mensaje->setFechaEnvio(new DateTime('now'));
                            $mensaje->setRemitente($user);
                            $mensaje->setDestinatario($acudiente->getUsuario());
                            $em->persist($mensaje);
                            }
            if(($user->getEsAlumno()==FALSE)){
                
                $profesor=$user->getProfesor();                        
                 $entity->setDueno($profesor);
            }            
            $em->persist($entity);
            $em->flush();

        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'alumno'=>$alumno
        );
    }

    /**
     * Displays a form to edit an existing Observacion entity.
     *
     * @Route("/{id}/edit", name="observacion_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Observacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Observacion entity.');
        }
        $ano_escolar_activo=  $this
                             ->getDoctrine()
                            ->getRepository("NetpublicCoreBundle:Dimension")
                            ->findPeriodoEscolarActivo();                
        
        $editForm = $this->createForm(
                new ObservacionType($ano_escolar_activo->getId()),
                $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Observacion entity.
     *
     * @Route("/{id}/update", name="observacion_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Observacion:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Observacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Observacion entity.');
        }
           $ano_escolar_activo=  $this->getDoctrine()
                            ->getRepository("NetpublicCoreBundle:Dimension")
                            ->findAnoEscolarActivo();                
        $editForm   = $this->createForm(
                new ObservacionType($ano_escolar_activo->getId()),
                $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            //return $this->redirect($this->generateUrl('observacion_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Observacion entity.
     *
     * @Route("/{id}/delete", name="observacion_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:Observacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Observacion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
return new \Symfony\Component\HttpFoundation\Response("OK");
        //return $this->redirect($this->generateUrl('observacion'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
