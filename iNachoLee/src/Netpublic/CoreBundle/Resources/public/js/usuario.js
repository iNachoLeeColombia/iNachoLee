
query="";
c=0;
////////Alumno de un Colegio
///////
/////
///
//
//
///
/////
///////
////////
function buscarUsuario(e){    
    query= e.value;
    mostrarMensajeNotificador("Cargando. ");
    if(query.length>3){                      
        $.post(entorno+"usuario/"+query+"/buscarkey",function(data){
            $("#capa_ram_buscar_usuarios").html(data);                                      
                ocultarMensajeNotificador();  
            
        });
    }
    if(query.length==1){
        
        if($("#ntp_inacholeebundle_mensajetype_destino").length==0){
        $.post(entorno+"usuario/indexbuscar",function(data){
            $("#page-wrapper").html(data);                       
                ocultarMensajeNotificador();
        });  
    }
    }
    e.focus();    
    /*$.get(entorno+"usuario/1/buscar",function(data){
            $("#tabs4-0").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            
        });        
        */
}
function mostrarPanelUsuario(){
    mostrarMensajeNotificador("Cargandon Panel De Usuario. ");
 $.post(entorno+"usuario/indexbuscar",function(data){
            $("#page-wrapper").html(data);                       
          ocultarMensajeNotificador();  
        });
}
function buscarUsuarioAhora(e){ 
alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando. Espere....");
    alerta_principal.show();  
      
        $.post(entorno+"usuario/indexbuscar",function(data){
                $("#page-wrapper").html(data);                       
                  alerta_principal.html("Listo"); alerta_principal.hide(5000);                 
                  query=$("#query_usuario").val();
              
                 $.post(entorno+"usuario/"+query+"/buscarkey",function(data){
            $("#capa_ram_buscar_usuarios").html(data);                                      
                alerta_principal.html("Listo"); alerta_principal.hide(5000);   
            
        });
            
        }); 
    
}
function filtroUsuario(e){    
    query= e.value;
    if(query.length>3){
        sede=$("#sede").val();
        grupo=$("#grupo").val();
        grado=$("#grado").val();
        item=$("#item").val();
        filtros={
            sede: sede,
            grupo: grupo,
            grado: grado,
            item: item,
            query: query
        }
        $.post(entorno+"usuario/filtro",filtros,function(data){
            $("#filtro_mensaje_lista_usuario_ram").html(data);                       
            
        });
    }
    
    e.focus();
    
    /*$.get(entorno+"usuario/1/buscar",function(data){
            $("#tabs4-0").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            
        });        
        */
}
function procesar_seleccionar_usuarios_filtros(){
    filtro_mensaje_lista_usuario=$("#filtro_mensaje_lista_usuario");
    filtro_mensaje_lista_usuario.hide();
    $("#ntp_inacholeebundle_mensajetype_asunto").focus();
    $("#ntp_inacholeebundle_mensajetype_destino").val("__LISTA__");
    var checked = new Array();
      $("input:checked.fila_alumno_filtro").each(function(i){ 
        checked.push(parseInt(this.value));
      });
      var json = $.toJSON(checked);
      //alert()
      $.post(entorno+"usuario/buscar", {asp: json}, function(res){
        $("#col3_content").html(res);
      });      
      $("#ids").attr("value",json);



}

function filtroUsuario_focus(){
     $.post(entorno+"usuario/indexbuscar",{'mostrar_button_seleccionar':1},function(data){
            $("#filtro_mensaje_lista_usuario").html(data);                       
            
        });  
     /*$.post(entorno+"usuario/filtro",{query: query},function(data){
            $("#filtro_mensaje_lista_usuario_ram").html(data);                       
            
        });*/
    filtro_mensaje_lista_usuario=$("#filtro_mensaje_lista_usuario");
    filtro_mensaje_lista_usuario.show();
    
}
function vista_buscar_usuario(e){
    query='*';
    $.post(entorno+"usuario/buscar",{query: query},function(data){
            $("#page-wrapper").html(data);                       
            
        });
}
function procesarFiltrosMensaje(){
        query=$("#ntp_inacholeebundle_mensajetype_destino").val();
        sede=$("#sede").val();
        grupo=$("#grupo").val();
        grado=$("#grado").val();
        filtros={
            sede: sede,
            grupo: grupo,
            grado: grado,
            query: query
        }
        $.post(entorno+"usuario/filtro",filtros,function(data){
            $("#filtro_mensaje_lista_usuario_ram").html(data);                       
            
        });
    
}
function allUsuariosFiltros(){
    
    input_check_all=$("#input_check_all");
   if(input_check_all.is(':checked')){
    $("input:checkbox.fila_alumno_filtro").each(function(i){ 
        $(this).attr("checked", true);
      });
   }
   else{
       $("input:checkbox.fila_alumno_filtro").each(function(i){ 
        $(this).attr("checked", false);
      });
   }
}
function allUsuariosFiltrosStardar(id_fuente,ids_destino){
    
    input_check_all=$("#"+id_fuente);
   if(input_check_all.is(':checked')){
    $("input:checkbox."+ids_destino).each(function(i){ 
        $(this).prop("checked", true);
      });
   }
   else{
       $("input:checkbox."+ids_destino).each(function(i){ 
        $(this).prop("checked", false);
      });
   }
}
function buscarUnicamenteAlumno(btn){
   sedes_filtro_usuario='*';
   grado='*';
   grupo='*';
   query=$("#my-input2").val();
   data={
       sede: sedes_filtro_usuario,
       grado: grado,
       grupo: grupo, 
       query: query
   }
   $.post(entorno+"usuario/buscar",data,function(data){
            $("#content_body_left").html(data);
        });
}
function getGruposGradoBuscarUsuario(){
    
    
    id_grado=$("#grado_filtro_usuario").val();
    
    $.get(entorno+"grado/"+id_grado+"/grupos",function(data){ 
                                                        
            ntp_inacholeebundle_contratotype_grupos=$("#ntp_inacholeebundle_type_grupos");
            ntp_inacholeebundle_contratotype_grupos.html(data);
            return;
    });  
}
//PROFESORES que dictan clases en un GRUPO
function getProfesoresDictanClaseGrupo(){
    id_grupo=$("#ntp_inacholeebundle_type_grupos").val();    
    $.get(entorno+"grupo/"+id_grupo+"/profesores",function(data){                    
            profesores_filtro_usuario=$("#profesores_grupo_filtros_usuario");
            profesores_filtro_usuario.html(data);
    });  
    
}
//ASIGNATURAS que dictar el profesor en un grupo
         
function getAsignaturaDictadasProfesor(){
    grupo=$("#ntp_inacholeebundle_type_grupos");
    id_grupo=grupo.val();                   
    id_profesor=$("#profesores_grupo_filtros_usuario").val();
    var data={
        id_grupo: id_grupo,
        id_profesor: id_profesor
    };
    $.get(entorno+"asignatura/"+id_grupo+"/"+id_profesor+"/asignaturas",function(data){                    
            profesores_filtro_usuario=$("#asignaturas_grupo_filtros_usuario");
            profesores_filtro_usuario.html(data);
    });     
}
function getPeriodosAnoEscolar(){
   id_ano_escolar=$("#ano_escolar_filtros_usaurio").val();
   $.get(entorno+"dimension/"+id_ano_escolar+"/periodos",function(data){                    
            periodo_escolar_filtros_usuario=$("#periodo_escolar_filtros_usuario");
            periodo_escolar_filtros_usuario.html(data);
    }); 
}
function getActividadesPeriodosProfesor(){
    id_profesor=$("#profesores_grupo_filtros_usuario").val();
    asignatura_filtro=$("#asignaturas_grupo_filtros_usuario").val();
    periodo_escolar=$("#periodo_escolar_filtros_usuario").val();
    var data={
        id_profesor: id_profesor,
        asignatura_filtro: asignatura_filtro,
        periodo_escolar: periodo_escolar
    };
     $.post(entorno+"dimension/actividades",data,function(data){                    
            actividades_profesor_filtro=$("#actividades_profesor_filtro");
            actividades_profesor_filtro.html(data);
    }); 
    
}
function getAsistenciaPeriodoAcademico(){      
    periodo_escolar=$("#periodo_escolar_filtros_usuario").val();    
     $.post(entorno+"dimension/"+periodo_escolar+"/asistencia",data,function(data){                    
            asistencia_periodo_filtros_usuario=$("#asistencia_periodo_filtros_usuario");
            asistencia_periodo_filtros_usuario.html(data);
    });  
}

//ACCIONES PARA LOS FILTROS
function imprimirCarnetEstudianteUsaurio_Sesion(tipo){
     var checked = new Array();
      checks=$("input:checked.fila_alumno_filtro");
     if(checks.length>0){
        checks.each(function(i){ 
            checked.push(parseInt(this.value));
        });
        var json = $.toJSON(checked);      
        $.post(entorno+"alumno/imprimircarnetsesion", {alumnos: json}, function(res){
            // capa_formato_html_xls_pdf=$("#capa_formato_html_xls_pdf") 
            //capa_formato_html_xls_pdf.hide();
        });      
        $("#ids").attr("value",json);
        return 1;
    }
    else{
        if(tipo==8){
            return 1;
        }
        else{
            alert("No has seleccionado Usuarios.");
            return -1;
        }
        
    }
}
function newFormatoImprimirUsuario(tipo){
   r=imprimirCarnetEstudianteUsaurio_Sesion(tipo); 
   if(r!=-1){
        data={
            id: 1
        };
        if(tipo==2){
            grupo=$("#ntp_inacholeebundle_type_grupos").val();
            profesor_filtro=$("#profesores_grupo_filtros_usuario").val();
            asignatura_filtro=$("#asignaturas_grupo_filtros_usuario").val();   
            ano_escolar=$("#ano_escolar_filtros_usaurio").val();
            periodo_escolar=$("#periodo_escolar_filtros_usuario").val(); 
            if(grupo=='*' || profesor_filtro=='*' || ano_escolar=="*" || periodo_escolar=='*'){
                alert("Asegurese de haber seleccionado: GRUPO,PROFESOR,ASIGNATURA,AÑO ESCOLAR, PERIODO ESCOLAR");
                return;
            }
            data={      
                grupo: grupo,
                profesor_filtro: profesor_filtro,
                asignatura_filtro: asignatura_filtro,
                ano_escolar: ano_escolar,       
                periodo_escolar: periodo_escolar       
            }
        
        }
   if(tipo==3){//Planilla en blanco
        periodo_escolar=$("#periodo_escolar_filtros_usuario").val();   
        data={      
            periodo_escolar: periodo_escolar,       
            profesor_filtro: profesor_filtro,
            asignatura_filtro: asignatura_filtro
        }
        
   }
   if(tipo==4){//Boletines de los estudiantes
        periodo_escolar=$("#perido_escolar_perfil_alumno").val(); 
        if(periodo_escolar=='*'){
            alert("Por favor selecciona un PERIODO ESCOLAR");
            return;
        }
        data={      
            periodo_escolar: periodo_escolar               
        }
        
   }
      if(tipo==7){//Mejores estudiantes
        ano_escolar=$("#ano_escolar_filtros_usaurio").val();
        periodo_escolar=$("#periodo_escolar_filtros_usuario").val(); 
        if(ano_escolar=='*'){
            alert("Por favor selecciona AÑO ESCOLAR");
            return;
        }
        
        data={      
            periodo_escolar: periodo_escolar,
            ano_escolar: ano_escolar
        }
        
   }
   if(tipo==8){//Libro final
        ;
   }   
   if(tipo==10){//Matricula de Estudiantes
        alerta_principal=$("#notificador_matricula_estudiante_nuevo");
    alerta_principal.html("Matriculando Estudiante.Espere....");
    
       grupo_id=$("#ntp_inacholeebundle_contratotype_grupos").val();
       ano_escolar_id=$("#ntp_inacholeebundle_anos_escolares").val();
       if(grupo_id=='*'){
        alert("Por favor selecciona un GRUPO");
        return;
       }
           
       data={
            grupo_id: grupo_id
       
        }
   }
   if(tipo==11){//Matricula de Estudiantes Antiguo
       grupo_id=$("#ntp_inacholeebundle_contratotype_grupos").val();
       ano_escolar_id=$("#ntp_inacholeebundle_anos_escolares").val();
       if(grupo_id=='*'){
        alert("Por favor selecciona un GRUPO");
        return;
       }
       if(ano_escolar_id=='*'){
          alert("Por favor selecciona AÑO ESCOLAR A MATRICULAR");
          return;
       }    
       data={
            grupo_id: grupo_id,
            ano_escolar_id: ano_escolar_id
        }
   }  
   if(tipo==12){//Cancelar Matricula de un alumoss
       ano_escolar_id=$("#ntp_inacholeebundle_anos_escolares").val();
       
       
       data={            
            ano_escolar_id: '*'
        }
   }     
   if(tipo==14){//Cambiar de grupo 
       grupo_id=$("#ntp_inacholeebundle_contratotype_grupos").val();
       
       if(grupo_id=='*'){
          alert("Por favor selecciona el Nuevo Grupo");
          return;
       }    
       data={            
            grupo_id: grupo_id
        }
   } 
   if(tipo==15){//Cambiar de grupo 
       fecha_inicio_ano=$("#ntp_inacholeebundle_profesorperiodoentregatype_fecha_inicio_date_year").val();
       fecha_inicio_mes=$("#ntp_inacholeebundle_profesorperiodoentregatype_fecha_inicio_date_month").val();
       fecha_inicio_dia=$("#ntp_inacholeebundle_profesorperiodoentregatype_fecha_inicio_date_day").val();
       fecha_inicio_hora=$("#ntp_inacholeebundle_profesorperiodoentregatype_fecha_inicio_time_hour").val();
       fecha_inicio_minuto=$("#ntp_inacholeebundle_profesorperiodoentregatype_fecha_inicio_time_minute").val();
      
       fecha_final_ano=$("#ntp_inacholeebundle_profesorperiodoentregatype_fecha_final_date_year").val();
       fecha_final_mes=$("#ntp_inacholeebundle_profesorperiodoentregatype_fecha_final_date_month").val();
       fecha_final_dia=$("#ntp_inacholeebundle_profesorperiodoentregatype_fecha_final_date_day").val();
       fecha_final_hora=$("#ntp_inacholeebundle_profesorperiodoentregatype_fecha_final_time_hour").val();
       fecha_final_minuto=$("#ntp_inacholeebundle_profesorperiodoentregatype_fecha_final_time_minute").val();
       fecha_inicio="'"+fecha_inicio_ano+"/"+fecha_inicio_mes+"/"+fecha_inicio_dia+'  '+fecha_inicio_hora+':'+fecha_inicio_minuto+"'";
       fecha_final="'"+fecha_final_ano+"/"+fecha_final_mes+"/"+fecha_final_dia+'  '+fecha_final_hora+':'+fecha_final_minuto+"'";
       
       data={            
            'fecha_inicio': fecha_inicio,
            'fecha_final': fecha_final        
        }
   }     


        $.post(entorno+"alumno/"+tipo+"/newhtmlpdfxls", data,function(data){
        capa_formato_html_xls_pdf=$("#capa_formato_html_xls_pdf") 
        capa_formato_html_xls_pdf.html(data);
        capa_formato_html_xls_pdf.show();
       $('#myModal').modal('hide')
        alerta_principal=$("#notificador_matricula_estudiante_nuevo");
        alerta_principal.html("Listo"); alerta_principal.hide(5000);
      }); 
   }
   
}
function ejecutarFiltroUsuario(tipo_comando,perido_id,profesor_id,asigatura_id){
    if(tipo_comando==1){
            alerta_principal=$("#alerta_principal");
            alerta_principal.html("Imprimiendo Carnet. Espere....");
            alerta_principal.show()
           $.post(entorno+"alumno/imprimircarnet.html",function(data){
               capa_ram_informes_buscar_usuarios=$("#capa_ram_informes_buscar_usuarios");
               capa_ram_informes_buscar_usuarios.html(data);
               $("#capa_formato_html_xls_pdf").hide();
               $("#sup_capa_ram_informes_buscar_usuarios").show("slow");
               procesarAllfiltros(this);
      }); 
        
    }
    if(tipo_comando==2){
            alerta_principal=$("#alerta_principal");
            alerta_principal.html("Imprimiendo Planillas Con Notas. Espere....");
            alerta_principal.show()
           $.post(entorno+"alumno/"+profesor_id+"/"+asigatura_id+"/"+perido_id+"/imprimirplanillanotas.html",function(data){
               capa_ram_informes_buscar_usuarios=$("#capa_ram_informes_buscar_usuarios");
               capa_ram_informes_buscar_usuarios.html(data);
               $("#capa_formato_html_xls_pdf").hide();
               $("#sup_capa_ram_informes_buscar_usuarios").show("slow");
               procesarAllfiltros(this);
      }); 
    }
      if(tipo_comando==3){ 
          alerta_principal=$("#alerta_principal");
            alerta_principal.html("Imprimiendo Planilla En Blanco . Espere....");
            alerta_principal.show()
           $.post(entorno+"alumno/"+perido_id+"/"+profesor_id+"/"+asigatura_id+"/imprimirplanillablanco.html",function(data){
               capa_ram_informes_buscar_usuarios=$("#capa_ram_informes_buscar_usuarios");
               capa_ram_informes_buscar_usuarios.html(data);
               $("#capa_formato_html_xls_pdf").hide();
               $("#sup_capa_ram_informes_buscar_usuarios").show("slow");
               procesarAllfiltros(this);
      });       
    }
      if(tipo_comando==4){ 
          alerta_principal=$("#alerta_principal");
            alerta_principal.html("Imprimiendo Boletines . Espere....");
            alerta_principal.show()
           $.post(entorno+"alumno/"+perido_id+"/imprimirboletines.html",function(data){
               capa_ram_informes_buscar_usuarios=$("#capa_ram_informes_buscar_usuarios");
               capa_ram_informes_buscar_usuarios.html(data);
               $("#capa_formato_html_xls_pdf").hide();
               $("#sup_capa_ram_informes_buscar_usuarios").show("slow");
               procesarAllfiltros(this);
      });       
    }
    
      if(tipo_comando==5){ 
          alerta_principal=$("#alerta_principal");
            alerta_principal.html("Imprimiendo Certificado De Estudio. Espere....");
            alerta_principal.show()
           $.post(entorno+"alumno/imprimircertificadoestudio.html",function(data){
               capa_ram_informes_buscar_usuarios=$("#capa_ram_informes_buscar_usuarios");
               capa_ram_informes_buscar_usuarios.html(data);
               $("#capa_formato_html_xls_pdf").hide();
               $("#sup_capa_ram_informes_buscar_usuarios").show("slow");
               procesarAllfiltros(this);
      });       
    }
    //Certificado de Estudio De Matricula Actual
     if(tipo_comando==6){ 
          alerta_principal=$("#alerta_principal");
          alerta_principal.html("Imprimiendo Constancia De Estudio. Espere....");
          alerta_principal.show()
           $.post(entorno+"alumno/imprimirconstanciaestudio.html",function(data){
               capa_ram_informes_buscar_usuarios=$("#capa_ram_informes_buscar_usuarios");
               capa_ram_informes_buscar_usuarios.html(data);
               $("#capa_formato_html_xls_pdf").hide();
               $("#sup_capa_ram_informes_buscar_usuarios").show("slow");
               procesarAllfiltros(this);
      });       
    }

    //Mejores estudiantes por periodo
    if(tipo_comando==7){ 
           data={      
            periodo_escolar: perido_id,
            ano_escolar: profesor_id
        };  
        alerta_principal=$("#alerta_principal");
            alerta_principal.html("Imprimiendo Lista De Mejores Estudiantes . Espere....");
            alerta_principal.show()
           $.post(entorno+"alumno/"+profesor_id+"/"+perido_id+"/imprimirmejorespuntajes.html",data,function(data){
               capa_ram_informes_buscar_usuarios=$("#capa_ram_informes_buscar_usuarios");
               capa_ram_informes_buscar_usuarios.html(data);
               $("#capa_formato_html_xls_pdf").hide();
               $("#sup_capa_ram_informes_buscar_usuarios").show("slow");
               procesarAllfiltros(this);
      });       
    }
    if(tipo_comando==10){ 
           data={                 
            ano_escolar: profesor_id
        };     
            alerta_principal=$("#alerta_principal");
            alerta_principal.html("Matriculando Alumno Nuevo . Espere....");
            alerta_principal.show()                
           $.post(entorno+"alumno/"+profesor_id+"/"+perido_id+"/matricularalumnonuevo.html",data,function(data){
               capa_ram_informes_buscar_usuarios=$("#capa_ram_informes_buscar_usuarios");
               capa_ram_informes_buscar_usuarios.html(data);
               $("#capa_formato_html_xls_pdf").hide();
               $("#sup_capa_ram_informes_buscar_usuarios").show("slow");
               procesarAllfiltros(this);
      });       
    }    

    if(tipo_comando==11){ 
           data={                 
            ano_escolar: profesor_id
        };     
            alerta_principal=$("#alerta_principal");
            alerta_principal.html("Matriculando Estudiante Antiguo. Espere....");
            alerta_principal.show()                
           $.post(entorno+"alumno/"+profesor_id+"/"+perido_id+"/matricularalumnoantiguo.html",data,function(data){
               capa_ram_informes_buscar_usuarios=$("#capa_ram_informes_buscar_usuarios");
               capa_ram_informes_buscar_usuarios.html(data);
               $("#capa_formato_html_xls_pdf").hide();
               $("#sup_capa_ram_informes_buscar_usuarios").show("slow");
               procesarAllfiltros(this);
      });       
    }    
    if(tipo_comando==12){ 
           data={                 
            ano_escolar: 2
        };     
           alerta_principal=$("#alerta_principal");
            alerta_principal.html("Cancelando Matricula. Espere....");
            alerta_principal.show()                 
           $.post(entorno+"alumno/2/cancelarmatricula.html",data,function(data){
               capa_ram_informes_buscar_usuarios=$("#capa_ram_informes_buscar_usuarios");
               capa_ram_informes_buscar_usuarios.html(data);
               $("#capa_formato_html_xls_pdf").hide();
               $("#sup_capa_ram_informes_buscar_usuarios").show("slow");
               procesarAllfiltros(this);
      });       
    }
    if(tipo_comando==13){ 
          alerta_principal=$("#alerta_principal");
            alerta_principal.html("Eliminando Usuarios. Espere....");
            alerta_principal.show()
           $.post(entorno+"alumno/borrarvarios.html",function(data){
               capa_ram_informes_buscar_usuarios=$("#capa_ram_informes_buscar_usuarios");
               capa_ram_informes_buscar_usuarios.html(data);
               $("#capa_formato_html_xls_pdf").hide();
               $("#sup_capa_ram_informes_buscar_usuarios").show("slow");
               procesarAllfiltros(this);
      });       
    }

    if(tipo_comando==14){ 
         mostrarMensajeNotificador("Cambiando Estudiante(s) a Nuevo Grupo. ");
         data={
             'grupo_id':perido_id
         };
           $.post(entorno+"alumno/moveralumononuevogrupo.html",data,function(data){
               capa_ram_informes_buscar_usuarios=$("#capa_ram_informes_buscar_usuarios");
               capa_ram_informes_buscar_usuarios.html(data);
               $("#capa_formato_html_xls_pdf").hide();
               $("#sup_capa_ram_informes_buscar_usuarios").show("slow");
               procesarAllfiltros(this);
      });       
    }
    if(tipo_comando==15){ 
         mostrarMensajeNotificador("Cambiando Fecha De Entrega A Profesores. ");
         data={
             'fecha_inicio':perido_id,
             'fecha_final': profesor_id        
         };
           $.post(entorno+"alumno/cambiarfechaentraga.html",data,function(data){
               capa_ram_informes_buscar_usuarios=$("#capa_ram_informes_buscar_usuarios");
               capa_ram_informes_buscar_usuarios.html(data);
               $("#capa_formato_html_xls_pdf").hide();
               $("#sup_capa_ram_informes_buscar_usuarios").show("slow");
               procesarAllfiltros(this);
      });       
    }

    
        
        
}
function procesarMovimientoVariosAlumnosGrupo($ids_alumnos_fuente,$ids_alumnos_destino,index){
           grupo_fuente=$("input:checked.grupo_fuente").val();
           grupo_destino=$("input:checked.grupo_destino").val();
           console.info(index);
           if($ids_alumnos_fuente.length>0){
                grupo_alumno_fuente_id=$ids_alumnos_fuente[index].getAttribute('data-grupo-fuente-id');
                if(grupo_alumno_fuente_id==="0" && grupo_fuente!=='0' && grupo_fuente!== undefined){
                    console.info("asignar fuente");
                    $.post(entorno+"alumno/"+grupo_fuente+"/"+$ids_alumnos_fuente[index].value+"/"+"matricularalumnonuevo",function(data){          
                        mostrarMensajeNotificador("Asignando grupo. "+data);
                        if(index+1>$ids_alumnos_fuente.length-1){
                            ocultarMensajeNotificador();
                            return;
                        }
                        procesarMovimientoVariosAlumnosGrupo($ids_alumnos_fuente,$ids_alumnos_destino,index+1);                
                    }); 
                }
                if(grupo_alumno_fuente_id==="0" && grupo_destino!=='0' && grupo_destino!== undefined){
                    console.info("asignar destino");
                    $.post(entorno+"alumno/"+grupo_destino+"/"+$ids_alumnos_fuente[index].value+"/"+"matricularalumnonuevo",function(data){          
                        mostrarMensajeNotificador("Asignando grupo. "+data);
                        if(index+1>$ids_alumnos_fuente.length-1){
                            ocultarMensajeNotificador();
                            return;
                        }
                        procesarMovimientoVariosAlumnosGrupo($ids_alumnos_fuente,$ids_alumnos_destino,index+1);                
                    });
                }
                if(grupo_alumno_fuente_id!=="0" && grupo_fuente=='0'  && grupo_fuente!== undefined){
                    console.info("retirar fuente");
                    ano_id=$("#h_fuente").val();
                    $.post(entorno+"alumno/"+$ids_alumnos_fuente[index].value+"/"+ano_id+"/cancelarmatricula.html",function(data){  
                        mostrarMensajeNotificador("Asignando grupo. "+data);
                        if(index+1>$ids_alumnos_fuente.length-1){
                            ocultarMensajeNotificador();
                            return;
                        }
                        procesarMovimientoVariosAlumnosGrupo($ids_alumnos_fuente,$ids_alumnos_destino,index+1);
                    }); 
                }
                if(grupo_alumno_fuente_id!=="0" && grupo_destino=='0' && grupo_destino!== undefined){
                    console.info("retirar destino");
                    ano_id=$("#h_destino").val();
                    $.post(entorno+"alumno/"+$ids_alumnos_fuente[index].value+"/"+ano_id+"/cancelarmatricula.html",function(data){  
                        mostrarMensajeNotificador("Asignando grupo. "+data);
                        if(index+1>$ids_alumnos_fuente.length-1){
                            ocultarMensajeNotificador();
                            return;
                        }
                        procesarMovimientoVariosAlumnosGrupo($ids_alumnos_fuente,$ids_alumnos_destino,index+1);
                    });
                }
                if(grupo_alumno_fuente_id!=="0" && grupo_fuente!=='0' && grupo_fuente!== undefined){
                    console.info("Transferir fuente"+grupo_fuente);
                    $.post(entorno+"alumno/"+grupo_fuente+"/"+$ids_alumnos_fuente[index].value+"/transferiralumno",function(data){
                      mostrarMensajeNotificador("Asignando grupo. "+data);
                        if(index+1>$ids_alumnos_fuente.length-1){
                            ocultarMensajeNotificador();
                            return;
                        }
                        procesarMovimientoVariosAlumnosGrupo($ids_alumnos_fuente,$ids_alumnos_destino,index+1);
                    });
                }
                if(grupo_alumno_fuente_id!=="0" && grupo_destino!=='0' && grupo_destino!== undefined){
                    console.info("Transferir destino"+grupo_destino);
                    $.post(entorno+"alumno/"+grupo_destino+"/"+$ids_alumnos_fuente[index].value+"/transferiralumno",function(data){
                      mostrarMensajeNotificador("Asignando grupo. "+data);
                        if(index+1>$ids_alumnos_fuente.length-1){
                            ocultarMensajeNotificador();
                            return;
                        }
                        procesarMovimientoVariosAlumnosGrupo($ids_alumnos_fuente,$ids_alumnos_destino,index+1);
                    });
                }
            }
          if($ids_alumnos_destino.length>0){
              grupo_alumno_destino_id=$ids_alumnos_destino[index].getAttribute('data-grupo-destino-id');
          }  
           
           
    
    
    /*
           if(grupo_id!=0 && grupo_alumno_id=="0"){
                $.post(entorno+"alumno/"+grupo_id+"/"+$ids_alumnos[index].value+"/"+"matricularalumnonuevo",function(data){          
                    mostrarMensajeNotificador("Asignando grupo. "+data);
                    if(index+1>$ids_alumnos.length-1){
                        procesarFiltrosGeneral(this,'content_body_left','id_sede_left','id_grado_left','id_grupo_left',url);
                        ocultarMensajeNotificador();
                        
                        return;
                    }
                    procesarMovimientoVariosAlumnosGrupo($ids_alumnos,index+1,url);
                });
            }
            else if(grupo_id==0 && grupo_alumno_id!="0") {
                
                $.post(entorno+"alumno/"+$ids_alumnos[index].value+"/cancelarmatricula.html",function(data){  
                    mostrarMensajeNotificador("Retirando de grupo"+data);
                    if(index+1>$ids_alumnos.length-1){
                        procesarFiltrosGeneral(this,'content_body_left','id_sede_left','id_grado_left','id_grupo_left',url);
                        ocultarMensajeNotificador();
                        return;
                    }
                    procesarMovimientoVariosAlumnosGrupo($ids_alumnos,index+1,url);
                    
                }); 
            }
            else if(grupo_id!="0" && grupo_alumno_id!="0"){
                if(grupo_alumno_id==grupo_id){
                    alert("El grupo de origen es igual al grupo destino");
                    return;
                }
                else{
                  $.post(entorno+"alumno/"+grupo_alumno_id+"/"+grupo_id+"/"+alumno_id+"/transferiralumno",function(data){
                      mostrarMensajeNotificador("Moviendo de un grupo a otro."+data);
                      if(index+1>$ids_alumnos.length-1){
                        ocultarMensajeNotificador();
                        procesarFiltrosGeneral(this,'content_body_left','id_sede_left','id_grado_left','id_grupo_left',url);
    
                        return;
                    }
                    procesarMovimientoVariosAlumnosGrupo($ids_alumnos,index+1,url);
                });
                }
            }
            else{
               
            }
            
      */  
}
function procesarMovimientoAlumnosGrupos(){
    this_alumnos_fuente=new Array();
    this_alumnos_destino=new Array();
    $("input:checked.alumnos_fuente").each(function(i){
        this_alumnos_fuente[i]=this;
    });
    $("input:checked.alumnos_destino").each(function(i){
        this_alumnos_destino[i]=this;
    });    
    mostrarMensajeNotificador("Procesando ");        
    procesarMovimientoVariosAlumnosGrupo(this_alumnos_fuente,this_alumnos_destino,0);
        
    
}
function cerrarcapa_ram_informes_buscar_usuarios(){
    $("#sup_capa_ram_informes_buscar_usuarios").hide("slow");
}
function promoverGrupoAlumnoUsuario(){
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Promoviendo alumnos. Espere....");
    alerta_principal.show();

    var checked = new Array();
      $("input:checked.fila_alumno_filtro").each(function(i){ 
        checked.push(parseInt(this.value));
      });
      var json = $.toJSON(checked);
    $.post(entorno+"alumno/promover",{alumnos: json},function(data){
          
   alerta_principal.html("Listo"); alerta_principal.hide(5000);
   

      });  
}
function matricularAlumnosNuevoUsuario(){
    
   
    var checked = new Array();
      $("input:checked.fila_alumno_filtro").each(function(i){ 
        checked.push(parseInt(this.value));
      });
      var json = $.toJSON(checked);
    $.post(entorno+"alumno/matricularalumnonuevo",data,{alumnos: json},function(data){
       
      });  
    
}
function newgrupoAnoEscolarUsuario(){
    ventana=$("#myModal");    
   $.post(entorno+"grado/grados",function(data){
       $.post(entorno+"dimension/anosescolares",function(data1){
      
          html='<div class="modal-header">';
    html+='<a class="close" data-dismiss="modal">×</a>';
    html+='          <h3>Año escolar a Matricular y Grupo</h3>';
    html+='</div>';
    html+='<div class="modal-body"> ';
    html+='            <div id="notificador_matricula_estudiante_nuevo" style="width: 100px;float: left">';    
    html+='</div>    ';    
    html+='<div id="contratos_profesor_id" style="border: thin gray;width: 200px;height: 150px;float: right">    ';
    html+='<select id="ntp_inacholeebundle_grados" onchange="getGruposGrado(this);">';
    html+=data;  
    html+='</select>';
    html+='<select id="ntp_inacholeebundle_contratotype_grupos">';
    html+="<option value='1'>Grupo</option>";  
    html+='</select>';
    html+='</div>  ';
    html+='<div style="clear: both"></div>                       ';
    html+='</div>';
    html+='<div class="modal-footer">';
    html+='<a href="#" class="btn" data-dismiss="modal">Cancelar</a>';
    html+='<button type="submit" id="btn_gruardar_contrato" class="btn btn-primary" onclick="newFormatoImprimirUsuario(10);">Asignar Grupo AHORA!!</button>';
    html+='</div>';       
             ventana.html(html);
             $('#myModal').modal('show');
              });
      }); 
          
}

/*Alumnos antiguos*/
function newgrupoAnoEscolarUsuarioViejo(){
   
   ventana=$("#myModal");    
   $.post(entorno+"grado/grados",function(data){
       $.post(entorno+"dimension/anosescolares",function(data1){      
    html='<div class="modal-header">';
    html+='<a class="close" data-dismiss="modal">×</a>';
    html+='          <h3>Renovación de Matricula(Estudiante antiguo)</h3>';
    html+='</div>';
    html+='<div class="modal-body"> ';
    html+='            <div style="width: 100px;float: left">';    
    html+='</div>    ';    
    html+='<div id="contratos_profesor_id" style="border: thin gray;width: 200px;height: 150px;float: right">    ';
    html+='<select id="ntp_inacholeebundle_anos_escolares">';
    html+=data1;  
    html+='</select>';
    html+='<select id="ntp_inacholeebundle_grados" onchange="getGruposGrado(this);">';
    html+=data;  
    html+='</select>';
    html+='<select id="ntp_inacholeebundle_contratotype_grupos">';
    html+="<option value='1'>Grupo</option>";  
    html+='</select>';
    html+='</div>  ';
    html+='<div style="clear: both"></div>                       ';
    html+='</div>';
    html+='<div class="modal-footer">';
    html+='<a href="#" class="btn" data-dismiss="modal">Finalizar</a>';
    html+='<button type="submit" id="btn_gruardar_contrato" class="btn btn-primary" onclick="newFormatoImprimirUsuario(11);">Matricular AHORA!!</button>';
    html+='</div>';       
             ventana.html(html);
             $('#myModal').modal('show');
              });
      }); 
          
}

//Cancelar matricula
function cancelarMatriculaUsuario(){
   
   ventana=$("#myModal");    
   $.post(entorno+"grado/grados",function(data){
       $.post(entorno+"dimension/anosescolares",function(data1){      
    html='<div class="modal-header">';
    html+='<a class="close" data-dismiss="modal">×</a>';
    html+='          <h3>Retirar Alumno(s) de un grupo.</h3>';
    html+='</div>';
    html+='<div class="modal-body"> ';
    html+='            <div style="width: 100px;float: left;font-size:14px;">';  
    html+='Se Retiraran los alumnos del(os) Grupo(s).';
    html+='</div>    ';    
    html+='<div id="contratos_profesor_id" style="border: thin gray;width: 200px;height: 150px;float: right">    ';
    html+='</div>  ';
    html+='<div style="clear: both"></div>                       ';
    html+='</div>';
    html+='<div class="modal-footer">';
    html+='<a href="#" class="btn" data-dismiss="modal">Cancelar</a>';
    html+='<button type="submit" id="btn_gruardar_contrato" class="btn btn-primary" onclick="newFormatoImprimirUsuario(12);">Retirar De Grupo AHORAA!!</button>';
    html+='</div>';       
             ventana.html(html);
             $('#myModal').modal('show');
              });
      }); 
          

}
function cambiarFechaDeEntregaVarios(){
   ventana=$("#myModal");    
   $.post(entorno+"profesorperiodoentrega/editfiltros",function(data){
      html='<div class="modal-header">';
    html+='<a class="close" data-dismiss="modal">×</a>';
    html+='          <h3>Retirar Alumno(s) de un grupo.</h3>';
    html+='</div>';
    html+='<div class="modal-body"> ';
    html+='            <div style="width: 100px;float: left;font-size:12px;">';  
    html+=data;
    html+='</div>    ';    
    html+='<div id="contratos_profesor_id" style="border: thin gray;width: 200px;height: 150px;float: right">    ';
    
    html+='</div>  ';
    html+='<div style="clear: both"></div>                       ';
    html+='</div>';
    html+='<div class="modal-footer">';
    html+='<a href="#" class="btn" data-dismiss="modal">Cancelar</a>';
    html+='<button type="submit" id="btn_gruardar_contrato" class="btn btn-primary" onclick="newFormatoImprimirUsuario(15);">Cambiar Fecha AHORAA!!</button>';
    html+='</div>';       
    ventana.html(html);
    $('#myModal').modal('show');
              });
   
}

//Cancelar matricula
function cambiarOtroGrupoaUsuario(){
   ventana=$("#myModal");    
   $.post(entorno+"grado/grados",function(data){
       
    html='<div class="modal-header">';
    html+='<a class="close" data-dismiss="modal">×</a>';
    html+='          <h3>Cambiar Alumno(s) a un Nuevo Grupo.</h3>';
    html+='</div>';
    html+='<div class="modal-body"> ';
    html+='            <div id="notificador1" style="width: 100px;float: left;font-size:12px;">';    
    html+='Lo estudiantes se moveran de su grupo antiguo al nuevo grupo seleccionado.';
   
    html+='</div>    ';    
    html+='<div id="contratos_profesor_id" style="border: thin gray;width: 200px;height: 150px;float: right">    ';
    html+='<select id="ntp_inacholeebundle_grados" onchange="$(\'#notificador1\').html(\'Cargando Grupos. \');getGruposGrado(this);">';
    html+=data;  
    html+='</select>';
    html+='<select id="ntp_inacholeebundle_contratotype_grupos">';
    html+="<option value='1'>Grupo</option>";  
    html+='</select>';
    html+='</div>  ';
    html+='<div style="clear: both"></div>                       ';
    html+='</div>';
    html+='<div class="modal-footer">';
    html+='<a href="#" class="btn" data-dismiss="modal">Cancelar</a>';
    html+='<button type="submit" id="btn_gruardar_contrato" class="btn btn-primary" onclick="newFormatoImprimirUsuario(14);">Cambiar Grupo AHORA!!</button>';
    html+='</div>';       
    ventana.html(html);
             $('#myModal').modal('show');
              });
          
}

//Borrar usuarios
function eliminarVariosUsuario(){
   
    ventana=$("#myModal");       
    html='<div class="modal-header">';
    html+='<a class="close" data-dismiss="modal">×</a>';
    html+='<h3>Eliminar Usuarios</h3>';
    html+='</div>';
    html+='<div class="modal-body"> ';
    html+='Estas seguros de Eliminar los Usuarios Seleccionados?';    
    html+='</div>    ';    
    html+='<div id="contratos_profesor_id" style="border: thin gray;width: 200px;height: 150px;float: right">    ';
    html+='</div>  ';
    html+='<div style="clear: both"></div>                       ';
    html+='</div>';
    html+='<div class="modal-footer">';
    html+='<a href="#" class="btn" data-dismiss="modal">Cancelar</a>';
    html+='<button type="submit" id="btn_gruardar_contrato" class="btn btn-danger" onclick="newFormatoImprimirUsuario(13);">Eliminar Usuario AHORAA!!</button>';
    html+='</div>';       
    ventana.html(html);
    $('#myModal').modal('show');
          
}



function editContrasenaUsuario(){
  
    $.post(entorno+"usuario/editcontrasena",function(data){
        contenido_principal=$("# sub_container ");
        contenido_principal.html(data);
      });
}
function editContrasenIdUsuario(id){
    mostrarMensajeNotificador("Cargando. ");  
  $.post(entorno+"usuario/"+id+"/editcontrasenaperfiladmin",function(data){
        contenido_principal=$("#container-minostas-perfil");
        contenido_principal.html(data);
         ocultarMensajeNotificador();
      });
}
function updateContrasenaUsuario(){
   input_repita_contrasena_usuario=$("#input_repita_contrasena_usuario").val();
   input_nueva_contrasena_usuario=$("#input_nueva_contrasena_usuario").val();
   if(input_nueva_contrasena_usuario!=input_repita_contrasena_usuario){
       alert("Las Contraseñas deben de ser Iguales");
       return;
   }
   data={
     'nueva_contrasena':  input_repita_contrasena_usuario 
   };
    mostrarMensajeNotificador("Cambiando contraseña. ");
    $.post(entorno+"usuario/updatecontrasena",data,function(){
        ocultarMensajeNotificador();
        location.href=entorno+"logout";
      });
}

function updateperfiladminContrasenaUsuario(id){
   input_repita_contrasena_usuario=$("#input_repita_contrasena_usuario").val();
   input_nueva_contrasena_usuario=$("#input_nueva_contrasena_usuario").val();
   if(input_nueva_contrasena_usuario!=input_repita_contrasena_usuario){
       alert("Las Contraseñas deben de ser Iguales");
       return;
   }
   data={
     'nueva_contrasena':  input_repita_contrasena_usuario 
   };
    mostrarMensajeNotificador("Cambiando contraseña. ");
    $.post(entorno+"usuario/"+id+"/updatecontrasenaperfiladmin",data,function(){
          ocultarMensajeNotificador();
        contenido_principal=$("#container-minostas-perfil");
        contenido_principal.html("<h2>Listo!!!</h2>");
              });
}
function mostrarFiltroPaginador(name_div,href){    
    filtros={
      sede: $("#sedes_filtro_usuario").val(),
      grado: $("#grado_filtro_usuario").val(),
      grupo: $("#ntp_inacholeebundle_type_grupos").val(),
      tipo_usuario: $("#tipo_filtro_usuario").val(),
      item: $("#item").val()
    };
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Nueva pagina De tu búsqueda. Espere....");
    alerta_principal.show();
    capa_trabajo=$("#"+name_div);
    html='<div style="text-align:center;margin-top:25px;"><img src="'+url_web+'uploads/loader.gif"></div>';
    capa_trabajo.html(html);
    $.post(href,filtros,function(data){          
            capa_trabajo.html(data);         
            alerta_principal.html("Listo"); alerta_principal.hide(5000);
            $("#input_check_all").attr('checked', false);
      });
    
    
}
function procesarFiltrosGeneral(){  
   mostrarMensajeNotificador("Cargando usuarios. "); 
   grupo=6;
   $.post(entorno+"cargaacademica/"+grupo+"/vergrupolista",function(data){
            $("#container-grupo-fuente").html(data);
            $('.tarea').each(function(){
                 $(this).rotate({angle : 270});
        
            });            
            ocultarMensajeNotificador();
    });   
}

function buscarUsuarioPrincipal(url,id){
           var usuarios = new Bloodhound({
                                datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.num); },
                                queryTokenizer: Bloodhound.tokenizers.whitespace,
                                limit: 10,
                                remote: {
                                         url: entorno+url+"?query=%QUERY",
                                        filter: function(list) {
                                                ocultarMensajeNotificador();
                                                return list;
                                            }   
                                },
                                prefetch: {
                                        url: entorno+url+"?query=m",
                                        filter: function(list) {
                                                return list;
                                        }
                                }
                        });
                        usuarios.initialize();
                        $('#'+id).typeahead(null, {
                                    name: 'usuarios',
                                    displayKey: 'num',
                                    source: usuarios.ttAdapter(),
                                    templates: {
                                    suggestion: Handlebars.compile([
                                        '<a  target="_blank" class="anchor_media" href="{{href}}">',
                                        '<div class="media-sugerencias">',      
       ' <img  class="pull-left media-object" src={{src_img}} alt="Generic placeholder image">',
       '<div class="parte_body pull-right">',
      '<h6 class="media-heading">{{nombre}}-{{tipo_usuario}}.<br/> (@{{nombre_usuario}})</h6>',
      '<span style="font-size:12px;">cedula: {{cedula}}</span> | ',
      '<span style="font-size:12px;"> Grado-Grupo: {{grado}}-{{grupo}}</span>',
      '</div>',
      '<div class="clearfix"></div>',
      '</div>',
    '</a>'
                                ].join(''))
                                    }
                        });
                       
}                                                
                        

