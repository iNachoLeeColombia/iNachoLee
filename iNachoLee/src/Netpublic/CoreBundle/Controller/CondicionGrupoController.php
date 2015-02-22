<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\CondicionGrupo;
use Netpublic\CoreBundle\Form\CondicionGrupoType;

/**
 * CondicionGrupo controller.
 *
 * @Route("/condiciongrupo")
 */
class CondicionGrupoController extends Controller
{
     /**
     * Lists all CondicionCargaacademicacolegio entities.
     *
     * @Route("/{tipo}/{id}/cambiarestado", name="condiciongrupo_cambiarestado")
     * @Template()
     */
    public function cambiarestadoAction($tipo,$id)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $celda=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:CondicionGrupo")
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
     * @Route("/{tipo}/{columna}/{grupo}/cambiarestadocolumna", name="condiciongrupo_cambiarestadocolumna")
     * @Template()
     */
    public function cambiarestadocolumnaAction($tipo,$columna,$grupo)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $celdas=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:CondicionGrupo")
                       ->findBy(array(
                           'dia_columna'=>$columna,
                           'grupo'=>$grupo
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
     * @Route("/{tipo}/{fila}/{grupo}/cambiarestadofila", name="condiciongrupo_cambiarestadofila")
     * @Template()
     */
    public function cambiarestadofilaAction($tipo,$fila,$grupo)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="UPDATE NetpublicCoreBundle:CondicionGrupo c";
        $dql.=" SET c.tipo=:tipo WHERE";
        $dql.=" (c.grupo=:grupo AND c.hora_fila=:fila) AND (c.tipo=1 OR c.tipo=0)";
        $query=$em->createQuery($dql);
        $query=$query->setParameter('tipo', $tipo);
        $query=$query->setParameter("fila", $fila);
        $query=$query->setParameter("grupo", $grupo);
        $celdas=$query->execute();                        
        $em->flush();
        return new \Symfony\Component\HttpFoundation\Response("ok");
    }



     /**
     * Lists all CondicionCargaacademicacolegio entities.
     *
     * @Route("/{id_grado}/ver", name="condiciongrupo_ver")
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
                            ->getRepository("NetpublicCoreBundle:CondicionGrupo")
                            ->findBy(array(                            
                            "hora_fila"=>$index,
                             "grupo"=>$id_grado
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
     * @Route("/{id}/generar", name="condiciongrupo_generar")
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
        $dql="SELECT count(c) FROM NetpublicCoreBundle:CondicionGrupo c";
        $dql.=" WHERE c.grupo=:grupo";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("grupo",$id);                                
         $nro_celdas_ca=$query->getSingleScalarResult();
        if($nro_celdas_ca==0){
            $hora=6;   
            $dias_festivos=array(5,6);
            for ($index = 0; $index <$nro_clase_dia ; $index++) {
                for ($index1 = -1; $index1 < 7; $index1++) {
                    $entity  = new CondicionGrupo();
                    $entity->setDiaColumna($index1);
                    $entity->setHoraFila($index);
                    $entity->setGrupo($this->getDoctrine()
                            ->getRepository("NetpublicCoreBundle:Grupo")
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
     * Lists all CondicionGrupo entities.
     *
     * @Route("/", name="condiciongrupo")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NetpublicCoreBundle:CondicionGrupo')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a CondicionGrupo entity.
     *
     * @Route("/{id}/show", name="condiciongrupo_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CondicionGrupo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionGrupo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new CondicionGrupo entity.
     *
     * @Route("/new", name="condiciongrupo_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CondicionGrupo();
        $form   = $this->createForm(new CondicionGrupoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new CondicionGrupo entity.
     *
     * @Route("/create", name="condiciongrupo_create")
     * @Method("POST")
     * @Template("NetpublicCoreBundle:CondicionGrupo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new CondicionGrupo();
        $form = $this->createForm(new CondicionGrupoType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('condiciongrupo_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CondicionGrupo entity.
     *
     * @Route("/{id}/edit", name="condiciongrupo_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CondicionGrupo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionGrupo entity.');
        }

        $editForm = $this->createForm(new CondicionGrupoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing CondicionGrupo entity.
     *
     * @Route("/{id}/update", name="condiciongrupo_update")
     * @Method("POST")
     * @Template("NetpublicCoreBundle:CondicionGrupo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NetpublicCoreBundle:CondicionGrupo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionGrupo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CondicionGrupoType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('condiciongrupo_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a CondicionGrupo entity.
     *
     * @Route("/{id}/delete", name="condiciongrupo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NetpublicCoreBundle:CondicionGrupo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CondicionGrupo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('condiciongrupo'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
