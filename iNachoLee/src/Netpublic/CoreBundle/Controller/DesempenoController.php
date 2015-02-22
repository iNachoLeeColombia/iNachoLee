<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\Desempeno;
use Netpublic\CoreBundle\Form\DesempenoType;
use Netpublic\CoreBundle\Entity\ActividadDesempeno;

/**
 * Desempeno controller.
 *
 * @Route("/desempeno")
 */
class DesempenoController extends Controller
{
    /**
     * Lists all Desempeno entities.
     *
     * @Route("/", name="desempeno")
     * @Template()
     */
    public function indexAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();        
        $user = $this->get('security.context')->getToken()->getUser(); 
        $periodo_id=$request->get("periodo_id");
        $grupo_id=$request->get("grupo_id");        
        $carga_id=$request->get("carga_id");
        $asignatura_id=$request->get("asignatura_id");
	$profesor_id=0;
        if(($user->getEsAlumno()==FALSE)){
            $profesor_id=$user->getProfesor()->getId();            
        }    
        $delete_form=array();
        $entities = $em->getRepository('NetpublicCoreBundle:Desempeno')->findBy(array(            
            'periodo'=>$periodo_id,
            'profesor'=>$profesor_id,            
            'asignatura'=>$carga_id                
        ));        
        foreach ($entities as $e) {
            $delete_form[] = $this->createDeleteForm($e->getId())->createView();
        }
        return array(
            'entities' => $entities,
            'delete_form'=>$delete_form,
            'periodo_id'=>$periodo_id,
            'grupo_id'=>$grupo_id,
            'carga_id'=>$carga_id,
            'asignatura_id'=>$asignatura_id
            );
    }

    /**
     * Finds and displays a Desempeno entity.
     *
     * @Route("/{id}/show", name="desempeno_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:Desempeno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Desempeno entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Desempeno entity.
     *
     * @Route("/new", name="desempeno_new")
     * @Template()
     */
    public function newAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();        
        $periodo_id=$request->get("periodo_id");
        $grupo_id=$request->get("grupo_id");        
        $carga_id=$request->get("carga_id");
        $asignatura_id=$request->get("asignatura_id");	
        $user = $this->get('security.context')->getToken()->getUser();
        if(($user->getEsAlumno()==FALSE)){
            $profesor_id=$user->getProfesor()->getId();
         }   
	
        $entity = new Desempeno();
        $asignatura=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($carga_id);
        $entity->setAsignatura($asignatura);
        
        $grupo=$em->getRepository("NetpublicCoreBundle:Grupo")->find($grupo_id);
        $entity->addGrupo($grupo);
        
        $form   = $this->createForm(new DesempenoType($profesor_id), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'periodo_id'=>$periodo_id,
            'grupo_id'=>$grupo_id,
            'carga_id'=>$carga_id,
            'asignatura_id'=>$asignatura_id
             
        );
    }

    /**
     * Creates a new Desempeno entity.
     *
     * @Route("/create", name="desempeno_create")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Desempeno:new.html.twig")
     */
    public function createAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $entity  = new Desempeno();
        $request = $this->getRequest();
        $user = $this->get('security.context')->getToken()->getUser();
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor();
            $profesor_id=$profesor->getId();
         }   
	
        
        $form    = $this->createForm(new DesempenoType($profesor_id), $entity);
         $form->handleRequest($request);
        $r="of";
        $session=$this->get('request')->getSession();
        if ($form->isValid()) {
            $entity->setProfesor($profesor);             
            $em->persist($entity);         
        $em->flush();
        $session->set("id_desempeno",$entity->getId());
        
        return new \Symfony\Component\HttpFoundation\Response("OssK");            
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Desempeno entity.
     *
     * @Route("/{id}/edit", name="desempeno_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();        
        $periodo_id=$request->get("periodo_id");
        $grupo_id=$request->get("grupo_id");        
        $carga_id=$request->get("carga_id");
        $asignatura_id=$request->get("asignatura_id");	

        $entity = $em->getRepository('NetpublicCoreBundle:Desempeno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Desempeno entity.');
        }

        $editForm = $this->createForm(new DesempenoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'periodo_id'=>$periodo_id,
            'grupo_id'=>$grupo_id,
            'carga_id'=>$carga_id,
            'asignatura_id'=>$asignatura_id

            );
    }

    /**
     * Edits an existing Desempeno entity.
     *
     * @Route("/{id}/update", name="desempeno_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:Desempeno:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $session=  $this->getRequest()->getSession();
        $session->set("id_desempeno",$id);
        $entity = $em->getRepository('NetpublicCoreBundle:Desempeno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Desempeno entity.');
        }

        $editForm   = $this->createForm(new DesempenoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            if($request->isXmlHttpRequest()){
                return new \Symfony\Component\HttpFoundation\Response("ok");
            }
            return $this->redirect($this->generateUrl('desempeno_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Desempeno entity.
     *
     * @Route("/{id}/delete", name="desempeno_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:Desempeno')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Desempeno entity.');
            }
            //Borramos todoslas notas en desempeños
            $entities = $em->getRepository('NetpublicCoreBundle:AlumnoDesempeno')->findBy(array(
                    'desempeno'=>$entity->getId()
                ));
                foreach ($entities as $e) {
                    $em->remove($e);
                }
            $entities = $em->getRepository('NetpublicCoreBundle:ActividadDesempeno')->findBy(array(
                    'desempeno'=>$entity->getId()
                ));
                foreach ($entities as $e) {
                    $em->remove($e);
                }    
            $em->remove($entity);
            $em->flush();
            if($request->isXmlHttpRequest()){
            return new \Symfony\Component\HttpFoundation\Response("Vok");
        }
        }
        if($request->isXmlHttpRequest()){
            return new \Symfony\Component\HttpFoundation\Response("ok");
        }
        return $this->redirect($this->generateUrl('desempeno'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
