<?php

namespace Netpublic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Netpublic\CoreBundle\Entity\Alumno;
use Netpublic\CoreBundle\Entity\Grupo;
use Netpublic\CoreBundle\Entity\Dimension;
use Netpublic\CoreBundle\Entity\AlumnoDimension;
use Netpublic\CoreBundle\Form\Type\GrupoType;
use Netpublic\CoreBundle\Form\Type\AlumnoType;
use Netpublic\CoreBundle\Form\Type\AlumnoDimensionType;
use Netpublic\CoreBundle\Form\Type\DimensionType;

class InacholeeController extends Controller
{
    
    public function indexAction(Request $request)
    {

        
        return $this->render('NetpublicCoreBundle:Inacholee:index.html.twig', array('name' => $name,
            'form'=>$form,
            "nombre_dimension"=>$nombres_dimensiones,
            "nombre_alumnos"=>$nombres_alumnos));
    }
    public function listarPlanillaAction(Request $request,$id_grupo,$id_dimension){    
        $name="En estos momentos seguimos adelante";        
        $em=$this->getDoctrine()->getEntityManager();
        //Item superiores
        $item_superiores=$this->getDoctrine()
                ->getRepository("NetpublicCoreBundle:Dimension")
                ->GetItemsSuperiores();
        //Se Cargan el Nombre de las Dimensiones y sus respectivas notas,hasta aqui no sabemos el nombre de los alumnos
        
        $n_alumnos_notas=$this->getDimenGrupo(1,$id_dimension,$id_grupo);
        $notas_grupo=$n_alumnos_notas[0];
        $nombres_dimensiones=$n_alumnos_notas[1];
        //Generamos los formularios y sus respectivas vistas
        $n_alumnos_form_vista=$this->generarFormCalificarNotas($notas_grupo,$id_grupo);
        $form=$n_alumnos_form_vista[0];
        $form_obt=$n_alumnos_form_vista[1];
        $nombres_alumnos=$n_alumnos_form_vista[2];
        if($request->getMethod()=="POST"){ 
            for ($index = 0; $index < count($nombres_dimensiones); $index++) {                       
                for ($index1 = 0; $index1 < count($nombres_alumnos); $index1++) {
                        $es_valido=FALSE;
                        $form_obt[$index][$index1]->handleRequest($request);
                        if($form_obt[$index][$index1]->isValid()){
                                //$testimonial=$notas_grupo[$index][$index1]->getNota();
                                $em->persist($notas_grupo[$index][$index1]);                
                                $es_valido=TRUE;
                         }   
                }
             
            }
            $em->flush();
            if($es_valido)                                                                                                         
                return $this->redirect($this->generateUrl('listar_alumnos_dimensiones',array('id_grupo'=>$id_grupo,'id_dimension'=>$id_dimension)));
            $name="Nota de un objeto".$testimonial;
              
        }
       
            return $this->render('NetpublicCoreBundle:Inacholee:listar_alumno_dimensiones.html.twig', array('name' => $name,
            'form'=>$form,
            "nombre_dimension"=>$nombres_dimensiones,
            "nombre_alumnos"=>$nombres_alumnos,
            "id_grupo"=>$id_grupo,
            "id_dimension"=>$id_dimension,    
            "item_superiores"=>$item_superiores));   

    }
    protected function getDimenGrupo($asignatura_id,$dimension_id,$grupo_id){
        $notas_grupo=array();
        $nombres_dimensiones=array();
        //Se Cargar los Elementos en hijos de la dimesion
        $hijos_dimension=$this->getDoctrine()
                ->getRepository("NetpublicCoreBundle:Dimension")
                ->findBy(
                        array("padre"=>$dimension_id)
                        );       
        $index=0;
        
        foreach ($hijos_dimension as $dimension) {
          //$dimension_ids[]=$dimension->getNombre();
            $notas_grupo[]=$this->getDoctrine()
                ->getRepository("NetpublicCoreBundle:AlumnoDimension")
                ->findBy(
                        array("asignatura"=>$asignatura_id,"grupo"=>$grupo_id,"dimension"=>$dimension->getId())
                        );
            if(count($notas_grupo[$index])>0){
                $nombres_dimensiones[$index]=$notas_grupo[$index][0]->getDimension();                
                   $index++;
            }
            else{
               break;
            }
            
        }
        
        $rnombres_dimensiones[]=$notas_grupo;
        $rnombres_dimensiones[]=$nombres_dimensiones;
        return $rnombres_dimensiones;        
    }
    protected function generarFormCalificarNotas($notas_grupo,$grupo_id){
        $form=array();
        $mi_form_obt=array();
        $mi_form_1=array();
        $nombres_alumnos=$this->getDoctrine()
                                    ->getRepository("NetpublicCoreBundle:Alumno")
                                    ->listarAlumnosGrupo($grupo_id)
                                    ->getResult();        
        for ($index2 = 0; $index2 < count($notas_grupo); $index2++) {
            $form_1=array();
            for ($index1 = 0; $index1 < count($notas_grupo[$index2]); $index1++) {
                //Cargo los alumnos
                if($index2==0){
                    $nombres_alumnos[$index1]=$notas_grupo[$index2][$index1]->getAlumno();
                }
                $mi_form_1[$index1] = $this->createForm(new AlumnoDimensionType($notas_grupo[$index2][$index1]->getId()), $notas_grupo[$index2][$index1]);
                $form_1[$index1] = $mi_form_1[$index1]->createView();
            }
            $form[$index2]=$form_1;
            $mi_form_obt[$index2]=$mi_form_1;
                
        }        
        $n_alumnos_form_vista[]=$form;
        $n_alumnos_form_vista[]=$mi_form_obt;
        $n_alumnos_form_vista[]=$nombres_alumnos;
        return $n_alumnos_form_vista;
    }
    
}
