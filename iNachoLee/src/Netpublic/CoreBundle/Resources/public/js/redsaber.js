/*Creacion de examenes tipo ICFES*/
function loadGrupoExamen(id){
    mostrarMensajeNotificador("Cargando grupos y componentes a evaluar");
    grado_id=$("#"+id).val();
    $.post(entorno+"grupo/"+grado_id+"/1"+"/grupostreetipo",function(data){
        $("#ul_grados").html(data);
        procesarul("");
        ocultarMensajeNotificador();
        
    });
    
}
function procesarComponenteEvaluar(e,componente_id,grupo_id){
    if($("input:checkbox:checked").length<=1){
        if($(e).is(':checked')){
            $("#netpublic_redsaberbundle_examenicfes_grupo").val(grupo_id);
            $("#netpublic_redsaberbundle_examenicfes_componente").val(componente_id);
        }
    }
    else{
        alert("Hay dos o mas componentes a evaluar seleccionados.Por favor seleccione solo uno ");
        $("input:checkbox:checked").each(function(){
            $(this).attr("checked", false)
        });
    }
}
      
function actualizarMatrixRespuesta(repuesta_ok_id,repuesta_porcentaje_id,label){
    mostrarMensajeNotificador("Actualizando Opción y Porcentajes");
    porcentaje=$("#p"+repuesta_porcentaje_id).val();
    $.post(entorno+"pregunta/"+repuesta_porcentaje_id+"/"+label+"./"+porcentaje+"/actualizarporcentaje",function(data){
        ocultarMensajeNotificador();        
    });$.post(entorno+"pregunta/"+repuesta_ok_id+"/"+label+"/actualizaropcion",function(data){
        ocultarMensajeNotificador();
        
    });
}
function actualizarMatrixPorcentaje(repuesta_porcentaje_id,repuesta_ok_id){
    mostrarMensajeNotificador("Actualizando Opción y Porcentajes");
    label=$('input:radio[name=label]:checked').val();
    label_sinpunto= label.replace(".", "");
    $.post(entorno+"pregunta/"+repuesta_ok_id+"/"+label_sinpunto+"/actualizaropcion",function(data){
        ocultarMensajeNotificador();
        
    });
    porcentaje=$("#p"+repuesta_porcentaje_id).val();
    $.post(entorno+"pregunta/"+repuesta_porcentaje_id+"/"+label+"/"+porcentaje+"/actualizarporcentaje",function(data){
        ocultarMensajeNotificador();        
    });
}
function actualizarLabelPregunta(label_id,opcion){
 mostrarMensajeNotificador("Editar label.");
 descripcion=$input_descripcion=$("#input_descripcion"+opcion).val();
 data={
   descripcion: descripcion  
 };
 $.post(entorno+"pregunta/"+label_id+"/"+opcion+"/actualizarlabel",data,function(data){
        ocultarMensajeNotificador();
        $capa_focus=$("#container-descripcion-"+opcion);
        $('html, body').animate({ scrollTop: $capa_focus.offset().top }, 'slow');
   

 });
}
function procesarAgregarContenido(pregunta_id){
 mostrarMensajeNotificador("Editar label.");
 
 
 $.post(entorno+"pregunta/"+pregunta_id+"/crearcontenido",function(data){
        $("#contenido_"+pregunta_id).show();
        $("#hidden_contenido_"+pregunta_id).val(data)
        ocultarMensajeNotificador();
        
 });
}
function procesarSalidaAgregarPregunta(opcion){
    $('#container_btns_'+opcion).hide();
    $descripcion=$("#descripcion"+opcion);
    $input_descripcion=$("#input_descripcion"+opcion);
    $descripcion.html($input_descripcion.val());
    $descripcion.show();
}
function procesarEntradaAgregarPregunta(opcion){
    $('.containes_btns').each(function(){$(this).hide()});
    $('#container_btns_'+opcion).show();
    $descripcion=$("#descripcion"+opcion);
    $input_descripcion=$("#input_descripcion"+opcion);
    $input_descripcion.val($descripcion.html());
    $descripcion.hide();
    $input_descripcion.show();
    $input_descripcion.focus();
}

function siguienteAtrasPregunta(tipo_avance,examen_id,url){
    mostrarMensajeNotificador("Cargando Siguiente pregunta.");
    $.post(entorno+"pregunta/"+examen_id+"/"+tipo_avance+"/setpreguntaactiva",function(data){
    });
}
var HTML_HOJA="";
    
function imprimirTodasHojaRepuestaEstudiantes(examen_id){
    HTML_HOJA="";
    mostrarMensajeNotificador("Cargando hojas de respuestas. ");
    $.post(entorno+"examenicfes/"+examen_id+"/nroestudiante",function(data){
        imprimirUnaHojaRepuestaEstudiantes(1,data,examen_id)
    });
    
}
function imprimirUnaHojaRepuestaEstudiantes(indice,nro_maximo_estudiantes,examen_id){
    
    $.post(entorno+"examenicfes/"+indice+"/"+examen_id+"/imprimirhojarespueta",function(data){
        HTML_HOJA+=data;
        $("#container-imprimir").html(HTML_HOJA);
        mostrarMensajeNotificador("Cargada hoja de repuestas de estudiante #"+indice+" ");
        if(indice==nro_maximo_estudiantes){
            console.info("He terminado"+indice);
            ocultarMensajeNotificador();
            return;
        }
        imprimirUnaHojaRepuestaEstudiantes(indice+1,nro_maximo_estudiantes,examen_id);
    });
    
}
function imprimirTodasSoloHojaRepuestaEstudiantes(examen_id){
    HTML_HOJA="";
    mostrarMensajeNotificador("Cargando hojas de respuestas. ");
    $.post(entorno+"examenicfes/"+examen_id+"/nroestudiante",function(data){
        imprimirUnaSoloHojaRepuestaEstudiantes(1,data,examen_id)
    });
    
}
function imprimirUnaSoloHojaRepuestaEstudiantes(indice,nro_maximo_estudiantes,examen_id){
    
    $.post(entorno+"examenicfes/"+indice+"/"+examen_id+"/imprimirsolohojarespueta",function(data){
        HTML_HOJA+=data;
        $("#container-imprimir").html(HTML_HOJA);
        mostrarMensajeNotificador("Cargada hoja de repuestas de estudiante #"+indice+" ");
        if(indice==nro_maximo_estudiantes){
            console.info("He terminado"+indice);
            ocultarMensajeNotificador();
            return;
        }
        imprimirUnaSoloHojaRepuestaEstudiantes(indice+1,nro_maximo_estudiantes,examen_id);
    });
    
}
//HojaBorrador
function imprimirTodasSoloHojaBorradorEstudiantes(examen_id){
    HTML_HOJA="";
    mostrarMensajeNotificador("Cargando hojas de respuestas. ");
    $.post(entorno+"examenicfes/"+examen_id+"/nroestudiante",function(data){
        imprimirUnaSoloHojaBorradorEstudiantes(1,data,examen_id)
    });
    
}
function imprimirUnaSoloHojaBorradorEstudiantes(indice,nro_maximo_estudiantes,examen_id){
    
    $.post(entorno+"examenicfes/"+indice+"/"+examen_id+"/imprimirsolohojaborrador",function(data){
        HTML_HOJA+=data;
        $("#container-imprimir").html(HTML_HOJA);
        mostrarMensajeNotificador("Cargada hoja de repuestas de estudiante #"+indice+" ");
        if(indice==nro_maximo_estudiantes){
            console.info("He terminado"+indice);
            ocultarMensajeNotificador();
            return;
        }
        imprimirUnaSoloHojaBorradorEstudiantes(indice+1,nro_maximo_estudiantes,examen_id);
    });
    
}
//HojaPricipal
function imprimirTodasSoloHojaPricipalEstudiantes(examen_id){
    HTML_HOJA="";
    mostrarMensajeNotificador("Cargando hojas de respuestas. ");
    $.post(entorno+"examenicfes/"+examen_id+"/nroestudiante",function(data){
        imprimirUnaSoloHojaPrincipalEstudiantes(1,data,examen_id)
    });
    
}
function imprimirUnaSoloHojaPrincipalEstudiantes(indice,nro_maximo_estudiantes,examen_id){
    
    $.post(entorno+"examenicfes/"+indice+"/"+examen_id+"/imprimirsolohojaprincipal",function(data){
        HTML_HOJA+=data;
        $("#container-imprimir").html(HTML_HOJA);
        mostrarMensajeNotificador("Cargada hoja de repuestas de estudiante #"+indice+" ");
        if(indice==nro_maximo_estudiantes){
            console.info("He terminado"+indice);
            ocultarMensajeNotificador();
            return;
        }
        imprimirUnaSoloHojaPrincipalEstudiantes(indice+1,nro_maximo_estudiantes,examen_id);
    });
    
}
function imprimirTodasSoloHojaPreguntasSinPrincipalEstudiantes(examen_id){
     mostrarMensajeNotificador("Cargada hoja de repuestas de estudiante");
        
    $.post(entorno+"examenicfes/"+examen_id+"/imprimirsoloexamen",function(data){
        HTML_HOJA=data;
        $("#container-imprimir").html(HTML_HOJA);
        ocultarMensajeNotificador();
    });
    
}

function guardaPregunta(pregunta_id){
    contenido=window.frames['child_frame'].$editor_texto.code();
    label=$('input:radio[name=label]:checked').val();
   data={
        'descripcion_A': $("#descripcionA").html(),
        'descripcion_B': $("#descripcionB").html(),
        'descripcion_C': $("#descripcionC").html(),
        'descripcion_D': $("#descripcionD").html(),
        'contenido': contenido
    };
    mostrarMensajeNotificador("Cargando hojas de respuestas. ");
    $.post(entorno+"pregunta/"+pregunta_id+"/"+label+"/guardar",data,function(data){
        ocultarMensajeNotificador();
        
    });
    
}
var nro_preguntas=0;         
function importarAhora(e){
    tipo=0;
    console.info(nro_preguntas);
    $this=$(e);
    pregunta_id=$this.val();
    data={
        pregunta_importar_id: pregunta_id
    };
    examen_id=$("#examen_id").val();
    if($this.is(':checked')){
       if(nro_preguntas>0){
           tipo=1;
       }
       else{
           tipo=2;
           nro_preguntas++;
       }
       $.post(entorno+"pregunta/"+examen_id+"/"+tipo+"/setpreguntaactiva",function(data2){
        $.post(entorno+"pregunta/"+examen_id+"/"+"procesarimportar",data,function(data){
            //siguienteAtrasPregunta(1,examen_id);
                $("#container-agregar-pregunta").html(data);
                ocultarMensajeNotificador();
            });
        });
    }
    else{
       $.post(entorno+"pregunta/"+examen_id+"/"+pregunta_id+"/retirar",function(data){
            $("#container-agregar-pregunta").html(data);
            ocultarMensajeNotificador();
       });
   }
    
   
    

}
function procesarListaImportar(){
    nro_preguntas=0;
}
function uploadAjax(url){
    var inputFileImage = document.getElementById("hrzip");
    var examen_id=$("#id").val();
    var file = inputFileImage.files[0];
    var data = new FormData();
    data.append("hrzip",file);
    data.append('id',examen_id);
    $.ajax({
        url:url,
        type:"POST",
        contentType:false,
        data:data,
        processData:false,
        cache:false,
         //mientras enviamos el archivo
            beforeSend: function(){
                mostrarMensajeNotificador("Subiendo hojas de repuestas. ");
            },
            //una vez finalizado correctamente
            success: function(data){
                mostrarMensajeNotificador("Iniciando revisión de examenes. ");
                revisarTodoHR(data,0,examen_id);
            },
            //si ha ocurrido un error
            error: function(){
                console.info("uhh Error")
            }
    });
}
function revisarTodoHR(data_hr,index,examen_id){
   var nombre_hr=data_hr[index].nombre; 
   data={
       'nombre_hr': nombre_hr
   };
   $.post(entorno+"examenicfes/"+examen_id+"/revisarhr",data,function(data){
        mostrarMensajeNotificador("Revisando examen a "+data+" ");
        if((index+1>data_hr.length-1)){
                ocultarMensajeNotificador();
                console.info("Terminamos");
                return;
        }
        revisarTodoHR(data_hr,index+1,examen_id);
   });

}
function iniciarRevisarExamenVirtual(examen_id){
   $.post(entorno+"examenicfes/"+examen_id+"/getreferencias",function(data){
        revisarTodoVirtuales(data,0,examen_id);
   });
}
function revisarTodoVirtuales(data_hr,index,examen_id){
   var referencia=data_hr[index]; 
   
   $.post(entorno+"examenicfes/"+examen_id+"/"+referencia+"/revisarvirtual",function(data){
        mostrarMensajeNotificador("Revisando examen a "+data+" ");
        if((index+1>data_hr.length-1)){
                ocultarMensajeNotificador();
                console.info("Terminamos");
                return;
        }
        revisarTodoVirtuales(data_hr,index+1,examen_id);
   });

}
function reiniciarMatrix(alumno_id,examen_id){
    mostrarMensajeNotificador("Reiniciando Matrix ");
   $.post(entorno+"examenicfes/"+examen_id+"/"+alumno_id+"/reiniciarmatrixrespuesta",function(data){
        ocultarMensajeNotificador();
   });
   
}
function newPlanArea(){
    mostrarMensajeNotificador("Cargando para un nuevo tema");
   $.get(entorno+"planarea/new",function(data){
       $("#container-contenido").html(data);
        ocultarMensajeNotificador();
   });
   
}

function guardarPlanArea(){
   contenidos=new Array();
   scrollos=new Array();
   contenido=window.frames['child_frame'].$editor_texto.code();
   asignatura_id=$("#asignatura").val();
   $("#container-contenido").html(contenido);
   
   $("#container-contenido h1,#container-contenido h2,#container-contenido h3,#container-contenido h4,#container-contenido h5").each(function(i){
       var etiqueta_html="<";
       var html=$(this).html();
       if(html.search(etiqueta_html)==-1){
            var mi_scroll='div'+i;
            $(this).after('<div class="scroll" id="'+mi_scroll+'"></div>');
            contenidos.push(html);
            scrollos.push(mi_scroll);
           
       }       
   });
   contenido=$("#container-contenido").html();
   data={
       data: $.toJSON(contenidos),
       contenido:contenido,
       asignatura:asignatura_id,
       scrolls: $.toJSON(scrollos)
   };
   $.post(entorno+"planarea/create",data,function(data){
       
   });

}
function mostrarTemasAsignatura(){
   asignatura_id=$("#asignatura").val();
   $.post(entorno+"planarea/"+asignatura_id+"/mostrarasignatura",function(data){
       $("#container-temas-asignatura").html(data);
       procesarul(".items_remoto");
       $(".items_remoto").each(function (e){
           $(this).removeClass("items_remoto");
       });
                            
   });
}
function procesarEliminarPlanArea(padre_id){
    if(confirm("Esta seguro de querer eliminar el Tema")){
        mostrarMensajeNotificador("Eliminando. ");
        $.post(entorno+"planarea/"+padre_id+"/delete",function(data){
            ocultarMensajeNotificador();                            
        });
    }
}
function procesarNewEdit(padre_id){
    $.get(entorno+"planarea/"+padre_id+"/edit",function(data){
        $("#container-contenido").html(data);
            ocultarMensajeNotificador();                            
    });
}
function procesarActualizar(padre_id){
   contenidos=new Array();
   scrollos=new Array();
   contenido=window.frames['child_frame'].$editor_texto.code();
   asignatura_id=$("#asignatura").val();
   $("#container-contenido").html(contenido);
   $(".scroll").each(function(){
       $(this).remove();
   });
   $("#container-contenido h1,#container-contenido h2,#container-contenido h3,#container-contenido h4,#container-contenido h5").each(function(i){
       var etiqueta_html="<";
       var html=$(this).html();
       if(html.search(etiqueta_html)==-1){
            var mi_scroll='div'+i;
            $(this).after('<div class="scroll" id="'+mi_scroll+'"></div>');
            contenidos.push(html);
            scrollos.push(mi_scroll);
           
       }       
   });
   contenido=$("#container-contenido").html();
   data={
       data: $.toJSON(contenidos),
       contenido:contenido,
       asignatura:asignatura_id,
       scrolls: $.toJSON(scrollos)
   };
   $.post(entorno+"planarea/"+padre_id+"/update",data,function(data){
       $.post(entorno+"planarea/"+padre_id+"/showcontenido",function(data){
       $("#container-contenido").html(data);
   });

   });

}
function procesarAdicionarTemaPregunta(pregunta_id){
    mostrarMensajeNotificador("Adicionando temas a pregunta . ")
    var temas="";
    var values = new Array();
    var values1 = new Array();    
    $inputs=$("input.check_temas:checked").each(function(){
        values.push($(this).val());        
        temas+=$("#nodo_tema_subtema_evaluar_"+$(this).val()).html();
    });
    $("input.check_subtemas:checked").each(function(){
        values1.push($(this).val());
        temas+=$("#nodo_subtema_evaluar_"+$(this).val()).html();
    });
   
   var json_values = $.toJSON(values);
   var json_values1 = $.toJSON(values1);
   data={
       ids: json_values,
       ids2: json_values1         
   };
   $.post(entorno+"pregunta/"+pregunta_id+"/"+"procesaradicionartema",data,function(data){
       $("#container-temas").html(temas);
       $("#container-temas_"+pregunta_id).html(temas);
       ocultarMensajeNotificador();
   });
}
function procesarAdicionarComponenteIcfes(pregunta_id){
    mostrarMensajeNotificador("Adicionando Componentes a pregunta . ")
    var temas="";
    var values = new Array();
    $inputs=$("input.check_items:checked").each(function(){
        values.push($(this).val()); 
                    
        temas+=$("#nodo_pruebaicfes_"+$(this).val()).html();
    });
    var json_values = $.toJSON(values);
   data={
       ids: json_values,
   };
   $.post(entorno+"pregunta/"+pregunta_id+"/"+"procesaradicionarcomponente",data,function(data){
       $("#container-componentes").html(temas);
       $("#container-componentes_"+pregunta_id).html(temas);
       ocultarMensajeNotificador();
   });
}
function actualizarEstadoPregunta(e,pregunta_id){
   $id=$(e);
   var estado=0;
   if($id.is(":checked")){
       estado=1;
   }
    mostrarMensajeNotificador("Actualizando estado de pregunta. ");
    $.post(entorno+"pregunta/"+pregunta_id+"/"+estado+"/"+"actualizarestado",function(data){
        ocultarMensajeNotificador();
   });
}
function editarContenidoPregunta(pregunta_id){
   
   mostrarMensajeNotificador("Actualizando estado de pregunta. ");
   $.post(entorno+"pregunta/"+pregunta_id+"/editarpregunta",function(data){
       $("#container-editar-contenido-pregunta-"+pregunta_id).html(data);
       $("#container-editar-contenido-pregunta-"+pregunta_id).show();
       $("#container-editar-contenido-pregunta-readyonly-"+pregunta_id).hide();
       ocultarMensajeNotificador();
   });
    
}
function actualizarContenidoPregunta(pregunta_id){   
   contenido=window.frames['child_frame_'+pregunta_id].$editor_texto.code();
   mostrarMensajeNotificador("Actualizando contenido de pregunta. ");
   data={
       'contenido': contenido
   };
   $.post(entorno+"pregunta/"+pregunta_id+"/actualizarpregunta",data,function(data){
       $("#container-editar-contenido-pregunta-readyonly-"+pregunta_id).html(data);
       $("#container-editar-contenido-pregunta-readyonly-"+pregunta_id).show();
       $("#container-editar-contenido-pregunta-"+pregunta_id).hide();
       
        ocultarMensajeNotificador();
   });
    
}
function actualizarOpionVerdaderaPregunta(pregunta_id){
   label=$('input:radio[name=label'+pregunta_id+']:checked').val();
   mostrarMensajeNotificador("Actualizando Opción de pregunta. ");
   $.get(entorno+"pregunta/"+pregunta_id+"/"+label+"/actualizaropcionpregunta",function(data){
       $("#container-opciones-pregunta-"+pregunta_id).html(data);
        ocultarMensajeNotificador();
   });
   
}
function eliminarPreguntas(){
   if(confirm("Esta seguro de eliminar las preguntas seleccionadas.")){
    var ids = new Array();
    $inputs=$("input.check_prenguntas:checked").each(function(){
        ids.push($(this).val());
    });
    eliminarUnoUnoPreguntas(0,ids);
   }
}
function eliminarUnoUnoPreguntas(index,ids){
    mostrarMensajeNotificador("Eliminado pregunta . ")
    $.post(entorno+'pregunta/'+ids[index]+'/eliminar',function(res){
            if(index>(ids.length-2)){
                ocultarMensajeNotificador();
                return;
            }
            eliminarUnoUnoPreguntas(index+1,ids)
    });      
     
    
}
function newCrearPregunta(){
    mostrarMensajeNotificador("Cargando para una nueva pregunta . ")
    $.post(entorno+'pregunta/nuevapregunta',function(res){
        $("#container-todas-pregunta").html(res);
        ocultarMensajeNotificador();
    });
}
function procesarDejataEditorTexto(){
   contenido=window.frames['child_frame'].$editor_texto.code();
   $("#netpublic_redsaberbundle_pregunta_contenidotexto").val(contenido);  
}

function procesarAdicionTemaNuevaPregunta(){
    $grado_id=$("#netpublic_redsaberbundle_pregunta_grado").val();
    var values=new Array();
    temas="";
    $("input.check_item_tema:checked").each(function(){
        values.push($(this).val());        
        temas+=$("#nodo_subtema_evaluar_"+$(this).val()).html();
    });
    $("#netpublic_redsaberbundle_pregunta_tematexto").val(values);
    $("#container-temas").html(temas);
    $("#myModal2").modal('hide');
    
}
function procesarAdicionComponenteNuevaPregunta(){
    $grado_id=$("#netpublic_redsaberbundle_pregunta_grado").val();
    var values=new Array();
    $("input.check_items:checked").each(function(){
        values.push($(this).val());        
        temas=$("#nodo_pruebaicfes_"+$(this).val()).html();
    });
    $("#netpublic_redsaberbundle_pregunta_componentetexto").val(values);
    $("#container-componentes").html(temas);
    $("#myModal1").modal('hide');
    
}

function mostrarComponenteNuevaPregunta(){
    if($("#netpublic_redsaberbundle_pregunta_grado").val()==""){
        alert("Seleccione en GRADO de la asigatura para la cual desea crear la pregunta tipo ICFES.")
    }
    else{
                 
    grado_id=$("#netpublic_redsaberbundle_pregunta_grado").val();
    url=entorno+'componente/'+grado_id+'/'+'0/showpruebastree';
    console.info(url);
    $("#myModal1").modal({
        show: true,
        remote: url
    });
    }
}
function mostrarTemaNuevaPregunta(){
    if($("#netpublic_redsaberbundle_pregunta_grado").val()==""){
        alert("Seleccione en GRADO de la asigatura para la cual desea crear la pregunta tipo ICFES.")
    }
    else{

        grado_id=$("#netpublic_redsaberbundle_pregunta_grado").val();
        url=entorno+'planarea/'+grado_id+"/"+'0/temasevaluar';
        $("#myModal2").modal({
            show: true,
            remote:  url
        });
        
    }
 
}
function getPorcentajeComplejidad(examen_id,input_inferior_B,input_superior_B,message_B){
    limite_inferior=$("#"+input_inferior_B).val();
    limite_superior=$("#"+input_superior_B).val();
    $("#"+message_B).html("Espere....");
    mostrarMensajeNotificador("Actualizanco porcentajes . ")
    $.post(entorno+'examenicfes/'+examen_id+'/'+limite_inferior+'/'+limite_superior+'/'+'informenivelcomplejidad',function(res){
        $("#"+message_B).html(res);
       
        ocultarMensajeNotificador();
    });

    
}

function procesarComparacionComponente(examen_id,id,tipo){
    componente_id=$("#componente_izquierda"+id).val();
    mensaje1=$("#mensanje_derecha_1"+id);
    mensaje2=$("#mensanje_derecha_2"+id)
    mensaje3=$("#mensanje_izquierda_1"+id);
    mensaje4=$("#mensanje_izquierda_2"+id)
    mostrarMensajeNotificador("Buscando pregutas . ")
    $.post(entorno+'examenicfes/'+examen_id+'/'+componente_id+'/getpreguntascomponente',function(res){
        data={
            'data': $.toJSON(res)
        };
      examen_id1=$("#examen1").val();
      examen_id2=$("#examen2").val();
      $.post(entorno+'examenicfes/'+examen_id1+"/"+examen_id2+'/informecomponenete2',data,function(res){
          mensaje3.html(res.nro_preguntas);
          mensaje4.html(res.puntaje_promedio1);
          
          if(res.puntaje_promedio1>=res.puntaje_promedio2){
              html="<span style='color:red;'>Bajamos de nivel </span>"+res.puntaje_promedio2;
          }
          else{
              html="<i class='fa fa-smile-o fa-2x green'></i><span style='green'>  Excelente, mejoramos. </span>"+res.puntaje_promedio2;
          }
          mensaje2.html(html);
          
          
        ocultarMensajeNotificador();
     });

    });
}

function procesarNotaComponente(examen_id,id,asg_id){
    componente_id=$("#componente"+id).val();
    mensaje=$("#mensanje"+asg_id);
    mensaje.html("Espere...")
    mostrarMensajeNotificador("Buscando pregutas . ")
    $.post(entorno+'examenicfes/'+examen_id+'/'+componente_id+'/getpreguntascomponente',function(res){
        data={
            'data': $.toJSON(res)
        };
      $.post(entorno+'examenicfes/'+examen_id+'/informecomponenete',data,function(res){
          mensaje.html(res);
        ocultarMensajeNotificador();
     });

    });
}
function mostrarExamenesGrupo(id_fuente,id_destino){
    grupo_id=$("#"+id_fuente).val();
    
    mostrarMensajeNotificador("Mostran componentes de grado ")
    $.get(entorno+'examenicfes/'+grupo_id+'/mostrargrupo',function(res){
        $("#"+id_destino).html(res);
        ocultarMensajeNotificador();
    });
}

function verComparacionComponentes(id){
    examen_id=$("#examen"+id).val();    
    mostrarMensajeNotificador("Mostran componentes de grado ")
    $.get(entorno+'examenicfes/'+examen_id+'/'+id+'/newinformedoscomponenete',function(res){
        $("#container"+id).html(res);
        ocultarMensajeNotificador();
    });  
}
function procesarComparacionesPuntajesPromedio(){
    examen_id1=$("#examen1").val();    
    examen_id2=$("#examen2").val();    
    mostrarMensajeNotificador("Calculado puntajes promedios");
    $.get(entorno+'examenicfes/'+examen_id1+'/'+examen_id2+'/procesarinformecomparacionpuntajespromedio',function(res){
        p_p_1=res.media_aritmetica1;
        p_p_2=res.media_aritmetica2;
        d1=res.desviacion_estandar1;
        d2=res.desviacion_estandar2;
        html='Puntaje promedio: '+p_p_2+'<br/>Desviación estandar: '+d2;
        html2='Puntaje promedio: '+p_p_1+'<br/>Desviación estandar: '+d1;
        $("#p_centro").html(html2);
        if(p_p_1>p_p_2 && d1>d2 ){
            $("#cuadrante_i").hide();
            $("#cuadrante_ii").hide();
            $("#cuadrante_iii").show();
            $("#cuadrante_iv").hide();
            $("#piii").html(html);
            $("#piii").show();
        }
        if(p_p_1>p_p_2 && d1<d2 ){
            $("#cuadrante_iii").hide();
            $("#cuadrante_ii").hide();
            $("#cuadrante_i").hide();
            $("#cuadrante_iv").show();
            $("#piv").html(html);
            $("#piv").show();
        }
        if(p_p_1<p_p_2 && d1>d2 ){
            $("#cuadrante_i").hide();
            $("#cuadrante_ii").show();
            $("#cuadrante_iii").hide();
            $("#cuadrante_iv").hide(); 
            $("#pii").html(html);
            $("#pii").show();
        
        }
        if(p_p_1<p_p_2 && d1<d2 ){
            $("#cuadrante_ii").hide();
            $("#cuadrante_i").show();
            $("#cuadrante_iii").hide();
            $("#cuadrante_iv").hide();
            $("#pi").html(html);
            $("#pi").show();
        }

        ocultarMensajeNotificador();
    });  
}
function listaAlumnosExamenesICFES(){
    mostrarMensajeNotificador("Cargando alumnos ");
    query=$("#my-input1").val();
    if(query==""){
            query='*';
    }
    data={
        'query':query
    };
     $.post(entorno+'alumno'+'/listaricfes',data,function(data){
            $("#container_alumnos_icfes").html(data);
            $("#container_informe_alumnos_icfes").html(" ");
            ocultarMensajeNotificador();
    });

}
function listaExamenesICFES(){
    mostrarMensajeNotificador("Cargando exámenes ");
    query=$("#my-input2").val();
    if(query==""){
            query='*';
    }
    data={
        'query':query
    };
     $.post(entorno+'examenicfes'+'/listarevisar',data,function(data){
            $("#container_alumnos_icfes").html(data);
            $("#container_informe_alumnos_icfes").html(" ");
            ocultarMensajeNotificador();
    });

}

function verImformeEstudinteicfesGeneral(alumno_id){
    mostrarMensajeNotificador("Cargando informe ");
     $.post(entorno+'examenicfes/'+alumno_id+'/verinformeestudiantegeneral',function(data){
            $("#container_informe_alumnos_icfes").html(data);
            $('html, body').animate({ scrollTop: $("#container_informe_alumnos_icfes").offset().top }, 'slow');
            ocultarMensajeNotificador();
    });

}
function procesarPaginador(container,url){
    mostrarMensajeNotificador("Cargando resultados");
    grado_id=$("#grado_id").val();
    data1={
        grado_id:grado_id
    };
  $.post(url,data1,function(data){
        $("#"+container).html(data);
        ocultarMensajeNotificador();
        
 });

}
function reiniciarTodasHR(examen_id){
    mostrarMensajeNotificador("Reiniciando todas las matrices de repuestas ");
    $.post(entorno+'examenicfes/'+examen_id+'/reiniciartodasmatrixrespuesta',function(data){
            ocultarMensajeNotificador();
    });
  
}
function procesarUltimaPregunta(pregunta_id,examen_id,tipo){
    mostrarMensajeNotificador("Cargando resumen de el examen ICFES. ")
    guardaPregunta(pregunta_id);
    if(tipo==1)
        $.post(entorno+'examenicfes/'+examen_id+'/resumen',function(data){
                $("#container-agregar-pregunta").html(data);
                ocultarMensajeNotificador();
        });
    if(tipo==2)
        $.post(entorno+'examenicfes/'+examen_id+'/resumenvirtual',function(data){
                $("#container-agregar-pregunta").html(data);
                ocultarMensajeNotificador();
        });
  
}
function procesarGenerarComponentesGrado(grado_id){
    mostrarMensajeNotificador("Generando componentes ICFES.")
    tipo=$("#tipo_"+grado_id).val();
    if(tipo=='*'){
        alert("POr favor seleccione el tipo de componentes a crear");
        return
    }
        
    $.post(entorno+'componente/'+grado_id+"/"+tipo+'/generarcomponentesicfes',function(data){
            $.post(entorno+'examenicfes/configuracionlocal',function(data){    
                $("# sub_container ").html(data);
                ocultarMensajeNotificador();
            });
    });
}
function verSiguienteHoja(tipo,examen_id,hora1,minuto1){
   $frame_principal=$("#frame_principal");
   $frame_principal.hide('slow');
   $.post(entorno+'examenicfes/'+examen_id+"/"+tipo+"/"+hora+"/"+minutos+"/contestar",function(data){
            $frame_principal.html(data);
            $frame_principal.show('6000');
    }); 
    
}
function procesarIniciarExamenAhora(examen_id){
    $button=$("#button");
    if($button.html()=='Iniciar Exámen Ahora'){
        $button.html("Iniciando...");
        $.post(entorno+'examenicfes/'+examen_id+"/activar",function(data){
            $button.html("Parar Exámen");
        }); 
    }
    if($button.html()=='Parar Exámen'){
        $button.html("Parando...");
        $.post(entorno+'examenicfes/'+examen_id+"/desaactivar",function(data){
            $button.html("Iniciar Exámen Ahora");
        }); 
    }
   
}
function iniciarExamenVirtualAhora(examen_id,hora,minuto){
    $.post(entorno+'examenicfes/'+examen_id+"/"+"-1/"+hora+"/"+minuto+"/contestar",function(data){
            $("#container-encuestas").html(data);
        });
}
function abrirHoraRespuesta(examen_id,referencia){
    $.post(entorno+'examenicfes/'+examen_id+"/"+referencia+"/verhojarepuesta",function(data){
            $("#container-encuestas").html(data);
        });
}
function iniciar2ExamenVirtualAhora(examen_id,hora1,minutos1){
    $.post(entorno+'examenicfes/'+examen_id+"/"+"0/"+hora1+"/"+minutos1+"/contestar",function(data){
            $("#container-encuestas").html(data);
        });
}
function procesarRespuestas(buble_id){
    mostrarMensajeNotificador("Actualizando respuesta");
    $buble=$("#buble_"+buble_id);
    $capa=$("#capa_"+buble_id);
    
    check=0;
    if($buble.hasClass('check')){
       $buble.html("<i class='icon icon-check-empty'></i>");
       check=0;
    }
    if($buble.hasClass('no_check')){
        $buble.html("<i class='icon icon-check-sign'></i>");
        check=1;
    }
    if(check==0){
       $buble.addClass('no_check');
       $buble.removeClass('check'); 
       $capa.addClass('no_check');
       $capa.removeClass('check'); 
       
    }
    if(check==1){
       $buble.addClass('check');
       $buble.removeClass('no_check');
       $capa.addClass('check');
       $capa.removeClass('no_check');
    }
    $.post(entorno+'examenicfes/'+buble_id+"/"+check+"/actualizarbuble",function(data){
            ocultarMensajeNotificador();
        });
    
     
    
}