	function img_activa(objeto)
	{
		var path="../sitio_web/img/car/vehiculo_"+$(objeto).val()+"/i135.png";
		$("#image_device").attr("src",path);	    	
	
	}


	$(document).ready(function()
	{
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

		$("#create").button({
			icons: {	primary: "ui-icon-document" },
			text: false
		    })
		    .click(function(){
		        window.location="&sys_section=create&sys_action=";		    
		    }
	    );		
	    if($("#write").length>0)
	    {
			$("#write").button({
				icons: {	primary: "ui-icon-pencil" },
				text: false
				})
				.click(function(){
				    window.location="&sys_section=write&sys_action=";		    
				}
			);
	    }
	    if($("#filtrar").length>0)
	    {
			$("#filtrar").button({
				icons: {	primary: "ui-icon-pencil" },
				text: true
				})
				.click(function()
				{
					$("form").submit();		        
				}
			);	    		
		}	
		action_cancel();
	    link_kanban("&sys_section=kanban&sys_action=");
	    link_report("&sys_section=report&sys_action=");
    
    
    
	    if($("select#image").length>0)
	    {
	    	$("select#image").change(function()
	    	{
	    		img_activa(this);	    	
	    	});	    
	    }    
	    img_activa($("select#image"));

    });
