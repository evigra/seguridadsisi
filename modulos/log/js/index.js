	function puntos(GeoMarker1)
	{
		var punto	=new String();
		var puntos	=new String();
		for(index in GeoMarker1)
		{
			puntos	=GeoMarker1[index];
			punto	+=puntos["k"]+","+puntos["B"]+"|"; 
		}		
		$("#PUNTOS").val(punto);	
	}
		function limpiar()
		{

			for(indexMarker=0;indexMarker<locationsMarker.length;indexMarker++)
			{
				locationsMarker[indexMarker].setMap(null);
			}				
			locationsMarker.length = 0;		
			locationsMarker=Array();

		}
		function polilinea(LocationsLine)
		{
			flightPath = new google.maps.Polyline({
				path: LocationsLine,
				geodesic: true,
				strokeColor: '#FF0000',
				strokeOpacity: 1.0,
				strokeWeight: 2
			});		
			flightPath.setMap(map);
		}

	$(document).ready(function()
	{
		var accion="";
		var GeoMarker1=Array();

		$("#action").button({
			icons: {	primary: "ui-icon-document" },
			text: true
		    })
		    .click(function(){
				var variables=getVarsUrl();
				var str_url="";
				for(ivariables in variables)
				{
					if(ivariables=="sys_action")	str_url+="&"+ivariables+"=__SAVE";
					else							str_url+="&"+ivariables+"="+ variables[ivariables];
				}		        
				$("form")
					.attr({"action":str_url})
					.submit();
		        
		    }
	    );		


		$("#map").click(function()
		{
			limpiar();
			coordinate	={latitude: latitud, longitude:longitud};
			marker		=locationsMap(coordinate, "aaaa");						
			locationsMarker.push(marker);						
					});
		$("#accion_punto")
			.button({
				icons: {	primary: "ui-icon-note" },
				text: true
			})		
			.click(function(){
				point		=LatLng(coordinate);		
				GeoMarker1.push(point);				
				polilinea(GeoMarker1);
				puntos(GeoMarker1);

			}
		);	
		$("#finalizar_punto")
			.button({
				icons: {	primary: "ui-icon-note" },
				text: true
			})		
			.click(function(){
				
				point=GeoMarker1[0];
				GeoMarker1.push(point);	
				polilinea(GeoMarker1);
				puntos(GeoMarker1);			
				limpiar();

			}
		);

		$("#cancel").button({
			icons: {	primary: "ui-icon-closethick" },
			text: true
		});
		$("#create").button({
			icons: {	primary: "ui-icon-document" },
			text: false
		    })
		    .click(function(){
		        window.location="&sys_section=create&sys_action=";		    
		    }
	    );		

		$("#write").button({
			icons: {	primary: "ui-icon-pencil" },
			text: false
		    })
		    .click(function(){
		        window.location="&sys_section=write&sys_action=";		    
		    }
	    );		

		link_report("&sys_section=report&sys_action=");
	    link_kanban("&sys_section=kanban&sys_action=");
    });
