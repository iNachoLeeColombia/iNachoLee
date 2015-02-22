
tipo_global=0;
////////TemaAsignatura
///////
/////
///
//
//
///
/////
///////
////////
function showTemaAsignaturainfoAcademicaDefectoAno(id,tipo){
    tipo_global=tipo;
    $.get(entorno+"TemaAsignatura/"+id+"/"+tipo+"/show",function(data){
            $("#tabs2-"+tipo).html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            
        });        
}

function indexTemaAsignaturainfoAcademicaDefectoAno(id_asignatura){ 
    
    $.get(entorno+"temaasignatura/"+id_asignatura,function(data){
            $("#capa_ram_lista_temas_asignatura").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            
        });        
}

function editarTemaAsignaturainfoAcademicaDefectoAno(id){
    tipo_global=tipo;
    $.get(entorno+"temaasignatura/"+id+"/edit",function(data){
            $("#capa_ram_lista_temas_asignatura").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            
        });        
}
function updateTemaAsignaturainfoAcademicaDefectoAno(id,id_asignatura){
   
   $("#form_edit_tema_asignatura").submit(function(){             
          $.ajax({
            type:"POST",
            url:entorno+'temaasignatura/'+id+'/update',
            dataType:"html",
            data:$(this).serialize(),
            beforeSend:function(){
                
              $("#loading").show();
            },
            success:function(response){
             
            indexTemaAsignaturainfoAcademicaDefectoAno(id_asignatura);
                $("#response").html(response);
                $("#loading").hide();
            }

          })
          return false;
        })      
   /*token=$("#ntp_inacholeebundle_TemaAsignaturatype__token").val();
    
    nombre=$("#ntp_inacholeebundle_TemaAsignaturatype_nombre").val();
    
    
    area=$("#ntp_inacholeebundle_TemaAsignaturatype_area").val();
    
    grado=$("#ntp_inacholeebundle_TemaAsignaturatype_grado").val();    
    
    duracion=$("#ntp_inacholeebundle_TemaAsignaturatype_duracion_minutos").val();
   frecuencia=$("#ntp_inacholeebundle_TemaAsignaturatype_frucuencia_semana").val();

    var data = {
              ntp_inacholeebundle_TemaAsignaturatype:{
                        nombre: nombre,
                        frucuencia_semana: frecuencia,
                        area: area,
                        grado: grado,                        
                        _token: token,
                        duracion_minutos: duracion
                        
                }
            };  
    $.post(entorno+"TemaAsignatura/"+id+"/"+tipo+"/update",data,function(data){
            $.post(entorno+"TemaAsignatura/"+tipo,data,function(data){
                $("#tabs2-"+tipo).html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            });
            
            
        }); */       
}
function newTemaAsignaturainfoAcademicaDefectoAno(id_asignatura){
    $.post(entorno+"temaasignatura/"+id_asignatura+"/new",function(data){
            $("#capa_ram_lista_temas_asignatura").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            
        });        
}
         
function createTemaAsignaturainfoAcademicaDefectoAno(id_asignatura){
       
   $("#new_form_tema_asignatura").submit(function(){             
          $.ajax({
            type:"POST",
            url:entorno+'temaasignatura/'+id_asignatura+'/create',
            dataType:"html",
            data:$(this).serialize(),
            beforeSend:function(){
                 nombre=$("#ntp_inacholeebundle_dimensiontype_nombre").val();
             
              $("#loading").show();
            },
            success:function(response){
             
            indexTemaAsignaturainfoAcademicaDefectoAno(id_asignatura);
                $("#response").html(response);
                $("#loading").hide();
            }

          })
          return false;
        })         
    /*token=$("#ntp_inacholeebundle_TemaAsignaturatype__token").val();
    
    nombre=$("#ntp_inacholeebundle_TemaAsignaturatype_nombre").val();
    
    
    area=$("#ntp_inacholeebundle_TemaAsignaturatype_area").val();
    
    grado=$("#ntp_inacholeebundle_TemaAsignaturatype_grado").val();    
    
    duracion=$("#ntp_inacholeebundle_TemaAsignaturatype_duracion_minutos").val();
   frecuencia=$("#ntp_inacholeebundle_TemaAsignaturatype_frucuencia_semana").val();
   
    if(tipo==1){
        data = {
                ntp_inacholeebundle_TemaAsignaturatype:{
                        nombre: nombre,
                        frucuencia_semana: frecuencia,                        
                        grado: grado,                        
                        _token: token,
                        duracion_minutos: duracion
                        
                }
            };  
    }
    if(tipo==2){
                data = {
                ntp_inacholeebundle_TemaAsignaturatype:{
                        nombre: nombre,
                        frucuencia_semana: frecuencia,
                        area: area,
                        grado: grado,                        
                        _token: token,
                        duracion_minutos: duracion
                        
                }
            };  
    }
    $.post(entorno+"TemaAsignatura/"+tipo+"/create",data,function(data){
            $.get(entorno+"TemaAsignatura/"+tipo,function(data){
                $("#tabs2-"+tipo).html(data);            
                $("#flass_tmp").html("<span>listo!!!</span>");
            });
            
            
        });  */      
}         
function deleteTemaAsignaturainfoAcademicaDefectoAno(id,id_asignatura){
   _token=$("div#"+id+" div input:first").val();                 
    var data = {
                form:{
                    id: id,
                    _token: _token                
                }
            }; 
    
    $.post(entorno+"temaasignatura/"+id+"/delete",data,function(){
            indexTemaAsignaturainfoAcademicaDefectoAno(id_asignatura);            
    });            
}
