<?php

#sudo wget -O - https://nightly.odoo.com/odoo.key | apt-key add - echo "deb http://nightly.odoo.com/11.0/nightly/deb/ ./" >> /etc/apt/sources.list.d/odoo.list
#sudo apt-get update && apt-get install odoo

	#if(file_exists("../device/modelo.php")) require_once("../device/modelo.php");	
	class execute extends general
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
		/*
		public function __CONSTRUCT()
		{
			parent::__CONSTRUCT();
			#$ultima_linea = passthru('/opt/traccar/bin/traccar status', $var);
			#$ultima_linea = passthru('ls', $var);		
			
			#echo $var;	
		}
		*/			
		public function saldo_correo()
    	{
			$comando_sql		="
				SELECT d.id,left(d.telefono,10) as referencia,  now() as actualizado, 'TEL030' as producto, 
				d.recargado as 'ultima_recarga',
				if(d.recargado is null  OR DATE_ADD(d.recargado, INTERVAL 14 DAY)< now(), 'AUTORIZADA','NEGADA' ) AS solicitud
				FROM devices d join company c on c.id=d.company_id  
				WHERE 1=1 
					AND md5(d.id)='{$this->request["a"]}'
			";
			
			$datas	=$this->__EXECUTE($comando_sql);
						
			foreach($datas as $row)
			{
				
			
				if($row["solicitud"]=="AUTORIZADA")
				{				
					$respuesta=$this->WS_TAECEL($row);					
					if($respuesta["mensaje2"]=="Recarga Exitosa" AND $respuesta["status"]=="Exitosa")
					{
					
						$this->__PRINT_R($row);
						
						$comando_sql		="
							UPDATE devices SET recargado='{$row["actualizado"]}'

							WHERE 1=1 
								AND id='{$row["id"]}'
						";
						$datas	=$this->__EXECUTE($comando_sql);
						
						$comando_sql		="
							INSERT INTO taecel SET 
								producto	='{$respuesta["producto"]}',
								referencia	='{$respuesta["referencia"]}',
								mensaje1	='{$respuesta["mensaje1"]}',
								transID		='{$respuesta["transID"]}',
								folio		='{$respuesta["folio"]}',
								mensaje2	='{$respuesta["mensaje2"]}'							
						";
						$this->__EXECUTE($comando_sql);		
					}
				}
			}
		}		
	}
?>
