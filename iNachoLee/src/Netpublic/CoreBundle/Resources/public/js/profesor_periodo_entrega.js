
////////Año Escolar
///////
/////
///
//
//
///
/////
///////
////////
function showfecha_entregainfoAcademicaDefectoAno(id,id_fecha_entrega_usuario){
    
    $.post(entorno+"fecha_entregausuario/"+id_fecha_entrega_usuario+"/leido");                                  
    $.get(entorno+"fecha_entrega/"+id+"/show",function(data){
            $("#contenido_principal").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            
        });        
}

function indexfecha_entregainfoAcademicaDefectoAno(id_profesor){ 
    mostrarMensajeNotificador("Cargando ");
    $.get(entorno+"profesorperiodoentrega/"+id_profesor+"/entregas",function(data){
            capa_ram_perfil_admin=$("#container-minostas-perfil");
            capa_ram_perfil_admin.html(data);
        });        
}

function editarfecha_entregainfoinfoAcademicaDefectoAno(id){
    mostrarMensajeNotificador("Cargando para editar");
    
    $.post(entorno+"profesorperiodoentrega/"+id+"/edit",function(data){
        capa_ram_perfil_admin=$("#container-minostas-perfil");
            capa_ram_perfil_admin.html(data);
        ocultarMensajeNotificador();
        
     });      
}
function updatefecha_entregainfoinfoAcademicaDefectoAno(id,id_profesor){
                
             
    //*****************************************
   //Formulario Nuevo Periodo Academico********
  
        $("#1").submit(function(){             
              $.ajax({
                type:"POST",
                url:entorno+'profesorperiodoentrega/'+id+'/update',
                dataType:"html",
                data:$(this).serialize(),
                beforeSend:function(){                        
                    mostrarMensajeNotificador("Actualizando ");
                },
                success:function(response){           
                 ocultarMensajeNotificador();
                 indexfecha_entregainfoAcademicaDefectoAno(id_profesor);
                }

                })
          return false;
        }); 
  
      //********************************************** 
}
function newfecha_entregainfoAcademicaDefectoAno(id_profesor){
    alerta_principal=$("#alerta_principal");
                    alerta_principal.html("Cargando....");
                    alerta_principal.show();
    $.post(entorno+"profesorperiodoentrega/"+id_profesor+"/new",function(data){
            $("#contenido_principal").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            alerta_principal.html("Listo"); alerta_principal.hide(5000);
            
        });        
}
         
function createfecha_entregainfoAcademicaDefectoAno(id_profesor){
               
             
    //*****************************************
   //Formulario Nuevo Periodo Academico********
  
        $("#1").submit(function(){             
              $.ajax({
                type:"POST",
                url:entorno+'profesorperiodoentrega/'+id_profesor+'/create',
                dataType:"html",
                data:$(this).serialize(),
                beforeSend:function(){                        
                    alerta_principal=$("#alerta_principal");
                    alerta_principal.html("Cargando....");
                    alerta_principal.show();
                },
                success:function(response){           
                 alerta_principal.html("Listo"); alerta_principal.hide(5000);
                 indexfecha_entregainfoAcademicaDefectoAno(id_profesor);
                }

                })
          return false;
        }); 
  
      //********************************************** 
      
}
         
function deletefecha_entregaUsuarioinfoAcademicaDefectoAno(id,id_profesor){
             
             
    //*****************************************
   //Formulario Nuevo Periodo Academico********
  
        $("#"+id).submit(function(){             
              $.ajax({
                type:"POST",
                url:entorno+'profesorperiodoentrega/'+id+'/delete',
                dataType:"html",
                data:$(this).serialize(),
                beforeSend:function(){                        
                    alerta_principal=$("#alerta_principal");
                    alerta_principal.html("Eliminando....");
                    alerta_principal.show();
                },
                success:function(response){           
                 alerta_principal.html("Listo"); alerta_principal.hide(5000);
                 indexfecha_entregainfoAcademicaDefectoAno(id_profesor);
                }

                })
          return false;
        }); 
  
      //**********************************************    
}
function getNumerosfecha_entregasLeidosTipo()
{
    $.post(entorno+"fecha_entregausuario/numerofecha_entrega",function(data){
            
            var nro_fecha_entregas = jQuery.parseJSON(data);   
            
            if(nro_fecha_entregas.fecha_entregas_importantes!=0)
                $("#numero_fecha_entregas_importante").html(nro_fecha_entregas.fecha_entregas_importantes);
            else
                $("#numero_fecha_entregas_importante").hide();
            if(nro_fecha_entregas.fecha_entregas_informaciones!=0)
                $("#numero_fecha_entregas_info").html(nro_fecha_entregas.fecha_entregas_informaciones);
            else
                $("#numero_fecha_entregas_info").hide();
            if(nro_fecha_entregas.fecha_entregas_felicitaciones!=0)
                $("#numero_fecha_entregas_felicitaciones").html(nro_fecha_entregas.fecha_entregas_felicitaciones);
            else
                $("#numero_fecha_entregas_felicitaciones").hide();
            $("#cont_nro_fecha_entregas").show();
                
    });
    url=document.URL;
    uri_carga_academica=url.search('grupo/calificarr');
    if(uri_carga_academica>0){
        if($("#asignatura_grupo").val()!='*' && $("#periodo_calificar_nota").val()!='*')
            listaAlumnosGrupoAsignaturaPeriodoInacholee();
    }
  
    
    return;
}



