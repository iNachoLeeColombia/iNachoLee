$(document).ready(function() {
    procesarul("");
});
function procesarul(clase){
    $('.tree > ul').attr('role', 'tree').find('ul').attr('role', 'group');
	$('.tree').find('li:has(ul)').addClass('parent_li').attr('role', 'treeitem').find(' > span'+clase).attr('title', 'Collapse this branch').on('click', function (e) {
        var children = $(this).parent('li.parent_li').find(' > ul > li');
        var id=$(this).attr('id');
        console.info(id);
        if (children.is(':visible')) {
    		children.hide('fast');
    		$(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
                if(id=='nodo_grado_comp'){
                    $("#operativo_grado").show();
                    $("#check_operativo_grado").attr('checked', false);
                    $("#todos_grados").hide();                    
                }            
                data_id=this.getAttribute('data-id');
                if(id=='nodo_grado_comp_'+data_id){
                    $("#operativo_grado"+data_id).show();
                    $("#check_operativo_grado"+data_id).attr('checked', false);
                    
                    $("#todos_grupo_grado"+data_id).hide();
                    
                }
                if(id=='nodo_grupo_'+data_id){
                    $("#operativo_grupo"+data_id).show();
                    $("#check_operativo_grupo"+data_id).attr('checked', false);
                    $("#small_grupo_gc"+data_id).hide()
                }
                
                
        }
        else {
                 if(id=='nodo_grado_boletin'){
                    mostrarMensajeNotificador("Cargando grados ");
                    $.post(entorno+"grado/1/gradostree",function(data){
                            $("#ul_grados").html(data);
                            procesarul(".items_remoto");
                            $(".items_remoto").each(function (e){
                                $(this).removeClass("items_remoto");
                            });
                            ocultarMensajeNotificador();
                            
                            
                    });
                 }
                 if(id=='nodo_grado_comp'){
                    $("#check_operativo_grado").attr('checked', false);                    
                    mostrarMensajeNotificador("Cargando grados ");
                    $.post(entorno+"grado/2/gradostree",function(data){
                            $("#ul_grados").html(data);
                            procesarul(".items_remoto");
                            $(".items_remoto").each(function (e){
                                $(this).removeClass("items_remoto");
                            });
                            $("#operativo_grado").hide();
                            $("#todos_grados").show();
                            ocultarMensajeNotificador();
                            
                            
                    });
                 }
                 var data_id=this.getAttribute('data-id');
                 if(id=='nodo_grado_boletin_'+data_id){
                     var tipo=this.getAttribute('data-tipo');
                     mostrarMensajeNotificador("Cargando grupos "); 
                    $.post(entorno+"grupo/"+data_id+"/"+tipo+"/grupostree",function(data){
                            $("#ul_grupo_"+data_id).html(data);
                            procesarul(".items_remoto");
                            $(".items_remoto").each(function (e){
                                $(this).removeClass("items_remoto");
                            });
                         });
                         ocultarMensajeNotificador();
                 }
                 if(id=='nodo_grado_comp_'+data_id){
                    var tipo=this.getAttribute('data-tipo');
                    $("#check_operativo_grado"+data_id).attr('checked', false);
                    mostrarMensajeNotificador("Cargando grupos "); 
                    $.post(entorno+"grupo/"+data_id+"/"+tipo+"/grupostree",function(data){
                            $("#ul_grupo_"+data_id).html(data);
                            procesarul(".items_remoto");
                            $(".items_remoto").each(function (e){
                                $(this).removeClass("items_remoto");
                            });
                            $("#operativo_grado"+data_id).hide();
                            $("#todos_grupo_grado"+data_id).show();
                
                
                         });
                         ocultarMensajeNotificador();
                 }

                    if(id=='nodo_grupo_'+data_id){
                     mostrarMensajeNotificador("Cargando alumnos ");
                    if($(".container-principal-informe-bc3").length>0 || $(".container-principal-informe-promover").length>0){
                             $.post(entorno+"alumno/"+data_id+"/alumnostree",function(data){
                                    $("#ul_ca_"+data_id).html(data);
                                    procesarul("");
                            });
                            ocultarMensajeNotificador();
                    }
                    else{
                       mostrarMensajeNotificador("Cargando asignaturas "); 
                       $("#check_operativo_grupo"+data_id).attr('checked', false);
                       $.post(entorno+"cargaacademica/"+data_id+"/mostrargrupo",function(data){
                            $("#ul_ca_"+data_id).html(data);
                            procesarul(".items_remoto");
                            $(".items_remoto").each(function (e){
                                $(this).removeClass("items_remoto");
                            });
                            ocultarMensajeNotificador();
                            $("#operativo_grupo"+data_id).hide();
                            $("#small_grupo_gc"+data_id).show();
                        });
                   } 
                    
                 }
                 if(id=='compo_'+data_id){
                    mostrarMensajeNotificador("Cargando componentes "); 
                    $.post(entorno+"dimension/"+data_id+"/-1/showca",function(data){
                        
                            $("#ul_compo_"+data_id).html(data);
                            procesarul(".items_remoto");
                            $(".items_remoto").each(function (e){
                                $(this).removeClass("items_remoto");
                            });
                            /*$.post(entorno+"cargaacademica/"+data_id+"/verdetallescargaunprofesor",function(data){
                                $("#sub-container-right").html(data);
                                $('.tarea').each(function(){
                                $(this).rotate({angle : 270});
                                });
                                
                                ocultarMensajeNotificador();
                            });*/
                            
                    });
                 }
                 if(id=='comp_asg_'+data_id){
                    mostrarMensajeNotificador("Cargando items "); 
                    carga_id=this.getAttribute('data-carga-id'); 
                    $.post(entorno+"dimension/"+carga_id+"/"+data_id+"/showcaitems",function(data){
                            $("#item_"+data_id).html(data);
                            procesarul(".items_remoto");
                            $(".items_remoto").each(function (e){
                                $(this).removeClass("items_remoto");
                            });
                            /*$.post(entorno+"cargaacademica/"+carga_id+"/"+data_id+"/mostrardetallescomponentes",function(data){
                                $("#sub-container-right").html(data);
                                $('.tarea').each(function(){
                                $(this).rotate({angle : 270});
                                });

                                ocultarMensajeNotificador();
                            });*/
                    });
                 }
                 //Red Saeber
                 if(id=='nodo_grupo_redsaber'+data_id){
                     mostrarMensajeNotificador("Cargando asignaturas "); 
                       $.post(entorno+"cargaacademica/"+data_id+"/mostrargrupotipo",function(data){
                            $("#ul_ca_"+data_id).html(data);
                            procesarul(".items_remoto");
                            $(".items_remoto").each(function (e){
                                $(this).removeClass("items_remoto");
                            });
                            ocultarMensajeNotificador();
                    });
                 }
                 if(id=='comp_redsaber_'+data_id){
                    mostrarMensajeNotificador("Cargando items "); 
                    carga_id=this.getAttribute('data-carga-id'); 
                    $.post(entorno+"dimension/"+carga_id+"/"+data_id+"/showcaitemstipo",function(data){
                            $("#item_"+data_id).html(data);
                            procesarul(".items_remoto");
                            $(".items_remoto").each(function (e){
                                $(this).removeClass("items_remoto");
                            });
                            $.post(entorno+"cargaacademica/"+carga_id+"/"+data_id+"/mostrardetallescomponentes",function(data){
                                $("#sub-container-right").html(data);
                                $('.tarea').each(function(){
                                $(this).rotate({angle : 270});
                                });

                                ocultarMensajeNotificador();
                            });
                    });
                 }
                 if(id=='compo_redsaber'+data_id){
                    mostrarMensajeNotificador("Cargando componentes "); 
                    $.post(entorno+"dimension/"+data_id+"/-1/showcatipo",function(data){
                            $("#ul_compo_"+data_id).html(data);
                            procesarul(".items_remoto");
                            $(".items_remoto").each(function (e){
                                $(this).removeClass("items_remoto");
                            });
                            ocultarMensajeNotificador();
                            
                    });
                 }
                 if(id=='nodo_pruebaicfes_'+data_id){
                    mostrarMensajeNotificador("Cargando componentes "); 
                    $.post(entorno+"componente/"+data_id+"/showcompetenciatree",function(data){
                            $("#padre_"+data_id).html(data);
                            procesarul(".items_remoto");
                            $(".items_remoto").each(function (e){
                                $(this).removeClass("items_remoto");
                            });
                            ocultarMensajeNotificador()
                            
                    });
                 }
                 if(id=='nodo_asg_temas_evaluar_'+data_id){
                    mostrarMensajeNotificador("Cargando componentes "); 
                    $.post(entorno+"planarea/"+data_id+"/showtemastree",function(data){
                            $("#padre_"+data_id).html(data);
                            procesarul(".items_remoto");
                            $(".items_remoto").each(function (e){
                                $(this).removeClass("items_remoto");
                            });
                            ocultarMensajeNotificador();
                            
                    });
                 }
                 if(id=='nodo_asg_subtemas_evaluar_'+data_id){
                    mostrarMensajeNotificador("Cargando componentes "); 
                    $.post(entorno+"planarea/"+data_id+"/showsubtemastree",function(data){
                            $("#padre_"+data_id).html(data);
                            procesarul(".items_remoto");
                            $(".items_remoto").each(function (e){
                                $(this).removeClass("items_remoto");
                            });
                            ocultarMensajeNotificador();
                            
                    });
                 }
                 //nodo_tema
                 if(id=='nodo_tema_'+data_id){
                    mostrarMensajeNotificador("Cargando temas "); 
                    $.post(entorno+"planarea/"+data_id+"/showcontenido",function(data){
                            $("#container-contenido").html(data);
                            procesarul(".items_remoto");
                            $(".items_remoto").each(function (e){
                                $(this).removeClass("items_remoto");
                            });
                            ocultarMensajeNotificador();
                            
                    });
                 }

                    children.show('fast');
    		$(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
               
        }
        e.stopPropagation();
    });
}