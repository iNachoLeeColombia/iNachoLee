
tipo_global=0;
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
function showinfoAcademicaDefectoAno(tipo,id){
    tipo_global=tipo;
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Detalles de Dimension. Espere....");
    alerta_principal.show();
    $.get(entorno+"dimension/"+id+"/show",function(data){
            if(tipo ==1)
                $("#tabs"+tipo+"-1").html(data);
            else if(tipo==2){
                $("#tabs"+tipo+"-1").html(data);                
            }
            else if(tipo==3){
                $("#tabs"+tipo+"-1").html(data);                
            }
            else if(tipo==4){
               capa_ram_actividades_desempenos_calificar_nota=$("#capa_ram_actividades_desempenos_calificar_nota");
                capa_ram_actividades_desempenos_calificar_nota.show();
                capa_ram_actividades_desempenos_calificar_nota.html(data);
            }else if(tipo==6){
                $("#tabs1-2").html(data);                
            }
            
            else    
                $("#tabs1-"+tipo).html(data);            
          
    alerta_principal.html("Listo"); alerta_principal.hide(5000);
   
            
        });        
}

function indexinfoAcademicaDefectoAno(tipo){ 
    mostrarMensajeNotificador("Cargando ");
    tipo_global=tipo;
    $.get(entorno+"dimension/"+tipo,helperindexinfoAcademicaDefectoAno);        
}
function helperindexinfoAcademicaDefectoAno(data){
     tipo=tipo_global;
   
            if(tipo ==1){
                $("#profile").html(data);
            }
            else if(tipo==2){
               $("#tabs"+tipo+"-1").html(data);
            }
            else if(tipo==3){
               $("#tabs"+tipo+"-1").html(data);
            }
            else if(tipo==4){
                capa_ram_actividades_desempenos_calificar_nota=$("#capa_ram_actividades_desempenos_calificar_nota");
                capa_ram_actividades_desempenos_calificar_nota.show();
                capa_ram_actividades_desempenos_calificar_nota.html(data);
              
            }
            else if(tipo==6){
               
               $("#tabs1"+"-2").html(data);
            }
            else{    
                $("#home").html(data);               
               
            }
            
    alerta_principal.html("Listo"); alerta_principal.hide(5000);
   
            
}
        
function editarinfoAcademicaDefectoAno(tipo,id){
    tipo_global=tipo;
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Interfaz para Editar Dimension. Espere....");
    alerta_principal.show();
    $.get(entorno+"dimension/"+id+"/"+tipo+"/edit",function(data){
             if(tipo ==1){
                $("#profile").html(data);
            }
            else if(tipo==2){
               $("#tabs"+tipo+"-1").html(data);
            }
            else if(tipo==3){
               $("#tabs"+tipo+"-1").html(data);
            }
            else if(tipo==4){
                capa_ram_actividades_desempenos_calificar_nota=$("#capa_ram_actividades_desempenos_calificar_nota");
                capa_ram_actividades_desempenos_calificar_nota.show();
                capa_ram_actividades_desempenos_calificar_nota.html(data);
            }
            else if(tipo==6){
               $("#tabs1-2").html(data);
            }
            else{    
                $("#home").html(data);               
               
            }
            
    alerta_principal.html("Listo"); alerta_principal.hide(5000);
    
            
        });        
}
function updateinfoAcademicaDefectoAno(id,tipo){
    //*****************************************
   //Formulario Nuevo Periodo Academico********
  
        $("#form_newDimencion").submit(function(){             
              $.ajax({
                type:"POST",
                url:entorno+"dimension/"+id+"/"+tipo+"/update",
                dataType:"html",
                data:$(this).serialize(),
                beforeSend:function(){                        
                    
                },
                success:function(response){          
                   indexinfoAcademicaDefectoAno(tipo);
                }

                })
          return false;
        }); 
  
      //**********************************************   
        
}
function newinfoAcademicaDefectoAno(tipo){
     alerta_principal=$("#alerta_principal");
               alerta_principal.html("Cargdando para ssssssssssssnueva Dimension. Espere.....");
                alerta_principal.show();    
      
    $.post(entorno+"dimension/"+tipo+"/new",function(data){
             if(tipo ==1){
                $("#profile").html(data);
            }
            else if(tipo==2){
               $("#tabs"+tipo+"-1").html(data);
            }
            else if(tipo==3){
               $("#tabs"+tipo+"-1").html(data);
            }
            else if(tipo==4){
              
                  $("#caja_herramientas_calificar").hide();   
                $("#_tabs9-2").html(data);                                
                cr_a_d=$("#capa_ram_actividades_desempenos_calificar_nota")
                cr_a_d.html(data);
                getDimSuperiorAcademicosAnoEscolar_doble('periodo_calificar_nota','dimension_padre');
                cr_a_d.show("slow");
               
                
            }
            else if(tipo==6){
               $("#tabs1"+"-2").html(data);
            }
            else{    
                $("#home").html(data);               
                $("#flass_tmp").html("<span>listo!!!</span>");
            }
             alerta_principal.html("Listo.");
        });        
}
         
function createinfoAcademicaDefectoAno(){
      tipo=$("#tipo").val();
    if(tipo==4){  
    nombre=  $("#dimension_nombre").val();
    porcentaje=$("#dimension_ponderado").val();
    padre=$("#dimension_padre").val();
    grupo=$("#dimension_grupo").val();
    if(nombre==''){
        alert("La Dimension deberia tener un NOMBRE.");
        return false;
    }
    
    if(porcentaje==''){
        alert("La Dimension deberia tener una PORCENTAJE.");
        return false;
    }
    if(padre=='*'){
        alert("Por favor Seleccione La Dimension Superior.");
        return 1;
    }
    if(grupo==null){
        alert("Por favor Seleccione el Grupo(s) De la dimension.");
        return 1;
    }
}
   //*****************************************
   //Formulario Nuevo Periodo Academico********
     
   alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Guardando Actividad. Espere....");
    alerta_principal.show();
   $("#form_newDimencion").submit(function(){             
          $.ajax({
            type:"POST",
            url:entorno+'dimension/'+tipo+'/create',
            dataType:"html",
            data:$(this).serialize(),
            beforeSend:function(){
              nombre=$("#dimension_nombre").val();
              if(tipo==0){        
                if(isNaN(nombre)){
                    alert("Ingrese un Año en Numeros(Ej:2013)");
                    return;
                }        
                if(nombre <= 2010){
                    alert("Debe ser un Año Mayor a 2012");
                    return;
                }        
              }  
              $("#loading").show();
            },
            success:function(response){
                if(tipo==4){
                 alerta_principal.html("Cargando lista de Estudiante. Espere....");    
                 $.post(entorno+"grupo/calificareditar",helperactualizarAllNotasAlumnoGrupo);              
                cr_a_d=$("#capa_ram_actividades_desempenos_calificar_nota")
                cr_a_d.hide("slow");
                cr_a_d.html("");
                  
    alerta_principal.html("Listo.");
    
                
            }
            $.get(entorno+"dimension/"+tipo,function(data){
                 if(tipo==4){                   
                   cr_a_d.hide("slow");
                   cr_a_d.html("");
                 } 
                 else if(tipo==6){                   
                   $("#tabs1-2").html(data);             
                    
                 }
                 else if(tipo ==1){
                      $("#profile").html(data);
                 }
                 else    
                    $("#home").html(data);
                   
    alerta_principal.html("Listo.");
    
                    
            });
                $("#response").html(response);
                $("#loading").hide();
            }

          })
          return false;
        }) 
      //**********************************************
      return 1;
}
function createnewinfoAcademicaDefectoAno(){
      tipo=$("#tipo").val();
    if(tipo==4){  
    nombre=  $("#dimension_nombre").val();
    porcentaje=$("#dimension_ponderado").val();
    padre=$("#dimension_padre").val();
    grupo=$("#dimension_grupo").val();
    if(nombre==''){
        alert("La Dimension deberia tener un NOMBRE.");
        return false;
    }
    
    if(porcentaje==''){
        alert("La Dimension deberia tener una PORCENTAJE.");
        return false;
    }
    if(padre=='*'){
        alert("Por favor Seleccione La Dimension Superior.");
        return 1;
    }
    if(grupo==null){
        alert("Por favor Seleccione el Grupo(s) De la dimension.");
        return 1;
    }
}
   //*****************************************
   //Formulario Nuevo Periodo Academico********
     
   alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Guardando Actividad. Espere....");
    alerta_principal.show();
   $("#form_newDimencion").submit(function(){             
          $.ajax({
            type:"POST",
            url:entorno+'dimension/'+tipo+'/create',
            dataType:"html",
            data:$(this).serialize(),
            beforeSend:function(){
              nombre=$("#dimension_nombre").val();
              if(tipo==0){        
                if(isNaN(nombre)){
                    alert("Ingrese un Año en Numeros(Ej:2013)");
                    return;
                }        
                if(nombre <= 2010){
                    alert("Debe ser un Año Mayor a 2012");
                    return;
                }        
              }  
              $("#loading").show();
            },
            success:function(response){
                newinfoAcademicaDefectoAno(tipo);
                
                
            }

          })
          return false;
        }) 
      //**********************************************
      return 1;
}

function deleteinfoAcademicaDefectoAno(e){
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Eliminando Actividad. Espere....");
    alerta_principal.show();
    $.post(entorno+"dimension/"+e+"/delete",function(data){
            if(tipo >1)
                $("#tabs"+tipo+"-1").html(data);
            else    
                $("#tabs1-"+tipo).html(data);
               
    alerta_principal.html("Listo"); alerta_principal.hide(5000);
    
            
        });        
}
function calificarinfoAcademicaDefectoAno(tipo,id){
    
    $.post(entorno+"dimension/"+e+"/delete",function(data){
            if(tipo >1)
                $("#tabs"+tipo+"-1").html(data);
            else    
                $("#tabs1-"+tipo).html(data);         
            
            
        });        
}
function mostrarCriterioDePromocionColegio(){
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando lista de Criterios. Espere....");
    alerta_principal.show();
    $.post(entorno+"colegio/criteriospromocion",function(data){
        $("#contenido_principal").html(data);
        alerta_principal.html("Listo"); alerta_principal.hide(5000);
            
        });        
}

function getGruposGradosCriterioPromocion(id_grado,nro_grupos){
    grado_sig=$("#grado_cp"+id_grado).val();
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Grupos. Espere....");
    alerta_principal.show();
    $.post(entorno+"grupo/"+grado_sig+'/'+nro_grupos+'/getgrupocriteriopromocion',function(data){
        $("#capa_criterio"+id_grado).html(data);
        alerta_principal.html("Listo"); alerta_principal.hide(5000);
            
        }); 
    
}
function promoverGradosColegio(accion){
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Actualizan Criterios. Espere....");
    alerta_principal.show();
    
     var ids = new Array();
     var ids_grupo_promocion=new Array();
     var grupo_promocion_siguiente=new Array();
     var cp_perdida = new Array();		
     var cp_habilita = new Array();		
     var cp_grado_siguiente = new Array();		
     input_hidden=$("input.ids_grupo_promocion");
     if(input_hidden.length>0){
        input_hidden.each(function(i){            i
                 if($(this).is(':checked')){
                    id_grupo = this.getAttribute('data-id');	                
                    ids_grupo_promocion.push(parseInt(id_grupo));
                    grupo_promocion_siguiente.push(parseInt($("#grupo_promovido_siguiente"+id_grupo).val()));
                 }
            
        });
        
        var json_ids_grupo_promocion = $.toJSON(ids_grupo_promocion);      
        var json_value_grupo_siguiente = $.toJSON(grupo_promocion_siguiente);      

     }
     
     checks=$("input.criterios_promocion");
     if(checks.length>0){
        checks.each(function(i){
            if($(this).is(':checked')){
                s = this.getAttribute('data-id');	                
                ids.push(parseInt(s));
                cp_perdida.push(parseInt($("#criterios_promocion_pierde"+s).val()));
                cp_habilita.push(parseInt($("#criterios_promocion_habilitar"+s).val()));
                cp_grado_siguiente.push(parseInt($("#criterios_promocion_grado"+s).val()));
            }
        });
        
        var json_perdida = $.toJSON(cp_perdida);      
        var json_ids = $.toJSON(ids);      
        var json_habilita = $.toJSON(cp_habilita);      
        var json_grado_siguiente = $.toJSON(cp_grado_siguiente);      
        //Tomamos ano escolar a promver
        ano_escolar_promover=$("#ano_escolar_promover").val();
        if(ano_escolar_promover=='0'){
            alert("Por favor Seleccione Año escolar a PROMOVER");
            return;
        }
        $.post(entorno+'colegio/gestionarpromover',
        {
            ids_:json_ids,
            perdida:json_perdida,
            habilita:json_habilita,
            grado_sigui:json_grado_siguiente,        
            ids_grupo:json_ids_grupo_promocion,
            value_grupo_siguiente:json_value_grupo_siguiente,
            ano_escolar_promover:ano_escolar_promover,
            accion:accion
        }, function(res){
                $("#capa_ram_criterios_promocions").html(res)
		alerta_principal.html("Listo"); alerta_principal.hide(5000);
		
           
        });      
    

    
}
}

function updateAnoEscolarDefecto(){
    mostrarMensajeNotificador("Cambiando año|periodo");
    ano_escolar_activo=$("#ano_escolar_activo").val();
    periodo_escolar_activo=$("#periodo_escolar_activo").val();
    data={
        'ano_escolar_activo': ano_escolar_activo,
        'periodo_escolar_activo': periodo_escolar_activo       
    };
    $.post(entorno+"colegio/updateconfiguracion",data,function(data){                       
            ocultarMensajeNotificador();
            $("#myModal_generica").modal('hide');
            document.location.href=document.URL;
                                            
            
    });  
        
}

function showConsolidadoColegio(tipo){    
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando. Espere....");
    alerta_principal.show();
    $.post(entorno+"colegio/1/newconsolidado",function(data){                       
            $("#contenido_principal").html(data);
            alerta_principal.html("Listo.");
            alerta_principal.hide();
    }); 
}
function mostrarConsolidadoColegio(tipo){
        
        $.post(entorno+"colegio/1/newconsolidadoajax",function(data){                       
            $("#capa_ram_consolidado").html(data);
            alerta_principal.html("Listo.");
            alerta_principal.hide();
         $("#iconos_formatos").show();
         $("#capa_grados_consolidado").show();
        alerta_principal=$("#alerta_principal");    
        alerta_principal.html("Cargando Consolidado. Espere....");
        alerta_principal.show();
                   
        sede_id=$("#sede_id").val();
        
        $.post(entorno+"colegio/1/consolidado.json",{sede: sede_id},function(data){                       
    
        txtattr1 = { font: "7px sans-serif" };
         //for (j=0;j<ids_grados.length;j++){
                x_grados=eval(data);               
            
             
             
          for(j=0;j<x_grados.length;j++){ 
               off_set_y=0;  
              off_set_x=30;
                     var r = Raphael("grado_"+x_grados[j][2]),
                    fin = function () {
                        this.flag = r.popup(this.bar.x, this.bar.y, this.bar.value+" alumnos" || "No Hay Estudiantes").insertBefore(this);                       
                    },
                    fout = function () {
                        this.flag.animate({opacity: 0}, 300, function () {this.remove();});
                    },
                    
                    
                    txtattr1 = { font: "10px sans-serif",fill: '#000000' };
                

              
              
             
             for (var i=0;i<x_grados[j][1].length;i++){
                 
                 //values                 
                 if(i%4==0 && i!=0){
                    off_set_x=30;
                    off_set_y=off_set_y+200;
                 }                 
                 var c = r.barchart(10+off_set_x, 60+off_set_y, 100, 190,x_grados[j][1][i][1], {stacked: false, type: "round",colors:["#2F69BF","#A2BF2F","#BFA22F","#BF5A2F","#BF2F2F"]}).hover(fin, fout);                 
                 r.text(65+30+off_set_x, 50+60+off_set_y,x_grados[j][1][i][0]+"(--"+x_grados[j][0]+")" ).attr(txtattr1);
                 off_set_x=off_set_x+180;
                 
                 
             }
          }
             
         //}  
        
       alerta_principal.html("Listo");
       alerta_principal.hide();    
        }); 
      });   
              
}
function actualizarSedeConsolidadoColegio(){
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cambiando Sede. Espere....");
    alerta_principal.show();
    sede=$("#sede").val();
    $.post(entorno+"colegio/"+sede+"/actualizarsedeconsoldato",function(data){                       
            
            alerta_principal.html("Listo.");
            alerta_principal.hide();
    }); 
}
function actualizarGrupoConsolidadoColegio(){
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cambiando Sede. Espere....");
    alerta_principal.show();
    sede=$("#grupo").val();
    $.post(entorno+"colegio/"+sede+"/actualizargrupoconsoldato",function(data){                       
            
            alerta_principal.html("Listo.");
            alerta_principal.hide();
    }); 
}

function mostrarConsolidadoColegioHTML(){
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Consolidado De Eficiencia. Espere....");
    alerta_principal.show();    
    $.post(entorno+"colegio/1/consolidado.html",{sede: 1},function(data){     
            $("#capa_ram_consolidado").html(data);
            alerta_principal.html("Listo.");
            alerta_principal.hide();
    }); 
    
}
function mostrarConsolidadoAsgColegioHTML(){
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Consolidado De Asignaturas Perdidas. Espere....");
    alerta_principal.show();
            $("#capa_ram_consolidado").css("height","10000");      

    $.post(entorno+"colegio/1/consolidadoasignaturas.json",function(data){ 
        datos=eval(data);
        
        valores_asg_perdidas=datos[0];
        valores_grupos=datos[1];
        //valores_labels=datos[2];
        
        labels=datos[2];
        //console.log(valores_asg_perdidas);
        
        var r = Raphael("capa_ram_consolidado");
        dy_texto=100;
        dy_grafico=0;
        anchura=350*valores_grupos.length;
        console.log(valores_grupos.length);
        for (i=0;i<valores_grupos.length;i++){
                    
                    pie = r.piechart(500, 240+dy_grafico, 100,valores_asg_perdidas[i], { legend: [labels[i][0],labels[i][1], labels[i][2],labels[i][3],labels[i][4],labels[i][5]], legendpos: "west", href: ["http://inacholee.com", "http://g.raphaeljs.com"]});

                r.text(320, dy_texto, "Numero De Asignaturas Perdidas X "+valores_grupos[i]).attr({ font: "20px sans-serif" });
                pie.hover(function () {
                    this.sector.stop();
                    this.sector.scale(1.1, 1.1, this.cx, this.cy);

                    if (this.label) {
                        this.label[0].stop();
                        this.label[0].attr({ r: 7.5 });
                        this.label[1].attr({ "font-weight": 800 });
                    }
                }, function () {
                    this.sector.animate({ transform: 's1 1 ' + this.cx + ' ' + this.cy }, 500, "bounce");

                    if (this.label) {
                        this.label[0].animate({ r: 5 }, 500, "bounce");
                        this.label[1].attr({ "font-weight": 400 });
                    }
                });
                dy_texto=300+dy_texto;
                dy_grafico=300+dy_grafico;
                
        }
        
                
                alerta_principal.hide();
    }); 
}
function mostrarConsolidadoLibroFinalColegio(){
    alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Consolidado Libro Final. Espere....");
    alerta_principal.show();
    $.post(entorno+"colegio/1/librofinal.json",function(data){ 
        datos=eval(data);        
        valores=datos[0];
        labels=datos[1];
         var r = Raphael("capa_ram_consolidado"),
                    pie = r.piechart(500, 240, 100,valores, { legend: [labels[0],labels[1], labels[2],labels[3],labels[4],labels[5]], legendpos: "west", href: ["http://inacholee.com", "http://g.raphaeljs.com"]});

                r.text(320, 100, "Numero De Asignaturas Perdidas X Grado ").attr({ font: "20px sans-serif" });
                pie.hover(function () {
                    this.sector.stop();
                    this.sector.scale(1.1, 1.1, this.cx, this.cy);

                    if (this.label) {
                        this.label[0].stop();
                        this.label[0].attr({ r: 7.5 });
                        this.label[1].attr({ "font-weight": 800 });
                    }
                }, function () {
                    this.sector.animate({ transform: 's1 1 ' + this.cx + ' ' + this.cy }, 500, "bounce");

                    if (this.label) {
                        this.label[0].animate({ r: 5 }, 500, "bounce");
                        this.label[1].attr({ "font-weight": 400 });
                    }
                });
                 alerta_principal.hide();
    }); 
}
function mostrarConsolidadoPromediosGruposColegio(){
        alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Consolidado Promedios Grupo. Espere....");
    alerta_principal.show();
        $.post(entorno+"colegio/1/promediogrupos.json",function(data){
             valores=eval(data);
             valores_y=valores[0];
             nombre_grupos=valores[1];
             valores_x=valores[2];
             var r = Raphael("capa_ram_consolidado"),
             txtattr = { font: "18px sans-serif" };
                
              


                r.text(220, 15, "Promedios De Grupos").attr(txtattr);
  
                var lines = r.linechart(70, 70, 700, 340, valores_x, valores_y, { nostroke: false, axis: "0 0 1 1", symbol: "circle", smooth: true });
                             
                lines.symbols.attr({ r: 3 }); 
                
                for (i=0;i<valores_x.length;i++){
                    
                    lines.symbols[0][i].data("grupo",nombre_grupos[valores_y[i]]);
                    lines.symbols[0][i].data("promedio",valores_y[i]);
                    //r.text(lines.symbols[0][i].attrs.cx,lines.symbols[0][i].attrs.cy,nombre_grupos[valores_y[i]]+":"+valores_y[i]).attr(txtattr);                                         
                    lines.symbols[0][i].mouseover(function(){   
                        this.attr({ r: 8 });
                        this.animate({fill: "#FFD700"}, 1000)
                        $("#notificacion_consolidos").html(this.data("grupo")+"  Promedio: "+this.data("promedio"));
                       
                    });
                    lines.symbols[0][i].mouseout(function(){
                         this.attr({ r: 3 });
                        this.animate({fill: "#2F69BF"}, 1000)
                        $("#notificacion_consolidos").html("Ubiquese en Un Punto para ver los VALORES")
                    });                
                    
                }
                
                lines.symbols[0][0].animate({fill: "#759E1A"}, 1000);                
                 
    alerta_principal.hide();
                
        });       
}
function mostrarConsolidadoMejoresAlumnosGruposColegio(){
        alerta_principal=$("#alerta_principal");    
    alerta_principal.html("Cargando Consolidado Mejores Estudiantes Grupo. Espere....");
    alerta_principal.show();
        $.post(entorno+"colegio/1/mejoresalumnosgrupos.json",function(data){
             valores=eval(data);
             puestos=valores[0];
             nombres=valores[1];
             promedios=valores[2];
             grupos=valores[3];
             valores_x=valores[4];
             var r = Raphael("capa_ram_consolidado"),
             txtattr = { font: "18px sans-serif" };                            

                r.text(220, 15, "Mejores Estudiantes").attr(txtattr);  
                var lines = r.linechart(70, 70, 700, 340, valores_x, promedios, { nostroke: false, axis: "0 0 1 1", symbol: "circle", smooth: true });
                             
                lines.symbols.attr({ r: 3 }); 
              
                for (i=0;i<valores_x.length;i++){
                    
                    lines.symbols[0][i].data("grupo",grupos[i]);
                    lines.symbols[0][i].data("promedio",promedios[i]);
                    lines.symbols[0][i].data("nombre",nombres[i]);
                    lines.symbols[0][i].data("puesto",puestos[i]);                    
                    //r.text(lines.symbols[0][i].attrs.cx,lines.symbols[0][i].attrs.cy,nombre_grupos[valores_y[i]]+":"+valores_y[i]).attr(txtattr);                                         
                    lines.symbols[0][i].mouseover(function(){ 
                        this.attr({ r: 8 });
                        this.animate({fill: "#FFD700"}, 1000)
                        $("#notificacion_consolidos").html(this.data("nombre")+this.data("grupo")+"  Promedio: "+this.data("promedio")+"  Puesto: "+this.data("puesto"));
                       
                    });
                    lines.symbols[0][i].mouseout(function(){
                        this.attr({ r: 3 });
                        this.animate({fill: "#2F69BF"}, 1000)
                        $("#notificacion_consolidos").html("Ubiquese en Un Punto para ver los VALORES")
                    });                
                    
                }
                
                lines.symbols[0][0].animate({fill: "#759E1A"}, 1000);                
                 
    alerta_principal.hide();
                
        });       
}
function mostrarPanelPlanillas(){
    mostrarMensajeNotificador("Cargando ");
    $.post(entorno+"colegio/listaplanillas",function(data){     
            $("#sub-container").html(data);
            
            ocultarMensajeNotificador();
    }); 
    
}
function mostrarPanelComponentesEvaluacion(){
    $.post(entorno+"colegio/listacomponentes",function(data){     
            $("#contenido_principal").html(data);
            alerta_principal.html("Listo.");
            alerta_principal.hide();
    }); 
    
}
function procesarFiltrosVerPlanillas(){
    sede=$("#sedes_filtro_usuario").val();
    grado=$("#grado_filtro_usuario").val();
    grupo=$("#ntp_inacholeebundle_type_grupos").val();
    asignatura=$("#ntp_inacholeebundle_contratotype_asignatura").val();
    query=$("#input_query").val();
    
    
    data={
      'sede':sede,
      'grado':grado,
      'grupo':grupo,
      'asignatura':asignatura,
      'query':query
    };
    $.post(entorno+"cargaacademica/buscarplanillas",data,function(data){     
            $("#capa_ram_buscar_planilas").html(data);
            alerta_principal.html("Listo.");
            alerta_principal.hide();
    }); 
    
}
function procesarFiltrosVerComponentes(){
    sede=$("#sedes_filtro_usuario").val();
    grado=$("#grado_filtro_usuario").val();
    grupo=$("#ntp_inacholeebundle_type_grupos").val();
    query=$("#input_query").val();
    if(query==''){
        query='*';
    }
    data={
      'sede':sede,
      'grado':grado,
      'grupo':grupo,
      'query':query
    };
    mostrarMensajeNotificador("Cargando.")
    $.post(entorno+"cargaacademica/buscarcomponentes",data,function(data){
        
            $("#capa_ram_buscar_planilas").html(data);
            ocultarMensajeNotificador();
              }); 
    
}
function procesarFiltrosInformePromover(){
    mostrarMensajeNotificador("Cargando alumnos.");
    sede=$("#sede").val();
    grado=$("#grado_filtro_usuario").val();
    grupo=$("#ntp_inacholeebundle_type_grupos").val();
    asignatura=$("#ntp_inacholeebundle_contratotype_asignatura").val();
    query=$("#input_query").val();
    
    
    data={
      'sede':sede,
      'grado':grado,
      'grupo':grupo,
      'asignatura':asignatura,
      'query':query
    };
    $.post(entorno+"cargaacademica/buscarplanillas",data,function(data){     
            $("#capa_ram_buscar_planilas").html(data);
            ocultarMensajeNotificador();
    }); 
    
}

function mostrarDetallesProfesorGestorComp(id){
    mostrarMensajeNotificador("Cargando.")
    
    $.post(entorno+"cargaacademica/"+id+"/mostrardetallesprofesor",function(data){     
            $("#capa_ram_profesores_componentes"+id).html(data);
            $("#capa_ram_profesores_componentes"+id).show('slow');
            ocultarMensajeNotificador();
    }); 
    
}
function mostrarDetallesProfesorAsignatura(id_ca){
    mostrarMensajeNotificador("Cargando.")
    
    $.post(entorno+"cargaacademica/"+id_ca+"/mostrardetallesprofesorasignatura",function(data){     
            $("#capa_ram_profesores_asignaturas"+id_ca).html(data);
            $("#capa_ram_profesores_asignaturas"+id_ca).show('slow');
            ocultarMensajeNotificador();
           
    }); 
    
}
function mostrarDetallesComponente(id_ca,id_componente){
    tiene=false;
    anchor_detalles_profesor=$("#anchor_mas_detalles_componente"+id_componente);
    if(anchor_detalles_profesor.hasClass('mas_detalles_componente')){
        tiene=true;
    }
    if(tiene){
        anchor_detalles_profesor.removeClass('mas_detalles_componente');
        anchor_detalles_profesor.addClass('menos_detalles_componente');
    }
    else
    {
        anchor_detalles_profesor.removeClass('menos_detalles_componente');
        anchor_detalles_profesor.addClass('mas_detalles_componente');
    
    }
    if(anchor_detalles_profesor.hasClass('mas_detalles_componente')){        
        anchor_detalles_profesor.html("Ver ++");
        $("#capa_ram_profesores_componentes"+id_componente).html(" ");
        $("#capa_ram_profesores_componentes"+id_componente).hide();           
     }
    if(anchor_detalles_profesor.hasClass('menos_detalles_componente')){
       mostrarMensajeNotificador("Cargando.")
    
          $.post(entorno+"cargaacademica/"+id_ca+"/"+id_componente+"/mostrardetallescomponentes",function(data){     
                  $("#capa_ram_profesores_componentes"+id_componente).html(data);
                $("#capa_ram_profesores_componentes"+id_componente).show();
                anchor_detalles_profesor.html("Ver -- --");   
                ocultarMensajeNotificador();
            });         
    }


  
    
}
function mostrarNewComponente(id_ca,id_componente){
    mostrarMensajeNotificador("Cargando.")
    
    $.post(entorno+"cargaacademica/"+id_ca+"/"+id_componente+"/mostrardetallescomponentes",function(data){     
            $("#capa_ram_profesores_componentes"+id_componente).html(data);
            $("#capa_ram_profesores_componentes"+id_componente).show('slow');
            ocultarMensajeNotificador();
           
    }); 
    
}
function verDetallesGrupoGestorPuestos(grupo_id){
    mostrarMensajeNotificador("Cargando.");    
    $.post(entorno+"colegio/"+grupo_id+"/verdetallesgrupopuestos",function(data){     
            $("#capa_ram_mejores_estudiantes"+grupo_id).html(data);
            ocultarMensajeNotificador();
           
    }); 
    
}

function sincronizarNotasPuestos(grupo_id){
    mostrarMensajeNotificador("Cargando.");
    
    $.post(entorno+"colegio/"+grupo_id+"/sincronicarnotaspuestos",function(data){     
            //$("#capa_ram_mejores_estudiantes"+grupo_id).html(data);
           ocultarMensajeNotificador();
           
    }); 
    

}
function mostrarGestorDePublicaciones(){
    mostrarMensajeNotificador("Cargando lista de publicaaciones de Muro. ");    
    $.post(entorno+"auditoria",function(data){     
            $("# sub_container ").html(data);
           ocultarMensajeNotificador();
           
    }); 
    
}
function procesarFuncionesPanel(valor,op){
   $("span.seleccionada_bc3").each(function(){
       if(op=='font_size'){
           $(this).css('font-size',valor+'px');
       }
       if(op=='tipo_letra'){
           //font-family:"Times New Roman",Georgia,Serif;
           $(this).css('font-family',valor);
       }
       if(op=='negrilla'){           
           if($(valor).hasClass('active')){
               $(valor).removeClass('active');
               $(this).css('font-weight',500);
           }
           else{
             $(valor).addClass('active');
             $(this).css('font-weight',900);
           }
       }
       if(op=='cursiva'){           
           if($(valor).hasClass('active')){
               $(valor).removeClass('active');
               $(this).css('font-style','normal');
           }
           else{
             $(valor).addClass('active');
             $(this).css('font-style','italic');
           }
       }
       if(op=='strike'){           
           if($(valor).hasClass('active')){
               $(valor).removeClass('active');
               $(this).css('text-decoration','none');
           }
           else{
             $(valor).addClass('active');
             $(this).css('text-decoration','line-through');
           }
       }
       if(op=='underline'){           
           if($(valor).hasClass('active')){
               $(valor).removeClass('active');
               $(this).css('text-decoration','none');
           }
           else{
             $(valor).addClass('active');
             $(this).css('text-decoration','underline');
           }
       }
       if(op=='justifyleft'){           
           if($(valor).hasClass('active')){
               $(valor).removeClass('active');
               $(this).parent().parent().css('text-align','initial');
           }
           else{
             $("#panel_configuracion div a").each(function(){
                 $(this).removeClass('active');
             });  
             $(valor).addClass('active');
             $(this).parent().parent().css('text-align','lefth');
           }
       }
       if(op=='justifycenter'){           
           if($(valor).hasClass('active')){
               $(valor).removeClass('active');
               $(this).parent().parent().css('text-align','initial');
           }
           else{
             $("#panel_configuracion div a").each(function(){
                 $(this).removeClass('active');
             });  
             $(valor).addClass('active');
             $(this).parent().parent().css('text-align','center');
           }
       }
       if(op=='justifyright'){           
           if($(valor).hasClass('active')){
               $(valor).removeClass('active');
               $(this).parent().parent().css('text-align','initial');
           }
           else{
             $("#panel_configuracion div a").each(function(){
                 $(this).removeClass('active');
             });  
             $(valor).addClass('active');
             $(this).parent().parent().css('text-align','right');
           }
       }
       if(op=='justifyfull'){           
           if($(valor).hasClass('active')){
               $(valor).removeClass('active');
               $(this).parent().parent().css('text-align','initial');
           }
           else{
             $("#panel_configuracion div a").each(function(){
                 $(this).removeClass('active');
             });  
             $(valor).addClass('active');
             $(this).parent().parent().css('text-align','justify');
           }
       }
       if(op=='color_letra'){           
             $(this).css('color',valor);
       }
       if(op=='color_fondo'){           
             $(this).css('background-color',valor);
       } }); 
}

function procesarSobreLabelBc3(e){
    //$(e).css("border","gray solid thin");
    $("#panel_configuracion").show();
    $(e).addClass('activa_bc3')
}
function procesarOutLabelBc3(e){
    //$(e).css("border","none");
    $("#panel_configuracion").show();
    $(e).removeClass('activa_bc3');
}
function procesarClickLabelBc3(e){
    $("span.seleccionada_bc3").each(function (){
        $(this).removeClass('seleccionada_bc3');
    });
    $("span.activa_bc3").each(function (){
        $(this).removeClass('activa_bc3S');
    });
    
    $(e).addClass('seleccionada_bc3');
    
}
function procesarDbClicLabelBc3(e){
    $id=$(e);
    //console.info("--"+e.id);    
    label=e.id.replace("_"+e.getAttribute('data-alumno-id'),"");
    //console.info("4-"+label);
    
    if($('#input_check_certificaciones').is(':checked')){
                referencia_plantilla=20;
                tipo_platilla=1;
            }
            else if($('#input_check_boletin').is(':checked')){
                referencia_plantilla=0;
                if($('#boletin_defecto').is(':checked'))
                    tipo_platilla=1;
                if($('#boletin_prescolar').is(':checked'))
                    tipo_platilla=0;
                if($('#boletin_cormaria').is(':checked'))
                    tipo_platilla=0;
                if($('#boletin_intar').is(':checked'))
                    tipo_platilla=0;
                if($('#boletin_clodomiro').is(':checked'))
                    tipo_platilla=0;
                if($('#boletin_semaforo').is(':checked'))
                    tipo_platilla=0;
                if($('#boletin_caritas').is(':checked'))
                    tipo_platilla=0;
                if($('#boletin_ultimo_informe').is(':checked'))
                    tipo_platilla=0;
             }
            else if($('#input_check_constancia').is(':checked')){
                ;
            }
     if(!$id.hasClass('label_bc3_texto')){
        $.post(entorno+"colegio/"+label+"/"+referencia_plantilla+"/gettag",function(data){  
                html="<input type='text' id=input_"+e.id+" value='"+data+"'  />"
                $(e).html(html);
    
        });
     }
     else{
         if($id.html().indexOf("<input")==-1){
             html="<input type='text' id=input_"+e.id+" value='"+$id.html()+"'  />"
             $(e).html(html);
             console.info("te digo ps");
             
          }
          else{
              $("#input_"+e.id).val($("#input_"+e.id).val());   
         }
    }
 }
$(document).keypress(function(e) {
    if(e.which == 13) {
        procesarGuardarBc3();
    }
});
function procesarEditarBc3(){
    if($("#input_check_boletin").is(':checked')){   
         platilla_id=1
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
    }
    if($("#input_check_constancia").is(':checked')){   
         platilla_id=2
         tipo=0;
    }
    if($("#input_check_certificaciones").is(':checked')){   
         platilla_id=3;
         tipo=0;
    }
    $.post(entorno+"alumno/"+platilla_id+"/"+tipo+"/mostrareditor",function(data){  
            $("#sub-container-right-informe-bc3").html(data);
            ocultarMensajeNotificador();
    }); 
        
}
function procesarGuardarBc3(){
   if($("#input_check_boletin").is(':checked')){   
         platilla_id=1
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
    }
    if($("#input_check_constancia").is(':checked')){   
         platilla_id=2
    }
    if($("#input_check_certificaciones").is(':checked')){   
         platilla_id=3
    }

    contenido=window.frames['child_frame'].$editor_texto.code();
    data={
        'contenido':contenido
    };
    $.post(entorno+"alumno/"+platilla_id+"/"+tipo+"/guardarplanilla",data,function(data){  
            $("#sub-container-right-informe-bc3").html(data);
            procesarImpresionBC3(this);
            ocultarMensajeNotificador();
    }); 
        
}


function procesarFiltrosInformePromover(){
    mostrarMensajeNotificador("Cargando alumnos.");
    sede=$("#sede").val();
    grado=$("#grado_id").val();
    grupo=$("#grupo_id").val();
    asignatura=$("#ntp_inacholeebundle_contratotype_asignatura").val();
    query=$("#input_query").val();
    
    
    data={
      'sede':sede,
      'grado':grado,
      'grupo':grupo,
      'asignatura':asignatura,
      'query':query
    };
    $.post(entorno+"colegio/informepromover.json",data,function(data){  
            console.info(data.nro_alumnos_perdieron);
            $("#capa_ram_buscar_planilas").html(data);
            dibujarPie(data.nro_alumnos_recuperan,data.nro_alumnos_ganaron,data.nro_alumnos_perdieron);
            $("#nro_pierden").html(data.nro_alumnos_perdieron);
            $("#nro_recuperan").html(data.nro_alumnos_recuperan);
            $("#nro_ganan").html(data.nro_alumnos_ganaron);
            $("#nro_nosesabe").html(parseInt(data.nro_total_alumnos)-(parseInt(data.nro_alumnos_ganaron)+parseInt(data.nro_alumnos_recuperan)+parseInt(data.nro_alumnos_perdieron)));
            
            ocultarMensajeNotificador();
    }); 
    
}
function showDetallesCeldaInformeConsolidado(minimo,grado_id,asg_id){
    mostrarMensajeNotificador("Cargando alumnos.");
    $.post(entorno+"colegio/"+minimo+"/"+grado_id+"/"+asg_id+"/"+"showalumnosdesempenos",function(data){  
            $id=$('#capa_grado'+grado_id);
            $id.html(data);
            $id.parent().parent().show();
            $id.show();
            ocultarMensajeNotificador();
    }); 
    
}
function actualizarTablaCE(){
    $(".item_detalles").each(function(){
        $(this).hide('slow');
    });
}
function dibujarPie(data1,data2,data3){
    jQuery(function($) {
				$('.easy-pie-chart.percentage').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
					var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
					var size = parseInt($(this).data('size')) || 50;
					$(this).easyPieChart({
						barColor: barColor,
						trackColor: trackColor,
						scaleColor: false,
						lineCap: 'butt',
						lineWidth: parseInt(size/10),
						animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
						size: size
					});
				})
			
				$('.sparkline').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
					$(this).sparkline('html', {tagValuesAttribute:'data-values', type: 'bar', barColor: barColor , chartRangeMin:$(this).data('min') || 0} );
				});
			
			
			
			
			  var placeholder = $('#piechart-placeholder-').css({'width':'90%' , 'min-height':'150px'});
			  var data = [
				{ label: "Recuperan",  data: data1, color: "#E59729"},
				{ label: "Aprueban",  data: data2, color: "#68BC31"},
                                { label: "Reprueban",  data: data3, color: "#DA5430"},
                           ]
                          
			  function drawPieChart(placeholder, data, position) {
			 	  $.plot(placeholder, data, {
					series: {
						pie: {
							show: true,
							tilt:0.8,
							highlight: {
								opacity: 0.25
							},
							stroke: {
								color: '#fff',
								width: 2
							},
							startAngle: 2
						}
					},
					legend: {
						show: true,
						position: position || "ne", 
						labelBoxBorderColor: null,
						margin:[-30,15]
					}
					,
					grid: {
						hoverable: true,
						clickable: true
					}
				 })
			 }
			 drawPieChart(placeholder, data);
			
			 /**
			 we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
			 so that's not needed actually.
			 */
			 placeholder.data('chart', data);
			 placeholder.data('draw', drawPieChart);
			
			
			
			  var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
			  var previousPoint = null;
			
			  placeholder.on('plothover', function (event, pos, item) {
				if(item) {
					if (previousPoint != item.seriesIndex) {
						previousPoint = item.seriesIndex;
						var tip = item.series['label'] + " : " +  Math.floor(item.series['percent'])+'%';
						$tooltip.show().children(0).text(tip);
					}
					$tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
				} else {
					$tooltip.hide();
					previousPoint = null;
				}
				
			 });
			placeholder.on('plotclick', function (event, pos, item) {
				console.info(item.series['label']);
                                filtroAlumnosInformePromover(item.series['label']);
                                
			 });
			
			})
}
function dibujarPieData(data,id){
    jQuery(function($) {
				$('.easy-pie-chart.percentage').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
					var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
					var size = parseInt($(this).data('size')) || 50;
					$(this).easyPieChart({
						barColor: barColor,
						trackColor: trackColor,
						scaleColor: false,
						lineCap: 'butt',
						lineWidth: parseInt(size/10),
						animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
						size: size
					});
				})
			
				$('.sparkline').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
					$(this).sparkline('html', {tagValuesAttribute:'data-values', type: 'bar', barColor: barColor , chartRangeMin:$(this).data('min') || 0} );
				});
			
			
			
			
			  var placeholder = $('#piechart-placeholder-'+id).css({'width':'90%' , 'min-height':'150px'});
			  
			  function drawPieChart(placeholder, data, position) {
			 	  $.plot(placeholder, data, {
					series: {
						pie: {
							show: true,
							tilt:0.8,
							highlight: {
								opacity: 0.25
							},
							stroke: {
								color: '#fff',
								width: 2
							},
							startAngle: 2
						}
					},
					legend: {
						show: true,
						position: position || "ne", 
						labelBoxBorderColor: null,
						margin:[-30,15]
					}
					,
					grid: {
						hoverable: true,
						clickable: true
					}
				 })
			 }
			 drawPieChart(placeholder, data);
			
			 /**
			 we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
			 so that's not needed actually.
			 */
			 placeholder.data('chart', data);
			 placeholder.data('draw', drawPieChart);
			
			
			
			  var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
			  var previousPoint = null;
			
			  placeholder.on('plothover', function (event, pos, item) {
				if(item) {
					if (previousPoint != item.seriesIndex) {
						previousPoint = item.seriesIndex;
						var tip = item.series['label'] + " : " +  Math.floor(item.series['percent'])+'%';
						$tooltip.show().children(0).text(tip);
					}
					$tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
				} else {
					$tooltip.hide();
					previousPoint = null;
				}
				
			 });
			placeholder.on('plotclick', function (event, pos, item) {
				console.info(item.series['label']);
                                filtroAlumnosInformePromover(item.series['label']);
                                
			 });
			
			})
}

function mostrarAlumnosGestorMatricula(){
    mostrarMensajeNotificador("Cargando alumnos.");
    sede_id=$("#sede").val();
    grado_id=$("#grado").val();
    grupo_id=$("#grupo").val();
    data={
        sede_id: sede_id,
        grado_id: grado_id,
        grupo_id: grupo_id
    };
    
    $.post(entorno+"colegio/"+"mostraralumnosgestormatricula",data,function(data){  
            $id=$('#container-newgestormatricula');
            $id.html(data);
            
            ocultarMensajeNotificador();
    }); 
    
}
function procesarCambioAnoEscolar(id){
    grupo_id=$("#pgrupo"+id).val();
    console.info(grupo_id);
    $(".grupo_"+id).each(function(e){
            $(this).val(grupo_id);
            $(this).addClass('activa');
            
     });
}
function mostrarListaGrado(container_id,container2,id_grado){
    grado_id=$("#"+id_grado).val();
    if(container2=='container-listagrupo-fuente'){
           tipo=1;
           ano=$("#h_fuente").val();
           
    }
    if(container2=='container-listagrupo-destino'){
           tipo=2;
           ano=$("#h_destino").val();
    }
    $.post(entorno+"cargaacademica/"+tipo+"/"+grado_id+"/"+ano+"/vergradolista",function(data){  
       $id=$('#'+container_id);
       $id.html(data);
       $('.tarea').each(function(){
                 $(this).rotate({angle : 270});        
       });
       data={
           'grado': grado_id
       };
       
       
       $.post(entorno+"grupo/"+tipo+"/buscar",data,function(data){  
          $("#"+container2).html(data); 
       });
       ocultarMensajeNotificador();
    });
}
function mostrarListaGrupo(container_id,container2,grupo_id){
    if(container2=='container-listagrupo-fuente'){
           grado_id=$("#select-grado-origen").val();
           tipo=1;
           ano=$("#h_fuente").val();
    }
    if(container2=='container-listagrupo-destino'){
           tipo=2;
           grado_id=$("#select-grado-destino").val();
           ano=$("#h_destino").val();
    }
    data={
        'grado_id':grado_id
    };
    $.post(entorno+"cargaacademica/"+tipo+"/"+grupo_id+"/"+ano+"/vergrupolista",data,function(data){  
       $id=$('#'+container_id);
       $id.html(data);
       $('.tarea').each(function(){
                 $(this).rotate({angle : 270});        
       });
       ocultarMensajeNotificador();
    });
}
function procesarCambioAno(container_id,btn_id){
    $container=$("#"+container_id);
    $btn=$("#"+btn_id);
    if(container_id=='container-form-ano-fuente'){
        token='fuente';
    }
    else{
        token='destino';
    }
    if($btn.html()==='cambiar'){
        $.post(entorno+"dimension/"+token+"/anoescolares",function(data){
           $container.html(data);
           $btn.html("actualizar");
        });    
    }
    if($btn.html()==='actualizar'){
        ano_seleccionado=$("#select_"+token).val();
        $.post(entorno+"dimension/"+ano_seleccionado+"/"+token+"/actualizaranogc",function(data){
           $container.html(data);
           $btn.html("cambiar");
        });    
    }

}
function procesarAnoEscolares(id){
    $id=$("#"+id)
    if("select_fuente"==id){
        $("#h_fuente").val($id.val());
    }
    if("select_destino"==id){
        $("#h_destino").val($id.val());
    }
}
function procesarBusquedadGC(id){
    query=$("#busca_"+id).val();
    data={
        'query': query
    };
    if("fuente"==id){
        ano=$("#h_fuente").val();
        tipo=1;
    }
    if("destino"==id){
        ano=$("#h_destino").val();
        tipo=2;
    }
    $.post(entorno+"alumno/"+tipo+"/"+ano+"/veralumnoslista",data,function(data){
           if("fuente"==id){
               $("#container-grupo-fuente").html(data);
           }
           if("destino"==id){
                $("#container-grupo-destino").html(data);
           } 
           $('.tarea').each(function(){
                 $(this).rotate({angle : 270});        
           });
       
    });
}

function procesarActualizacioniNachoLee(){
    $.post(entorno+"colegio/actualizarversion",function(data){
           
   });
}