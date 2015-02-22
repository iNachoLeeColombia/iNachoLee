
tipo_global=0;
////////Asignatura
///////
/////
///
//
//
///
/////
///////
////////
function showAsignaturainfoAcademicaDefectoAno(id,tipo){
    tipo_global=tipo;
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Detalles Asignatura|Area.. Espere....");
    alerta_principal.show();
    $.get(entorno+"asignatura/"+id+"/"+tipo+"/show",function(data){
            $("#tabs2-"+tipo).html(data);                         
             alerta_principal.html("Listo"); alerta_principal.hide(5000);
   
            
        });        
}

function indexAsignaturainfoAcademicaDefectoAno(tipo){
    if(tipo==2)
        grado=$("#filtros_asignaturas_grados").val();
    else
        grado=$("#filtros_areas_grados").val();
    if(grado==null){
       grado=0;
    }
    if(tipo==2)
    $.get(entorno+"asignatura/"+tipo+"/"+grado,function(data){
            $("#asignatura_show").html(data);            
        }); 
    if(tipo==1)
    $.get(entorno+"asignatura/"+tipo+"/"+grado,function(data){
            $("#area_show").html(data);            
        }); 
        
        
}
         
function editarAsignaturainfoAcademicaDefectoAno(id,tipo){
    tipo_global=tipo;
    if(tipo==2)
    $.get(entorno+"asignatura/"+id+"/"+tipo+"/edit",function(data){
            $("#asignatura_show").html(data);            
           });
    if(tipo==1)
    $.get(entorno+"asignatura/"+id+"/"+tipo+"/edit",function(data){
            $("#area_show").html(data);            
             });        
   
}
function updateAsignaturainfoAcademicaDefectoAno(id,tipo){
       //*****************************************
   $("#edit_form_asignatura").submit(function(){             
          $.ajax({
            type:"POST",
            url:entorno+"asignatura/"+id+"/"+tipo+"/update",
            dataType:"html",
            data:$(this).serialize(),
            beforeSend:function(){
            },
            success:function(response){
                indexAsignaturainfoAcademicaDefectoAno(tipo)
            }

          })
          return false;
        }) 
}        
function newAsignaturainfoAcademicaDefectoAno(tipo){
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Interfaz .......................para Nueva Area|Asignatura .. Espere....");
    alerta_principal.show();
    $.post(entorno+"asignatura/"+tipo+"/new",function(data){
            if(tipo===1)
                $("#area_show").html(data); 
            else
            $("#asignatura_show").html(data);            
           
    alerta_principal.html("Listo.");
  
            
        });        
}


function createAsignaturainfoAcademicaDefectoAno(tipo,new_index){
    nombre_area=$('#nombre_area').val();
    grado_id=$("#select_new_area").val();
    duracion=$("#horas_duracion").val();
    asgs=new Array();
    f_asgs=new Array();
    data={
        'nombre_area':nombre_area,
        'grado_id': grado_id,
        'duracion': duracion        
    };
    $.post(entorno+"asignatura/"+tipo+"/create",data,function(data){
        $area_id=data;
        $(".nombre_asg").each(function(i){
            asgs[i]=$(this).val();
        });
        $(".f_asg").each(function(i){
            f_asgs[i]=$(this).val();
        });
        auxiliarAgregarAsg(asgs,f_asgs,0,2,data,new_index);
    });    
}
function auxiliarAgregarAsg(asgs,f_asgs,index,tipo,area_id,new_index){
    grado_id=$("#select_new_area").val();
    data={
        'area_id': area_id,
        'grado_id': grado_id,
        'nombre_asg': asgs[index],
        'frecuencia': f_asgs[index]
    };
    $.post(entorno+"asignatura/"+tipo+"/create",data,function(data){
        if(index+1>asgs.length-1){
            ocultarMensajeNotificador();
            console.info("Terminamos de adicionar");
            if (new_index==1){
                indexAsignaturainfoAcademicaDefectoAno(1); 
            }
            else
                newAsignaturainfoAcademicaDefectoAno(1);
            return;
        } 
        auxiliarAgregarAsg(asgs,f_asgs,index+1,tipo,area_id,new_index);
           
    });
    
}
         
function createnewAsignaturainfoAcademicaDefectoAno(tipo,new_index){
    createAsignaturainfoAcademicaDefectoAno(tipo,new_index);   
}
         
function deleteAsignaturainfoAcademicaDefectoAno(id,tipo){
        //*****************************************
   //Formulario Nuevo Periodo Academico********
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Borrando Asignatura. Espere....");
    alerta_principal.show()
        $("#form_"+id).submit(function(){             
              $.ajax({
                type:"POST",
                url:entorno+'asignatura/'+id+"/"+tipo+'/delete',
                dataType:"html",
                data:$(this).serialize(),
                beforeSend:function(){                        
                    
                },
                success:function(response){           
                    indexAsignaturainfoAcademicaDefectoAno(tipo);    
                   alerta_principal.html("Listo");
                   alerta_principal.hide(5000);
               }

                })
          return false;
        }); 
  
      //********************************************** 

}
function procesarAgregarAsg(){
    nro_asg=$("#nro_asg").val();
    html='';
    for (i=1;i<=nro_asg;i++){
        html+='<label>Asignatura'+i+'</label>';
        html+='<input class="nombre_asg" type="text" ><input style="width: 40px;" class="f_asg" type="text" value="1" ><span style="background-color: yellow;font-size: 9px;">Numero de veces en la semana</span><br/>'
    }
    $("#container-nuevo-area").html(html);
}
function procesarPrimerAsg(){
    nombre_area=$("#nombre_area").val();
    $asgs=$(".nombre_asg").each(function(i){
        if(i==0){
            $(this).val(nombre_area);
        }
    });
    
}
