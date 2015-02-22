
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
function showMensajeinfoAcademicaDefectoAno(id,id_mensaje_usuario){
    
    $.post(entorno+"mensajeusuario/"+id_mensaje_usuario+"/leido");                                  
    $.get(entorno+"mensaje/"+id+"/show",function(data){
            $("#contenido_principal").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            
        });        
}

function indexMensajeinfoAcademicaDefectoAno(page){ 
    
    $.get(entorno+"mensajeusuario/",{page:page},function(data){
            $("#contenido_principal").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            
        });        
}
function indexMensajeEnviadosinfoAcademicaDefectoAno(page){ 
    
    $.get(entorno+"mensajeusuario/enviados",{page:page},function(data){
            $("#contenido_principal").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            
        });        
}

function editarDimensioninfoAcademicaDefectoAno(tipo,id){
    tipo_global=tipo;
    $.get(entorno+"dimension/"+id+"/edit",function(data){
            $("#_tabs1-"+tipo).html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            
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
            });
            
            
        });        
}
function newMensajeinfoAcademicaDefectoAno(){
    $.post(entorno+"mensaje/new",function(data){
            $("#contenido_principal").html(data);            
            $("#flass_tmp").html("<span>listo!!!</span>");
            
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
    $.post(entorno+"dimension/"+tipo+"/create",data,function(data_){
            $.get(entorno+"dimension/"+tipo,function(data){
                $("#_tabs1-"+tipo).html(data);            
                $("#flass_tmp").html("<span>listo!!!</span>");
            });
            
            
        });        
}
         
function deleteMensajeUsuarioinfoAcademicaDefectoAno(id,page){
    _token=$("div#"+id+" div input#form__token").val();                 
    var data = {
                form:{
                    id: id,
                    _token: _token                
                }
            }; 
    
    $.post(entorno+"mensajeusuario/"+id+"/delete",data,function(){
            indexMensajeinfoAcademicaDefectoAno();            
    });        
}
function getNumerosMensajesLeidosTipo()
{
    $.post(entorno+"mensajeusuario/numeromensaje",function(data){
            
            var nro_mensajes = jQuery.parseJSON(data);   
            
            if(nro_mensajes.mensajes_importantes!=0)
                $("#numero_mensajes_importante").html(nro_mensajes.mensajes_importantes);
            else
                $("#numero_mensajes_importante").hide();
            if(nro_mensajes.mensajes_informaciones!=0)
                $("#numero_mensajes_info").html(nro_mensajes.mensajes_informaciones);
            else
                $("#numero_mensajes_info").hide();
            if(nro_mensajes.mensajes_felicitaciones!=0)
                $("#numero_mensajes_felicitaciones").html(nro_mensajes.mensajes_felicitaciones);
            else
                $("#numero_mensajes_felicitaciones").hide();
            if(nro_mensajes.mensajes_boletines!=0)
                $("#numero_mensajes_boletines").html(nro_mensajes.mensajes_boletines);
            else
                $("#numero_mensajes_boletines").hide();
            $("#cont_nro_mensajes").show();
                
    });
    url=document.URL;
    uri_carga_academica=url.search('grupo/calificarr');
    if(uri_carga_academica>0){
        if($("#asignatura_grupo").val()!='*' && $("#periodo_calificar_nota").val()!='*')
            listaAlumnosGrupoAsignaturaPeriodoInacholee();
    }
  
    
    return;
}

function filtroUsuarioMensaje(e){ 
 
}

function removenull(str) {
    var new_str = str;
    if (str == '') {
        new_str = str.replace('', "N/A");
    }
    else if (str == null) {
        new_str = "N/A";
    }

    return new_str;
}

function eliminar_desitario(e){
    
    $(e).parent().remove();
}
function procesarDejadaFocusDestinotemporal(){        
    destinos=$("#ntp_inacholeebundle_mensajetype_destinot").val();
    if(destinos!=""){        
        destinos=destinos+";";
        
    }
    destinos+=$("#span_destino").html();
    destinos=destinos.replace(/"/g,""); 
    $("#ntp_inacholeebundle_mensajetype_destino").val(destinos);
    
}