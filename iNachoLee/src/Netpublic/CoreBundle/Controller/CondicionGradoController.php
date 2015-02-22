<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\CondicionGrado;
use Netpublic\CoreBundle\Form\CondicionGradoType;

/**
 * CondicionGrado controller.
 *
 * @Route("/condiciongrado")
 */
class CondicionGradoController extends Controller
{
          
     /**
     * Lists all CondicionCargaacademicacolegio entities.
     *
     * @Route("/{tipo}/{id}/cambiarestado", name="condiciongrado_cambiarestado")
     * @Template()
     */
    public function cambiarestadoAction($tipo,$id)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $celda=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:CondicionGrado")
                       ->find($id);        
        $celda->setTipo($tipo);
        $em->persist($celda);
        $em->flush();
        return array(
            'c'=>$celda
        );      
    }
     /**
     * Lists all CondicionCargaacademicacolegio entities.
     *
     * @Route("/{tipo}/{columna}/{grado}/cambiarestadocolumna", name="condiciongrado_cambiarestadocolumna")
     * @Template()
     */
    public function cambiarestadocolumnaAction($tipo,$columna,$grado)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $celdas=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:CondicionGrado")
                       ->findBy(array(
                           'dia_columna'=>$columna,
                           'grado'=>$grado
                       ));     
        foreach ($celdas as $celda) {
           $celda->setTipo($tipo);
           $em->persist($celda);                
        }        
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response("ok");
    }
     /**
     * Lists all CondicionCargaacademicacolegio entities.
     *
     * @Route("/{tipo}/{fila}/{grado}/cambiarestadofila", name="condiciongrado_cambiarestadofila")
     * @Template()
     */
    public function cambiarestadofilaAction($tipo,$fila,$grado)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="UPDATE NetpublicCoreBundle:CondicionGrado c";
        $dql.=" SET c.tipo=:tipo WHERE";
        $dql.=" (c.grado=:grado AND c.hora_fila=:fila) AND (c.tipo=1 OR c.tipo=0)";
        $query=$em->createQuery($dql);
        $query=$query->setParameter('tipo', $tipo);
        $query=$query->setParameter("fila", $fila);
        $query=$query->setParameter("grado", $grado);
        $celdas=$query->execute();                        
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response("ok");
    }



     /**
     * Lists all CondicionCargaacademicacolegio entities.
     *
     * @Route("/{id_grado}/ver", name="condiciongrado_ver")
     * @Template()
     */
    public function verAction($id_grado)
    {
        $sede_principal=  $this->getDoctrine()
         ->getRepository("NetpublicCoreBundle:Colegio")
         ->findSedePrincipal()
         ;        
        $nro_clase=$sede_principal->getNroClasesDia();
        
        $clases_hora=array();
        for ($index = 0; $index < $nro_clase; $index++) {
            $clases_hora[]=$h_c_profesor=$this->getDoctrine()
                            ->getRepository("NetpublicCoreBundle:CondicionGrado")
                            ->findBy(array(                            
                            "hora_fila"=>$index,
                             "grado"=>$id_grado
                                ));
        
        }
        return array(            
            'clases_hora'=>$clases_hora,
            'id_ca'=>$id_grado
            );

    
    }

        /**
     * Lists all CondicionContrato entities.
     *
     * @Route("/{id}/generar", name="condiciongrado_generar")
     * @Template()
     */
    public function generarAction($id)
    {
        $r="Ya esta";
        $em = $this->getDoctrine()->getEntityManager();
        $sede_principal=  $this->getDoctrine()
         ->getRepository("NetpublicCoreBundle:Colegio")
         ->findSedePrincipal()
         ;        
        $nro_clase_dia=$sede_principal->getNroClasesDia();
        $dql="SELECT count(c) FROM NetpublicCoreBundle:CondicionGrado c";
        $dql.=" WHERE c.grado=:grado";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("grado",$id);                                
         $nro_celdas_ca=$query->getSingleScalarResult();
        if($nro_celdas_ca==0){
            $hora=6;   
            $dias_festivos=array(5,6);
            for ($index = 0; $index <$nro_clase_dia ; $index++) {
                for ($index1 = -1; $index1 < 7; $index1++) {
                    $entity  = new CondicionGrado;
                    $entity->setDiaColumna($index1);
                    $entity->setHoraFila($index);
                    $entity->setGrado($this->getDoctrine()
                            ->getRepository("NetpublicCoreBundle:Grado")
                            ->find($id)
                            );
                    $es_libre=0;                
                    if(in_array($index1, $dias_festivos)){
                        $es_libre=2;
                    }
                    if($index1==-1){
                        $es_libre=-1;
                    }
                    $entity->setTipo($es_libre);                                                
                    $em->persist($entity);        
                }           
            }           
          $r="Generado por primera vez"  ;
 
 
        }
     $em->flush();    
     return new \Symfony\Component\HttpFoundation\Response("$r");

    }

    /**
     * Lists all CondicionGrado entities.
     *
     * @Route("/", name="condiciongrado")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NetpublicCoreBundle:CondicionGrado')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a CondicionGrado entity.
     *
     * @Route("/{id}/show", name="condiciongrado_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CondicionGrado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionGrado entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new CondicionGrado entity.
     *
     * @Route("/new", name="condiciongrado_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CondicionGrado();
        $form   = $this->createForm(new CondicionGradoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new CondicionGrado entity.
     *
     * @Route("/create", name="condiciongrado_create")
     * @Method("POST")
     * @Template("NetpublicCoreBundle:CondicionGrado:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new CondicionGrado();
        $form = $this->createForm(new CondicionGradoType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('condiciongrado_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CondicionGrado entity.
     *
     * @Route("/{id}/edit", name="condiciongrado_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CondicionGrado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionGrado entity.');
        }

        $editForm = $this->createForm(new CondicionGradoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing CondicionGrado entity.
     *
     * @Route("/{id}/update", name="condiciongrado_update")
     * @Method("POST")
     * @Template("NetpublicCoreBundle:CondicionGrado:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CondicionGrado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionGrado entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CondicionGradoType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('condiciongrado_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a CondicionGrado entity.
     *
     * @Route("/{id}/delete", name="condiciongrado_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NetpublicCoreBundle:CondicionGrado')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CondicionGrado entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('condiciongrado'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
