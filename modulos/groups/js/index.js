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

		$("#kanban")
		    .button({
			    icons: {	primary: "ui-icon-newwin" },
			    text: false
		    })
		    .click(function(){
		        window.location="&sys_section=kanban&sys_action=";
		    
		    }
	    );		
		$("#report")
		    .button({
			    icons: {	primary: "ui-icon-note" },
			    text: false
		    })
		    .click(function(){
		        window.location="&sys_section=report&sys_action=";
		    
		    }
	    );
    });
