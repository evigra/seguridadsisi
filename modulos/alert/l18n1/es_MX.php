<?php
		$this->sys_fields_l18n	=array(
			"id"	    		=>"",
			"name"	    		=>"Nombre",
			"email"	    		=>"Mail",
			"password"			=>"Password",
			"hashedPassword"	=>"Password",
			"files_id"	    	=>"Imagen",
			"img_files_id"	    =>"Imagen",
			"sesion_start"	    =>"Menu inicio",
			"company_id"	    =>"Compañia",
			"salt"	    		=>"",
		);				
		$this->sys_view_l18n	=array(
			"module_title"    	=>"",
			
			"actions_delete"    =>"Borrar",
			"actions_write"    	=>"Modificar",
			"actions_show"    	=>"Mostrar",
			
			"action"    		=>"Guardar",
			"cancel"	    	=>"Cancela",
			"create"	   		=>"Crear",
			"kanban"			=>"Kanban",
			"report"			=>"Reporte",			
		);
		$this->sys_view_l18n["html_head_title"]="SOLES GPS";
		if(@$_SESSION["company"] and @$_SESSION["company"]["razonSocial"])
			$this->sys_view_l18n["html_head_title"].=" :: {$_SESSION["company"]["razonSocial"]} :: {$this->sys_view_l18n["module_title"]}";
						
?>
