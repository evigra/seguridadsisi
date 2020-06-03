<?php
	class modulo extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_menu=array();
		var $sys_table		="modulos";
		var $sys_fields		=array( 
			"id"	    =>array(
			    "title"             => "id",
			    "type"              => "primary key",
			),
			"name"	    =>array(
			    "title"             => "Nombre",
			    "type"              => "input",
			),
			"clase"	    =>array(
			    "title"             => "Clase",
			    "type"              => "input",
			),
			"descripcion"	    =>array(
			    "title"             => "Descripcion",
			    "type"              => "input",
			),
			"menu"	    =>array(
			    "title"             => "URL",
			    "type"              => "input",
			),			
		);						
		##############################################################################	
		##  Metodos	
		##############################################################################
		public function autocomplete_modulos()		
    	{	
    		$option					=array();
    		$option["where"]		=array();    		
    		
    		$option["where"][]		="name LIKE '%{$_GET["term"]}%'";
    		
			$return =$this->__BROWSE($option);    				
			return $return;			
		}				

	}
?>
