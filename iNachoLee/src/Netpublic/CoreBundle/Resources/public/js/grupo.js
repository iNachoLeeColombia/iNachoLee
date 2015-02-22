
//tipo_global=0;
////////Grupo de un Colegio
///////
/////
///
//
//
///
/////
///////
////////
function showGrupoinfoAcademicaDefectoAno(id){  
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Detalles Grupo. Espere....");
    alerta_principal.show();
    $.get(entorno+"grupo/"+id+"/show",function(data){
            $("#tabs5-0").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
               
    alerta_principal.html("Listo"); alerta_principal.hide(5000);
   
        });        
}

function indexGrupoinfoAcademicaDefectoAno(){ 
    mostrarMensajeNotificador("Cargando lista de grupos.");
    $.get(entorno+"grupo/",function(data){
            $("#grupo").html(data);            
           ocultarMensajeNotificador()
        });  
    return;    
}

function editarGrupoinfoAcademicaDefectoAno(id){
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Interfaz para Editar Grupo . Espere....");
    alerta_principal.show();
    $.get(entorno+"grupo/"+id+"/edit",function(data){
            $("#grupo").html(data);            
            
    alerta_principal.html("Listo"); alerta_principal.hide(5000);
 
            
        });        
}
function updateGrupoinfoAcademicaDefectoAno(id){
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
    mostrarMensajeNotificador("Actualizando grupo. ");
    $.post(entorno+"grupo/"+id+"/update",data,function(data){
            $.post(entorno+"grupo/",data,function(data){
                $("#grupo").html(data);
                indexGrupoinfoAcademicaDefectoAno();
                ocultarMensajeNotificador();
            });
            
            
        });        
}
function newGrupoinfoAcademicaDefectoAno(){
    mostrarMensajeNotificador("Cargando." );
    $.post(entorno+"grupo/new",function(data){
            $("#grupo").html(data);            
           ocultarMensajeNotificador();
    });        
}
         
function createGrupoinfoAcademicaDefectoAno(tipo){
    nombres=new Array();
    nombre=$(".nombres").each(function(i){
        $this=$(this);
        console.info($this.val());
        nombres[i]=$this.val();
    }); 
    createGrupoAuxiliar(nombres,0,tipo);
}
function createGrupoAuxiliar(nombres,index,tipo){
    grado=$("#select_new_grado").val();
    data={
        'nombre':nombres[index],
        'grado':grado
    };
    $.post(entorno+"grupo/create",data,function(data){
        if(index+1>nombres.length-1){
            ocultarMensajeNotificador();
            console.info("Terminamos de adicionar");
            if(tipo==2)
                newGrupoinfoAcademicaDefectoAno();
            else
                indexGrupoinfoAcademicaDefectoAno();
            return;
        } 
        createGrupoAuxiliar(nombres,index+1,tipo);
    });
    
}
function createnewGrupoinfoAcademicaDefectoAno(){
    createGrupoinfoAcademicaDefectoAno(2);   
     
}

function deleteGrupoinfoAcademicaDefectoAno(id){
   //*****************************************
   //Formulario Nuevo Periodo Academico********
    alerta_principal=$("#alerta_principal");
    alerta_principal.html("Borrando Grupo. Espere....");
    alerta_principal.show()
        $("#form_"+id).submit(function(){             
              $.ajax({
                type:"POST",
                url:entorno+'grupo/'+id+'/delete',
                dataType:"html",
                data:$(this).serialize(),
                beforeSend:function(){                        
                    
                },
                success:function(response){           
                   indexGrupoinfoAcademicaDefectoAno();
                   alerta_principal.html("Listo");
                   alerta_principal.hide(5000);
               }

                })
          return false;
        }); 
}
function actualizarEditarGrupo(sede_id,html){
    $btn=$("#btn_"+sede_id);
    $span=$("#span_"+sede_id);
    $input=$("#input_"+sede_id);
    grado=$("#select_new_grado").val();
    nombre_sede=$span.val();
    nuevo_nombre=$input.val();
    
    if($btn.html()=='cambiar nombre corto'){
        $span.html(html);
        $btn.html('actualizar nombre corto');
    }
    else{
        data={
            'nombre_corto': nuevo_nombre,
            'sede_id': sede_id,
            'grado_id': grado
        };
        $.post(entorno+"colegio/actualizarnombrecorto",data,function(data){
            $("#container-nuevo-grupo").html(data);
            
            $btn.html('cambiar nombre corto');
            
        });
    }
    
}
function procesarSeleccionGradoGrupo(){
    $grado=$("#select_new_grado");
    $.post(entorno+"grupo/"+$grado.val()+"/newgrupo",function(data){
        $("#container-nuevo-grupo").html(data);
        $("#container-nuevo-grupo").show();
    });
}
function procesarNroGruposGrado(sede_id){
    $grado=$("#select_new_grado");                   
    nro_grupos=$("#input_sede_"+sede_id).val();
    if(nro_grupos!="")
    $.post(entorno+"grupo/"+$grado.val()+"/"+nro_grupos+"/"+sede_id+"/newvariosgrupo",function(data){
        $("#container-varios-grupos-"+sede_id).html(data);
        $("#container-varios-grupos-"+sede_id).show();
    });
}
function procesarCheckedNuevoGrupo(e,sede_id){
    $id=$(e);
    $c=$("#container-info-sede-nuevo-grupo-"+sede_id);
    if($id.is(':checked')){
        $c.show();
        $(".nombres_"+sede_id).each(function(){
            $(this).addClass('nombres');
        });
    }
    else{
        $c.hide();
        $(".nombres_"+sede_id).each(function(){
            $(this).removeClass('nombres');
        });
    }
}
