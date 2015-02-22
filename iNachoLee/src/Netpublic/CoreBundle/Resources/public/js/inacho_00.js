/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//
//entorno="http://www.local.inacholee.com/app_test.php/";
//entorno="http://192.168.88.247/app.php/";
//entorno="http://www.local.inacholee.com/app_dev.php/";
//entorno="http://www.local.inacholee.com/app.php/";
//entorno="http://192.168.1.2/app_dev.php/";

//entorno="http://192.168.0.59/iNachoLeeYuri/web/app.php/";
//entorno="http://www.yuribermudez.com/iNachoLeeYuri/web/app.php/";
nota_alumno="nota";
nro_publicaciones=0;
input_ram_focus="";
inputs_notas="";
nombre_nota="";
$obj_input_focus='';
$obj_input_antes_focus='';
index_input_focus=1;
index_global=0;
es_cargado_global=0;
value_input_click_global=0

t="";
c=0;
numeros_alumnos_grupo_a=0;
numeros_alumnos_grupo_b=0;
_numeros_alumnos_grupo_b=0;
VALOR_NOTA=0;
tiempo_update=18000;
notas_grupo_json='{';
notas_grupo_json+='"notas": [';
nota_json='{';
nota_json+='"notas": [';
//Para Carga Academica 
id_horario_aula_global='';
id_aula_global='';
index_global_asistencia=0;
//Para contrados de un profesor.
contrato_json_profesor='';
horario_aula_json_cargaacademica='';
id_carga_academica_global=0;
nro_input_seleccionados_clik=0;
//Para desempeños
id_desempeno_global=-1;
numero_click=1;
ultima_alumno=0;
ids_alumnos_promover=Array();
alumnos=new Array();   
G_FUENTE=0;
CUERPO_BOLETINES=" ";
BANDERA_GESTION_BOLETINE_PARAR=false;
BANDERA_GESTION_BOLETINE_INICIAR=false;
notificador="| ";
x=$(document);
x.ready(function(){
//Bole    
//Colocamos focus  
$('.tarea').each(function(){
        $(this).rotate({angle : 270});
        
    });
    $("#dialogo_custom").hide();
      
    $("input.input_nota:first").focus();
    //filtro Grado-->Asignaturas en Vista Contrato
    $("#ntp_inacholeebundle_contratotype_grado").change(getAsignaturaGrado);
    
    inputs_notas=$('input.input_nota');
    numeros_alumnos_grupo_b=inputs_notas.length-$("input.alumnos").length;
    //Desempeños
    id_desempeno_global=-1;
    
   $("#grupo_b").html(numeros_alumnos_grupo_b);
    //Para el manejo de las influencias de las actividades
    $(".dimensiones_influencias").click(setInfluenciaActividadDescriptor);
    
    //Plugin type-head
    
                                            
  				
});

function actualizarNotaServidor(){    
    id_nota_alumno=0;
    value_nota='-1';
    nota_json+='{ "id_nota_alumno": '+id_nota_alumno+', "valor_nota": "'+value_nota+' " }';
    nota_json+=']';
    nota_json+='}';
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Actualizando Notas....");
    alerta_principal.show();
    p_nota_json=jQuery.parseJSON(nota_json);    
    
        $.post(entorno+"grupo/1/1/2/calificarf", p_nota_json,helperactualizarNotaServidor);        
    //});
    nota_json='{';
    nota_json+='"notas": [';    
    es_cargado_global=1;
    
    return;
}
function helperactualizarNotaServidor(data){
   $("#form_calificar_nota").html(data);            
   $("#flass_tmp").html("<span>listo!!!</span>");
   inputs_notas=$('input.input_nota');
   inputs_notas[index_global].focus();
      $('.tarea').each(function(){
        $(this).rotate({angle : 270});
        
    });
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Listo");alerta_principal.hide(5000);
    alerta_principal.show();
    //$("#alerta_principal").hide();
    //t=setTimeout("actualizarNotaServidor()",tiempo_update);
}
function colocarNotaInput(e){    
     
    VALOR_NOTA=e.value;    
    $("#calificar_foto_valornota").html(VALOR_NOTA);  
    $obj_input_focus.val(VALOR_NOTA); 
   $obj_input_focus.css('color','black');
    if($obj_input_focus.hasClass("grupoAsistencia")){
                    input_seleccionado_asistencia=$obj_input_focus;
                    //input_seleccionado_asistencia.val(parseInt(input_seleccionado_asistencia.val())+1);
                    input_asistencia=$('input.grupoAsistencia');
                    index_global_asistencia=input_asistencia.index(input_seleccionado_asistencia);
                    input_asistencia[index_global_asistencia+1].focus()

    }
    if($obj_input_focus.hasClass("grupoAtividades")){
            inputs_notas=$('input.grupoAtividades');
            nro_notas_actividades=inputs_notas.length;
              index=inputs_notas.index($obj_input_focus)+1;
             if(index>(nro_notas_actividades-1)){
                inputs_notas[0].focus();
            
            }
            else{
              inputs_notas[index].focus();
      
            }
            
    }
    numero_click=1;
}
function procesarFocus(e){
    input_ram_focus=e;
    tmp=e.name;    
    id_nota_alumno=tmp.replace('[nota]',"");
    $obj_input_focus=$("#"+e.id);    
    //agregado    
    if($obj_input_focus.hasClass('grupoAtividades')){    
        $("#lapiz_agil_actividades").show();
        $("#lapiz_agil_fallas").hide();
    }
    if($obj_input_focus.hasClass('grupoAsistencia')){    
        $("#lapiz_agil_actividades").hide();
        $("#lapiz_agil_fallas").show();
    }
    //Mostramos informacion en lapiz agil
    if(!$obj_input_focus.hasClass("notas_lotes")){
    nombre=$("#nombre_alumno_la");
    nota=$("#nota_la");
    
    m=$obj_input_focus.parent().parent().children().eq(0).children().eq(1);
    ul_1=$obj_input_focus.parent().parent().children().index($obj_input_focus.parent());
    l=$obj_input_focus.parent().parent().parent().children().first().children().eq(ul_1+1).children().first().children().first();
    
    nombre_componente=$("#dimension_la").html(l.html());
    nombre.html(m.val());
    nota.html(e.value)
        if(!($obj_input_focus.hasClass('notas_alumno'+ultima_alumno))){    
            getUrlFotoPerfilalumno(m.attr('name'));
        
        }
    }
    //console.info(ultima_alumno)   
    if(!($obj_input_focus.hasClass('notas_alumno_fallas'+ultima_alumno)) && $obj_input_focus.hasClass('grupoAsistencia') ){
        guardarFallasUnoAlumno(ultima_alumno);
        
    }
    if(!($obj_input_focus.hasClass('notas_alumno'+ultima_alumno)) && !$obj_input_focus.hasClass('grupoAsistencia')){
        //console.info("Has Cambiando De alumno");
        guardarNotasUnoAlumno(ultima_alumno);
        
    }
    }
function procesarOnblur(e){ 
    ultima_alumno=e.getAttribute('data-alumno');
    //console.info(ultima_alumno);
    return;
}
function guardarNotasUnoAlumno(clase_alumno){     
     var ids = new Array();
     var values = new Array();
     padre_id=0;
     checks=$("input.notas_alumno"+clase_alumno);     
     if(checks.length>0){
        checks.each(function(i){
            if($(this).hasClass('notas_alumno_padre'+clase_alumno)){
                padre_id=this.getAttribute('data-id');
            }            
            else{
                id= this.getAttribute('data-id');                
                nota= parseFloat(this.value);
                values.push(nota);
                ids.push(parseInt(id));
            }       

        });
     }
     var json_values = $.toJSON(values);      
     var json_ids = $.toJSON(ids);
     data={
         'ids_notas':json_ids,
         'values_notas':json_values,
         'padre':padre_id,
         'alumno_id':clase_alumno
     };
                  
     promedio=$("#r"+padre_id+"_nota").val("..");
     $.post(entorno+'alumno/guardarnotas',data, function(res){
	promedio.val(res);
        });      
    
}
function guardarFallasUnoAlumno(clase_alumno){     
     var ids = new Array();
     var values = new Array();
     padre_id=0;
     checks=$("input.notas_alumno_fallas"+clase_alumno);     
     if(checks.length>0){
        checks.each(function(i){
           
                id= this.getAttribute('data-id'); 
                padre_id=id;
                nota= parseFloat(this.value);
                values.push(nota);
                ids.push(parseInt(id));
           
        });
     }
     var json_values = $.toJSON(values);      
     var json_ids = $.toJSON(ids);
     data={
         'ids_notas':json_ids,
         'values_notas':json_values      
         
     };
     promedio=$("#r"+padre_id+"_nota").val("..");
     $.post(entorno+'alumno/guardarfallas',data, function(res){
         promedio.val(res);
        });      
    
}
function actualizarValoresDescriptivosUnoTodos(periodo_id,grupo_id,carga_id,asignatura_id){ 
    $.post(entorno+'alumno/getalumnos', function(alumnos_text){
        alumnos=jQuery.parseJSON(alumnos_text);
        actualizarValoresDescriptivosUnoUNo(0,periodo_id,grupo_id,carga_id,asignatura_id) 
    });
}
function actualizarValoresDescriptivosUnoUNo(index,periodo_id,grupo_id,carga_id,asignatura_id){ 
        mostrarMensajeNotificador("Actualizando descriptores de "+alumnos[index].nombre);       
        data={
            'periodo_id': periodo_id,
            'grupo_id': grupo_id,
            'ca_id': carga_id,
            'alumno_id' : alumnos[index].id,
            'asignatura_id': asignatura_id
         };
        $.post(entorno+'alumno/updatedesempenos',data, function(res){
            console.info(alumnos[index]);
            if(index>(alumnos.length-2)){
                ocultarMensajeNotificador();
                return;
            }
            actualizarValoresDescriptivosUnoUNo(index+1,periodo_id,grupo_id,carga_id,asignatura_id)
        });      
     
}



function guardarNotasRRUnoAlumno(index,vector,valor_minimo,valor_maximo){     
     var ids = new Array();
     var values = new Array();
     var padre_id=0; 
     var elem_error=null;
    clase_alumno=vector[index]
     
     alumno=$("#alumno_"+clase_alumno);
     mostrarMensajeNotificador("Guardando notas a "+alumno.val())
            
     checks=$("input.notas_alumno"+clase_alumno);     
     if(checks.length>0){
        checks.each(function(i){
            if($(this).hasClass('notas_alumno_padre'+clase_alumno)){
                padre_id=this.getAttribute('data-id');
            }            
            else{
                id= this.getAttribute('data-id');                
                nota= parseFloat(this.value);
                if(nota<=valor_maximo && nota>=valor_minimo){
                    values.push(nota);
                    ids.push(parseInt(id));
                     //$(this).css("background-color",'white');              
                }
                else{                   
                    $(this).css("background-color",'red');                     
                    if(nota==-1)
                        $(this).css("color",'red');
                    mostrarMensajeNotificador("<span style='color:red;'>ERROR, Verifica que el valores de la notas sea valido.</span>");
        
                }
               
            }       

        });
     }
     var json_values = $.toJSON(values);      
     var json_ids = $.toJSON(ids);
     data={
         'ids_notas':json_ids,
         'values_notas':json_values,
         'padre':padre_id,
         'alumno_id':clase_alumno
     };
                  
     promedio=$("#r"+padre_id+"_nota").val("..");
   
     $.post(entorno+'alumno/guardarnotas',data, function(res){
	promedio.val(res);
        ocultarMensajeNotificador();
        //guardarFallasRRAlumno(0,vector);
        //console.info(vector[index]);
        if(index>(vector.length-2)){
            ocultarMensajeNotificador();
            return;
        }
        guardarNotasRRUnoAlumno(index+1,vector,valor_minimo,valor_maximo);
        });      
    
}
function guardarFallasRRAlumno(index,vector){     
     var ids_fallas = new Array();
     var values_fallas = new Array();
     var padre_id_fallas=0;
     clase_alumno=vector[index];
     alumno=$("#alumno_"+clase_alumno);
     mostrarMensajeNotificador("Guardando FALLAS a "+alumno.val())
     
     checks=$("input.notas_alumno_fallas"+clase_alumno);     
     if(checks.length>0){
        checks.each(function(i){
           
                id= this.getAttribute('data-id'); 
                padre_id_fallas=id;
                nota= parseFloat(this.value);
                values_fallas.push(nota);
                ids_fallas.push(parseInt(id));
           
        });
     }
     var json_values_fallas = $.toJSON(values_fallas);      
     var json_ids_fallas = $.toJSON(ids_fallas);
     data={
         'ids_notas':json_ids_fallas,
         'values_notas':json_values_fallas      
         
     };
     promedio_fallas=$("#r"+padre_id_fallas+"_nota").val("..");
     $.post(entorno+'alumno/guardarfallas',data, function(res){
         promedio_fallas.val(res);
          
       if(index>(vector.length-2)){
           ocultarMensajeNotificador();
            return;
        }
        guardarFallasRRAlumno(index+1,vector);

        });      
    
}

function guardarTodosLosAlumnos(valor_minimo,valor_maximo){
     checks=$("input.alumnos");  
     var values = new Array();
     if(checks.length>0){
        checks.each(function(i){  
                console.info(i);
                id= this.getAttribute('name');                
                values[i]=parseInt(id);       
                
        });
        
     }
    guardarNotasRRUnoAlumno(0,values,valor_minimo,valor_maximo);
    guardarFallasRRAlumno(0,values);

}
function procesarMoverIzquierda(e){
  
      inputs_notas=$('input.grupoAtividades');
    index_anterior=inputs_notas.index($obj_input_focus)    
    inputs_notas[index_anterior+1].focus()
    

}
function procesarMoverDerecha(e){
 
    inputs_notas=$('input.grupoAtividades');
    index_anterior=inputs_notas.index($obj_input_focus);
    inputs_notas[index_anterior-1].focus();
}
function procesarMoverAbajo(e){
    numero_alumnos=$("input.alumnos").length
    inputs_notas=$('input.grupoAtividades');
    salto=inputs_notas.length/numero_alumnos;
    index_anterior=inputs_notas.index($obj_input_focus) ;   
    if(index_anterior+salto<inputs_notas.length)
        inputs_notas[index_anterior+salto].focus();
    else{
        inputs_notas[index_anterior].focus();
    }
    
}
function procesarMoverArriba(e){
    numero_alumnos=$("input.alumnos").length
    inputs_notas=$('input.grupoAtividades');
    salto=inputs_notas.length/numero_alumnos;
    index_anterior=inputs_notas.index($obj_input_focus) ;   
    if(index_anterior-salto<inputs_notas.length)
        inputs_notas[index_anterior-salto].focus();
    else{
        inputs_notas[index_anterior].focus();
    }
}

function procesarClick(e){ 
    input_ram_focus=e.id;    
    $obj_input_click=$("#"+e.id); 
    if($obj_input_focus.hasClass('grupoAtividades')){    
        inputs_notas=$('input.grupoAtividades');
        nombre_nota=e.id;     
        nota=$("#"+nombre_nota);         
    //index_global=inputs_notas.index(nota);
    //if(index_global_>=_numeros_alumnos_grupo_b)
     //   return;
    //inputs_notas[index_global].focus();
     if(numero_click==0)
        $obj_input_click.val(VALOR_NOTA);
    
    //Grupos A Grupo B, Calificacion masiva
    $("#VALOR_NOTA_GRUPO_A").val(VALOR_NOTA);
    HAY_GRUPO_B=false;
    HAY_GRUPO_A=false;     
    if($obj_input_click.hasClass('grupoB')){
                      
            $obj_input_click.removeClass('grupoB');                
            //$obj_input_click.addClass('grupoA');                
                
            //numeros_alumnos_grupo_a++;
            //numeros_alumnos_grupo_b--;
            HAY_GRUPO_B=true;
           
    numero_click=1;    
    }
    if($obj_input_click.hasClass('grupoA')){
        $obj_input_click.removeClass('grupoA');                
        //$obj_input_click.addClass('grupoB');  
        //numeros_alumnos_grupo_a--;
        //numeros_alumnos_grupo_b++;
        HAY_GRUPO_A=true
        //$("#grupo_a").html(numeros_alumnos_grupo_a);
        //    $("#grupo_b").html(numeros_alumnos_grupo_b);
        
    }
    if(HAY_GRUPO_B){
       $obj_input_click.addClass('grupoA'); 
    }
    if(HAY_GRUPO_A){
       $obj_input_click.addClass('grupoB'); 
    }
    $("#grupo_a").html($("input.grupoA").length);
    $("#grupo_b").html($("input.grupoB").length);
    }
}
function updateGrupoAsignatura(){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando....");
    alerta_principal.show();
    /*if(c==0){
        t=setTimeout("actualizarNotaServidor()",tiempo_update);
        c++;
    }*/
    asignatura_grupo=$("#asignatura_grupo");    
    $.post(entorno+"grupo/update_grupo_asignatura",{grupo_asignatura: asignatura_grupo.val()},function(){
               
         id_nota_alumno=0
         tmp_notas_grupo_json='{';
         tmp_notas_grupo_json+='"notas": [';
         tmp_nota_json='{';
         tmp_nota_json+='"notas": [';
         tmp_value_nota='-1';
         tmp_nota_json+='{ "id_nota_alumno": '+id_nota_alumno+', "valor_nota": "'+tmp_value_nota+' " }';
         tmp_nota_json+=']';
         tmp_nota_json+='}';
         alerta_principal=$("#alerta_principal");
         alerta_principal.html("Cargando....");
         alerta_principal.show();
         p_nota_json=jQuery.parseJSON(tmp_nota_json);    
         $.post(entorno+"grupo/1/1/2/calificarf", p_nota_json,helperupdateGrupoAsignatura);

    });
        $("#alerta_principal").hide();

    
    
}
function updatePeriodoGrupo(){
    periodo=$("#periodo_calificar_nota").val();
    data={
       periodo: periodo
    }
     $.post(entorno+"grupo/updateperiodo",data,function(data){
                                           
        });
}
function helperupdateGrupoAsignatura(data){
      $("#form_calificar_nota").html(data);           

      inputs_notas=$('input.input_nota');
      inputs_notas[index_global].focus();      
      numeros_alumnos_grupo_b=inputs_notas.length-$("input.alumnos").length;
      _numeros_alumnos_grupo_b=numeros_alumnos_grupo_b;
      
       $('.tarea').each(function(){
        $(this).rotate({angle : 270});
        
    });
    $("#caja_herramientas_calificar").show();
    $("#alerta_principal").hide();
}
function updateAllAlumnos(){
    stop();
    numero_alumnos=$("input.alumnos").length;
    inputs_notas=$('input.input_nota');       
    update_notas_grupo_json='{';
    update_notas_grupo_json+='"notas": [';                                       
    for (i = 0; i < inputs_notas.length-numero_alumnos; i++) {
             primer_elemento=inputs_notas.eq(i);
             value_nota=primer_elemento.val()
             id_nota_alumno_nota=primer_elemento.attr('id');
             id_nota_alumno=id_nota_alumno_nota.replace('_nota','');
             update_notas_grupo_json+='{ "id_nota_alumno": '+id_nota_alumno+', "valor_nota": "'+value_nota+' " },';
    }    
    id_nota_alumno=0;
    value_nota='-1';
    update_notas_grupo_json+='{ "id_nota_alumno": '+id_nota_alumno+', "valor_nota": "'+value_nota+' " }';
    update_notas_grupo_json+=']';
    update_notas_grupo_json+='}';
    p_nota_json=jQuery.parseJSON(update_notas_grupo_json); 
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Actualizando Notas....");
    alerta_principal.show();
    $.post(entorno+"grupo/1/1/2/calificarf", p_nota_json,helperupdateAllAlumnos);     
}
function helperupdateAllAlumnos(data){
    $("#form_calificar_nota").html(data);          
      inputs_notas=$('input.input_nota');
      inputs_notas[index_global].focus();      
      numeros_alumnos_grupo_b=inputs_notas.length-$("input.alumnos").length;
      _numeros_alumnos_grupo_b=numeros_alumnos_grupo_b;      
       $('.tarea').each(function(){
        $(this).rotate({angle : 270});
        
    });
    $("#caja_herramientas_calificar").show();
    $("#alerta_principal").hide();
    //t=setTimeout("actualizarNotaServidor()",tiempo_update);
}
//Colocal parte inician el ACORDEON, todas las vistas
function iniciarinfoDefectoAcademicaDefectoAno(){
    
    //Para los años escolates
     $.post(entorno+"dimension/0",function(data){
            $("#tabs1-0").html(data);                                    
        });  
}
function procesarGrupoA(e){
    inputs_notas_grupo=$('input.grupoA'); 
    jQuery.each(inputs_notas_grupo,function(){
        valor=$("#VALOR_NOTA_GRUPO_A").val();        
        $(this).val(valor);
        $(this).css("color",'black');
    });
    inputs_notas=$('input.grupoAtividades');
   inputs_notas[index_global].focus();
    
}
function procesarGrupoB(e){
    inputs_notas_grupo=$('input.grupoB'); 
    jQuery.each(inputs_notas_grupo,function(){
        valor=$("#VALOR_NOTA_GRUPO_B").val();        
        $(this).val(valor);
        $(this).css("color",'black');
    
    });
    inputs_notas=$('input.grupoAtividades');
     inputs_notas[index_global].focus();
}
function helperprocesarGrupoB(){   
        inputs_notas_grupo=$('input.input_nota'); 
        index_global_=inputs_notas_grupo.index($(this));
        
        if(index_global_>=_numeros_alumnos_grupo_b ){
           ;
        }
        else{
          if($(this).hasClass("grupoB")){
                valor=$("#VALOR_NOTA_GRUPO_B").val();        
                $(this).val(valor);
           }
        }
        
    
}
function procesarTomaMasAsitencia(){
    if($obj_input_focus.hasClass('grupoAsistencia')){
    stop();
    input_seleccionado_asistencia=$obj_input_focus;
    //input_seleccionado_asistencia.val(parseInt(input_seleccionado_asistencia.val())+1);
    input_asistencia=$('input.grupoAsistencia');
    index_global_asistencia=input_asistencia.index(input_seleccionado_asistencia);
    input_asistencia[index_global_asistencia+1].focus()
    }
}
function procesarTomaMenosAsitencia(){
    if($obj_input_focus.hasClass('grupoAsistencia')){
    stop();
    input_seleccionado_asistencia=$obj_input_focus;
    input_seleccionado_asistencia.val(parseInt(input_seleccionado_asistencia.val())+1);
    input_asistencia=$('input.grupoAsistencia');
    index_global_asistencia=input_asistencia.index(input_seleccionado_asistencia);
    input_asistencia[index_global_asistencia+1].focus()
    }
    
}
function procesarCheckCalificacionGrupo(btn){
    input_check_actualizado_automatico=$("#"+btn.id);
    
    if(input_check_actualizado_automatico.is(':checked')){
        t=setTimeout("actualizarNotaServidor()",tiempo_update);        
    }
    else{
       stop();
    }
    
}

function stop(){
    clearTimeout(t);
    return t;
}

function actualizarAllNotasAlumnoGrupo(valor_minimo,valor_maximo){    
     $("#caja_herramientas_calificar").show();
      alerta_principal=$("#alerta_principal");
      alerta_principal.html("Actualizando Notas. Espere....");
     alerta_principal.show();	
     var elem_error=null;
     var checked = new Array();
     var ids = new Array();
     var values = new Array();		
     checks=$("input.input_nota");
     var c=0
     if(checks.length>0){
        checks.each(function(i){
            s = this.getAttribute('data-id');	    
            
           nota= parseFloat(this.value);
           if($(this).hasClass("grupoAsistencia")){
                    values.push(nota);
                    ids.push(parseInt(s));
           }
           if($(this).hasClass('grupoAtividades')){
                if(nota<=valor_maximo && nota>=valor_minimo){
                    values.push(nota);
                    ids.push(parseInt(s));
                }
                else{
                    if(c==0)
                        elem_error=this.id;               
                    c++; 
                }
        }
		
        });		
        if(elem_error!=null){
            t=$("#"+elem_error);
            t.focus();
            t.css("background-color",'red');
            if(t.val()==-1)
            t.css("color",'red');
           alerta_principal.html("<span style='color:red;'>ERROR, Verifica que el wvalores de la notas sea valido.</span>");
            alerta_principal.hide(25000);
            return;
        }     
        var json_values = $.toJSON(values);      
        var json_ids = $.toJSON(ids);      
        $.post(entorno+'grupo/calificarrupdate', {ids_nota:json_ids,values:json_values}, function(res){
		alerta_principal.html("Listo");alerta_principal.hide(5000);
		alerta_principal.html("Cargando Lista de Estudiantes con Notas actualizadas. Espere....");
           $.post(entorno+"grupo/calificareditar",helperactualizarAllNotasAlumnoGrupo);
        });      
    
    }        
  
  return ;
     
}


function actualizarAdicionAllNotasAlumnoGrupo(valor_minimo,valor_maximo){    
     $("#caja_herramientas_calificar").show();
      alerta_principal=$("#alerta_principal");
      alerta_principal.html("Actualizando Notas. Espere....");
     alerta_principal.show();	
     var elem_error=null;
     var checked = new Array();
     var ids = new Array();
     var values = new Array();		
     checks=$("input.input_nota");
     var c=0
     if(checks.length>0){
        checks.each(function(i){
            s = this.getAttribute('data-id');	    
            me=$(this);
           nota= parseFloat(this.value);
           if(me.hasClass("grupoAsistencia")){
                    values.push(nota);
                    ids.push(parseInt(s));
                    if(nota==-1)
                    me.css('color','#D9EDF7');
           }
           if(me.hasClass('grupoAtividades')){
                if(nota==-1)
                    me.css('color','white');
                if(nota<=valor_maximo && nota>=valor_minimo){
                    values.push(nota);
                    ids.push(parseInt(s));
                }
                else{
                    if(c==0)
                        elem_error=this.id;               
                    c++; 
                }
        }
		
        });		
        if(elem_error!=null){
            t=$("#"+elem_error);
            t.focus();
            t.css("background-color",'red');
            if(t.val()==-1)
            t.css("color",'red');
            
            
            alerta_principal.html("<span style='color:red;'>ERROR, Verifica que el valores de la notas sea valido.</span>");
            alerta_principal.hide(25000);
            return;
        }     
        var json_values = $.toJSON(values);      
        var json_ids = $.toJSON(ids);      
        $.post(entorno+'grupo/calificarradicionesupdate', {ids_nota:json_ids,values:json_values}, function(res){
		alerta_principal.html("Listo");alerta_principal.hide(5000);
		alerta_principal.html("Cargando Lista de Estudiantes con Notas actualizadas. Espere....");
           $.post(entorno+"grupo/calificaradicioneseditar",helperactualizarAllNotasAlumnoGrupo);
        });      
    
    }        
  
  return ;
     
}


function listaAlumnosGrupoAsignaturaPeriodoInacholee(){
    alerta_principal=$("#alerta_principal");
                    alerta_principal.html("Cargando Lista de Estudiantes. Espere....");
                    alerta_principal.show();
    $.post(entorno+"grupo/calificareditar",helperactualizarAllNotasAlumnoGrupo);
    
}
function helperactualizarAllNotasAlumnoGrupo(data){ 
                        $("#form_calificar_nota").html(data);
                                        
                         $('.tarea').each(function(){
                                     $(this).rotate({angle : 270});
        
                        });
                         inputs_notas=$('input.grupoAtividades');
                        index=inputs_notas.index($obj_input_focus)+1;
                        inputs_notas[index].focus();     
                    alerta_principal=$("#alerta_principal");
                    alerta_principal.html("Listo");alerta_principal.hide(5000);
    input_check_actualizado_automatico=$("#es_copiar_fallas");
    
    if(input_check_actualizado_automatico.is(':checked')){    
                         procesarCopiaPallas();   
                         $(input_check_actualizado_automatico).attr("checked", false);
    }
    checks=$("input.input_nota");
     if(checks.length>0){
        checks.each(function(i){
            me=$(this);
           if(me.hasClass("grupoAsistencia") && this.value==-1){
                    me.css('color','#D9EDF7');
           }
           if(me.hasClass('grupoAtividades') && this.value==-1){
               me.css('color','white');
           }
       });
     }
                                 
                    
}
function notasPeriodoGrupoAsignatura(periodo_calificar_nota,asignatura_grupo,nivel){
     alerta_principal=$("#alerta_principal");
     alerta_principal.html("Cargando lista de Estudiantes. Espere.....");
     alerta_principal.show();    
    //periodo_calificar_nota=$("#periodo_calificar_nota").val();
    //asignatura_grupo=$("#asignatura_grupo").val();
    data={
      grupo_asignatura: asignatura_grupo,
      periodo_id: periodo_calificar_nota
    };
    
    $.post(entorno+"grupo/update_grupo_asignatura",data,function(){
        
        if(periodo_calificar_nota!='*' && asignatura_grupo!='*'){
          //getDimSuperiorAcademicosAnoEscolar_doble('periodo_calificar_nota','dimension_padre');  
          $.post(entorno+"grupo/calificareditar",function(data){
               form_calificar_nota=$("#new_colegio_ano_escolar");
               form_calificar_nota.html(data);
                   checks=$("input.input_nota");
               $("input.input_nota:first").focus();

              if(checks.length>0){
        checks.each(function(i){
            me=$(this);
           if(me.hasClass("grupoAsistencia") && this.value==-1){
                    me.css('color','#D9EDF7');
           }
           if(me.hasClass('grupoAtividades') && this.value==-1){
               me.css('color','white');
           }
       });
     }

                 $('.tarea').each(function(){
                                     $(this).rotate({angle : 270});
        
                        });
                 $.post(entorno+"grupo/get_grupo_asignatura_periodo",function(data){
                     if(nivel==2)
                     {    
                        miga_pan_segundo_nivel=$("#miga_pan_segundo_nivel");
                        url_nivel_1="notasPeriodoGrupoAsignatura("+periodo_calificar_nota+",'"+asignatura_grupo+"');"
                        miga_pan_segundo_nivel.attr('onclick',url_nivel_1);
                        miga_pan_segundo_nivel.html('<i class="fa fa-edit"></i>'+data);
                     }
                     if(nivel==3)
                     {    
                        miga_pan_tercer_nivel=$("#miga_pan_tercer_nivel");
                        url_nivel_1="notasPeriodoGrupoAsignatura("+periodo_calificar_nota+",'"+asignatura_grupo+"');"
                        miga_pan_tercer_nivel.attr('onclick',url_nivel_1);
                        miga_pan_tercer_nivel.html('<i class="fa fa-edit"></i>'+data);
                     }
                     
                 });    
                 
                 $("#caja_herramientas_calificar").show();         
               alerta_principal.html("Listo");alerta_principal.hide(5000);alerta_principal.hide(5000);  
      
          });  
          
        }
    }); 
}
function getPeriodosDimensionesInacho(){    
           alerta_principal=$("#alerta_principal");
           alerta_principal.html("Cargando Periodos y Dimensiones academicos. Espere.....");
           alerta_principal.show();    
            periodo_calificar_nota=$("#periodo_calificar_nota").val();
            asignatura_grupo=$("#asignatura_grupo").val();
            data={
                grupo_asignatura: asignatura_grupo,
                periodo_id: periodo_calificar_nota
             };
            $.post(entorno+"grupo/update_grupo_asignatura",data,function(){
            $.post(entorno+"grupo/periodosacademicos",function(data){
               $("#periodo_calificar_nota").html(data);  
               alerta_principal.html("Listo");alerta_principal.hide(5000);
            });    
            
        });
    

}
function getUrlFotoPerfilalumno(id_alumno){
    foto=$("#foto_la");
    foto.html("Cargando Foto.Espere....");
    $.post(entorno+"alumno/"+id_alumno+"/geturlfotoperfil",function(data){
               $("#foto_la").html(data);  
               alerta_principal.html("Listo");alerta_principal.hide(5000);
            });
}
function procesarVerLapizAgil(){
        btn_la=$("#boton_ver_lapiz_agil");
        if(btn_la.hasClass("oculta")){
            r=0;
        }
        if(btn_la.hasClass("ver")){
            r=1;
        }
        if(r==0){
            $("#caja_herramientas_calificar").show();
            btn_la.removeClass("oculta");
            btn_la.addClass("ver");
            btn_la.html('<i class="icon-eye-close"></i><span style="color: orange;font-weight:900;">Ocultar LAPIZ AGIL.</span>');
        }
        if(r==1){
            $("#caja_herramientas_calificar").hide();
            btn_la.removeClass("ver");
            btn_la.addClass("oculta");
            btn_la.html("<i class='icon-eye-open'></i>Mostrar LAPIZ AGIL.");
        }
        
        
}
function procesarOverClickBotones(e){
    $("#nota_posible_profesor").html(e.value);
   
}
function procesarOutClickBotones(e){
    $("#nota_posible_profesor").html(" ");
    
}
function procesarOutDestino(id){
    $planilla=$("#"+id);    
    if(!$planilla.hasClass('activa') && !$planilla.hasClass('destino')){
       $planilla.css('border','solid black thin');
    }    
}
function procesarClick(id){
    $planilla=$("#"+id);
    $planillas_activas=$("div.activa");
    $planillas_activas.each(function(){
        $p=$("#"+this.id);
            $p.removeClass('activa');
            $p.css('border','solid black thin');
      });
    $planilla.addClass('activa');
    if(G_FUENTE!=0 && G_FUENTE!=id){
        $planilla.addClass('destino');
        $("div.destino").each(function(){
            $p=$("#"+this.id);
            $p.css('border','solid orange 2px');
        });
    }
}

function setPlanillaCopiar(){
    $("#pegar_real").show();
    $("#pegar_oculto").hide();
    $planillas_activas=$("div.activa");    
    $planillas_activas.each(function(){
        G_FUENTE=this.id;
        $("#"+G_FUENTE).css('border','solid gray 2px');

    });

}
function procesarcambioCopiarPlanilla(periodo_id){
    mostrarMensajeNotificador("Copiando notas.");
     var carga_ids_destino = new Array();
    cargas=$("div.destino");    
    cargas.each(function(i){
          carga_ids_destino.push(parseInt(this.id));
    });		
    var json_ids = $.toJSON(carga_ids_destino);      
    data={
        carga_ids_destino:json_ids,
        carga_id_fuente: G_FUENTE,        
        periodo_id:  periodo_id       
    };
    $.post(entorno+"grupo/copiarplanilla",data,function(data){
               ocultarMensajeNotificador();
     });
    
}
function procesarCopiaPallas(){
    info_remitente=$("#asignatura_grupo").val();
    data={
        data:info_remitente
    };
    $.post(entorno+"grupo/copiarfallas",data,function(data){
               alerta_principal.html("Listo");
               alerta_principal.hide(5000);
    });
    
}
function mostrarPeriodos(nombre_ruta,me){
    $("#mostrar_periodos").html("Cargando Periodos. Espere.....")
    $.post(entorno+"dimension/"+nombre_ruta+"/periodosescolares",function(data){
               $("#mostrar_periodos").html(data);
               
    });
    
}
function cambiarPeriodoActivo(href){
    
    periodo_activo=$("#periodo_calificar_la").val();
    btn_cambiar_periodo_activo=$("#btn_cambiar_periodo_activo");
    btn_cambiar_periodo_activo.html("Espere...")
    $.post(entorno+"dimension/"+periodo_activo+"/cambiarperiodoactivo",function(data){
               $("#mostrar_periodos").html("");
               window.location.href=href;
    });
    
}
function procesarBtnRetiroLA(btn){    
    e_focus=$("#"+input_ram_focus.id);
    id_alumno=e_focus.attr('data-id');
    e_focus.addClass('celda_retirar');
    colocarNotaInput(btn);
    e_focus.removeClass('input_nota');
    $.post(entorno+"auditoria/"+id_alumno+"/solicitudretirarlapizagil",function(data){
        $('#div_solicitud'+id_alumno).html(data);
    });

    console.info(e_focus.attr('data-id'));
    
}
function procesarAdicionesLA(btn){
    $.post(entorno+"grupo/calificaradicioneseditar",helperactualizarAllNotasAlumnoGrupo);
    
}
function  preconfiguraciones(){
$('.tarea').each(function(){
                                     $(this).rotate({angle : 270});
        
                        });
}
function mostrarLapizAgil(posicion){
    if(posicion==-1){
        $("#cla_0").hide();
        $("#cla_1").hide();
        $("#cla_2").hide();
        $("#cla_3").hide();       
    }

    if(posicion==0){
        $("#cla_0").show();
        $("#cla_1").hide();
        $("#cla_2").hide();
        $("#cla_3").hide();       
    }
    if(posicion==1){
        $("#cla_0").hide();
        $("#cla_1").show();
        $("#cla_2").hide();
        $("#cla_3").hide();       
    }
    if(posicion==2){
        $("#cla_0").hide();
        $("#cla_1").hide();
        $("#cla_2").show();
        $("#cla_3").hide();       
    }
    if(posicion==3){
        $("#cla_0").hide();
        $("#cla_1").hide();
        $("#cla_2").hide();
        $("#cla_3").show();       
    }

}
function mostrarMensajeNotificador(mensaje){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html(mensaje+"Espere....");
    alerta_principal.show();
    
}
function ocultarMensajeNotificador(){
    alerta_principal=$("#alerta_principal");
    alerta_principal.hide();
    
}
