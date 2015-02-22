
var crono = $("span#crono");
var cronoId = null;
var cronoActivo = false;
var centesimas, segundos, minutos = 40,hora=0;
var nParcial;
var valorCrono;
var arrayParciales = new Array();
	


function pararCrono(){
	if(cronoActivo)
	{
		clearTimeout(cronoId);
		cronoActivo = false;
	}
	else
	{
		cronoActivo = false;
	}
};
function inicializarCrono(mi_hora,mi_minutos){

	if(cronoActivo == false)
	{
		centesimas = 0;
		segundos = 5;
		minutos = mi_minutos;
                hora=mi_hora;
		//Reseteamos a 0 los marcadores.
		$('#crono').val(minutos+':'+segundos+':'+centesimas);
		localStorage.clear();
	}

	
	

};
function mostrarCrono(mi_hora,mi_minutos,url) { 
	centesimas++;
	if(centesimas > 99)
	{
		centesimas = 0;
		segundos--;
		if(segundos > 9)
		{
			segundos = segundos;
		}
		else
		{
			segundos = '0' + segundos;
		}
		if(segundos <=0)
		{
			segundos = 59;
			
                        if(minutos>0)
                          minutos--;
                        else
                           minutos=0;
                            
                        if(minutos > 9)
                        {
                            minutos = minutos;
                        }
                        else
                        {
                            minutos = '0' + minutos;
                        }       
			if(minutos <= 0){
                            if(hora>0)
                                hora--;
                            else
                                hora=0;
                            if(hora==0 && minutos==0){
                                $('#crono').val( hora+':'+minutos+':'+segundos+':'+centesimas);
       
                                pararCrono();
                                document.location.href=url;
                                console.info(url);
                                return;
                            }
                            minutos=59;
                            
			}
                        
		}
	}
        //Y Lo sacamos por pantalla.
	valorCrono = minutos+':'+segundos+':'+centesimas;

	$('#crono').val( hora+':'+minutos+':'+segundos+':'+centesimas);
        
	cronoId = setTimeout("javascript:void(0);mostrarCrono("+mi_hora+","+mi_minutos+",'"+url+"')",10);
	cronoActivo = true;

	
	
};

function arrancarCrono(mi_hora,mi_minutos,url){
	pararCrono();
	inicializarCrono(mi_hora,mi_minutos);
	mostrarCrono(mi_hora,mi_minutos,url);
};

function parcialesCrono(){
	//Obtenemos el parcial del crono.
	var parcial;

	nParcial = nParcial || 1;
	parcial = $('#crono').val();
	//Declaramos una variable por defecto.
	localStorage.parcialCrono = localStorage.parcialCrono || '';
	arrayParciales.push(valorCrono+'<br/>');
	localStorage.parcialCrono += valorCrono+'<br/>';
        console.info(valorCrono);
	$('<tr><td>'+nParcial+'</td><td>'+parcial+'</td></tr>').appendTo('table.parciales > tbody');
	nParcial++;
	
};



function eventosTactiles(){
	var i = $('div.marcador');
	var xIni, yIni;

	i.on('touchstart', function(e){
		xIni = e.targetTouches[0].pageX;
		yIni = e.targetTouches[0].pageY;
	});

	i.on('touchmove', function(e){
		if (e.targetTouches[0].pageX > xIni+10){pararCrono();};
		if (e.targetTouches[0].pageX < xIni-10){pararCrono();inicializarCrono();};
	});
	i.on('tap', function(e){
		if(cronoActivo == false)
		{
			mostrarCrono();
			parcialesCrono();
		}
		else
		{
			pararCrono();
		}
	});
	
};

