<?php
		$this->sys_fields_l18n	=array(
			"id"	    		=>"",
			"name"	    		=>"Name",
			"email"	    		=>"Mail",
			"password"			=>"Password",
			"hashedPassword"	=>"Password",
			"files_id"	    	=>"Image",
			"img_files_id"	    =>"Image",
			"sesion_start"	    =>"Object Start",
			"company_id"	    =>"Company",
			"salt"	    		=>"",
		);

		$this->sys_view_l18n	=array(
			"action"    		=>"Save",
			"cancel"	    	=>"Cancel",
			"create"	   		=>"Create",
			"kanban"			=>"Kanban",
			"report"			=>"Report",
			"module_title"    	=>"Users Administration",
		);
		$this->sys_view_l18n["html_head_title"]="SOLES GPS :: {$_SESSION["company"]["razonSocial"]} :: {$this->sys_view_l18n["module_title"]}";
				
?>
