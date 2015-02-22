
tipo_global=0;
////////Grados de un Colegio
///////
/////
///
//
//
///
/////
///////
////////
function showGradoinfoAcademicaDefectoAno(id){ 
    $.get(entorno+"grado/"+id+"/show",function(data){
            $("#home").html(data);                           
    });        
}

function indexGradoinfoAcademicaDefectoAno(){ 
    $.get(entorno+"grado/",function(data){
            $("#home").html(data);            
    });  
    return;    
}

function editarGradoinfoAcademicaDefectoAno(id){
    $.get(entorno+"grado/"+id+"/edit",function(data){
            $("#home").html(data);            
    });        
}
function updateGradoinfoAcademicaDefectoAno(id){
      //*****************************************
   //Formulario Nuevo Periodo Academico********
   $("#1").submit(function(){             
          $.ajax({
            type:"POST",
            url:entorno+'grado/'+id+'/update',
            dataType:"html",
            data:$(this).serialize(),
            beforeSend:function(){
                 nombre=$("#ntp_inacholeebundle_dimensiontype_nombre").val();
              },
            success:function(response){
                indexGradoinfoAcademicaDefectoAno();
            }
            })
          return false;
        }) 
      //**********************************************
               
    
}
function newGradoinfoAcademicaDefectoAno(tipo){
    $.post(entorno+"grado/new",function(data){
            $("#home").html(data);            
               
        });        
}
         
function createGradoinfoAcademicaDefectoAno(){
     //*****************************************
   //Formulario Nuevo Periodo Academico********
  $("#form_newGrado").submit(function(){             
          $.ajax({
            type:"POST",
            url:entorno+'grado/create',
            dataType:"html",
            data:$(this).serialize(),
            beforeSend:function(){
                 nombre=$("#ntp_inacholeebundle_dimensiontype_nombre").val();
              },
            success:function(response){
            indexGradoinfoAcademicaDefectoAno();
            }

          })
          return false;
        }) 
      //**********************************************
             
}
function createnewGradoinfoAcademicaDefectoAno(){
     //*****************************************
   //Formulario Nuevo Periodo Academico********
     
   alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Guardando Grado. Espere....");
    alerta_principal.show();
   $("#form_newGrado").submit(function(){             
          $.ajax({
            type:"POST",
            url:entorno+'grado/create',
            dataType:"html",
            data:$(this).serialize(),
            beforeSend:function(){
                 nombre=$("#ntp_inacholeebundle_dimensiontype_nombre").val();
              
              $("#loading").show();
            },
            success:function(response){
                newGradoinfoAcademicaDefectoAno(0)
            }

          })
          return false;
        }) 
      //**********************************************
             
}
         
function deleteGradoinfoAcademicaDefectoAno(id){
   //*****************************************
   //Formulario Nuevo Periodo Academico********
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Borrando Asignatura. Espere....");
    alerta_principal.show()
        $("#form_"+id).submit(function(){             
              $.ajax({
                type:"POST",
                url:entorno+'grado/'+id+'/delete',
                dataType:"html",
                data:$(this).serialize(),
                beforeSend:function(){                        
                    
                },
                success:function(response){           
                   indexGradoinfoAcademicaDefectoAno();
                   alerta_principal.html("Listo");
                   alerta_principal.hide(5000);
               }

                })
          return false;
        }); 
  
      //********************************************** 


}
function mostrarGruposAsignatuasGrado(id_fuente_grado,id_destino_grupo,id_destino_asignatura){    
    getGruposGradoEstandar(id_fuente_grado,id_destino_grupo);    
    getAsignaturasGrado(id_fuente_grado,id_destino_asignatura);
    
}