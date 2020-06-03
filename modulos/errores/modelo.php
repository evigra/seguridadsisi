<?php		
	class errores extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_mensaje="";
		
		var $sys_fields	=array(
			"id"	    =>array(
			    "title"             => "id",
			    "showTitle"         => "si",
			    "type"              => "primary key",
			    "default"           => "",
			    "value"             => "",			    
			),
			"user"	    =>array(
			    "title"             => "Usuario",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################

        
      

		public function __CONSTRUCT()
		{
			parent::__CONSTRUCT();
		}  
						

					
	}
?>
