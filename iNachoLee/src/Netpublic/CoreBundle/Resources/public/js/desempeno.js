
string_desempeno_s='Demuestro habilidades superiores para <span class="text_insert_textarea">#_#</span> .También demuestro intensiones de aprender';
string_desempeno_a='Tengo muy buena habilidad para <span class="text_insert_textarea">#_#</span>';
string_desempeno_m='Soy capaz de  <span class="text_insert_textarea">#_#</span> con algunas dificultades, aunque me esfuerzo por mejorar';
string_desempeno_b='Tengo dificultades para <span class="text_insert_textarea">#_#</span>';

////////desempeno de un Colegio
///////
/////
///
//
//
///
/////
///////
////////
function showdesempenoinfoAcademicaDefectoAno(id){    
    $.get(entorno+"desempeno/"+id+"/show",function(data){
           capa_ram_actividades_desempenos_calificar_nota=$("#capa_ram_actividades_desempenos_calificar_nota");
            capa_ram_actividades_desempenos_calificar_nota.html(data);  
            capa_ram_actividades_desempenos_calificar_nota.show();
            
        });        
}
function showCruceActividadesDesempeno(){
    
    
    desempenos_seleccionados=$("input.desempenos_profesor:checked");
    
    id_nota_alumno=0
    
    tmp_nota_json='{';
    tmp_nota_json+='"desempenos":{'; 	 
    id=desempenos_seleccionados.eq(0).val();
    if(desempenos_seleccionados.length==0){
	id=0;
    }
    tmp_nota_json+='"0": '+id;        
    for (i = 1; i < desempenos_seleccionados.length; i++) {
        id=desempenos_seleccionados.eq(i).val();
        tmp_nota_json+=',"'+i+'": '+id;    
    }
    tmp_nota_json+='}';
    tmp_nota_json+='}';
    $("#flass_tmp").html("<span>Cargando......</span>")
    p_nota_json=jQuery.parseJSON(tmp_nota_json);  
    $.post(entorno+"actividaddesempeno/newcustom",p_nota_json,function(data){
                                                                
             capa_ram_actividades_desempenos_calificar_nota=$("#capa_ram_actividades_desempenos_calificar_nota");
            capa_ram_actividades_desempenos_calificar_nota.html(data);  
            capa_ram_actividades_desempenos_calificar_nota.show();
            
            $("div.puntaje_all").click(setPuntajeInfluenciaActividadDescriptor);
            $("#flass_tmp").html("<span>listo!!!</span>");
            
        });  
}
function indexdesempenoinfoAcademicaDefectoAno(periodo_id,grupo_id,carga_id,asignatura_id){ 
    $("#caja_herramientas_calificar").hide();
    data={
        'periodo_id':periodo_id,
        'grupo_id':grupo_id,
        'carga_id':carga_id,
        'asignatura_id':asignatura_id
    };
    $.post(entorno+"desempeno/",data,function(resp){
            capa_ram_actividades_desempenos_calificar_nota=$("#capa_ram_actividades_desempenos_calificar_nota");
            capa_ram_actividades_desempenos_calificar_nota.html(resp);  
            capa_ram_actividades_desempenos_calificar_nota.show();
            
        });  
    return;    
}

function editardesempenoinfoAcademicaDefectoAno(id,periodo_id,grupo_id,carga_id,asignatura_id){
    data={
        'periodo_id': periodo_id,
        'grupo_id': grupo_id,
        'carga_id': carga_id,
        'asignatura_id' :asignatura_id
    };
    $.get(entorno+"desempeno/"+id+"/edit",data,function(data){
           capa_ram_actividades_desempenos_calificar_nota=$("#capa_ram_actividades_desempenos_calificar_nota");
            capa_ram_actividades_desempenos_calificar_nota.html(data);  
            capa_ram_actividades_desempenos_calificar_nota.show();
            
        });        
}
function editdesempenoperfilinfoAcademicaDefectoAno(e,id){
    $.get(entorno+"desempeno/"+id+"/editperfil",function(data){
            $("#contenido_principal").html(data);            
            
            
        });        
}
function updatedesempenoinfoAcademicaDefectoAno(id,periodo_id,grupo_id,carga_id,asignatura_id){
    $("#desempenotype_descripcion_sobresaliente").val($("#_desempenotype_descripcion_sobresaliente").html());
    $("#desempenotype_descripcion_excelente").val($("#_desempenotype_descripcion_excelente").html());
    $("#desempenotype_descripcion_aceptable").val($("#_desempenotype_descripcion_aceptable").html());
    $("#desempenotype_descripcion_insuficiente").val($("#_desempenotype_descripcion_insuficiente").html());
   
   //*****************************************
   //Formulario Nuevo Periodo Academico********
  
        $("#new_desenpeno").submit(function(){             
              $.ajax({
                type:"POST",
                url:entorno+'desempeno/'+id+'/update',
                dataType:"html",
                data:$(this).serialize(),
                beforeSend:function(){                        
                    $("#loading").show();
                },
                success:function(response){           
                    $("#response").html(response);
                    $("#loading").hide();
                    actualizarValoresDescriptivosUnoTodos(periodo_id,grupo_id,carga_id,asignatura_id);
                   indexdesempenoinfoAcademicaDefectoAno(periodo_id,grupo_id,carga_id,asignatura_id);
                 
                }

                })
          return false;
        }); 

}
function updatedesempenoperfilinfoAcademicaDefectoAno(id,periodo_id,grupo_id,carga_id,asignatura_id){
    
    token=$("#desempeno_perfil__token").val();
    movil=$("#desempeno_perfil_movil").val();
    nombre=$("#desempeno_perfil_nombre").val();
    grupo=$("#desempeno_perfil_grupo").val();
    grado=$("#desempeno_perfil_grado").val();
    tipo_documento=$("#desempeno_perfil_tipo_documento").val();
    documento=$("#desempeno_perfil_cedula").val();
    
    var data = {
                desempeno_perfil:{
                        nombre: nombre,                 
                        _token: token,
                        movil: movil,
                        grupo: grupo,
                        grado: grado,
                        tipo_documento: tipo_documento,
                        cedula: documento

                }
            };  
    $.post(entorno+"desempeno/"+id+"/updateperfil",data,function(data){
            $.post(entorno+"desempeno/",data,function(data){
                $("#contenido_principal").html("Listo,actulizado");            
            });
            
            
        });        
}
function newdesempenoinfoAcademicaDefectoAno(periodo_id,grupo_id,carga_id,asignatura_id){
    data={
        'periodo_id': periodo_id,
        'grupo_id': grupo_id,
        'carga_id': carga_id,
        'asignatura_id': asignatura_id
    };

      $("#caja_herramientas_calificar").hide();   
    $.post(entorno+"desempeno/new",data,function(data){
            $("#capa_ram_actividades_desempenos_calificar_nota").html(data);            
                _desempenotype_descripcion_sobresaliente=$("#_desempenotype_descripcion_sobresaliente");                
                _desempenotype_descripcion_sobresaliente.html(string_desempeno_s);
                _desempenotype_descripcion_excelente=$("#_desempenotype_descripcion_excelente");                
                _desempenotype_descripcion_excelente.html(string_desempeno_a);
                _desempenotype_descripcion_aceptable=$("#_desempenotype_descripcion_aceptable");                
                _desempenotype_descripcion_aceptable.html(string_desempeno_m);
                _desempenotype_descripcion_insuficiente=$("#_desempenotype_descripcion_insuficiente");                
                _desempenotype_descripcion_insuficiente.html(string_desempeno_b);
                //Creamos botones de influe                                           
                $("div.puntaje_all").click(setPuntajeInfluenciaActividadDescriptor);
             $("#capa_ram_actividades_desempenos_calificar_nota").show();   
                
                
                
               dimension_grupo=$("#desempenotype_grupo");
    
     $.post(entorno+"profesor/grupocargaacademica",function(data){
              dimension_grupo.html(data);                             
        }); 
     
                
            
        }); 
        
}
function createdesempenoinfoAcademicaDefectoAno(periodo_id,grupo_id,carga_id,asignatura_id){
   b=$("#boton_desenpeno");
   b.html("Espere....");
    nombre=  $("#desempenotype_descripcion_inf").val();
    //periodo_id=$("#desempenotype_periodo").val();
    grupo=$("#desempenotype_grupo").val();
    if(nombre==''){
        alert("Deberia tener una descripción .");
        return;
    }    
    
    $("#desempenotype_descripcion_sobresaliente").val($("#_desempenotype_descripcion_sobresaliente").html());
    $("#desempenotype_descripcion_excelente").val($("#_desempenotype_descripcion_excelente").html());
    $("#desempenotype_descripcion_aceptable").val($("#_desempenotype_descripcion_aceptable").html());
    $("#desempenotype_descripcion_insuficiente").val($("#_desempenotype_descripcion_insuficiente").html());
    //*****************************************
   //Formulario Nuevo Periodo Academico********
    $("#desempenotype_grupo").val(grupo_id);
        $("#new_desenpeno45").submit(function(){             
              $.ajax({
                type:"POST",
                url:entorno+'desempeno/create',
                dataType:"html",
                data:$(this).serialize(),
                beforeSend:function(){  
                    b.attr("disabled","true");
                },
                success:function(response){           
                    $("#response").html(response);
                    newInfluenciaActividadesDesempeno(periodo_id,grupo_id,carga_id,asignatura_id);
                    b.hide();
                 
                }

                })
          return false;
        }); 
}
function createPadresinfoAcademicaDefectoAno(){
     item_seleccionados=$("input.dimesiones:checked");
     vale='';
     for (i = 0; i < item_seleccionados.length; i++) {
         posicion_ref=item_seleccionados.index(item_seleccionados[i])        
        ultimo=$("div.porcentaje_puntaje").eq(posicion_ref); 
        vale+=ultimo.html();
    }

    
    return;
    token_padre=$("#padre__token").val();
    nombre_padre=$("#padre_nombre").val();
    cedula_padre=$("#padre_cedula").val();
    tipo_cedula_padre=$("#padre_tipo_documento").val();
    direccion_padre=$("#padre_direccion").val();
    telefono_padre=$("#padre_telefono").val();
    ocupacion_padre=$("#padre_ocupacion").val();
    empresa_padre=$("#padre_empresa").val();
    email_padre=$("#padre_email").val();        
    var data = {
                padre:{
                        nombre: nombre_padre,                 
                        _token: token_padre,
                        cedula: cedula_padre,                 
                        tipo_documento: tipo_cedula_padre,
                        direccion:direccion_padre,
                        telefono: telefono_padre,
                        ocupacion: ocupacion_padre,
                        empresa: empresa_padre,
                        email:email_padre
                        

                }
            };  
    $.post(entorno+"desempeno/1/createcustom",data,function(data){
            
        });        
    token_madre=$("#madre__token").val();
    nombre_madre=$("#madre_nombre").val();
    cedula_madre=$("#madre_cedula").val();
    tipo_cedula_madre=$("#madre_tipo_documento").val();
    direccion_madre=$("#madre_direccion").val();
    telefono_madre=$("#madre_telefono").val();
    ocupacion_madre=$("#madre_ocupacion").val();
    empresa_madre=$("#madre_empresa").val();
    email_madre=$("#madre_email").val();        
    var data = {
                madre:{
                        nombre: nombre_madre,                 
                        _token: token_madre,
                        cedula: cedula_madre,                 
                        tipo_documento: tipo_cedula_madre,
                        direccion:direccion_madre,
                        telefono: telefono_madre,
                        ocupacion: ocupacion_madre,
                        empresa: empresa_madre,
                        email:email_padre
                        

                }
            };      
    $.post(entorno+"desempeno/1/createcustom",data,function(data){
            
        });            

}
function createAcudienteinfoAcademicaDefectoAno(){
    item_seleccionados=$("input.dimesiones:checked");
    alert(item_seleccionados.length);
    /*token_acudiente=$("#acudiente__token").val();
    nombre_acudiente=$("#acudiente_nombre").val();
    cedula_acudiente=$("#acudiente_cedula").val();
    tipo_cedula_acudiente=$("#acudiente_tipo_documento").val();
    direccion_acudiente=$("#acudiente_direccion").val();
    telefono_acudiente=$("#acudiente_telefono").val();
    ocupacion_acudiente=$("#acudiente_ocupacion").val();
    empresa_acudiente=$("#acudiente_empresa").val();
    email_acudiente=$("#acudiente_email").val();        
    parentesco_acudiente=$("#acudiente_parentesco").val();
    municipio_acudiente=$("#acudiente_municipio").val();
    departamento_acudiente=$("#acudiente_departamento").val();
    var data = {
                acudiente:{
                        nombre: nombre_acudiente,                 
                        _token: token_acudiente,
                        cedula: cedula_acudiente,                 
                        tipo_documento: tipo_cedula_acudiente,
                        direccion: direccion_acudiente,
                        telefono: telefono_acudiente,
                        ocupacion: ocupacion_acudiente,
                        empresa: empresa_acudiente,
                        email: email_acudiente,
                        departamento: departamento_acudiente,
                        municipio: municipio_acudiente,
                        parentesco: parentesco_acudiente
                        

                }
            };  
    $.post(entorno+"/desempeno/0/createcustom",data,function(data){
            
        });        */
}
function deletedesempenoinfoAcademicaDefectoAno(id,periodo_id,grupo_id,carga_id,asignatura_id){
       alerta_principal=$("#alerta_principal");
    alerta_principal.html("Borrando Desempe|ño. Espere....");
    alerta_principal.show()
        $("#form_"+id).submit(function(){             
              $.ajax({
                type:"POST",
                url:entorno+'desempeno/'+id+'/delete',
                dataType:"html",
                data:$(this).serialize(),
                beforeSend:function(){                        
                    
                },
                success:function(response){           
                    indexdesempenoinfoAcademicaDefectoAno(periodo_id,grupo_id,carga_id,asignatura_id);
                   alerta_principal.html("Listo");
                   alerta_principal.hide(5000);
               }

                })
          return false;
        }); 
  
      //********************************************** 
   
}
function matriculardesempenoinfoAcademicaDefectoAno(){
    
    desempenos_seleccionados= $("input:checkbox:checked").map(function () {
                        return this.value;}).get();
    v=desempenos_seleccionados[0];
    v1=desempenos_seleccionados[1]
    var data = '{';
        data+='          "usuarios" : [ ';
        data+='                       { "id"  : '+desempenos_seleccionados[0]+'}';
        for (i = 1; i < desempenos_seleccionados.length; i++) {
            data+='                  ,{ "id"  : '+desempenos_seleccionados[i]+'}';
        }
        
        data+='                    ] ';
        data+='           } ';
   
     data = eval("(" + data + ")"); //ok!
     $.post(entorno+"desempeno/matricular",data,function(data){
           
        $.post(entorno+"usuario/buscar",{query: query},function(data){
            $("#contenido_principal").html(data);                       
            
        });  
            
            
        }); 
   
    
}
         
function guardardesempenoGestorAdministrativo(id_desempeno,id_matricula_desempeno){
    id_desempeno_global=id_desempeno;
    estado_pago=$("#pago_matricula"+id_desempeno).val();
    es_papeles=$("#es_papeles"+id_desempeno).val();
    observaciones=$("#observaciones"+id_desempeno).val();    
    var data={
        estado_pago: estado_pago,
        es_papeles: es_papeles,
        observaciones: observaciones,
        id_matricula: id_matricula_desempeno,
        id_desempeno: id_desempeno
    }
    $.post(entorno+"desempeno/updatematricula",data,mostrarFilaGestor
    //$("#contenido_principal").html(data);                       
            
    );  
    
    
}
function generarstringdesempeno(){
    desempenotype_descripcion_inf=$("#desempenotype_descripcion_inf");
    $("#_desempenotype_descripcion_sobresaliente").html(string_desempeno_s.replace('#_#',desempenotype_descripcion_inf.val()));
    $("#_desempenotype_descripcion_excelente").html(string_desempeno_a.replace('#_#',desempenotype_descripcion_inf.val()));
    $("#_desempenotype_descripcion_aceptable").html(string_desempeno_m.replace('#_#',desempenotype_descripcion_inf.val()));
    $("#_desempenotype_descripcion_insuficiente").html(string_desempeno_b.replace('#_#',desempenotype_descripcion_inf.val()));
    
    /*string_desempeno_s='Demuestro habilidades superiores para #_# .Tambien demuestro intesiones de aprender';
    string_desempeno_a='Tengo muy buena habilidad para #_#';
    string_desempeno_m='Soy capaz de #_# con algunas dificultades, aunque me esfuerzo por mejorar' ;
    string_desempeno_b='Tengo dificultades para #_#';*/
    
}
function setInfluenciaActividadDescriptor(){
    //alert($(".dimensiones_influencias").index(this));
}
function setPuntajeInfluenciaActividadDescriptor(){    
    elemento=$("#"+this.id);    
    nombre_clase=elemento.parent().attr('id');
    elementos_clase=$("div."+nombre_clase);        
    posicion_elemento=elementos_clase.index(elemento);
    if(elemento.hasClass('influencia_white')){        
        for(i=0;i<=posicion_elemento;i++){
            elementos_clase.eq(i).removeClass('influencia_white');
            elementos_clase.eq(i).addClass('influencia_black');                        
        }
        for(i=posicion_elemento+1;i<elementos_clase.length;i++){           
            elementos_clase.eq(i).removeClass('influencia_black');
            elementos_clase.eq(i).addClass('influencia_white');
        }
       
    }
    if(elemento.hasClass('influencia_black')){
        
        for(i=0;i<=posicion_elemento;i++){
            elementos_clase.eq(i).removeClass('influencia_white');
            elementos_clase.eq(i).addClass('influencia_black');
        }
        for(i=posicion_elemento+1;i<elementos_clase.length;i++){
            elementos_clase.eq(i).removeClass('influencia_black');
            elementos_clase.eq(i).addClass('influencia_white');            
        }
       
    }
    ultimo=elementos_clase.last();
    porcentaje=(posicion_elemento)*10; 
    ultimo.html("<span style='font-size:3px;'>espere...</span>");
    
    //Actualizamos porcenjes en servidor
    data={
       porcentaje: porcentaje,
       id_actividad_desempeno: nombre_clase
    };
    $.post(entorno+"actividaddesempeno/actualizarporcentaje",data,function(data){                                          
        ultimo.html(porcentaje+'%');
     });
        
    return;
   
}
function hacerCalculosActividadesDesempeno(){
          alerta_principal=$("#alerta_principal");
                    alerta_principal.html("Realizando Calculos, Espere......");
                    alerta_principal.show();
        $.post(entorno+"actividaddesempeno/ponderar",function(data){  
            alerta_principal=$("#alerta_principal");
                    capa_actividad_desempenos_desempeno=$("#capa_ram_actividades_desempenos_calificar_nota");                    
                    capa_actividad_desempenos_desempeno.hide('slow');
                    alerta_principal.html("Listo"); alerta_principal.hide(5000);
                    
               });
         
               
}
function newInfluenciaActividadesDesempeno(periodo_id,grupo_id,carga_id,asignatura_id){
    data={
        'periodo_id': periodo_id,
        'grupo_id': grupo_id,
        'carga_id': carga_id,
        'asignatura_id': asignatura_id
    };
    $.post(entorno+"actividaddesempeno/createprofesor",data,function(data){                                          
        capa_actividad_desempenos_desempeno=$("#capa_actividad_desempenos_desempeno");
        capa_actividad_desempenos_desempeno.html(data);
        capa_actividad_desempenos_desempeno.show();
        $("div.puntaje_all").click(setPuntajeInfluenciaActividadDescriptor);
     });
}
function cancelarInfluenciaActividadesDesempeno(id_desempeno){
    $.post(entorno+"actividaddesempeno/"+id_desempeno+"/cancelarprofesor",function(data){                                          
        capa_ram_actividades_desempenos_calificar_nota=$("#capa_ram_actividades_desempenos_calificar_nota");        
        capa_ram_actividades_desempenos_calificar_nota.hide();
        
     });
}
