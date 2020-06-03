<?php

	class crons extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $sys_fields		=array(
			"id"	    =>array(
			    "title"             => "id",
			    "showTitle"         => "si",
			    "type"              => "primary key",
			    "default"           => "",
			    "value"             => "",			    
			),
			"company_id"	    =>array(
			    "title"             => "Ejecucion",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"tipo_cron"	    =>array(
			    "title"             => "Cron",
			    "showTitle"         => "si",
			    "type"              => "select",
			    "default"           => "",
			    "value"             => "",
			    "source"             =>array(
			    	""			=>"Selecciona la frecuencia",
			    	"distancia"	=>"Distancia",
			    	"tiempo"	=>"Tiempo",
			    ),			    			    
			),

			"auto_item_ids"	    =>array(
			    "title"             => "Nombre",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"item_ids"	    =>array(
			    "title"             => "Nombre",
			    "showTitle"         => "si",
			    "type"              => "autocomplete",
			    "source"           	=> "../modulos/item/ajax/index.php",
			    "value"             => "",			    
			    
			    "relation"          => "one2many",			    
			    "class_name"       	=> "item",
			    "class_field_l"    	=> "nombre",						# Label
			    "class_field_o"    	=> "item_ids",
			    "class_field_m"    	=> "id",
			    
			),
			"descripcion"	    =>array(
			    "title"             => "Descripcion",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"tipo_frecuencia"	    =>array(
			    "title"             => "Tipo",
			    "showTitle"         => "si",
			    "type"              => "select",
			    "default"           => "",
			    "value"             => "",			    
			    "source"            =>array(
			    	""				=>"Selecciona una frecuencia",
			    	"distancia"	=>"Distancia",
			    	"tiempo"	=>"Tiempo",
			    ),			    			    
			    
			),
			"frecuencia"	    =>array(
			    "title"             => "Frecuencia",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"unidades"	    =>array(
			    "title"             => "Unidades",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),			
			"ejecucion"	    =>array(
			    "title"             => "Ejecutado",
			    "showTitle"         => "si",
			    "type"              => "textarea",
			    "default"           => "",
			    "value"             => "",			    
			),			
			"siguiente"	    =>array(
			    "title"             => "Siguiente",
			    "showTitle"         => "si",
			    "type"              => "textarea",
			    "default"           => "",
			    "value"             => "",			    
			),			
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################

        
		public function __CONSTRUCT()
		{
			#echo "<br>CONSTRUCTOR TAREAS";
			parent::__CONSTRUCT();			
			
		}
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		$datas["company_id"]    	=$_SESSION["company"]["id"];
    		
    		parent::__SAVE($datas,$option);
    		
		}		
		
		public function __BROWSE($option=NULL)		
    	{	
    		#if(is_null($option))			$option				=array();
    		#if(is_null(@$option["select"]))	$option["select"]	=array();
    		    		
    		#$time_now=substr(@$this->sys_date,0,16);
    		
			#$option["select"][]	="cc.*";

			#$option["from"]		="crons_contabilidad cc";
			#$option["limit"]		="1";
			
			$data = parent::__BROWSE($option);
			return $data;
		}
		public function showCrons()
    	{	
    		$crons_data =array();    		
    		$option		=array();
    		
    		$time_now	=substr(@$this->sys_date,0,16);			
    		#$option["echo"]	="SQL";
			$option["select"]	=array(
				"
					CASE
						WHEN TYPE_TIME='SECOND' 	THEN DATE_ADD(now_time, INTERVAL CANTIDAD SECOND)
						WHEN TYPE_TIME='MINUTE' 	THEN DATE_ADD(now_time, INTERVAL CANTIDAD MINUTE)
						WHEN TYPE_TIME='HOUR' 		THEN DATE_ADD(now_time, INTERVAL CANTIDAD HOUR)
						WHEN TYPE_TIME='DAY' 		THEN DATE_ADD(now_time, INTERVAL CANTIDAD DAY)
					END				
				"=>"next_time1"
			);
		
			if(!isset($option["where"]))	$option["where"]=array("LEFT(now_time,16)= LEFT(now(),16)");
		
			$crons_data =$this->crons($option);
			#$this->__PRINT_R($crons_data["data"]);
			if(count($crons_data["data"])==0)
			{
				$option["select"]	=array("DATE_ADD(now(), INTERVAL 2 MINUTE)"=>"next_time1");
				$option["where"]	=array("LEFT(now_time,16)< LEFT(now(),16) ");
				#$option["echo"]		="SQL2";
				
				$crons_data =$this->crons($option);    										
			}
			#$this->__PRINT_R($crons_data["data"]);
			foreach($crons_data["data"] as $row)
			{
				$this->sys_primary_field	="id";
				$this->sys_primary_id		=$row["id"];				
				$data=array(
					"now_time"	=>	$row["next_time1"],
					"ejecucion"	=>	$row["now_time"]
				);
				$option_tareas=array("echo"=>"TAREAS :: SAVE");
				$this->__SAVE($data,$option_tareas);
							
				$navegador="Terminal";
				if(isset($_SERVER["HTTP_USER_AGENT"]))		$navegador	=$_SERVER["HTTP_USER_AGENT"];
			
				$cronshistory_data				=array();
				$cronshistory_data["resume"]	="<br>Desde la tarea:<br>".$navegador;
				$cronshistory_data["date"]		=@$this->sys_date;				
								
				$eval="
					$"."objeto		=new {$row["class"]}();
					{$row["codigo"]}
				";
				#echo "<br><br><br>$eval";
			
				#if(@eval($row["codigo"])===false)
				#/*
				if(@eval($eval)===false)		
				{					
					$cronshistory_data["resume"]	="Error en la ejecucion:<br>$navegador";									
					#echo $cronshistory_data["resume"];
					
					$comando_sql="INSERT INTO logs SET text='{$row["codigo"]}'";
					$comando_sql="INSERT INTO logs SET text='{$row["name"]}'";
					$position_data 		=$this->__EXECUTE($comando_sql);										
				}
				else
				{
					$this->cronshistory_obj	=new crons_history();
					$this->cronshistory_obj->__SAVE($cronshistory_data);
					#echo "<br><br>".$this->sys_date . " :: " . $cronshistory_data["resume"];				
				}
				#*/
			}
		}	
								
	}
?>
