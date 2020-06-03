<?php
	class crons_history extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $sys_fields		=array(
			"id"	    =>array(
			    "title"             => "id",
			    "type"              => "primary key",
			),
			"resume"	    =>array(
			    "title"             => "Resumen",
			    "title_filter"      => "Resumen",
			    "type"              => "input",
			),
			"date"	    =>array(
			    "title"             => "Fecha",
			    "type"              => "date",
			),
			"codigo"	    =>array(
			    "title"             => "Codigo",
			    "type"              => "input",
			),
			"objeto"	    =>array(
			    "title"             => "Objeto",
			    "type"              => "input",
			),
			"execute"	    =>array(
			    "title"             => "Execute",
			    "type"              => "input",
			),

		);				
		##############################################################################	
		##  Metodos	
		##############################################################################

        
		public function __CONSTRUCT()
		{
			parent::__CONSTRUCT();
		}
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		parent::__SAVE($datas,$option);
		}		
		
		public function crons($option=NULL)		
    	{	
    		if(is_null($option))	$option=array();
    		
    		$time_now			=substr(@$this->sys_date,0,16);
			$option["select"]	=array(				
				"crons_history.*",
			);
			$option["from"]		="crons_history";
			$option["order"]	="id desc";
			$data = $this->__VIEW_REPORT($option);
			
			return $data;					
		}
	}
?>
