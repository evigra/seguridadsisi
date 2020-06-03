<?php
	require_once("nucleo/sesion.php");	


	##############################################################################	
	##  Propiedades	
	##############################################################################
	if($_SERVER["QUERY_STRING"]=="sys_vpath=" OR $_SESSION["var"]["vpath"]=="")		
	{	
		############################################
		## RUTA RAIZ ###############################
		############################################				
		$path_instalacion="modulos/instalacion/";
		if(@file_exists($path_instalacion . "index.php"))						$sys_location	="Location:instalacion/";
		else
		
		unset($_COOKIE['SolesGPS']);
		
		if(isset($_COOKIE['SolesGPS']) AND !isset($_SESSION["var"]["action"]))
			$sys_location	="Location:sesion/&cookie=1";
		elseif(in_array($_SERVER["SERVER_NAME"],@$_SESSION["var"]["server_true"]))	
			$sys_location	="Location:webHome/";							
		else																	
			$sys_location	="Location:sesion/";
		
		header($sys_location);
		exit;
	}
	$folders=substr_count($_SESSION["var"]["vpath"], "/");
	
	if(file_exists($_SESSION["var"]["vpath"]))									require_once($_SESSION["var"]["vpath"]);
	else if(file_exists($_SESSION["var"]["modulo_path"]) AND $folders==1)		require_once($_SESSION["var"]["modulo_path"]);
	else 
	{
		$_SESSION["var"]["vpath"]			="";
		
		if($folders>0)
			for($a=0;$a<$folders;$a++)
				$_SESSION["var"]["vpath"]	.="../";
		$_SESSION["var"]["vpath"]			.="errores/";		

		header('Location:'.$_SESSION["var"]["vpath"]);		
	}
	
?>
