<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\ActividadDesempeno;
use Netpublic\CoreBundle\Form\ActividadDesempenoType;
use Netpublic\CoreBundle\Entity\AlumnoDesempeno;

/**
 * ActividadDesempeno controller.
 *
 * @Route("/actividaddesempeno")
 */
class ActividadDesempenoController extends Controller
{
    /**
     * Lists all ActividadDesempeno entities.
     *
     * @Route("/", name="actividaddesempeno")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('NetpublicCoreBundle:ActividadDesempeno')->findAll();
        
          
        return array('entities' => $entities);
    }

    /**
     * Finds and displays a ActividadDesempeno entity.
     *
     * @Route("/{id}/show", name="actividaddesempeno_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:ActividadDesempeno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ActividadDesempeno entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }
     /**
     * Displays a form to create a new ActividadDesempeno entity.
     *
     * @Route("/new", name="actividaddesempeno_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ActividadDesempeno();
        $form   = $this->createForm(new ActividadDesempenoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }


    /**
     * Displays a form to create a new ActividadDesempeno entity.
     *
     * @Route("/newcustom", name="actividaddesempeno_newcustom")
     * @Template()
     */
    public function newcustomAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $actividades_mostrar=$request->get('desempenos');
        
        //Guardamos en sesion        
        $session=$this->get('request')->getSession();        
        $session->set('desempenos',$actividades_mostrar);
        $asignatura_id=$session->get('asignatura_id');   
        $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodoEscolarActivo();
        $periodo_id=$session->get('perido_id',$periodo_activo->getId());
	
        $user = $this->get('security.context')->getToken()->getUser();             
        if(!($user->getEsAlumno())){
            $profesor=$user->getProfesor();            
            $id_profesor=$profesor->getId();
        }   
        //Actividades disponible por periodo escolar
         $actividades_periodo=$em->getRepository('NetpublicCoreBundle:Dimension')->findBy(array(
             'tipo'=>4,
             'padre'=>$periodo_id,             
             'profesor'=>$id_profesor
             ));
        $actividades_desempenos=array();
        for ($index = 0; $index < count($actividades_mostrar); $index++) {
            $actividades_desempenos[] = $em->getRepository('NetpublicCoreBundle:ActividadDesempeno')->findBy(array(
            'desempeno'=>$actividades_mostrar[$index])); 
           
        }

        
        return array(
            'actividades_desempenos' => $actividades_desempenos,
            'actividades_periodo'=>$actividades_periodo
           
        );
    }

    /**
     * Creates a new ActividadDesempeno entity.
     *
     * @Route("/create", name="actividaddesempeno_create")
     * @Method("post")
     * @Template("NetpublicCoreBundle:ActividadDesempeno:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new ActividadDesempeno();
        $request = $this->getRequest();
        $form    = $this->createForm(new ActividadDesempenoType(), $entity);
         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('actividaddesempeno_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }
    /**
     * Creates a new ActividadDesempeno entity.
     *
     * @Route("/createprofesor", name="actividaddesempeno_createprofesor")
     * @Method("post")
     * @Template()
     */
    public function createprofesorAction()
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();        
        $periodo_id=$request->get("periodo_id");
        $grupo_id=$request->get("grupo_id");        
        $carga_id=$request->get("carga_id");
        $carga=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($carga_id);
        $asignatura_id=$request->get("asignatura_id");	

        $user = $this->get('security.context')->getToken()->getUser();
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor();            
         //   $id_profesor=$profesor->getId();
        }
        $session=$this->get('request')->getSession();
        $asignatura=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Asignatura")->find($asignatura_id);
        
        //$periodo_id=$session->get('perido_id');
        $id_desempeno=$session->get("id_desempeno");
        $periodo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);
        
        $desempeno=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Desempeno")->find($id_desempeno);
        $desempeno->setAsignatura($carga);
        $desempeno->setPeriodo($periodo);
        $desempeno->setProfesor($profesor);
        $em->persist($desempeno);
        $grupos=$desempeno->getGrupo();
        $actividad_desempeno_grupos=array();
        echo "$carga";
        //foreach ($grupos as $g) {
            $entities=$em->getRepository("NetpublicCoreBundle:Dimension")->findComponentesItems($periodo,$carga);
            $actividad_desempeno=array();
            foreach ($entities as $entity) {           
                echo "mama";
                $a_d=new ActividadDesempeno();
                $a_d->setActividad($entity);
                $a_d->setDesempeno($desempeno);
                $a_d->setPorcentaje(0.0);
                $em->persist($a_d);
                $actividad_desempeno[]=$a_d;
                
            }
            $actividad_desempeno_grupos[]=$actividad_desempeno;
            
        //}
        $em->flush();
        return array(
            "periodo"=>$periodo_id,
            'actividades_desempeno_grupos' => $actividad_desempeno_grupos,
            'id_desempeno'=>$id_desempeno,
            'grupos'=>$grupos,
            'periodo_id'=>$periodo_id,
            'grupo_id'=>$grupo_id,
            'carga_id'=>$carga_id,
            'asignatura_id'=>$asignatura_id
        );
    }    
    /**
     * Creates a new ActividadDesempeno entity.
     *
     * @Route("/{id_desempeno}/cancelarprofesor", name="actividaddesempeno_cancelarprofesor")
     * @Method("post")
     * @Template()
     */
    public function cancelarprofesorAction($id_desempeno)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        
        
        $entities=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:ActividadDesempeno")->findBy(array(
            'desempeno'=>$id_desempeno           
        ));
        
        foreach ($entities as $entity) {
            $em->remove($entity);
        }
        $desempeno=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Desempeno")->find($id_desempeno);
        $em->remove($desempeno);
         $em->flush();
        return new \Symfony\Component\HttpFoundation\Response("ok");
       
        
    }        
    /**
     * Creates a new ActividadDesempeno entity.
     *
     * @Route("/createcustom", name="actividaddesempeno_createcustom")
     * @Method("post")
     * @Template("")
     */
    public function createcustomAction()
    {
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }
     /**
     * Creates a new ActividadDesempeno entity.
     *
     * @Route("/actualizarporcentaje", name="actividaddesempeno_actualizarporcentaje")
     * 
     * @Template("")
     */
    public function actualizarporcentajeAction()
    {
        $request=  $this->getRequest();
        $id_actividad_desempeno=$request->get('id_actividad_desempeno');
        $porcentaje=$request->get('porcentaje');
        $actividad_desempeno=$this->getDoctrine()->getRepository("NetpublicCoreBundle:ActividadDesempeno")->find($id_actividad_desempeno);
        $actividad_desempeno->setPorcentaje($porcentaje);
        $em=  $this->getDoctrine()->getEntityManager();
        $em->persist($actividad_desempeno);
        $em->flush();
        
        return new \Symfony\Component\HttpFoundation\Response("ok");
        
    }
     /**
     * Creates a new ActividadDesempeno entity.
     *
     * @Route("/ponderar", name="actividaddesempeno_ponderar")     
     * @Template("")
     */
    public function ponderarAction()
    {
    ini_set('memory_limit', '-1');    
    set_time_limit(0);
        $em=  $this->getDoctrine()->getEntityManager();
        
        $session=$this->get('request')->getSession();
        $desempenos_ids=$session->get('desempenos');
        $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodoEscolarActivo();
        $periodo_id=$session->get('perido_id',$periodo_activo->getId());
	$user = $this->get('security.context')->getToken()->getUser();       
    
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor();            
            $id_profesor=$profesor->getId();
	}
        $this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumnodesempeno")
                ->ponderarNotasProfesor($periodo_id, $id_profesor, $desempenos_ids) 
                ;
        
        
        return new \Symfony\Component\HttpFoundation\Response("ok");
    }   

    /**
     * Displays a form to edit an existing ActividadDesempeno entity.
     *
     * @Route("/{id}/edit", name="actividaddesempeno_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:ActividadDesempeno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ActividadDesempeno entity.');
        }

        $editForm = $this->createForm(new ActividadDesempenoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing ActividadDesempeno entity.
     *
     * @Route("/{id}/update", name="actividaddesempeno_update")
     * @Method("post")
     * @Template("NetpublicCoreBundle:ActividadDesempeno:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('NetpublicCoreBundle:ActividadDesempeno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ActividadDesempeno entity.');
        }

        $editForm   = $this->createForm(new ActividadDesempenoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('actividaddesempeno_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ActividadDesempeno entity.
     *
     * @Route("/{id}/delete", name="actividaddesempeno_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:ActividadDesempeno')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ActividadDesempeno entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('actividaddesempeno'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
