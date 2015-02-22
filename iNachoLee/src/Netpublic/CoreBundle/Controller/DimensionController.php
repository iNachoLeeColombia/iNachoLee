<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Netpublic\CoreBundle\Entity\Dimension;
use Netpublic\CoreBundle\Form\DimensionType;
use Netpublic\CoreBundle\Entity\AlumnoDimension;
use Symfony\Component\HttpFoundation\Response;
use Netpublic\CoreBundle\Entity\MatriculaAlumno;
use Netpublic\CoreBundle\Entity\NivelAcademico;
/**
 * Dimension controller.
 *
 * @Route("/dimension")
 */
class DimensionController extends Controller
{
     /**
     * Lists all Colegio entities.
     *
     * @Route("/{padre_id}/actualizarcompleta", name="colegio_actualizarcompleta")
     * @Template()
     */
    public function actualizarcompletaAction($padre_id)
    {
        $em=  $this->getDoctrine()->getManager();
        $request=  $this->getRequest();
        $componentes=$em->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
            'padregc'=>$padre_id
        ));
        foreach ($componentes as $com) {
            $componentes=$em->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
            'padregc'=>$com->getId(),
            'tipo'=>4    
            ));
            foreach ($componentes as $item_tipo4) {
                $item_tipo4->setNombre($com->getNombre());
                $item_tipo4->setPonderado($com->getPonderado());
                $em->persist($item_tipo4);
            }
            $items=$em->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
                    'padregc'=>$com->getId(),
                    'tipogc'=>9    
                    ));
            foreach ($items as $item_gc) {
                $items_tipo_4=$em->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
                    'padregc'=>$item_gc->getId(),
                    'tipo'=>4    
                ));
                foreach ($items_tipo_4 as $item_tipo4_1) {
                    $item_tipo4_1->setNombre($item_gc->getNombre());
                    $item_tipo4_1->setPonderado($item_gc->getPonderado());
                    $em->persist($item_tipo4_1);
                
                }
            
            }
            
        }
        //$em->remove($padre);
        $em->flush();
        return new Response("ok");
    }

    /**
     * Lists all Colegio entities.
     *
     * @Route("/{padre_id}/deletecomponente", name="colegio_deletecomponente")
     * @Template()
     */
    public function deletecomponenteAction($padre_id)
    {
        $em=  $this->getDoctrine()->getManager();
        $padre=$em->getRepository("NetpublicCoreBundle:Dimension")->find($padre_id);
        $cas=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
            "padre_evaluacion"=>$padre_id
        ));
        foreach ($cas as $ca) {
            //$ca=new \Netpublic\CoreBundle\Entity\CargaAcademica();
            $ca->setPadreEvaluacion();
            $em->persist($ca);
        }
        $em->flush();
        /*$hijos=$padre->getPadresgc();
        foreach ($hijos as $h) {
            $hs=$h->getPadresgc();
            foreach ($hs as $h1) {
                $hs->removePadresgc($h1);
            }
            $hijos->removePadresgc($h);
        }
        $hijos=$padre->getPadres();
        foreach ($hijos as $h) {
            $hs=$h->getPadres();
            foreach ($hs as $h1) {
                $hs->removePadres($h1);
            }
            $hijos->removePadres($h);
        
        }*/
           
        $em->flush();
        return new Response("ok");
    }

    /**
     * Lists all Colegio entities.
     *
     * @Route("/{id}/showcomponente", name="colegio_showcomponente")
     * @Template()
     */
    public function showcomponenteAction($id)
    {
        $em=  $this->getDoctrine()->getManager();
        $request=  $this->getRequest();
        $padre=$em->getRepository("NetpublicCoreBundle:Dimension")->find($id);
        return array(
            'padre'=>$padre
        );
    }

    /**
     * Lists all Colegio entities.
     *
     * @Route("/{id}/actualizarcomponente", name="colegio_actualizarcomponente")
     * @Template()
     */
    public function actualizarcomponenteAction($id)
    {
        $em=  $this->getDoctrine()->getManager();
        $request=  $this->getRequest();
        $padre=$em->getRepository("NetpublicCoreBundle:Dimension")->find($id);
        $padre->setNombre($request->get('nombre'));
        $padre->setPonderado($request->get('porcentaje'));
        $em->persist($padre);
        $em->flush();
        return new Response(1);
        
        
    }

    /**
     * Lists all Colegio entities.
     *
     * @Route("/{padre_id}/editarcomponente", name="colegio_editarcomponente")
     * @Template()
     */
    public function editarcomponenteAction($padre_id)
    {
        $em=  $this->getDoctrine()->getManager();
        $padre=$em->getRepository("NetpublicCoreBundle:Dimension")->find($padre_id);
        return array(
            'padre'=>$padre
        );
        
        
    }

    /**
     * Lists all Dimension entities.
     * 
     * @Route("/{padre_id}/{carga_id}/creardimension",name="dimension_creardimension")     
     * @Template()
     */
    public function creardimensionAction($padre_id,$carga_id)
    {
        $em=  $this->getDoctrine()->getManager();
        $session=  $this->getRequest()->getSession();
        $ca=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($carga_id);
        $padre=$em->getRepository("NetpublicCoreBundle:Dimension")->find($padre_id);
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($ano_escolar_id_s);

        $padre_viejo=$ca->getPadreEvaluacion();
        if($padre_viejo){
            $em->getRepository("NetpublicCoreBundle:CargaAcademica")->deleteCarga($ca,$ano_escolar_activo);        
            $this->crearDimensionesPadreGc($padre,$ca);
        }
        else{
            $re=2;
            $this->crearDimensionesPadreGc($padre,$ca);            
        }
        $ca->setPadreEvaluacion($padre);
        $em->persist($ca);
        $em->flush();
        return new Response(1);
    }
    /**
     * Lists all Dimension entities.
     * 
     * @Route("/{padre_id}/deletepadre",name="dimension_deletepadre")     
     * @Template()
     */
    public function deletepadreAction($padre_id)
    {
        $em=  $this->getDoctrine()->getManager();
           
        return new Response(1);
    }
    /**
     * Lists all Dimension entities.
     * 
     * @Route("/{label}/{padre_id}/{max}/actualizarfalla",name="dimension_actualizarfalla")     
     * @Template()
     */
    public function actualizarfallaAction($label,$padre_id,$max)
    {
        $re=-1;
        if($label<=$max && $label>0){
            $request=  $this->getRequest();
            $nombre_hijo=$request->get('nombre_hijo');
            $porcentaje=$request->get('porcentaje');
            $nombre_padre=$request->get('nombre_padre');
            $porcentaje_padre=$request->get('porcentaje_padre');            
            $em=  $this->getDoctrine()->getManager();
            $padre=$em->getRepository("NetpublicCoreBundle:Dimension")->findOneBy(array(
                'posicion'=>$padre_id
            ));
            if($padre){
                $padre->setPosicion($padre_id);
                $padre->setBposicion($padre_id);
                $padre->setPonderado($porcentaje_padre);
                $padre->setTipogc(7);
                $padre->setNombre($nombre_padre);
                $em->persist($padre);
            }
            else{
                $padre=new Dimension();
                $padre->setPosicion($padre_id);
                $padre->setBposicion($padre_id);
                $padre->setPonderado($porcentaje_padre);
                $padre->setTipogc(7);
                $padre->setNombre($nombre_padre);
                $em->persist($padre);
            }
            $hijo=$em->getRepository("NetpublicCoreBundle:Dimension")->findOneBy(array(
                'posicion'=>$label
            ));
            if($hijo){
                $hijo->setPosicion($label);
                $hijo->setBposicion($label);
                $hijo->setPadregc($padre);
                $hijo->setNombre($nombre_hijo);
                $hijo->setPonderado($porcentaje);
                $hijo->setTipogc(8);
                $em->persist($hijo);
            }
            else{
                $hijo=new Dimension();
                $hijo->setPosicion($label);
                $hijo->setBposicion($label);
                $hijo->setPadregc($padre);
                $hijo->setNombre($nombre_hijo);
                $hijo->setPonderado($porcentaje);
                $hijo->setTipogc(8);
                $em->persist($hijo);
            }
            $em->flush();       
            $re=1;
        }
        return new Response($re);
        
    }
    /**
     * Lists all Dimension entities.
     * 
     * @Route("/{label}/{padre_id}/{max}/actualizarpadre",name="dimension_actualizarpadre")     
     * @Template()
     */
    public function actualizarpadreAction($label,$padre_id,$max)
    {
        $re=-1;
        if($label<=$max && $label>0){
            $request=  $this->getRequest();
            $nombre_hijo=$request->get('nombre_hijo');
            $porcentaje=$request->get('porcentaje');
            $nombre_padre=$request->get('nombre_padre');
            $porcentaje_padre=$request->get('porcentaje_padre');            
            $em=  $this->getDoctrine()->getManager();
  
            $padre=$em->getRepository("NetpublicCoreBundle:Dimension")->findOneBy(array(
                'posicion'=>$padre_id
            ));
            if($padre){
                $padre->setPosicion($padre_id);
                $padre->setBposicion($padre_id);
                $padre->setPonderado($porcentaje_padre);
                $padre->setTipogc(7);
                $padre->setNombre($nombre_padre);
                $em->persist($padre);
                $re="edit";
            }
            else{
                $padre=new Dimension();
                $padre->setPosicion($padre_id);
                $padre->setBposicion($padre_id);
                $padre->setPonderado($porcentaje_padre);
                $padre->setTipogc(7);
                $padre->setNombre($nombre_padre);
                $em->persist($padre);
                $re="new";
            }
            $hijo=$em->getRepository("NetpublicCoreBundle:Dimension")->findOneBy(array(
                'posicion'=>$label
            ));
            if($hijo){
                $hijo->setPosicion($label);
                $hijo->setBposicion($label);
                $hijo->setPadregc($padre);
                $hijo->setNombre($nombre_hijo);
                $hijo->setPonderado($porcentaje);
                $hijo->setTipogc(9);
                $em->persist($hijo);
                $re="edit"+$hijo->getId();
            }
            else{
                $hijo=new Dimension();
                $hijo->setPosicion($label);
                $hijo->setBposicion($label);
                $hijo->setPadregc($padre);
                $hijo->setNombre($nombre_hijo);
                $hijo->setPonderado($porcentaje);
                $hijo->setTipogc(9);
                $em->persist($hijo);
                $re="new"+$hijo->getId();
            }
            $em->flush();       
            
        }
       return new Response($re."$padre $hijo"); 
    }

    /**
     * Lists all Dimension entities.
     * 
     * @Route("/{nro}/newnrocomponente",name="dimension_newnrocomponente")     
     * @Template()
     */
    public function newnrocomponenteAction($nro)
    {
        $em=  $this->getDoctrine()->getManager();
        $entities=$em->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
            'tipogc'=>8
        ));
        foreach ($entities as $entity) {
            $entity->setPosicion(-1);
            $em->persist($entity);
        }
        $entities=$em->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
            'tipogc'=>7
        ));
        foreach ($entities as $entity) {
            $entity->setPosicion(-1);
            $em->persist($entity);
        }
        $entities=$em->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
            'tipogc'=>9
        ));
        foreach ($entities as $entity) {
            $entity->setPosicion(-1);
            $em->persist($entity);
        }

        $em->flush();
        return array(
            'nro_componentes'=>$nro
        );
        
    }
    /**
     * Lists all Dimension entities.
     * 
     * @Route("/{tipo}/adicionarcomponente",name="dimension_adicionarcomponente")     
     * @Template()
     */
    public function adicionarcomponenteAction($tipo)
    {
        $request=  $this->getRequest();
        $em=  $this->getDoctrine()->getManager();
        if($tipo==7){  
            $dimension=new Dimension();
            $dimension->setNombre($request->get('nombre'));
            $dimension->setTipogc(7);
            $dimension->setPonderado($request->get("porcentaje"));
        }
        if($tipo==3){  
            $dimension=new Dimension();
            $dimension->setNombre("Fallas");
            $dimension->setTipogc(33);
            $dimension->setPonderado(0);
        }
        if($request->get("padre")==0){
                $padre=new Dimension();
                $padre->setNombre("Final de periodo");
                $padre->setTipogc(8);
                $padre->setPonderado(100);
                $em->persist($padre);
                $dimension->setPadre($padre);
        }
        else{
            $padre=$em->getRepository("NetpublicCoreBundle:Dimension")->find($request->get("padre"));
            $dimension->setPadregc($padre);
        }
        $em->persist($dimension);
        $em->flush();
        
        $hijos=$em->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
            'padre'=>$padre->getId()
        ));
        return array(
            'hijos'=>$hijos,
            'padre'=>$padre
        );
    }

    /**
     * Lists all Dimension entities.
     * 
     * @Route("/newcomponente",name="dimension_newcomponente")     
     * @Template()
     */
    public function newcomponenteAction()
    {
        return array("id"=>1);
    }
    /**
     * Lists all Dimension entities.
     * 
     * @Route("/{ca_id}/{dimension_id}/showca.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|json|pdf"},name="dimension_showca")     
     * @Template()
     */
    public function showcaAction($ca_id,$dimension_id)
    {
       $em=  $this->getDoctrine()->getManager();
       
       $ca=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($ca_id);
       if($ca->getPadreEvaluacion()){
           $padre=$ca->getPadreEvaluacion();
           echo $padre->getId();
       }
       else{
           $padre=array();
       }
       return array(
           "padre"=>$padre,
           "carga"=>$ca
       );
       
    }
    /**
     * Lists all Dimension entities.
     * 
     * @Route("/{ca_id}/{dimension_id}/showcatipo.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|json|pdf"},name="dimension_showcatipo")     
     * @Template()
     */
    public function showcatipoAction($ca_id,$dimension_id)
    {
       $em=  $this->getDoctrine()->getManager();
       $session=  $this->getRequest()->getSession();
       $request=  $this->getRequest();
       if($dimension_id==-1){
            $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                            ->findPeriodoEscolarActivo();
            $periodo_id=$session->get('perido_id',$periodo_activo->getId());
       }
       else{
           $periodo_id=$dimension_id;
       }
       $periodo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);
       $ca=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($ca_id);
       $asignatura_id=$ca->getAsignatura()->getId();
       $grupo_id=$ca->getGrupo()->getId();
       $componentes_items=$em->getRepository("NetpublicCoreBundle:Dimension")->getComponentesItems($periodo, $asignatura_id,$grupo_id);
       $format = $request->get('_format');
       $comp_json=array();
       if($format=='json'){
           foreach ($componentes_items as $compo) {
               $comp_json[]=$compo->getId();
           }
           return new \Symfony\Component\HttpFoundation\JsonResponse($comp_json);
       } 
       
       return array(
           "componentes_items"=>$componentes_items,
           "carga"=>$ca
       );
       
    }

    /**
     * Lists all Dimension entities.
     * @Route("/{ca_id}/{dimension_id}/showcaitems",name="dimension_showcaitems")     
     * @Template()
     */
    public function showcaitemsAction($ca_id,$dimension_id)
    {
       $em=  $this->getDoctrine()->getManager();
       $ca=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($ca_id);
       $dimension=$em->getRepository("NetpublicCoreBundle:Dimension")->find($dimension_id);
       
       $items=$em->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
           'padre'=>$dimension_id
       ));
       
       return array(
           "componentes_items"=>$items,
           "carga"=>$ca
       );
       
    }
    /**
     * Lists all Dimension entities.
     * @Route("/{ca_id}/{dimension_id}/showcaitemstipo",name="dimension_showcaitemstipo")     
     * @Template()
     */
    public function showcaitemstipoAction($ca_id,$dimension_id)
    {
       $em=  $this->getDoctrine()->getManager();
       $session=  $this->getRequest()->getSession();
       if($dimension_id==-1){
            $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                            ->findPeriodoEscolarActivo();
            $periodo_id=$session->get('perido_id',$periodo_activo->getId());
       }
       else{
           $periodo_id=$dimension_id;
       }
       $periodo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);
       $ca=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($ca_id);
       $profesor_id=$ca->getProfesor()->getId();
       $asignatura_id=$ca->getAsignatura()->getId();
       $grupo_id=$ca->getGrupo()->getId();
       $componentes_items=$em->getRepository("NetpublicCoreBundle:Dimension")->getComponentesItems($profesor_id,$periodo, $asignatura_id,$grupo_id);
       return array(
           "componentes_items"=>$componentes_items,
           "carga"=>$ca
       );
       
    }

    /**
     * Lists all Dimension entities.
     * @Route("/{carga_origen_id}/{carga_destino_id}/pegarcargacarga",name="dimension_pegarcargacarga")     
     * @Template()
     */
    public function pegarcargacargaAction($carga_origen_id,$carga_destino_id)
    {
            $em=  $this->getDoctrine()->getManager();
            $session=  $this->getRequest()->getSession();
            $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                            ->findPeriodoEscolarActivo();
            $periodo_id=$session->get('perido_id',$periodo_activo->getId());
            $periodo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);
            
            $carga_destino=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($carga_destino_id);
            $carga_origen=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($carga_origen_id);
            
            $compo_origenes=$em->getRepository("NetpublicCoreBundle:Dimension")->getComponentesItems(
                                       $periodo, $carga_origen->getAsignatura()->getId(),$carga_origen->getGrupo()->getId());
            foreach ($compo_origenes as $c_o) {
                $compo=$em->getRepository("NetpublicCoreBundle:Dimension")
                ->adicionarComponente($carga_destino->getGrupo(),$carga_destino->getAsignatura(),$periodo,$c_o->getNombre(),$c_o->getPonderado());

                echo "$c_o\n";
                $items_destino=$em->getRepository("NetpublicCoreBundle:Dimension")->getComponentesItems(
                $c_o, $carga_origen->getAsignatura()->getId(),$carga_origen->getGrupo()->getId());
                
                foreach ($items_destino as $item) {
                         
                $em->getRepository("NetpublicCoreBundle:Dimension")
                ->adicionarComponente($carga_destino->getGrupo(),$carga_destino->getAsignatura(),$compo,$item->getNombre(),$item->getPonderado());
                        echo "--------$item\n";
                }
           }
           $em->flush();
           return new Response("ok");
    }
 
     /**
     * Lists all Dimension entities.
     * @Route("/{origen_id}/{carga_origen_id}/{carga_destino_id}/crearcomponente",name="dimension_crearcomponente")     
     * @Template()
     */
    public function crearcomponenteAction($origen_id,$carga_origen_id,$carga_destino_id)
    {
            $em=  $this->getDoctrine()->getManager();
            $session=  $this->getRequest()->getSession();
            $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                            ->findPeriodoEscolarActivo();
            $periodo_id=$session->get('perido_id',$periodo_activo->getId());
            $periodo=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);
       
            
            $origen=$em->getRepository("NetpublicCoreBundle:Dimension")->find($origen_id);
            $carga_destino=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($carga_destino_id);
            $carga_origen=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($carga_origen_id);
            
            $compo_nuevo= $em->getRepository("NetpublicCoreBundle:Dimension")
                ->adicionarComponente($carga_destino->getGrupo(),$carga_destino->getAsignatura(),$periodo,$origen->getNombre(),$origen->getPonderado());
            $items_origenes=$em->getRepository("NetpublicCoreBundle:Dimension")->getComponentesItems(
                    $origen, $carga_origen->getAsignatura()->getId(),$carga_origen->getGrupo()->getId());
            $asignatura_destino=$carga_destino->getAsignatura();
            //$profesor_destino=$carga_destino->getProfesor();
            $grupo_destino=$carga_destino->getGrupo();
            foreach ($items_origenes as $item) {
                $item_nuevo=new Dimension();
                $item_nuevo->setNombre($item->getNombre());
                $item_nuevo->setAsignatura($asignatura_destino);
                $item_nuevo->setPadre($compo_nuevo);
                $item_nuevo->setPonderado($item->getPonderado());
                $item_nuevo->setPorcentaje($item->getPorcentaje());
                //$item_nuevo->setProfesor($profesor_destino);
                $item_nuevo->addGrupo($grupo_destino);
                $item_nuevo->setTipo($item->getTipo());            
                $em->persist($item_nuevo);
                $em->getRepository("NetpublicCoreBundle:Dimension")
                ->adicionarComponente($grupo_destino,$asignatura_destino,$compo_nuevo,$item->getNombre(),$item->getPonderado());
            
            }
            
            $em->flush();
            return new Response("ok");
    }
 
     /**
     * Lists all Dimension entities.
     * @Route("/{origen_id}/{destino_id}/{carga_origen_id}/{carga_destino_id}/pegarcomponentecomponente",name="dimension_pegarcomponentecomponente")     
     * @Template()
     */
    public function pegarcomponentecomponenteAction($origen_id,$destino_id,$carga_origen_id,$carga_destino_id)
    {
        $em=  $this->getDoctrine()->getManager();
        $compo_oringen=$em->getRepository("NetpublicCoreBundle:Dimension")->find($origen_id);
        $compo_destino=$em->getRepository("NetpublicCoreBundle:Dimension")->find($destino_id);
        $carga_origen=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($carga_origen_id);
        $carga_destino=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($carga_destino_id);
        $asignatura_id=$carga_origen->getAsignatura()->getId();
        $grupo=$carga_origen->getGrupo();
        //Buscamos los items del compo origen
        $items_origenes=$em->getRepository("NetpublicCoreBundle:Dimension")->getComponentesItems($compo_oringen, $asignatura_id,$grupo->getId());
        $asignatura_destino=$carga_destino->getAsignatura();
        //$profesor_destino=$carga_destino->getProfesor();
        $grupo_destino=$carga_destino->getGrupo();
        
        foreach ($items_origenes as $item) {
            $em->getRepository("NetpublicCoreBundle:Dimension")
                ->adicionarComponente($grupo_destino,$asignatura_destino,$compo_destino,$item->getNombre(),$item->getPonderado());
           
        } 
        $em->flush();
        return new Response("ok");
    }
    
     /**
     * Lists all Dimension entities.
     * @Route("/guardarsesioncopiar",name="dimension_guardarsesioncopiar")     
     * @Template()
     */
    public function guardarsesioncopiarAction()
    {
        $request=  $this->getRequest();
        $session=$request->getSession();
        $componentes_copiar=json_decode($request->get('componentes_copiar'));
        $nro_hijos_compnomente_copiar=json_decode($request->get('nro_hijos_componente_copiar'));
        $padres_items=json_decode($request->get('padres_copiar'));
        $items=json_decode($request->get('items_copiar'));
        $session->set('componentes_copiar', $componentes_copiar);
        $session->set('nro_hijos_componente_copiar', $nro_hijos_compnomente_copiar);
        $session->set('padres_copiar', $padres_items);
        $session->set('items_copiar', $items);
        
        return new Response("ok");
      }

      /**
     * Lists all Dimension entities.
     * @Route("/eliminarcolumnanota",name="dimension_eliminarcolumnanota")     
     * @Template()
     */
    public function eliminarcolumnanotaAction()
    {
        ini_set('memory_limit', '-1');    
        set_time_limit(0);
        $em=  $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $es_tipo_cuatro=FALSE;
        //Trabajamos con los items
        $notas=json_decode($request->get('id_notas'));        
        for ($index = 0; $index < count($notas); $index++) {
            
            $mi_nota=$em->getRepository("NetpublicCoreBundle:AlumnoDimension")->find($notas[$index]);
            if($mi_nota->getDimension()->getTipo()==4 && $index==0){
                $dimension=$mi_nota->getDimension();
                $es_tipo_cuatro=TRUE;
            }
            $mi_nota->setDimension();
            $em->persist($mi_nota);
            $em->remove($mi_nota);
        }
        $em->flush();
        if($es_tipo_cuatro && count($dimension->getNota())==0){
            $dimension->setPadre();
            $dimension->setPeriodoAcademico();
            $em->persist($dimension);
            $em->remove($dimension);
        }
        $em->flush();
        
        return new Response("ok");
      }
      /**
     * Lists all Dimension entities.
     * @Route("/{nota_id}/eliminarunanota",name="dimension_eliminarunanota")     
     * @Template()
     */
    public function eliminarunanotaAction($nota_id)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $mi_nota=$em->getRepository("NetpublicCoreBundle:AlumnoDimension")->find($nota_id);
        $em->remove($mi_nota);
        $em->flush();
        return new Response("ok");
      }

      /**
     * Lists all Dimension entities.
     * @Route("/pegar", name="dimension_pegar")     
     * @Template()
     */
    public function pegarAction(){
        ini_set('memory_limit', '-1');    
        set_time_limit(0);
        $em=  $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $session=$request->getSession();
        $periodo_id=$session->get('perido_id');    
        $padre=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);
        
        
        $componentes_copiar=$session->get('componentes_copiar');//json_decode($request->get('componentes_copiar'));
        $nro_hijos_compnomente_copiar=$session->get('nro_hijos_componente_copiar');//json_decode($request->get('nro_hijos_componente_copiar'));
        
        $profesores=json_decode($request->get('profesores_pegar'));
        $nro_hijos_profe=json_decode($request->get('nro_hijos_profesores_pegar'));
        
        //$componentes_=json_decode($request->get('padres_copiar'));
        
        //Trabajamos con los Componentes.
        $padres_items_2=array();
        $items_2=array();
        $posicion=0;
        for ($index1 = count($componentes_copiar)-1; $index1 >=0; $index1--) {
            $mi_padre=$em->getRepository("NetpublicCoreBundle:Dimension")->find($componentes_copiar[$index1]);
            
            if($mi_padre->getTipo()==4){
                $grupos=$mi_padre->getGrupo();
                $grupo_id=$grupos[0]->getId();
            $itemas_mi_padre=$this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Dimension")
                               ->getComponentesItems($mi_padre,$mi_padre->getAsignatura(),$grupo_id);
            
            if($nro_hijos_compnomente_copiar[$index1]!=count($itemas_mi_padre )){
                
                for ($index2 = 0; $index2 < count($itemas_mi_padre); $index2++) {
                   $padres_items_2[$posicion]=$mi_padre->getId();
                    $items_2[$posicion]=$itemas_mi_padre[$index2];
                    echo "traajandocon items";
                    $posicion++;
                }                
            }
            if(count($itemas_mi_padre)==0){
                if($mi_padre->getTipo()==4){
                $padres_items_2[$posicion]=$mi_padre->getId();
                $posicion++;
                echo "Cero comop";
                }
            }
            
        }
        }
        
        //Trabajamos con los Items suletos.
        $padres_items=$session->get('padres_copiar');//json_decode($request->get('padres_copiar'));
        $items=$session->get('items_copiar');//json_decode($request->get('items_copiar'));
        
        
        for ($index = 0; $index < count($profesores); $index++) {
            
            $carga_academica_profe=$carga_academica_profe=$em->getRepository("NetpublicCoreBundle:CargaAcademica")
                                      ->getAsignaturaGrupo($profesores[$index]);
            if(count($carga_academica_profe)!=$nro_hijos_profe[$index]){
                foreach ($carga_academica_profe as $carga_academica) {                
                    $this->generarItemsComponente($padres_items,$items,$carga_academica,$padre);       
                    $this->generarItemsComponente($padres_items_2,$items_2,$carga_academica,$padre);       
                    
                    
                }   
            }
        }
//Trabajamos con las Carga Academicas Destinos seleccionadas
      $ca=json_decode($request->get('ca'));      
      for ($index4=0;$index4<count($ca);$index4++) {
          $carga_academica=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($ca[$index4]);
          $this->generarItemsComponente($padres_items,$items,$carga_academica,$padre);         
          $this->generarItemsComponente($padres_items_2,$items_2,$carga_academica,$padre);         
          echo "mmamma";
       }
    
     $em->flush();
     return new Response("Ok");
    }
     /**
     * Lists all Dimension entities.
     * @Route("/adicionaritems", name="dimension_adicionaritems")     
     * @Template()
     */
    public function adicionaritemsAction(){
        ini_set('memory_limit', '-1');    
        set_time_limit(0);
        $request=  $this->getRequest();
        
            
        $carga_academicas=json_decode($request->get('cas'));
        $componentes=json_decode($request->get('componentes'));
        
        $nombre=$request->get("nombre");
        $ponderado=$request->get("ponderado");
        $em=  $this->getDoctrine()->getEntityManager();
        
        for ($index = 0; $index < count($carga_academicas); $index++) {
            $carga_academica=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($carga_academicas[$index]);
            $padre=$em->getRepository("NetpublicCoreBundle:Dimension")->find($componentes[$index]);
            //$dueno=$carga_academica->getProfesor();
            $grupo=$carga_academica->getGrupo();
            $asignatura=$carga_academica->getAsignatura();
            $em->getRepository("NetpublicCoreBundle:Dimension")
                ->adicionarComponente($grupo,$asignatura,$padre,$nombre,$ponderado);
           ;
        }
        $em->flush();
        return new Response("Ok");
        
            
    }
    
    
     /**
     * Lists all Dimension entities.
     * @Route("/adicionarcomponentes", name="dimension_adicionarcomponentes")     
     * @Template()
     */
    public function adicionarcomponentesAction(){
        ini_set('memory_limit', '-1');    
        set_time_limit(0);
        $request=  $this->getRequest();
        $session=$request->getSession();
        $em=  $this->getDoctrine()->getEntityManager();
        $periodo_activo=$em->getRepository("NetpublicCoreBundle:Dimension")
                            ->findPeriodoEscolarActivo();
        $periodo_id=$session->get('perido_id',$periodo_activo->getId());
        $padre=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);
            
        $carga_academicas=json_decode($request->get('carga_academica'));
        
        $nombre=$request->get("nombre");
        $ponderado=$request->get("ponderado");
        //procesamos cargas academicas
        for ($index = 0; $index < count($carga_academicas); $index++) {
            $carga_academica=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($carga_academicas[$index]);        
            //$dueno=$carga_academica->getProfesor();
            $grupo=$carga_academica->getGrupo();
            $asignatura=$carga_academica->getAsignatura();
            $em->getRepository("NetpublicCoreBundle:Dimension")
                ->adicionarComponente($grupo,$asignatura,$padre,$nombre,$ponderado);

        }
        
        $em->flush();
        return new Response("Ok");
        
            
    }
    
     /**
     * Lists all Dimension entities.
     * @Route("/crearcomponentesobligatorios", requirements={"asignatura" = "\d+"}, name="dimension_crearcomponentesobligatorios")     
     * @Template()
     */
    public function crearcomponentesobligatoriosAction()
    {
        
    $em=  $this->getDoctrine()->getEntityManager();
    $request=  $this->getRequest();
    $session=$request->getSession();
    $periodo_id=$session->get('perido_id');
    $padre=$em->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);
    //$periodos_academicos=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodosEscolar($padre);
    $periodos_academicos=$em->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
        "id"=>$padre->getId()
    ));
    
    //Profesores
    $carga_academicas=json_decode($request->get('ca'));
    //Trabajamos con la Cargas Academicas
       for ($index1 = 0; $index1 < count($carga_academicas); $index1++) {
            $ca=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($carga_academicas[$index1]);
                $em->getRepository("NetpublicCoreBundle:Dimension")
                   ->adicinarComponentesObligatorios($ca->getGrupo(),$ca->getAsignatura(),$periodos_academicos)
                ;
        }

    $em->flush();
    return new Response("ok");
    }
     /**
     * Lists all Dimension entities.
     * @Route("/neweditar",name="dimension_neweditar")     
     * @Template()
     */
    public function neweditarAction()
    {
        ini_set('memory_limit', '-1');    
        set_time_limit(0);
        $em=  $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        //Trabajamos con los items
        $items=json_decode($request->get('items'));
        
        $componentes=json_decode($request->get('componentes'));
        $item_hay=FALSE;
        $componente_hay=FALSE;
        $item_principal=1;
        $componente_principal=1;
        if(count($items)>0){
            $item_hay=true;
            $item_principal=$em->getRepository("NetpublicCoreBundle:Dimension")->find($items[0]);
        }
        if(count($componentes)>0){
                $componente_hay=true;
                $componente_principal=$em->getRepository("NetpublicCoreBundle:Dimension")->find($componentes[0]);        
        }
        return array(
            'item_principal'=>$item_principal,
            'componente_principal'=>$componente_principal,
            'item_hay'=>$item_hay,
            'componente_hay'=>$componente_hay
        );
        
    }
     /**
     * Lists all Dimension entities.
     * @Route("/editar",name="dimension_editar")     
     * @Template()
     */
    public function editarAction()
    {
        ini_set('memory_limit', '-1');    
        set_time_limit(0);
        $em=  $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        //Trabajamos con los items
        $items=json_decode($request->get('items'));  
        $nombre_item=$request->get("nombre_item");
        $ponderado_item=$request->get("ponderado_item");
        $componentes=json_decode($request->get('componentes'));
        $nombre_componente=$request->get("nombre_componente");
        $ponderado_componente=$request->get("ponderado_componente");
        $item_hay=FALSE;
        $componente_hay=FALSE;
        $item_principal=1;
        $componente_principal=1;
        for ($index = 0; $index < count($items); $index++) {
            $item_hay=true;
            $item_principal=$em->getRepository("NetpublicCoreBundle:Dimension")->find($items[$index]);
            $item_principal->setNombre($nombre_item);
            $item_principal->setPonderado($ponderado_item);
            $em->persist($item_principal);
        }
        for ($index = 0; $index < count($componentes); $index++) {
                $componente_hay=true;
                $componente_principal=$em->getRepository("NetpublicCoreBundle:Dimension")->find($componentes[$index]);
                $componente_principal->setNombre($nombre_componente);
                $componente_principal->setPonderado($ponderado_componente);
                $em->persist($componente_principal);
        }
        $em->flush();
        return new Response("ok");
        
    }
    /**
     * Lists all Dimension entities.
     * @Route("/{item_id}/borraritem", requirements={"asignatura" = "\d+"}, name="dimension_borraritem")     
     * @Template()
     */
    public function borraritemAction($item_id)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        echo $item_id;
        $em->getRepository("NetpublicCoreBundle:Dimension")->deleteItem($item_id); 
        $em->flush();
        return new Response("ok");
        
    }
    /**
     * Lists all Dimension entities.
     * @Route("/{compo_id}/borrarcomponente", requirements={"asignatura" = "\d+"}, name="dimension_borrarcomponente")     
     * @Template()
     */
    public function borrarcomponenteAction($compo_id)
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $em->getRepository("NetpublicCoreBundle:Dimension")->deleteComponente($compo_id);            
        return new Response("ok");
        
    }
    
    /**
     * Lists all Dimension entities.
     * @Route("/{tipo}", requirements={"tipo" = "\d+"}, name="dimension_index")     
     * @Template()
     */
    public function indexAction($tipo)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();        
        $deleteForm=array();
        $entities=array();
        $es_ajax=FALSE;
        $user = $this->get('security.context')->getToken()->getUser();
        if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor();            
            $id_profesor=$profesor->getId(); 
            
        }        
        if($tipo==4){
	$session=$this->get('request')->getSession();
        $asignatura_id=$session->get('asignatura_id'); 
        $entities = $em->getRepository('NetpublicCoreBundle:Dimension')->findBy(array(
            "tipo"=>$tipo,
            "profesor"=>$id_profesor,
	    "asignatura"=>$asignatura_id,
	    "padre"=>$session->get('perido_id')	
            ));
        }
        elseif($tipo==1){
             $ano_escolar_activo=  $this->getDoctrine()
                             ->getRepository("NetpublicCoreBundle:Dimension")
                            ->findAnoEscolarActivo()
                    ;
             if($ano_escolar_activo!=null)
              $entities = $em->getRepository('NetpublicCoreBundle:Dimension')->findBy(array(
            "tipo"=>$tipo,
            "padre"=>$ano_escolar_activo->getId()                                           
            ));

            
        }
        elseif($tipo==6){
            $entities=array();
             $venctor_entities=  $this->getDoctrine()
                             ->getRepository("NetpublicCoreBundle:Dimension")
                            ->findPeriodosHijosAnoActivo()
                    ;
             foreach ($venctor_entities as $ve) {                 
                 foreach ($ve as $v) {
                     $entities[]=$v;      
                 }
                  
             }
             
            
        }
        
        else{
             $entities = $em->getRepository('NetpublicCoreBundle:Dimension')->findBy(array(
            "tipo"=>$tipo,
                 
         
            ));
        }
        
        if($request->isXmlHttpRequest()){
            $es_ajax=TRUE;
        }
        foreach ($entities as $e) {
     
            $deleteForm[] = $this->createDeleteForm($e->getId())->createView();
            
        }        
        return array(
            'entities' => $entities,
            'tipo' => $tipo,
            'es_ajax' =>$es_ajax,
            'delete_form'=>$deleteForm
            );
    }
     /**
     * Lists all Grado entities.
     *
     * @Route("/anosescolares.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|json|pdf"}, name="dimension_anosescolares")
     * @Template()
     */
    public function anosescolaresAction()
    {
        $anos_escolares= $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
            'tipo'=>0));
        if($this->getRequest()->get('_format')=='json'){
            $anos_json=array();
            foreach ($anos_escolares as $ano) {
                $anos_json[]=$ano->getId();
            }
            return new \Symfony\Component\HttpFoundation\JsonResponse($anos_json);
        }
        return array(
            "anos_escolares"=>$anos_escolares
        );
    }
     /**
     * Lists all Grado entities.
     *
     * @Route("/{ano_escolar}/{periodo}/cambiarperiodoactivo", name="dimension_cambiarperiodoactivo")
     * @Template()
     */
    public function cambiarperiodoactivoAction($ano_escolar,$periodo)
    {
        $session=$this->get('request')->getSession();
        $session->set('perido_id',$periodo);
        $session->set('ano_escolar_id',$ano_escolar);
        
        
        return new Response("ok");
    }

     /**
     * Lists all Grado entities.
     *
     * @Route("/{nombre_ruta}/periodosescolares", name="dimension_periodosescolares")
     * @Template()
     */
    public function periodosescolaresAction($nombre_ruta)
    {
        $ano_escolar_activo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                      ->findAnoEscolarActivo();
     
        $periodos_escolares= $this->getDoctrine()
                                  ->getRepository("NetpublicCoreBundle:Dimension")
                                  ->findPeriodosEscolar($ano_escolar_activo);
        $periodo_activo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")
                      ->findPeriodoEscolarActivo();
        
     
        $session=$this->get('request')->getSession();
        $periodo_sesion=$session->get('perido_id',$periodo_activo->getId());
        
        return array(
            "periodos_escolares"=>$periodos_escolares,
            "periodo_activo"=>$periodo_sesion,
            "href"=>$this->generateUrl($nombre_ruta)

        );
    }
    
    /**
     * Finds and displays a Dimension entity.
     *
     * @Route("/{id}/show", name="dimension_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request= $this->getRequest();
        $entity = $em->getRepository('NetpublicCoreBundle:Dimension')->find($id);
        $es_ajax=FALSE;
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dimension entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        if($request->isXmlHttpRequest()){
            $es_ajax=TRUE;
        }
        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'es_ajax' =>$es_ajax
            );
    }
    /**
     * Finds and displays a Dimension entity.
     *
     * @Route("/{id_periodo}/periodos", name="dimension_periodos")
     * @Template()
     */
    public function periodosAction($id_periodo)
    {
        $periodos=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
            'padre'=>$id_periodo,
            'tipo'=>1
        ));
        
        return array(     
            'periodos'=>$periodos            
            );
    }
    /**
     * Finds and displays a Dimension entity.
     *
     * @Route("/{id_periodo}/dimensionessuperiores", name="dimension_dimensionessuperiores")
     * @Template()
     */
    public function dimensionessuperioresAction($id_periodo)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $session=$this->get('request')->getSession();

        $asignatura_id=$session->get('asignatura_id');                     
        $periodo_id=$session->get('perido_id');
        $dimensiones_superiores=array();
        $periodo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->find($periodo_id);
         if(($user->getEsAlumno()==FALSE)){
            $profesor=$user->getProfesor();            
            $id_profesor=$profesor->getId(); 
        
        $dimensiones_superiores=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
            'padre'=>$periodo_id,
            'profesor'=>$id_profesor,
            'asignatura'=>$asignatura_id
        ));
         }
        return array(     
            'dimensiones_superiores'=>$dimensiones_superiores,
            'periodo'=>$periodo
            );
    }    
    /**
     * Finds and displays a Dimension entity.
     *
     * @Route("/{id_periodo}/asistencia", name="dimension_asistencia")
     * @Template()
     */
    public function asistenciaAction($id_periodo)
    {
        
        
        $asistencia_periodo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
            'padre'=>$id_periodo,
            'tipo' =>3
        ));
        
        return array(     
            'asistencia_periodo'=>$asistencia_periodo
            
            );
    }       
    /**
     * Finds and displays a Dimension entity.
     *
     * @Route("/actividades", name="dimension_actividades")
     * @Template()
     */
    public function actividadesAction()
    {
        
   
        
        $request=$this->getRequest();
        $em=  $this->getDoctrine()->getEntityManager();
        $id_profesor=$request->get('id_profesor');
        $id_asignatura=$request->get('asignatura_filtro');
        $id_periodo=$request->get('periodo_escolar');
        $actividades=array();
        
          $query = $em->createQuery('SELECT a FROM NetpublicCoreBundle:Dimension a WHERE a.profesor=:id_profesor AND a.asignatura=:id_asignatura AND a.padre=:periodoacademico')
                            ->setParameters(array(
                            "id_profesor"=>$id_profesor,
                            "id_asignatura"=>$id_asignatura,
                            "periodoacademico"=>$id_periodo        
                            ));
         $actividades = $query->getResult();  
 
        return array(     
            'actividades'=>$actividades
            );
    }

    /**
     * Displays a form to create a new Dimension entity.
     *
     * @Route("/{tipo}/new", name="dimension_new")
     * @Template()
     */
    public function newAction($tipo)
    {
          ini_set('memory_limit', '-1');    
          set_time_limit(0);
        $request=  $this->getRequest();
        $es_ajax=FALSE;
        $entity = new Dimension();
        $entity->setTipo($tipo);
        $tipo_padre=0;
        //Filtro de tipo
        switch ($tipo) {
            case 0:{//Año escolar
                $tipo_padre=-1;            
                break;
            }
            case 2:{//Periodo Academico
                $tipo_padre=-1;            
                break;
            }
            case 1:{//Periodo Academico
                $tipo_padre=0;            
                break;
            }
            case 4:{//actividades
                $tipo_padre=1;            
                break;
            }
            case 6:{//actividad generadora de actividades
                $tipo_padre=6;            
                break;
            }
            default:
                break;
        }
        
        $form   = $this->createForm(new DimensionType($tipo_padre), $entity);
        if($request->isXmlHttpRequest()){
            $es_ajax=TRUE;
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'tipo' =>$tipo,
            'es_ajax' =>$es_ajax
        );
    }

    /**
     * Creates a new Dimension entity.
     *
     * @Route("/{tipo}/create", name="dimension_create")
     * @Method("post")
     * @Template()
     */
    public function createAction($tipo)
    {
    ini_set('memory_limit', '-1');    
    set_time_limit(0);


        $em=  $this->getDoctrine()->getEntityManager();
        $tipo_padre=0;
        //Filtro de tipo
        switch ($tipo) {
            case 0:{//Año escolar
                $tipo_padre=-1;            
                break;
            }
            case 1:{//Periodo Academico
                $tipo_padre=0;            
                break;
            }
            case 2:{
                $tipo_padre=-1;
                break;
            }
            case 4:{//actividades
                $tipo_padre=1;            
                break;
            }
             case 6:{//generadres
                $tipo_padre=6;            
                break;
            }
            default:
                break;
        }
        $entity  = new Dimension();
        $entity->setTipo($tipo);
        $request = $this->getRequest();
        $form    = $this->createForm(new DimensionType($tipo_padre), $entity);
         $form->handleRequest($request);
        
        if ($form->isValid()) {
            if($entity->getTipo()==0){
                //Generamos registros para hacer seguimientos al proceso de matricula.Para Estudiantes Viejos
                //$em->createQuery('UPDATE NetpublicCoreBundle:Dimension d set d.es_ano_escolar=0 WHERE d.tipo=0')
                //            ->execute();
                $pp_ano_escolar=new Dimension();
                $pp_ano_escolar->setNombre("PromediosPeriodo");
                $pp_ano_escolar->setPadre($entity);
                $pp_ano_escolar->setTipo(5);   
                //$entity->setEsAnoEscolar(TRUE);
                $em->persist($pp_ano_escolar);
                $entity->setNivel(0);
                $ano_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
                if($ano_activo){
                $mis_cargas=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
                    'ano_escolar'=>$ano_activo->getId()
                ));
                foreach ($mis_cargas as $ca) {   
                    $nueva_carga=new \Netpublic\CoreBundle\Entity\CargaAcademica();
                    $nueva_carga->setAsignatura($ca->getAsignatura());
                    $nueva_carga->setGrupo($ca->getGrupo());
                    $nueva_carga->setAnoEscolar($entity);
                    if($ca->getProfesor()){
                        $nueva_carga->setProfesor($ca->getProfesor());
                    }                    
                    $em->persist($nueva_carga);
                    
                }
                }
            }
            //Solo es VALIDO Si LA DIMESION ES UN PERIODO ACADEMICO.
            if($entity->getTipo()==1){
                //Obtenemos los peridos academicos anteriores
                $periodos_academico=$em->getRepository("NetpublicCoreBundle:Dimension")->findOneBy(
                        array('padre'=>$entity->getPadre()->getId())
                        );
                $entity->setNivel($periodos_academico->getId()+1);
                $dim_asistencia=new Dimension();
                $dim_asistencia->setPadre($entity);
                $dim_asistencia->setTipo(3);
                $dim_asistencia->setNivel($entity->getNivel()+1);
                $dim_asistencia->setNombre("Fallas");
                $em->persist($dim_asistencia);
                //areas
                $dim_area=new Dimension();
                $dim_area->setPadre($entity);
                $dim_area->setTipo(2);
                $dim_area->setNivel($entity->getNivel()+1);
                $dim_area->setNombre("Area");
                $em->persist($dim_area);
                //Promedios Periodos
                $dim_pp=new Dimension();
                $dim_pp->setPadre($entity);
                $dim_pp->setTipo(5);
                $dim_pp->setNivel($entity->getNivel()+1);
                $dim_pp->setNombre("PromedioPeriodos");
                $em->persist($dim_pp);
                //Tiempo de inicio y Cierre De calificacion de notas
                $profesores=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Profesor")->findBy(array(
                    'tipo'=>2
                ));
                if($entity->getFechaFinal()){
                    $fecha_final=$entity->getFechaFinal();
                }
                else{
                    $fecha_final=new \DateTime("now");
                }
                if($entity->getFechaInicio()){
                    $fecha_inicio=$entity->getFechaInicio();
                }
                else{
                    $fecha_inicio=new \DateTime("now");
                }
                
                foreach ($profesores as $profe) {
                    $entrega=new \Netpublic\CoreBundle\Entity\Profesorperiodoentrega();
                    $entrega->setFechaFinal($fecha_final);
                    $entrega->setFechaInicio($fecha_inicio);
                    $entrega->setProfesor($profe);
                    $entrega->setPeriodo($entity);
                    $em->persist($entrega);
                    //Para determinar si publicaron las notas
                    $estado_publicacion_ntas= new \Netpublic\CoreBundle\Entity\PublicacionPeriodosProfesores();
                    $estado_publicacion_ntas->setPeriodoAcademico($entity);
                    $estado_publicacion_ntas->setProfesor($profe);
                    $estado_publicacion_ntas->setTipo(0);
                    $em->persist($estado_publicacion_ntas);
                }
            }
            //Solo es VALIDO SI LA DIMENSION ES UNA TAREA|ACTIVIDAD
            //Se crean las notas para todos los estudiantes del grupo|grupos seleccionados
            if($entity->getTipo()==4){
                //Establecemos nivel para mostrar
                $valor_defecto=-1;
                $entity->setNivel($entity->getPadre()->getNivel()+1);

                $user = $this->get('security.context')->getToken()->getUser();
                $entity->setProfesor($profesor=$user->getProfesor());
                $session=$this->get('request')->getSession();
                $grupo_id=$session->get('grupo_id');
                $asignatura_id=$session->get('asignatura_id');
                $periodoacademico=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->find($grupo_id);    

                $asignatura=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Asignatura")->find($asignatura_id); 

                //$entity->setPeriodoacademico($periodoacademico);
		$entity->setPeriodoacademico($entity->getPadre());
//                return new \Symfony\Component\HttpFoundation\Response("ok");           
                $entity->setAsignatura($asignatura);
                $grupos_tarea=$entity->getGrupo();

                foreach ($grupos_tarea as $grupo_tarea) {
                    //Buscamos los alumnos del grupo
                    $alumnos_grupo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")->findBy(array('grupo'=>$grupo_tarea->getId()));
                    //Asignamos registros para guardar nota de la la tera-actividad
                    foreach ($alumnos_grupo as $alumno_grupo) {
                        $nota=new AlumnoDimension();
                        $nota->setAlumno($alumno_grupo);
                        $nota->setAsignatura($entity->getAsignatura());
                        $nota->setDimension($entity);
                        $nota->setNota($valor_defecto);
                        $nota->setNotaBuffered(-1);
                        $em->persist($nota);
                    }
                }
            }   
            //Solo es VALIDO SI LA DIMENSION ES UNA generadora de actividades 
            //Se crean las notas para todos los estudiantes del grupo|grupos seleccionados
            if($entity->getTipo()==6){
                //Todos los profesores de la institucion
                //$temp="ss";
		//$entity->setPeriodoacademico($entity);
                $valor_defecto=-1;
                $profesores=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Profesor")->findBy(array(
                    'tipo'=>2
					));
                foreach ($profesores as $profe) {
                    $c_a_p=$this->getDoctrine()->getRepository("NetpublicCoreBundle:CargaAcademica")
                            ->findBy(array(
                                'profesor'=>$profe->getId(),
                                'es_carga_academica'=> 1
                            ));
                    foreach ($c_a_p as $me_carga) {
			if($entity->getPadre()->getTipo()==1){
                                $entity1=new Dimension();                                                                
                                $entity1->setProfesor($profe);
                                
                                $grupo_id=$me_carga->getGrupo()->getId();
                                $asignatura_id=$me_carga->getAsignatura()->getId();
                               //$periodoacademico=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->find($grupo_id);        
                                $asignatura=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Asignatura")->find($asignatura_id);        
                                $entity1->setPeriodoacademico($entity);
                                $entity1->setNombre($entity->getNombre());
                                $entity1->setAsignatura($me_carga->getAsignatura());
                                $entity1->setPonderado($entity->getPonderado());
                                $entity1->setPadre($entity->getPadre());
                                $entity1->setTipo(4);
                                $entity1->addGrupo($me_carga->getGrupo());
                             }
			if($entity->getPadre()->getTipo()==6){
                                $entity1=new Dimension();                                                                
                                $entity1->setProfesor($profe);
                                $dimension_padre="1";
                                $grupo_id=$me_carga->getGrupo()->getId();
                                $asignatura_id=$me_carga->getAsignatura()->getId();
                                $periodoacademico=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->find($grupo_id);        
                                $asignatura=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Asignatura")->find($asignatura_id); 
       				$dimension_padre=$this->getDoctrine()
                                                      ->getRepository("NetpublicCoreBundle:Dimension")
                                                      ->findBy(array(
								"profesor"=>$profe->getId(),
								"asignatura"=>$asignatura_id,
								"tipo"=>4,
								"periodoacademico"=>$entity->getPadre()->getId()
							)); 
								$index=0;
							foreach ($dimension_padre as $d_m) {
								foreach ($d_m->getGrupo() as $grupo) {
								if($grupo->getId()==$me_carga->getGrupo()->getId()){
                                $entity1->setPeriodoacademico($entity);
                                $entity1->setNombre($entity->getNombre());
                                $entity1->setAsignatura($me_carga->getAsignatura());
                                $entity1->setPonderado($entity->getPonderado());
                                $entity1->setPadre($dimension_padre[$index]);
                                $entity1->setTipo(4);
                                $entity1->addGrupo($me_carga->getGrupo());
								//$temp.=$dimension_padre[$index]->getId()."--."; 
								}
								}
								$index++;
								 }
								 
                             }
                                //$grupos_tarea=$entity->getGrupo();
                               // foreach ($grupos_tarea as $grupo_tarea) {
                                    //Buscamos los alumnos del grupo
       $alumnos_grupo=$this->getDoctrine()->getRepository("NetpublicCoreBundle:Alumno")->findBy(array('grupo'=>$me_carga->getGrupo()->getId()));
                                    //Asignamos registros para guardar nota de la la tera-actividad
                                    foreach ($alumnos_grupo as $alumno_grupo) {
                                        $nota=new AlumnoDimension();
                                        $nota->setAlumno($alumno_grupo);
                                        $nota->setAsignatura($me_carga->getAsignatura());
                                        $nota->setDimension($entity1);
                                        $nota->setNota($valor_defecto);
                                        $nota->setNotaBuffered(-1);
                                        $em->persist($nota);
                                    }
                                //}
                                    $em->persist($entity1);

                        
                    }
                    //$temp.="k";
                }
                //return new \Symfony\Component\HttpFoundation\Response($temp);
            }//****
            //$valido=$temp;
            $em->persist($entity);
            $em->flush();

            //return $this->redirect($this->generateUrl('dimension_show', array('id' => $entity->getId())));
            
        }
        return new \Symfony\Component\HttpFoundation\Response("k");
        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
        
    }

    /**
     * Displays a form to edit an existing Dimension entity.
     *
     * @Route("/{id}/{tipo}/edit", name="dimension_edit")
     * @Template()
     */
    public function editAction($id,$tipo)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request=  $this->getRequest();
        $es_ajax=false;
        $entity = $em->getRepository('NetpublicCoreBundle:Dimension')->find($id);
         $entity->setTipo($tipo);
        $tipo_padre=0;
        //Filtro de tipo
        switch ($tipo) {
            case 0:{//Año escolar
                $tipo_padre=-1;            
                break;
            }
            case 2:{//Periodo Academico
                $tipo_padre=-1;            
                break;
            }
            case 1:{//Periodo Academico
                $tipo_padre=0;            
                break;
            }
            case 4:{//actividades
                $tipo_padre=1;            
                break;
            }
            case 6:{//actividades
                $tipo_padre=6;            
                break;
            }
            default:
                break;
        }
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dimension entity.');
        }

        $editForm = $this->createForm(new DimensionType($tipo_padre), $entity);
        $deleteForm = $this->createDeleteForm($id);
        if($request->isXmlHttpRequest()){
            $es_ajax=TRUE;
        }
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'es_ajax' =>$es_ajax
        );
    }

    /**
     * Edits an existing Dimension entity.
     *
     * @Route("/{id}/{tipo}/update", name="dimension_update")
     * @Method("post")
     * @Template()
     */
    public function updateAction($id,$tipo)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $sede_principal=  $this->getDoctrine()
                        ->getRepository("NetpublicCoreBundle:Colegio")
                        ->findSedePrincipal();
        $valor_defecto=-1;

        $entity = $em->getRepository('NetpublicCoreBundle:Dimension')->find($id);
        $entity->setTipo($tipo);
        $tipo_padre=0;
        //Filtro de tipo
        switch ($tipo) {
            case 0:{//Año escolar
                $tipo_padre=-1;            
                break;
            }
            case 2:{//Periodo Academico
                $tipo_padre=-1;            
                break;
            }
            case 1:{//Periodo Academico
              
                $tipo_padre=0;            
                break;
            }
            case 4:{//actividades
                $tipo_padre=1; 
               /*   $notas=$entity->getNota();
                foreach ($notas as $nota) {
                    $em->remove($nota);
                }*/
                $em->flush();
                break;
            }
             case 6:{//Periodo Academico
              
                $tipo_padre=6;            
                break;
            }
            default:
                break;
        }
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dimension entity.');
        }

        $editForm   = $this->createForm(new DimensionType($tipo_padre), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            if($tipo==1){
                //Tiempo de inicio y Cierre De calificacion de notas
                $PeriodosEntraga=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Profesorperiodoentrega")->findBy(array(
                    'periodo'=>$entity->getId()
                ));
                foreach ($PeriodosEntraga as $entrega) {                    
                    $entrega->setFechaFinal($entity->getFechaFinal());
                    $entrega->setFechaInicio($entity->getFechaInicio());                  
                    $entrega->setPeriodo($entity);
                    $em->persist($entrega);
                }
              $profesores=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Profesor")->findBy(array(
                    'tipo'=>2
                ));
              $ano_escolar_activo=  $this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Dimension")
                              ->findAnoEscolarActivo();
              
               $perios_escolares=$this->getDoctrine()
                               ->getRepository("NetpublicCoreBundle:Dimension")
                             ->findPeriodosEscolar($ano_escolar_activo);
                     foreach ($profesores as $profe) {
                         
                    
                     foreach ($perios_escolares as $p_e) {    

                          $this->getDoctrine()->getRepository("NetpublicCoreBundle:Profesor")
                        ->generarFechasEntregasProfesor($profe,$p_e);

                     }
                    }

               
                
            }
            if($tipo==4){
                $entities = $em->getRepository('NetpublicCoreBundle:AlumnoDimension')->findBy(array(
                    'dimension'=>$entity->getId()
                ));
                foreach ($entities as $e) {
                    $em->remove($e);
                }
                $em->flush();
                $grupos=$entity->getGrupo();
                foreach ($grupos as $grupo) {
                    $alumnos=$em->getRepository('NetpublicCoreBundle:Alumno')->findBy(array(
                    'grupo'=>$grupo->getId()));
                    foreach ($alumnos as $alumno) {
                        $a_d=new AlumnoDimension();
                        $a_d->setAlumno($alumno);
                        $a_d->setAsignatura($entity->getAsignatura());
                        $a_d->setDimension($entity);
                        $a_d->setNota($valor_defecto);
                        $a_d->setNotaBuffered(-1);
                        $em->persist($a_d);
                    }                    
                }
            }
            if ($tipo==6){
                $entities = $em->getRepository('NetpublicCoreBundle:Dimension')->findBy(array(
                    'periodoacademico'=>$entity->getId()
                ));
                
                foreach ($entities as $e) {
                    $e->setNombre($entity->getNombre());
                    $e->setPonderado($entity->getPonderado());
                    $e->setPadre($entity->getPadre());
                    $em->persist($e);
                }
                
            }
            $em->persist($entity);
            $em->flush();
             if ($this->container->get('request')->isXmlHttpRequest()){
                 return new Response("Actualizado");            
            }
            //return $this->redirect($this->generateUrl('dimension_ed', array('id' => $id)));
            return new Response("ok");
        }
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Dimension entity.
     *
     * @Route("/{id}/delete", name="dimension_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {

       	    ini_set('memory_limit', '-1');    
    set_time_limit(0);

        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

         $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('NetpublicCoreBundle:Dimension')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Dimension entity.');
            }
            $entities = $em->getRepository('NetpublicCoreBundle:AlumnoDimension')->findBy(array(
                    'dimension'=>$entity->getId()
                ));
                foreach ($entities as $e) {
                    $em->remove($e);
                }
            if ($entity->getTipo()==6){
                $entities = $em->getRepository('NetpublicCoreBundle:Dimension')->findBy(array(
                    'periodoacademico'=>$entity->getId(),
					'tipo'=>4
                ));
                foreach ($entities as $e) {
                    //;
                    $entities2 = $em->getRepository('NetpublicCoreBundle:AlumnoDimension')->findBy(array(
                    'dimension'=>$e->getId()
                    ));
                    foreach ($entities2 as $e2) {
                         $em->remove($e2);
                    }
                    $this->borrarDesempeno($e->getId());
                    $this->borrarActividadDesempeno($e->getId());
                    $em->remove($e);
                }   
                $em->remove($entity);
                $em->flush();                 
            }else{                   
            //Eliminamod depe
            //Borramos notas de la Dimension
            //Borramos los Niveles academicos
            
            //Borramos todas las Notas de las Dimesiones hijas
            $periodos_academicos=  $this->getDimensionesPadre($entity->getId());
            foreach ($periodos_academicos as $pa) {
                $dimensiones=  $this->getDimensionesPadre($pa->getId());
                foreach ($dimensiones as $dim) {
                    $talleres=  $this->getDimensionesPadre($dim->getId());
                    foreach ($talleres as $taller) {
                        $this->borrarNotas($taller);                        
                    }
                    //$this->borrarDesempeno($dim->getId());
                    $this->borrarMatriculaAlumno($dim->getId());
                    $this->borrarNivelAcademico($dim->getId());
                    $this->borrarObservacion($dim->getId());
                    $this->borrarProfesorPeriodoEntrega($dim->getId());
                    $this->borrarPublicacionProfesor($dim->getId());
            
                    $this->borrarAlumnoDesempeno($dim->getId());
                    $this->borrarActividadDesempeno($dim->getId());
                    $this->borrarDesempeno($entity->getId());
                    $this->borrarDimensionesPadre($dim->getId());
                    $this->borrarNotas($dim->getId());
                }              
                $this->borrarMatriculaAlumno($pa->getId());
                $this->borrarNivelAcademico($pa->getId());
                $this->borrarObservacion($pa->getId());
                $this->borrarProfesorPeriodoEntrega($pa->getId());
                $this->borrarPublicacionProfesor($pa->getId());
            
                $this->borrarAlumnoDesempeno($pa->getId());
                $this->borrarActividadDesempeno($pa->getId());
                $this->borrarDesempeno($pa->getId());
                $this->borrarDimensionesPadre($pa->getId());
                $this->borrarNotas($pa->getId());                
            }      
            
            $this->borrarMatriculaAlumno($entity->getId());
            $this->borrarNivelAcademico($entity->getId());
            $this->borrarObservacion($entity->getId());
            $this->borrarProfesorPeriodoEntrega($entity->getId());
            $this->borrarPublicacionProfesor($entity->getId());
            $this->borrarAlumnoDesempeno($entity->getId());
            $this->borrarActividadDesempeno($entity->getId());
            $this->borrarDesempeno($entity->getId());
            $this->borrarDimensionesPadre($entity->getId());
            $this->borrarNotas($entity->getId());
            //$em->remove($entity);
            $this->borrarUltimoPadre($entity->getId());
            }
            //$em->flush();                 
            if($request->isXmlHttpRequest()){
                return new Response("$entity");
            }
            return $this->redirect($this->generateUrl('dimension_index',array('tipo'=>0)));
        }
        return new Response("No valido");
        
    }
    /**
     * Finds and displays a Dimension entity.
     *
     * @Route("/{ano}/{token}/actualizaranogc", name="dimension_actualizaranogc")
     * @Template()
     */
    public function actualizaranogcAction($ano,$token)
    {
       $em=  $this->getDoctrine()->getManager(); 
       $ano=$em->getRepository("NetpublicCoreBundle:Dimension")->find($ano);
       
       $session=  $this->getRequest()->getSession();
       $session->set('ano_'.$token, $ano);
       return new Response($ano);
    }
    /**
     * Finds and displays a Dimension entity.
     *
     * @Route("/{token}/anoescolares", name="dimension_anoescolares")
     * @Template()
     */
    public function anoescolaresAction($token)
    {
       $em=  $this->getDoctrine()->getManager();
       $session=  $this->getRequest()->getSession();
       $anos_escolares=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolares();
       $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
       $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
       if($token=='fuente')
            $ano_escolar_id_s=$session->get('ano_fuente',$ano_escolar_activo);
       if($token=='destino')
            $ano_escolar_id_s=$session->get('ano_destino',$ano_escolar_activo);        
        
       return array(
           'anos'=>$anos_escolares,
           'ano_activo_id'=>$ano_escolar_id_s->getId(),
           'token'=>$token
               
       );
    }
    /**
     * Finds and displays a Dimension entity.
     *
     * @Route("/{id}/periodosano", name="dimension_periodosano")
     * @Template()
     */
    public function periodosanoAction($id)
    {
        $request=  $this->getRequest();
        $entities=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
           'padre'=>$id,
           'tipo'=>1 
        ));
        $es_ajax=false;
        if($request->isXmlHttpRequest()){
            $es_ajax=TRUE;
        }
        return array(
            'entities'      => $entities,            
            'es_ajax' =>$es_ajax
            );
    }
    /**
     * Finds and displays a Dimension entity.
     *
     * @Route("/fechasentrega", name="dimension_fechasentrega")
     * @Template()
     */
    public function fechasentregaAction()
    {
        
        $ano_escolar_activo=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findOneBy(array(
            "tipo"=>0,
            "es_ano_escolar"=>TRUE
        ));        
        $entities=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
           'padre'=>$ano_escolar_activo->getId(),
           'tipo'=>1 
        ));        
        $dias_espanol=  \Netpublic\CoreBundle\Util\Util::getDiaEspanol();
        $mes_espanol= \Netpublic\CoreBundle\Util\Util::getMesEspanol();
        $colegio=  $this->getDoctrine()->getRepository("NetpublicCoreBundle:Colegio")
                        ->findSedePrincipal();
        
        
        return array(                    
            "entities" =>$entities,
            "mes_espanol"=>$mes_espanol,
            "dias_espanol"=>$dias_espanol,
            'colegio'=>$colegio
        );
        
    }


    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    private function getDimensionesPadre($padre_id) {
        $em=  $this->getDoctrine()->getEntityManager();
         $dql="SELECT a_d FROM NetpublicCoreBundle:Dimension a_d";
         $dql.=" WHERE a_d.padre=:dimension_id";
         $query=$em->createQuery($dql);
         $dimensiones_tercer_nivel=$query
                       ->setParameter("dimension_id", $padre_id)
                       ->getResult();
         return $dimensiones_tercer_nivel;
     
    }
    private function borrarNotas($dimension_id) {
        $em=  $this->getDoctrine()->getEntityManager();        
        $dql="DELETE NetpublicCoreBundle:AlumnoDimension a_d";
        $dql.=" WHERE a_d.dimension=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $dimension_id)->execute();                                
    }
    private function borrarDimensionesPadre($dimension_padre_id) {
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:Dimension a_d";
        $dql.=" WHERE a_d.padre=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $dimension_padre_id)->execute();                        
    }
    private function borrarActividadDesempeno($dimension_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:ActividadDesempeno a_d";
        $dql.=" WHERE a_d.actividad=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $dimension_id)->execute();                        

    }
    private function borrarAlumnoDesempeno($dimension_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:AlumnoDesempeno a_d";
        $dql.=" WHERE a_d.dimension=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $dimension_id)->execute();                        

    }
    private function borrarNivelAcademico($dimension_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:NivelAcademico a_d";
        $dql.=" WHERE a_d.periodo_actual=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $dimension_id)->execute();                        

    }
    private function borrarDesempeno($dimension_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="SELECT a_d FROM NetpublicCoreBundle:Desempeno a_d";
        $dql.=" WHERE a_d.periodo=:dimension_id";
        $query=$em->createQuery($dql);
        $desempenos=$query
                        ->setParameter("dimension_id", $dimension_id)
                        ->getResult();                        
        foreach ($desempenos as $d) {
                $dql="DELETE NetpublicCoreBundle:AlumnoDesempeno a_d";
                $dql.=" WHERE a_d.desempeno=:dimension_id";
                $query=$em->createQuery($dql);
                $query=$query->setParameter("dimension_id",$d->getId())->execute();                        
                
                $dql="DELETE NetpublicCoreBundle:ActividadDesempeno a_d";
                $dql.=" WHERE a_d.desempeno=:dimension_id";
                $query=$em->createQuery($dql);
                $query=$query->setParameter("dimension_id",$d->getId())->execute();                        
         }
        $dql="DELETE NetpublicCoreBundle:Desempeno a_d";
        $dql.=" WHERE a_d.periodo=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $dimension_id)->execute();                        

    }
    private function borrarMatriculaAlumno($dimension_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:MatriculaAlumno a_d";
        $dql.=" WHERE a_d.ano=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $dimension_id)->execute();                        

    }
//    Profesorperiodoentrega
    private function borrarProfesorPeriodoEntrega($dimension_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:Profesorperiodoentrega a_d";
        $dql.=" WHERE a_d.periodo=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $dimension_id)->execute();                        

    }
    private function borrarPublicacionProfesor($dimension_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:PublicacionPeriodosProfesores a_d";
        $dql.=" WHERE a_d.periodo_academico=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $dimension_id)->execute();                        

    }
    private function borrarObservacion($dimension_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:Observacion a_d";
        $dql.=" WHERE a_d.periodo=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $dimension_id)->execute();                        

    }
    private function borrarUltimoPadre($dimension_id){
        $em=  $this->getDoctrine()->getEntityManager();
        $dql="DELETE NetpublicCoreBundle:Dimension a_d";
        $dql.=" WHERE a_d.id=:dimension_id";
        $query=$em->createQuery($dql);
        $query=$query->setParameter("dimension_id", $dimension_id)->execute();                        

    }
    private function generarItemsComponente($padre_items,$items,$carga_academica,$periodo_academico){
        $em=  $this->getDoctrine()->getEntityManager();
        $padre_items_=$padre_items;        
        for ($index2 = 0; $index2 < count($padre_items); $index2++) { 
                    $elemento=$padre_items_[$index2];
                    if($elemento!=0){
                        $inicio=0;
                        $componente_copiar=$em->getRepository("NetpublicCoreBundle:Dimension")->find($padre_items[$index2]);
                        /*$entity=new Dimension();
                        $entity->setNombre($componente_copiar->getNombre());
                        $entity->setPonderado($componente_copiar->getPonderado());
                        $entity->setPadre($periodo_academico);                
                        $entity->setAsignatura($carga_academica->getAsignatura());
                        $entity->setProfesor($carga_academica->getProfesor());
                        $esta=false;
                        foreach ($entity->getGrupo() as $grupo) {
                            if($grupo->getId()==$carga_academica->getGrupo()->getId()){
                                $esta=true;                         
                            }
                        }
                        if(!$esta){*/
                       //     $entity->addGrupo($carga_academica->getGrupo());                    
                       // $entity->setTipo(4);
                       // $em->persist($entity);
                       $entity=   $em->getRepository("NetpublicCoreBundle:Dimension")
                               ->adicionarComponente(
                                       $carga_academica->getGrupo(),
                                       $carga_academica->getAsignatura(),
                                       $periodo_academico,
                                       $componente_copiar->getNombre(),
                                       $componente_copiar->getPonderado());
                        //}
                    }
                    else{
                        $inicio=  count($padre_items);
                    }                     
                    for ($index3 = $inicio; $index3 < count($padre_items); $index3++) {
                        if($elemento==$padre_items[$index3] && count($items)!=0){                    
                            $item_copiar=$em->getRepository("NetpublicCoreBundle:Dimension")->find($items[$index3]);
                            $nombre=$item_copiar->getNombre();
                            $ponderado=$item_copiar->getPonderado();
                            //$dueno=$carga_academica->getProfesor();
                            $grupo=$carga_academica->getGrupo();
                            $asignatura=$carga_academica->getAsignatura();                     
                            $em->getRepository("NetpublicCoreBundle:Dimension")
                               ->adicionarComponente($grupo,$asignatura,$entity,$nombre,$ponderado);
                            $padre_items_[$index3]=0;
                                        
                        }
                    }
            }       
    }
    private function deleteDimensionesPadreGc($asg,$ano_escolar,$grupo) {
        $em=  $this->getDoctrine()->getManager();
        $periodos_academicos=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodosEscolar($ano_escolar);
        foreach ($periodos_academicos as $periodo) {
            $dimensiones=$em->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
                'asignatura'=>$asg->getId(),
                'grupo'=>$grupo->getId(),
                'padre'=>$periodo->getId()
            ));
            foreach ($dimensiones as $dim) {
                $notas=$em->getRepository("NetpublicCoreBundle:AlumnoDimension")->findBy(array(
                    'dimension'=>$dim->getId()
                ));
                foreach ($notas as $n) {
                    $em->remove($n);
                }
                $em->remove($dim);
            }
        }
    }
    private function crearDimensionesPadreGc($padre,$ca) {
        $em=  $this->getDoctrine()->getManager();
        $grupo=$ca->getGrupo();
        $asg=$ca->getAsignatura();
        $ano_escolar=$ca->getAnoEscolar();
        $periodos_academicos=$em->getRepository("NetpublicCoreBundle:Dimension")->findPeriodosEscolar($ano_escolar);
        $dimensiones=$em->getRepository("NetpublicCoreBundle:Dimension")->getModeloComp($padre->getId());
        if($grupo){
            $alumnos_a=$em->getRepository("NetpublicCoreBundle:MatriculaAlumno")->findBy(array(
                'ano'=>$ano_escolar->getId(),
                'grupo'=>$grupo->getId()
            ));
        
            $alumnos=array();
            foreach ($alumnos_a as $vma) {
                $alumnos[]=$vma->getAlumno();
            }
                $loop_comp=4;
        foreach ($dimensiones as $dim_p) {            
            foreach ($periodos_academicos as $periodo) {
                if($dim_p->getTipogc()!=8){
                    echo "<br/>------------$dim_p {$dim_p->getPonderado()}-------------</br>";
                    $mi_dim=new Dimension();
                    $mi_dim->setAsignatura($asg);
                    $mi_dim->setPadre($periodo);
                    $mi_dim->setPadregc($dim_p);
                    $mi_dim->setTipo(4);
                    $mi_dim->setGrupo($grupo);
                    $mi_dim->setNombre($dim_p->getNombre());
                    $mi_dim->setPonderado($dim_p->getPonderado());
                    $mi_dim->setOrden($periodo->getOrden()-$loop_comp);
                   foreach ($alumnos as $alumno) {
                        $a_d=new AlumnoDimension();
                        $a_d->setAlumno($alumno);
                        $a_d->setAsignatura($asg);
                        $a_d->setDimension($mi_dim);
                        $a_d->setNota(-1);                    
                        $em->persist($a_d);
                    }
                    $em->persist($dim_p);
                    $em->persist($mi_dim);
                    $items=$em->getRepository("NetpublicCoreBundle:Dimension")->getModeloComp($dim_p->getId());
                    $loop_items=1;
                    foreach ($items as $item) {
                        echo $item->getPonderado()."$item";
                        $mi_dim_i=new Dimension();
                        $mi_dim_i->setAsignatura($asg);
                        $mi_dim_i->setPadre($mi_dim);
                        $mi_dim_i->setPadregc($item);
                        $mi_dim_i->setTipo(4);
                        $mi_dim_i->setGrupo($grupo);
                        $mi_dim_i->setNombre($item->getNombre());
                        $mi_dim_i->setPonderado($item->getPonderado());
                        $mi_dim_i->setOrden($dim_p->getOrden()-$loop_items);
                        foreach ($alumnos as $alumno) {
                            $a_d=new AlumnoDimension();
                            $a_d->setAlumno($alumno);
                            $a_d->setAsignatura($asg);
                            $a_d->setDimension($mi_dim_i);
                            $a_d->setNota(-1);
                            $em->persist($a_d);
                        }
                        $em->persist($mi_dim_i);
                        $loop_items++;
                        
                    }
                }
            }
            $loop_comp++;
        }
        
        foreach ($periodos_academicos as $periodo) {
            //Parar nota final de periodo
            foreach ($alumnos as $alumno) {
                    
            $a_d=new AlumnoDimension();
            $a_d->setAlumno($alumno);
            $a_d->setAsignatura($asg);
            $a_d->setDimension($periodo);                   
            $a_d->setNota(-1);                    
            $em->persist($a_d);
            }
            $periodo->setOrden(300);
            $em->persist($periodo);
            //Areas
            $areas_periodos_academicos=$em->getRepository("NetpublicCoreBundle:Dimension")
                                              ->findOneBy(array(
                                                    "padre"=>$periodo->getId(),
                                                    "tipo"=>2
                                                ));
            foreach ($alumnos as $alumno) {
                    
            $a_d=new AlumnoDimension();
            $a_d->setAlumno($alumno);
            $a_d->setAsignatura($asg->getArea());                    
            $a_d->setDimension($areas_periodos_academicos);                                        
            $a_d->setNota(-1);
            $a_d->setNotaBuffered(-1);
            $em->persist($a_d);   
            }
    //fallas
            $falla=$em->getRepository("NetpublicCoreBundle:Dimension")->findOneBy(array(
                'tipo'=>3,
                'padre'=>$periodo->getId()
            ));
            $loop_comp=1;
            foreach ($dimensiones as $dim) {
                //echo $dim.$dim->getTipogc();
                $tipo=$dim->getTipogc();
                if($tipo==8){//Fallas
                    $falla->setOrden(299);
                    $em->persist($falla);            
                    $componente=$falla;
                    foreach ($alumnos as $alumno) {
                    
                    $a_d=new AlumnoDimension();
                    $a_d->setAlumno($alumno);
                    $a_d->setAsignatura($asg);
                    $a_d->setDimension($componente);                   
                    $a_d->setNota(-1);                    
                    $em->persist($a_d); 
                    $em->persist($componente);
                    }
                    //echo "falla";
                 }
                
            }
        }

        
        }
        $em->flush();
    }
    public function deleteCompPadre($padre_id) {
        $em=  $this->getDoctrine()->getManager();
        $session=  $this->getRequest()->getSession();
        $padre=$em->getRepository("NetpublicCoreBundle:Dimension")->find($padre_id);
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:Dimension")->findAnoEscolarActivo();
        $ano_escolar_id_s=$session->get("ano_escolar_id",$ano_escolar_activo->getId());
        $ano_escolar_activo=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->find($ano_escolar_id_s);
        $cargas=$em->getRepository("NetpublicCoreBundle:CargaAcademica")->findBy(array(
            'padre_evaluacion'=>$padre_id
        ));
        foreach ($cargas as $ca) {
            $ca->setPadreEvaluacion();
            $em->persist($ca);            
            $em->getRepository("NetpublicCoreBundle:CargaAcademica")->deleteCarga($ca,$ano_escolar_activo);
        }
        $componentesgc=$em->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
                    'padregc'=>$padre_id
                ));
        foreach ($componentesgc as $com_gc) {
            $componentes_4=$em->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
                'padregc'=>$com_gc->getId(),
                'tipo'=>4
                ));        
            foreach ($componentes_4 as $comp) {
                $notas=$em->getRepository("NetpublicCoreBundle:AlumnoDimension")->findBy(array(
                    'dimension'=>$comp->getId()
                ));
               $comp->setPadregc();
               $em->persist($comp);
                foreach ($notas as $nota) {
                    $em->remove($nota);
                }
                $items=$em->getRepository("NetpublicCoreBundle:Dimension")->findBy(array(
                'padre'=>$comp->getId()           
                    ));
        
                foreach ($items as $item) {
                    $mys_notas=$em->getRepository("NetpublicCoreBundle:AlumnoDimension")->findBy(array(
                    'dimension'=>$item->getId()
                    ));
                    foreach ($mys_notas as $nota) {
                        $em->remove($nota);
                    }                
                    $em->remove($item);
                }
                $em->remove($comp);
            }
            $com_gc->setPadregc();
            $em->persist($com_gc);
            $em->remove($com_gc);
        }
        $em->remove($padre);
        $em->flush();
        
    }
    
}
