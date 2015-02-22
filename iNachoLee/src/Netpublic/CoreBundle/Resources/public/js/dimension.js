
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
function showDimensioninfoAcademicaDefectoAno(tipo,id){
    tipo_global=tipo;
    $.get(entorno+"dimension/"+id+"/show",function(data){
            $("#_tabs1-"+tipo).html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            
        });        
}

function indexDimensioninfoAcademicaDefectoAno(e){ 
    $.get(entorno+"dimension/"+e,function(data){
            $("#home").html(data);            
    });        
}

function editarDimensioninfoAcademicaDefectoAno(tipo,id){
    tipo_global=tipo;
    $.get(entorno+"dimension/"+id+"/edit",function(data){
            $("#home").html(data);            
            ocultarMensajeNotificador();
            
        });        
}
function updateDimensioninfoAcademicaDefectoAno(e){
    id=e;
    token=$("#ntp_inacholeebundle_dimensiontype__token").val();
    nombre=$("#ntp_inacholeebundle_dimensiontype_nombre").val();
    e_c=$("#ntp_inacholeebundle_dimensiontype_es_carita_feliz").val();
    padre=$("#ntp_inacholeebundle_dimensiontype_padre").val();
    asignatura=$("#ntp_inacholeebundle_dimensiontype_asignatura").val();
    grupo=$("#ntp_inacholeebundle_dimensiontype_asignatura").val()|| [];      
    var data = {
                ntp_inacholeebundle_dimensiontype:{
                        nombre: nombre, 
                        es_carita_feliz: e_c,
                        padre: padre,
                        asignatura: asignatura,
                        _token: token,
                        grupo: {
                              '': grupo          
                            }
                        
                }
            };  
    $.post(entorno+"dimension/"+id+"/update",data,function(data){
            $.post(entorno+"dimension/0",data,function(data){
                $("#_tabs1-1").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            ocultarMensajeNotificador();
            });
            
            
        });        
}
         
function newDimensioninfoAcademicaDefectoAno(tipo){
    mostrarMensajeNotificador("Cargando");
    $.post(entorno+"dimension/"+tipo+"/new",function(data){
            $("#home").html(data);            
            ocultarMensajeNotificador();
        });        
}
         
function createDimensioninfoAcademicaDefectoAno(tipo){
               
    token=$("#ntp_inacholeebundle_dimensiontype__token").val();
    
    nombre=$("#ntp_inacholeebundle_dimensiontype_nombre").val();
    e_c=$("#ntp_inacholeebundle_dimensiontype_es_carita_feliz").val();
    
    padre=$("#ntp_inacholeebundle_dimensiontype_padre").val();    
    asignatura=$("#ntp_inacholeebundle_dimensiontype_asignatura").val();    

    
    var data = {
                ntp_inacholeebundle_dimensiontype:{
                        nombre: nombre, 
                        es_carita_feliz: e_c,
                        padre: padre,
                        asignatura: asignatura,
                        _token: token
                
                }
            };  
    mostrarMensajeNotificador("Cargando");        
    $.post(entorno+"dimension/"+tipo+"/create",data,function(data_){
            $.get(entorno+"dimension/"+tipo,function(data){
                $("#home").html(data);            
                ocultarMensajeNotificador();
            });
            
            
        });        
}
         
function deleteDimensioninfoAcademicaDefectoAno(tipo,id){
    //*****************************************
   //Formulario Nuevo Periodo Academico********
    $("#form_"+id).submit(function(){             
              $.ajax({
                type:"POST",
                url:entorno+'dimension/'+id+'/delete',
                dataType:"html",
                data:$(this).serialize(),
                beforeSend:function(){                        
                    
                },
                success:function(response){           
                    indexinfoAcademicaDefectoAno(tipo);    
                                
            cr_a_d=$("#capa_ram_actividades_desempenos_calificar_nota")
                cr_a_d.hide("slow");
                cr_a_d.html("");
                mostrarMensajeNotificador("Cargando");
                if(tipo==4)
                $.post(entorno+"grupo/calificareditar",
            helperactualizarAllNotasAlumnoGrupo);    
                 
                }

                })
          return false;
        }); 
  
      //********************************************** 
}

function procesarAdicionDimension(){
    
    nombre_dim=$("#nombre_dim").val();
    ponderado=$("#ponderado").val();
    var carga_academica_checked = new Array();
    nro_hijos_profesores_checked=new Array();
    checks=$("input:checked.carga");
     if(checks.length>0){
        checks.each(function(i){ 
            carga_academica_checked.push(parseInt(this.value));
        });
        var carga_academica = $.toJSON(carga_academica_checked);      
     }
    data={
        'nombre':nombre_dim,
        'ponderado': ponderado,
        'carga_academica': carga_academica,
    };
    mostrarMensajeNotificador("Cargando.");
    $.post(entorno+"dimension/adicionarcomponentes",data,function(data){     
          $("#capa_adicionar_compomentes").hide();
          ocultarMensajeNotificador();
    });
    
}

function procesarAdicionItem(){    
    nombre_dim=$("#nombre_dim").val();
    console.info(nombre_dim);
    ponderado=$("#ponderado").val();
    var componente_checked = new Array();
    var carga_checked = new Array();
    
    checks=$("input:checked.compo");
     if(checks.length>0){
        checks.each(function(i){
            carga_checked.push(parseInt(this.getAttribute('data-carga-id')));
            componente_checked.push(parseInt(this.value));
        });
        var componentes = $.toJSON(componente_checked);      
        var cas=$.toJSON(carga_checked);
     }
    data={
        'nombre':nombre_dim,
        'ponderado': ponderado,
        'componentes': componentes,
        'cas':cas
    };
    mostrarMensajeNotificador("Cargando");
    $.post(entorno+"dimension/adicionaritems",data,function(data){     
            //$("#capa_ram_profesores_componentes"+id_componente).html(data);
            //$("#capa_ram_profesores_componentes"+id_componente).show();
           ocultarMensajeNotificador();
    }); 
    
}

function verComponentesUnProfesor(id,tipo){
    //
    tiene=false;
    anchor_detalles_profesor=$("#anchorVerComponentesUnProfesor"+id);
    if(anchor_detalles_profesor.hasClass('mas_detalles_profesor')){
        tiene=true;
    }
    if(tiene){
        anchor_detalles_profesor.removeClass('mas_detalles_profesor');
        anchor_detalles_profesor.addClass('menos_detalles_profesor');
    }
    else
    {
        anchor_detalles_profesor.removeClass('menos_detalles_profesor');
        anchor_detalles_profesor.addClass('mas_detalles_profesor');
    
    }
    if(anchor_detalles_profesor.hasClass('mas_detalles_profesor')){        
        anchor_detalles_profesor.html("Ver ++");
        $("#capa_ram_profesores_componentes"+id).html(" ");
        $("#capa_ram_profesores_componentes"+id).hide();
        
     }
    if(anchor_detalles_profesor.hasClass('menos_detalles_profesor')){
        mostrarMensajeNotificador("Cargando");
          $.post(entorno+"cargaacademica/"+id+"/mostrardetallesprofesor",function(data){
            if(tipo==1){  
            $("#capa_ram_profesores_componentes"+id).html(data);
            $("#capa_ram_profesores_componentes"+id).show();
            anchor_detalles_profesor.html("Ver -- --");     
            }
            else{
                $("#helper_zoom").html(data);
            }
            ocultarMensajeNotificador();
            //$("#profesor_gcomp"+id).attr('checked',true);
            //allcheckProfesores("profesor_gcomp"+id,'carga_profesor'+id);
         });
        
    }

    
}
function verComponentesUnProfesorDetalles(id){
    mostrarMensajeNotificador("Cargando");
          $.post(entorno+"cargaacademica/"+id+"/vercargaunprofesor",function(data){
                $("#helper_zoom").html(data);
                ocultarMensajeNotificador();
          });  
    
}
function verDetallesCargaAcademicaProfesor(id){
    mostrarMensajeNotificador("Cargando");
          $.post(entorno+"cargaacademica/"+id+"/verdetallescargaunprofesor",function(data){
                $("#sub-container-right").html(data);
                 $('.tarea').each(function(){
                 $(this).rotate({angle : 270});
                 ocultarMensajeNotificador();
        
    });
          });  
    
}

function procesarSeleccionProfesor(id){
    
            allcheckProfesores("profesor_gcomp"+id,"carga_profesor"+id);

}
function procesarCheckTodos(){
    allcheckProfesoresCopiar('todos_check','cbox');

}
function copiarCargaAcadeimica(){
     borrarMensajeLetrero('letrero');
     checks_carga_academica=$("input:checked.fila_ca");
     checks_componentes=$("input:checked.componente");
     checks_items=$("input:checked.item");
     setNombreClaseCopiaOrigen('copiar_ca','fila_ca','copiar')
     setNombreClaseCopiaOrigen('copiar_componente','componente','copiar');
     setNombreClaseCopiaOrigen('copiar_item','item','copiar');
    var componentes_copiar_checked=new Array();
    var nro_hijos_componentes_copiar_checked=new Array();
    var items_checked = new Array();
    var componentes_padres_checked = new Array();
    //Componentes A copiar
    checks=$("input:checked.copiar_componente");
     if(checks.length>0){
        checks.each(function(i){
            nro=$("input:checked.item"+this.value).length;
            nro_hijos_componentes_copiar_checked.push(parseInt(nro));            
            componentes_copiar_checked.push(parseInt(this.value));
        });
        var componentes_copiar = $.toJSON(componentes_copiar_checked);  
        var hijos_componentes_copiar= $.toJSON(nro_hijos_componentes_copiar_checked);
        }
    //Items
    checks=$("input:checked.copiar_item");
     if(checks.length>0){
        checks.each(function(i){
            componentes_padres_checked.push(parseInt(this.getAttribute('data-padre')));
            items_checked.push(parseInt(this.value));
        });
        var componentes_padres = $.toJSON(componentes_padres_checked);      
        var items=$.toJSON(items_checked);
     }
     $("#pegar_gestor_comp").css('color','orange');
     $("#pegar_gestor_comp").css('background-color','orange');
     

         data={
        'componentes_copiar':componentes_copiar,
        'nro_hijos_componente_copiar': hijos_componentes_copiar,        
        'items_copiar':items,
        'padres_copiar': componentes_padres,
       
    };
    mostrarMensajeNotificador("Cargando");
    $.post(entorno+"dimension/guardarsesioncopiar",data,function(data){     
           ocultarMensajeNotificador();
    }); 

}

function getJsonClase(clase){
    var componente_checked= new Array();
    
    checks=$("input:checked."+clase);
     if(checks.length>0){
        checks.each(function(i){
            componente_checked.push(parseInt(this.value));
        });
        var componentes = $.toJSON(componente_checked);      
        
     }
     return componentes;
}

function crearComponentes(){
            $origen=$("input.origen");
            $destinos=$("input.destino");
            procesarCrearComponentesServidor($origen,$destinos,0);
}
function procesarCrearComponentesServidor($origen_array,$destinos,index){
    $origen=$origen_array[0];
    $destino=$destinos[index];
//Compo---->Cargaasignatura    
    if($($origen).hasClass('compo_origen') && $($destino).hasClass('carga_destino')){
        mostrarMensajeNotificador("Creando componentes ");
        compo_origen_id=$origen.value;
        carga_origen_id=$origen.getAttribute('data-carga-id');
        carga_destino_id=$destino.value;
        $.post(entorno+"dimension/"+compo_origen_id+"/"+carga_origen_id+"/"+carga_destino_id+"/crearcomponente",function(data){
               if(index+1>$destinos.length-1){
                    ocultarMensajeNotificador();
                    console.info("Terminamos de adicionar");
                    return;
                } 
                procesarCrearComponentesServidor($origen_array,$destinos,index+1);
           
       });
    }
//Compo---->Compo    
    if($($origen).hasClass('compo_origen') && $($destino).hasClass('compo_destino')){
        mostrarMensajeNotificador("Copiando componente a componente ");
        compo_origen_id=$origen.value;
        carga_origen_id=$origen.getAttribute('data-carga-id');
        compo_destino_id=$destino.value;
        carga_destino_id=$destino.getAttribute('data-carga-id');
        
        $.post(entorno+"dimension/"+compo_origen_id+"/"+compo_destino_id+"/"+carga_origen_id+"/"+carga_destino_id+"/pegarcomponentecomponente",function(data){     
                    mostrarMensajeNotificador("Copiando componentes ");                    
                    
        }); 
        ocultarMensajeNotificador();
        if(index+1>$destinos.length-1){
             ocultarMensajeNotificador();
             
             return;
        } 
                procesarCrearComponentesServidor($origen_array,$destinos,index+1);
           
   }
//Compo---->Grupo    
    if($($origen).hasClass('compo_origen') && $($destino).hasClass('grupo_destino')){
        mostrarMensajeNotificador("Copiando Componente a grupo");
        compo_origen_id=$origen.value;
        carga_origen_id=$origen.getAttribute('data-carga-id');
        grupo_destino_id=$destino.value;
        $.post(entorno+"cargaacademica/"+grupo_destino_id+"/mostrargrupo.json",function(data){     
             console.info(data.length);
             $cargas_destino=data;
             procesarVariasCargas($origen,$cargas_destino,0);
             if(index+1>$destinos.length-1){
               ocultarMensajeNotificador();
               
               return;
            }
            procesarCrearComponentesServidor($origen_array,$destinos,index+1);
    
        });
    }
//Compo ---->Grado.
    if($($origen).hasClass('compo_origen') && $($destino).hasClass('grado_destino')){
        mostrarMensajeNotificador("Copiando componente a grado ");
        compo_origen_id=$origen.value;
        carga_origen_id=$origen.getAttribute('data-carga-id');
        grado_destino_id=$destino.value;
        $.post(entorno+"cargaacademica/"+grado_destino_id+"/mostrarcargagrado.json",function(data){     
             console.info(data.length);
             $cargas_destino=data;
             procesarVariasCargas($origen,$cargas_destino,0);
             if(index+1>$destinos.length-1){
               ocultarMensajeNotificador();
               return;
            }
            procesarCrearComponentesServidor($origen_array,$destinos,index+1);
    
        });
    }
//Carga ---->Carga.
    if($($origen).hasClass('carga_origen') && $($destino).hasClass('carga_destino')){
        mostrarMensajeNotificador("Copiando componente de una asigatura a otra asigatura ");
        carga_origen_id=$origen.value;
        carga_destino_id=$destino.value;
        $.post(entorno+"dimension/"+carga_origen_id+"/"+carga_destino_id+"/pegarcargacarga",function(data){
               if(index+1>$destinos.length-1){
                    ocultarMensajeNotificador();
                    
                    return;
                } 
                procesarCrearComponentesServidor($origen_array,$destinos,index+1);
           
       });

    }
//Carga ---->Grupo.
    if($($origen).hasClass('carga_origen') && $($destino).hasClass('grupo_destino')){
        mostrarMensajeNotificador("Copiando componente de una asignatura a un grupo ")
        carga_origen_id=$origen.value;
        grupo_destino_id=$destino.value;
        $.post(entorno+"cargaacademica/"+grupo_destino_id+"/mostrargrupo.json",function($cargas){
            procesarCargaGrupo(carga_origen_id,$cargas,0);
            procesarCrearComponentesServidor($origen_array,$destinos,index+1);
            ocultarMensajeNotificador();
        });
    }
//Carga ---->Grado.
    if($($origen).hasClass('carga_origen') && $($destino).hasClass('grado_destino')){
        mostrarMensajeNotificador("Copiando componente de una asignatura a un grado ")
        carga_origen_id=$origen.value;
        grado_destino_id=$destino.value;
        $.post(entorno+"cargaacademica/"+grado_destino_id+"/mostrarcargagrado.json",function($cargas){
            procesarCargaGrupo(carga_origen_id,$cargas,0);
            procesarCrearComponentesServidor($origen_array,$destinos,index+1);
            ocultarMensajeNotificador();
        });
    }
//Grupo ---->Grupo.
    if($($origen).hasClass('grupo_origen') && $($destino).hasClass('grupo_destino')){
        mostrarMensajeNotificador("Copiando componente de un grupo a otro grupo");
        grupo_origen_id=$origen.value;
        grupo_destino_id=$destino.value;
        $.post(entorno+"cargaacademica/"+grupo_origen_id+"/mostrargrupo.json",function($cargas_grupo_origen){
            $.post(entorno+"cargaacademica/"+grupo_destino_id+"/mostrargrupo.json",function($cargas_grupo_destino){
            procesarGrupoGrupo($cargas_grupo_origen,$cargas_grupo_destino,index);
            procesarCrearComponentesServidor($origen_array,$destinos,index+1);
                ocultarMensajeNotificador();
            });
        });
    }
//Grupo ---->Grado.
    if($($origen).hasClass('grupo_origen') && $($destino).hasClass('grado_destino')){
        mostrarMensajeNotificador("Copiando componente de un grupo a un grado ")
        grupo_origen_id=$origen.value;
        grado_destino_id=$destino.value;
        $.post(entorno+"cargaacademica/"+grupo_origen_id+"/mostrargrupo.json",function($cargas_grupo_origen){
            $.post(entorno+"cargaacademica/"+grado_destino_id+"/mostrargrupo.json",function($cargas_grado_destino){
            procesarGrupoGrado($cargas_grupo_origen,$cargas_grado_destino,0,0);
            procesarCrearComponentesServidor($origen_array,$destinos,index+1);
            });
        });
    }

}
function procesarGrupoGrado($cargas_grupo_origen,$cargas_grupo_destino,index,index2){
    if(index+1>$cargas_grupo_origen.length-1){
        index=0;
    }
    carga_destino_id=$cargas_grupo_destino[index];
    carga_origen_id=$cargas_grupo_origen[index2];
     $.post(entorno+"dimension/"+carga_origen_id+"/"+carga_destino_id+"/pegarcargacarga",function(data){
               if(index2+1>$cargas_grupo_destino.length-1){
                    ocultarMensajeNotificador();
                    console.info("Terminamos de adicionar");
                    return;
                } 
              procesarGrupoGrado($cargas_grupo_origen,$cargas_grupo_destino,index,index2+1);
       });
  }

function procesarGrupoGrupo($cargas_grupo_origen,$cargas_grupo_destino,index){
    carga_destino_id=$cargas_grupo_destino[index];
    carga_origen_id=$cargas_grupo_origen[index];
     $.post(entorno+"dimension/"+carga_origen_id+"/"+carga_destino_id+"/pegarcargacarga",function(data){
               if(index+1>$cargas_grupo_origen.length-1){
                    ocultarMensajeNotificador();
                    console.info("Terminamos de adicionar");
                    return;
                } 
              procesarGrupoGrupo($cargas_grupo_origen,$cargas_grupo_destino,index+1);
       });
  }

function procesarCargaGrupo(carga_origen_id,$cargas,index){
    if(index%2==0)
        paso='. . .';
    else
        paso='. . . . . .';
    carga_destino_id=$cargas[index];
     $.post(entorno+"dimension/"+carga_origen_id+"/"+carga_destino_id+"/pegarcargacarga",function(data){
                mostrarMensajeNotificador("Creando componentes"+paso);
               if(index+1>$cargas.length-1){
                    ocultarMensajeNotificador();
                    console.info("Terminamos de adicionar");
                    return;
                } 
                procesarCargaGrupo(carga_origen_id,$cargas,index+1);
       });
  }
function procesarVariasCargas($origen,cargas_destino_1,index1){
       if(index1%2==0)
           paso=". . . .";
       else
           paso=". . . . . . .";
       
       
        compo_origen_id=$origen.value;
        carga_origen_id=$origen.getAttribute('data-carga-id');        
        carga_destino_id=cargas_destino_1[index1];
        $.post(entorno+"dimension/"+compo_origen_id+"/"+carga_origen_id+"/"+carga_destino_id+"/crearcomponente",function(data){
                mostrarMensajeNotificador("Creando comoponenetes"+paso); 
                if((index1+1)>cargas_destino_1.length-1){
                        ocultarMensajeNotificador();
                        console.info("Terminamos de adicionar");
                        return;
                 }
                 procesarVariasCargas($origen,cargas_destino_1,index1+1);
          
        });
           
}

function procesarCopiar(){
    origen=$("input:checked");
    comp_origen=$("input:checked.componentes");
    items_origen=$("input:checked.items");
    if(items_origen.length>0 && comp_origen.length>0){
        alert("No se puede seleccionar dos fuentes a copiar");
        return;
    }
     $("span.nodo_origen").each(function(e){
         $(this).removeClass("nodo_origen");
     });
     $("input").each(function(j){
                $id=$(this);
                $id.removeClass("origen");
                $id.removeClass("destino");                
                $id.removeClass('compo_origen');
                $id.removeClass('carga_origen');
                $id.removeClass('grupo_origen');
                $id.removeClass('grado_origen');
                $id.removeClass('compo_destino');
                $id.removeClass('carga_destino');
                $id.removeClass('grupo_destino');
                $id.removeClass('grado_destino');
                
            });
        origen.each(function(i){
           
            $id=$(this);
            $id.addClass('origen');
            $id.parent().children('span').first().addClass("nodo_origen");
            $("#label_copiar_componente").addClass("nodo_origen");
            if($id.hasClass('compo')){
                $id.addClass('compo_origen');
            }
            if($id.hasClass('carga')){
                $id.addClass('carga_origen');
            }
            if($id.hasClass('grupo')){
                $id.addClass('grupo_origen');
            }
            if($id.hasClass('grado')){
                $id.addClass('grado_origen');
            }
            
        });
   
}
function procesarCheckPegar(e){
   input_check=$(e);
   if($("input:checked").length<=0){
       $("#label_pegar_componente").removeClass("nodo_destino");
       $("#label_copiar_componente").removeClass("nodo_origen");
            
   }
       
   if(!input_check.hasClass('origen') && $("input.origen").length>0){
        if(input_check.is(':checked')){
            input_check.addClass('destino');
            $("#label_pegar_componente").addClass("nodo_destino");
            input_check.parent().children('span').first().addClass("nodo_destino");
            if(input_check.hasClass('compo')){
                input_check.addClass('compo_destino');
            }
            if(input_check.hasClass('carga')){
                input_check.addClass('carga_destino');
            }
            if(input_check.hasClass('grupo')){
                input_check.addClass('grupo_destino');
            }
            if(input_check.hasClass('grado')){
                input_check.addClass('grado_destino');
            }
        }
        else{
            input_check.removeClass('destino');
            input_check.removeClass('compo_destino');
            input_check.removeClass('carga_destino');
            input_check.removeClass('grupo_destino');
            input_check.removeClass('grado_destino');
            input_check.removeClass('compo_origen');
            input_check.removeClass('carga_origen');
            input_check.removeClass('grupo_origen');
            input_check.removeClass('grado_origen');
            input_check.parent().children('span').first().removeClass("nodo_destino");
   
        }
   }
 
}
function procesarPegar(){
     crearComponentes();
     return;
     $origen=$("input.compo_origen");     
     $destinos=$("input:checked.compo_destino");
     pegarCompoCompoR($origen[0],$destinos,0);

}
function pegarCompoCompoR($origen,$destinos,index){
    origen_id=$origen.value;
    carga_origen_id=$origen.getAttribute('data-carga-id');
    destino_id=$destinos[index].value;
    carga_destino_id=$destinos[index].getAttribute('data-carga-id');
    console.info(origen_id);
    console.info(destino_id);
  
    $.post(entorno+"dimension/"+origen_id+"/"+destino_id+"/"+carga_origen_id+"/"+carga_destino_id+"/pegarcomponentecomponente",function(data){     
           
           mostrarMensajeNotificador("Copiando componentes("+index+") ");
           
           if(index+1>$destinos.length-1){
               console.info("Terminamos");
               ocultarMensajeNotificador();
               return;
           }
           pegarCompoCompoR($origen,$destinos,index+1);
           
    }); 
    
}
function procesarEliminar(){
    if(confirm("Estas Seguro De eliminar.???")){
        $inputs=$("input:checked");
        subProcesarEliminar($inputs,0);
    }
}
function subProcesarEliminar($inputs,index){
    input=$inputs[index];
    if($(input).hasClass('items')){
        $.post(entorno+"dimension/"+input.value+"/borraritem",function(data){     
           if(index+1>$inputs.length-1){
               console.info("Terminamos");
               ocultarMensajeNotificador();
               return;
           }
           subProcesarEliminar($inputs,index+1);
    
        }); 
    }
    if($(input).hasClass('compo')){
        input=$inputs[index];
        $.post(entorno+"dimension/"+input.value+"/borrarcomponente",function(data){     
            if(index+1>$inputs.length-1){
               console.info("Terminamos");
               ocultarMensajeNotificador();
               return;
            }
            subProcesarEliminar($inputs,index+1);
        }); 
   }
    if($(input).hasClass('carga')){
        $.post(entorno+"dimension/"+input.value+"/-1/showca.json",function($compos){     
             borrarCarga($compos,0);
             if(index+1>$inputs.length-1){
               console.info("Terminamos");
               ocultarMensajeNotificador();
               return;
            }
            subProcesarEliminar($inputs,index+1);
        });
        
    }
    if($(input).hasClass('grupo')){
        grupo_id=input.value;
        $.post(entorno+"cargaacademica/"+grupo_id+"/mostrargrupo.json",function($cargas){ 
            borrarGrupo($cargas,0);
            if(index+1>$inputs.length-1){
               console.info("Terminamos");
               ocultarMensajeNotificador();
               return;
            }
            subProcesarEliminar($inputs,index+1);
            
        });    
    }
    if($(input).hasClass('grado')){
        grado_id=input.value;
        $.post(entorno+"cargaacademica/"+grado_id+"/mostrarcargagrado.json",function($cargas){ 
            borrarGrupo($cargas,0);
            if(index+1>$inputs.length-1){
               console.info("Terminamos");
               ocultarMensajeNotificador();
               return;
            }
            subProcesarEliminar($inputs,index+1);
            
        });    
        
    }

}
function borrarGrupo($cargas,index){
    carga_id=$cargas[index];
    $.post(entorno+"dimension/"+carga_id+"/-1/showca.json",function($compos){     
             borrarCarga($compos,0);
            if(index+1>$cargas.length-1){
               console.info("Terminamos");
               ocultarMensajeNotificador();
               return;
            }
            borrarGrupo($cargas,index+1)
    });
    
}
function borrarCarga($compos,index){
    if($compos.length>0){
        compo=$compos[index];
        $.post(entorno+"dimension/"+compo+"/borrarcomponente",function(data){     
            if(index+1>$compos.length-1){
               console.info("Terminamos");
               ocultarMensajeNotificador();
               return;
            }
             borrarCarga($compos,index+1);
        });
    }

}
function procesarAdicionComponentesObligarios(){
    var ca_checked=new Array();
    var ca;
    
    //Cargas Academicas Donde deseamos adicionar los CO
    checks=$("input:checked.carga");
     if(checks.length>0){
        checks.each(function(i){
            ca_checked.push(parseInt(this.value));
        });
         ca= $.toJSON(ca_checked);  
     }
    data={
        'ca':ca
    };
    mostrarMensajeNotificador("Cargando");
    $.post(entorno+"dimension/crearcomponentesobligatorios",data,function(data){     
            //$("#capa_ram_profesores_componentes"+id_componente).html(data);
            //$("#capa_ram_profesores_componentes"+id_componente).show();
           ocultarMensajeNotificador();
    }); 

}
// new editar
function procesarNewEditar(){
    var componentes_checked=new Array();
    var items_checked=new Array();
    //Cargas Academicas Donde deseamos adicionar los CO
    checks=$("input:checked.compo");
     if(checks.length>0){
        checks.each(function(i){
            componentes_checked.push(parseInt(this.value));
        });
        var componentes = $.toJSON(componentes_checked);  
     }
     //Profeosres
     checks=$("input:checked.items");
     if(checks.length>0){
        checks.each(function(i){
            items_checked.push(parseInt(this.value));
            
        });
        var items = $.toJSON(items_checked);
        }
    data={
        'componentes': componentes,
        'items': items
        };
        mostrarMensajeNotificador("Cargando");
    $.post(entorno+"dimension/neweditar",data,function(data){     
            $("#sub-container-right").html(data);
            //$("#capa_ram_profesores_componentes"+id_componente).show();
           ocultarMensajeNotificador();
    }); 
    
}
//Procesar edicion
function procesarEditarComponentesItems(){
        var componentes_checked=new Array();
    var items_checked=new Array();
    nombre_item=$("#nombre_item_1").val();
    ponderado_item=$("#ponderado_item_1").val();
    nombre_componente=$("#nombre_componente").val();
    ponderado_componente=$("#ponderado_componente").val();
    //Cargas Academicas Donde deseamos adicionar los CO
    checks=$("input:checked.compo");
     if(checks.length>0){
        checks.each(function(i){
            componentes_checked.push(parseInt(this.value));
        });
        var componentes = $.toJSON(componentes_checked);  
     }
     //Profeosres
     checks=$("input:checked.items");
     if(checks.length>0){
        checks.each(function(i){
            items_checked.push(parseInt(this.value));
            
        });
        var items = $.toJSON(items_checked);
        }
    data={
        'componentes': componentes,
        'items': items,
        'nombre_item': nombre_item,
        'ponderado_item': ponderado_item,
        'nombre_componente': nombre_componente,
        'ponderado_componente': ponderado_componente
        };
        mostrarMensajeNotificador("Cargando");
$.post(entorno+"dimension/editar",data,function(data){     
            //$("#capa_ram_profesores_componentes"+id_componente).html(data);
            //$("#capa_ram_profesores_componentes"+id_componente).show();
           ocultarMensajeNotificador();
    }); 

}
function setNombreClaseCopiaOrigen(nombre_clase,clase,clase_universal){
          $('input.'+clase).each(function(i){               
            $(this).removeClass(nombre_clase);
            $(this).removeClass(clase_universal);            
           });
         $('input:checked.'+clase).each(function(i){                
                //$("#letrero_copiar"+this.value).html("Guardada. Lista para Pegar");
                $(this).addClass(nombre_clase);
                $(this).addClass(clase_universal);     
                $(this).addClass('pegar_copiar');
            });  
  
}
function borrarMensajeLetrero(letrero){
    $("span."+letrero).each(function(i){
        $(this).html(" ");
    });
}
function procesarCheckCargaAcademica(id_carga,profesor_id){    
            allcheckProfesores("check_carga_academica"+id_carga,"componetes_ca"+id_carga);
            checks_c=$("input:checked.carga_profesor"+profesor_id).length    ;
            todos_c=$("input.carga_profesor"+profesor_id).length;
            if(checks_c==todos_c){
               $("#profesor_gcomp"+profesor_id).attr('checked',true);        
            }
           else{
            $("#profesor_gcomp"+profesor_id).attr('checked',false);        
           }
   
}
function procesarCheckComponente(id_ca,comp_id,profesor_id){
    checks=$("input:checked.componetes_ca"+id_ca).length    ;
    todos=$("input.componetes_ca"+id_ca).length;
    console.info(checks+"--"+todos);
    if(checks==todos){
        $("#check_carga_academica"+id_ca).attr('checked',true);
        checks_c=$("input:checked.carga_profesor"+profesor_id).length    ;
        todos_c=$("input.carga_profesor"+profesor_id).length;
        if(checks_c==todos_c){
            $("#profesor_gcomp"+profesor_id).attr('checked',true);        
        }
        else{
            $("#profesor_gcomp"+profesor_id).attr('checked',false);        
        }
    }
    else{
        $("#profesor_gcomp"+profesor_id).attr('checked',false);
        $("#check_carga_academica"+id_ca).attr('checked',false);
    
    }
}
function adicionaComponenteProfesor(){
    
}
function allcheckProfesoresCopiar(oringen,clase,me){
   //Miramos si hay que seleccionar padre
   nrl_copiar=$("input:checked.copiar").length;
       
   if(oringen!='todos_check'){
   name_me=me.getAttribute('data-clase-me');   
   hermanos_chekeados=$("input:checked."+name_me).length;
   numero_hermanos=$("input."+name_me).length; 
   
    
   if(numero_hermanos==hermanos_chekeados){
       padre=$("#"+me.getAttribute('data-clase-padre'));
       padre.attr('checked',true);
       console.info("nl"+nrl_copiar);
       if(nrl_copiar>0){
           if(!padre.hasClass('copiar')){
               if(padre.hasClass('profesor')){
                   padre.addClass('pegar_profesor');
                   padre.addClass('pegar_copiar');
                   
               }
               if(padre.hasClass('fila_ca')){
                   padre.addClass('pegar_ca');
                   padre.addClass('pegar_copiar');
                   
               }
               //$("#observacion"+padre.val()).html("Pegar.");
           }
       }
   }
   if(hermanos_chekeados<numero_hermanos || hermanos_chekeados==0){            
            padre=$("#"+me.getAttribute('data-clase-padre'));
            padre.attr('checked',false);
            if(nrl_copiar>0){
                if(!padre.hasClass('copiar')){
                 if(padre.hasClass('profesor')){
                   padre.removeClass('pegar_profesor');
                   padre.removeClass('pegar_copiar');
                   
                }
               if(padre.hasClass('fila_ca')){
                   padre.removeClass('pegar_ca');
                   padre.removeClass('pegar_copiar');
                   
               }
               $("#observacion"+padre.val()).html(" ");
           }
       }
    }
       
   }
   input_check_all=$("#"+oringen);
   clase_seleccionar=$("input:checkbox."+clase); 
   if(input_check_all.is(':checked')){
       //nrl_copiar=$("input:checked.copiar").length;
       console.info("nl"+nrl_copiar);
       //if(nrl_copiar>0){
           if(!input_check_all.hasClass('copiar')){
               if(input_check_all.hasClass('profesor')){
                   input_check_all.addClass('pegar_profesor');
                   input_check_all.addClass('pegar_copiar');
                   
               }
               if(input_check_all.hasClass('fila_ca')){
                   input_check_all.addClass('pegar_ca');
                   input_check_all.addClass('pegar_copiar');
                   
               }
               //$("#observacion"+input_check_all.val()).html("Pegar.");
           }
       //}
    clase_seleccionar.each(function(i){
       me_i=$(this);
       fuente=this.getAttribute('data-fuente');
       destino=this.getAttribute('data-clase-destino');
       me_i.attr("checked", true);
       //nrl_copiar=$("input:checked.copiar").length;
       //console.info("nl"+nrl_copiar);
       //if(nrl_copiar>0){
           if(!me_i.hasClass('copiar')){
               if(me_i.hasClass('profesor')){
                   me_i.addClass('pegar_profesor');
                   me_i.addClass('pegar_copiar');
               
               }
               if(me_i.hasClass('profesor_ca')){
                   me_i.addClass('pegar_ca');
                   me_i.addClass('pegar_copiar');
               
               }
               //$("#observacion"+me_i.val()).html("Pegar.");
           }
       //}
       allcheckProfesoresCopiar(fuente,destino,me);
       
    });
        
   }
   else{
       //nrl_copiar=$("input:checked.copiar").length;
       console.info("nl"+nrl_copiar);
       if(nrl_copiar>0){
           if(!input_check_all.hasClass('copiar')){
               if(input_check_all.hasClass('profesor')){
                   input_check_all.removeClass('pegar_profesor');
                   input_check_all.removeClass('pegar_copiar');
                   
               }
               if(input_check_all.hasClass('fila_ca')){
                   input_check_all.removeClass('pegar_ca');
                   input_check_all.removeClass('pegar_copiar');
                   
               }
               $("#observacion"+input_check_all.val()).html(" ");
           }
       }   
       clase_seleccionar.each(function(i){
            console.info("nl"+nrl_copiar);
            me_i=$(this);
            if(nrl_copiar>0){
                if(!me_i.hasClass('copiar')){
                    if(me_i.hasClass('profesor')){
                        me_i.removeClass('pegar_profesor');
                        me_i.removeClass('pegar_copiar');
                   
                    }
                    if(me_i.hasClass('profesor_ca')){
                        me_i.removeClass('pegar_ca');
                        me_i.removeClass('pegar_copiar');
                   
                    }
                    $("#observacion"+me_i.val()).html("Pegar.");
                }
            }
            $(this).attr("checked", false);
            fuente=this.getAttribute('data-fuente');        
            destino=this.getAttribute('data-clase-destino');
            allcheckProfesoresCopiar(fuente,destino,me);
      
        
      });
   }
 
}
function allcheckProfesores(oringen,clase){    
    input_check_all=$("#"+oringen);
   if(input_check_all.is(':checked')){
    $("input:checkbox."+clase).each(function(i){ 
        $(this).attr("checked", true);
      });
   }
   else{
       $("input:checkbox."+clase).each(function(i){ 
        $(this).attr("checked", false);
        
      });
   }
 
}
function procesarMouseAndetroComponente(id_componente,nivel){
   label_seleccionarHermanos=$("#label_seleccionarHermanos"+id_componente);
   label_seleccionarHermanos.show();
    $("input:checkbox."+'hermanos_'+nivel).each(function(i){ 
        if($("#seleccionarHermanos"+id_componente).is(':checked'))
            $(this).attr("checked", true);
      });
    
    $("div."+'capa_hermano'+nivel).each(function(i){ 
        $(this).css('color','orange');
        $(this).css('font-weight','900');        
        $(this).css('font-size','14px');
      });
    
    
}
function procesarMouseAfueraComponente(id_componente,nivel,id_carga){
   label_seleccionarHermanos=$("#label_seleccionarHermanos"+id_componente);
   label_seleccionarHermanos.hide();
    $("input:checkbox."+'hermanos_'+nivel).each(function(i){
           
      });
    $("div."+'capa_hermano'+nivel).each(function(i){ 
        $(this).css('color','black');
        $(this).css('font-weight','100');        
        $(this).css('font-size','10px');
      });
   
    
}

function procesarcheckCambioHermanos(comp,loop){
    allcheckProfesores('seleccionarHermanos'+comp,'hermanos_'+loop);
    allcheckProfesores('seleccionarHermanos'+comp,'hermano_lado'+loop);
    
}
function procesarSalidaListaAlumnos(id){
    anchor=$("#anchor"+id);
    anchor.hide();
    input_nota=$("#input_nota"+id);
    input_nota.show();


}
function procesarEntradaListaAlumnos(id){
    anchor=$("#anchor"+id);
    input_nota=$("#input_nota"+id);
    input_nota.hide();
    anchor.show();
}
function procesarEliminarColumna(ca_id,nro_columna){
    checkbox=$("#checkBox"+nro_columna);
    $("input.columna"+nro_columna).each(function(i){ 
                $(this).css('background-color','red');
     });
            
    if(confirm("Estas Seguros de eliminar las Notas de Esta Columna.")){
        var notas_eliminar=new Array();
        if(checkbox.is(':checked')){    
            $("input.columna"+nro_columna).each(function(i){ 
     //           $(this).css('background-color','red');
                notas_eliminar.push(parseInt(this.getAttribute('data-id')));
            });
            var notas_json = $.toJSON(notas_eliminar);
            data={
                id_notas:notas_json
            };
            mostrarMensajeNotificador("Cargando");
            $.post(entorno+"dimension/eliminarcolumnanota",data,function(data){     
                 verDetallesCargaAcademicaProfesor(ca_id);
                 ocultarMensajeNotificador();
            }); 

            
        }
        else{
            
        
       }
    }
    else{
        checkbox.attr('checked',false);
         $("input.columna"+nro_columna).each(function(i){ 
                $(this).css('background-color','white');
     });
            
   
    }
    
    

}
function procesarEliminarCelda(nota_id,ca_id){
    if(confirm("Estas seguro De Eliminira la Nota")){
        mostrarMensajeNotificador("Cargando");
        $.post(entorno+"dimension/"+nota_id+"/eliminarunanota",function(data){     
                 verDetallesCargaAcademicaProfesor(ca_id);
                 ocultarMensajeNotificador();
            }); 

    }
    else{
        
    }
}
function procesarAdiciones(tipo){
    padre=$("#padre").val();      
    data={
        'padre': padre
    };
    if(tipo==7){
      nombre=$("#name_componente").val();
      porcentaje=$("#porcentaje").val();
      data={
          'padre': padre,
          'nombre': nombre,
          'porcentaje': porcentaje
      };
    }
    mostrarMensajeNotificador("Cargando. ");
    $.post(entorno+"dimension/"+tipo+"/adicionarcomponente",data,function(data){
       $("#container-new-componentes-padre").html(data);
       $("#container-new-componentes-padre").html(data)
       ocultarMensajeNotificador();
    }); 

 }
function desativarDatos(){
        tipo=$("#tipo").val();
    if(tipo==1){//Componentes
        $("#div_nombre_dim").show();
        $("#div_ponderado").show();
    }
    if(tipo==2){//Items
       $("#div_nombre_dim").show();
        $("#div_ponderado").show();
        
    }
    if(tipo==3){//Compo Obligatorios
        $("#div_nombre_dim").hide();
        $("#div_ponderado").hide();
    }

}
function mostrarNewComponente(){
    mostrarMensajeNotificador("Cargando. ");
    $.post(entorno+"dimension/newcomponente",function(data){
       $("#container-new-componentes-padre").html(data);
       ocultarMensajeNotificador();
    }); 

}
function newNroComponentes(){
    mostrarMensajeNotificador("Cargando. ");
    nro=$("#nro_componentes").val();
    $.post(entorno+"dimension/"+nro+"/newnrocomponente",function(data){
       $("#container-new-componentes-padre").html(data);
       ocultarMensajeNotificador();
    });    
}
function porcesarCheckFallas(e,id,max){
    if($(e).is(':checked')){
        $("td.fila_"+id).each(function(){
                $(this).css('background-color','#D9EDF7');
        });
        mostrarMensajeNotificador("Cargando. ");
        padre=max;
        //hijo
        nombre_hijo=$("#falla_"+id).val();
        porcentaje=$("#p_"+id).val();
        //padre
        nombre_padre=$("#nombre_"+padre).val();
        porcentaje_padre=$("#p_"+padre).val();
        data={
            'nombre_hijo': nombre_hijo,
            'porcentaje': porcentaje,
            'nombre_padre': nombre_padre,
            'porcentaje_padre': porcentaje_padre
        };
    $.post(entorno+"dimension/"+id+"/"+padre+"/"+max+"/actualizarfalla",data,function(data){
      ocultarMensajeNotificador();
    });

    }
    else{
       $("td.fila_"+id).each(function(){
                $(this).css('background-color','#FBFBFB');
        });
    }
    
}
function procesarPadreGestorComp(id,max){
    mostrarMensajeNotificador("Cargando. ");
    padre=$("#padre"+id).val();
    //hijo
    nombre_hijo=$("#nombre_"+id).val();
    porcentaje=$("#p_"+id).val();
    //padre
    nombre_padre=$("#nombre_"+padre).val();
    porcentaje_padre=$("#p_"+padre).val();
    data={
        'nombre_hijo': nombre_hijo,
        'porcentaje': porcentaje,
        'nombre_padre': nombre_padre,
        'porcentaje_padre': porcentaje_padre
    };
    $.post(entorno+"dimension/"+id+"/"+padre+"/"+max+"/actualizarpadre",data,function(data){
      ocultarMensajeNotificador();
    });
}
function editComponenteGC(id,max){
    $edit=$("#btn_edit_nombre_"+id);
    if($("#padre"+id).val()!=''){
        $("#nombre_"+id).val($("#input_nombre"+id).val());
        procesarPadreGestorComp(id,max);
        if($edit.html()=="actualizar"){
            $edit.html("editar");
            $("#span_nombre_c"+id).html("<label>"+$("#input_nombre"+id).val()+"</label>")
        }
        else{
            $("#span_nombre_c"+id).html("<input id='input_nombre"+id+"' type='text' placeholder='Ej: Comp Cognitivo'>");
            $edit.html("actualizar");
        }

    }
    else{
        alert("Por favor ingrese un padre");
    }
    
    
}
function updateComponenteGC(id,max){
    if($("#padre"+id).val()!=''){
        $("#nombre_"+id).val($("#input_nombre"+id).val());
        procesarPadreGestorComp(id,max);
    }
    else{
        alert("Por favor ingrese un padre");
    }
}
         
function editComponentePorcentajeGC(id,max){
    $edit=$("#btn_edit_"+id);
    if($("#padre"+id).val()!=''){
        $("#p_"+id).val($("#input_p"+id).val());
        procesarPadreGestorComp(id,max);
        if($edit.html()=="actualizar"){
            $edit.html("editar");
            $("#span_p_c"+id).html("<label>"+$("#input_p"+id).val()+"</label>")
        }
        else{
            $("#span_p_c"+id).html("<input style='width:30px;' id='input_p"+id+"' type='text' placeholder='Ej: 70'>");
            $edit.html("actualizar");
        }

    }
    else{
        alert("Por favor ingrese un padre");
    }
    
}
function procesarSalidaMouseGC(){
    $(".btn_editar_gc").each(function(){
        $(this).hide();
    });
   
    
}
function procesarEntradaMouseGC(){
    $(".btn_editar_gc").each(function(){
        $(this).show();
    });
   
}
function procesarEliminarCGC(padre,url){
    if(confirm("Esta seguro de eliminar")){
    mostrarMensajeNotificador("Espere mientras se elemina...");
    $.post(entorno+"dimension/"+padre+"/deletepadre",function(data){
      ocultarMensajeNotificador();
      window.location=url;
    });
    }
}
function procesarPegarCG(){
    ESTADO_CARGA=1;
    datas=new Array();        
    $destinos=$("input:checked.destino");
    $destinos.each(function(i){
        if($(this).hasClass('operatico-unico')){
            console.info("todos los grados");
            $.post(entorno+"cargaacademica/todascargas",function(data){  
                crearComponenteCarga(data,0);
            });
        }
        if($(this).hasClass('gradooperativo')){
            console.info("Grados");            
            $.post(entorno+"cargaacademica/"+$(this).val()+"/mostrarcargagrado.json",function(data){  
                crearComponenteCarga(data,0);
            });
        }
        if($(this).hasClass('grupo_operativo')){
            console.info("Vamos con el grupo");
            $.post(entorno+"cargaacademica/"+$(this).val()+"/mostrargrupo.json",function(data){  
                crearComponenteCarga(data,0);
            });
        }
        if($(this).hasClass('carga')){
            if(ESTADO_CARGA==1){
                console.info("carga");
                $("input:checked.carga").each(function (i){
                    datas[i]=$(this).val();
                    });
                crearComponenteCarga(datas,0);
                ESTADO_CARGA=0;
            }
        }
    });
}
function crearComponenteCarga($cas,index){
    $padre=$('input:radio[name=label]:checked');
    $.post(entorno+"dimension/"+$padre.val()+"/"+$cas[index]+"/creardimension",function(data){    
        console.info("Creamos niestra carga"+index);
        notificador+="| ";
        mostrarMensajeNotificador(notificador);
        if(index+1>($cas.length-1)){
            ocultarMensajeNotificador();
            console.info("terminamos");
            notificador="|";
            return;
        }
        crearComponenteCarga($cas,index+1);
    });
}
function procesarEdicionComonentesGC(padre_id){
    $btn=$("#btn_edit_actualizar_gc"+padre_id);
    console.info($btn.html());
    if($btn.html()=='<i class="icon icon-edit icon-2x"></i> editar'){
        mostrarMensajeNotificador("Editar ");
        $.post(entorno+"dimension/"+padre_id+"/editarcomponente",function(data){ 
            $("#container_table_padre"+padre_id).html(data);
            ocultarMensajeNotificador();
        });
        $btn.html('<i class="icon icon-refresh icon-2x"></i> actualizar');
    }
    else{
        $.post(entorno+"dimension/"+padre_id+"/actualizarcompleta",function(data){ 
            
        });
        
        procesarShowComonentesGC(padre_id);
        $btn.html('<i class="icon icon-edit icon-2x"></i> editar');
    }
}
function procesarActualiacionComponentes(id){
    mostrarMensajeNotificador("Actualizando ");
    nombre=$("#n"+id).val();
    porcentaje=$("#p"+id).val();
    data={
        'nombre':nombre,
        'porcentaje':porcentaje
    };
    $.post(entorno+"dimension/"+id+"/actualizarcomponente",data,function(){         
        ocultarMensajeNotificador();
    });
}
function procesarShowComonentesGC(padre_id){
    mostrarMensajeNotificador("Editar ");
    $.post(entorno+"dimension/"+padre_id+"/showcomponente",function(data){ 
        $("#container_table_padre"+padre_id).html(data);
        ocultarMensajeNotificador();
    });
}
function procesarEliminarGC(id,url){    
    if(confirm('esta seguro de eliminar')){
    $.post(entorno+"dimension/"+id+"/deletecomponente",function(data){ 
        ocultarMensajeNotificador();
        window.location=url;

    });
    }
}
