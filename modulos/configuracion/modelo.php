<?php
	class configuracion extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $sys_enviroments	="DEVELOPER";
		var $sys_fields		=array(
			"id"			=>array(
			    "title"             => "id",
			    "type"              => "primary key",
			),		
			"company_id"	    	=>array(
			    "title"             => "Empresa",
			    "type"              => "input",
			),
			"variable"	    		=>array(
			    "title"             => "Variable",
			    "type"              => "input",
			),
			"subvariable"	    	=>array(
			    "title"             => "SubVariable",
			    "type"              => "input",
			),
			"tipo"	    	=>array(
			    "title"             => "Tipo",
			    "type"              => "input",
			),
			"subtipo"	    	=>array(
			    "title"             => "SubTipo",
			    "type"              => "input",
			),
			"objeto"	    	=>array(
			    "title"             => "Objeto",
			    "type"              => "autocomplete",	    
			    "procedure"       	=> "autocomplete_modulos",
			    #"relation"          => "one2many",
			    "relation"          => "many2one",
			    "class_name"       	=> "modulo",
			    "class_field_l"    	=> "name",				# Label
			    "class_field_o"    	=> "objeto",
			    "class_field_m"    	=> "clase",			    
			    
			),
			"valor"	    =>array(
			    "title"             => "valor",
			    "type"              => "input",
			),
			"descripcion"	    =>array(
			    "title"             => "descripcion",
			    "type"              => "input",
			),

		);				
		##############################################################################	
		##  Metodos	
		##############################################################################		
		public function __CONSTRUCT($option=NULL)
		{
			parent::__CONSTRUCT($option);
		}
		public function __SAVE($datas=NULL,$option=NULL)
    	{
    	    if($_SESSION["company"]["id"]>0)
       	    	$datas["company_id"]=$_SESSION["company"]["id"];
    		return parent::__SAVE($datas,$option);
		}		
		public function __BROWSE($option=NULL)
    	{    		
    		if(is_null($option))	$option=array();			
			if(!isset($option["where"]))    $option["where"]    =array();
			
			$option["where"][]      ="company_id={$_SESSION["company"]["id"]}";
			$return 				=parent::__BROWSE($option);
			return	$return;     	
		}				
	}
?>
