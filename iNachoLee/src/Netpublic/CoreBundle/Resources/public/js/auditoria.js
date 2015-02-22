/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function procesarFiltrosAuditorias(btn){
   alerta_principal=$("#alerta_principal");    
   alerta_principal.html("Actualizando Filtros. Espere....");
   alerta_principal.show();

   sedes_filtro_usuario=$("#sedes_filtro_usuario").val();
   grado=$("#grado_filtro_usuario").val();
   grupo=$("#ntp_inacholeebundle_type_grupos").val();
   tipo_usuario="*";
   condicion_ie="*";
   item=50;//$("#item").val();
   if(grado!='*' && btn.id=='grado_filtro_usuario'){
       getGruposGradoBuscarUsuario();
   }
   query=$("#input_query").val()
   console.info(query);
   if(query=="")
       query='*';
   data={
       sede: sedes_filtro_usuario,
       grado: grado,
       grupo: grupo, 
       tipo_usuario: 1,
       item: item,
       condicion_ie:condicion_ie,
       query: query
   }
   $.post(entorno+"auditoria/buscar",data,function(data){
            $("#capa_ram_auditorias").html(data);                       
                alerta_principal=$("#alerta_principal");    
                alerta_principal.html("Listo"); alerta_principal.hide(5000);
                $("#input_check_all").attr("checked", true);
                 $("input:checkbox.fila_alumno_filtro").each(function(i){ 
                    $(this).attr("checked", true);
                 });
    

        });

}
function procesarCambiarGrupoUNoUno(id){
    div=$("#"+id);
    div.show();
}
function procesarCambiarGrupoAuditoria(id_alumno){
    
    id_grupo=$("#select_grupo_auditoria"+id_alumno).val();
    $.post(entorno+"auditoria/"+id_alumno+"/"+id_grupo+"/solicitudcambiar",function(data){
        $("#div_cambiarGrupo"+id_alumno).hide("slow");    
        $('#div_solicitud'+id_alumno).html(data);    
        });

}
function procesarAdicionarGrupoAuditoria(){
    PrimerNombre=$("#inputPrimerNombre").val();
    SegundoNombre=$("#inputSegundoNombre").val();
    PrimerApellido=$("#inputPrimerApellido").val();
    SegundoApellido=$("#inputSegundoApellido").val();
    tipo_documento=$("#select_tipo_documento").val();
    Cedula=$("#inputCedula").val();
    grado_adicionar_solicitud=$("#select_grado_adicionar_solicitud").val();
    grupo_adicionar_solicitud=$("#select_grupo_adicionar_solicitud").val();
    
    data={
        "primer_nombre": PrimerNombre,
        "segundo_nombre": SegundoNombre,
        "primer_apellido": PrimerApellido,
        "segundo_apellido": SegundoApellido,
        "tipo_documento": tipo_documento,
        "cedula": Cedula,
        "grado": grado_adicionar_solicitud,
        "grupo": grupo_adicionar_solicitud
    };
    $.post(entorno+"auditoria/solicitudadicionar",data,function(data){
        $('#div_adicionar_solicitud').hide('slow');
        
        
    });

}
function procesarNewCambiarMultipleAuditoria(){
         var checked = new Array();
      checks=$("input:checked.fila_alumno");
     if(checks.length>0){
         numero_alumno=checks.length;
         $("#span_numero_alumnos").html(numero_alumno);
         $("#div_cambiar_multiple_solicitud").show();
     }
    else{
        alert("Tienes que seleccionar los Alumnos a cambiar de grupo");
    }

}
function procesarCambiarMultipleAuditoria(){
         var checked = new Array();
      checks=$("input:checked.fila_alumno");
     if(checks.length>0){
        checks.each(function(i){ 
            checked.push(parseInt(this.value));
        });
        grupo=$("#select_grupo_cambiar_multiple_solicitud").val();
        var json = $.toJSON(checked);      
        $.post(entorno+"auditoria/"+grupo+"/solicitudcambiarmultiple", {alumnos: json}, function(res){
            $("#div_cambiar_multiple_solicitud").hide("slow");
            procesarFiltrosAuditorias(this);
        });      
    }
    else{
        alert("No has seleccionado Usuarios.");
            return -1;
        
        
    }

}

function allAlumnosAuditoria(){    
    input_check_all=$("#input_check_all_auditoria");
   if(input_check_all.is(':checked')){
    $("input:checkbox.fila_alumno").each(function(i){ 
        $(this).attr("checked", true);
      });
   }
   else{
       $("input:checkbox.fila_alumno").each(function(i){ 
        $(this).attr("checked", false);
      });
   }
}
function procesarRetirarGrupoAuditoria(id_alumno){
    
    $.post(entorno+"auditoria/"+id_alumno+"/solicitudretirar",function(data){
        $('#div_solicitud'+id_alumno).html(data);
    });

}
function procesarRetirarMultipleAuditoria(){
         var checked = new Array();
      checks=$("input:checked.fila_alumno");
     if(checks.length>0){
        checks.each(function(i){ 
            checked.push(parseInt(this.value));
        });
        grupo=$("#select_grupo_cambiar_multiple_solicitud").val();
        var json = $.toJSON(checked);      
        $.post(entorno+"auditoria/solicitudretirarmultiple", {alumnos: json}, function(res){
            procesarFiltrosAuditorias(this);
        });      
    }
    else{
        alert("No has seleccionado Usuarios.");
            return -1;
        
        
    }

}
function procesarSolicitudUnoUnoAuditoria(id_solicitud){
    btn_procesarSolicitudUnoUno=$("#btn_procesarSolicitudUnoUno"+id_solicitud);
    btn_procesarSolicitudUnoUno.html("Espere..");
    $.post(entorno+"auditoria/"+id_solicitud+"/procesarsolicitudes",function(res){
            btn_procesarSolicitudUnoUno.html("Procesar");
            btn_procesarSolicitudUnoUno.focus();
        });
}
// VER Y PROCESAR SOLICITUDES

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function procesarFiltrosVerSolicitudesAuditorias(btn){
   alerta_principal=$("#alerta_principal");    
   alerta_principal.html("Actualizando Filtros. Espere....");
   alerta_principal.show();

   sedes_filtro_usuario=$("#sedes_filtro_usuario").val();
   grado=$("#grado_filtro_usuario").val();
   grupo=$("#ntp_inacholeebundle_type_grupos").val();
   tipo_usuario="*";
   condicion_ie="*";
   item=50;//$("#item").val();
   if(grado!='*' && btn.id=='grado_filtro'){
       getGruposGradoBuscarUsuario();
   }
   query=$("#input_query").val()
   console.info(query);
   if(query=="")
       query='*';
   data={
       sede: sedes_filtro_usuario,
       grado: grado,
       grupo: grupo, 
       tipo_usuario: 1,
       item: item,
       condicion_ie:condicion_ie,
       query: query
   }
   $.post(entorno+"auditoria/buscarlistarsolicitudes",data,function(data){
            $("#capa_ram_auditorias").html(data);                       
                alerta_principal=$("#alerta_principal");    
                alerta_principal.html("Listo"); alerta_principal.hide(5000);
                $("#input_check_all").attr("checked", true);
                 $("input:checkbox.fila_alumno_filtro").each(function(i){ 
                    $(this).attr("checked", true);
                 });
    

        });

}
function procesarSolicitudesMultipleAuditoria(){
         var checked = new Array();
      checks=$("input:checked.fila_alumno");
     if(checks.length>0){
        checks.each(function(i){ 
            checked.push(parseInt(this.value));
        });
        var json = $.toJSON(checked);      
        $.post(entorno+"auditoria/procesarsolicitudesmultiple", {solicitudes: json}, function(res){
            $("#capa_ram_auditorias").html(res);
            
        });      
    }
    else{
        alert("No has seleccionado Usuarios.");
            return -1;
        
        
    }

}
function mostrarNewAuditoria(){
        $.post(entorno+"auditoria/new", function(res){
            $("#contenido_principal").html(res);
            
        });      

}
function mostrarEditarAuditoria(auditoria_id){
        $.post(entorno+"auditoria/"+auditoria_id+"/edit", function(res){
            $("#contenido_principal").html(res);
            
        });      

}

function createAuditoria(){
 //*****************************************
   //Formulario Nuevo Periodo Academico********

        $("#form_crear_auditoria").submit(function(){             
              $.ajax({
                type:"POST",
                url:entorno+'auditoria/create',
                dataType:"html",
                data:$(this).serialize(),
                beforeSend:function(){                        
                 mostrarMensajeNotificador("Guardando Publicación De Muro.");
                },
                success:function(response){    
                    ocultarMensajeNotificador();
                    mostrarGestorDePublicaciones();
                }

                })
          return false;
        }); 
  
      //**********************************************                       
 

}

function updateAuditoria(auditoria_id){
        $("#form_aditar_auditoria").submit(function(){             
              $.ajax({
                type:"POST",
                url:entorno+"auditoria/"+auditoria_id+"/update",
                dataType:"html",
                data:$(this).serialize(),
                beforeSend:function(){                        
                 mostrarMensajeNotificador("Actualizando Publicación De Muro.");
                },
                success:function(response){    
                    ocultarMensajeNotificador();
                    mostrarGestorDePublicaciones();
                }

                })
          return false;
        }); 
}
