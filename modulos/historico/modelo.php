<?php
	class historico extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_menu=array();
		var $sys_fields		=array( 
			"id"	    =>array(
			    "title"             => "id",
			    "showTitle"         => "si",
			    "type"              => "primary key",
			    "default"           => "",
			    "value"             => "",			    
			),
			"tabla"	    =>array(
			    "title"             => "Nombre",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),
			"objeto"	    =>array(
			    "title"             => "Matricula",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"matricula"	    =>array(
			    "title"             => "Matricula",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),
			"trabajador"	    =>array(
			    "title"             => "Trabajador",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    			    
			),
			"fecha"	    =>array(
			    "title"             => "Fecha",
				"title_filter"		=> "Fecha",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),										
			"descripcion"	    =>array(
			    "title"             => "Descripcion",
				"title_filter"		=> "Descripcion",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),										
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################
        /*
		public function __CONSTRUCT()
		{
			parent::__CONSTRUCT();			
		}
		*/
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		## GUARDAR USUARIO
    		#$datas["total"]		=count(explode(",",$datas["dias"]));
    		
    		
			#$option["echo"]=$datas["total"];
    		
    	    $user_id=parent::__SAVE($datas,$option);
		}				

   		public function __REPORTE($option="")
    	{
			
			if($option=="")	$option=array();			
			$option["actions"]="false";
			
			
			$option["template_title"]	                = $this->sys_module . "html/report_title";
			$option["template_body"]	                = $this->sys_module . "html/report_body";
			
			$option["order"]="id desc";			
			return $this->__VIEW_REPORT($option);
		}						

	}
?>
