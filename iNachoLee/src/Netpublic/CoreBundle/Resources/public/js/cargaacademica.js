
tipo_global=0;
////////CargaAcademica de un Colegio
///////
/////
///
//
//
///
/////
///////
////////
function showCargaAcademicainfoAcademicaDefectoAno(id){  
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Detalles de Carga Academica...........");
    alerta_principal.show();
    $.get(entorno+"cargaAcademica/"+id+"/show",function(data){
            $("#tab5-0").html(data);            
          alerta_principal.html("Listo");alerta_principal.hide(5000);
            
        });        
}

function indexCargaAcademicainfoAcademicaDefectoAno(){ 
    
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Lista de las Cargas Academicas.......");
    alerta_principal.show();
    $.get(entorno+"aula/1/horarios",function(data){
            $("#_well10-1").html(data);            
           alerta_principal.html("Listo");alerta_principal.hide(5000);
            
        });  
    return;    
}

function editarCargaAcademicainfoAcademicaDefectoAno(id){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Interfaz para Editar Carga Academica.......");
    alerta_principal.show();
    $.get(entorno+"cargaccademica/"+id+"/edit",function(data){
            $("#tabs2-0").html(data);            
           alerta_principal.html("Listo");alerta_principal.hide(5000);
            
        });        
}
function updateCargaAcademicainfoAcademicaDefectoAno(id){
    token=$("#ntp_inacholeebundle_CargaAcademicatype__token").val();
    
    nombre=$("#ntp_inacholeebundle_CargaAcademicatype_nombre").val();
    
    var data = {
                ntp_inacholeebundle_CargaAcademicatype:{
                        nombre: nombre,                 
                        _token: token

                }
            };  
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Actualizando Carga Academica.......");
    alerta_principal.show();
    $.post(entorno+"CargaAcademica/"+id+"/update",data,function(data){
            $.post(entorno+"CargaAcademica",data,function(data){
                $("#tabs2-0").html(data);            
                alerta_principal.html("Listo");alerta_principal.hide(5000);
            });
            
            
        });        
}
function newCargaAcademicainfoAcademicaDefectoAno(){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Interfaz para Nueva Carga Academica.......");
    alerta_principal.show();
    $.post(entorno+"cargaacademica/new",function(data){
            $("#tabs6-0").html(data);            
           alerta_principal.html("Listo");alerta_principal.hide(5000);
            
        });        
}
         
function createCargaAcademicainfoAcademicaDefectoAno(){
               
    token=$("#ntp_inacholeebundle_cargaacademicatype__token").val();
    profesor=$("#ntp_inacholeebundle_cargaacademicatype_profesor").val();
    grupo=$("#ntp_inacholeebundle_cargaacademicatype_grupo").val();
    profesor=$("#ntp_inacholeebundle_cargaacademicatype_profesor").val();    
    asignatura=$("#ntp_inacholeebundle_cargaacademicatype_asignatura").val();
    aula=$("#ntp_inacholeebundle_cargaacademicatype_aula").val();    
    var data = {
                ntp_inacholeebundle_cargaacademicatype:{
                        profesor: profesor,                 
                        _token: token,
                        grupo: grupo,
                        asignatura:asignatura,
                        aula:aula

                }
            };
     alerta_principal=$("#alerta_principal");
    alerta_principal.html("Creando  Nueva Carga Academica.......");
    alerta_principal.show();   
    $.post(entorno+"cargaacademica/create",data,function(data_){
            $.get(entorno+"cargaacademica/",function(data){
                $("#tabs6-0").html(data);            
               alerta_principal.html("Listo");alerta_principal.hide(5000);
               
            });
            
            
        });        
}
function deleteCargaAcademicainfoAcademicaDefectoAno(e){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Borrando Carga Academica.......");
    alerta_principal.show();   
    $.post(entorno+"dimension/"+e+"/delete",function(data){
            $("#tabs1-1").html(data);            
           alerta_principal.html("Listo");alerta_principal.hide(5000);
            
        });        
}
function procesarFiltrosCargaAcademica(){
    profesor_cargaacademica=$("#profesor_cargaacademica").val();
    grupo_cargaacademica=$("#grupo_cargaacademica").val();
    asignatura_cargaacademica=$("#asignatura_cargaacademica").val();
    aula_cargaacademica=$("#aula_cargaacademica").val();
    var data={
        profesor: profesor_cargaacademica,
        grupo: grupo_cargaacademica,
        asignatura: asignatura_cargaacademica,
        aula: aula_cargaacademica
    }    
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Procesando fltros.......");
    alerta_principal.show();
    $.post(entorno+"cargaacademica/",data,function(data){
            $("#_well10-1").html(data);            
           alerta_principal.html("Listo");alerta_principal.hide(5000);
            
        });  
   
}
function procesarFiltroProfesorGrupoCargaAcademica(){
    
    profesor_cargaacademica=$("#profesor_cargaacademica").val();
    grupo_cargaacademica=$("#grupo_cargaacademica").val();
    asignatura_cargaacademica=$("#asignatura_cargaacademica").val();
    aula_cargaacademica=$("#aula_cargaacademica").val();
    var data={
        profesor: profesor_cargaacademica,
        grupo: grupo_cargaacademica,
        asignatura: asignatura_cargaacademica,
        aula: aula_cargaacademica
    }    
     alerta_principal=$("#alerta_principal");
                    alerta_principal.html("Cargando Carga Academica aplicando Filtros....");
                    alerta_principal.show();
    $.post(entorno+"cargaacademica/filtros",data,function(data){
            $("#_well10-1").html(data);            
           alerta_principal.html("Listo");alerta_principal.hide(5000);
            
        });  
}
function procesarFiltrosEditarVariosCargaAcademica(){
    profesor_cargaacademica_editarvarios=$("#profesor_cargaacademica").val();
    grupo_cargaacademica_editarvarios=$("#grupo_cargaacademica").val();    
    
    var data={
        profesor: profesor_cargaacademica_editarvarios,
        grupo: grupo_cargaacademica_editarvarios    
    } 
    $("#alerta_principal").html("Cargando.....");
    $.post(entorno+"cargaacademica/",data,function(data){
            $("#_well10-1").html(data);            
           $("#alerta_principal").html("Listo");
            
        });  
   
}
function procesarFiltrosAulasCargaAcademica(){ 
    
    id_aula=$("#aula_cargaacademica").val();
    if(id_aula==""){
        alert("Debe de seleccionar:AULA");
        return;
    }
    id_aula_global=id_aula;
    alerta_principal=$("#alerta_principal");
                    alerta_principal.html("Cargando....");
                    alerta_principal.show();
    $.get(entorno+"aula/"+id_aula+"/horarios",function(data){               
           $("#_well10-1").html(data);
          alerta_principal.html("Listo");alerta_principal.hide(5000);
                
               
     });
    
}
function showCargaAcademicaEditarVario(){
     var data={
        profesor_editarvarios: '*',
        grupo_editarvarios: '*',
        asignatura_editarvarios: '*',
        aula_editarvarios: '*'
    }  
    $("#alerta_principal").html("Cargando.....");
     $.get(entorno+"cargaacademica/editvarios",data,function(data){
                $("#_tabs10-2").html(data);            
               $("#alerta_principal").html("Listo");
               
     });
}
function updateAllCargaAcademica(){        
    $.post(entorno+"grupo/1/1/2/calificarf", p_nota_json,helperupdateGrupoAsignatura);     
}
function getDisponibilidadCA(){
     ntp_inacholeebundle_cargaacademicaftype_grupo=$("#ntp_inacholeebundle_cargaacademicaftype_grupo").val();
     ntp_inacholeebundle_cargaacademicaftype_asignatura=$("#ntp_inacholeebundle_cargaacademicaftype_asignatura").val();
     ntp_inacholeebundle_cargaacademicaftype_profesor=$("#ntp_inacholeebundle_cargaacademicaftype_profesor").val();
     
     $.post(entorno+"profesor/"+ntp_inacholeebundle_cargaacademicaftype_asignatura+"/"+ntp_inacholeebundle_cargaacademicaftype_profesor+"/cargaacademica",function(data){
         informador_errores_profesor_carga_academica=$("#informador_errores_profesor_carga_academica");
         if(data==-1){
             
             informador_errores_profesor_carga_academica.addClass('error_ajax');
             informador_errores_profesor_carga_academica.removeClass('exito_ajax');
             informador_errores_profesor_carga_academica.html("No tiene Horas Disponible");
             ntp_inacholeebundle_cargaacademicaftype_profesor=$("#ntp_inacholeebundle_cargaacademicaftype_profesor option:first").attr("selected","selected")
             
         }
         else{
             informador_errores_profesor_carga_academica.addClass('exito_ajax');
             informador_errores_profesor_carga_academica.removeClass('error_ajax');
             informador_errores_profesor_carga_academica.html("OK");
         }
     });     


}
function getAsignaturasGrupoCargaAcademica(){
         ntp_inacholeebundle_cargaacademicaftype_grupo=$("#ntp_inacholeebundle_cargaacademicaftype_grupo").val();
         $("#notificador_general_ca").html("Cargando asignaturas....Espere.")   
         $.post(entorno+"grupo/"+ntp_inacholeebundle_cargaacademicaftype_grupo+"/asignaturas",function(data){
             ntp_inacholeebundle_cargaacademicaftype_asignatura=$("#ntp_inacholeebundle_cargaacademicaftype_asignatura")
             ntp_inacholeebundle_cargaacademicaftype_asignatura.html(data);
             $("#notificador_general_ca").html("Listo.");
         
        });     
}
function getGrupoGradoCargaAcademica(){
    alerta_principal=$("#notificador_general_ca");
        alerta_principal.html("Cargando Grupos.......Espere");
    
    ntp_inacholeebundle_cargaacademicaftype_grado=$("#ntp_inacholeebundle_cargaacademicaftype_grado").val();
     $.get(entorno+"grado/"+ntp_inacholeebundle_cargaacademicaftype_grado+"/grupos",function(data){                                                         
            ntp_inacholeebundle_cargaacademicaftype_grupo=$("#ntp_inacholeebundle_cargaacademicaftype_grupo");
            ntp_inacholeebundle_cargaacademicaftype_grupo.html(data);
            alerta_principal.html("Listo");alerta_principal.hide(5000);
            return;
    }); 
}
function getProfesorAsignaturaCargaAcademica(){
    alerta_principal=$("#notificador_general_ca");
        alerta_principal.html("Cargando Profesores que pueden dictar la Asignatura.......Espere");
    ntp_inacholeebundle_cargaacademicaftype_asignatura=$("#ntp_inacholeebundle_cargaacademicaftype_asignatura").val();
    $.get(entorno+"contrato/"+ntp_inacholeebundle_cargaacademicaftype_asignatura+"/getcontrato",function(data){                                                         
            ntp_inacholeebundle_cargaacademicaftype_profesor=$("#ntp_inacholeebundle_cargaacademicaftype_profesor");
            ntp_inacholeebundle_cargaacademicaftype_profesor.html(data);
            alerta_principal.html("Listo");alerta_principal.hide(5000);
            return;
    }); 

    
}
function showCargaAcademicaGradoGrupoCargaAcademica(id_profesor){
  alerta_principal=$("#notificador_general_ca");
  alerta_principal.html("Cargando Carga Academica");  
  alerta_principal.show();
  grupo_ca=$("#grupo"+id_profesor).val();
    $.post(entorno+"cargaacademica/"+"1/"+grupo_ca+"/"+id_profesor+"/mostrar",function(data){                                                         
            $("#ca_libres"+id_profesor).html(data);
            alerta_principal.html("Listo");alerta_principal.hide(5000);
            return;
    }); 
    $.post(entorno+"cargaacademica/"+"0/"+grupo_ca+"/"+id_profesor+"/mostrar",function(data){                                                         
            $("#ca_no_libres"+id_profesor).html(data);
            alerta_principal.html("Listo");alerta_principal.hide(5000);
            return;
    });     
}
function eliminarCargaAcademica(){
    if(confirm("Estas seguros de asignar AÑO ESCOLAR A LA CARGA.")){
        mostrarMensajeNotificador("Cargando. ");     
        ano_escolar_id=$("#ano_escolar_id").val();
     var ids = new Array();
     var values = new Array();		
     checks=$("input.optionsCheckboxLibres:checked");
          
     if(checks.length>0){checks.each(function(i){
            s = this.getAttribute('data-id');	    
            ids.push(parseInt(s));
            if($(this).is(':checked'))
                r=1;
            else
                r=0
	   values.push(r);
		
        });		
        var json_values = $.toJSON(values);      
        var json_ids = $.toJSON(ids);      
       $.post(entorno+"cargaacademica/eliminarca",{ids:json_ids,ids_values:json_values},function(data){                                                                
           mostrarFiltrorCargaAcademica();
    });         
}
}
}

function asignarAnoEscolarCarga(){
    if(confirm("Estas seguros de asignar AÑO ESCOLAR A LA CARGA.")){
        mostrarMensajeNotificador("Cargando. ");     
        ano_escolar_id=$("#ano_escolar_id").val();
     var ids = new Array();
     var values = new Array();		
     checks=$("input.optionsCheckboxLibres:checked");
          
     if(checks.length>0){checks.each(function(i){
            s = this.getAttribute('data-id');	    
            ids.push(parseInt(s));
            if($(this).is(':checked'))
                r=1;
            else
                r=0
	   values.push(r);
		
        });		
        var json_values = $.toJSON(values);      
        var json_ids = $.toJSON(ids);      
       $.post(entorno+"cargaacademica/"+ano_escolar_id+"/asignarano",{ids:json_ids,ids_values:json_values},function(data){                                                                
           mostrarFiltrorCargaAcademica();
    });         
}
}
}

function moverCaLibreNoLibre(){
    if(confirm("Estas seguros de Asignar las Cargas Academicas.")){
      alerta_principal=$("#notificador_general_ca");
      alerta_principal.html("Actualizando Profesor en Carga Academica");  
      alerta_principal.show();     
    id_profesor=$("#profesor").val();
     var ids = new Array();
     var values = new Array();		
     checks=$("input.optionsCheckboxLibres:checked");
          
     if(checks.length>0){checks.each(function(i){
            s = this.getAttribute('data-id');	    
            ids.push(parseInt(s));
            if($(this).is(':checked'))
                r=1;
            else
                r=0
	   values.push(r);
		
        });		
        var json_values = $.toJSON(values);      
        var json_ids = $.toJSON(ids);      
       $.post(entorno+"cargaacademica/"+id_profesor+"/moverlibrenolibre",{ids:json_ids,ids_values:json_values},function(data){                                                                
           mostrarFiltrorCargaAcademica();
    });         
}
}
}
function cambiarProfesorCa(){
        if(confirm("Estas seguro De Cambiar Carga Academica")){
     mostrarMensajeNotificador("Cargando. ");   
     id_profesor=$("#profesor").val();
     var ids = new Array();
     var values = new Array();		
     checks=$("input.optionsCheckboxLibres:checked");
          
     if(checks.length>0){checks.each(function(i){
            s = this.getAttribute('data-id');	    
            ids.push(parseInt(s));
            if($(this).is(':checked'))
                r=1;
            else
                r=0
	   values.push(r);
		
        });		
        var json_values = $.toJSON(values);      
        var json_ids = $.toJSON(ids);      
       $.post(entorno+"cargaacademica/"+id_profesor+"/moverprofesor",{ids:json_ids,ids_values:json_values},function(data){                                                                
           mostrarFiltrorCargaAcademica();
            ocultarMensajeNotificador();
    });         
}
        }
}

function moverCaNoLibreLibre(){
    if(confirm("Se Quitaran las Cargas a los profesores. Seguro?")){
      alerta_principal=$("#notificador_general_ca");
      alerta_principal.html("Actualizando Profesor en Carga Academica");  
      alerta_principal.show();         
    id_profesor=$("#profesor").val();
     var ids = new Array();
     var values = new Array();		
     checks=$("input.optionsCheckboxLibres:checked");
    
     if(checks.length>0){        
        checks.each(function(i){
            s = this.getAttribute('data-id');	    
            ids.push(parseInt(s));
            if($(this).is(':checked'))
                r=1;
            else
                r=0
	   values.push(r);
		
        });		
        var json_values = $.toJSON(values);      
        var json_ids = $.toJSON(ids);      
       $.post(entorno+"cargaacademica/"+id_profesor+"/movernolibrelibre",{ids:json_ids,ids_values:json_values},function(data){                                                                
           mostrarFiltrorCargaAcademica();
    });         
}
    }
}

function allCheckBox(elemento,clase){    
    input_check_all=$("#"+elemento);    
   if(input_check_all.is(':checked')){
    //$("input:checkbox."+clase).attr("checked", true);  
    $("input:checkbox."+clase).prop('checked', true);
    //$("input[type=checkbox]").prop('checked', true);
   }
   else{
    //$("input:checkbox."+clase).attr("checked", false);
    $("input:checkbox."+clase).prop('checked', false);
    //$("input[type=checkbox]").prop('checked', false);    
   }
}
function newgestionarCargaAcademica(id,id_profesor){                    
 
   $.post(entorno+"cargaacademica/0/"+id_profesor+"/asignar",function(data){        
         div_ca=$("#profe"+id_profesor);       
         div_ca.html(data);
         div_ca.show('slow');              
           return;
    });         

       
}

function cambiargestionarCargaAcademica(e){                    
  id=e.getAttribute('data-id');
  h_c_p=$("#"+e.id);
  celdas=$("td.celda_intercambiar");
  res='s';
  //alert("Vamos");
  if(celdas.length<2){
      if(h_c_p.hasClass('celda_libre')){
            res='celda_libre';
      }
  }
  if(h_c_p.hasClass('celda_intercambiar')){
       res='celda_intercambiar';       
  }
  if(res=='celda_libre'){
      h_c_p.addClass('celda_intercambiar');
      h_c_p.removeClass('celda_libre');
      
  }
  if(res=='celda_intercambiar'){
      h_c_p.addClass('celda_libre');
      h_c_p.removeClass('celda_intercambiar');
  }    
  
}
function interCambiarHorarioClaseCargaAcademica(id_profesor){
    var celdas_intencambiar=new Array();    
    var ids=new Array();
    
    celdas_intencambiar=$("td.celda_intercambiar");
    div_profesor=$("#horario_clase_profe"+id_profesor);
    div_profesor.html("<span style='font-size:18px;'>Actualizando Horario. Espere</span>")
     
    if(celdas_intencambiar.length==2){
        celdas_intencambiar.each(function(i){
        s = this.getAttribute('data-id');	    
            ids.push(parseInt(s));
        });
       id_h_c_pp=ids[0];
       id_h_c_ps=ids[1];
       $.post(entorno+"horarioclase/"+id_h_c_pp+"/"+id_h_c_ps+"/intercambiar",function(data){                                                                
                $.post(entorno+"horarioclase/"+id_profesor+"/horarioclase",function(data){                                                                
                 
                 div_profesor.html(data);
                 div_profesor.show();
                return;
            });         
 
            return;
            });         

    }      
}
function updateProfesorCargaAcademica(id_carga_academica){                    
      alerta_principal=$("#notificador_general_ca");
      alerta_principal.html("Actualizando Profesor en Carga Academica");  
      alerta_principal.show();

    id_profesor=$("#profesor_ca"+id_carga_academica).val();
    
   $.post(entorno+"cargaacademica/"+id_profesor+"/"+id_carga_academica+"/updateprofesor",function(data){        
         $("#capa_c_a"+id_carga_academica).hide("slow") 
         $("#capa_c_a"+id_carga_academica+'1').hide("slow") 
         alerta_principal.html("Listo"); 
         alerta_principal.hide(5000);
         
           return;
    });         

       
}
function mostrarHorarioProfesorCargaAcademica(id_carga_academica){                    
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Horario De clase.Espere.......");
    alerta_principal.show();
       
    id_profesor=$("#profesor_ca"+id_carga_academica).val();
    
   $.post(entorno+"horarioclase/"+id_profesor+"/horarioclase",function(data){        
         $("#capa_ram_horas"+id_carga_academica).html(data).show();         
         alerta_principal.html("Listo");
         alerta_principal.hide(5000);
         
           return;
    });         

       
}
function moverCaLibreNoLibreFiltro(id_carga_academica){   
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Agregando Clase.Espere.......");
    alerta_principal.show();
    
     var ids = new Array();
     var values = new Array();		                    
     id_profesor=$("#profesor_ca"+id_carga_academica).val();
     if(id_profesor=='*'){
         alert("Por favor seleccion Profesor.");
         return;
     }
     ids.push(parseInt(id_carga_academica));
     r=1;
     values.push(r);	
     var json_values = $.toJSON(values);      
     var json_ids = $.toJSON(ids);      
      $.post(entorno+"cargaacademica/"+id_profesor+"/moverlibrenolibre",{ids:json_ids,ids_values:json_values},function(data){                                                                

            $.post(entorno+"horarioclase/"+id_profesor+"/horarioclase",function(data){                                                                                 
                 $("#capa_ram_horas"+id_carga_academica).html(data);
                             alerta_principal.html("Listo");alerta_principal.hide(5000);       
            });         

            
           return;
    });         
}
function moverCaNoLibreLibreFiltro(id_carga_academica){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Quitando Clase.Espere.......");
    alerta_principal.show();
    
     var ids = new Array();                    
     var values=new Array();
     id_profesor=$("#profesor_ca"+id_carga_academica).val();
     if(id_profesor=='*'){
         alert("Seleccion un Profesor Antes De seguir.");
         return;
     }
         
     ids.push(parseInt(id_carga_academica));     
     r=1;     
     values.push(r);
     var json_values = $.toJSON(values);      
     var json_ids = $.toJSON(ids);      
     $.post(entorno+"cargaacademica/"+id_profesor+"/movernolibrelibre",{ids:json_ids,ids_values:json_values},function(data){                                                                
            alerta_principal.html("Listo"); 
            alerta_principal.hide(5000);            
            $.post(entorno+"horarioclase/"+id_profesor+"/horarioclase",function(data){                                                                                 
                 $("#capa_ram_horas"+id_carga_academica).html(data);
                return;
            });         

           return;
    });         

}
function moverCaNoLibreLibreFiltroLibre(id_carga_academica,id_profesor){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Quitando Clase.Espere.......");
    alerta_principal.show();
    
     var ids = new Array();                    
     var values=new Array();     
     if(id_profesor=='*'){
         alert("Seleccion un Profesor Antes De seguir.");
         return;
     }
         
     ids.push(parseInt(id_carga_academica));     
     r=1;     
     values.push(r);
     var json_values = $.toJSON(values);      
     var json_ids = $.toJSON(ids);      
     $.post(entorno+"cargaacademica/"+id_profesor+"/movernolibrelibre",{ids:json_ids,ids_values:json_values},function(data){                                                                
            alerta_principal.html("Listo"); 
            alerta_principal.hide(5000);            
            mostrarFiltrorCargaAcademica();
            

           return;
    });         

}

function interCambiarHorarioClaseFiltroCargaAcademica(id_carga_academica){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Intercambiando Clases.Espere .......");
    alerta_principal.show();
    id_profesor=$("#profesor_ca"+id_carga_academica).val();
    var celdas_intencambiar=new Array();    
    var ids=new Array();    
    celdas_intencambiar=$("td.celda_intercambiar");
     
    if(celdas_intencambiar.length==2){
        celdas_intencambiar.each(function(i){
        s = this.getAttribute('data-id');	    
            ids.push(parseInt(s));
        });
       id_h_c_pp=ids[0];
       id_h_c_ps=ids[1];
       $.post(entorno+"horarioclase/"+id_h_c_pp+"/"+id_h_c_ps+"/intercambiar",function(data){                                                                
                $.post(entorno+"horarioclase/"+id_profesor+"/horarioclase",function(data){                                                                
                
                $("#capa_ram_horas"+id_carga_academica).html(data);
                alerta_principal.html("Listo.");    
                return;
            });         
 
            return;
            });         

    }      
}


function mostrarFiltrorCargaAcademica(){                    
    mostrarMensajeNotificador("Cargando cargas academicas. ");    
      tipo_clase=$("#tipo_clase").val();
      grupo_id=$("#grupo_id").val();
      grado_id=$("#grado_id").val();
      ano_escolar_id=$("#ano_escolar_id").val();
   $.post(entorno+"cargaacademica/"+tipo_clase+"/"+grupo_id+"/"+ano_escolar_id+"/"+grado_id+"/filtro",function(data){        
       $("#capa_ram_ca_contrato_filtro").html(data);         
        ocultarMensajeNotificador();  
       return;
    });         

       
}
function mostrarListaContratoCargaAcademica(){                    
    mostrarMensajeNotificador("Cargando contratos.");
    $.post(entorno+"cargaacademica/listar",function(data){               
         $("#capa_ram_ca").html(data);         
        ocultarMensajeNotificador(); 
        return;
    });                
}
//Condiciones para COntrato
function verHorarioContratoCargaAcademica(id){
          $.post(entorno+"condicioncontrato/"+id+"/ver",function(data){               
         $("#capa_ram_ca_contrato"+id).html(data);         
         alerta_principal.html("Listo");
         alerta_principal.hide(5000);         
         return;
    });                
         

}

function  mostrarHorarioContrato(id){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando.Espere.......");
    alerta_principal.show();        
    $.post(entorno+"condicioncontrato/"+id+"/generar",function(data){               
        verHorarioContratoCargaAcademica(id);
    });                

}

function procesarClickContratoHorarios(id){
    tipo=cambiarEstadoCelda(id);
       $.post(entorno+"condicioncontrato/"+tipo+"/"+id+"/cambiarestado",function(data){        
            alerta_principal.html("Listo");
            alerta_principal.hide(4000);
            $("#celda_madre"+id).html(data);
   });                       

}
function procesarFilaContratoHorarios(fila,tipo,id){
  $.post(entorno+"condicioncontrato/"+tipo+"/"+fila+"/"+id+"/cambiarestadofila",function(data){        
            alerta_principal.html("Listo");
            alerta_principal.hide(4000);             
            verHorarioContratoCargaAcademica(id);
   });                       

    
}
function procesarColumnaContratoHorarios(columna,tipo,id){       
       $.post(entorno+"condicioncontrato/"+tipo+"/"+columna+"/"+id+"/cambiarestadocolumna",function(data){        
            alerta_principal.html("Listo");
            alerta_principal.hide(4000);         
            verHorarioContratoCargaAcademica(id);
            
   });                       
         
    
}
//Condicion De Grado

function  mostrarHorarioGrado(id){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando.Espere.......");
    alerta_principal.show();        
    $.post(entorno+"condiciongrado/"+id+"/generar",function(data){               
        verHorarioGradoCargaAcademica(id);
    });                

}
function verHorarioGradoCargaAcademica(id){
          $.post(entorno+"condiciongrado/"+id+"/ver",function(data){               
         $("#capa_ram_ca_grado"+id).html(data);         
         alerta_principal.html("Listo");
         alerta_principal.hide(5000);         
         return;
    });                
         

}
function procesarClickGradoHorarios(id){
    tipo=cambiarEstadoCelda(id);
       $.post(entorno+"condiciongrado/"+tipo+"/"+id+"/cambiarestado",function(data){        
            alerta_principal.html("Listo");
            alerta_principal.hide(4000);
            $("#celda_madre"+id).html(data);
   });                       

}
function procesarFilaGradoHorarios(fila,tipo,id){
  $.post(entorno+"condiciongrado/"+tipo+"/"+fila+"/"+id+"/cambiarestadofila",function(data){        
            alerta_principal.html("Listo");
            alerta_principal.hide(4000);             
            verHorarioGradoCargaAcademica(id);
   });                       

    
}
function procesarColumnaGradoHorarios(columna,tipo,id){       
       $.post(entorno+"condiciongrado/"+tipo+"/"+columna+"/"+id+"/cambiarestadocolumna",function(data){        
            alerta_principal.html("Listo");
            alerta_principal.hide(4000);         
            verHorarioGradoCargaAcademica(id);
            
   });                       
         
    
}
//Condiciones para GRupo en carga Academica
function  mostrarHorarioGrupo(id){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando.Espere.......");
    alerta_principal.show();        
    $.post(entorno+"condiciongrupo/"+id+"/generar",function(data){               
        verHorarioGrupoCargaAcademica(id);
    });                

}
function verHorarioGrupoCargaAcademica(id){
          $.post(entorno+"condiciongrupo/"+id+"/ver",function(data){               
         $("#capa_ram_ca_grupo"+id).html(data);         
         alerta_principal.html("Listo");
         alerta_principal.hide(5000);         
         return;
    });                
         

}
function procesarClickGrupoHorarios(id){
    tipo=cambiarEstadoCelda(id);
       $.post(entorno+"condiciongrupo/"+tipo+"/"+id+"/cambiarestado",function(data){        
            alerta_principal.html("Listo");
            alerta_principal.hide(4000);
            $("#celda_madre"+id).html(data);
   });                       

}
function procesarFilaGrupoHorarios(fila,tipo,id){
  $.post(entorno+"condiciongrupo/"+tipo+"/"+fila+"/"+id+"/cambiarestadofila",function(data){        
            alerta_principal.html("Listo");
            alerta_principal.hide(4000);             
            verHorarioGrupoCargaAcademica(id);
   });                       

    
}
function procesarColumnaGrupoHorarios(columna,tipo,id){       
       $.post(entorno+"condiciongrupo/"+tipo+"/"+columna+"/"+id+"/cambiarestadocolumna",function(data){        
            alerta_principal.html("Listo");
            alerta_principal.hide(4000);         
            verHorarioGrupoCargaAcademica(id);
            
   });                       
         
    
}
//Condiciones para el Profesor
function mostrarListaProfesoresCargaAcademica(){                    
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Profesores.Espere.......");
    alerta_principal.show();        
   $.post(entorno+"cargaacademica/listar/profesores",function(data){               
         $("#capa_ram_ca").html(data);         
         alerta_principal.html("Listo");
         alerta_principal.hide(5000);         
         return;
    });                
}

function  mostrarHorarioProfesor(id){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando.Espere.......");
    alerta_principal.show();        
    $.post(entorno+"condicionprofesor/"+id+"/generar",function(data){               
        verHorarioProfesorCargaAcademica(id);
    });                

}
function verHorarioProfesorCargaAcademica(id){
          $.post(entorno+"condicionprofesor/"+id+"/ver",function(data){               
         $("#capa_ram_ca_profesor"+id).html(data);         
         alerta_principal.html("Listo");
         alerta_principal.hide(5000);         
         return;
    });                
         

}
function procesarClickProfesorHorarios(id){
    tipo=cambiarEstadoCelda(id);
       $.post(entorno+"condicionprofesor/"+tipo+"/"+id+"/cambiarestado",function(data){        
            alerta_principal.html("Listo");
            alerta_principal.hide(4000);
            $("#celda_madre"+id).html(data);
   });                       

}
function procesarFilaProfesorHorarios(fila,tipo,id){
  $.post(entorno+"condicionprofesor/"+tipo+"/"+fila+"/"+id+"/cambiarestadofila",function(data){        
            alerta_principal.html("Listo");
            alerta_principal.hide(4000);             
            verHorarioProfesorCargaAcademica(id);
   });                       

    
}
function procesarColumnaProfesorHorarios(columna,tipo,id){       
       $.post(entorno+"condicionprofesor/"+tipo+"/"+columna+"/"+id+"/cambiarestadocolumna",function(data){        
            alerta_principal.html("Listo");
            alerta_principal.hide(4000);         
            verHorarioProfesorCargaAcademica(id);
            
   });                       
         
    
}
/*Mostrar Condicion Asignaturas*/
function mostrarListaAsignaturasCargaAcademica(){                    
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Asignaturas.Espere.......");
    alerta_principal.show();        
   $.post(entorno+"cargaacademica/listar/asignaturas",function(data){               
         $("#capa_ram_ca").html(data);         
         alerta_principal.html("Listo");
         alerta_principal.hide(5000);         
         return;
    });                
}

function  mostrarHorarioAsignatura(id){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando.Espere.......");
    alerta_principal.show();        
    $.post(entorno+"condicionasignatura/"+id+"/generar",function(data){               
        verHorarioAsignaturaCargaAcademica(id);
    });                

}
function verHorarioAsignaturaCargaAcademica(id){
          $.post(entorno+"condicionasignatura/"+id+"/ver",function(data){               
         $("#capa_ram_ca_asignatura"+id).html(data);         
         alerta_principal.html("Listo");
         alerta_principal.hide(5000);         
         return;
    });                
         

}
function procesarClickAsignaturaHorarios(id){
    tipo=cambiarEstadoCelda(id);
       $.post(entorno+"condicionasignatura/"+tipo+"/"+id+"/cambiarestado",function(data){        
            alerta_principal.html("Listo");
            alerta_principal.hide(4000);
            $("#celda_madre"+id).html(data);
   });                       

}
function procesarFilaAsignaturaHorarios(fila,tipo,id){
  $.post(entorno+"condicionasignatura/"+tipo+"/"+fila+"/"+id+"/cambiarestadofila",function(data){        
            alerta_principal.html("Listo");
            alerta_principal.hide(4000);             
            verHorarioAsignaturaCargaAcademica(id);
   });                       

    
}
function procesarColumnaAsignaturaHorarios(columna,tipo,id){       
       $.post(entorno+"condicionasignatura/"+tipo+"/"+columna+"/"+id+"/cambiarestadocolumna",function(data){        
            alerta_principal.html("Listo");
            alerta_principal.hide(4000);         
            verHorarioAsignaturaCargaAcademica(id);
            
   });                       
         
    
}

function mostrarProfesoresCaPaginador(name_div,href){    
    
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Nueva pagina De tu búsqueda. Espere....");
    alerta_principal.show();
    capa_trabajo=$("#"+name_div);
    html='<div style="text-align:center;margin-top:25px;"><img src="'+url_web+'uploads/loader.gif"></div>';
    capa_trabajo.html(html);
    $.post(href,function(data){          
            capa_trabajo.html(data);         
            alerta_principal.html("Listo"); 
            alerta_principal.hide(5000);
    
      });
    
    
}
function actualizarConfiguracionCa(){     
     var ids = new Array();
     var nro_clase_dia=$("#nro_clase_dia").val();
     var values = new Array();		
     checks=$("input.fichas_horas");     
     if(checks.length>0){
        checks.each(function(i){
            s = this.getAttribute('data-id');	                
           valor= this.value;           
           values.push(valor);
           ids.push(parseInt(s));                   		
        });		
        var json_values = $.toJSON(values);      
        var json_ids = $.toJSON(ids);      
        $.post(entorno+'horarioclase/updateconfiguracion',
                {
                    ids_nota:json_ids,
                    values:json_values,
                    nro_clase_dia: nro_clase_dia
                }, function(res){
		alerta_principal.html("Listo");
                alerta_principal.hide(5000);
		newConfiguracionHorarioClase();
        });      
    
    }        
  
  return ;
     


}
