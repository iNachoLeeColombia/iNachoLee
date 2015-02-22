
id_alumno_global=0;
tipo_global=0;
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
function showAlumnoinfoAcademicaDefectoAno(id){   
    mostrarMensajeNotificador("Cargando. ");
    $.get(entorno+"alumno/"+id+"/show",function(data){
            $("#tabs4-0").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            ocultarMensajeNotificador();
        });        
}

function editAlumnoperfilinfoAcademicaDefectoAno(id){
    mostrarMensajeNotificador("Cargando. ");
    $.get(entorno+"alumno/"+id+"/editperfil",function(data){
            $("#container-minostas-perfil").html(data);            
            ocultarMensajeNotificador();
            
        });        
}

function newAcudienteinfoAcademicaDefectoAno(){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Interfaz de Nuevo Alumno. Espere....");
    alerta_principal.show()
    $.post(entorno+"alumno/0/newcustom",function(data){            
            $("#page-wrapper").html(data);   
            alerta_principal.html("Listo"); alerta_principal.hide(5000);           
            
            
        });        
}         
         
function newAlumnoSinfoAcademicaDefectoAno(){
    mostrarMensajeNotificador("Cargando. ");
    $.post(entorno+"alumno/new",function(data){            
            $("#sub-container").html(data);   
            ocultarMensajeNotificador();
        });        
}         
         

         
function createPadresinfoAcademicaDefectoAno1(tipo){
 //*****************************************
   //Formulario Nuevo Periodo Academico********

        $("#3").submit(function(){             
              $.ajax({
                type:"POST",
                url:entorno+'alumno/'+tipo+'/createcustom',
                dataType:"html",
                data:$(this).serialize(),
                beforeSend:function(){                        
                    mostrarMensajeNotificador("Cargando. ");
                },
                success:function(response){    
                    $.post(entorno+"alumno/new",function(data){
                       capa_ram_new_alumno=$("#capa_ram_new_alumno");
                       capa_ram_new_alumno.html(data)
                       capa_ram_new_alumno.show();
                       $("#button_createPadres").hide();
                       ocultarMensajeNotificador();
                        });  
                    
                    
                }

                })
          return false;
        }); 
  
      //**********************************************                       
 

}
function createAcudienteinfoAcademicaDefectoAno11(tipo){
   //*****************************************
   //Formulario Nuevo Periodo Academico********
 
         
                    $.post(entorno+"alumno/1/newcustom",function(data){
                         capa_ram_new_padre=$("#capa_ram_new_padre");
                         $("#button_createAcudiente").hide();
                         capa_ram_new_padre.html(data);
                         capa_ram_new_padre.show();
                         alerta_principal=$("#alerta_principal");
                         alerta_principal.html("Listo.");
                         alerta_principal.show();           
                         padre_nombre=$("#padre_nombre");
                         padre_nombre.focus();
                       
                    });    
                   
               
      //**********************************************                       
 
       
}
function deleteAlumnoinfoAcademicaDefectoAno(e){
    $.post(entorno+"/dimension/"+e+"/delete",function(data){
            $("#tabs1-1").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            
        });        
}
function guardarAlumnoGestorAdministrativo(id_alumno,id_matricula_alumno){
    id_alumno_global=id_alumno;
    estado_pago=$("#pago_matricula"+id_alumno).val();
    es_papeles=$("#es_papeles"+id_alumno).val();
    observaciones=$("#observaciones"+id_alumno).val();    
    var data={
        estado_pago: estado_pago,
        es_papeles: es_papeles,
        observaciones: observaciones,
        id_matricula: id_matricula_alumno,
        id_alumno: id_alumno
    }
    mostrarMensajeNotificador("Cargando. ");
    $.post(entorno+"alumno/updatematricula",data,mostrarFilaGestor);  
    
    
}
function mostrarFilaGestor(data){
     ocultarMensajeNotificador();                    
}
function listarAlumnosAcudienteAlumno(id_acudiente){
    mostrarMensajeNotificador("Cargando. ");
         $.post(entorno+"alumno/"+id_acudiente+"/perfilacudiente",function(data){
            $("#sub-container").html(data);
            ocultarMensajeNotificador();
      }
      );

}
function verMisDescriptores(id_alumno){
    mostrarMensajeNotificador("Cargando descriptores. ");
    $.post(entorno+"alumno/"+id_alumno+"/misdescriptores",function(data){
            $("#container-minostas-perfil").html(data);
            ocultarMensajeNotificador();
    });  
}
function filtrosObtenerAsgAlumno(id_alumno){
    $ano=$("#ano_escolar_perfil_alumno").val();
    mostrarMensajeNotificador("Cargando asignaturas. ");
    $.post(entorno+"alumno/"+$ano+"/"+id_alumno+"/getasg",function(data){
            $("#asignatura_perfil_alumno").html(data);
            ocultarMensajeNotificador();
    });
    
}
function getPeriodosDimensionAlumno(id_alumno){
    ano_escolar_perfil_alumno=$("#ano_escolar_perfil_alumno").val();
    perido_escolar_perfil_alumno=$("#perido_escolar_perfil_alumno").val();
    asignatura_perfil_alumno=$("#asignatura_perfil_alumno").val();
    data={
        ano_escolar: ano_escolar_perfil_alumno,
        periodo_escolar: perido_escolar_perfil_alumno,
        asignatura_escolar: asignatura_perfil_alumno,
        id_alumno: id_alumno
    };
    mostrarMensajeNotificador("Cargando periodos academicos. ");
    $.post(entorno+"alumno/getperiodosdimension",data,function(data){
            $("#perido_escolar_perfil_alumno").html(data);
            ocultarMensajeNotificador();
     });  
}
function getPeriodosDimensiondescriptorAlumno(id_alumno){
    ano_escolar_perfil_alumno=$("#ano_escolar_perfil_descriptores_alumno").val();
    perido_escolar_perfil_alumno=$("#perido_descriptores_escolar_perfil_alumno").val();
    asignatura_perfil_alumno=$("#asignatura_perfil_descriptores_alumno").val();
    data={
        ano_escolar: ano_escolar_perfil_alumno,
        periodo_escolar: perido_escolar_perfil_alumno,
        asignatura_escolar: asignatura_perfil_alumno,
        id_alumno: id_alumno
    };
    mostrarMensajeNotificador("Cargando. ");
    $.post(entorno+"alumno/getperiodosdimension",data,function(data){
            $("#perido_descriptores_escolar_perfil_alumno").html(data);
            ocultarMensajeNotificador();
     });  
}
function getAlumnoCedulaAlumno(){    
    mostrarMensajeNotificador("Buscando alumnos repetidos..")
     cedula=$("#ntp_inacholeebundle_alumnotype_cedula").val();
     n=$("#notificador_cedula");
     n.html("<span style='color:green'>espere........</span>")
     $.post(entorno+"alumno/"+cedula+"/getalumnocedula",function(data){
            if(data>0){
                   n.html("<span style='color:red'>Ojo ya hay un usuario con esta cedula</span>")
                   $("#boton_guardar_alumno").attr("disabled", "disabled");
            }
            else{
             
                $("#boton_guardar_alumno").removeAttr("disabled");
                 n.html("")
            
            }
            ocultarMensajeNotificador();
     });  
}
function newAlumnoUnoUnoLoteDefectoAno(){
    mostrarMensajeNotificador("Cargando ");
    $.post(entorno+"alumno/newalumnounonolote",function(data){
            $("#sub-container").html(data);
            ocultarMensajeNotificador();
        
        });        
}
function newAlumnoExcellDefectoAno(){
    mostrarMensajeNotificador("Cargando. ");
    $.post(entorno+"alumno/newexcell",function(data){
            $("#sub-container").html(data);
            ocultarMensajeNotificador();
            
        });        
}
function mejoresAcademicaAlumno(){
    mostrarMensajeNotificador("Cargando. ");
    $.post(entorno+"alumno/mejores",function(data){
            $("#page-wrapper").html(data);
            ocultarMensajeNotificador();
        });        
}
function buscarMejoresAlumnosAlumno(){
    mostrarMensajeNotificador("Cargando. ");
    sede=$("#sede_mejores").val();
    periodo_academico=$("#perido_escolar_perfil_alumno").val();
    filtro=$("#colegio_mejores").val();
    nro_items=$("#nro_items").val();
    $.post(entorno+"alumno/"+sede+"/"+periodo_academico+"/"+filtro+"/getmejores",{nro_items:nro_items},function(data){
            $("#ram_mejores_estudiante").html(data);                       
                      ocultarMensajeNotificador();
        });        
}

function calcularMejoresAlumnosAlumno(tipo){  
    mostrarMensajeNotificador("Realizando calculos. ");
    periodo_id=$("#perido_escolar_perfil_alumno").val()
    if(periodo_id=='*'){
        alert("Por favor Seleccione el Año Escolar y luego El periodo escolar");
        return;
    }
    $.post(entorno+"alumno/"+periodo_id+"/"+tipo+"/calcularmejores",function(data){
            $("#ram_mejores_estudiante").html(data);
           ocultarMensajeNotificador();
            
        });        
}
function mostrarFiltroPaginadorMejores(href){
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Nueva pagina De tu búsqueda. Espere....");
    alerta_principal.show();
    sede=$("#sede_mejores").val();
    periodo_academico=$("#perido_escolar_perfil_alumno").val();
    filtro=$("#colegio_mejores").val();
    nro_items=$("#nro_items").val();
    $.post(href,{nro_items:nro_items},function(data){
            $("#ram_mejores_estudiante").html(data);                       
            alerta_principal.html("Listo.");
            alerta_principal.hide(5000);
        });        
    
    
}

function getDatosBoletin(){
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Nueva pagina De tu búsqueda. Espere....");
    alerta_principal.show();    
    $.post(entorno+"alumno/75/imprimirboletin",function(data){
            $("#ram_mejores_estudiante").html(data);                       
            alerta_principal.html("Listo.");
        });        
    
    
}
function mostrarHorarioAlumno(id_alumno){
    mostrarMensajeNotificador("Cargando. ")
    $.post(entorno+"alumno/"+id_alumno+"/horarioclase",function(data){
            $("#sub-container").html(data);
            ocultarMensajeNotificador();
            
        });        
}
function mostrarCapasNombreCompletoPorPartes(e){
    
    tipo=e.value;
    if(tipo==2){
        $("#capa_nombre_entero").hide();
        $("#capa_nombre_separado").show();
    }
    if(tipo==1){
        $("#capa_nombre_entero").show();
        $("#capa_nombre_separado").hide();
    }
    $.post(entorno+"alumno/"+tipo+"/nombreseparado",function(data){
            
        });        

}
//Promover alumnos
function procesarVariosPrincipalPromover(){
    if($("#ano_escolar_id").val()!='*'){
        var ids=new Array();
        $("input:checked").each(function(e){
            ids.push(this);
        });
        procesarPromover(ids,0);
        ocultarMensajeNotificador();
    }
    else{
        alert("Por selecciona el AÑO ESCOLAR de matricula");
        return;
    }
    
}

function procesarPromover(ids,index){
   $id=$(ids[index]);
            mostrarMensajeNotificador("Promoviendo ");            
            
            if($id.hasClass('grupo') && $id.is(":checked")){
                grupo_id=$id.val();
                $.post(entorno+"alumno/"+grupo_id+"/alumnostree.json",function($ids_alumnos){
                procesarGrupoPromover($ids_alumnos,0);
                });    
            }
            if($id.hasClass('grado') && $id.is(":checked")){
                grado_id=$id.val();
                $.post(entorno+"alumno/"+grado_id+"/alumnosgradotree.json",function($ids_alumnos){
                    procesarGrupoPromover($ids_alumnos,0);
                });
            }
            if($id.hasClass('alumnos') && $id.is(":checked")){
                    alumno_id=$id.val();
                    ano_id=$("#ano_escolar_id").val();
                    mostrarMensajeNotificador("Promoviendo alumnos. ");
                    $.post(entorno+"alumno/"+alumno_id+"/"+ano_id+"/matricularpromovido",function(data){
                        ocultarMensajeNotificador();
                        
                    });
                    
                  
            }
            if(index+1>ids.length-1){
                ocultarMensajeNotificador();
                return;
            }
            procesarPromover(ids,index+1);
            
}

function procesarImpresionBC3(e){
    CUERPO_BOLETINES="";
    $ids=$("input:checked");
    procesarImpresionBC3R($ids,0);
    ocultarMensajeNotificador();
}
function procesarImpresionBC3R($ids,index){
     $id=$($ids[index]);
     if($id.hasClass('grupo') && $id.is(":checked")){
           grupo_id=$id.val();
             $.post(entorno+"alumno/"+grupo_id+"/alumnostree.json",function($ids_alumnos){
                 
                procesarGrupoImpresionesBCR3($ids_alumnos,0);
                });    
     }
     if($id.hasClass('grado') && $id.is(":checked")){
                grado_id=$id.val();
                $.post(entorno+"alumno/"+grado_id+"/alumnosgradotree.json",function($ids_alumnos){
                    procesarGrupoImpresionesBCR3($ids_alumnos,0);
                });
     }
     if($id.hasClass('alumnos') && $id.is(":checked")){
        
         procesarVariosImpresionesBCR3($id);
     }
     if(index+1>$ids.length-1){
         ocultarMensajeNotificador();
        return;
    }
     procesarImpresionBC3R($ids,index+1);
     
    
}
function procesarGrupoImpresionesBCR3($ids_alumnos,index){
    alumno_id=$ids_alumnos[index];
    if(index%2==0){
        tag=". .";
    }else
        tag=". . .";
    if($("#input_check_boletin").is(':checked')){    
        id_plantilla=$("input:checked.checks_boletines");        
         if($("#boletin_defecto").is(':checked'))  
            tipo=0;
         if($("#boletin_prescolar").is(':checked'))   
            tipo=1;
         if($("#boletin_semaforo").is(':checked'))   
            tipo=2;
         if($("#boletin_antiguo").is(':checked'))   
            tipo=3;
         if($("#boletin_ultimo_informe").is(':checked'))   
            tipo=4;        
    
       
        $.post(entorno+"alumno/"+alumno_id+"/"+id_plantilla[0].value+'/'+tipo+"/imprimirboletin",function(data){
            mostrarMensajeNotificador("Imprimiendo boletin"+tag)
            CUERPO_BOLETINES+=data;
            $("#sub-container-right-informe-bc3").html(CUERPO_BOLETINES);
            if(index+1>$ids_alumnos.length-1){
                ocultarMensajeNotificador();
                if($("input:checked").length==1){
                    procesarGrupoImpresionesBCR3($ids_alumnos,index+1);
                }
                return;
            }
            procesarGrupoImpresionesBCR3($ids_alumnos,index+1);
        });
    }
    if($("#input_check_constancia").is(':checked')){
        $.post(entorno+"alumno/"+alumno_id+"/imprimirconstanciaestudio",function(data){
            mostrarMensajeNotificador("Imprimiendo Constacia"+tag);
            CUERPO_BOLETINES+=data;
            $("#sub-container-right-informe-bc3").html(CUERPO_BOLETINES);
            if(index+1>$ids_alumnos.length-1){
                ocultarMensajeNotificador();
                return;
            }
            procesarGrupoImpresionesBCR3($ids_alumnos,index+1);
        });
    }
    if($("#input_check_certificaciones").is(':checked')){    
        $.post(entorno+"alumno/"+alumno_id+"/imprimircertificadoestudio",function(data){
            mostrarMensajeNotificador("Imprimiendo Certificado "+tag);
            CUERPO_BOLETINES+=data;
            $("#sub-container-right-informe-bc3").html(CUERPO_BOLETINES);
            if(index+1>$ids_alumnos.length-1){
                ocultarMensajeNotificador();
                return;
            }
            procesarGrupoImpresionesBCR3($ids_alumnos,index+1);
        });
    }
    if($("#input_check_carnet").is(':checked')){    
        $.post(entorno+"alumno/"+alumno_id+"/imprimircarnet",function(data){
            mostrarMensajeNotificador("Imprimiendo Carnet "+tag);
            CUERPO_BOLETINES+=data;
            $("#sub-container-right-informe-bc3").html(CUERPO_BOLETINES);
            if(index+1>$ids_alumnos.length-1){
                ocultarMensajeNotificador();
                return;
            }
            procesarGrupoImpresionesBCR3($ids_alumnos,index+1);
        });    
    
    }
    
}
function procesarGrupoPromover($ids_alumnos,index){
    alumno_id=$ids_alumnos[index];
    ano_id=$("#ano_escolar_id").val();
    $.post(entorno+"alumno/"+alumno_id+"/"+ano_id+"/matricularpromovido",function(data){
            mostrarMensajeNotificador(data)
            if(index+1>$ids_alumnos.length-1){
                ocultarMensajeNotificador();
                return;
            }
            procesarGrupoPromover($ids_alumnos,index+1);
    });
    
}

function procesarinputsCheckBC3(e){
    $("input.checkbox_informe_bc3").each(function(e){
        $(this).prop('checked',false);
    });
    $id=$("#"+e);
    $id.prop('checked',true);
}
function procesarVariosImpresionesBCR3($ids_alumnos){
    //console.info(index);
    alumno_id=$ids_alumnos.val();
    if($("#input_check_boletin").is(':checked')){
        id_plantilla=$("input:checked.checks_boletines");        
         if($("#boletin_defecto").is(':checked'))  
            tipo=0;
         if($("#boletin_prescolar").is(':checked'))   
            tipo=1;
         if($("#boletin_semaforo").is(':checked'))   
            tipo=2;
         if($("#boletin_antiguo").is(':checked'))   
            tipo=3;
         if($("#boletin_ultimo_informe").is(':checked'))   
            tipo=4;        
    
        mostrarMensajeNotificador("Imprimiendo boletines ");
        $.post(entorno+"alumno/"+alumno_id+"/"+id_plantilla[0].value+"/"+tipo+"/imprimirboletin",function(data){
            ocultarMensajeNotificador()
            CUERPO_BOLETINES+=data;
            $("#sub-container-right-informe-bc3").html(CUERPO_BOLETINES);
            
    });
    }
    if($("#input_check_constancia").is(':checked')){ 
        mostrarMensajeNotificador("Imprimiendo constacia ");
        $.post(entorno+"alumno/"+alumno_id+"/imprimirconstanciaestudio",function(data){
            ocultarMensajeNotificador();
            CUERPO_BOLETINES+=data;
            $("#sub-container-right-informe-bc3").html(CUERPO_BOLETINES);
            
        });
    }
    if($("#input_check_certificaciones").is(':checked')){
        mostrarMensajeNotificador("Imprimiendo certificado ");
        $.post(entorno+"alumno/"+alumno_id+"/imprimircertificadoestudio",function(data){
            ocultarMensajeNotificador();
            CUERPO_BOLETINES+=data;
            $("#sub-container-right-informe-bc3").html(CUERPO_BOLETINES);
            
        });
    }
    if($("#input_check_carnet").is(':checked')){   
        mostrarMensajeNotificador("Imprimiendo carnet ");
        $.post(entorno+"alumno/"+alumno_id+"/imprimircarnet",function(data){
            ocultarMensajeNotificador();
            CUERPO_BOLETINES+=data;
            $("#sub-container-right-informe-bc3").html(CUERPO_BOLETINES);
            
            
        });    
    }
 
}
function procesarVariosPromover($ids_alumnos,index){
    alumno_id=$ids_alumnos[index].value;
    ano_id=$("#ano_escolar_id").val();
    $.post(entorno+"alumno/"+alumno_id+"/"+ano_id+"/matricularpromovido",function(data){
            mostrarMensajeNotificador(data);
            $("#sub-container-right-informe-bc3").html("");
            if((index+1>$ids_alumnos.length-1)){
                ocultarMensajeNotificador();
                return;
            }
            
            procesarVariosPromover($ids_alumnos,index+1);
    });
 }
function imprimirMisNotas(alumno_id,id_plantilla,ano_escolar_id){
    data1={
        'ano_escolar':ano_escolar_id,
    };
    mostrarMensajeNotificador("Cargando notas. ");
     $.post(entorno+"alumno/"+alumno_id+"/"+id_plantilla+"/imprimirboletin",data1,function(data){
            ocultarMensajeNotificador();
            $("#container-minostas-perfil").html(data);
      });
}
function imprimirNotasAnoEscolar(e){
    ano_escolar=$("#ano_escolar").val();
    if(ano_escolar!='0'){
        id_plantilla=6;
        alumno_id=e.getAttribute('alumno-id');
        data={
        'ano_escolar':ano_escolar
        };
        mostrarMensajeNotificador("Cargando notas. ");
        $.post(entorno+"alumno/"+alumno_id+"/"+id_plantilla+"/imprimirboletin",data,function(data){
            ocultarMensajeNotificador();
            $("#container-minostas-perfil").html(data);
        });
    }
    else{
        CUERPO_BOLETINES="";
        $.post(entorno+"dimension/anosescolares.json",function(anos_escolares){
            procesarVariosMisNotasAnosEscolares(e,anos_escolares,0);
        });
    }
}
function procesarVariosMisNotasAnosEscolares(e,anos_escolares,index){
    id_plantilla=6;
    alumno_id=e.getAttribute('alumno-id');
    data={
        'ano_escolar':anos_escolares[index]
    };
    mostrarMensajeNotificador("Cargando notas. ");
    $.post(entorno+"alumno/"+alumno_id+"/"+id_plantilla+"/imprimirboletin",data,function(data){
            CUERPO_BOLETINES+=data;
            $("#container-minostas-perfil").html(CUERPO_BOLETINES);
            if((index+1>anos_escolares.length-1)){
                ocultarMensajeNotificador();
                return;
            }
            procesarVariosMisNotasAnosEscolares(e,anos_escolares,index+1);
            
    });
}
function editDesempenoalumno(alumno_desempeno_id){
    mostrarMensajeNotificador("Cargando notas. ");
     $.post(entorno+"alumno/"+alumno_desempeno_id+"/editardescriptor",function(data){
            ocultarMensajeNotificador();
            $("#capa_desempeno_alumno_"+alumno_desempeno_id).html(data);
            $("#update_a_"+alumno_desempeno_id).show();
            $("#editar_a_"+alumno_desempeno_id).hide();
            
    });
}
function updateDesempenoalumno(alumno_desempeno_id){
    mostrarMensajeNotificador("Cargando notas. ");
    desempeno=$("#t_area"+alumno_desempeno_id).val();
    $.post(entorno+"alumno/"+alumno_desempeno_id+"/updatedescriptor",{'desenpeno': desempeno},function(data){
            ocultarMensajeNotificador();
            
            $("#capa_desempeno_alumno_"+alumno_desempeno_id).html(data);
            $("#update_a_"+alumno_desempeno_id).hide();
            $("#editar_a_"+alumno_desempeno_id).show();
            
    });
}
function deleteDesempenoalumno(alumno_id,alumno_desempeno_id){
    mostrarMensajeNotificador("Cargando notas. ");
    $.post(entorno+"alumno/"+alumno_desempeno_id+"/deletedescriptor",function(data){
        verMisDescriptores(alumno_id);
  });
}
function verRecuperaciones(alumno_id){
    mostrarMensajeNotificador("Cargando notas. ");
    $.post(entorno+"alumno/"+alumno_id+"/verrecuperaciones",function(data){
            $("#container-minostas-perfil").html(data);
            ocultarMensajeNotificador();
  });
}
function actualizarNotaRecuperacion(id_nota,id_nota_recuperacion,valor,alumno_id,id_re){
     descripcion=$("#textarea"+id_re).val();
     data={
         'nueva_nota':valor,
         'id_nota_recuperacion':id_nota_recuperacion,
         'id_nota_periodo':id_nota,
         'observacion': descripcion
     };
     $.post(entorno+'alumno/cambiarnotarecuperacion',data, function(res){
	verRecuperaciones(alumno_id);
      });      
    
}
function actualizarNotaRecuperacionObseracion(id_recuperacion,valor,alumno_id){
     descripcion=$("#textarea_"+id_recuperacion).val();
     data={
         'nueva_nota':valor,
         'id_recuperacion':id_recuperacion,
         'observacion': descripcion
     };
     $.post(entorno+'alumno/cambiarnotarecuperacionobservacion',data, function(res){
	verRecuperaciones(alumno_id);
      });      
    
}
function borrarAlumno(alumno_id){
    if(confirm("Esta seguro de eliminar al alumno!")){
    $.post(entorno+'alumno/'+alumno_id+'/borraruno.html', function(res){
	
    });      
    }
    
}
function mostrarBoletinPerfil(alumno_id,plantilla_id){
    mostrarMensajeNotificador("Imprimiendo Boletin. ");
    $.post(entorno+'alumno/'+alumno_id+'/'+plantilla_id+'/imprimirboletin.html', function(res){
	$("#container-minostas-perfil").html(res);
        ocultarMensajeNotificador();
    });      
 }
function mostrarCertificadoPerfil(alumno_id,plantilla_id){
    mostrarMensajeNotificador("Imprimiendo Certificado. ");
    $.post(entorno+'alumno/'+alumno_id+'/imprimircertificadoestudio.html', function(res){
	$("#container-minostas-perfil").html(res);
        ocultarMensajeNotificador();
    });      
 }
function mostrarConstanciaPerfil(alumno_id,plantilla_id){
    mostrarMensajeNotificador("Imprimiendo Constancia. ");
    $.post(entorno+'alumno/'+alumno_id+'/imprimirconstanciaestudio.html', function(res){
	$("#container-minostas-perfil").html(res);
        ocultarMensajeNotificador();
    });      
 }
function mostrarcarnetPerfil(alumno_id,plantilla_id){
    mostrarMensajeNotificador("Imprimiendo carnet estudiantil. ");
    $.post(entorno+'alumno/'+alumno_id+'/imprimircarnet.html', function(res){
	$("#container-minostas-perfil").html(res);
        ocultarMensajeNotificador();
    });      
 }
function filtroAlumnosInformePromover(label){
    mostrarMensajeNotificador("Cargando alumnos.");
    sede=$("#sede").val();
    grado=$("#grado_id").val();
    grupo=$("#grupo_id").val();
    
    data={
      'sede':sede,
      'grado':grado,
      'grupo':grupo,
      };
    
    mostrarMensajeNotificador("Buscando alumnos que"+label);
    $.post(entorno+'alumno/'+label+'/filtropromover', data,function(res){
	ocultarMensajeNotificador();
        $("#rapper-informe-promover").html(res);
    });      
 }
 function filtrosObtenerNotasAlumno(e,alumno_id){
     periodo_id=$("#perido_escolar_perfil_alumno").val();
     ano_escolar_id=$("#ano_escolar_perfil_alumno").val()
     asg_id=$("#asignatura_perfil_alumno").val();
     data={
         'periodo_escolar':periodo_id,
         'ano_escolar': ano_escolar_id,
         'asignatura_escolar':asg_id
     };
     $.post(entorno+'alumno/'+alumno_id+'/misnotas', data,function(res){
	ocultarMensajeNotificador();
        $("#registro_notas_alumnos").html(res);
    }); 
 }
 function filtrosObtenerNotasdescriptoresAlumno(e,alumno_id){
     periodo_id=$("#perido_escolar_perfil_alumno").val();
     ano_escolar_id=$("#ano_escolar_perfil_alumno").val()
     asg_id=$("#asignatura_perfil_alumno").val();
     data={
         'periodo_escolar':periodo_id,
         'ano_escolar': ano_escolar_id,
         'asignatura_escolar':asg_id
     };
     $.post(entorno+'alumno/'+alumno_id+'/misdescriptores', data,function(res){
	ocultarMensajeNotificador();
        $("#registro_notas_descriptores_alumnos").html(res);
    }); 
 }
 
 function enviarActualizacionMatriculas(){
     var ids=new Array();
     var data=new Array();
     $(".activa").each(function(e){
            ids.push($(this).val());
            data.push($(this).attr('data-id'));           
            
     });
    
    index=0; 
    mostrarMensajeNotificador("Procesando ");
    for (index=0;index<ids.length;index++){
    $.post(entorno+'alumno/'+data[index]+'/'+ids[index]+'/actualizarmatricula', data,function(res){
	ocultarMensajeNotificador();
        $("#registro_notas_alumnos").html(res);
            ocultarMensajeNotificador();
    }); 
    }
     
      
 }
 function procesarActivarCambio(e){
     $id=$(e);
     $id.addClass('activa');
     
 }





