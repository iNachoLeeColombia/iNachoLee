/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function indexObservacionAlumno(id_alumno){
    mostrarMensajeNotificador("Cargando observador. ");
    $.post(entorno+"observacion/"+id_alumno+"/customindex",function(data){
            $("#container-minostas-perfil").html(data);
            ocultarMensajeNotificador();
      }
      );
}
function indexObservacionPerfilAlumno(id_alumno){
    $.post(entorno+"observacion/"+id_alumno+"/customindex",function(data){
            
            $("#capa_ram_tabs3-0").html(data);
      }
      );
}
function showObservacionPerfilAlumno(id_observacion){
     $.post(entorno+"observacion/"+id_observacion+"/show",function(data){
                  $("#capa_ram_tabs3-0").html(data);
      }
      );
}
function newObservacionAlumno(id_alumno){
    $.post(entorno+"observacion/"+id_alumno+"/new",function(data){
            $("#sub-contaner-observador-estudiante").html(data);
            
      }
      );
}
function createObservacionAlumno(id_alumno){
     
        $("#1").submit(function(){             
              $.ajax({
                type:"POST",
                url:entorno+'observacion/'+id_alumno+'/create',
                dataType:"html",
                data:$(this).serialize(),
                beforeSend:function(){                        
                    $("#loading").show();
                },
                success:function(response){           
                    $("#response").html(response);
                    $("#loading").hide();
                 indexObservacionAlumno(id_alumno);
                }

                })
          return false;
        }); 
  
      //**********************************************
}
function showObservacionAlumno(id_observacion){
     $.post(entorno+"observacion/"+id_observacion+"/show",function(data){
            $("#capa_ram_perfil_admin_alumno").html(data);
      }
      );
}
function editObservacionAlumno(id_observacion){
   $.post(entorno+"observacion/"+id_observacion+"/edit",function(data){
            $("#capa_ram_perfil_admin_alumno").html(data);
      }
      );
}
function updateObservacionAlumno(id_observacion,id_alumno){
     
        $("#1").submit(function(){             
              $.ajax({
                type:"POST",
                url:entorno+'observacion/'+id_observacion+'/update',
                dataType:"html",
                data:$(this).serialize(),
                beforeSend:function(){                        
                    $("#loading").show();
                },
                success:function(response){           
                    $("#response").html(response);
                    $("#loading").hide();
                 indexObservacionAlumno(id_alumno);
                }

                })
          return false;
        }); 
  
      //**********************************************
}
function deleteObservacionAlumno(id_observacion,id_alumno){
     
        $("#1").submit(function(){             
              $.ajax({
                type:"POST",
                url:entorno+'observacion/'+id_observacion+'/delete',
                dataType:"html",
                data:$(this).serialize(),
                beforeSend:function(){                        
                    $("#loading").show();
                },
                success:function(response){           
                    $("#response").html(response);
                    $("#loading").hide();
                 indexObservacionAlumno(id_alumno);
                }

                })
          return false;
        }); 
  
      //**********************************************
}
function editObservadoralumno(alumno_desempeno_id){
    mostrarMensajeNotificador("Cargando notas. ");
     $.post(entorno+"alumno/"+alumno_desempeno_id+"/editarobservacion",function(data){
            ocultarMensajeNotificador();
            $("#capa_observador_alumno_"+alumno_desempeno_id).html(data);
            $("#update_a_"+alumno_desempeno_id).show();
            $("#editar_a_"+alumno_desempeno_id).hide();
            
    });
}
function updateObservadoralumno(alumno_desempeno_id){
    mostrarMensajeNotificador("Cargando notas. ");
    desempeno=$("#t_area"+alumno_desempeno_id).val();
    $.post(entorno+"alumno/"+alumno_desempeno_id+"/updateobservacion",{'desenpeno': desempeno},function(data){
            ocultarMensajeNotificador();
            
            $("#capa_observador_alumno_"+alumno_desempeno_id).html(data);
            $("#update_a_"+alumno_desempeno_id).hide();
            $("#editar_a_"+alumno_desempeno_id).show();
            
    });
}
function deleteObservadoralumno(alumno_id,alumno_desempeno_id){
    mostrarMensajeNotificador("Cargando notas. ");
    $.post(entorno+"alumno/"+alumno_desempeno_id+"/deleteobservacion",function(data){
       
  });
}
