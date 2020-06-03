<?php
	if(!isset($_SESSION))
	{
		$usuarios_sesion						="PHPSESSID";
		session_name($usuarios_sesion);
		@session_start();
		@session_cache_limiter('nocache,private');					
	}
	
	if(!isset($_SESSION))		$_SESSION=array();
	
	if(isset($_SESSION))
	{
		if(!isset($_SESSION["var"]))			        $_SESSION["var"]					=array();
		if(!isset($_SESSION["var"]["menu"]))	        $_SESSION["var"]["menu"]			="";
		if(isset($_REQUEST["sys_menu"]))		        $_SESSION["var"]["menu"]			=$_REQUEST["sys_menu"];
		if(isset($_REQUEST["sys_vpath"]))		        $_SESSION["var"]["vpath"]			=@$_REQUEST["sys_vpath"];		
		if($_SESSION["var"]["menu"]=="")		        $_SESSION["var"]["menu"]			=2;

	    if(!isset($_SESSION["company"]))		        @$_SESSION["company"]					    =array();
		if(!isset($_SESSION["company"]["nombre"]))		@$_SESSION["company"]["nombre"]		        =" ";
		if(!isset($_SESSION["company"]["nombre"]))		@$_SESSION["company"]["abreviatura_web"]	=" ";								

	    if(!isset($_SESSION["user"]))		            @$_SESSION["user"]					    =array();
		if(!isset($_SESSION["user"]["name"]))		    @$_SESSION["user"]["name"]		        ="Iniciar Sesion";
		if(!isset($_SESSION["user"]["id"]))		        @$_SESSION["user"]["id"]		        =0;



						
		$_SESSION["var"]["false"]			=array(0,"0","false", "no");
		$_SESSION["var"]["true"]			=array(1,"1","true", "yes","si");
		$_SESSION["var"]["server_true"]		=array("www.solesgps.com","solesgps.com","sntss.solesgps.com");
		$_SESSION["var"]["server_error"]	=array("localhost","developer.solesgps.com");		
		$_SESSION["var"]["print"]			=array("print_report","print_excel","print_pdf");		
		$_SESSION["var"]["datetime"]		=date("Y-m-d H:i:s" , strtotime ("-7 hour", strtotime(date("Y-m-d H:i:s"))));
		$_SESSION["var"]["date"]			=date("Y-m-d" , strtotime ("-7 hour", strtotime(date("Y-m-d H:i:s"))));		
		$_SESSION["var"]["modulo"]			=substr(@$_SESSION["var"]["vpath"],0, strpos(@$_SESSION["var"]["vpath"], "/"));
		$_SESSION["var"]["modulo_path"] 	="modulos/". $_SESSION["var"]["modulo"] ."/index.php";
		$_SESSION["var"]["folders"] 		=substr_count(@$_SESSION["var"]["vpath"], "/");
		$_SESSION["var"]["import"]			=array(
												"type"		=>"replace",
												"fields"	=>",",
												"enclosed"	=>"\"",
												"lines"		=>"\\n",
												"ignore"	=>"1",
												"path"	    =>"/var/lib/mysql/files/frame/file/",
		);
		$_SESSION["var"]["img"]			    =array(
		                                        "grande"=>"450",
		                                        "mediana"=>"290",
		                                        "chica"=>"140",
		                                        "superchica"=>"10",
		);

		$_SESSION["var"]["modules"]			=array(
												"historico","menu","user_group","tareas", 
												"group","modulos","permiso","sesion","cron",
												"cron_history","position","positions","crons_history"
		);
		$_SESSION["var"]["server"]			=array_merge($_SESSION["var"]["server_true"], $_SESSION["var"]["server_error"]);

		#print_r($_GET);	

		if(@$_GET["sys_action"]=="cerrar_sesion")
		{
			$_SESSION["var"]["action"]="cerrar_sesion";
			
			setcookie('SolesGPS', '', time() - (60 * 60 * 24 * 365));
			session_destroy();
			$destino= "../sesion/";				
			Header ("Location: $destino");			
		}	
	}
	$pre_path="";
	
	
	
	for($a=0; $a<10; $a++)
	{
	    
		$path_instalacion="modulos/instalacion/";

		if(@file_exists($path_instalacion . "index.php"))
		{
			require_once($pre_path	."nucleo/basededatos.php");
			require_once($pre_path	."nucleo/auxiliar.php");
			require_once($pre_path	."nucleo/general.php");		

			require_once($pre_path	.$path_instalacion . "modelo.php");	
			break;
			exit;
		}
		
		else if(@file_exists($pre_path	."nucleo/general.php"))
		{		    
			require_once($pre_path	."nucleo/basededatos.php");
			require_once($pre_path	."nucleo/auxiliar.php");
			require_once($pre_path	."nucleo/general.php");		
			
			$objeto					=new general();         
			
			#$objeto->__PRINT_R($_SESSION);
			
			$comando_sql			="SELECT * FROM modulos WHERE status=1";
			$modulos 				=$objeto->__EXECUTE($comando_sql);    
			
			foreach($modulos as $modulo)
			{
				if(file_exists($pre_path	."modulos/{$modulo["clase"]}/modelo.php")) 				
					require_once($pre_path	."modulos/{$modulo["clase"]}/modelo.php");	
			}
			
			if(@$_REQUEST["setting_company"]>0)
			{
				$comando_sql="
					SELECT 
						FN_ImgFile('../modulos/user/img/user.png',files_id,0,0) as img_files_id,
						FN_ImgFile('../modulos/user/img/user.png',files_id,50,0) as img_files_id_med, c.*		
					FROM company c WHERE id={$_REQUEST["setting_company"]}
				";		
				$modulos 		=$objeto->__EXECUTE($comando_sql);    
				$objeto=null;					
				foreach($modulos as $modulo)
					$_SESSION["company"]					=$modulo;
			}			
			break;
		}				
		$pre_path.="../";
		
	}	
	if(isset($_SESSION) AND !isset($_SESSION["var"]["action"]) AND isset($_SESSION["user"]) AND isset($_SESSION["user"]["id"]) AND isset($_SESSION["company"]))
	{
		$md5_id		=@$_SESSION["user"]["md5_id"]; 
		setcookie('SolesGPS', $md5_id, time() + (1.5 * 24 * 60 * 60));		
	}
?>
