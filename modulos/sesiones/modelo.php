<?php
	class sesiones extends sesion
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_mensaje="";
		var $sys_table	="sesion";
		var $sys_fields	=array(
			"id"	    =>array(
			    "title"             => "id",
			    "type"              => "primary key",
			),
			"user"	    =>array(
			    "title"             => "Usuario",
			    "type"              => "input",
			),
			"pass"	    =>array(
			    "title"             => "Password",
			    "type"              => "password",
			),			
			"user_id"	    =>array(
			    "title"             => "Nombre",
			    "type"              => "input",
			),
			"server_addr"	    =>array(
			    "title"             => "Servidor",
			    "type"              => "input",
			),
			"date"	    =>array(
			    "title"             => "Fecha",
			    "type"              => "password",
			),
			"remote_addr"	    =>array(
			    "title"             => "Servidor",
			    "type"              => "input",
			),
			"http_user_agent"	    =>array(
			    "title"             => "Agente",
			    "type"              => "input",
			),
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################

		public function __VIEW_REPORT($option=NULL)		
    	{	
    		if(is_null($option))	$option=array();
    		
			$option["select"]	=array(				
				"s.*",
				"u.*",
				"c.*",
			);
			$option["from"]		="
				sesion s join
				users u on s.user_id=u.id join
				company c on c.id=u.company_id
			";
			$option["order"]		="date desc";
			
			#$option["where"]=" and u.company_id={$_SESSION["company"]["id"]} or u.id={$_SESSION["user"]["id"]}";
			if(!isset($option["where"]))
				$option["where"]=" and u.company_id={$_SESSION["company"]["id"]}";
			$return =parent::__VIEW_REPORT($option);    				
			return $return;
		}				

	}
?>
