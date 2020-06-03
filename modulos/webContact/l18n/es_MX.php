<?php
		$this->sys_fields_l18n	=array(
			"find_us"	    	=>"ENCUENTRANOS!",
			"location"	    	=>"UBICACION",
			"phones"	    	=>"TELEFONOS",
			"mails"				=>"CORREOS",
			"write_us_now"		=>"Escribenos ya!",	
			"name"				=>"Nombre",			
			"email"				=>"Correo",		
			"subject"			=>"Asunto",	
			"message"			=>"Mensaje",	
			"send"				=>"ENVIAR",
			"foot_1"			=>"Geolocalizacion y Rastreo Satelital",
			"foot_2"			=>"Vehicular y Celular",
			"confirm_send"		=>"Gracias por escribirnos, a la brevedad nos pondremos en contacto con usted para ofrecerle atención personalizada...",
			);				

		$this->sys_view_l18n	=array(
			"action"    		=>"Guardar",
			"cancel"	    	=>"Cancela",
			"create"	   		=>"Crear",
			"kanban"			=>"Kanban",
			"report"			=>"Reporte",
			"module_title"    	=>"Administracion de Usuarios",
		);
		$this->sys_view_l18n["html_head_title"]="SOLES GPS";
		if(@$_SESSION["company"] and @$_SESSION["company"]["razonSocial"])
			$this->sys_view_l18n["html_head_title"].=" :: {$_SESSION["company"]["razonSocial"]} :: {$this->sys_view_l18n["module_title"]}";
?>
