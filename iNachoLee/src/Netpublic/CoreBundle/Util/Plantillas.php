<?php
namespace Netpublic\CoreBundle\Util;
use Netpublic\CoreBundle\Entity\TagPlantilla;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Plantillas
 *
 * @author yuri
 */
class Plantillas {
    static public function getFotoAlumno($tipo="defecto"){
    if($tipo=="defecto"){
        $resultado="{%if alumno.usuario.getEsFotoperfil()==TRUE%}";
        $resultado.='<img alt="{{alumno}}" class="img-thumbnail"'; 
        $resultado.="src='/iNachoLee/web/uploads/documents/strongalumno{{alumno.id}}.png' alt=\"{{alumno}}\" />";
        $resultado.='{%else%}';
        $resultado.='<img alt="{{alumno}}" class="img-thumbnail" src="/iNachoLee/web/uploads/documents/strongavatar.png" ';
        $resultado.='alt="{{alumno}}" />';                    
        $resultado.='{%endif%}';  
    }
    if($tipo=="circle"){
        $resultado="{%if alumno.usuario.getEsFotoperfil()==TRUE%}";
        $resultado.='<img alt="{{alumno}}" class="img-circle"'; 
        $resultado.="src='/iNachoLee/web/uploads/documents/strongalumno{{alumno.id}}.png' alt=\"{{alumno}}\" />";
        $resultado.='{%else%}';
        $resultado.='<img alt="{{alumno}}" class="img-circle" src="/iNachoLee/web/uploads/documents/strongavatar.png" ';
        $resultado.='alt="{{alumno}}" />';                    
        $resultado.='{%endif%}';  
    }
       if($tipo=="redondo"){
        $resultado="{%if alumno.usuario.getEsFotoperfil()==TRUE%}";
        $resultado.='<img alt="{{alumno}}" class="img-rounded"'; 
        $resultado.="src='/iNachoLee/web/uploads/documents/strongalumno{{alumno.id}}.png' alt=\"{{alumno}}\" />";
        $resultado.='{%else%}';
        $resultado.='<img alt="{{alumno}}" class="img-rounded" src="/iNachoLee/web/uploads/documents/strongavatar.png" ';
        $resultado.='alt="{{alumno}}" />';                    
        $resultado.='{%endif%}';  
    }


        return $resultado;      
          
    }
    static public function getPlantilla($referencia,$tipo=0){
        //Plantilla para los boletines.
         if($referencia==1 && $tipo==0){
               $resultado='<table style="width:100%;" class="table table-bordered table-boletin">';
               $resultado.='<thead>';
               $resultado.='  <tr>';
               $resultado.='      <td>Areas/Asignaturas</td>';
               $resultado.='      {%for periodo_academico in periodos_escolares%}';
               $resultado.='      <td class="{%if loop.last%}item_fast_boletin{%endif%}">  ';                  
               $resultado.='          P{{loop.index}}';
               $resultado.='      </td>';
               $resultado.='      {%endfor%}';
               $resultado.='      <td>Def</td>';
               $resultado.='      <td>Desmp</td>';
               $resultado.='      <td>Fallas</td>';
               $resultado.='  </tr>';
               $resultado.='</thead>';
               $resultado.='<tbody>';
               $resultado.='  {%for areas in datos%}';
               $resultado.='  <tr>';
               $resultado.='      <td><strong>  {{areas.nombre|upper}}</strong></td>';
               $resultado.='      {%for periodo_academico in periodos_escolares%}';
               $resultado.='      <td class="{%if loop.last%}item_fast_boletin{%endif%}"></td>';
               $resultado.='      {%endfor%}';
               $resultado.='      <td>';
               $resultado.="          {{areas.nota_promedio_acumalativa|number_format(1,'.',',')}}";
               $resultado.='      </td>';
               $resultado.='      <td>';
               $resultado.='          {{areas.desempeno}}';
               $resultado.='      </td>';
               $resultado.='      <td>';
               $resultado.='      {%if areas.inasistencia!=0 and areas.inasistencia!=-1  %}  '; 
               $resultado.='          {{areas.inasistencia}}';
               $resultado.='     {%endif%}';
               $resultado.='     </td>   ';     

               $resultado.=' </tr>';
               $resultado.='  {%for asignaturas_area in areas.asignaturas%}';
               $resultado.='  <tr>';
               $resultado.='      <td class="asg_item ">{{asignaturas_area.asignatura.nombre|lower}}</td>';
               $resultado.='      {%for periodos_asignatura in asignaturas_area.asignatura.periodos %}';
               $resultado.='          <td class="{%if loop.last%}item_fast_boletin{%endif%}" >';
               $resultado.="              {{periodos_asignatura.periodo.nota|number_format(1,'.',',')}}";
               $resultado.='          </td>';
               $resultado.='      {%endfor%}';
               $resultado.='           <td>';
               $resultado.="              {{asignaturas_area.asignatura.nota|number_format(1,'.',',')}}";
               $resultado.='          </td>';
               $resultado.='          <td> </td>';
               $resultado.='          <td>';
               $resultado.='              {%if asignaturas_area.asignatura.inasistencias !=0 and asignaturas_area.asignatura.inasistencias !=-1 %}';
               $resultado.='                  {{asignaturas_area.asignatura.inasistencias}}';
               $resultado.='              {%endif%}';
               $resultado.='          </td>';

               $resultado.='  </tr>';
               $resultado.=' {%endfor%}';

               $resultado.='  {%endfor%}';
               $resultado.='</tbody>';
               $resultado.='</table>'; 
            }
        //Plantillas para boletines de  prescolar
         if($referencia==1 && $tipo==1){
                $resultado=" ";
                $resultado.="<table class='table table-bordered'>";
                $resultado.='{%for areas in datos%}';
                $resultado.="<tr style='background-color:yellow;'>";
                $resultado.="<td  colspan='3'>AREA <span style='margin-left:200px;'>{{areas.nombre|upper}}</span></td>"; 
                $resultado.="<td>{{areas.nota_promedio_acumalativa}}</td>";
                $resultado.="<td>{{areas.desempeno}}</td>";              
                
                $resultado.="</tr>";
                
                $resultado.="{% for asignaturas_area in areas.asignaturas%}";
                $resultado.="<tr>";
                $resultado.="<td style='text-align:center;'> <strong>ASIGNATURA</strong><br/>{{asignaturas_area.asignatura.nombre|lower}}";
                $resultado.="<br/>Fallas :{{asignaturas_area.asignatura.inasistencias}} ";
                $resultado.="<br/><strong>DOCENTE</strong> <br/>{{asignaturas_area.asignatura.profesor}}";                
                $resultado.="</td>";
                $resultado.="<td style='text-align:center;'><span>IH</span><br/>{{asignaturas_area.asignatura.ih}}</td>";                
                $resultado.="<td>";
                $resultado.="<strong style='text-align:center;'><center>INDICADORES DE DESEMPEÑO</center></strong><br/>";
                $resultado.='{%for desempenos_asg in asignaturas_area.asignatura.desempenos%}';
                $resultado.='   {%for desempeno_asg in desempenos_asg%}';
                $resultado.='        <strong>{{loop.index}}.</strong> {{desempeno_asg}}<br/>';
                $resultado.='   {%endfor%}';
                $resultado.='{%endfor%} ';  
                
                $resultado.="</td>";
                $resultado.="<td>{{asignaturas_area.asignatura.nota}}</td>";                
                $resultado.="<td>{{asignaturas_area.asignatura.valor_desempeno}}</td>";  
                $resultado.="</tr>"; 
                $resultado.="{%endfor%}";
                
                $resultado.="{%endfor%}";
                $resultado.="</table>";
                $resultado.="<h5>Observaciones.</h5>";
                $resultado.="{%for observacion in observaciones%}";
                $resultado.="<p><strong>{{loop.index}}.</strong>  {{observacion}}</p>";
                $resultado.="{%endfor%}";
        }  
        //Plantillas para boletines de  prescolar
         if($referencia==1 && $tipo==2){
                $resultado=" ";
                $resultado.='<table  class="table table-bordered table-boletin" style="margin-top: 15px;">';
                $resultado.='        <tr style="height: 40px;font-weight: 900;font-size: 20px;">';
                $resultado.='            <td><strong>Areas/Asignaturas</strong></td>';
                $resultado.='            {%for periodo_academico in periodos_escolares%}';
                $resultado.='                <td><strong>P{{loop.index}}</strong></td>';
                $resultado.='            {%endfor%}';
                $resultado.='            <td><strong>Def</strong></td>';
                $resultado.='            <td><strong>Desemp </strong></td>';
                $resultado.='            <td><strong>Descriptores|Logros</strong></td>';
                $resultado.='            <td><strong>Fallas</strong></td>';
                $resultado.='         </tr>   ';
                $resultado.='     {%for areas in datos%}';
                $resultado.="        <tr {%if areas.desempeno=='BAJO'%}";
                $resultado.='              style="color: red;font-weight: 600;"';
                $resultado.="            {%elseif areas.desempeno=='SUPERIOR'%}";
                $resultado.='              style="color: green;font-weight: 600;"';
                $resultado.='            {%endif%}>';
                $resultado.='            <td><strong>{{areas.nombre|upper}}</td>';
                $resultado.='            {%for periodo_academico in periodos_escolares%}';
                $resultado.='                <td>--</td>';
                $resultado.='            {%endfor%}';
                $resultado.='            <td>{{areas.nota_promedio_acumalativa}}</td>';
                $resultado.='            <td>';
                $resultado.='                 {{areas.desempeno}}';
                $resultado.='            </td>';
                $resultado.='            {%if areas.inasistencia!=0%}';
                $resultado.='                <td>{{areas.inasistencia}}</td>';
                $resultado.='            {%else%}';
                $resultado.='                <td>  </td>';
                $resultado.='            {%endif%} ';         
                $resultado.='         </tr> ';   
                $resultado.='         {% for asignaturas_area in areas.asignaturas%}';
                $resultado.='         <tr style="clear: both">';
                $resultado.='                 <td>{{asignaturas_area.asignatura.nombre|lower}}</td>';         
                $resultado.='                 {%for periodos_asignatura in asignaturas_area.asignatura.periodos %}';
                $resultado.='                    <td>{{periodos_asignatura.periodo.nota}}</td>';
                $resultado.='                 {%endfor%}';   
                $resultado.='                 <td>{{asignaturas_area.asignatura.nota}}</td> ';    
                $resultado.='                 <td>-</td>';
                $resultado.='                 <td style="text-align: justify;">';
                $resultado.='                   {%for desempenos_asg in asignaturas_area.asignatura.desempenos%}';
                $resultado.='                       {%for desempeno_asg in desempenos_asg%}';
                $resultado.='                          {{desempeno_asg}}';
                $resultado.='                      {%endfor%}';
                $resultado.='                   {%endfor%}';    
                $resultado.='                 </td>';
                $resultado.='                 <td>';
                $resultado.='                 {%if asignaturas_area.asignatura.inasistencias!=0%}';
                $resultado.='                       {{asignaturas_area.asignatura.inasistencias}}';
                $resultado.='                 {%endif%}';                    
                $resultado.='                 </td>';                 
                $resultado.='            </tr>';
                $resultado.='          {%endfor%}';

               $resultado.='     {%endfor%}';
               $resultado.='     </table>';  

        }  
        
         //Plantilla para Constancia
         if($referencia==2){
             $resultado='<h3 style="text-align: center;margin-top: 25px;">H A C E<span style="color: white;width: 10px;">';
             $resultado.='&nbsp;&nbsp;&nbsp;&nbsp</span>      C O N S T A R:</h3>';
             $resultado.='<p style="font-size: 18px;text-align: justify;font-family: sans-serif;">';
             $resultado.='Que, <strong>{{alumno}}</strong> identificada con ';
             $resultado.='{%if alumno.getTipoDocumento()==1 %}';
             $resultado.='            Cedula Ciudadania';
             $resultado.='         {%elseif alumno.getTipoDocumento()==2%}  '; 
             $resultado.='            Tarjeta de Identidad';
             $resultado.='         {%elseif alumno.getTipoDocumento()==3%}';   
             $resultado.='            Cédula de Extranjería ó Identificación de Extranjería';
             $resultado.='         {%elseif alumno.getTipoDocumento()==4%} ';  
             $resultado.='            Registro Civil de Nacimiento';
             $resultado.='         {%elseif alumno.getTipoDocumento()==5%} ';  
             $resultado.='            Número de Identificación Personal (NIP)';
             $resultado.='         {%elseif alumno.getTipoDocumento()==6%}   ';
             $resultado.='            Número de Identificación establecido por la Secretaría de  Educación';
             $resultado.='         {%elseif alumno.getTipoDocumento()==7%} ';  
             $resultado.='            Certificado Cabildo';
             $resultado.='         {%endif%}  '; 
             $resultado.='Nº {{alumno.cedula}} de ';
             $resultado.='{%if alumno.departamento is null%}';
             $resultado.='________________';
             $resultado.='{%else%}';
             $resultado.='{{alumno.departamento}} ';
             $resultado.='{%endif%} es estudiante de esta Institución Educativa y se encuentra cursando el'; 
             $resultado.='grado {{alumno.grado}} de Educación ';
             $resultado.='{%if alumno.grado.getNivelesEducativo()==1 %}'; 
             $resultado.='    Nivel PreEscolar';
             $resultado.='{%elseif alumno.grado.getNivelesEducativo()==2%}';                    
             $resultado.='    Básica Primaria';
             $resultado.='{%elseif alumno.grado.getNivelesEducativo()==3%}';                    
             $resultado.='    Básica Secundaria';
             $resultado.='{%elseif alumno.grado.getNivelesEducativo()==4%}';                                        
             $resultado.='    Media';
             $resultado.='{%endif%}';                    
             $resultado.=' y ha cursado más del 80% de las clases. Asistiendo puntualmente.';
             $resultado.='</p>';
         }
         //Cuerpo para plantilla certificado
         if($referencia==3){
                 $resultado='<table class="table table-bordered  table-boletin">';  
                 $resultado.='<tr>';
                 $resultado.='<td style="background-color: gray;color: white;">AREAS</td>';
                 $resultado.='<td  style="background-color: gray;color: white;">';
                 $resultado.='   INTESIDAD(horas)';
                 $resultado.='</td>';
                 $resultado.='<td style="background-color: gray;color: white;">NOTA</td>';
                 $resultado.='<td style="background-color: gray;color: white;">DESEMPEÑO</td>';
                 $resultado.='</tr> ';    
                 $resultado.='{%for area in datos_alumno.areas%} '; 
                 $resultado.='<tr>';     
                 $resultado.='     <td>{{area.nombre}}</td> ';           
                 $resultado.='    <td>{{area.ih}}</td>';            
                 $resultado.='    <td>{{area.nota}}</td>';            
                 $resultado.='    <td>{{area.desempeno|raw}}</td>';
                 $resultado.='</tr> ';       
                 $resultado.='{%endfor%} '; 
                 $resultado.='</table> ';
         }
         return $resultado;   
    }
    
}

?>
