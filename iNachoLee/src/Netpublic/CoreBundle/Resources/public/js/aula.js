tipo_global=0;
////////Aulas de un Colegio
///////
/////
///
//
//
///
/////
///////
////////
function showAulainfoAcademicaDefectoAno(id){ 
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Detalles Aula. Espere....");
    alerta_principal.show();
    $.get(entorno+"aula/"+id+"/show",function(data){
            $("#tabs9-1").html(data);            
           
    alerta_principal.html("Listo.");
    
            
        });        
}

function indexAulainfoAcademicaDefectoAno(){ 
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Lista Aulas. Espere....");
    alerta_principal.show();
    $.get(entorno+"aula/",function(data){
            $("#tabs9-1").html(data);            
           
    alerta_principal.html("Listo ");
   
        });  
    return;    
}

function editarAulainfoAcademicaDefectoAno(id){
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Interfaz para Editar Aula . Espere....");
    alerta_principal.show();
    $.get(entorno+"aula/"+id+"/edit",function(data){
            $("#tabs9-1").html(data);            
             
    alerta_principal.html("Listo.");
  
            
        });        
}
function updateAulainfoAcademicaDefectoAno(id){
               
    token=$("#ntp_inacholeebundle_aulatype__token").val();
    ubicacion=$("#ntp_inacholeebundle_aulatype_ubicacion").val();
    nombre=$("#ntp_inacholeebundle_aulatype_nombre").val();
    horario_clase=$("#ntp_inacholeebundle_aulatype_horario_clase").val();    
    contrato_aula=$("#ntp_inacholeebundle_aulatype_contrato_aula").val();
    if(contrato_aula==null){
        
        var data = {
                ntp_inacholeebundle_aulatype:{
                        nombre: nombre,                 
                        _token: token,
                        ubicacion: ubicacion,
                        horario_clase: {
                            '': horario_clase
                        }
                                                
                }
            };  
    }
    else{
        data = {
                ntp_inacholeebundle_aulatype:{
                        nombre: nombre,                 
                        _token: token,
                        ubicacion: ubicacion,
                        horario_clase: {
                            '': horario_clase
                        },
                        contrato_aula: {
                            '': contrato_aula
                        }
                        
                }
            };  
    } 
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Actualizando Aula. Espere....");
    alerta_principal.show();
    $.post(entorno+"aula/"+id+"/update",data,function(data){
            $.post(entorno+"aula/",data,function(data){
                $("#tabs9-1").html(data);            
             
    alerta_principal.html("Listo.");
    
            });
            
            
        });        
}
function newAulainfoAcademicaDefectoAno(){
     ubicacion=$("#ntp_inacholeebundle_aulatype_ubicacion").val();
     sede=$("#ntp_inacholeebundle_aulatype_nombre").val();
     alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Interfaz para Nueva Aula . Espere....");
    alerta_principal.show();
    $.post(entorno+"aula/new",function(data){
             
            $("#tabs9-1").html(data);  
            $("#ntp_inacholeebundle_aulatype_ubicacion").val(sede);
            $("#ntp_inacholeebundle_aulatype_nombre").val(ubicacion);
              
    alerta_principal.html("Listo.");
 
            
        });        
}
         
function createAulainfoAcademicaDefectoAno(){
               
    token=$("#ntp_inacholeebundle_aulatype__token").val();
    ubicacion=$("#ntp_inacholeebundle_aulatype_ubicacion").val();
    nombre=$("#ntp_inacholeebundle_aulatype_nombre").val();
    horario_clase=$("#ntp_inacholeebundle_aulatype_horario_clase").val();    
    contrato_aula=$("#ntp_inacholeebundle_aulatype_contrato_aula").val();
    if(contrato_aula==null){
        
        var data = {
                ntp_inacholeebundle_aulatype:{
                        nombre: nombre,                 
                        _token: token,
                        ubicacion: ubicacion,
                        horario_clase: {
                            '': horario_clase
                        }
                                                
                }
            };  
    }
    else{
        data = {
                ntp_inacholeebundle_aulatype:{
                        nombre: nombre,                 
                        _token: token,
                        ubicacion: ubicacion,
                        horario_clase: {
                            '': horario_clase
                        },
                        contrato_aula: {
                            '': contrato_aula
                        }
                        
                }
            };  
    }
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Guardando Nueva Aula . Espere....");
    alerta_principal.show();
    $.post(entorno+"aula/create",data,function(data_){
            $.get(entorno+"aula/",function(data){
                $("#tabs9-1").html(data);            
                
    alerta_principal.html("Listo.");
  
            });
            
            
        });        
}
function deleteAulainfoAcademicaDefectoAno(id){
   _token=$("div#"+id+" div input:first").val();                 
    var data = {
                form:{
                    id: id,
                    _token: _token                
                }
            }; 
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Eliminando Aula. Espere......");
    alerta_principal.show();
    $.post(entorno+"aula/"+id+"/delete",data,function(){
              
    alerta_principal.html("Listo"); alerta_principal.hide(5000);
   
            indexAulainfoAcademicaDefectoAno();            
    });           
}
function newHorarioAulaAula(){
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Detalles Asignatura|Area.. Espere....");
    alerta_principal.show();
    $.post(entorno+"horarioclase/new",function(data){
           ventana=$("#myModal");
                ventana.html(data);
                $('#myModal').modal('show');
                alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Detalles Asignatura|Area.. Espere....");
    alerta_principal.show();
        });  
}
function agregarNuevoHorarioaulaAula(){
    ntp_inacholeebundle_horarioclasetype_hora_inicio=$("#ntp_inacholeebundle_horarioclasetype_hora_inicio");
    hora_inicio=ntp_inacholeebundle_horarioclasetype_hora_inicio.val();
    
    ntp_inacholeebundle_horarioclasetype_hora_final=$("#ntp_inacholeebundle_horarioclasetype_hora_final");
    hora_final=ntp_inacholeebundle_horarioclasetype_hora_final.val();
    ntp_inacholeebundle_horarioclasetype_dia_semana=$("#ntp_inacholeebundle_horarioclasetype_dia_semana");
    dia_semana=ntp_inacholeebundle_horarioclasetype_dia_semana.val();    
    ntp_inacholeebundle_horarioclasetype__token=$("#ntp_inacholeebundle_horarioclasetype__token");
    token=ntp_inacholeebundle_horarioclasetype__token.val();
     
    
    if(dia_semana=='7'){
        for(i=0;i<7;i++){
          var data = {
                ntp_inacholeebundle_horarioclasetype:{
                        hora_inicio: hora_inicio,                 
                        _token: token,
                        hora_final: hora_final,
                        dia_semana: i
                }
            };  
            $.post(entorno+"horarioclase/create",data,function(data){
               newAulainfoAcademicaDefectoAno();
            }); 
         }
        
        
    }
    else{
        data = {
                ntp_inacholeebundle_horarioclasetype:{
                        hora_inicio: hora_inicio,                 
                        _token: token,
                        hora_final: hora_final,
                        dia_semana: dia_semana 
                }
            };  
            $.post(entorno+"horarioclase/create",data,function(data){
                newAulainfoAcademicaDefectoAno();
            }); 
        
    }
    
}
function deleteHorarioclaseAula(){
    ntp_inacholeebundle_aulatype_horario_clase=$("#ntp_inacholeebundle_aulatype_horario_clase").val()+"";
    if(ntp_inacholeebundle_aulatype_horario_clase==null){
        alert("Seleccione Horario a Eliminar.");
        return;
    }
    horarios=ntp_inacholeebundle_aulatype_horario_clase.split(",");
    for(i=0;i<horarios.length;i++){
         $.post(entorno+"horarioclase/"+horarios[i]+"/delete",function(data){
                newAulainfoAcademicaDefectoAno();
            }); 
        
    }
    
    
}
function editarHorarioclaseAula(){
     ntp_inacholeebundle_aulatype_horario_clase=$("#ntp_inacholeebundle_aulatype_horario_clase").val();
     $.post(entorno+"horarioclase/"+ntp_inacholeebundle_aulatype_horario_clase+"/edit",function(data){
           ventana=$("#myModal");
                ventana.html(data);
                $('#myModal').modal('show');
                
        });
}
function updateHorarioclaseAula(){
     ntp_inacholeebundle_horarioclasetype_hora_inicio=$("#ntp_inacholeebundle_horarioclasetype_hora_inicio");
    hora_inicio=ntp_inacholeebundle_horarioclasetype_hora_inicio.val();
    
    ntp_inacholeebundle_horarioclasetype_hora_final=$("#ntp_inacholeebundle_horarioclasetype_hora_final");
    hora_final=ntp_inacholeebundle_horarioclasetype_hora_final.val();
    ntp_inacholeebundle_horarioclasetype_dia_semana=$("#ntp_inacholeebundle_horarioclasetype_dia_semana");
    dia_semana=ntp_inacholeebundle_horarioclasetype_dia_semana.val();    
    ntp_inacholeebundle_horarioclasetype__token=$("#ntp_inacholeebundle_horarioclasetype__token");
    token=ntp_inacholeebundle_horarioclasetype__token.val();
    horario_clase_editar_id=$("#horario_clase_editar_id").val();
     data = {
                ntp_inacholeebundle_horarioclasetype:{
                        hora_inicio: hora_inicio,                 
                        _token: token,
                        hora_final: hora_final,
                        dia_semana: dia_semana 
                }
            };  
            $.post(entorno+"horarioclase/"+horario_clase_editar_id+"/update",data,function(data){
                newAulainfoAcademicaDefectoAno();
            }); 
    
}

