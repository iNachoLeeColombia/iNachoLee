/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function showCriterioAcademicoAno(id){  
    mostrarMensajeNotificador("Cargando.");
    $.get(entorno+"grupo/"+id+"/show",function(data){
            $("#tabs5-0").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            ocultarMensajeNotificador();
      });        
}
          
function indexCriterioAcademicoAno(){ 
    mostrarMensajeNotificador("Cargando. ");
    $.get(entorno+"criteriopromocion/",function(data){
        $("#panel_new_cp").html(data);  
        ocultarMensajeNotificador()
    }); 
    return;    
}

function editarCriterioAcademicoAno(id){
    mostrarMensajeNotificador("Cargando. ");
    $.post(entorno+"criteriopromocion/"+id+"/edit",function(data){
        $("#capa_editar_"+id).html(data);
        ocultarMensajeNotificador()
    });        
}
function updateCriterioAcademicoAno(id){
  mostrarMensajeNotificador("Cargando. ");  
  $("#edit_criterio_promocion").submit(function(){             
          $.ajax({
            type:"POST",
            url:entorno+"criteriopromocion/"+id+"/update",
            dataType:"html",
            data:$(this).serialize(),
            beforeSend:function(){                 
              $("#loading").show();
            },
            success:function(response){
                ocultarMensajeNotificador();
                indexCriterioAcademicoAno();
                
            }

          })
          return false;
        }) 

            
}
function newCriterioAcademicoAno1(){
    mostrarMensajeNotificador("Cargando. ");
    $.post(entorno+"criteriopromocion/new",function(data){
            $("#panel_new_cp").html(data);
            ocultarMensajeNotificador()
            });        
}
         
function createCriterioAcademicoAno(){
    mostrarMensajeNotificador("Cargando. ");
   $("#new_criterio_promocion").submit(function(){             
          $.ajax({
            type:"POST",
            url:entorno+"criteriopromocion/create",
            dataType:"html",
            data:$(this).serialize(),
            beforeSend:function(){                 
              $("#loading").show();
            },
            success:function(response){
                ocultarMensajeNotificador()                
                indexCriterioAcademicoAno()
            }

          })
          return false;
        }) 
}
function deleteCriterioAcademicoAno(id){
    mostrarMensajeNotificador("Cargando. ");
   $("#criterio_eleminar"+id).submit(function(){             
          $.ajax({
            type:"POST",
            url:entorno+"criteriopromocion/"+id+"/delete",
            dataType:"html",
            data:$(this).serialize(),
            beforeSend:function(){                 
              $("#loading").show();
            },
            success:function(response){
                ocultarMensajeNotificador();
                indexCriterioAcademicoAno();
            }

          })
          return false;
        }) 

}

function agregarCriterioAcademicoAno(id){
    mostrarMensajeNotificador("Cargando. ");
    simbolo=$("#simbolo_separador"+id).val();
    id_hijo=$("#criterio_hijo"+id).val();
    id_padre=$("#criterio_padre"+id).val();    
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Agregando Criterio academico. Espere....");
    alerta_principal.show();
    $.post(entorno+"criteriopromocion/"+id_padre+'/'+id_hijo+'/'+simbolo+"/unir",function(data){
            $("#tabs1-0-0").html(data);            
            ocultarMensajeNotificador();
    indexCriterioAcademicoAno();
            
        });        
}

function guardarNotaMinima(){
    mostrarMensajeNotificador("Cargando. ");
    nota_minima_colegio=$("#nota_minima_colegio").val();
    $boton=$("#button_guardar_nota");
    $boton.html("Espere...");
    $.post(entorno+"colegio/guardarnotaminima",{nota_minima:nota_minima_colegio},function(data){
       if(data=='ok')
        $boton.html("Guardar Nota Minima");
       else     
         $boton.html("Error");   
        });
        ocultarMensajeNotificador();
}
function getGruposGradoPromover(grado_id){
    $btn_ano_escolar_actual=$("#capa_ano_actual_grado"+grado_id);
    $.post(entorno+"grado/"+grado_id+"/gruposlista",function(data){            
       $btn_ano_escolar_actual.html(data);
       $btn_ano_escolar_siguiente.html(data);
    });    
}
function mostrarGruposAnoSiguiente(grado_actual_id){
    mostrarMensajeNotificador("Cargando grupos. ");
    grado_siguiente_id=$("#select_grado_siguiente"+grado_actual_id).val();
    $btn_ano_escolar_siguiente=$("#capa_ano_siguiente_grado"+grado_actual_id);    
    $.post(entorno+"colegio/"+grado_actual_id+"/"+grado_siguiente_id+"/grupos",function(data){            
       
       $btn_ano_escolar_siguiente.html(data);
        ocultarMensajeNotificador();
    });    
    
    
}
function promoverTotalSeleccioandos(){
    var ids = new Array();
    var ids_sigiente = new Array();
    $("select.grupo_destino").each(function(e){
        $id=$(this);
        if($id.val()!='*'){
            grupo_actual=this.getAttribute('grupo-data-id');
            ids.push(parseInt(grupo_actual));
            ids_sigiente.push(parseInt($id.val()));
        }
    });
    procesarpromoverTotalSeleccioandos(ids,ids_sigiente,0);
    
}
function procesarpromoverTotalSeleccioandos(alumnos_grupo,a_g_s,index){
    grupo_actual=alumnos_grupo[index];
    grupo_siguiente=a_g_s[index];
    $.post(entorno+"grupo/"+grupo_actual+"/alumnos",function(data){
        mostrarMensajeNotificador("promoviendo a"+data.nombre);
        ids_alumnos_promover=jQuery.parseJSON(data);
            promoverAhoraAlumno(0,ids_alumnos_promover,grupo_siguiente);
            if(index+1>alumnos_grupo.length-1){
                ocultarMensajeNotificador();
                return;
            }
        procesarpromoverTotalSeleccioandos(alumnos_grupo,a_g_s,index+1);
    });
    
}
function promover(grupo_actual){
    grupo_siguiente=$("#select_grupo_siguiente"+grupo_actual).val();
    $.post(entorno+"grupo/"+grupo_actual+"/alumnos",function(data){
        ids_alumnos_promover=jQuery.parseJSON(data);        
        promoverAhoraAlumno(0,ids_alumnos_promover,grupo_siguiente);
        ocultarMensajeNotificador();
    });    
}
function promoverAhoraAlumno(posicion,ids_alumnos_promover,grupo_siguiente){
    if(ids_alumnos_promover.length>0){
        $.post(entorno+"alumno/"+ids_alumnos_promover[posicion].id+"/"+grupo_siguiente+"/promover",function(data){
        mostrarMensajeNotificador(data);
        if(posicion+1>ids_alumnos_promover.length-1){
            ocultarMensajeNotificador();
            return;
        }
        promoverAhoraAlumno(posicion+1,ids_alumnos_promover,grupo_siguiente);
        console.info(ids_alumnos_promover.length);
    
    });
    }
    else{
        mostrarMensajeNotificador("No hay alumnos el grupo origen");
    }
        
}