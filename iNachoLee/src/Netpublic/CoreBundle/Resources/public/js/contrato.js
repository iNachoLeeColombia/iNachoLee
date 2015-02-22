
tipo_global=0;
////////contrato de un Colegio
///////
/////
///
//
//
///
/////
///////
////////
function showcontratoinfoAcademicaDefectoAno(id){ 
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Detalles Del Contrato. Espere....");
    alerta_principal.show()
    $.get(entorno+"contrato/"+id+"/show",function(data){
              capa_ram_perfil_admin=$("#capa_ram_perfil_admin")
            capa_ram_perfil_admin.html(data); 
            
    alerta_principal.html("Listo"); alerta_principal.hide(5000);
    
        });        
}
function indexcontratoinfoAcademicaDefectoAno(id_profesor){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Lista De Contrato. Espere....");
    alerta_principal.show()
    $.post(entorno+"contrato/"+id_profesor+"/profesor",function(data){
             capa_ram_perfil_admin=$("#capa_ram_perfil_admin")
            capa_ram_perfil_admin.html(data);
           
    alerta_principal.html("Listo"); alerta_principal.hide(5000);
   
        });        
}

function indexDescriptorescontratoinfoAcademicaDefectoAno(){ 
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Lista De Descriptores. Espere....");
    alerta_principal.show()
    $.get(entorno+"contrato/indexdesempeno",function(data){
            $("#_tabs9-3").html(data);            
           
    alerta_principal.html("Listo.");
   
            
        });  
    return;    
}

function editarcontratoinfoAcademicaDefectoAno(id_){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Interfaz Para Editar Contrato. Espere....");
    alerta_principal.show()
    $.get(entorno+"contrato/"+id+"/edit",function(data){
            $("#tabs3-0").html(data);            
            
    alerta_principal.html("Listo.");
  
            
        });        
}
function updatecontratoinfoAcademicaDefectoAno(id,id_profesor){
            
    //*****************************************
   //Formulario Nuevo Periodo Academico********
  alerta_principal=$("#alerta_principal");
    alerta_principal.html("Actualizando Contrato. Espere....");
    alerta_principal.show()
        $("#1").submit(function(){             
              $.ajax({
                type:"POST",
                url:entorno+'contrato/'+id+'/update',
                dataType:"html",
                data:$(this).serialize(),
                beforeSend:function(){                        
                    $("#loading").show();
                },
                success:function(response){           
                    $("#response").html(response);
                    $("#loading").hide();
                   
    alerta_principal.html("Listo.");
    
                 indexcontratoinfoAcademicaDefectoAno(id_profesor);
                }

                })
          return false;
        }); 
  
      //********************************************** 
      
}
function newcontratoinfoAcademicaDefectoAno(){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Interfaz de Nuevo Contrato. Espere....");
    alerta_principal.show()
    $.post(entorno+"contrato/new",function(data){
   capa_ram_perfil_admin=$("#capa_ram_perfil_admin")
            capa_ram_perfil_admin.html(data);
           
    alerta_principal.html("Listo.");
   
        });        
}
function editarcontratoinfoAcademicaDefectoAno(id_contrato){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Interfaz Para Editar Contrato. Espere....");
    alerta_principal.show()
    $.post(entorno+"contrato/"+id_contrato+"/edit",function(data){
            capa_ram_perfil_admin=$("#capa_ram_perfil_admin")
            capa_ram_perfil_admin.html(data);      
            
    alerta_principal.html("Listo.");

        });        
}
         
function createcontratoinfoAcademicaDefectoAno(id_profesor){
         
    //*****************************************
   //Formulario Nuevo Periodo Academico********
  alerta_principal=$("#alerta_principal");
    alerta_principal.html("Guardando Contrato. Espere....");
    alerta_principal.show()
        $("#1").submit(function(){             
              $.ajax({
                type:"POST",
                url:entorno+'contrato/create',
                dataType:"html",
                data:$(this).serialize(),
                beforeSend:function(){                        
                    $("#loading").show();
                },
                success:function(response){           
                    $("#response").html(response);
                    $("#loading").hide();
                 indexcontratoinfoAcademicaDefectoAno(id_profesor);
                 
    alerta_principal.html("Listo ");
    
                }

                })
          return false;
        }); 
  
      //********************************************** 
       
}
function createClientecontratoinfoAcademicaDefectoAno(){
    
    ntp_inacholeebundle_contratotype_horas_contratadas=$("#ntp_inacholeebundle_contratotype_horas_contratadas").val();
    if(ntp_inacholeebundle_contratotype_horas_contratadas==""){
        alert("Por favor ingrese Horas De Disponibiliad.");
        return;
    }
    $ntp_inacholeebundle_contratotype_asignatura=$("#ntp_inacholeebundle_contratotype_asignatura option:selected");
    ntp_inacholeebundle_contratotype_asignatura=$ntp_inacholeebundle_contratotype_asignatura.val();
    nombre_ntp_inacholeebundle_contratotype_asignatura=$ntp_inacholeebundle_contratotype_asignatura.text();    
   
    contrato_json_profesor+='{"asignatura": "'+ntp_inacholeebundle_contratotype_asignatura+' ",';
    contrato_json_profesor+='"horas_semanales": "'+ntp_inacholeebundle_contratotype_horas_contratadas+'"},';
    contratos_profesor_id=$("#contratos_profesor_id");    
    html="";
    html+="<div>";
    html+="<input type='checkbox' class='contratos_profesor_checkbox' />";
    html+='<span id="+ntp_inacholeebundle_contratotype_horas_contratadas">';
    html+=nombre_ntp_inacholeebundle_contratotype_asignatura;
    html+="("+ntp_inacholeebundle_contratotype_horas_contratadas+"horas)";
    html+="    </span></div>";
    
    contratos_profesor_id.append(html);
    
}
function eliminarItemCargaacademica(){
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Interfaz de Nuevo Alumno. Espere....");
    alerta_principal.show()
    contratos_profesor_checkbox=$("input.contratos_profesor_checkbox:checked").each(function(){
        
        $(this).parent().remove();
        alerta_principal=$("#alerta_principal");
    alerta_principal.html("Cargando Interfaz de Nuevo Alumno. Espere....");
    alerta_principal.show()
    });
    
    
}
function deletecontratoinfoAcademicaDefectoAno(id,id_profesor){
           
    //*****************************************
   //Formulario Nuevo Periodo Academico********
  alerta_principal=$("#alerta_principal");
    alerta_principal.html("Borrando Contrato. Espere....");
    alerta_principal.show()
        $("#1").submit(function(){             
              $.ajax({
                type:"POST",
                url:entorno+'contrato/'+id+'/delete',
                dataType:"html",
                data:$(this).serialize(),
                beforeSend:function(){                        
                    $("#loading").show();
                },
                success:function(response){           
                    $("#response").html(response);
                    $("#loading").hide();
                  
    alerta_principal.html("Listo.");
   
                 indexcontratoinfoAcademicaDefectoAno(id_profesor);
                 
                }

                })
          return false;
        }); 
  
      //********************************************** 
       
 
}
function finalizarcontratoinfoAcademicaDefectoAno(){
     dialogo.hide();
}
function filtroGradoAsignatura(id_grado)
{
    //ntp_inacholeebundle_contratotype_grado
    getAsignaturaGrado(id_grado);
}


