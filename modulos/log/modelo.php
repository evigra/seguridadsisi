<?php
	#if(file_exists("../device/modelo.php")) require_once("../device/modelo.php");	
	class log extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_menu=array();
		var $log=array();
		var $sys_fields		=array( 
			"id"	    =>array(
			    "title"             => "id",
			    "showTitle"         => "si",
			    "type"              => "primary key",
			    "default"           => "",
			    "value"             => "",			    
			),
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################        
		public function __CONSTRUCT()
		{
			$contenido = 'NO esta funcionando';
			parent::__CONSTRUCT();

			#$gestor = fopen("modulos/log/html/tracker-server.log", "rb");
			$gestor = fopen("modulos/log/html/tracker-server.log", "r");
			$gestor = fopen("html/tracker-server.log","r");
			/*
			if (FALSE === $gestor)
			{
				exit("Falló la apertura del flujo al URL");
			}

			
			while (!feof($gestor)) {
				$contenido .= fread($gestor, 1024);
			}
			fclose($gestor);
			
			*/
			$this->log="				
				<textarea style=\"height:100%\">
					$contenido
				</textarea>
			";
			
		}			
	}
?>
