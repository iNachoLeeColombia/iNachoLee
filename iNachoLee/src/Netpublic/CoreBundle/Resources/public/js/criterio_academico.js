/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function showCriterioAcademicoAno(id){  
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Detalles Criterio Acádemico. Espere....");
    alerta_principal.show();
    $.get(entorno+"grupo/"+id+"/show",function(data){
            $("#tabs5-0").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
               
    alerta_principal.html("Listo"); alerta_principal.hide(5000);
   
        });        
}

function indexCriterioAcademicoAno(){ 
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Lista de Criterios Academicos. Espere....");
    alerta_principal.show();
    $.get(entorno+"criteriopromocion/",function(data){
            $("#tabs1-0-0").html(data);            
           
    alerta_principal.html("Listo.");
  
            
        });  
    return;    
}

function editarCriterioAcademicoAno(id){
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Interfaz para Editar Grupo . Espere....");
    alerta_principal.show();
    $.get(entorno+"grupo/"+id+"/edit",function(data){
            $("#tabs5-0").html(data);            
            
    alerta_principal.html("Listo"); alerta_principal.hide(5000);
 
            
        });        
}
function updateCriterioAcademicoAno(id){
    token=$("#ntp_inacholeebundle_grupotype__token").val();
    grado=$("#ntp_inacholeebundle_grupotype_grado").val();
    nombre=$("#ntp_inacholeebundle_grupotype_nombre").val();
    dir_grupo=$("#ntp_inacholeebundle_grupotype_director_grupo").val();
    
   
    var data = {
                ntp_inacholeebundle_grupotype:{
                        nombre: nombre,                 
                        _token: token,
                        grado: grado,
                        director_grupo: dir_grupo

                }
            };
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Actualizando Grupo. Espere....");
    alerta_principal.show();        
    $.post(entorno+"grupo/"+id+"/update",data,function(data){
            $.post(entorno+"grupo/",data,function(data){
                $("#tabs5-0").html(data);            
            alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Detalles Grado.. Espere....");
    alerta_principal.show();
            });
            
            
        });        
}
function newCriterioAcademicoAno(tipo){
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Interfaz para Nuevo Grupo. Espere....");
    alerta_principal.show();
    $.post(entorno+"criteriopromocion/"+tipo+"/new",function(data){
            $("#tabs1-0-0").html(data);            
           
    alerta_principal.html("Listo"); alerta_principal.hide(5000);
    
            
        });        
}
         
function createCriterioAcademicoAno(tipo){
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Creando Criterio Academico. Espere....");
    alerta_principal.show();
   $("#new_criterio_promocion").submit(function(){             
          $.ajax({
            type:"POST",
            url:entorno+"criteriopromocion/"+tipo+"/create",
            dataType:"html",
            data:$(this).serialize(),
            beforeSend:function(){                 
              $("#loading").show();
            },
            success:function(response){
                alerta_principal.html("Listo.");                
                indexCriterioAcademicoAno()
            }

          })
          return false;
        }) 
}
function deleteCriterioAcademicoAno(id){
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Eliminando Criterio Academico. Espere....");
    alerta_principal.show();
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
                alerta_principal.html("Listo.");                
                indexCriterioAcademicoAno()
            }

          })
          return false;
        }) 

}

function agregarCriterioAcademicoAno(id){
    simbolo=$("#simbolo_separador"+id).val();
    id_hijo=$("#criterio_hijo"+id).val();
    id_padre=$("#criterio_padre"+id).val();    
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Agregando Criterio academico. Espere....");
    alerta_principal.show();
    $.post(entorno+"criteriopromocion/"+id_padre+'/'+id_hijo+'/'+simbolo+"/unir",function(data){
            $("#tabs1-0-0").html(data);            
           
    alerta_principal.html("Listo"); alerta_principal.hide(5000);
    indexCriterioAcademicoAno();
            
        });        
}


