<?php
	class template extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $sys_enviroments	="DEVELOPER";
		#var $sys_table			="company";
		var $sys_fields		=array(
			"id"			=>array(
			    "title"             => "id",
			    "type"              => "primary key",
			),		
			"nombre"	    	=>array(
			    "title"             => "Nombre de plantilla",
			    "type"              => "input",
			),
			"descripcion"	    	=>array(
			    "title"             => "Descripcion",
			    "type"              => "input",
			),
			"fecha_inicio"	    	=>array(
			    "title"             => "Fecha inicio",
			    "type"              => "date",
			),
			"fecha_fin"	    	=>array(
			    "title"             => "Fecha fin",
			    "type"              => "date",
			),
			"modulo"	    	=>array(
			    "title"             => "Modulo",
			    "type"              => "input",
			),
			"html"	    	=>array(
			    "title"             => "Codigo HTML",
			    "type"              => "textarea",
			    "htmlentities"      => "false",
			),
			"estatus"	    	=>array(
			    "title"             => "Activo",
			    "type"              => "checkbox",
			),			

		);				
		##############################################################################	
		##  Metodos	
		##############################################################################		
				
		
	}
?>
