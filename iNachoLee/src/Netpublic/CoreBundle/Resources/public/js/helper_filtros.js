//las ASIGNATURAS de una grado
function getAsignaturaGrado(e){
    $ntp_inacholeebundle_contratotype_grado=$("#"+e.id);
    id_grado=$ntp_inacholeebundle_contratotype_grado.val();
    
    $.get(entorno+"grado/"+id_grado+"/asignaturas",function(data){                    
            $ntp_inacholeebundle_contratotype_asignatura=$("#ntp_inacholeebundle_contratotype_asignatura");
            $ntp_inacholeebundle_contratotype_asignatura.html(data);
            return;
    });  
}
function getAsignaturaGradoAula(e){
    $ntp_inacholeebundle_contratotype_grado=$("#"+e.id);
    
    id_grado=$ntp_inacholeebundle_contratotype_grado.val();
    
    $.get(entorno+"grado/"+id_grado+"/asignaturas",function(data){                    
            $ntp_inacholeebundle_contratotype_asignatura=$("#ntp_inacholeebundle_aulatype_contrato_aula");
            $ntp_inacholeebundle_contratotype_asignatura.html(data);
            return;
    });  
}
//Los GRUPOS de un GRADO
function getGruposGrado(btn){
    
    $ntp_inacholeebundle_contratotype_grado=$("#"+btn.id);
    id_grado=$ntp_inacholeebundle_contratotype_grado.val();
                          
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Grupos. Espere....");
    alerta_principal.show()
    $.get(entorno+"grado/"+id_grado+"/grupos",function(data){ 
                                                        
            ntp_inacholeebundle_contratotype_grupos=$("#ntp_inacholeebundle_contratotype_grupos");
            ntp_inacholeebundle_contratotype_grupos.html(data);
           
    alerta_principal.html("Listo");alerta_principal.hide(5000);
  
            return;
    });  
}
//Los grupos de un usuario,totalmente estandar
function getGruposGradoEstandar(id_fuente,id_destino){    
    $ntp_inacholeebundle_contratotype_grado=$("#"+id_fuente);
    id_grado=$ntp_inacholeebundle_contratotype_grado.val();
                          
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Grupos. Espere....");
    alerta_principal.show()
    $.get(entorno+"grado/"+id_grado+"/grupos",function(data){ 
                                                        
            ntp_inacholeebundle_contratotype_grupos=$("#"+id_destino);
            ntp_inacholeebundle_contratotype_grupos.html(data);
           
    alerta_principal.html("Listo");alerta_principal.hide(5000);
  
            return;
    });  
}
function getAsignaturasGrado(id_fuente_grado,id_destino_asignatura){        
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Asignaturas. Espere....");
    alerta_principal.show()
    id_grado=$("#"+id_fuente_grado).val();    
    $.get(entorno+"grado/"+id_grado+"/asignaturas",function(data){                    
            $("#"+id_destino_asignatura).html(data);
            alerta_principal.html("Listo");
            return;
    });  
}

//Obtiene los grupos y los coloca en select de la clase
function getGruposGradoEstandarClase(id_fuente,clase_destino){    
    $ntp_inacholeebundle_contratotype_grado=$("#"+id_fuente);
    id_grado=$ntp_inacholeebundle_contratotype_grado.val();
                          
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Grupos. Espere....");
    alerta_principal.show()
    $.get(entorno+"grado/"+id_grado+"/grupos",function(data){                                                         
            checks=$("."+clase_destino);
            if(checks.length>0){
             checks.each(function(i){                
                id = this.getAttribute('id');
                $("#"+id).html(data);               
                });
            }
            alerta_principal.html("Listo");alerta_principal.hide(5000);alerta_principal.hide(5000);  
            return;
    });  
}

function getAsignaturaGrupoPeriodo(btn){
    
    $ntp_inacholeebundle_contratotype_grado=$("#"+btn.id);
    id_grado=$ntp_inacholeebundle_contratotype_grado.val();
    
    $.get(entorno+"grado/"+id_grado+"/grupos",function(data){                    
            ntp_inacholeebundle_contratotype_grupos=$("#ntp_inacholeebundle_contratotype_grupos");
            ntp_inacholeebundle_contratotype_grupos.html(data);
            return;
    });  
}
//Periodos de un año escolar}
function getPeriodosAcademicosAnoEscolar(btn){
        
    ano_escolar_perfil_alumno=$("#"+btn.id);
    id_ano=ano_escolar_perfil_alumno.val();
    
    $.get(entorno+"dimension/"+id_ano+"/periodosano",function(data){                    
            perido_escolar_perfil_alumno=$("#perido_escolar_perfil_alumno");
            perido_escolar_perfil_alumno.removeAttr("disabled");
            perido_escolar_perfil_alumno.html(data);
            return;
    });  
}
//Grados de Una Sede
function getGradosSede(btn){
        sede=$("#"+btn.id);
        id_sede=sede.val();
        $.get(entorno+"colegio/"+id_sede+"/grados",function(data){                    
            grado_filtro_usuario=$("#grado_filtro_usuario");
            grado_filtro_usuario.html(data);
    });  
    
}
//Periodos de un año escolar
function getPeriodosAcademicosAnoEscolar_doble(btn_ano_escolar,btn_periodos){
        
    ano_escolar_perfil_alumno=$("#"+btn_ano_escolar);
    id_ano=ano_escolar_perfil_alumno.val();
    
    $.get(entorno+"dimension/"+id_ano+"/periodosano",function(data){                    
            perido_escolar_perfil_alumno=$("#"+btn_periodos);
            perido_escolar_perfil_alumno.removeAttr("disabled");
            perido_escolar_perfil_alumno.html(data);
            return;
    });  
}
//Dimensiones Superiores del un periodo
function getDimSuperiorAcademicosAnoEscolar_doble(btn_periodo,btn_dimension_superior){
        
    periodo_ano_escolar=$("#"+btn_periodo);
    id_periodo=periodo_ano_escolar.val();    
    $.get(entorno+"dimension/"+id_periodo+"/dimensionessuperiores",function(data){                    
            dimension_superior=$("#"+btn_dimension_superior);
            dimension_superior.removeAttr("disabled");
            dimension_superior.html(data);
            return;
    });
        grupoCargaAcademicaInacho();
}
function getActividadesDesempenosProfesor(){
    id_periodo_actual=$("#periodo_calificar_nota");
    $.get(entorno+"dimension/"+id_periodo+"/dimensionessuperiores",function(data){                    
            dimension_superior=$("#"+btn_dimension_superior);
            dimension_superior.removeAttr("disabled");
            dimension_superior.html(data);
            return;
    });

    
}
function grupoCargaAcademicaInacho(){
    dimension_grupo=$("#dimension_grupo");
    dimension_asignatura=$("#dimension_asignatura");
     $.post(entorno+"profesor/grupocargaacademica",function(data){
              dimension_grupo.html(data);                             
        }); 
      /*$.post(entorno+"profesor/asignaturacargaacademica",function(data){
              dimension_asignatura.html(data);                             
        });*/         
}
function getAreasGrado(){
    id_grado=$("#ntp_inacholeebundle_asignaturatype_grado").val(); 
        alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Lista de Areas Del Grupo. Espere....");
    alerta_principal.show()
     $.post(entorno+"grado/"+id_grado+"/getareasgrado",function(data){
              $("#ntp_inacholeebundle_asignaturatype_area").html(data);
                    
    alerta_principal.html("Listo");alerta_principal.hide(5000);
                    
        }); 
      /*$.post(entorno+"profesor/asignaturacargaacademica",function(data){
              dimension_asignatura.html(data);                             
        });*/         
}
function getAreasAsignaturas(fuente_id_grado,destino_hmtl,id_arae){
    id_grado=$("#"+fuente_id_grado).val(); 
    tipo=$("#"+id_arae).val();
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Lista de Areas|asignaturas. Espere....");
    alerta_principal.show()
     $.post(entorno+"asignatura/"+id_grado+"/"+tipo+"/getareasasignaturasgrado",function(data){
              $("#"+destino_hmtl).html(data);
                    
    alerta_principal.html("Listo");alerta_principal.hide(5000);
                    
        }); 
      /*$.post(entorno+"profesor/asignaturacargaacademica",function(data){
              dimension_asignatura.html(data);                             
        });*/         
}

function mostrarVerMasVerMenos(id_div,url_relativa,me){
    
    tiene=false;
    me_=$("#"+me.id);
    if(me_.hasClass('mas_detalles')){
        tiene=true;
    }
    if(tiene){
        me_.removeClass('mas_detalles');
        me_.addClass('menos_detalles');
    }
    else
    {
        me_.removeClass('menos_detalles');
        me_.addClass('mas_detalles');
    
    }
    if(me_.hasClass('mas_detalles')){        
        me_.html("Ver ++");
        $("#"+id_div).html(" ");
        $("#"+id_div).hide();           
     }
    if(me_.hasClass('menos_detalles')){
       mostrarMensajeNotificador("Cargando.");    
       $.post(entorno+url_relativa,function(data){     
                $("#"+id_div).html(data);
                $("#"+id_div).show();
                me_.html("Ver -- --");   
                ocultarMensajeNotificador();
            });         
    }


  
    
}
