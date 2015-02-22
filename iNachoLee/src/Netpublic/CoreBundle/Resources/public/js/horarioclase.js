function verHorarioClase(){    
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Horarios.Espere...........");
    alerta_principal.show();
    
    $.post(entorno+"horarioclase/verall",function(data){
                  $("#capa_ram_ca").html(data);
               alerta_principal.html("Listo");
               alerta_principal.hide(4000);
    }); 
}
function  generarHorarioClase(){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Generando Horarios.Espere....");
    alerta_principal.show();
    
    $.post(entorno+"horarioclase/generarall",function(data){
               alerta_principal.html("Listo");
               alerta_principal.hide(4000);

         verHorarioClase();
    });     
}
function  generarPorParteHorarioClase(grupo_id){
    mostrarMensajeNotificador("Generando Horario De Clase.");
    $.post(entorno+"horarioclase/"+grupo_id+"/generarporpartes",function(data){
          $("#mostrar_fin_gneracion_grupo_"+grupo_id).html("<div style='background-color:yellow;color: black;'>Horario Generado: OK.</div>")
      
        ocultarMensajeNotificador();
    });     
}
function  generarPorParteGradoHorarioClase(grado_id){
    mostrarMensajeNotificador("Generando Horario De Clase.");
    $.post(entorno+"horarioclase/"+grado_id+"/generarporpartesgrado",function(data){
        $("#mostrar_fin_gneracion"+grado_id).html("<div style='background-color:yellow;color: black;'>Horario Generado: OK.</div>")
        ocultarMensajeNotificador();
    });     
}

function borrarHorarioClase(){
    if(confirm("Esta seguro de Eliminar todos los Horarios De clases.?")){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Borrando Horarios.Espere....");
    alerta_principal.show();

    $.post(entorno+"horarioclase/borrar",function(data){
                alerta_principal.html("Listo");
               alerta_principal.hide(4000);
         verHorarioClase();
    });     
    }
}
function imprimirHorarioClase(){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Exportando Horario Clase.Espere....");
    alerta_principal.show();

    $.post(entorno+"horarioclase/imprimir",function(data){        
         alerta_principal.html("Listo");
         alerta_principal.hide(4000);
                  $("#capa_ram_ca").html(data);
         
    });     
    
}

function verTiemposLibresHorarioClase(){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Mostrando Condiciones en Tiempos Libres.Espere.......");
    alerta_principal.show();        
    $.post(entorno+"horarioclase/vertiemposlibres",function(data){               
          $("#capa_ram_ca").html(data);
          alerta_principal.html("Listo");
          alerta_principal.hide(5000);         
          return;
    });                
         

}

function verificarHorarioClase(){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("VerificandoCondiciones.Espere.......");
    alerta_principal.show();        
    $.post(entorno+"horarioclase/verificar",function(data){               
          $("#capa_ram_ca").html(data);
          alerta_principal.html("Listo");
          alerta_principal.hide(5000);         
          return;
    });                
         

}
function newGenerarPorPartesHorarioClase(){
    alerta_principal=$("#alerta_principal");
    
    if(confirm("Se Borraran todos los horarios viiejos generados. Esta seguro De Borrar??")){
        $.post(entorno+"horarioclase/borrar",function(data){
                alerta_principal.html("Listo");
          mostrarMensajeNotificador("Cargando Para Generación Por partes. ");
           //verHorarioClase();
    $.post(entorno+"horarioclase/newgenerarporpartes",function(data){               
          $("#capa_ram_ca").html(data);
          ocultarMensajeNotificador();
        return;
    });
    });
    
    }

}
function verDetallesGradoHoracioClase(grado_id){
    mostrarMensajeNotificador("Cargando Grupos. ");
    $.post(entorno+"horarioclase/"+grado_id+"/verdetallesgrado",function(data){    
          
          $("#capa_detalles_grado"+grado_id).html(data);
            $("#capa_detalles_grado"+grado_id).show();
        ocultarMensajeNotificador();
        return;
    });                
         

}

function newConfiguracionHorarioClase(){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Actualizando.Espere....");
    alerta_principal.show();

    $.post(entorno+"horarioclase/newconfiguracion",function(data){        
         alerta_principal.html("Listo");
         alerta_principal.hide(4000);
         $("#capa_ram_ca").html(data);
             nro_clase=$("#nro_clase_dia").val();
           $.post(entorno+"condicioncargaacademicacolegio/"+nro_clase+"/ver",function(data){        
            alerta_principal.html("Listo");
            alerta_principal.hide(4000);
            $("#capa_ram_ca_horario_configuracion").html(data);         
        });                       
    });     
    
}
function verHorarioConfiguracionColegio(){
            nro_clase=$("#nro_clase_dia").val();
           $.post(entorno+"condicioncargaacademicacolegio/"+nro_clase+"/ver",function(data){        
            alerta_principal.html("Listo");
            alerta_principal.hide(4000);
            $("#capa_ram_ca_horario_configuracion").html(data);         
        });                       

}
function generarMostrarHorarioConfiguracion(){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Nueva Configruración.Espere....");
    alerta_principal.show();
    nro_clase=$("#nro_clase_dia").val();
    $.post(entorno+"condicioncargaacademicacolegio/"+nro_clase+"/generarhorario",function(data){        
         alerta_principal.html("Listo");
         alerta_principal.hide(4000);
         $.post(entorno+"condicioncargaacademicacolegio/"+nro_clase+"/ver",function(data){        
            alerta_principal.html("Listo");
            alerta_principal.hide(4000);
            $("#capa_ram_ca_horario_configuracion").html(data);         
        });                       
    });     

}
function procesarClickHorarios(id){
    tipo=cambiarEstadoCelda(id);
       $.post(entorno+"condicioncargaacademicacolegio/"+tipo+"/"+id+"/cambiarestado",function(data){        
            alerta_principal.html("Listo");
            alerta_principal.hide(4000);
            $("#celda_madre"+id).html(data);
   });                       

}
function procesarFilaHorarios(fila,tipo){
  $.post(entorno+"condicioncargaacademicacolegio/"+tipo+"/"+fila+"/cambiarestadofila",function(data){        
            alerta_principal.html("Listo");
            alerta_principal.hide(4000);            
            verHorarioConfiguracionColegio();             
   });                       

    
}
function procesarColumnaHorarios(columna,tipo){       
       $.post(entorno+"condicioncargaacademicacolegio/"+tipo+"/"+columna+"/cambiarestadocolumna",function(data){        
            alerta_principal.html("Listo");
            alerta_principal.hide(4000);            
            verHorarioConfiguracionColegio();             
   });                       
         
    
}
function cambiarEstadoCelda(id){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cambiando Estado De Celda.Espere....");
    alerta_principal.show();        
    celda=$("#celda"+id);        
    tipo=-1;
    if(celda.hasClass('celda_libre')){        
        tipo=1;    
        
    }                              
    if(celda.hasClass('celda_ocupada')){        
        tipo=0;                
    }
    if(tipo==0){
        celda.removeClass('celda_acupada');        
        celda.addClass('celda_libre');
        html="<i class='icon-check'></i>";
        
    }
    if(tipo==1){        
        celda.removeClass("celda_libre");                        
        celda.addClass('celda_acupada');        
        html="<i class='icon-remove-circle'></i>";        
    }
    
   return tipo;
    
}