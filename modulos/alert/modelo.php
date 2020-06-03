<?php
	class alert extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $sys_fields		=array(
			"id"	    =>array(
			    "title"             => "id",
			    "type"              => "primary key",
			),
			"company_id"	    =>array(
			    "title"             => "Compania",
			    "type"              => "input",
			),			
			"fechaEvento"	    =>array(
			    "title"             => "Evento",
			    "type"              => "input",
			),
			"asunto"	    =>array(
			    "title"             => "Asunto",
			    "title_filter"      => "Asunto",
			    "type"              => "input",
			),

			"descripcion"	    =>array(
			    "title"             => "Descripcion",
			    "type"              => "html",
			),
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################

        
		public function __CONSTRUCT()
		{
			#$this->menu_obj=new menu();
			parent::__CONSTRUCT();

		}
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		$datas["company_id"]    =$_SESSION["company"]["id"];
    	    return parent::__SAVE($datas,$option);
		}						
		public function __VIEW_REPORT($option=NULL)
    	{    		
    		if(is_null($option)) 			$option					=array();
    		
    		#$option["template_title"]="";    
    		$option["actions"]		=array(
    			"show"		=>"1",
    			"write"		=>"false",
    			"delete"	=>"false",
    			"check"		=>"false",
    		);
    		return parent::__VIEW_REPORT($option);
		}
		public function __BROWSE($option=NULL)
    	{
    		if(is_null($option)) 			$option					=array();
    		
    		if(!isset($option["where"])) 	$option["where"]		=array();
    		    		
    		$option["where"][]		="company_id='{$_SESSION["company"]["id"]}'";
    		$option["order"]		="fechaevento DESC";    		
    		return parent::__BROWSE($option);
		}
	}
?>
