<?php
	class tareas extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $sys_fields		=array(
			"id"	    =>array(
			    "title"             => "id",
			    "type"              => "primary key",
			),
			"name"	    =>array(
			    "title"             => "Nombre",
			    "type"              => "input",
			),
			"ejecucion"	    =>array(
			    "title"             => "Ejecutado",
			    "type"              => "input",
			),
			"now_time"	    =>array(
			    "title"             => "Siguiente Ejecucion",
			    "type"              => "input",
			),
			"codigo"	    =>array(
			    "title"             => "Codigo",
			    "type"              => "textarea",
			),
			"CANTIDAD"	    =>array(
			    "title"             => "Tiempo",
			    "type"              => "input",
			),
			"TYPE_TIME"	    =>array(
			    "title"             => "Unidad de Tiempo",
			    "type"              => "select",
			    "source"           	=> array(
			    	"MINUTE"        => "Minutos",
			    	"DAY"           => "Dias",
			    	"MONTH"         => "Mes",
			    ),			    
			),

		);				
		##############################################################################	
		##  Metodos	
		##############################################################################

        
		public function __CONSTRUCT($option=NULL)
		{
			#echo "<br>CONSTRUCTOR TAREAS";
			parent::__CONSTRUCT($option);			
			
		}
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		parent::__SAVE($datas,$option);
		}		
		
		public function crons($option=NULL)		
    	{	
    		if(is_null($option))			$option				=array();
    		if(is_null(@$option["select"]))	$option["select"]	=array();
    		    		
    		#$time_now=substr(@$this->sys_date,0,16);
    		
			$option["select"][]	="t.*";

			$option["from"]		="tareas t";
			#$option["limit"]		="1";
			#$data = $this->__VIEW_REPORT($option);
			$data = $this->__BROWSE($option);
			
			return $data;
		}
		public function showCrons()
    	{	
			$navegador="Terminal";
			if(isset($_SERVER["HTTP_USER_AGENT"]))	$navegador	=$_SERVER["HTTP_USER_AGENT"];
    	
    		$this->__PRINT_R($navegador);
    	
    		if($navegador!="Wget/1.12 (linux-gnu)")
    		{
    			$comando_sql="UPDATE tareas SET now_time=now() WHERE id=100";
	    		$this->__EXECUTE($comando_sql);
    		}
    		else
    		{
    			#### EXECUCION MANUAL###################################

				#$objeto				=new plantilla_venta();
				#$objeto->__CRON();
    		    		
    		}

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

			if(count($crons_data["data"])==0)
			{
				$option["select"]	=array("DATE_ADD(now(), INTERVAL 2 MINUTE)"=>"next_time1");
				$option["where"]	=array("LEFT(now_time,16)< LEFT(now(),16) ");
				#$option["echo"]		="SQL2";
				
				$crons_data =$this->crons($option);    										
			}
			#$this->__PRINT_R($crons_data);
			foreach($crons_data["data"] as $row)
			{
				echo "<br>## TAREA {$row["name"]} ##################################";
				$this->sys_private["field"]	="id";
				$this->sys_private["id"]		=$row["id"];				
				$data=array(
					"now_time"		=>	$row["next_time1"],
					"ejecucion"		=>	$row["now_time"],
				);
				#$option_tareas=array("echo"=>"TAREAS :: SAVE");
				$this->__SAVE($data);
										
				$eval="
					$"."objeto		=new {$row["class"]}();
					$"."return_code	={$row["codigo"]}	
				";
				$cronshistory_data				=array();
				$cronshistory_data["execute"]	=$navegador;
				$cronshistory_data["objeto"]	=@$row["class"];								
				
				$cronshistory_data["codigo"]	=@$row["codigo"];								
				
				$cronshistory_data["date"]		=@$this->sys_date;

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
					$cronshistory_data["resume"]	=@$return_code;
					
					$this->cronshistory_obj	=new crons_history();
					$this->cronshistory_obj->__SAVE($cronshistory_data);
					#echo "<br><br>".$this->sys_date . " :: " . $cronshistory_data["resume"];				
				}
				#*/
			}

			#/*			
			$para      = 'evigra@hotmail.com;evigra@gmail.com';
			$titulo    = 'SOLESGPS EJECUTA CRONS';
			$mensaje   = "CRONS TAREAS";
			$cabeceras = 'From: webmaster@example.com' . "\r\n" .
				'Reply-To: webmaster@example.com' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();

			#echo "<br>mail($para, $titulo, $mensaje, $cabeceras)";
			#mail($para, $titulo, $mensaje, $cabeceras);			
			
			#*/

		}	
								
	}
?>
