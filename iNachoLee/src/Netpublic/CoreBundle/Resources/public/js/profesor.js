
tipo_global=0;
////////Profesor de un Colegio
///////
/////
///
//
//
///
/////
///////
////////
function showProfesorinfoAcademicaDefectoAno(id){    
    $.get(entorno+"profesor/"+id+"/show",function(data){
            $("#tabs3-0").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            
        });        
}

function indexProfesorinfoAcademicaDefectoAno(){ 
    
    $.get(entorno+"profesor/",function(data){
            $("#tabs3-0").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            
        });  
    return;    
}
function indexDescriptoresProfesorinfoAcademicaDefectoAno(){ 
    $("#caja_herramientas_calificar").hide(); 
    alerta_principal=$("#alerta_principal");
                    alerta_principal.html("Cargando....");
                    alerta_principal.show();
    $.get(entorno+"profesor/indexdesempeno",function(data){
            capa_ram_actividades_desempenos_calificar_nota=$("#capa_ram_actividades_desempenos_calificar_nota");
            capa_ram_actividades_desempenos_calificar_nota.html(data);  
            capa_ram_actividades_desempenos_calificar_nota.show();           
             alerta_principal=$("#alerta_principal");
                    alerta_principal.html("Listo....");
                    alerta_principal.show();
            
        });  
    return;    
}

function editarProfesorinfoAcademicaDefectoAno(id){
    
    $.get(entorno+"profesor/"+id+"/edit",function(data){
            $("#tabs3-0").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            
        });        
}
function updateProfesorinfoAcademicaDefectoAno(id){
     token=$("#ntp_inacholeebundle_profesortype__token").val();
    nombre=$("#ntp_inacholeebundle_profesortype_nombre").val();
    cedula=$("#ntp_inacholeebundle_profesortype_cedula").val();
    url_foto=$("#ntp_inacholeebundle_profesortype_url_foto").val();
    hs=$("#ntp_inacholeebundle_profesortype_horas_trabajo_semanales").val();
    //contrato=$("#ntp_inacholeebundle_profesortype_contrato").val();
    contrato_json='"contrato":[ ';
    contrato_json+='{"asignatura": "-1",';
    contrato_json+='"horas_semanales": "-1"},';    
    contrato_json+=contrato_json_profesor;  
    contrato_json+='{"asignatura": "-1",';
    contrato_json+='"horas_semanales": "-1"}';
    contrato_json+=']';      
    
    
    var data ='{'
        data+='"ntp_inacholeebundle_profesortype":{';
        data+='"nombre": "'+nombre+'",';
        data+='"_token": "'+token+'",';
        data+='"horas_trabajo_semanales": "'+hs+'",';
        data+='"cedula": "'+cedula+'",';                 
        data+='"url_foto": "'+url_foto+'"';        
        data+='},';
        /*data+='"contrato":[ ';
        data+='{"asignatura": "25",';
        data+='"horas_semanales": "21"},';
        data+='{"asignatura": "25",';
        data+='"horas_semanales": "21"}';        
        data+=']';      */
        data+=contrato_json;
        data+='}';  
        contrato_json_profesor=""; 
     data=jQuery.parseJSON(data);  
    $.post(entorno+"profesor/"+id+"/update",data,function(data){
            $.post(entorno+"profesor/",data,function(data){
                $("#tabs3-0").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            });
            
            
        });        
}
function newProfesorinfoAcademicaDefectoAno(){
    $.post(entorno+"profesor/new",function(data){
            $("#tabs3-0").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            
        });        
}
function newProfesorSinfoAcademicaDefectoAno(){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Interfaz de Nuevo Profesor. Espere....");
    alerta_principal.show()
    $.post(entorno+"profesor/new",function(data){            
            $("#sub-container").html(data);   
            alerta_principal.html("Listo"); alerta_principal.hide(5000);           
            
            
        });        
}         

function newperfilProfesorinfoAcademicaDefectoAno(){
    $.post(entorno+"profesor/new",function(data){
            $("#page-wrapper").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            
        });        
}
         
function createProfesorinfoAcademicaDefectoAno(){               
    token=$("#ntp_inacholeebundle_profesortype__token").val();
    nombre=$("#ntp_inacholeebundle_profesortype_nombre").val();
    cedula=$("#ntp_inacholeebundle_profesortype_cedula").val();
    url_foto=$("#ntp_inacholeebundle_profesortype_url_foto").val();
    hs=$("#ntp_inacholeebundle_profesortype_horas_trabajo_semanales").val();
    //contrato=$("#ntp_inacholeebundle_profesortype_contrato").val();
    contrato_json='"contrato":[ ';
    contrato_json+='{"asignatura": "-1",';
    contrato_json+='"horas_semanales": "-1"},';    
    contrato_json+=contrato_json_profesor;  
    contrato_json+='{"asignatura": "-1",';
    contrato_json+='"horas_semanales": "-1"}';
    contrato_json+=']';      
    
    
    var data ='{'
        data+='"ntp_inacholeebundle_profesortype":{';
        data+='"nombre": "'+nombre+'",';
        data+='"_token": "'+token+'",';
        data+='"horas_trabajo_semanales": "'+hs+'",';
        data+='"cedula": "'+cedula+'",';                 
        data+='"url_foto": "'+url_foto+'"';        
        data+='},';
        /*data+='"contrato":[ ';
        data+='{"asignatura": "25",';
        data+='"horas_semanales": "21"},';
        data+='{"asignatura": "25",';
        data+='"horas_semanales": "21"}';        
        data+=']';      */
        data+=contrato_json;
        data+='}';  
        contrato_json_profesor=""; 
     data=jQuery.parseJSON(data);  
     $.post(entorno+"profesor/create",data,function(data_){
            $.get(entorno+"profesor/",function(data){
                $("#tabs3-0").html(data);            
                $("#flass_tmp").html("<span>listo!!!</span>");
               
            });
            
            
        });        
}
function deleteProfesorinfoAcademicaDefectoAno(id){
    _token=$("div#"+id+" div input:first").val();                 
    var data = {
                form:{
                    id: id,
                    _token: _token                
                }
            }; 
    
    $.post(entorno+"profesor/"+id+"/delete",data,function(){
            indexProfesorinfoAcademicaDefectoAno();            
    });               
}
function edit_editar_entrega_notasprofesor(id){
    $.post(entorno+'profesorperiodoentrega/'+id+'/edit',function(data){
            capa_ram_perfil_admin=$("#capa_ram_perfil_admin")
            capa_ram_perfil_admin.html(data);
    });
    
}
function update_entrega_notasprofesor(id){
    $("#form_edit_profesorperiodoEntrega").submit(function(){             
          $.ajax({
            type:"POST",
            url:entorno+'profesorperiodoentrega/'+id+'/update',
            dataType:"html",
            data:$(this).serialize(),
            beforeSend:function(){
                
              $("#loading").show();
            },
            success:function(response){
              ; 
            }

          })
          return false;
        }) 
      //**********************************************
    
}
function listar_entrega_notasprofesor(id_profesor){
    $.post(entorno+'profesorperiodoentrega/'+id_profesor+"/entregas",function(data){
            capa_ram_perfil_admin=$("#container-minostas-perfil");
            capa_ram_perfil_admin.html(data);
    });
    
}
function listarGruposPerfilAdminProfesor(){
     $.get(entorno+"grupo/directoragrupo",function(data){
           capa_ram_perfil_admin=$("#capa_ram_perfil_admin");
            capa_ram_perfil_admin.html(data);
        });  
    return;   
}
function editarGruposPerfilAdminProfesor(id){
     $.get(entorno+"grupo/"+id+"/editdirectoragrupo",function(data){
           capa_ram_perfil_admin=$("#capa_ram_perfil_admin");
            capa_ram_perfil_admin.html(data);
        });  
    return;   
}
function mostrarHorarioClaseProfesor(id_profesor){
       $.post(entorno+"horarioclase/"+id_profesor+"/horarioclase",function(data){                                                                                 
           contenido_principal=$("#sub-container");
            contenido_principal.html(data);
                return;
            });             
}
function getAlumnoCedulaProfesor(){    
     cedula=$("#ntp_inacholeebundle_profesortype_cedula").val();
     n=$("#notificador_cedula");
     n.html("<span style='color:green'>espere........</span>")
     $.post(entorno+"profesor/"+cedula+"/getprofesorcedula",function(data){
            if(data>0){
                   n.html("<span style='color:red'>Ojo ya hay un usuario con esta cedula</span>")
                   $("#boton_guardar_profesor").attr("disabled", "disabled");
            }
            else{
                     
                //$("#boton_guardar_profesor").removeAttr("disabled");
                m=$("#boton_guardar_profesor");
                m.removeAttr("disabled");
                //m.removeClass("ui-state-disabled");
                n.html("");
                
            
            }
     });  
}
function newSeguimientoProfesor(id_profesor,capawork){ 
    $capa_focus=$("#div_profe"+id_profesor);
    $('html, body').animate({ scrollTop: $capa_focus.offset().top }, 'slow');
    $.post(entorno+'profesor/'+id_profesor+'/seguimientonotas',function(data){
            c_w=$("#"+capawork);
            c_w.html(data);
            c_w.show('slow');
     });
    return

}
function listaSeguimientoProfesor(){  
     $.post(entorno+'profesor/'+'listaflujos',function(data){
            $("#page-wrapper").html(data);
      });

}
function listaSeguimientoProfesores(page){  
    mostrarMensajeNotificador("Cargando flujo de profesores ");
    sede=$("#sedes_filtro_usuario").val();
    maximo=$("#maximo").val();
    minimo=$("#minimo").val();
    query=$("#my-input2").val();
    if(query!=""){
        maximo=100;
        minimo=0;
        sede='*'
    }
    else{
        query='*';
    }
        
    data={
        'page':page,
        'sede':sede,
        'query':query,
        'maximo':maximo,
        'minimo':minimo
    };
     $.post(entorno+'profesor'+'/listaflujosprofe',data,function(data){
            $("#capa_ram_flujo_profesor").html(data);
            ocultarMensajeNotificador();
    });

}
function publicarnotasProfesores(id_profesor){  
 botn_pp=$("#button"+id_profesor);   
 html_b=botn_pp.html(); 
 botn_pp.html("Publicando Notas.Espere...")
 id_periodo_academico=0;   
 $.post(entorno+'profesor/'+id_periodo_academico+'/'+id_profesor+'/publicarnotas',function(data){
           botn_pp.html("Publicar Notas("+data+")");
           if(botn_pp.hasClass("btn-danger")){
               botn_pp.removeClass("btn-danger");
               botn_pp.addClass("btn-success");
           }
            
    });

}
function newProfesorExcellDefectoAno(){
    $.post(entorno+"profesor/newexcell",function(data){
            $("#sub-container").html(data);
            
            
        });        
}

function getHorariosClaseProfesor(id_fuente,id_destino){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Horarios De Clase. Espere....");
    alerta_principal.show()
    id_profesor=$("#"+id_fuente).val();    
    $.post(entorno+"horarioclase/"+id_profesor+"/horarioclaseoption",function(data){
              $("#"+id_destino).html(data);                    
              alerta_principal.html("Listo");
              alerta_principal.hide(5000);
                    
        }); 

    
}


function mostrarFlujoDeTrabajoDelProfsor(profesor_id){
    mostrarMensajeNotificador("Cargando Flujo De Trabajo. ");
    $.post(entorno+"profesor/"+profesor_id+"/"+3+"/seguimientonotas",function(data){
              $("# sub_container ").html(data);
              $("#page_header").html('<h1>Flujo de trabajo<small><i class="icon-double-angle-right"></i>Avance en calificación de notas.</small></h1>');
              $("# sub_container   ").html(data);
              
              ocultarMensajeNotificador();
        }); 

    
}
function newMostrarNotasDetallesFlujo(ca_id){
     ventana=$("#myModal");
     ventana.css('width','70%');
     ventana.css('height','400px');
     
   
       $.post(entorno+"cargaacademica/"+ca_id+"/verdetallescargaunprofesor",function(data){
      
          html='<div class="modal-header">';
    html+='<a class="close" data-dismiss="modal">×</a>';
    html+='<h3>Lista De Estudiantes</h3>';
    html+='</div>';
    html+='<div class="modal-body" style="font-size:12px;"> ';
    html+=data;  
    html+='</div>  ';
    html+='<div style="clear: both"></div>                       ';
    html+='</div>';
    html+='<div class="modal-footer">';
    html+='<button type="submit" id="btn_gruardar_contrato" class="btn btn-primary" onclick="$(\'#myModal\').modal(\'hide\');">Listo, Termine De Ver</button>';
    html+='</div>'; 
    
             ventana.html(html);
     $('.tarea').each(function(){
        $(this).rotate({angle : 270});
        
    });         
             $('#myModal').modal('show');
              });
          

  
}
